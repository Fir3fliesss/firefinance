@extends('layouts.app')

@section('title', 'Beranda')
@section('meta_description', 'FireFinance — Platform jasa keuangan premium. Konsultan, Financial Planner, Investasi, Asuransi & Perpajakan.')

@section('content')

{{-- Hero Section --}}
<section class="relative pt-20 pb-32 overflow-hidden">
    <div class="absolute inset-0 -z-10">
        <div class="absolute top-1/4 left-1/3 w-[500px] h-[500px] bg-emerald-500/8 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-10 right-1/4 w-[400px] h-[400px] bg-amber-500/6 rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm font-medium mb-6">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
            Jasa Keuangan Premium & Terpercaya
        </div>
        <h1 class="section-title text-5xl sm:text-6xl lg:text-7xl text-white mb-6 leading-tight">
            Wujudkan<br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-400">Kebebasan Finansial</span><br>
            Anda Bersama Kami
        </h1>
        <p class="text-slate-400 text-lg sm:text-xl max-w-2xl mx-auto mb-10 leading-relaxed">
            Konsultan keuangan profesional, financial planner berpengalaman, dan solusi investasi yang terukur untuk masa depan yang lebih sejahtera.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('catalog.index') }}" class="btn-primary text-base px-8 py-4">
                Temukan Layanan
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            <a href="{{ route('register') }}" class="btn-outline text-base px-8 py-4">
                Daftar Gratis
            </a>
        </div>

        {{-- Stats --}}
        <div class="flex flex-wrap items-center justify-center gap-8 mt-16 pt-12 border-t border-white/10">
            <div class="text-center">
                <p class="text-3xl font-bold text-white">500+</p>
                <p class="text-sm text-slate-500 mt-1">Klien Puas</p>
            </div>
            <div class="w-px h-10 bg-white/10 hidden sm:block"></div>
            <div class="text-center">
                <p class="text-3xl font-bold text-white">12+</p>
                <p class="text-sm text-slate-500 mt-1">Layanan Tersedia</p>
            </div>
            <div class="w-px h-10 bg-white/10 hidden sm:block"></div>
            <div class="text-center">
                <p class="text-3xl font-bold text-white">98%</p>
                <p class="text-sm text-slate-500 mt-1">Tingkat Kepuasan</p>
            </div>
            <div class="w-px h-10 bg-white/10 hidden sm:block"></div>
            <div class="text-center">
                <p class="text-3xl font-bold text-white">5★</p>
                <p class="text-sm text-slate-500 mt-1">Rating Konsultan</p>
            </div>
        </div>
    </div>
</section>

{{-- Featured Categories --}}
@if($featuredCategories->isNotEmpty())
<section class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12">
        <h2 class="section-title text-3xl text-white mb-3">Layanan Unggulan Kami</h2>
        <p class="text-slate-400">Solusi keuangan terpilih yang paling banyak diminati klien kami</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($featuredCategories as $cat)
        <a href="{{ route('catalog.index', ['category' => $cat->slug]) }}"
           class="group glass-card rounded-2xl p-8 border border-white/10 hover:border-emerald-500/30 transition-all duration-300 hover:-translate-y-1">
            <div class="text-4xl mb-4">{{ $cat->icon }}</div>
            <h3 class="text-xl font-bold text-white mb-2 group-hover:text-emerald-400 transition-colors">{{ $cat->name }}</h3>
            <p class="text-slate-400 text-sm leading-relaxed">{{ $cat->description }}</p>
            <div class="flex items-center gap-1 mt-4 text-emerald-400 text-sm font-medium">
                Lihat Layanan
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </div>
        </a>
        @endforeach
    </div>
</section>
@endif

{{-- Featured Services --}}
@if($featuredServices->isNotEmpty())
<section class="py-20 bg-slate-900/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-12">
            <div>
                <h2 class="section-title text-3xl text-white mb-3">Paket Layanan Terpilih</h2>
                <p class="text-slate-400">Dipilih khusus oleh tim ahli kami untuk hasil terbaik</p>
            </div>
            <a href="{{ route('catalog.index') }}" class="hidden sm:flex items-center gap-2 text-emerald-400 hover:text-emerald-300 text-sm font-medium transition-colors">
                Lihat Semua
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($featuredServices as $service)
            <a href="{{ route('services.show', $service->slug) }}"
               class="group glass-card rounded-2xl overflow-hidden border border-white/10 hover:border-emerald-500/30 transition-all duration-300 hover:-translate-y-1 flex flex-col">
                {{-- Image / Placeholder --}}
                <div class="h-48 bg-gradient-to-br from-slate-800 to-slate-900 relative overflow-hidden flex items-center justify-center">
                    @if($service->image)
                        <img src="{{ Storage::url($service->image) }}" class="w-full h-full object-cover" alt="{{ $service->title }}">
                        <div class="absolute inset-0 bg-slate-900/10"></div>
                    @elseif($service->category && $service->category->image)
                        <img src="{{ Storage::url($service->category->image) }}" class="w-24 h-24 object-contain opacity-40" alt="{{ $service->category->name }}">
                    @else
                        <div class="text-6xl opacity-30">{{ $service->category->icon ?? '💼' }}</div>
                    @endif
                    <div class="absolute top-3 left-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-500/20 text-amber-300 border border-amber-500/30">
                            ⭐ Unggulan
                        </span>
                    </div>
                    <div class="absolute top-3 right-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-700/80 text-slate-300 border border-white/10">
                            {{ $service->category->name }}
                        </span>
                    </div>
                </div>
                <div class="p-6 flex flex-col flex-1">
                    <h3 class="font-bold text-white group-hover:text-emerald-400 transition-colors mb-2 leading-snug">{{ $service->title }}</h3>
                    <p class="text-slate-400 text-sm leading-relaxed flex-1 line-clamp-2">{{ $service->short_description }}</p>
                    <div class="flex items-center justify-between mt-4 pt-4 border-t border-white/10">
                        <p class="text-emerald-400 font-bold text-lg">{{ $service->formatted_price }}</p>
                        <span class="text-xs text-slate-500 flex items-center gap-1">
                            Lihat Detail
                            <svg class="w-3 h-3 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <div class="text-center mt-10 sm:hidden">
            <a href="{{ route('catalog.index') }}" class="btn-outline">Lihat Semua Layanan</a>
        </div>
    </div>
</section>
@endif

{{-- Why Choose Us --}}
<section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-14">
        <h2 class="section-title text-3xl text-white mb-3">Mengapa Memilih FireFinance?</h2>
        <p class="text-slate-400 max-w-xl mx-auto">Kami menggabungkan keahlian profesional dengan teknologi modern untuk memberikan layanan keuangan terbaik</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="text-center">
            <div class="w-14 h-14 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center mx-auto mb-5">
                <svg class="w-7 h-7 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-white mb-2">Terpercaya & Akuntabel</h3>
            <p class="text-slate-400 text-sm leading-relaxed">Setiap transaksi terdokumentasi dengan invoice resmi dan status yang dapat dipantau real-time.</p>
        </div>
        <div class="text-center">
            <div class="w-14 h-14 rounded-2xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center mx-auto mb-5">
                <svg class="w-7 h-7 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/></svg>
            </div>
            <h3 class="text-lg font-bold text-white mb-2">Konsultan Berpengalaman</h3>
            <p class="text-slate-400 text-sm leading-relaxed">Tim konsultan dengan pengalaman 10+ tahun di bidang keuangan, investasi, dan perpajakan.</p>
        </div>
        <div class="text-center">
            <div class="w-14 h-14 rounded-2xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center mx-auto mb-5">
                <svg class="w-7 h-7 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-white mb-2">Konsultasi via WhatsApp</h3>
            <p class="text-slate-400 text-sm leading-relaxed">Setelah checkout, Anda langsung terhubung dengan konsultan kami melalui WhatsApp untuk konfirmasi layanan.</p>
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="glass-card rounded-3xl p-12 border border-emerald-500/20 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-transparent -z-10"></div>
            <h2 class="section-title text-3xl text-white mb-4">Siap Memulai Perjalanan Finansial Anda?</h2>
            <p class="text-slate-400 mb-8 max-w-lg mx-auto">Bergabung dengan ratusan klien yang telah mempercayakan perencanaan keuangan mereka kepada kami.</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('catalog.index') }}" class="btn-primary text-base px-8 py-4">Mulai Sekarang</a>
                <a href="https://wa.me/6282163387780" target="_blank" class="btn-outline text-base px-8 py-4">
                    <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                    Hubungi via WA
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
