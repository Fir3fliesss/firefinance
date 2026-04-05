@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white tracking-tight">Profil Saya</h1>
        <p class="text-slate-400 mt-2">Kelola informasi pribadi dan pengaturan akun Anda.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        {{-- Sidebar Info --}}
        <div class="md:col-span-1 space-y-6">
            <div class="glass-card rounded-2xl p-6 border border-white/10 text-center relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-b from-emerald-500/10 to-transparent"></div>
                
                <div class="relative flex flex-col items-center">
                    @if($user->avatar)
                        <img src="{{ Str::startsWith($user->avatar, 'http') ? $user->avatar : asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-24 h-24 rounded-full border-2 border-emerald-500/50 shadow-lg object-cover mb-4">
                    @else
                        <div class="w-24 h-24 rounded-full border-2 border-emerald-500/50 bg-slate-800 flex items-center justify-center text-3xl text-emerald-400 mb-4 shadow-lg">
                            {{ auth()->user()->initials() }}
                        </div>
                    @endif

                    <h2 class="text-xl font-semibold text-white">{{ $user->name }}</h2>
                    <p class="text-sm text-emerald-400 font-medium mb-1">{{ $user->role_name ?? 'Client' }}</p>

                    @if($user->google_id)
                        <div class="mt-4 px-3 py-1.5 bg-white/5 border border-white/10 rounded-lg flex items-center justify-center gap-2 text-xs font-medium text-slate-300 group">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Google Linked
                        </div>
                        <p class="text-xs text-slate-500 mt-2 break-all">{{ $user->email }}</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Form Edit --}}
        <div class="md:col-span-2">
            <div class="glass-card rounded-2xl p-6 md:p-8 border border-white/10">
                <h3 class="text-lg font-semibold text-white mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Informasi Akun
                </h3>
                
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-slate-300 mb-1.5">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                            @error('name')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-1.5">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                                @if($user->google_id) disabled title="Email diatur via Google" class="w-full px-4 py-2.5 bg-slate-900/50 border border-white/5 rounded-xl text-slate-500 cursor-not-allowed" @else class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500/50" @endif>
                            @error('email')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-1.5">Nomor Telepon</label>
                            <input type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                            @error('phone_number')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                        </div>

                        @if($user->isAdmin())
                            <div class="sm:col-span-2 mt-2"><h4 class="text-sm font-semibold text-emerald-400 border-b border-white/10 pb-2">Informasi Posisi (Bagi Admin)</h4></div>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-1.5">Departemen</label>
                                <input type="text" name="department" value="{{ old('department', $user->department) }}" class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                                @error('department')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-1.5">Jabatan / Posisi</label>
                                <input type="text" name="position" value="{{ old('position', $user->position) }}" class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                                @error('position')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-slate-300 mb-1.5">Line Manager</label>
                                <input type="text" name="line_manager" value="{{ old('line_manager', $user->line_manager) }}" class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                                @error('line_manager')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                            </div>
                        @endif
                    </div>

                    @if(!$user->google_id)
                        <div class="border-t border-white/10 my-6"></div>
                        <h3 class="text-sm font-semibold text-white mb-4">Pengaturan Akun Lokal</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div class="sm:col-span-2 mb-2">
                                <label class="block text-sm font-medium text-slate-300 mb-1.5">Ganti Foto Profil / Avatar</label>
                                <input type="file" name="avatar_file" accept="image/*" class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-500/20 file:text-emerald-400 hover:file:bg-emerald-500/30">
                                @error('avatar_file')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                            </div>
                            
                            <div class="sm:col-span-2"><p class="block text-sm font-medium text-slate-300 mb-1.5">Ganti Password <span class="text-slate-500 text-xs font-normal">(opsional)</span></p></div>
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-1.5">Password Baru</label>
                                <input type="password" name="password" class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                                @error('password')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-1.5">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                            </div>
                        </div>
                    @endif

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="btn-primary px-8 py-2.5">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
