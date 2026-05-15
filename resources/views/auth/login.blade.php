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
    <title>Login - SendYourPhotos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap');
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: {{ $bg }}; 
            transition: background-color 0.5s ease;
        }

        /* Animasi Entrance Premium */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>
<body class="p-4 md:p-6 h-screen overflow-hidden flex justify-center items-center">

    <div class="w-full max-w-[1400px] h-[90vh] bg-white rounded-[2rem] shadow-2xl flex relative border-[8px] border-white/50 overflow-hidden opacity-0 animate-fade-in-up">
        
        <div class="w-full lg:w-1/2 p-8 lg:p-20 flex flex-col relative justify-center bg-white z-10 overflow-y-auto">
            
            <div class="absolute top-8 left-8 lg:top-12 lg:left-16 flex items-center gap-3 cursor-pointer group">
                <div class="w-10 h-10 bg-[{{ $primary }}] rounded-xl flex items-center justify-center text-white shadow-lg shadow-gray-200 group-hover:-rotate-12 transition-transform duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path d="M12.963 2.286a.75.75 0 00-1.071-.136 9.742 9.742 0 00-3.539 6.177A7.547 7.547 0 016.648 6.61a.75.75 0 00-1.152.082A9 9 0 1015.68 4.534a7.46 7.46 0 01-2.717-2.248z" />
                    </svg>
                </div>
                <span class="font-bold text-gray-900 tracking-tight text-lg">SendYourPhotos</span>
            </div>

            <div class="max-w-sm w-full mt-12 mx-auto">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Sign In</h2>
                <p class="text-sm text-gray-500 mb-8">Please enter your details to proceed.</p>

                <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                    @csrf 
                    <div>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" class="w-full border-b-2 border-gray-100 py-3 text-gray-800 focus:outline-none focus:border-[{{ $primary }}] transition-colors bg-transparent text-base lg:text-lg" required>
                    </div>
                    <div>
                        <input type="password" name="password" placeholder="Password" class="w-full border-b-2 border-gray-100 py-3 text-gray-800 focus:outline-none focus:border-[{{ $primary }}] transition-colors bg-transparent text-base lg:text-lg" required>
                    </div>

                    <div class="flex items-center justify-between mt-4 mb-6">
                        <label class="flex items-center gap-2 text-sm text-gray-500 cursor-pointer hover:text-gray-700">
                            <input type="checkbox" name="remember" class="w-4 h-4 accent-[{{ $primary }}] rounded border-gray-300">
                            Remember me
                        </label>
                        <a href="{{ route('password.request') }}" class="text-sm font-medium text-[{{ $primary }}] hover:text-[{{ $secondary }}] hover:underline">Forgot password?</a>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full justify-center bg-[{{ $primary }}] text-white font-bold text-lg px-8 py-3.5 rounded-full hover:bg-[{{ $secondary }}] transition-transform active:scale-[0.98] shadow-lg shadow-gray-200">
                            Sign In
                        </button>
                    </div>
                </form>

                <div class="mt-8 flex items-center gap-4 before:h-px before:flex-1 before:bg-gray-100 after:h-px after:flex-1 after:bg-gray-100">
                    <span class="text-[11px] text-gray-400 font-bold uppercase tracking-widest">Or continue with</span>
                </div>
                
                <div class="mt-6 grid grid-cols-2 gap-3">
                    <button type="button" class="flex items-center justify-center gap-2 px-4 py-2.5 border-2 border-gray-100 rounded-full hover:bg-gray-50 transition-colors text-sm font-semibold text-gray-600">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-4 h-4" alt="Google"> Google
                    </button>
                    <button type="button" class="flex items-center justify-center gap-2 px-4 py-2.5 border-2 border-gray-100 rounded-full hover:bg-gray-50 transition-colors text-sm font-semibold text-gray-600">
                        <svg viewBox="0 0 384 512" class="w-4 h-4 text-gray-900" fill="currentColor"><path d="M318.7 268.7c-.2-36.7 16.4-64.4 50-84.8-18.8-26.9-47.2-41.7-84.7-44.6-35.5-2.8-74.3 20.7-88.5 20.7-15 0-49.4-19.7-76.4-19.7C63.3 141.2 4 184.8 4 273.5q0 39.3 14.4 81.2c12.8 36.7 59 126.7 107.2 125.2 25.2-.6 43-17.9 75.8-17.9 31.8 0 48.3 17.9 76.4 17.9 48.6-.7 90.4-82.5 102.6-119.3-65.2-30.7-61.7-90-61.7-91.9zm-56.6-164.2c27.3-32.4 24.8-61.9 24-72.5-24.1 1.4-52 16.4-67.9 34.9-17.5 19.8-27.8 44.3-25.6 71.9 26.1 2 49.9-11.4 69.5-34.3z"/></svg> Apple
                    </button>
                </div>

                <a href="{{ route('register') }}" class="block text-center mt-6 lg:hidden text-sm font-medium text-gray-400 hover:text-[{{ $primary }}]">Create Account</a>
            </div>
        </div>

        <div class="hidden lg:block w-1/2 p-4 h-full relative">
            <div class="w-full h-full rounded-[1.5rem] overflow-hidden relative">
                <!-- GAMBAAR DINAMIS SESUAI TEMA -->
                <img src="{{ $heroImage }}" alt="Login Visual Theme" class="w-full h-full object-cover transition-all duration-700">
                
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                
                <div class="absolute top-8 right-8 z-20">
                    <a href="{{ route('register') }}" class="bg-white/90 backdrop-blur-md text-gray-900 font-semibold px-6 py-3 rounded-full hover:bg-white transition-all shadow-lg text-sm">
                        Create Account
                    </a>
                </div>

                <div class="absolute bottom-12 left-12 right-12 z-20">
                    <h1 class="text-[4rem] leading-[1] font-bold text-white/90 mb-4 tracking-tight drop-shadow-md">
                        Welcome <br>
                        <span class="text-[{{ $primary }}] drop-shadow-lg">Back.</span>
                    </h1>
                    <p class="text-white/70 text-lg font-medium leading-relaxed max-w-md drop-shadow-sm">
                        Access your digital portfolio, monitor sales, and grow your photography business.
                    </p>
                </div>

            </div>
        </div>

    </div>

    <!-- ALERT LOGIN -->
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
                Toast.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{!! addslashes(session('success')) !!}"
                });
            @endif

            @if(session('error'))
                Toast.fire({
                    icon: 'error',
                    title: 'Akses Ditolak',
                    text: "{!! addslashes(session('error')) !!}"
                });
            @endif

            @if($errors->any())
                Toast.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "{!! addslashes($errors->first()) !!}"
                });
            @endif
        });
    </script>
</body>
</html>