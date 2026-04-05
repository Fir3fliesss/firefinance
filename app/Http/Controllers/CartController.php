<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $cartItems = auth()->user()
            ->cartItems()
            ->with('service.category')
            ->get();

        $total = $cartItems->sum(fn ($item) => $item->service->price * $item->quantity);

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'service_id' => ['required', 'exists:services,id'],
        ]);

        $existing = auth()->user()->cartItems()->where('service_id', $request->service_id)->first();

        if ($existing) {
            return back()->with('error', 'Layanan ini sudah ada di Bucket Anda.');
        }

        auth()->user()->cartItems()->create([
            'service_id' => $request->service_id,
            'quantity' => 1,
        ]);

        return back()->with('success', 'Layanan berhasil ditambahkan ke Bucket!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $item = auth()->user()->cartItems()->findOrFail($id);
        $item->delete();

        return back()->with('success', 'Layanan dihapus dari Bucket.');
    }

    public function clear(): RedirectResponse
    {
        auth()->user()->cartItems()->delete();

        return back()->with('success', 'Bucket berhasil dikosongkan.');
    }
}
