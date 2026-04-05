<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function show(string $slug): View
    {
        $service = Service::where('slug', $slug)
            ->where('is_active', true)
            ->with(['category'])
            ->firstOrFail();

        $relatedServices = Service::where('category_id', $service->category_id)
            ->where('id', '!=', $service->id)
            ->where('is_active', true)
            ->limit(3)
            ->get();

        $isInWishlist = auth()->check()
            ? auth()->user()->wishlistItems()->where('service_id', $service->id)->exists()
            : false;

        $isInCart = auth()->check()
            ? auth()->user()->cartItems()->where('service_id', $service->id)->exists()
            : false;

        return view('services.show', compact('service', 'relatedServices', 'isInWishlist', 'isInCart'));
    }
}
