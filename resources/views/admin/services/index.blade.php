@extends('layouts.admin')

@section('title', 'Kelola Layanan')
@section('page-title', 'Layanan')
@section('page-subtitle', 'Kelola katalog layanan keuangan')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div></div>
    <a href="{{ route('admin.services.create') }}" class="btn-primary !text-sm">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Tambah Layanan
    </a>
</div>

<div class="glass-card rounded-2xl border border-white/10 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-900/50">
                <tr>
                    <th class="text-left px-6 py-3 text-xs uppercase tracking-wider text-slate-500 font-medium">Layanan</th>
                    <th class="text-left px-6 py-3 text-xs uppercase tracking-wider text-slate-500 font-medium">Kategori</th>
                    <th class="text-left px-6 py-3 text-xs uppercase tracking-wider text-slate-500 font-medium">Harga</th>
                    <th class="text-left px-6 py-3 text-xs uppercase tracking-wider text-slate-500 font-medium">Status</th>
                    <th class="text-right px-6 py-3 text-xs uppercase tracking-wider text-slate-500 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($services as $service)
                <tr class="hover:bg-white/2 transition-all">
                    <td class="px-6 py-4">
                        <p class="font-medium text-slate-200">{{ $service->title }}</p>
                        @if($service->is_featured)
                        <span class="text-xs text-amber-400">⭐ Unggulan</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-slate-400 text-xs">{{ $service->category->icon }} {{ $service->category->name }}</span>
                    </td>
                    <td class="px-6 py-4 font-bold text-emerald-400">{{ $service->formatted_price }}</td>
                    <td class="px-6 py-4">
                        @if($service->is_active)
                            <span class="status-paid">Aktif</span>
                        @else
                            <span class="status-cancelled">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.services.edit', $service->id) }}"
                               class="px-3 py-1.5 rounded-lg bg-slate-700/50 border border-white/10 text-slate-300 text-xs hover:bg-slate-700 transition-all">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.services.destroy', $service->id) }}" onsubmit="return confirm('Yakin hapus layanan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-500/10 border border-red-500/20 text-red-400 text-xs hover:bg-red-500/20 transition-all">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-12 text-center text-slate-500">Belum ada layanan. <a href="{{ route('admin.services.create') }}" class="text-emerald-400 hover:underline">Tambah sekarang</a>.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($services->hasPages())
<div class="mt-6">{{ $services->links() }}</div>
@endif
@endsection
