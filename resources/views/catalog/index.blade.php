@extends('layouts.app')

@section('title', 'Katalog Layanan')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- Header --}}
    <div class="mb-10">
        <h1 class="section-title text-3xl text-white mb-2">Katalog Layanan</h1>
        <p class="text-slate-400">Temukan layanan keuangan yang tepat untuk kebutuhan Anda</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">

        {{-- Sidebar Filters --}}
        <aside class="lg:w-64 flex-shrink-0 space-y-6">
            <form method="GET" action="{{ route('catalog.index') }}" id="filterForm">

                {{-- Search --}}
                <div class="glass-card rounded-xl p-4 border border-white/10">
                    <h3 class="text-sm font-semibold text-slate-300 mb-3">Cari Layanan</h3>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Nama layanan..."
                            class="w-full pl-9 pr-3 py-2.5 bg-white/5 border border-white/10 rounded-lg text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 text-sm transition-all">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </div>

                {{-- Categories --}}
                <div class="glass-card rounded-xl p-4 border border-white/10">
                    <h3 class="text-sm font-semibold text-slate-300 mb-3">Kategori</h3>
                    <div class="space-y-1">
                        <a href="{{ route('catalog.index', array_merge(request()->except('category'), [])) }}"
                           class="flex items-center justify-between px-3 py-2 rounded-lg text-sm transition-all
                                  {{ !$activeCategory ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                            <span>Semua Kategori</span>
                        </a>
                        @foreach($categories as $category)
                        <a href="{{ route('catalog.index', array_merge(request()->except('category'), ['category' => $category->slug])) }}"
                           class="flex items-center justify-between px-3 py-2 rounded-lg text-sm transition-all
                                  {{ $activeCategory === $category->slug ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                            <span class="flex items-center gap-1.5">
                                @if($category->image)
                                    <img src="{{ Storage::url($category->image) }}" class="w-4 h-4 object-cover rounded-sm" alt="{{ $category->name }}">
                                @else
                                    <span>{{ $category->icon }}</span>
                                @endif
                                <span>{{ $category->name }}</span>
                            </span>
                            <span class="text-xs text-slate-600">{{ $category->services_count }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>

                {{-- Sort --}}
                <div class="glass-card rounded-xl p-4 border border-white/10">
                    <h3 class="text-sm font-semibold text-slate-300 mb-3">Urutkan</h3>
                    <select name="sort" onchange="document.getElementById('filterForm').submit()"
                        class="w-full px-3 py-2.5 bg-white/5 border border-white/10 rounded-lg text-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/40">
                        <option value="" {{ !request('sort') ? 'selected' : '' }}>Relevansi</option>
                        <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Harga: Termurah</option>
                        <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Harga: Termahal</option>
                        <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Terbaru</option>
                    </select>
                </div>

                <button type="submit" class="btn-primary w-full justify-center">Terapkan Filter</button>

                @if(request()->hasAny(['search', 'category', 'sort']))
                    <a href="{{ route('catalog.index') }}" class="flex items-center justify-center gap-2 w-full py-2 text-sm text-slate-400 hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        Reset Filter
                    </a>
                @endif
            </form>
        </aside>

        {{-- Services Grid --}}
        <div class="flex-1">
            {{-- Result Count --}}
            <div class="flex items-center justify-between mb-6">
                <p class="text-sm text-slate-400">
                    Menampilkan <span class="text-white font-medium">{{ $services->total() }}</span> layanan
                    @if($activeCategory) dalam kategori <span class="text-emerald-400">{{ $categories->firstWhere('slug', $activeCategory)?->name }}</span> @endif
                </p>
            </div>

            @if($services->isEmpty())
                <div class="text-center py-20">
                    <div class="w-16 h-16 rounded-2xl bg-slate-800 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <p class="text-slate-400 font-medium">Layanan tidak ditemukan</p>
                    <p class="text-slate-600 text-sm mt-1">Coba kata kunci atau filter lain</p>
                    <a href="{{ route('catalog.index') }}" class="inline-flex items-center gap-2 mt-4 text-emerald-400 hover:text-emerald-300 text-sm transition-colors">Reset pencarian</a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                    @foreach($services as $service)
                    <a href="{{ route('services.show', $service->slug) }}"
                       class="group glass-card rounded-2xl overflow-hidden border border-white/10 hover:border-emerald-500/30 transition-all duration-300 hover:-translate-y-1 flex flex-col">
                        <div class="h-40 bg-gradient-to-br from-slate-800 to-slate-900 relative flex items-center justify-center overflow-hidden">
                            @if($service->image)
                                <img src="{{ Storage::url($service->image) }}" class="w-full h-full object-cover" alt="{{ $service->title }}">
                                <div class="absolute inset-0 bg-slate-900/10"></div>
                            @elseif($service->category && $service->category->image)
                                <img src="{{ Storage::url($service->category->image) }}" class="w-20 h-20 object-contain opacity-40" alt="{{ $service->category->name }}">
                            @else
                                <div class="text-5xl opacity-20">{{ $service->category->icon ?? '💼' }}</div>
                            @endif
                            @if($service->is_featured)
                            <div class="absolute top-3 left-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-500/20 text-amber-300 border border-amber-500/30">⭐ Unggulan</span>
                            </div>
                            @endif
                            <div class="absolute top-3 right-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-slate-700/80 text-slate-300 border border-white/10">{{ $service->category->name }}</span>
                            </div>
                        </div>
                        <div class="p-5 flex flex-col flex-1">
                            <h3 class="font-bold text-sm text-white group-hover:text-emerald-400 transition-colors mb-1.5 leading-snug">{{ $service->title }}</h3>
                            <p class="text-slate-500 text-xs leading-relaxed flex-1 line-clamp-2">{{ $service->short_description }}</p>
                            <div class="flex items-center justify-between mt-4 pt-3 border-t border-white/10">
                                <p class="text-emerald-400 font-bold">{{ $service->formatted_price }}</p>
                                <span class="flex items-center gap-1 text-xs text-slate-500 group-hover:text-slate-300 transition-colors">
                                    Detail
                                    <svg class="w-3 h-3 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                </span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if($services->hasPages())
                    <div class="mt-10 flex justify-center">
                        {{ $services->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection
