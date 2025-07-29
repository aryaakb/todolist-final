<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>UNIMUS - Sistem Manajemen Tugas Mahasiswa</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- UNIMUS Theme Styles -->
        <style>
            :root {
                --unimus-blue: #0ea5e9;
                --unimus-blue-dark: #0891b2;
                --unimus-gold: #fbbf24;
                --unimus-green: #22c55e;
            }
            
            body {
                font-family: 'Inter', sans-serif;
                background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #0f172a 100%);
                position: relative;
                overflow-x: hidden;
            }
            
            body::before {
                content: '';
                position: fixed;
                top: -50%;
                right: -50%;
                width: 100%;
                height: 100%;
                background: radial-gradient(circle, rgba(14, 165, 233, 0.1) 0%, transparent 70%);
                border-radius: 50%;
                z-index: -1;
            }
            
            body::after {
                content: '';
                position: fixed;
                bottom: -50%;
                left: -50%;
                width: 100%;
                height: 100%;
                background: radial-gradient(circle, rgba(14, 165, 233, 0.1) 0%, transparent 70%);
                border-radius: 50%;
                z-index: -1;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative z-10">
            <!-- Header Logo -->
            <div class="mb-8">
                <a href="/" class="group">
                    <div class="flex flex-col items-center text-white transition-all duration-300 group-hover:scale-105">
                        <div class="w-20 h-20 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center mb-4 shadow-2xl p-3 border border-white/20">
                            <img src="{{ asset('image/logo-unimus-981x1024.png') }}" alt="Logo UNIMUS" class="w-full h-full object-contain">
                        </div>
                        <div class="text-center">
                            <div class="font-bold text-xl mb-1">UNIMUS</div>
                            <div class="text-sm text-blue-200 font-medium">Sistem Manajemen Tugas</div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Form Container -->
            <div class="w-full sm:max-w-md px-6 py-8 bg-white/95 backdrop-blur-md shadow-2xl overflow-hidden sm:rounded-2xl border border-white/20">
                {{ $slot }}
            </div>
            
            <!-- Back to Home Link -->
            <div class="mt-6 text-center">
                <a href="/" class="text-blue-200 hover:text-white transition-colors duration-300 text-sm font-medium">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Beranda
                </a>
            </div>
        </div>
    </body>
</html>

