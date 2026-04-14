@extends('layouts.app')

@section('title', $service->title)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-slate-500 mb-8">
        <a href="{{ route('home') }}" class="hover:text-emerald-400 transition-colors">Beranda</a>
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('catalog.index') }}" class="hover:text-emerald-400 transition-colors">Katalog</a>
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-300 truncate max-w-xs">{{ $service->title }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Main Info --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Image / Hero --}}
            <div class="glass-card rounded-2xl border border-white/10 overflow-hidden h-64 relative flex items-center justify-center">
                @if($service->image)
                    <img src="{{ Storage::url($service->image) }}" class="w-full h-full object-cover" alt="{{ $service->title }}">
                @elseif($service->category && $service->category->image)
                    <img src="{{ Storage::url($service->category->image) }}" class="w-32 h-32 object-contain opacity-20" alt="{{ $service->category->name }}">
                @else
                    <div class="text-8xl opacity-10">{{ $service->category->icon ?? '💼' }}</div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/10 to-transparent pointer-events-none"></div>
                <div class="absolute top-4 left-4 flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-slate-700/80 text-slate-300 border border-white/10">{{ $service->category->icon }} {{ $service->category->name }}</span>
                    @if($service->is_featured)
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-amber-500/20 text-amber-300 border border-amber-500/30">⭐ Unggulan</span>
                    @endif
                </div>
            </div>

            {{-- Details --}}
            <div class="glass-card rounded-2xl border border-white/10 p-8">
                <h1 class="text-2xl font-bold text-white mb-3">{{ $service->title }}</h1>
                @if($service->short_description)
                    <p class="text-slate-400 text-base leading-relaxed mb-6">{{ $service->short_description }}</p>
                @endif
                <div class="border-t border-white/10 pt-6">
                    <h2 class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-4">Deskripsi Lengkap</h2>
                    <div class="prose prose-invert prose-sm max-w-none text-slate-300 leading-relaxed whitespace-pre-line">{{ $service->description }}</div>
                </div>
            </div>
        </div>

        {{-- Sidebar: Buy Box --}}
        <div class="space-y-4">
            <div class="glass-card rounded-2xl border border-white/10 p-6 sticky top-24">
                <div class="mb-6">
                    <p class="text-sm text-slate-500 mb-1">Harga Layanan</p>
                    <p class="text-3xl font-bold text-emerald-400">{{ $service->formatted_price }}</p>
                    <p class="text-xs text-slate-500 mt-1">Per sesi/paket</p>
                </div>

                @auth
                    {{-- Add to Cart --}}
                    @if($isInCart)
                        <a href="{{ route('cart.index') }}" class="btn-primary w-full justify-center mb-3">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Sudah di Bucket — Lihat
                        </a>
                    @else
                        <form method="POST" action="{{ route('cart.store') }}">
                            @csrf
                            <input type="hidden" name="service_id" value="{{ $service->id }}">
                            <button type="submit" class="btn-primary w-full justify-center mb-3">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                Tambah ke Bucket
                            </button>
                        </form>
                    @endif

                    {{-- Wishlist --}}
                    <form method="POST" action="{{ route('wishlist.toggle', $service->id) }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 border transition-all duration-200 rounded-lg text-sm font-semibold
                            {{ $isInWishlist ? 'border-amber-500/40 bg-amber-500/10 text-amber-300 hover:bg-amber-500/20' : 'border-white/20 text-slate-300 hover:border-amber-500/40 hover:text-amber-300' }}">
                            <svg class="w-5 h-5 {{ $isInWishlist ? 'fill-amber-400 text-amber-400' : '' }}" fill="{{ $isInWishlist ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            {{ $isInWishlist ? 'Tersimpan di Wishlist' : 'Simpan ke Wishlist' }}
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-primary w-full justify-center mb-3">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        Masuk untuk Memesan
                    </a>
                    <p class="text-center text-xs text-slate-500">Login diperlukan untuk pesan layanan</p>
                @endauth

                {{-- Quick WA contact --}}
                <div class="mt-6 pt-6 border-t border-white/10">
                    <p class="text-xs text-slate-500 mb-3">Ada pertanyaan? Hubungi kami:</p>
                    <a href="https://wa.me/6281234567890?text=Halo, saya ingin bertanya tentang layanan {{ urlencode($service->title) }}"
                       target="_blank"
                       class="flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-lg bg-green-500/10 hover:bg-green-500/20 border border-green-500/30 text-green-400 text-sm font-medium transition-all">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                        Chat via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Related Services --}}
    @if($relatedServices->isNotEmpty())
    <div class="mt-16">
        <h2 class="text-xl font-bold text-white mb-6">Layanan Terkait</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @foreach($relatedServices as $related)
            <a href="{{ route('services.show', $related->slug) }}"
               class="group glass-card rounded-xl p-5 border border-white/10 hover:border-emerald-500/30 transition-all hover:-translate-y-0.5 flex flex-col">
                <div class="text-2xl mb-2">{{ $related->category->icon }}</div>
                <h3 class="font-semibold text-sm text-white group-hover:text-emerald-400 transition-colors mb-1 flex-1">{{ $related->title }}</h3>
                <p class="text-emerald-400 font-bold text-sm mt-2">{{ $related->formatted_price }}</p>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
