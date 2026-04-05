<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(Request $request): View
    {
        $query = Service::query()
            ->where('is_active', true)
            ->with('category');

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhereHas('category', fn ($cq) => $cq->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('sort')) {
            match ($request->sort) {
                'price_asc' => $query->orderBy('price'),
                'price_desc' => $query->orderByDesc('price'),
                'newest' => $query->latest(),
                default => $query->orderByDesc('is_featured')->latest(),
            };
        } else {
            $query->orderByDesc('is_featured')->latest();
        }

        $services = $query->paginate(12)->withQueryString();
        $categories = Category::withCount(['services' => fn ($q) => $q->where('is_active', true)])->get();
        $activeCategory = $request->category;

        return view('catalog.index', compact('services', 'categories', 'activeCategory'));
    }
}
