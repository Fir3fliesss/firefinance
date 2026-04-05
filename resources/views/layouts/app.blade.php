<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FireFinance') — Jasa Keuangan Premium</title>
    <meta name="description" content="@yield('meta_description', 'Platform e-commerce jasa keuangan premium. Konsultan, Financial Planner, Investasi, Asuransi, dan Perpajakan.')">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen antialiased">

    {{-- Background Gradient --}}
    <div class="fixed inset-0 -z-10">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950"></div>
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-emerald-500/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-amber-500/5 rounded-full blur-3xl"></div>
    </div>

    {{-- Navbar --}}
    <nav class="sticky top-0 z-50 border-b border-white/10 glass-card">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center shadow-lg shadow-emerald-500/40 group-hover:shadow-emerald-500/60 transition-all">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                    <span class="font-bold text-lg tracking-tight">Fire<span class="text-emerald-400">Finance</span></span>
                </a>

                {{-- Nav Links --}}
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('home') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-white/5 transition-all">Beranda</a>
                    <a href="{{ route('catalog.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-white/5 transition-all">Layanan</a>
                    @auth
                        <a href="{{ route('client.dashboard') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-white/5 transition-all">Dashboard</a>
                    @endauth
                </div>

                {{-- Right Actions --}}
                <div class="flex items-center gap-3">
                    @auth
                        {{-- Cart --}}
                        <a href="{{ route('cart.index') }}" class="relative p-2 rounded-lg text-slate-400 hover:text-white hover:bg-white/5 transition-all">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            @php $cartCount = auth()->user()->cartItems()->count(); @endphp
                            @if($cartCount > 0)
                                <span class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-emerald-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center leading-none">{{ $cartCount }}</span>
                            @endif
                        </a>

                        {{-- Wishlist --}}
                        <a href="{{ route('wishlist.index') }}" class="relative p-2 rounded-lg text-slate-400 hover:text-white hover:bg-white/5 transition-all">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            @php $wishlistCount = auth()->user()->wishlistItems()->count(); @endphp
                            @if($wishlistCount > 0)
                                <span class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-amber-500 text-slate-900 text-[10px] font-bold rounded-full flex items-center justify-center leading-none">{{ $wishlistCount }}</span>
                            @endif
                        </a>

                        {{-- User Menu --}}
                        <div class="relative group">
                            <button class="flex items-center gap-2 px-3 py-1.5 rounded-lg glass-card hover:border-emerald-500/30 transition-all">
                                @if(auth()->user()->avatar)
                                    <img src="{{ Str::startsWith(auth()->user()->avatar, 'http') ? auth()->user()->avatar : asset('storage/' . auth()->user()->avatar) }}" alt="Avatar" class="w-7 h-7 rounded-full object-cover border border-emerald-500/50 shadow-sm">
                                @else
                                    <div class="w-7 h-7 bg-emerald-500/20 text-emerald-400 rounded-full flex items-center justify-center text-xs font-bold">
                                        {{ auth()->user()->initials() }}
                                    </div>
                                @endif
                                <span class="hidden sm:block text-sm font-medium text-slate-200">{{ auth()->user()->name }}</span>
                                <svg class="w-3 h-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            {{-- Dropdown --}}
                            <div class="absolute right-0 mt-2 w-48 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-150 z-50">
                                <div class="glass-card rounded-xl border border-white/10 shadow-2xl shadow-black/50 overflow-hidden py-1">
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-300 hover:text-white hover:bg-white/5 transition-all">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                            Admin Panel
                                        </a>
                                    @endif
                                    <a href="{{ route('client.dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-300 hover:text-white hover:bg-white/5 transition-all">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                                        Dashboard Saya
                                    </a>
                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-300 hover:text-white hover:bg-white/5 transition-all">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        Profil Saya
                                    </a>
                                    <a href="{{ route('client.orders.index') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-300 hover:text-white hover:bg-white/5 transition-all">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                        Riwayat Pesanan
                                    </a>
                                    <div class="border-t border-white/10 my-1"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-red-400 hover:text-red-300 hover:bg-red-500/10 transition-all text-left">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                            Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-white/5 transition-all">Masuk</a>
                        <a href="{{ route('register') }}" class="btn-primary !py-2 !text-sm">Daftar Gratis</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="flex items-center gap-3 px-4 py-3 rounded-lg bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-sm">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="flex items-center gap-3 px-4 py-3 rounded-lg bg-red-500/10 border border-red-500/30 text-red-300 text-sm">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('error') }}
            </div>
        </div>
    @endif

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="border-t border-white/10 mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        </div>
                        <span class="font-bold text-lg">Fire<span class="text-emerald-400">Finance</span></span>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed max-w-xs">Platform e-commerce jasa keuangan premium. Konsultan berpengalaman siap membantu Anda mencapai kebebasan finansial.</p>
                    <div class="flex items-center gap-2 mt-4 text-sm text-slate-400">
                        <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                        <a href="https://wa.me/6281234567890" target="_blank" class="hover:text-emerald-400 transition-colors">+62 812 3456 7890</a>
                    </div>
                </div>
                <div>
                    <h4 class="font-semibold text-slate-200 mb-4 text-sm uppercase tracking-wider">Layanan</h4>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li><a href="{{ route('catalog.index') }}" class="hover:text-emerald-400 transition-colors">Semua Layanan</a></li>
                        <li><a href="{{ route('catalog.index', ['category' => 'konsultan-keuangan']) }}" class="hover:text-emerald-400 transition-colors">Konsultan Keuangan</a></li>
                        <li><a href="{{ route('catalog.index', ['category' => 'financial-planner']) }}" class="hover:text-emerald-400 transition-colors">Financial Planner</a></li>
                        <li><a href="{{ route('catalog.index', ['category' => 'investasi']) }}" class="hover:text-emerald-400 transition-colors">Investasi</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-slate-200 mb-4 text-sm uppercase tracking-wider">Akun</h4>
                    <ul class="space-y-2 text-sm text-slate-400">
                        @guest
                            <li><a href="{{ route('login') }}" class="hover:text-emerald-400 transition-colors">Masuk</a></li>
                            <li><a href="{{ route('register') }}" class="hover:text-emerald-400 transition-colors">Daftar</a></li>
                        @else
                            <li><a href="{{ route('client.dashboard') }}" class="hover:text-emerald-400 transition-colors">Dashboard</a></li>
                            <li><a href="{{ route('client.orders.index') }}" class="hover:text-emerald-400 transition-colors">Pesanan Saya</a></li>
                            <li><a href="{{ route('wishlist.index') }}" class="hover:text-emerald-400 transition-colors">Wishlist</a></li>
                        @endguest
                    </ul>
                </div>
            </div>
            <div class="border-t border-white/10 mt-8 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} FireFinance. All rights reserved.</p>
                <p>Dibuat dengan ❤️ untuk kebebasan finansial Anda.</p>
            </div>
        </div>
    </footer>

</body>
</html>
