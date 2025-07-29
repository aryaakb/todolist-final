<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Manajemen Tugas - Universitas Muhammadiyah Semarang</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'unimus-blue': '#0ea5e9',
                        'unimus-blue-dark': '#0891b2',
                        'unimus-gold': '#fbbf24',
                        'unimus-green': '#22c55e',
                    }
                }
            }
        }
    </script>
</head>
<body class="font-['Inter'] antialiased bg-gradient-to-br from-slate-900 via-blue-900 to-slate-800 min-h-screen">
    
    <!-- Background Pattern -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-1/2 -right-1/2 w-full h-full bg-gradient-to-l from-unimus-blue/5 to-transparent rounded-full blur-3xl"></div>
        <div class="absolute -bottom-1/2 -left-1/2 w-full h-full bg-gradient-to-r from-unimus-blue/5 to-transparent rounded-full blur-3xl"></div>
    </div>

    <!-- Navigation -->
    <nav class="relative z-10 p-4 sm:p-6">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center space-x-3 sm:space-x-4">
                <img src="{{ asset('image/logo-unimus-981x1024.png') }}" alt="UNIMUS Logo" class="h-10 sm:h-12 w-auto">
                <div class="text-center sm:text-left">
                    <h1 class="text-white text-lg sm:text-xl font-bold">UNIMUS</h1>
                    <p class="text-blue-200 text-xs sm:text-sm">Sistem Manajemen Tugas</p>
                </div>
            </div>
            
            @if (Route::has('login'))
                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-unimus-blue hover:bg-unimus-blue-dark text-white px-4 sm:px-6 py-2 rounded-lg font-medium transition-all duration-300 transform hover:scale-105 text-center text-sm sm:text-base">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-white hover:text-unimus-gold transition-colors duration-300 px-4 py-2 text-center text-sm sm:text-base">
                            <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-unimus-blue hover:bg-unimus-blue-dark text-white px-4 sm:px-6 py-2 rounded-lg font-medium transition-all duration-300 transform hover:scale-105 text-center text-sm sm:text-base">
                                <i class="fas fa-user-plus mr-2"></i>Daftar
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="relative z-10 flex-1 flex items-center justify-center px-4 sm:px-6 py-8 sm:py-12">
        <div class="max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                
                <!-- Left Column - Content -->
                <div class="text-center lg:text-left">
                    <div class="mb-6">
                        <span class="inline-block bg-unimus-blue/10 text-unimus-blue px-4 py-2 rounded-full text-sm font-medium border border-unimus-blue/20">
                            <i class="fas fa-graduation-cap mr-2"></i>Platform Pembelajaran Digital
                        </span>
                    </div>
                    
                    <h1 class="text-3xl sm:text-4xl lg:text-6xl font-bold text-white mb-4 sm:mb-6 leading-tight">
                        Sistem Manajemen
                        <span class="bg-gradient-to-r from-unimus-blue to-unimus-gold bg-clip-text text-transparent">
                            Tugas Mahasiswa
                        </span>
                    </h1>
                    
                    <p class="text-lg sm:text-xl text-blue-100 mb-6 sm:mb-8 leading-relaxed">
                        Platform modern untuk mengelola tugas akademik antara dosen dan mahasiswa di Universitas Muhammadiyah Semarang. Efisien, terorganisir, dan mudah digunakan.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-gradient-to-r from-unimus-blue to-unimus-blue-dark hover:from-unimus-blue-dark hover:to-blue-700 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-xl font-semibold text-base sm:text-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-center">
                                <i class="fas fa-rocket mr-2"></i>Mulai Sekarang
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="bg-gradient-to-r from-unimus-blue to-unimus-blue-dark hover:from-unimus-blue-dark hover:to-blue-700 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-xl font-semibold text-base sm:text-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-center">
                                <i class="fas fa-sign-in-alt mr-2"></i>Masuk Sistem
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="border-2 border-unimus-blue text-unimus-blue hover:bg-unimus-blue hover:text-white px-6 sm:px-8 py-3 sm:py-4 rounded-xl font-semibold text-base sm:text-lg transition-all duration-300 transform hover:scale-105 text-center">
                                    <i class="fas fa-user-plus mr-2"></i>Daftar Akun
                                </a>
                            @endif
                        @endauth
                    </div>
                    
                    @guest
                    <!-- Demo Accounts Info -->
                    <div class="mt-8 p-6 bg-white/10 backdrop-blur-md border border-white/20 rounded-xl">
                        <h3 class="text-white font-semibold mb-4 flex items-center">
                            <i class="fas fa-users mr-2 text-unimus-gold"></i>Akun Demo Tersedia
                        </h3>
                        <div class="grid md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-unimus-gold font-medium mb-2">👨‍🏫 Admin/Dosen:</p>
                                <p class="text-blue-100">saskia.wijaya@unimus.ac.id</p>
                                <p class="text-blue-100">vincent.tanujaya@unimus.ac.id</p>
                            </div>
                            <div>
                                <p class="text-unimus-gold font-medium mb-2">👨‍🎓 Mahasiswa:</p>
                                <p class="text-blue-100">alexander.wijaya@student.unimus.ac.id</p>
                                <p class="text-blue-100">clarissa.vanderliem@student.unimus.ac.id</p>
                            </div>
                        </div>
                        <p class="text-blue-200 text-xs mt-3 text-center">
                            <i class="fas fa-key mr-1"></i>Password untuk semua akun demo: <span class="font-mono bg-white/20 px-2 py-1 rounded">password123</span>
                        </p>
                    </div>
                    @endguest
                </div>
                
                <!-- Right Column - Features -->
                <div class="grid gap-6">
                    <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 hover:bg-white/15 transition-all duration-300">
                        <div class="flex items-center mb-4">
                            <div class="bg-unimus-blue/20 p-3 rounded-lg mr-4">
                                <i class="fas fa-tasks text-unimus-blue text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-white">Manajemen Tugas</h3>
                        </div>
                        <p class="text-blue-100">Kelola pemberian dan pengumpulan tugas dengan sistem yang terorganisir dan mudah digunakan.</p>
                    </div>
                    
                    <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 hover:bg-white/15 transition-all duration-300">
                        <div class="flex items-center mb-4">
                            <div class="bg-unimus-gold/20 p-3 rounded-lg mr-4">
                                <i class="fas fa-bell text-unimus-gold text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-white">Notifikasi Real-time</h3>
                        </div>
                        <p class="text-blue-100">Dapatkan pemberitahuan instant untuk tugas baru, deadline, dan update penting lainnya.</p>
                    </div>
                    
                    <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 hover:bg-white/15 transition-all duration-300">
                        <div class="flex items-center mb-4">
                            <div class="bg-unimus-green/20 p-3 rounded-lg mr-4">
                                <i class="fas fa-chart-line text-unimus-green text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-white">Analytics & Laporan</h3>
                        </div>
                        <p class="text-blue-100">Monitor progress dan kinerja dengan dashboard analytics yang komprehensif.</p>
                    </div>
                </div>
                
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="relative z-10 py-8 border-t border-white/10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-4 mb-4 md:mb-0">
                    <img src="{{ asset('image/logo-unimus-981x1024.png') }}" alt="UNIMUS Logo" class="h-8 w-auto">
                    <div class="text-sm text-blue-200">
                        <p>&copy; {{ date('Y') }} Universitas Muhammadiyah Semarang</p>
                        <p>Sistem Manajemen Tugas Mahasiswa</p>
                    </div>
                </div>
                
                <div class="text-sm text-blue-300">
                    <p>Design by <a href="https://github.com/aryaakb" target="_blank" rel="noopener noreferrer" class="text-unimus-gold hover:text-yellow-300 transition-colors underline">Arya Bintang Cahyono</a></p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Animation Script -->
    <script>
        // Add fade-in animation on load
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('main > div > div > div');
            elements.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(30px)';
                setTimeout(() => {
                    el.style.transition = 'all 0.8s ease-out';
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 200);
            });
        });
    </script>
</body>
</html>