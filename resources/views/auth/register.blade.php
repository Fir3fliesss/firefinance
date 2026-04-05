@extends('layouts.app')

@section('title', 'Daftar')

@section('content')
<div class="min-h-[calc(100vh-4rem)] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="section-title text-white mb-2">Mulai Perjalanan Finansial Anda</h1>
            <p class="text-slate-400">Daftar gratis dan akses layanan keuangan premium</p>
        </div>

        <div class="glass-card rounded-2xl p-8 border border-white/10">
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-slate-300 mb-1.5">Nama Lengkap</label>
                    <input id="name" name="name" type="text" autocomplete="name" required
                        value="{{ old('name') }}"
                        class="w-full px-4 py-3 bg-white/5 border @error('name') border-red-500/50 @else border-white/10 @enderror rounded-xl text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/50 transition-all text-sm"
                        placeholder="Nama lengkap Anda">
                    @error('name')
                        <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-300 mb-1.5">Email</label>
                    <input id="email" name="email" type="email" autocomplete="email" required
                        value="{{ old('email') }}"
                        class="w-full px-4 py-3 bg-white/5 border @error('email') border-red-500/50 @else border-white/10 @enderror rounded-xl text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/50 transition-all text-sm"
                        placeholder="nama@email.com">
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-slate-300 mb-1.5">No. WhatsApp <span class="text-slate-500">(opsional)</span></label>
                    <input id="phone" name="phone" type="tel"
                        value="{{ old('phone') }}"
                        class="w-full px-4 py-3 bg-white/5 border @error('phone') border-red-500/50 @else border-white/10 @enderror rounded-xl text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/50 transition-all text-sm"
                        placeholder="+62 812 3456 7890">
                    @error('phone')
                        <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-300 mb-1.5">Password</label>
                    <input id="password" name="password" type="password" autocomplete="new-password" required
                        class="w-full px-4 py-3 bg-white/5 border @error('password') border-red-500/50 @else border-white/10 @enderror rounded-xl text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/50 transition-all text-sm"
                        placeholder="Min. 8 karakter">
                    @error('password')
                        <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-300 mb-1.5">Konfirmasi Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/50 transition-all text-sm"
                        placeholder="Ulangi password">
                </div>

                <button type="submit" class="w-full btn-primary justify-center py-3">
                    Buat Akun Gratis
                </button>
            </form>

            <p class="text-center text-sm text-slate-500 mt-6">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-emerald-400 hover:text-emerald-300 font-medium transition-colors">Masuk</a>
            </p>
        </div>
    </div>
</div>
@endsection
