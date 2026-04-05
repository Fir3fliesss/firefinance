@extends('layouts.admin')

@section('title', 'Edit Layanan')
@section('page-title', 'Edit Layanan')
@section('page-subtitle', '{{ $service->title }}')

@section('content')
<div class="max-w-3xl">
    <form method="POST" action="{{ route('admin.services.update', $service->id) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="glass-card rounded-2xl border border-white/10 p-6 space-y-5">

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1.5">Kategori</label>
                <select name="category_id" required class="w-full px-4 py-3 bg-white/5 border @error('category_id') border-red-500/50 @else border-white/10 @enderror rounded-xl text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 text-sm">
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ (old('category_id', $service->category_id)) == $cat->id ? 'selected' : '' }}>{{ $cat->icon }} {{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1.5">Nama Layanan</label>
                <input type="text" name="title" value="{{ old('title', $service->title) }}" required
                    class="w-full px-4 py-3 bg-white/5 border @error('title') border-red-500/50 @else border-white/10 @enderror rounded-xl text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 text-sm">
                @error('title')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1.5">Deskripsi Singkat <span class="text-slate-500">(maks. 500 karakter)</span></label>
                <input type="text" name="short_description" value="{{ old('short_description', $service->short_description) }}"
                    class="w-full px-4 py-3 bg-white/5 border @error('short_description') border-red-500/50 @else border-white/10 @enderror rounded-xl text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 text-sm">
                @error('short_description')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1.5">Deskripsi Lengkap</label>
                <textarea name="description" rows="6" required
                    class="w-full px-4 py-3 bg-white/5 border @error('description') border-red-500/50 @else border-white/10 @enderror rounded-xl text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 text-sm resize-none">{{ old('description', $service->description) }}</textarea>
                @error('description')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1.5">Harga (Rp)</label>
                <input type="number" name="price" value="{{ old('price', $service->price) }}" required min="0" step="1000"
                    class="w-full px-4 py-3 bg-white/5 border @error('price') border-red-500/50 @else border-white/10 @enderror rounded-xl text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 text-sm">
                @error('price')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center gap-6">
                <label class="flex items-center gap-2.5 cursor-pointer">
                    <input type="hidden" name="is_featured" value="0">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $service->is_featured) ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-white/20 bg-white/5 text-emerald-500 focus:ring-emerald-500/50">
                    <span class="text-sm text-slate-300">⭐ Tampilkan sebagai Unggulan</span>
                </label>
                <label class="flex items-center gap-2.5 cursor-pointer">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-white/20 bg-white/5 text-emerald-500 focus:ring-emerald-500/50">
                    <span class="text-sm text-slate-300">Aktifkan Layanan</span>
                </label>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
            <a href="{{ route('admin.services.index') }}" class="text-sm text-slate-400 hover:text-white transition-colors">Batal</a>
        </div>
    </form>
</div>
@endsection
