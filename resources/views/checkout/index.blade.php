@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8">
        <h1 class="section-title text-2xl text-white mb-1">Konfirmasi Pesanan</h1>
        <p class="text-slate-400 text-sm">Periksa detail pesanan sebelum melanjutkan</p>
    </div>

    <form method="POST" action="{{ route('checkout.store') }}">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Data Diri --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="glass-card rounded-2xl border border-white/10 p-6">
                    <h2 class="font-bold text-white mb-5 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Informasi Klien
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-slate-300 mb-1.5">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ $user->name }}" required
                                class="w-full px-4 py-3 bg-white/5 border @error('name') border-red-500/50 @else border-white/10 @enderror rounded-xl text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 text-sm transition-all">
                            @error('name')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-1.5">Email</label>
                            <input type="email" name="email" value="{{ $user->email }}" required
                                class="w-full px-4 py-3 bg-white/5 border @error('email') border-red-500/50 @else border-white/10 @enderror rounded-xl text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 text-sm transition-all">
                            @error('email')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-1.5">No. WhatsApp</label>
                            <input type="tel" name="phone" value="{{ $user->phone }}" required placeholder="+62..."
                                class="w-full px-4 py-3 bg-white/5 border @error('phone') border-red-500/50 @else border-white/10 @enderror rounded-xl text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 text-sm transition-all">
                            @error('phone')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-slate-300 mb-1.5">Catatan <span class="text-slate-500">(opsional)</span></label>
                            <textarea name="notes" rows="3" placeholder="Informasi tambahan untuk konsultan..."
                                class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 text-sm transition-all resize-none"></textarea>
                        </div>
                    </div>
                </div>

                {{-- Items --}}
                <div class="glass-card rounded-2xl border border-white/10 p-6">
                    <h2 class="font-bold text-white mb-5 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        Layanan yang Dipesan
                    </h2>
                    <div class="space-y-3">
                        @foreach($cartItems as $item)
                        <div class="flex items-center gap-3 p-3 bg-white/5 rounded-xl border border-white/5">
                            <div class="w-10 h-10 rounded-lg bg-slate-800 flex items-center justify-center text-xl flex-shrink-0">{{ $item->service->category->icon ?? '💼' }}</div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-white truncate">{{ $item->service->title }}</p>
                                <p class="text-xs text-slate-500">{{ $item->service->category->name }}</p>
                            </div>
                            <p class="text-sm font-bold text-emerald-400 whitespace-nowrap">{{ $item->service->formatted_price }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Summary --}}
            <div class="lg:col-span-1">
                <div class="glass-card rounded-2xl border border-white/10 p-6 sticky top-24">
                    <h2 class="font-bold text-white mb-5">Ringkasan</h2>
                    <div class="space-y-2 mb-4 text-sm">
                        <div class="flex justify-between text-slate-400">
                            <span>Jumlah Layanan</span><span>{{ $cartItems->count() }} item</span>
                        </div>
                    </div>
                    <div class="border-t border-white/10 pt-4 mb-6">
                        <div class="flex items-center justify-between">
                            <span class="font-semibold text-slate-300">Total</span>
                            <span class="text-xl font-bold text-emerald-400">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="bg-green-500/5 border border-green-500/20 rounded-xl p-4 mb-5 text-xs text-slate-400">
                        <div class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-green-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                            <p>Setelah konfirmasi, Anda akan diarahkan ke <strong class="text-green-400">WhatsApp</strong> untuk berkoordinasi dengan konsultan kami.</p>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary w-full justify-center py-4">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Konfirmasi & Pesan
                    </button>

                    <a href="{{ route('cart.index') }}" class="flex items-center justify-center gap-2 mt-3 text-sm text-slate-400 hover:text-white transition-colors">← Kembali ke Bucket</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
