<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = Order::with('user', 'items')
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(20)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load('user', 'items.service.category', 'invoice');

        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:pending,paid,active,cancelled'],
            'admin_note' => ['required', 'string', 'max:1000'],
        ], [
            'admin_note.required' => 'Catatan admin wajib diisi saat mengubah status pesanan.',
        ]);

        $order->update([
            'status' => $request->status,
            'admin_note' => $request->admin_note,
            'admin_note_at' => now(),
        ]);

        if ($order->invoice && $request->status === 'paid') {
            $order->invoice->update(['status' => 'paid']);
        }

        return back()->with('success', "Status pesanan {$order->order_number} berhasil diperbarui!");
    }
}
