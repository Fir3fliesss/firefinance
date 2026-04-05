@extends('layouts.admin')

@section('title', 'Detail Pesanan ' . $order->order_number)
@section('page-title', 'Detail Pesanan')
@section('page-subtitle', $order->order_number)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Items & Notes --}}
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
            <h2 class="font-bold text-white mb-3">Catatan Klien</h2>
            <p class="text-slate-400 text-sm">{{ $order->notes }}</p>
        </div>
        @endif
    </div>

    {{-- Sidebar --}}
    <div class="space-y-5">
        {{-- Client Info --}}
        <div class="glass-card rounded-2xl border border-white/10 p-5">
            <h2 class="font-bold text-white mb-4">Informasi Klien</h2>
            <div class="space-y-2 text-sm">
                <p class="font-semibold text-slate-200">{{ $order->user->name }}</p>
                <p class="text-slate-400">{{ $order->user->email }}</p>
                @if($order->user->phone)
                <p class="text-slate-400">{{ $order->user->phone }}</p>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->user->phone) }}"
                   target="_blank"
                   class="inline-flex items-center gap-1.5 mt-2 text-xs text-green-400 hover:text-green-300 transition-colors">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                    Chat WhatsApp
                </a>
                @endif
            </div>
        </div>

        {{-- Order Info --}}
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
                    <span class="font-mono text-amber-400 text-xs">{{ $order->invoice->invoice_number }}</span>
                </div>
                @endif
            </div>
        </div>

        {{-- Update Status --}}
        <div class="glass-card rounded-2xl border border-white/10 p-5">
            <h2 class="font-bold text-white mb-4">Update Status</h2>
            <form method="POST" action="{{ route('admin.orders.update', $order->id) }}">
                @csrf
                @method('PATCH')
                <select name="status" class="w-full px-4 py-2.5 mb-3 bg-white/5 border border-white/10 rounded-xl text-slate-100 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                    @foreach(['pending' => 'Pending', 'paid' => 'Dibayar', 'active' => 'Aktif', 'cancelled' => 'Dibatalkan'] as $val => $label)
                    <option value="{{ $val }}" {{ $order->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>

                <label for="admin_note" class="block text-sm font-medium text-slate-300 mb-1.5">Catatan Admin <span class="text-red-400">*</span></label>
                <textarea name="admin_note" id="admin_note" rows="3"
                    class="w-full px-4 py-2.5 mb-1 bg-white/5 border border-white/10 rounded-xl text-slate-100 text-sm placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 resize-none"
                    placeholder="Tulis catatan terkait perubahan status..."
                    required>{{ old('admin_note', $order->admin_note) }}</textarea>
                @error('admin_note')
                    <p class="text-red-400 text-xs mb-2">{{ $message }}</p>
                @enderror

                <button type="submit" class="btn-primary w-full justify-center !text-sm !py-2.5 mt-2">Simpan Status</button>
            </form>
        </div>

        {{-- Admin Note History --}}
        @if($order->admin_note)
        <div class="glass-card rounded-2xl border border-amber-500/20 bg-amber-500/5 p-5">
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                </svg>
                <h2 class="font-bold text-amber-300 text-sm">Catatan Admin Terakhir</h2>
            </div>
            <p class="text-slate-300 text-sm leading-relaxed">{{ $order->admin_note }}</p>
            @if($order->admin_note_at)
            <p class="text-xs text-slate-500 mt-2">{{ $order->admin_note_at->format('d M Y, H:i') }}</p>
            @endif
        </div>
        @endif

        <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-2 text-slate-400 hover:text-white text-sm transition-colors">
            ← Kembali ke Daftar Pesanan
        </a>
    </div>
</div>
@endsection
