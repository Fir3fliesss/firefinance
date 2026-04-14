@extends('layouts.admin')

@section('title', 'Kelola Kategori')
@section('page-title', 'Kategori')
@section('page-subtitle', 'Kelola kategori layanan')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Add Category Form --}}
    <div class="lg:col-span-1">
        <div class="glass-card rounded-2xl border border-white/10 p-6 sticky top-24">
            <h2 class="font-bold text-white mb-5">Tambah Kategori</h2>
            <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1.5">Nama Kategori</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Perencanaan Keuangan"
                        class="w-full px-4 py-3 bg-white/5 border @error('name') border-red-500/50 @else border-white/10 @enderror rounded-xl text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 text-sm">
                    @error('name')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1.5">Gambar Ikon (Opsional)</label>
                    <input type="file" name="image" accept="image/*"
                         class="w-full px-4 py-2 bg-white/5 border @error('image') border-red-500/50 @else border-white/10 @enderror rounded-xl text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-500 file:text-white hover:file:bg-emerald-600 transition-all cursor-pointer">
                    @error('image')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror

                    <div class="mt-4 relative flex items-center">
                        <div class="flex-grow border-t border-white/10"></div>
                        <span class="flex-shrink-0 mx-4 text-slate-500 text-xs font-medium">ATAU</span>
                        <div class="flex-grow border-t border-white/10"></div>
                    </div>

                    <label class="block text-sm font-medium text-slate-300 mt-4 mb-1.5">Ikon Emoji (Opsional)</label>
                    <input type="text" name="icon" value="{{ old('icon') }}" placeholder="📊" maxlength="10"
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 text-sm text-center text-2xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1.5">Deskripsi</label>
                    <textarea name="description" rows="3" placeholder="Tentang kategori ini..."
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 text-sm resize-none">{{ old('description') }}</textarea>
                </div>
                <label class="flex items-center gap-2.5 cursor-pointer">
                    <input type="hidden" name="is_featured" value="0">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-white/20 bg-white/5 text-emerald-500">
                    <span class="text-sm text-slate-300">Tampilkan di Beranda</span>
                </label>
                <button type="submit" class="btn-primary w-full justify-center">Tambah Kategori</button>
            </form>
        </div>
    </div>

    {{-- Categories List --}}
    <div class="lg:col-span-2">
        <div class="space-y-3">
            @forelse($categories as $category)
            <div class="glass-card rounded-2xl border border-white/10 p-5 flex items-center gap-4">
                @if($category->image)
                <div class="w-12 h-12 rounded-xl overflow-hidden flex-shrink-0 border border-white/10 bg-white/5">
                    <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                </div>
                @else
                <div class="text-3xl w-12 h-12 rounded-xl bg-slate-800 flex items-center justify-center flex-shrink-0">
                    {{ $category->icon ?? '📁' }}
                </div>
                @endif
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2">
                        <p class="font-semibold text-white">{{ $category->name }}</p>
                        @if($category->is_featured)
                        <span class="text-xs text-amber-400 border border-amber-500/30 bg-amber-500/10 px-2 py-0.5 rounded-full">Beranda</span>
                        @endif
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $category->services_count }} layanan</p>
                    @if($category->description)
                    <p class="text-xs text-slate-500 mt-1 truncate">{{ $category->description }}</p>
                    @endif
                </div>
                <form method="POST" action="{{ route('admin.categories.destroy', $category->id) }}" onsubmit="return confirm('Yakin hapus kategori ini? Semua layanannya akan ikut terpengaruh.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-2 text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded-lg transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </form>
            </div>
            @empty
            <div class="glass-card rounded-2xl border border-white/10 p-12 text-center">
                <p class="text-slate-500">Belum ada kategori.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
