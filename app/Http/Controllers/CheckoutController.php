<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use XanderID\QrisDynamicify\QrisDynamicify;

class CheckoutController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $cartItems = auth()->user()
            ->cartItems()
            ->with('service.category')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Bucket Anda masih kosong.');
        }

        $total = $cartItems->sum(fn ($item) => $item->service->price * $item->quantity);
        $user = auth()->user();

        return view('checkout.index', compact('cartItems', 'total', 'user'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'string', 'max:20'],
        ]);

        $cartItems = auth()->user()
            ->cartItems()
            ->with('service')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Bucket Anda kosong.');
        }

        $total = $cartItems->sum(fn ($item) => $item->service->price * $item->quantity);

        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => 'FF-' . strtoupper(Str::random(8)),
            'total_amount' => $total,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'service_id' => $item->service_id,
                'quantity' => $item->quantity,
                'unit_price' => $item->service->price,
            ]);
        }

        Invoice::create([
            'order_id' => $order->id,
            'invoice_number' => 'INV-' . strtoupper(Str::random(10)),
            'issue_date' => now()->toDateString(),
            'due_date' => now()->addDays(3)->toDateString(),
            'status' => 'unpaid',
        ]);

        // Clear cart
        auth()->user()->cartItems()->delete();

        // Build WhatsApp message
        $itemLines = $cartItems->map(fn ($item) => "- {$item->service->title}: Rp " . number_format($item->service->price, 0, ',', '.'))->join("\n");
        $waMessage = "Halo FireFinance! 👋\n\nSaya ingin konfirmasi pesanan saya:\n\n*Order:* {$order->order_number}\n*Nama:* {$request->name}\n*Email:* {$request->email}\n\n*Layanan yang dipesan:*\n{$itemLines}\n\n*Total:* Rp " . number_format($total, 0, ',', '.') . "\n\nMohon konfirmasinya. Terima kasih!";

        $waUrl = 'https://wa.me/6281234567890?text=' . rawurlencode($waMessage);

        return redirect()->route('checkout.success', $order)->with([
            'wa_url' => $waUrl,
            'success' => "Pesanan #{$order->order_number} berhasil dibuat!",
        ]);
    }

    public function success(Order $order): View
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $waUrl = session('wa_url', 'https://wa.me/6281234567890');

        $order->load('items.service', 'invoice');

        $staticQris = config('services.qris.static');
        $dynamicQris = null;

        if ($staticQris) {
            try {
                $dynamicQris = (string) QrisDynamicify::fromString($staticQris)
                    ->setPrice((int) $order->total_amount);
            } catch (\Exception $e) {
                logger()->error('QRIS Generation failed: ' . $e->getMessage());
            }
        }

        return view('checkout.success', compact('order', 'waUrl', 'dynamicQris'));
    }
}
