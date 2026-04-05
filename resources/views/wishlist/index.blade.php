@extends('layouts.app')

@section('title', 'Wishlist Saya')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8">
        <h1 class="section-title text-2xl text-white mb-1">Wishlist Saya</h1>
        <p class="text-slate-400 text-sm">Layanan yang Anda simpan untuk masa depan</p>
    </div>

    @if($wishlistItems->isEmpty())
        <div class="glass-card rounded-2xl border border-white/10 p-16 text-center">
            <div class="w-16 h-16 rounded-2xl bg-slate-800 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            </div>
            <p class="text-slate-300 font-semibold mb-2">Wishlist masih kosong</p>
            <p class="text-slate-500 text-sm mb-6">Simpan layanan favorit Anda untuk dipesan nanti</p>
            <a href="{{ route('catalog.index') }}" class="btn-primary">Jelajahi Layanan</a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($wishlistItems as $item)
            <div class="glass-card rounded-2xl border border-white/10 overflow-hidden flex flex-col group">
                <div class="h-36 bg-gradient-to-br from-slate-800 to-slate-900 flex items-center justify-center relative">
                    <div class="text-5xl opacity-20">{{ $item->service->category->icon ?? '💼' }}</div>
                    <div class="absolute top-3 right-3">
                        <span class="text-xs px-2 py-0.5 rounded-full bg-slate-700/80 text-slate-300 border border-white/10">{{ $item->service->category->name }}</span>
                    </div>
                </div>
                <div class="p-5 flex flex-col flex-1">
                    <a href="{{ route('services.show', $item->service->slug) }}" class="font-semibold text-sm text-white hover:text-emerald-400 transition-colors mb-1 leading-snug flex-1">{{ $item->service->title }}</a>
                    <p class="text-emerald-400 font-bold mt-2 mb-4">{{ $item->service->formatted_price }}</p>
                    <div class="flex gap-2">
                        <form method="POST" action="{{ route('cart.store') }}" class="flex-1">
                            @csrf
                            <input type="hidden" name="service_id" value="{{ $item->service->id }}">
                            <button type="submit" class="w-full px-3 py-2 bg-emerald-500/20 hover:bg-emerald-500/30 border border-emerald-500/30 text-emerald-300 rounded-lg text-xs font-medium transition-all">
                                + Bucket
                            </button>
                        </form>
                        <form method="POST" action="{{ route('wishlist.toggle', $item->service->id) }}">
                            @csrf
                            <button type="submit" class="px-3 py-2 text-red-400 hover:text-red-300 hover:bg-red-500/10 border border-red-500/20 rounded-lg text-xs transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
