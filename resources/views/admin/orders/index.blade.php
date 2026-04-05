@extends('layouts.admin')

@section('title', 'Kelola Pesanan')
@section('page-title', 'Pesanan')
@section('page-subtitle', 'Semua pesanan klien')

@section('content')

{{-- Filter by status --}}
<div class="flex flex-wrap items-center gap-2 mb-6">
    @foreach(['', 'pending', 'paid', 'active', 'cancelled'] as $statusFilter)
    <a href="{{ route('admin.orders.index', $statusFilter ? ['status' => $statusFilter] : []) }}"
       class="px-4 py-1.5 rounded-full text-xs font-medium border transition-all
              {{ request('status') === $statusFilter || (!request('status') && $statusFilter === '')
                  ? 'bg-emerald-500/20 text-emerald-300 border-emerald-500/40'
                  : 'border-white/10 text-slate-400 hover:border-white/20 hover:text-white' }}">
        {{ $statusFilter === '' ? 'Semua' : ucfirst($statusFilter) }}
    </a>
    @endforeach
</div>

<div class="glass-card rounded-2xl border border-white/10 overflow-hidden">
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
                @forelse($orders as $order)
                <tr class="hover:bg-white/2 transition-all">
                    <td class="px-6 py-4 font-mono font-bold text-white text-xs">{{ $order->order_number }}</td>
                    <td class="px-6 py-4">
                        <p class="font-medium text-slate-200">{{ $order->user->name }}</p>
                        <p class="text-xs text-slate-500">{{ $order->user->email }}</p>
                    </td>
                    <td class="px-6 py-4 text-slate-400">{{ $order->items->count() }} layanan</td>
                    <td class="px-6 py-4 font-bold text-emerald-400 whitespace-nowrap">{{ $order->formatted_total }}</td>
                    <td class="px-6 py-4"><span class="status-{{ $order->status }}">{{ $order->status_label }}</span></td>
                    <td class="px-6 py-4 text-slate-500 text-xs whitespace-nowrap">{{ $order->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.orders.show', $order->id) }}"
                           class="px-3 py-1.5 rounded-lg bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs hover:bg-emerald-500/20 transition-all">
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-12 text-center text-slate-500">Belum ada pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($orders->hasPages())
<div class="mt-6">{{ $orders->withQueryString()->links() }}</div>
@endif
@endsection
