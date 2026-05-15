@php
    $currentTheme = session('user_theme', 'autumn');
    if ($currentTheme == 'forest') {
        $bg = '#E8F3E8'; $primary = '#2D5A27'; $secondary = '#1B3022';
        $heroImage = 'https://images.unsplash.com/photo-1473448912268-2022ce9509d8?q=80&w=1600&auto=format&fit=crop';
    } elseif ($currentTheme == 'ocean') {
        $bg = '#E0F2F7'; $primary = '#076678'; $secondary = '#002B36';
        $heroImage = 'https://images.unsplash.com/photo-1505118380757-91f5f5632de0?q=80&w=1600&auto=format&fit=crop';
    } else {
        $bg = '#F4ECE6'; $primary = '#C84B31'; $secondary = '#3E2723';
        // Gambar dikembalikan ke request awal kamu
        $heroImage = 'https://images.unsplash.com/photo-1507371341162-763b5e419408?q=80&w=1600&auto=format&fit=crop';
    }
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SendYourPhotos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap');
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: {{ $bg }}; 
            transition: background-color 0.5s ease;
        }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>
<body class="p-4 md:p-6 h-screen overflow-hidden flex justify-center items-center">

    <div class="w-full max-w-[1400px] h-[90vh] bg-white rounded-[2rem] shadow-2xl flex relative border-[8px] border-white/50 overflow-hidden opacity-0 animate-fade-in-up">
        
        <div class="w-full lg:w-1/2 p-8 lg:p-12 flex flex-col relative justify-center overflow-y-auto h-full bg-white z-10 custom-scrollbar">
            
            <div class="max-w-sm w-full mx-auto py-8">
                
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Create Account</h2>
                <p class="text-sm text-gray-500 mb-6">Join our community of creators.</p>
                
                <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Full Name" class="w-full border-b-2 border-gray-100 py-2 text-gray-800 focus:outline-none focus:border-[{{ $primary }}] transition-colors bg-transparent" required>
                        @error('name') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" class="w-full border-b-2 border-gray-100 py-2 text-gray-800 focus:outline-none focus:border-[{{ $primary }}] transition-colors bg-transparent" required>
                        @error('email') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="flex gap-4">
                        <div class="w-1/2">
                            <select name="gender" class="w-full border-b-2 border-gray-100 py-2 text-gray-500 focus:text-gray-800 focus:outline-none focus:border-[{{ $primary }}] bg-transparent" required>
                                <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Select Gender</option>
                                <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Male (L)</option>
                                <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Female (P)</option>
                            </select>
                            @error('gender') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div class="w-1/2">
                            <select name="role" class="w-full border-b-2 border-gray-100 py-2 text-gray-500 focus:text-gray-800 focus:outline-none focus:border-[{{ $primary }}] bg-transparent" required>
                                <option value="" disabled>Register As</option>
                                <option value="buyer" {{ request('as') != 'contributor' ? 'selected' : '' }}>Buyer</option>
                                <option value="contributor" {{ request('as') == 'contributor' ? 'selected' : '' }}>Contributor</option>
                            </select>
                            @error('role') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="w-1/2 relative">
                            <input type="password" id="reg-password" name="password" placeholder="Password (Min. 8)" class="w-full border-b-2 border-gray-100 py-2 pr-10 text-gray-800 focus:outline-none focus:border-[{{ $primary }}] transition-colors bg-transparent" required>
                            
                            <button type="button" onclick="togglePassword('reg-password', 'eye-icon-pass')" class="absolute right-0 top-3 text-gray-400 hover:text-[{{ $primary }}] transition-colors focus:outline-none">
                                <svg id="eye-icon-pass" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                            @error('password') <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="w-1/2 relative">
                            <input type="password" id="reg-password-confirm" name="password_confirmation" placeholder="Confirm Pwd" class="w-full border-b-2 border-gray-100 py-2 pr-10 text-gray-800 focus:outline-none focus:border-[{{ $primary }}] transition-colors bg-transparent" required>
                            
                            <button type="button" onclick="togglePassword('reg-password-confirm', 'eye-icon-confirm')" class="absolute right-0 top-3 text-gray-400 hover:text-[{{ $primary }}] transition-colors focus:outline-none">
                                <svg id="eye-icon-confirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full justify-center bg-[{{ $primary }}] text-white font-bold text-lg px-8 py-3.5 rounded-full hover:bg-[{{ $secondary }}] transition-transform active:scale-[0.98] shadow-lg shadow-gray-200">
                            Create Account
                        </button>
                    </div>
                    <a href="{{ route('login') }}" class="block text-center lg:hidden text-sm font-medium text-gray-400 hover:text-[{{ $primary }}] mt-4">Sign in instead</a>
                </form>

                <div class="mt-6 flex items-center gap-4 before:h-px before:flex-1 before:bg-gray-100 after:h-px after:flex-1 after:bg-gray-100">
                    <span class="text-[11px] text-gray-400 font-bold uppercase tracking-widest">Or register with</span>
                </div>
                <div class="mt-4 grid grid-cols-2 gap-3">
                    <button type="button" class="flex items-center justify-center gap-2 px-4 py-2.5 border-2 border-gray-100 rounded-full hover:bg-gray-50 transition-colors text-sm font-semibold text-gray-600">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-4 h-4" alt="Google"> Google
                    </button>
                    <button type="button" class="flex items-center justify-center gap-2 px-4 py-2.5 border-2 border-gray-100 rounded-full hover:bg-gray-50 transition-colors text-sm font-semibold text-gray-600">
                        <svg viewBox="0 0 384 512" class="w-4 h-4 text-gray-900" fill="currentColor"><path d="M318.7 268.7c-.2-36.7 16.4-64.4 50-84.8-18.8-26.9-47.2-41.7-84.7-44.6-35.5-2.8-74.3 20.7-88.5 20.7-15 0-49.4-19.7-76.4-19.7C63.3 141.2 4 184.8 4 273.5q0 39.3 14.4 81.2c12.8 36.7 59 126.7 107.2 125.2 25.2-.6 43-17.9 75.8-17.9 31.8 0 48.3 17.9 76.4 17.9 48.6-.7 90.4-82.5 102.6-119.3-65.2-30.7-61.7-90-61.7-91.9zm-56.6-164.2c27.3-32.4 24.8-61.9 24-72.5-24.1 1.4-52 16.4-67.9 34.9-17.5 19.8-27.8 44.3-25.6 71.9 26.1 2 49.9-11.4 69.5-34.3z"/></svg> Apple
                    </button>
                </div>

            </div>
        </div>

        <div class="hidden lg:block w-1/2 p-4 h-full relative">
            <div class="w-full h-full rounded-[1.5rem] overflow-hidden relative">
                <img src="{{ $heroImage }}" alt="Visual Theme" class="w-full h-full object-cover transition-all duration-700">
                 <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                 
                 <div class="absolute top-8 right-8 z-20">
                    <a href="{{ route('login') }}" class="bg-white/90 backdrop-blur-md text-gray-900 font-semibold px-6 py-3 rounded-full hover:bg-white transition-all shadow-lg text-sm">
                        Sign in instead
                    </a>
                </div>

                <div class="absolute bottom-12 left-12 right-12 z-20">
                    <h1 class="text-[4rem] leading-[1] font-bold text-white/90 mb-4 tracking-tight drop-shadow-md">
                        Join <span class="text-[{{ $primary }}] drop-shadow-lg">Our</span> <br>Gallery.
                    </h1>
                    <p class="text-white/70 text-lg font-medium leading-relaxed max-w-md drop-shadow-sm">
                        Create an account to start buying premium photos or selling your own masterpiece.
                    </p>
                </div>
            </div>
        </div>

    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
            if (input.type === 'password') {
                input.type = 'text';
                // Ubah SVG menjadi ikon mata disilang (eye-slash)
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
            } else {
                input.type = 'password';
                // Ubah SVG kembali menjadi ikon mata terbuka (eye)
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                customClass: { popup: 'rounded-2xl shadow-xl border border-gray-100 z-[9999]' }
            });

            @if(session('success'))
                Toast.fire({ icon: 'success', title: 'Berhasil!', text: "{!! addslashes(session('success')) !!}" });
            @endif
            @if(session('error'))
                Toast.fire({ icon: 'error', title: 'Gagal', text: "{!! addslashes(session('error')) !!}" });
            @endif
            @if($errors->any())
                Toast.fire({ icon: 'error', title: 'Pendaftaran Gagal', text: "{!! addslashes($errors->first()) !!}" });
            @endif
        });
    </script>
</body>
</html>