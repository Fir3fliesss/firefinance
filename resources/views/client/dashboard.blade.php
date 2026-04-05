@extends('layouts.app')

@section('title', 'Dashboard Saya')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8">
        <h1 class="section-title text-2xl text-white mb-1">Dashboard Saya</h1>
        <p class="text-slate-400">Selamat datang kembali, <span class="text-emerald-400">{{ auth()->user()->name }}</span>!</p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
        <div class="glass-card rounded-2xl border border-white/10 p-5">
            <p class="text-xs text-slate-500 mb-2">Total Pesanan</p>
            <p class="text-3xl font-bold text-white">{{ $totalOrders }}</p>
        </div>
        <div class="glass-card rounded-2xl border border-white/10 p-5">
            <p class="text-xs text-slate-500 mb-2">Layanan Aktif</p>
            <p class="text-3xl font-bold text-emerald-400">{{ $activeOrders }}</p>
        </div>
        <div class="glass-card rounded-2xl border border-white/10 p-5">
            <p class="text-xs text-slate-500 mb-2">Menunggu Konfirmasi</p>
            <p class="text-3xl font-bold text-amber-400">{{ $pendingOrders }}</p>
        </div>
        <div class="glass-card rounded-2xl border border-white/10 p-5">
            <p class="text-xs text-slate-500 mb-2">Total Pengeluaran</p>
            <p class="text-xl font-bold text-blue-400">Rp {{ number_format($totalSpent, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="flex flex-wrap gap-3 mb-10">
        <a href="{{ route('catalog.index') }}" class="btn-primary !text-sm !py-2.5">+ Pesan Layanan Baru</a>
        <a href="{{ route('client.orders.index') }}" class="btn-outline !text-sm !py-2.5">📋 Riwayat Pesanan</a>
        <a href="{{ route('wishlist.index') }}" class="btn-outline !text-sm !py-2.5">❤️ Wishlist Saya</a>
    </div>

    {{-- Recent Orders --}}
    <div class="glass-card rounded-2xl border border-white/10 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-white/10">
            <h2 class="font-bold text-white">Pesanan Terbaru</h2>
            <a href="{{ route('client.orders.index') }}" class="text-sm text-emerald-400 hover:text-emerald-300 transition-colors">Lihat Semua →</a>
        </div>

        @if($recentOrders->isEmpty())
            <div class="p-12 text-center">
                <p class="text-slate-500 text-sm">Belum ada pesanan.</p>
                <a href="{{ route('catalog.index') }}" class="inline-flex items-center gap-2 mt-4 text-emerald-400 hover:text-emerald-300 text-sm transition-colors">Mulai pesan sekarang →</a>
            </div>
        @else
            <div class="divide-y divide-white/5">
                @foreach($recentOrders as $order)
                <div class="flex items-center gap-4 px-6 py-4 hover:bg-white/2 transition-all">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-mono text-sm font-bold text-white">{{ $order->order_number }}</span>
                            <span class="status-{{ $order->status }}">{{ $order->status_label }}</span>
                        </div>
                        <p class="text-xs text-slate-500">{{ $order->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="font-bold text-emerald-400 text-sm">{{ $order->formatted_total }}</p>
                        @if($order->invoice)
                        <a href="{{ route('client.invoices.show', $order->invoice->id) }}" class="text-xs text-amber-400 hover:text-amber-300 transition-colors">Lihat Invoice →</a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
