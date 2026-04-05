<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $totalOrders = $user->orders()->count();
        $activeOrders = $user->orders()->where('status', 'active')->count();
        $pendingOrders = $user->orders()->where('status', 'pending')->count();
        $totalSpent = $user->orders()
            ->whereIn('status', ['paid', 'active'])
            ->sum('total_amount');

        $recentOrders = $user->orders()
            ->with('invoice')
            ->latest()
            ->limit(5)
            ->get();

        return view('client.dashboard', compact(
            'totalOrders',
            'activeOrders',
            'pendingOrders',
            'totalSpent',
            'recentOrders'
        ));
    }
}
