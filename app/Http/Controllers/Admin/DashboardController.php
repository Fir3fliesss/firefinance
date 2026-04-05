<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalRevenue = Order::whereIn('status', ['paid', 'active'])->sum('total_amount');
        $totalClients = User::where('role', 'client')->count();

        $recentOrders = Order::with('user', 'items')
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'totalRevenue',
            'totalClients',
            'recentOrders'
        ));
    }
}
