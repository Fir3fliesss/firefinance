@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan platform FireFinance')

@section('content')

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="glass-card rounded-2xl border border-white/10 p-5">
        <p class="text-xs text-slate-500 mb-2 uppercase tracking-wider">Total Pesanan</p>
        <p class="text-3xl font-bold text-white">{{ number_format($totalOrders) }}</p>
    </div>
    <div class="glass-card rounded-2xl border border-amber-500/20 p-5">
        <p class="text-xs text-slate-500 mb-2 uppercase tracking-wider">Menunggu</p>
        <p class="text-3xl font-bold text-amber-400">{{ number_format($pendingOrders) }}</p>
    </div>
    <div class="glass-card rounded-2xl border border-emerald-500/20 p-5">
        <p class="text-xs text-slate-500 mb-2 uppercase tracking-wider">Total Klien</p>
        <p class="text-3xl font-bold text-emerald-400">{{ number_format($totalClients) }}</p>
    </div>
    <div class="glass-card rounded-2xl border border-blue-500/20 p-5">
        <p class="text-xs text-slate-500 mb-2 uppercase tracking-wider">Total Revenue</p>
        <p class="text-xl font-bold text-blue-400">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
</div>

{{-- Recent Orders --}}
<div class="glass-card rounded-2xl border border-white/10 overflow-hidden">
    <div class="flex items-center justify-between px-6 py-4 border-b border-white/10">
        <h2 class="font-bold text-white">Pesanan Terbaru</h2>
        <a href="{{ route('admin.orders.index') }}" class="text-sm text-emerald-400 hover:text-emerald-300 transition-colors">Lihat Semua →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-900/50">
                <tr>
                    <th class="text-left px-6 py-3 text-xs uppercase tracking-wider text-slate-500 font-medium">Order #</th>
                    <th class="text-left px-6 py-3 text-xs uppercase tracking-wider text-slate-500 font-medium">Klien</th>
                    <th class="text-left px-6 py-3 text-xs uppercase tracking-wider text-slate-500 font-medium">Items</th>
                    <th class="text-left px-6 py-3 text-xs uppercase tracking-wider text-slate-500 font-medium">Total</th>
                    <th class="text-left px-6 py-3 text-xs uppercase tracking-wider text-slate-500 font-medium">Status</th>
                    <th class="text-left px-6 py-3 text-xs uppercase tracking-wider text-slate-500 font-medium">Tanggal</th>
                    <th class="text-right px-6 py-3 text-xs uppercase tracking-wider text-slate-500 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($recentOrders as $order)
                <tr class="hover:bg-white/2 transition-all">
                    <td class="px-6 py-3 font-mono font-bold text-white text-xs">{{ $order->order_number }}</td>
                    <td class="px-6 py-3">
                        <p class="font-medium text-slate-200">{{ $order->user->name }}</p>
                        <p class="text-xs text-slate-500">{{ $order->user->email }}</p>
                    </td>
                    <td class="px-6 py-3 text-slate-400">{{ $order->items->count() }}</td>
                    <td class="px-6 py-3 font-bold text-emerald-400 whitespace-nowrap">{{ $order->formatted_total }}</td>
                    <td class="px-6 py-3"><span class="status-{{ $order->status }}">{{ $order->status_label }}</span></td>
                    <td class="px-6 py-3 text-slate-500 text-xs whitespace-nowrap">{{ $order->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-3 text-right">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-emerald-400 hover:text-emerald-300 text-xs transition-colors">Detail →</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-10 text-center text-slate-500">Belum ada pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
