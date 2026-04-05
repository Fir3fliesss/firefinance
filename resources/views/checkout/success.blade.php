@extends('layouts.app')

@section('title', 'Pesanan Berhasil')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    {{-- Success Header --}}
    <div class="text-center mb-10">
        <div class="w-20 h-20 rounded-full bg-emerald-500/20 border-2 border-emerald-500/50 flex items-center justify-center mx-auto mb-5">
            <svg class="w-10 h-10 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h1 class="section-title text-3xl text-white mb-3">Pesanan Berhasil Dibuat!</h1>
        <p class="text-slate-400">Nomor pesanan: <span class="font-mono text-amber-400 font-bold">{{ $order->order_number }}</span></p>
    </div>

    {{-- Order Details --}}
    <div class="glass-card rounded-2xl border border-white/10 p-6 mb-6">
        <h2 class="font-bold text-white mb-4">Detail Pesanan</h2>
        <div class="space-y-3 mb-5">
            @foreach($order->items as $item)
            <div class="flex items-center gap-3 p-3 bg-white/5 rounded-xl">
                <div class="w-10 h-10 rounded-lg bg-slate-800 flex items-center justify-center text-xl">{{ $item->service->category->icon ?? '💼' }}</div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-white">{{ $item->service->title }}</p>
                    <p class="text-xs text-slate-500">{{ $item->service->category->name }}</p>
                </div>
                <p class="text-sm font-bold text-emerald-400">{{ 'Rp ' . number_format($item->unit_price, 0, ',', '.') }}</p>
            </div>
            @endforeach
        </div>
        <div class="border-t border-white/10 pt-4 flex items-center justify-between">
            <span class="font-semibold text-slate-300">Total</span>
            <span class="text-xl font-bold text-emerald-400">{{ $order->formatted_total }}</span>
        </div>
    </div>

    {{-- QRIS Section --}}
    @if(isset($dynamicQris) && $dynamicQris)
    <div class="glass-card rounded-3xl border border-white/10 p-8 mb-8 text-center relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-48 h-48 bg-emerald-500/20 rounded-full -mr-24 -mt-24 blur-3xl group-hover:bg-emerald-500/30 transition-all duration-700"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-blue-500/20 rounded-full -ml-24 -mb-24 blur-3xl group-hover:bg-blue-500/30 transition-all duration-700"></div>
        
        <div class="relative z-10 flex flex-col items-center">
            <div class="flex items-center gap-3 mb-3">
                <div class="px-3 py-1 bg-white rounded-lg border-2 border-slate-900 shadow-sm">
                    <img src="{{ asset('qris.jpeg') }}" alt="QRIS" class="h-6 object-contain">
                </div>
                <h2 class="font-black text-white text-2xl tracking-tight">Pesan & Bayar</h2>
            </div>
            
            <p class="text-slate-400 text-sm mb-8 max-w-sm mx-auto leading-relaxed">Scan kode QR di bawah dengan aplikasi pembayaran favorit Anda untuk konfirmasi instan pesanan Anda.</p>
            
            <div class="relative inline-block mb-8 p-6 bg-white rounded-3xl shadow-2xl shadow-emerald-500/10 border-4 border-slate-900 overflow-hidden transform group-hover:scale-[1.02] transition-transform duration-500">
                <div class="absolute top-0 left-0 right-0 h-1 bg-slate-900"></div>
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-slate-900"></div>
                <div class="absolute top-0 bottom-0 left-0 w-1 bg-slate-900"></div>
                <div class="absolute top-0 bottom-0 right-0 w-1 bg-slate-900"></div>
                {!! QrCode::size(240)->generate($dynamicQris) !!}
                <div class="mt-4 flex flex-col items-center">
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.2em] mb-1">Merchant</span>
                    <span class="text-xs font-black text-slate-900 uppercase">Virtual Oasis Creations</span>
                </div>
            </div>
            
            <div class="w-full max-w-xs mx-auto flex flex-col gap-1 p-5 bg-emerald-500/10 rounded-2xl border border-emerald-500/20 mb-3 hover:bg-emerald-500/20 transition-colors">
                <span class="text-[10px] text-emerald-300 font-black uppercase tracking-[0.3em]">Total Tagihan</span>
                <span class="text-3xl font-black text-emerald-400 tracking-tight">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
            <div class="flex items-center gap-2 text-slate-500 text-[11px] font-medium italic opacity-70">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Nominal sudah termasuk biaya layanan sistem
            </div>
        </div>
    </div>
    @endif

    {{-- Invoice Info --}}
    @if($order->invoice)
    <div class="glass-card rounded-2xl border border-amber-500/20 p-4 mb-6 flex items-center justify-between">
        <div>
            <p class="text-xs text-slate-500 mb-0.5">Invoice</p>
            <p class="font-mono font-bold text-amber-400">{{ $order->invoice->invoice_number }}</p>
        </div>
        <a href="{{ route('client.invoices.show', $order->invoice->id) }}" class="flex items-center gap-2 px-4 py-2 rounded-lg bg-amber-500/10 border border-amber-500/30 text-amber-300 text-sm font-medium hover:bg-amber-500/20 transition-all">
            Lihat Invoice
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>
    @endif

    {{-- WA CTA --}}
    <div class="bg-green-500/5 border border-green-500/20 rounded-2xl p-6 text-center">
        <div class="w-12 h-12 rounded-full bg-green-500/20 flex items-center justify-center mx-auto mb-4">
            <svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
        </div>
        <h3 class="font-bold text-white mb-2">Lanjutkan via WhatsApp</h3>
        <p class="text-slate-400 text-sm mb-5">Klik tombol di bawah untuk mengirim detail pesanan ke konsultan kami dan menjadwalkan sesi konsultasi.</p>
        <a href="{{ $waUrl }}" target="_blank"
           class="inline-flex items-center gap-3 px-8 py-4 bg-green-500 hover:bg-green-400 text-white font-bold rounded-xl transition-all shadow-lg shadow-green-500/30 hover:-translate-y-0.5 hover:shadow-green-500/50">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
            Chat di WhatsApp Sekarang
        </a>
    </div>

    {{-- Actions --}}
    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mt-8">
        <a href="{{ route('client.dashboard') }}" class="btn-outline">Ke Dashboard Saya</a>
        <a href="{{ route('catalog.index') }}" class="btn-primary">Pesan Layanan Lain</a>
    </div>
</div>
@endsection
