@extends('layouts.app')

@section('title', 'Masuk')

@section('content')
<div class="min-h-[calc(100vh-4rem)] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="section-title text-white mb-2">Selamat Datang Kembali</h1>
            <p class="text-slate-400">Masuk untuk mengakses layanan keuangan premium Anda</p>
        </div>

        <div class="glass-card rounded-2xl p-8 border border-white/10">
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

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
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-sm font-medium text-slate-300">Password</label>
                    </div>
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                        class="w-full px-4 py-3 bg-white/5 border @error('password') border-red-500/50 @else border-white/10 @enderror rounded-xl text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/50 transition-all text-sm"
                        placeholder="••••••••">
                    @error('password')
                        <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-2">
                    <input id="remember" name="remember" type="checkbox" class="w-4 h-4 rounded border-white/20 bg-white/5 text-emerald-500 focus:ring-emerald-500/50">
                    <label for="remember" class="text-sm text-slate-400">Ingat saya</label>
                </div>

                <button type="submit" class="w-full btn-primary justify-center py-3">
                    Masuk
                </button>

                <div class="flex items-center gap-4 my-5 mt-6">
                    <div class="flex-1 border-t border-white/10"></div>
                    <span class="text-xs text-slate-500 uppercase tracking-wider font-medium">Atau</span>
                    <div class="flex-1 border-t border-white/10"></div>
                </div>

                <a href="{{ route('google.login') }}" class="w-full flex items-center justify-center gap-3 py-3 px-4 bg-white/5 border border-white/10 rounded-xl text-slate-200 hover:bg-white/10 transition-all text-sm font-medium group">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Masuk dengan Google
                </a>
            </form>

            <p class="text-center text-sm text-slate-500 mt-6">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-emerald-400 hover:text-emerald-300 font-medium transition-colors">Daftar sekarang</a>
            </p>
        </div>

        {{-- Demo Credentials --}}
        <div class="mt-6 glass-card rounded-xl p-4 border border-amber-500/20">
            <p class="text-xs font-semibold text-amber-400 mb-2">Akun Demo</p>
            <div class="space-y-1 text-xs text-slate-400 font-mono">
                <p><span class="text-slate-300">Admin:</span> admin@firefinance.id / password</p>
                <p><span class="text-slate-300">Client:</span> budi@example.com / password</p>
            </div>
        </div>
    </div>
</div>
@endsection
