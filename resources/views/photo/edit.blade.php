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

    // Variabel Penyingkat Class Tailwind untuk Form (REFACTORING)
    $labelStyle = "block text-xs font-bold text-[{$secondary}] uppercase tracking-wider mb-2";
    $inputStyle = "w-full px-5 py-4 rounded-2xl bg-gray-50 border border-gray-200 focus:bg-white focus:border-[{$primary}] focus:ring-4 focus:ring-[{$primary}]/10 outline-none font-medium transition-all";
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Foto - SendYourPhotos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: {{ $bg }}; 
            transition: background-color 0.5s ease;
        }
    </style>
</head>
<body class="antialiased text-gray-900 min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-5xl bg-white rounded-[3rem] shadow-2xl overflow-hidden flex flex-col md:flex-row border-[6px] border-[{{ $secondary }}]">
        
        <!-- Sisi Kiri: Preview Foto Asli -->
        <div class="w-full md:w-1/2 bg-[{{ $light }}] p-10 flex flex-col items-center justify-center relative border-r border-[{{ $borderLight }}]">
            
            <!-- TOMBOL BACK TO DASHBOARD -->
            <a href="{{ route('dashboard') }}" class="absolute top-8 left-8 flex items-center gap-2 text-xs font-bold text-[{{ $primary }}] bg-white border border-[{{ $borderLight }}] px-5 py-2.5 rounded-xl shadow-sm hover:bg-[{{ $primary }}] hover:text-white transition-all duration-300 z-10 active:scale-95 uppercase tracking-wider">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Back to Dashboard
            </a>

            <div class="w-full aspect-[4/5] rounded-[2rem] overflow-hidden shadow-lg border-4 border-white mt-12 relative group">
                <img src="{{ asset('storage/' . $photo->file_path) }}" class="w-full h-full object-cover select-none pointer-events-none transition-transform duration-700 group-hover:scale-105" oncontextmenu="return false;" draggable="false">
                <div class="absolute inset-0 z-20 bg-gradient-to-t from-[{{ $secondary }}]/50 to-transparent" oncontextmenu="return false;"></div>
                <div class="absolute bottom-6 left-0 w-full text-center z-30">
                    <span class="bg-white/90 backdrop-blur-md text-[{{ $primary }}] text-xs font-extrabold px-4 py-2 rounded-full shadow-lg flex items-center gap-2 w-max mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        Visual Terkunci
                    </span>
                </div>
            </div>
        </div>

        <!-- Sisi Kanan: Form Edit Detail -->
        <div class="w-full md:w-1/2 p-10 lg:p-14 bg-white flex flex-col justify-center">
            <h2 class="text-3xl font-black text-[{{ $secondary }}] mb-2 tracking-tight">Edit Masterpiece</h2>
            <p class="text-gray-500 text-sm mb-8">Perbarui informasi karya Anda agar lebih menarik minat kolektor.</p>

            <form action="{{ route('photo.update', $photo->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Judul -->
                <div>
                    <label class="{{ $labelStyle }}">Judul Fotografi</label>
                    <input type="text" name="title" value="{{ $photo->title }}" required class="{{ $inputStyle }}" placeholder="Masukkan judul foto...">
                </div>

                <!-- Kategori & Harga -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="{{ $labelStyle }}">Kategori</label>
                        <select name="category_id" required class="{{ $inputStyle }} appearance-none">
                            <option value="1" {{ $photo->category_id == 1 ? 'selected' : '' }}>Nature</option>
                            <option value="2" {{ $photo->category_id == 2 ? 'selected' : '' }}>Architecture</option>
                            <option value="3" {{ $photo->category_id == 3 ? 'selected' : '' }}>Street</option>
                        </select>
                    </div>
                    <div>
                        <label class="{{ $labelStyle }}">Harga (Rp)</label>
                        <input type="number" name="price" value="{{ $photo->price }}" required class="{{ $inputStyle }}" placeholder="0">
                    </div>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="{{ $labelStyle }}">Cerita di Balik Lensa</label>
                    <textarea name="description" rows="4" class="{{ $inputStyle }} resize-none" placeholder="Ceritakan kisah menarik tentang foto ini...">{{ $photo->description }}</textarea>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="w-full bg-[{{ $primary }}] text-white font-black text-lg py-4 rounded-2xl hover:bg-[{{ $hover }}] transition-all shadow-xl shadow-[{{ $primary }}]/20 active:scale-[0.98] mt-4 flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</body>
</html>