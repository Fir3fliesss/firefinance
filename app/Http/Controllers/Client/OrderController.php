<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = auth()->user()
            ->orders()
            ->with('invoice', 'items')
            ->latest()
            ->paginate(10);

        return view('client.orders.index', compact('orders'));
    }

    public function show(int $id): View
    {
        $order = auth()->user()
            ->orders()
            ->with('items.service.category', 'invoice')
            ->findOrFail($id);

        return view('client.orders.show', compact('order'));
    }
}
