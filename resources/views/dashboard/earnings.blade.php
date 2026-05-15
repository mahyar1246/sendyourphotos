@extends('layouts.app')
@section('title', 'Revenue Analytics - SendYourPhotos')

@php
    $currentTheme = session('user_theme', 'autumn');
    if ($currentTheme == 'forest') {
        $bg = '#E8F3E8'; $primary = '#2D5A27'; $secondary = '#1B3022';
        $accent = '#82A766'; $hover = '#1F401B'; $light = '#F0FDF4'; $borderLight = '#DCFCE7';
    } elseif ($currentTheme == 'ocean') {
        $bg = '#E0F2F7'; $primary = '#076678'; $secondary = '#002B36';
        $accent = '#268BD2'; $hover = '#044e5c'; $light = '#ECFEFF'; $borderLight = '#CFFAFE';
    } else {
        $bg = '#F4ECE6'; $primary = '#C84B31'; $secondary = '#3E2723';
        $accent = '#E7993A'; $hover = '#A63C25'; $light = '#FFF7ED'; $borderLight = '#FFEDD5';
    }
@endphp

@section('content')
<!-- Panggil Library Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- MAIN CONTENT -->
<main class="flex-1 min-w-0 p-8 overflow-y-auto relative custom-scrollbar flex items-start justify-center">
    

    <div class="bg-white w-full max-w-4xl mt-4 p-8 md:p-10 rounded-[2rem] shadow-sm border border-gray-100 border-t-8 border-t-[{{ $secondary }}]">
        
        <div class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-black text-gray-900">Revenue Analytics</h1>
                <p class="text-gray-500 mt-1">Track your photo sales performance this week.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="bg-[{{ $light }}] text-[{{ $primary }}] px-6 py-2.5 rounded-xl font-bold text-sm hover:bg-[{{ $borderLight }}] transition-all border border-[{{ $borderLight }}] active:scale-95 shadow-sm">
                Back to Dashboard
            </a>
        </div>

        <!-- AREA GRAFIK -->

        <div class="bg-gray-50/50 p-6 rounded-[2rem] border border-gray-100 shadow-inner relative w-full h-[300px] md:h-[400px]">
            <canvas id="earningsChart"></canvas>
        </div>

        <!-- KARTU STATISTIK -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
            <div class="p-6 bg-white rounded-2xl border border-gray-100 border-l-4 border-l-[{{ $accent }}] shadow-sm flex flex-col justify-center">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[{{ $accent }}]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Total This Week
                </p>
                <p class="text-3xl font-black text-gray-900 mt-2">
                    Rp {{ number_format($chartData['total'], 0, ',', '.') }}
                </p>
            </div>
            
            <div class="p-6 bg-white rounded-2xl border border-gray-100 border-l-4 border-l-[{{ $primary }}] shadow-sm flex flex-col justify-center">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[{{ $primary }}]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    Average Daily
                </p>
                <p class="text-3xl font-black text-[{{ $secondary }}] mt-2">
                    Rp {{ number_format($chartData['total'] / 7, 0, ',', '.') }}
                </p>
            </div>
        </div>

    </div>
</main>

<!-- SCRIPT INISIALISASI CHART.JS -->
<script>
    // Melempar data PHP/Blade ke JavaScript Eksternal
    window.earningsConfig = {
        labels: @json($chartData['labels']),
        data: @json($chartData['data']),
        primary: '{{ $primary }}',
        secondary: '{{ $secondary }}',
        accent: '{{ $accent }}'
    };
</script>
<!-- Panggil file eksternalnya -->
<script src="{{ asset('js/earnings.js') }}"></script>

@endsection