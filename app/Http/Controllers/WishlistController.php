<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(): View
    {
        $wishlistItems = auth()->user()
            ->wishlistItems()
            ->with('service.category')
            ->latest()
            ->get();

        return view('wishlist.index', compact('wishlistItems'));
    }

    public function toggle(Service $service): RedirectResponse
    {
        $existing = auth()->user()->wishlistItems()->where('service_id', $service->id)->first();

        if ($existing) {
            $existing->delete();
            return back()->with('success', 'Layanan dihapus dari Wishlist.');
        }

        auth()->user()->wishlistItems()->create([
            'service_id' => $service->id,
        ]);

        return back()->with('success', 'Layanan disimpan ke Wishlist!');
    }
}
