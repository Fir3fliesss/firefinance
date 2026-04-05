@extends('layouts.app')

@section('title', 'Bucket Saya')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="section-title text-2xl text-white mb-1">Bucket Saya</h1>
            <p class="text-slate-400 text-sm">{{ $cartItems->count() }} layanan siap dipesan</p>
        </div>
        @if($cartItems->isNotEmpty())
        <form method="POST" action="{{ route('cart.clear') }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm text-red-400 hover:text-red-300 hover:bg-red-500/10 border border-red-500/20 transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Kosongkan
            </button>
        </form>
        @endif
    </div>

    @if($cartItems->isEmpty())
        <div class="glass-card rounded-2xl border border-white/10 p-16 text-center">
            <div class="w-16 h-16 rounded-2xl bg-slate-800 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
            <p class="text-slate-300 font-semibold mb-2">Bucket Anda masih kosong</p>
            <p class="text-slate-500 text-sm mb-6">Temukan layanan keuangan terbaik untuk Anda</p>
            <a href="{{ route('catalog.index') }}" class="btn-primary">Jelajahi Layanan</a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Cart Items --}}
            <div class="lg:col-span-2 space-y-4">
                @foreach($cartItems as $item)
                <div class="glass-card rounded-xl border border-white/10 p-5 flex items-start gap-4">
                    <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-slate-800 to-slate-900 flex items-center justify-center text-2xl flex-shrink-0">
                        {{ $item->service->category->icon ?? '💼' }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('services.show', $item->service->slug) }}" class="font-semibold text-white hover:text-emerald-400 transition-colors text-sm">{{ $item->service->title }}</a>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $item->service->category->name }}</p>
                        <p class="text-emerald-400 font-bold mt-2">{{ $item->service->formatted_price }}</p>
                    </div>
                    <form method="POST" action="{{ route('cart.destroy', $item->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 rounded-lg text-slate-500 hover:text-red-400 hover:bg-red-500/10 transition-all">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </form>
                </div>
                @endforeach
            </div>

            {{-- Order Summary --}}
            <div class="lg:col-span-1">
                <div class="glass-card rounded-2xl border border-white/10 p-6 sticky top-24">
                    <h2 class="font-bold text-white mb-5">Ringkasan Pesanan</h2>

                    <div class="space-y-3 mb-5">
                        @foreach($cartItems as $item)
                        <div class="flex items-start justify-between gap-2 text-sm">
                            <span class="text-slate-400 leading-snug flex-1">{{ $item->service->title }}</span>
                            <span class="text-slate-300 whitespace-nowrap">{{ $item->service->formatted_price }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="border-t border-white/10 pt-4 mb-6">
                        <div class="flex items-center justify-between">
                            <span class="font-semibold text-slate-300">Total</span>
                            <span class="text-xl font-bold text-emerald-400">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="btn-primary w-full justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Lanjut ke Checkout
                    </a>
                    <a href="{{ route('catalog.index') }}" class="flex items-center justify-center gap-2 mt-3 text-sm text-slate-400 hover:text-white transition-colors">
                        ← Tambah Layanan Lain
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
