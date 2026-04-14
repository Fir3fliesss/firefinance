@extends('layouts.app')

@section('title', 'Invoice ' . $invoice->invoice_number)

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    {{-- Actions Bar --}}
    <div class="flex items-center justify-between mb-8">
        <a href="{{ route('client.orders.index') }}" class="flex items-center gap-2 text-slate-400 hover:text-white text-sm transition-colors">
            ← Kembali ke Pesanan
        </a>
        <div class="flex items-center gap-3">
            <a href="{{ route('client.invoices.print', $invoice->id) }}" target="_blank"
               class="flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-700/50 border border-white/10 text-slate-300 text-sm font-medium hover:bg-slate-700 transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Print / Simpan PDF
            </a>
        </div>
    </div>

    {{-- Invoice Card --}}
    <div class="glass-card rounded-2xl border border-white/10 p-8">
        {{-- Header --}}
        <div class="flex items-start justify-between mb-8 pb-6 border-b border-white/10">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <img src="{{ asset('images/logo-firefinance.webp') }}" class="w-6 h-6 object-contain" alt="FireFinance Logo">
                    <span class="font-bold text-lg text-white">FireFinance</span>
                </div>
                <p class="text-xs text-slate-500 mt-1">Platform Jasa Keuangan Premium</p>
                <p class="text-xs text-slate-500">+62 812 3456 7890</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-slate-500 uppercase tracking-widest mb-1">INVOICE</p>
                <p class="font-mono font-bold text-amber-400 text-lg">{{ $invoice->invoice_number }}</p>
                <div class="mt-2">
                    <span class="{{ $invoice->status === 'paid' ? 'status-paid' : ($invoice->status === 'unpaid' ? 'status-pending' : 'status-cancelled') }}">
                        {{ $invoice->status_label }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Client & Dates --}}
        <div class="grid grid-cols-2 gap-6 mb-8">
            <div>
                <p class="text-xs text-slate-500 uppercase tracking-wider mb-2">Ditagihkan Kepada</p>
                <p class="font-semibold text-white">{{ $invoice->order->user->name }}</p>
                <p class="text-sm text-slate-400">{{ $invoice->order->user->email }}</p>
                @if($invoice->order->user->phone)
                <p class="text-sm text-slate-400">{{ $invoice->order->user->phone }}</p>
                @endif
            </div>
            <div class="text-right">
                <div class="mb-2">
                    <p class="text-xs text-slate-500 uppercase tracking-wider">Tanggal Invoice</p>
                    <p class="text-sm text-slate-300">{{ $invoice->issue_date->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 uppercase tracking-wider">Order</p>
                    <p class="font-mono text-sm font-medium text-white">{{ $invoice->order->order_number }}</p>
                </div>
            </div>
        </div>

        {{-- Items --}}
        <div class="mb-8">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-white/10">
                        <th class="text-left py-3 text-xs uppercase tracking-wider text-slate-500 font-medium">Layanan</th>
                        <th class="text-right py-3 text-xs uppercase tracking-wider text-slate-500 font-medium w-32">Harga</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($invoice->order->items as $item)
                    <tr>
                        <td class="py-4">
                            <p class="font-medium text-white">{{ $item->service->title }}</p>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $item->service->category->name }}</p>
                        </td>
                        <td class="py-4 text-right font-medium text-slate-300">{{ 'Rp ' . number_format($item->unit_price, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-t border-white/10">
                        <td class="pt-4 font-bold text-slate-300">Total</td>
                        <td class="pt-4 text-right text-xl font-bold text-emerald-400">{{ $invoice->order->formatted_total }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- QRIS Section --}}
        @if(isset($dynamicQris) && $dynamicQris)
        <div class="mb-8 p-6 bg-white/5 rounded-2xl border border-white/10 flex flex-col md:flex-row items-center gap-6">
            <div class="bg-white p-3 rounded-xl">
                {!! QrCode::size(150)->generate($dynamicQris) !!}
            </div>
            <div class="flex-1 text-center md:text-left">
                <div class="flex items-center justify-center md:justify-start gap-2 mb-2">
                    <img src="{{ asset('qris.jpeg') }}" alt="QRIS" class="h-4 object-contain grayscale invert">
                    <p class="text-sm font-bold text-white uppercase tracking-wider">Bayar Instan</p>
                </div>
                <p class="text-xs text-slate-400 mb-4">Scan kode QR di samping untuk melakukan pembayaran aman via QRIS.</p>
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-emerald-500/10 rounded-lg border border-emerald-500/20">
                    <span class="text-[10px] text-emerald-400 font-bold uppercase tracking-widest">Merchant</span>
                    <span class="text-xs font-bold text-white uppercase">Virtual Oasis Creations</span>
                </div>
            </div>
        </div>
        @endif

        {{-- Footer --}}
        <div class="pt-6 border-t border-white/10 text-center">
            <p class="text-xs text-slate-600">Terima kasih telah menggunakan layanan FireFinance.<br>Invoice ini dibuat secara digital dan sah tanpa tanda tangan.</p>
        </div>
    </div>
</div>
@endsection
