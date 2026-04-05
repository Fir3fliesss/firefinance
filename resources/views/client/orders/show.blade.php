@extends('layouts.app')

@section('title', 'Detail Pesanan ' . $order->order_number)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8">
        <a href="{{ route('client.orders.index') }}" class="text-sm text-slate-400 hover:text-white transition-colors">← Kembali ke Riwayat Pesanan</a>
        <h1 class="section-title text-2xl text-white mt-3 mb-1">Detail Pesanan</h1>
        <p class="text-slate-400 font-mono">{{ $order->order_number }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Items --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="glass-card rounded-2xl border border-white/10 overflow-hidden">
                <div class="px-6 py-4 border-b border-white/10">
                    <h2 class="font-bold text-white">Item Layanan</h2>
                </div>
                <table class="w-full text-sm">
                    <thead class="bg-slate-900/50">
                        <tr>
                            <th class="text-left px-6 py-3 text-xs uppercase tracking-wider text-slate-500 font-medium">Layanan</th>
                            <th class="text-right px-6 py-3 text-xs uppercase tracking-wider text-slate-500 font-medium">Harga</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($order->items as $item)
                        <tr>
                            <td class="px-6 py-4">
                                <p class="font-medium text-slate-200">{{ $item->service->title }}</p>
                                <p class="text-xs text-slate-500">{{ $item->service->category->name }}</p>
                            </td>
                            <td class="px-6 py-4 text-right font-bold text-emerald-400">{{ 'Rp ' . number_format($item->unit_price, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="border-t border-white/10 bg-slate-900/30">
                            <td class="px-6 py-4 font-bold text-slate-300">TOTAL</td>
                            <td class="px-6 py-4 text-right text-lg font-bold text-emerald-400">{{ $order->formatted_total }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            @if($order->notes)
            <div class="glass-card rounded-2xl border border-white/10 p-6">
                <h2 class="font-bold text-white mb-3">Catatan Anda</h2>
                <p class="text-slate-400 text-sm">{{ $order->notes }}</p>
            </div>
            @endif

            {{-- Admin Note --}}
            @if($order->admin_note)
            <div class="glass-card rounded-2xl border border-amber-500/20 bg-amber-500/5 p-6">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                    <h2 class="font-bold text-amber-300">Catatan dari Admin</h2>
                </div>
                <p class="text-slate-300 text-sm leading-relaxed">{{ $order->admin_note }}</p>
                @if($order->admin_note_at)
                <p class="text-xs text-slate-500 mt-3">Diperbarui: {{ $order->admin_note_at->format('d M Y, H:i') }}</p>
                @endif
            </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="space-y-5">
            <div class="glass-card rounded-2xl border border-white/10 p-5">
                <h2 class="font-bold text-white mb-4">Informasi Pesanan</h2>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Order#</span>
                        <span class="font-mono font-bold text-white text-xs">{{ $order->order_number }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Tanggal</span>
                        <span class="text-slate-300">{{ $order->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500">Status</span>
                        <span class="status-{{ $order->status }}">{{ $order->status_label }}</span>
                    </div>
                    @if($order->invoice)
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500">Invoice</span>
                        <a href="{{ route('client.invoices.show', $order->invoice->id) }}" class="font-mono text-amber-400 text-xs hover:underline">
                            {{ $order->invoice->invoice_number }}
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
