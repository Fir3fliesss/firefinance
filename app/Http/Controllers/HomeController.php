<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredServices = Service::where('is_featured', true)
            ->where('is_active', true)
            ->with('category')
            ->latest()
            ->limit(6)
            ->get();

        $featuredCategories = Category::where('is_featured', true)->get();
        $categories = Category::withCount(['services' => fn ($q) => $q->where('is_active', true)])->get();

        return view('welcome', compact('featuredServices', 'featuredCategories', 'categories'));
    }
}
