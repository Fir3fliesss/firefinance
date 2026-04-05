@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8">
        <h1 class="section-title text-2xl text-white mb-1">Riwayat Pesanan</h1>
        <p class="text-slate-400">Semua transaksi layanan Anda</p>
    </div>

    @if($orders->isEmpty())
        <div class="glass-card rounded-2xl border border-white/10 p-16 text-center">
            <p class="text-slate-400 mb-4">Belum ada pesanan.</p>
            <a href="{{ route('catalog.index') }}" class="btn-primary">Pesan Layanan Sekarang</a>
        </div>
    @else
        <div class="glass-card rounded-2xl border border-white/10 overflow-hidden">
            <div class="divide-y divide-white/5">
                @foreach($orders as $order)
                <div class="px-6 py-5 hover:bg-white/2 transition-all">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <a href="{{ route('client.orders.show', $order->id) }}" class="font-mono font-bold text-white text-sm hover:text-emerald-400 transition-colors">{{ $order->order_number }}</a>
                                <span class="status-{{ $order->status }}">{{ $order->status_label }}</span>
                            </div>
                            <p class="text-xs text-slate-500">{{ $order->created_at->format('d M Y, H:i') }} • {{ $order->items->count() }} layanan</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="font-bold text-emerald-400">{{ $order->formatted_total }}</span>
                            @if($order->invoice)
                            <a href="{{ route('client.invoices.show', $order->invoice->id) }}"
                               class="px-3 py-1.5 rounded-lg bg-amber-500/10 border border-amber-500/30 text-amber-300 text-xs font-medium hover:bg-amber-500/20 transition-all">
                                Invoice
                            </a>
                            @endif
                        </div>
                    </div>

                    @if($order->admin_note)
                    <div class="mt-3 px-4 py-3 rounded-xl bg-amber-500/5 border border-amber-500/15">
                        <div class="flex items-center gap-1.5 mb-1">
                            <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                            </svg>
                            <span class="text-xs font-semibold text-amber-300">Catatan Admin</span>
                            @if($order->admin_note_at)
                            <span class="text-xs text-slate-500 ml-auto">{{ $order->admin_note_at->format('d M Y, H:i') }}</span>
                            @endif
                        </div>
                        <p class="text-sm text-slate-300 leading-relaxed">{{ $order->admin_note }}</p>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @if($orders->hasPages())
            <div class="mt-6">{{ $orders->links() }}</div>
        @endif
    @endif
</div>
@endsection
