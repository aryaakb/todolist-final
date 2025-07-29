<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sistem Manajemen Tugas - Universitas Muhammadiyah Semarang</title>
    <link rel="icon" href="{{ asset('image/logo-unimus-981x1024.png') }}" type="image/png">

    <!-- Fonts: Menggunakan Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons: Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- UNIMUS Design System -->
    <link rel="stylesheet" href="{{ asset('css/unimus-design-system.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    
    <!-- Scripts & Styles: Menggunakan Vite (Cara Standar Laravel) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Image Optimizer -->
    <script src="{{ asset('js/image-optimizer.js') }}" defer></script>
    <!-- UNIMUS Interactions -->
    <script src="{{ asset('js/unimus-interactions.js') }}" defer></script>
    <!-- Form Validation -->
    <script src="{{ asset('js/form-validation.js') }}" defer></script>

    <!-- AlpineJS untuk interaktivitas -->
    <script src="https://cdn.jsdelivr.net/npm/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        /* Animasi Warna Latar Belakang Gelap */
        @keyframes animated-dark-gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        body.custom-bg {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(-45deg, #0369a1, #0891b2, #0ea5e9, #0284c7);
            background-size: 400% 400%;
            animation: animated-dark-gradient 25s ease infinite;
            color: #f1f5f9;
            transition: all 0.3s ease;
        }

        /* Dark Mode Styles - Comprehensive */
        body.dark-mode {
            background: linear-gradient(-45deg, #1e293b, #334155, #475569, #64748b);
            background-size: 400% 400%;
            animation: animated-dark-gradient 25s ease infinite;
            color: #f1f5f9;
        }

        /* Layout Components */
        body.dark-mode .content-section {
            background: rgba(30, 41, 59, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(75, 85, 99, 0.3);
        }

        body.dark-mode .section-header {
            background: linear-gradient(135deg, #0ea5e9 0%, #0891b2 100%);
        }

        /* Tables */
        body.dark-mode .table-container {
            background: rgba(30, 41, 59, 0.8);
            border: 1px solid rgba(75, 85, 99, 0.3);
        }

        body.dark-mode .table-container th {
            background: rgba(55, 65, 81, 0.8);
            color: #e2e8f0;
            border-bottom: 1px solid rgba(75, 85, 99, 0.5);
        }

        body.dark-mode .table-container tbody tr {
            background: rgba(30, 41, 59, 0.5);
            border-bottom-color: rgba(75, 85, 99, 0.3);
        }

        body.dark-mode .table-container tbody tr:hover {
            background: rgba(55, 65, 81, 0.7);
        }

        body.dark-mode .table-container td {
            color: #e2e8f0;
            border-bottom: 1px solid rgba(75, 85, 99, 0.3);
        }

        /* Cards */
        body.dark-mode .stats-card {
            background: rgba(30, 41, 59, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(75, 85, 99, 0.3);
        }

        body.dark-mode .content-card {
            background: rgba(30, 41, 59, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(75, 85, 99, 0.3);
        }

        /* Forms */
        body.dark-mode input[type="text"],
        body.dark-mode input[type="email"],
        body.dark-mode input[type="password"],
        body.dark-mode input[type="file"],
        body.dark-mode textarea,
        body.dark-mode select {
            background: rgba(55, 65, 81, 0.8);
            border: 1px solid rgba(75, 85, 99, 0.5);
            color: #f1f5f9;
        }

        body.dark-mode input[type="text"]:focus,
        body.dark-mode input[type="email"]:focus,
        body.dark-mode input[type="password"]:focus,
        body.dark-mode textarea:focus,
        body.dark-mode select:focus {
            border-color: #0ea5e9;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
        }

        body.dark-mode input::placeholder,
        body.dark-mode textarea::placeholder {
            color: #9ca3af;
        }

        /* Labels and Text - Dark mode only */
        body.dark-mode label {
            color: #e2e8f0;
        }

        body.dark-mode .text-gray-900 {
            color: #f1f5f9 !important;
        }

        body.dark-mode .text-gray-800 {
            color: #e2e8f0 !important;
        }

        body.dark-mode .text-gray-700 {
            color: #cbd5e1 !important;
        }

        body.dark-mode .text-gray-600 {
            color: #94a3b8 !important;
        }

        body.dark-mode .text-gray-500 {
            color: #64748b !important;
        }

        /* Ensure light mode keeps original text colors */
        body:not(.dark-mode) label {
            color: #374151;
        }

        body:not(.dark-mode) .text-gray-900 {
            color: #111827 !important;
        }

        body:not(.dark-mode) .text-gray-800 {
            color: #1f2937 !important;
        }

        body:not(.dark-mode) .text-gray-700 {
            color: #374151 !important;
        }

        body:not(.dark-mode) .text-gray-600 {
            color: #4b5563 !important;
        }

        body:not(.dark-mode) .text-gray-500 {
            color: #6b7280 !important;
        }

        /* Backgrounds - Only override in dark mode */
        body.dark-mode .bg-white {
            background: rgba(30, 41, 59, 0.9) !important;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(75, 85, 99, 0.3);
        }

        body.dark-mode .bg-gray-50 {
            background: rgba(55, 65, 81, 0.5) !important;
        }

        body.dark-mode .bg-gray-100 {
            background: rgba(75, 85, 99, 0.5) !important;
        }

        /* Ensure light mode keeps original backgrounds */
        body:not(.dark-mode) .bg-white {
            background: white !important;
        }

        body:not(.dark-mode) .bg-gray-50 {
            background: #f9fafb !important;
        }

        body:not(.dark-mode) .bg-gray-100 {
            background: #f3f4f6 !important;
        }

        /* Alerts */
        body.dark-mode .success-alert {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #86efac;
        }

        body.dark-mode .error-alert {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
        }

        /* Shadow adjustments for dark mode */
        body.dark-mode .shadow {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.3), 0 1px 2px 0 rgba(0, 0, 0, 0.2);
        }

        body.dark-mode .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2);
        }

        /* Additional Dark Mode Text and UI Element Optimizations */
        body.dark-mode .user-name-display,
        body.dark-mode .user-email-display {
            color: #e2e8f0 !important;
        }

        body.dark-mode .text-readability {
            color: #f1f5f9 !important;
        }

        body.dark-mode .self-note {
            color: #94a3b8 !important;
        }

        /* Ensure light mode custom classes remain readable */
        body:not(.dark-mode) .user-name-display,
        body:not(.dark-mode) .user-email-display {
            color: #1f2937 !important;
        }

        body:not(.dark-mode) .text-readability {
            color: #1f2937 !important;
        }

        body:not(.dark-mode) .self-note {
            color: #6b7280 !important;
        }

        /* Button optimizations for dark mode */
        body.dark-mode button[type="submit"]:not(.btn-primary) {
            background: rgba(59, 130, 246, 0.8);
            border-color: rgba(59, 130, 246, 0.5);
            color: white;
        }

        body.dark-mode button[type="submit"]:not(.btn-primary):hover {
            background: rgba(59, 130, 246, 1);
        }

        /* Ensure light mode buttons remain normal */
        body:not(.dark-mode) button[type="submit"]:not(.btn-primary) {
            background: #3b82f6;
            border-color: #3b82f6;
            color: white;
        }

        body:not(.dark-mode) button[type="submit"]:not(.btn-primary):hover {
            background: #2563eb;
        }

        /* Select dropdown dark mode */
        body.dark-mode .form-select {
            background: rgba(55, 65, 81, 0.8);
            border: 1px solid rgba(75, 85, 99, 0.5);
            color: #f1f5f9;
        }

        /* Ensure light mode selects remain normal */
        body:not(.dark-mode) .form-select {
            background: white;
            border: 1px solid #d1d5db;
            color: #1f2937;
        }

        /* Utility class overrides - Dark mode only */
        body.dark-mode .text-black {
            color: #f1f5f9 !important;
        }

        body.dark-mode .bg-gray-200 {
            background: rgba(75, 85, 99, 0.5) !important;
        }

        body.dark-mode .bg-gray-300 {
            background: rgba(107, 114, 128, 0.5) !important;
        }

        body.dark-mode .border-gray-300 {
            border-color: rgba(75, 85, 99, 0.5) !important;
        }

        body.dark-mode .border-gray-200 {
            border-color: rgba(75, 85, 99, 0.3) !important;
        }

        body.dark-mode .divide-gray-200 > :not([hidden]) ~ :not([hidden]) {
            border-color: rgba(75, 85, 99, 0.3) !important;
        }

        /* Ensure light mode keeps original utility classes */
        body:not(.dark-mode) .text-black {
            color: #000000 !important;
        }

        body:not(.dark-mode) .bg-gray-200 {
            background: #e5e7eb !important;
        }

        body:not(.dark-mode) .bg-gray-300 {
            background: #d1d5db !important;
        }

        body:not(.dark-mode) .border-gray-300 {
            border-color: #d1d5db !important;
        }

        body:not(.dark-mode) .border-gray-200 {
            border-color: #e5e7eb !important;
        }

        body:not(.dark-mode) .divide-gray-200 > :not([hidden]) ~ :not([hidden]) {
            border-color: #e5e7eb !important;
        }

        /* Light Mode Styles - Enhanced Glassmorphism */
        body.light-mode {
            background: linear-gradient(-45deg, #f8fafc, #e2e8f0, #cbd5e1, #94a3b8);
            background-size: 400% 400%;
            animation: animated-dark-gradient 25s ease infinite;
            color: #1f2937;
        }

        body.light-mode .content-section {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(226, 232, 240, 0.6);
            box-shadow: 0 8px 32px rgba(31, 41, 55, 0.1);
        }

        body.light-mode .table-container tbody tr {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(5px);
        }

        body.light-mode .stats-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(226, 232, 240, 0.6);
            box-shadow: 0 4px 16px rgba(31, 41, 55, 0.08);
        }

        body.light-mode .content-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(226, 232, 240, 0.6);
            box-shadow: 0 4px 16px rgba(31, 41, 55, 0.08);
        }

        /* Enhanced Light Mode Glassmorphism */
        body:not(.dark-mode) .bg-white {
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 24px rgba(31, 41, 55, 0.1);
        }
        
        /* Canvas untuk animasi rasi bintang */
        #constellation-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        /* PERUBAHAN: Style untuk Scrollbar Gelap */
        /* Untuk browser berbasis Webkit (Chrome, Safari, Edge) */
        ::-webkit-scrollbar {
            width: 12px;
        }
        ::-webkit-scrollbar-track {
            background: #1e293b; /* Warna track scrollbar */
        }
        ::-webkit-scrollbar-thumb {
            background-color: #475569; /* Warna thumb (pegangan) scrollbar */
            border-radius: 20px;
            border: 3px solid #1e293b; /* Memberi sedikit padding */
        }
        ::-webkit-scrollbar-thumb:hover {
            background-color: #64748b; /* Warna thumb saat di-hover */
        }

        /* Efek hover baru untuk link sidebar */
        aside nav a {
            transition: all 0.2s ease-in-out;
            border-left: 4px solid transparent;
        }

        aside nav a:hover {
            background-color: rgba(255, 255, 255, 0.08);
            border-left-color: #0ea5e9;
        }

        /* Sidebar footer integration */
        aside .border-t {
            background: linear-gradient(to right, transparent, rgba(75, 85, 99, 0.3), transparent);
            border-color: rgba(75, 85, 99, 0.4);
            position: relative;
        }

        aside .border-t::before {
            content: '';
            position: absolute;
            top: -1px;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(to right, transparent, #0ea5e9, transparent);
            opacity: 0.3;
        }
        
        /* Pastikan text terlihat jelas */
        .text-readability {
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            color: #1f2937 !important;
        }
        
        /* Override untuk text yang blur */
        * {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Warna teks copyright - Compact */
        .copyright-text {
            color: #94a3b8;
            font-weight: 400;
            font-size: 11px;
            line-height: 1.3;
        }
        
        .designer-credit {
            font-size: 10px;
            line-height: 1.2;
        }
        
        .text-shadow {
            text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
        }

        [x-cloak] { display: none !important; }
        .transition-all { transition: all 0.3s ease-in-out; }

        /* Theme Toggle Switch */
        .theme-toggle {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 30px;
        }

        .theme-toggle input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .theme-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, #0ea5e9, #0891b2);
            transition: 0.4s;
            border-radius: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .theme-slider:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 22px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        input:checked + .theme-slider {
            background: linear-gradient(135deg, #475569, #1e293b);
        }

        input:checked + .theme-slider:before {
            transform: translateX(30px);
        }

        .theme-icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 12px;
            transition: 0.3s;
        }

        .sun-icon {
            left: 8px;
            color: #fbbf24;
            opacity: 1;
        }

        .moon-icon {
            right: 8px;
            color: #e2e8f0;
            opacity: 0.5;
        }

        input:checked ~ .sun-icon {
            opacity: 0.5;
        }

        input:checked ~ .moon-icon {
            opacity: 1;
        }

        /* Compact Theme Toggle for Header */
        .theme-toggle-header {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .theme-toggle-compact {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 22px;
        }

        .theme-toggle-compact input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .theme-slider-compact {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, #0ea5e9, #0891b2);
            transition: 0.4s;
            border-radius: 22px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .theme-slider-compact:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        input:checked + .theme-slider-compact {
            background: linear-gradient(135deg, #475569, #1e293b);
        }

        input:checked + .theme-slider-compact:before {
            transform: translateX(22px);
        }

        .theme-icon-compact {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 9px;
            transition: 0.3s;
            z-index: 1;
        }

        .sun-icon-compact {
            left: 5px;
            color: #fbbf24;
            opacity: 1;
        }

        .moon-icon-compact {
            right: 5px;
            color: #e2e8f0;
            opacity: 0.5;
        }

        input:checked ~ .sun-icon-compact {
            opacity: 0.5;
        }

        input:checked ~ .moon-icon-compact {
            opacity: 1;
        }

        .theme-toggle-compact:hover .theme-slider-compact {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
            transform: translateY(-1px);
        }

        /* Sidebar Logout Button Styling */
        .sidebar-logout-btn {
            color: #cbd5e1;
            background: transparent;
            border: 1px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .sidebar-logout-btn:hover {
            background: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.2);
            color: #fca5a5;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .sidebar-logout-btn:active {
            transform: translateY(0);
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* Logout button subtle animation */
        .sidebar-logout-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(239, 68, 68, 0.1), transparent);
            transition: left 0.5s;
        }

        .sidebar-logout-btn:hover::before {
            left: 100%;
        }

        /* Dark mode logout button */
        body.dark-mode .sidebar-logout-btn {
            color: #e2e8f0;
        }

        body.dark-mode .sidebar-logout-btn:hover {
            background: rgba(239, 68, 68, 0.15);
            border-color: rgba(239, 68, 68, 0.3);
            color: #fecaca;
        }

        /* Light mode logout button */
        body:not(.dark-mode) .sidebar-logout-btn {
            color: #94a3b8;
        }

        body:not(.dark-mode) .sidebar-logout-btn:hover {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
        }

        /* Submission Details Dark Mode Fix */
        body.dark-mode .text-gray-900 {
            color: #f1f5f9 !important;
        }

        body.dark-mode .text-gray-600 {
            color: #94a3b8 !important;
        }

        body.dark-mode .text-green-900 {
            color: #86efac !important;
        }

        body.dark-mode .text-green-700 {
            color: #4ade80 !important;
        }

        body.dark-mode .text-blue-700 {
            color: #60a5fa !important;
        }

        body.dark-mode .bg-green-50 {
            background: rgba(34, 197, 94, 0.1) !important;
            border-color: rgba(34, 197, 94, 0.3) !important;
        }

        body.dark-mode .bg-blue-50 {
            background: rgba(59, 130, 246, 0.1) !important;
            border-color: rgba(59, 130, 246, 0.3) !important;
        }

        body.dark-mode .border-green-200 {
            border-color: rgba(34, 197, 94, 0.3) !important;
        }

        body.dark-mode .border-blue-200 {
            border-color: rgba(59, 130, 246, 0.3) !important;
        }

        /* Global Textarea Dark Mode Fix - BRIGHT WHITE TEXT */
        body.dark-mode textarea {
            background: rgba(55, 65, 81, 0.9) !important;
            border: 1px solid rgba(75, 85, 99, 0.5) !important;
            color: #ffffff !important;
            caret-color: #ffffff !important;
        }

        body.dark-mode textarea:focus {
            background: rgba(55, 65, 81, 0.95) !important;
            color: #ffffff !important;
            caret-color: #ffffff !important;
            border-color: #0ea5e9 !important;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1) !important;
        }

        body.dark-mode textarea::placeholder {
            color: #9ca3af !important;
            opacity: 0.7 !important;
        }

        /* Select Options Dark Mode Fix - BRIGHT WHITE TEXT */
        body.dark-mode select {
            background: rgba(55, 65, 81, 0.9) !important;
            border: 1px solid rgba(75, 85, 99, 0.5) !important;
            color: #ffffff !important;
        }

        body.dark-mode select option {
            background: rgba(55, 65, 81, 0.95) !important;
            color: #ffffff !important;
        }

        body.dark-mode select option:hover,
        body.dark-mode select option:focus,
        body.dark-mode select option:checked {
            background: rgba(14, 165, 233, 0.8) !important;
            color: #ffffff !important;
        }

        /* Input Fields Dark Mode Fix - BRIGHT WHITE TEXT */
        body.dark-mode input[type="text"],
        body.dark-mode input[type="email"],
        body.dark-mode input[type="password"],
        body.dark-mode input[type="number"],
        body.dark-mode input[type="date"],
        body.dark-mode input[type="datetime-local"],
        body.dark-mode input[type="time"],
        body.dark-mode input[type="url"],
        body.dark-mode input[type="search"] {
            background: rgba(55, 65, 81, 0.9) !important;
            border: 1px solid rgba(75, 85, 99, 0.5) !important;
            color: #ffffff !important;
            caret-color: #ffffff !important;
        }

        body.dark-mode input[type="text"]:focus,
        body.dark-mode input[type="email"]:focus,
        body.dark-mode input[type="password"]:focus,
        body.dark-mode input[type="number"]:focus,
        body.dark-mode input[type="date"]:focus,
        body.dark-mode input[type="datetime-local"]:focus,
        body.dark-mode input[type="time"]:focus,
        body.dark-mode input[type="url"]:focus,
        body.dark-mode input[type="search"]:focus {
            background: rgba(55, 65, 81, 0.95) !important;
            color: #ffffff !important;
            caret-color: #ffffff !important;
            border-color: #0ea5e9 !important;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1) !important;
        }

        body.dark-mode input::placeholder {
            color: #9ca3af !important;
            opacity: 0.7 !important;
        }

        /* File Input Dark Mode */
        body.dark-mode input[type="file"] {
            background: rgba(55, 65, 81, 0.9) !important;
            border: 1px solid rgba(75, 85, 99, 0.5) !important;
            color: #ffffff !important;
        }

        body.dark-mode input[type="file"]:focus {
            background: rgba(55, 65, 81, 0.95) !important;
            color: #ffffff !important;
            border-color: #0ea5e9 !important;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1) !important;
        }

        /* Form Labels Dark Mode */
        body.dark-mode label,
        body.dark-mode .form-group label {
            color: #e2e8f0 !important;
        }

        /* Text Colors Dark Mode */
        body.dark-mode .text-gray-500,
        body.dark-mode .text-gray-600,
        body.dark-mode .text-gray-700 {
            color: #94a3b8 !important;
        }

        /* Prevent FOUC (Flash of Unstyled Content) */
        [x-cloak] { display: none !important; }
        
        /* Logo FOUC prevention */
        img[src*="logo-unimus"] {
            max-height: 48px;
            width: auto;
        }

        /* Mobile Responsive Enhancements */
        @media (max-width: 768px) {
            /* Container padding for mobile */
            .container {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
            
            /* Form adjustments */
            .form-group input,
            .form-group select,
            .form-group textarea {
                font-size: 16px !important; /* Prevents zoom on iOS */
            }
            
            /* Card spacing */
            .space-y-6 > * + * {
                margin-top: 1.5rem !important;
            }
            
            /* Button stacking */
            .flex.gap-4 {
                flex-direction: column !important;
            }
            
            /* Table horizontal scroll */
            .table-wrapper {
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch !important;
            }
            
            /* Mobile table cards */
            .table-container table,
            .dashboard-wrapper table {
                display: block !important;
                overflow-x: auto !important;
                white-space: nowrap !important;
            }
            
            .table-container thead,
            .dashboard-wrapper thead {
                display: block !important;
                position: sticky !important;
                top: 0 !important;
                background: var(--card-bg, rgba(255, 255, 255, 0.9)) !important;
                z-index: 10 !important;
            }
            
            .table-container tbody,
            .dashboard-wrapper tbody {
                display: block !important;
            }
            
            .table-container tr,
            .dashboard-wrapper tr {
                display: block !important;
                border: 1px solid var(--border-color, #e5e7eb) !important;
                border-radius: 0.5rem !important;
                margin-bottom: 0.75rem !important;
                padding: 1rem !important;
                background: var(--card-bg, rgba(255, 255, 255, 0.9)) !important;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
            }
            
            .table-container th,
            .table-container td,
            .dashboard-wrapper th,
            .dashboard-wrapper td {
                display: block !important;
                text-align: left !important;
                padding: 0.5rem 0 !important;
                border: none !important;
                white-space: normal !important;
            }
            
            .table-container th,
            .dashboard-wrapper th {
                display: none !important; /* Hide headers in mobile card view */
            }
            
            /* Add labels for mobile */
            .table-container td:before,
            .dashboard-wrapper td:before {
                content: attr(data-label) ": " !important;
                font-weight: 600 !important;
                color: var(--text-secondary, #6b7280) !important;
                display: inline-block !important;
                width: auto !important;
                margin-right: 0.5rem !important;
            }
            
            /* Font size adjustments */
            h1, .text-2xl {
                font-size: 1.75rem !important;
            }
            
            h2, .text-xl {
                font-size: 1.5rem !important;
            }
            
            h3, .text-lg {
                font-size: 1.25rem !important;
            }
        }
        
        @media (max-width: 640px) {
            /* Extra small mobile adjustments */
            .px-4 {
                padding-left: 0.75rem !important;
                padding-right: 0.75rem !important;
            }
            
            .py-4 {
                padding-top: 0.75rem !important;
                padding-bottom: 0.75rem !important;
            }
            
            /* Grid to single column */
            .grid-cols-2 {
                grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
            }
            
            .grid-cols-3 {
                grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
            }
            
            /* Touch targets */
            button, a, input, select, textarea {
                min-height: 44px !important;
                min-width: 44px !important;
            }
            
            /* Prevent horizontal scroll */
            body {
                overflow-x: hidden !important;
            }
            
            /* Mobile-friendly spacing */
            .p-6 {
                padding: 1rem !important;
            }
            
            .p-8 {
                padding: 1.5rem !important;
            }
            
            .m-6 {
                margin: 1rem !important;
            }
            
            .gap-6 {
                gap: 1rem !important;
            }
        }
    </style>
</head>
<body class="custom-bg" x-data="{ darkMode: $persist(false) }" 
      :class="darkMode ? 'dark-mode' : 'custom-bg'">

    <canvas id="constellation-canvas"></canvas>

    <div x-data="{ 
        sidebarOpen: window.innerWidth >= 1024 ? $persist(true) : $persist(false),
        isMobile: window.innerWidth < 1024 
    }" 
    x-init="
        $watch('sidebarOpen', value => { if (isMobile && value) { document.body.style.overflow = 'hidden'; } else { document.body.style.overflow = ''; } });
        window.addEventListener('resize', () => { 
            isMobile = window.innerWidth < 1024; 
            if (!isMobile && sidebarOpen) { document.body.style.overflow = ''; }
        });
    " 
    class="flex h-screen bg-transparent relative">
        
        <!-- Mobile Overlay -->
        <div x-show="isMobile && sidebarOpen" x-cloak @click="sidebarOpen = false" 
             class="fixed inset-0 bg-black bg-opacity-50 z-[20000] lg:hidden"></div>

        <!-- Sidebar -->
        <aside 
            class="bg-[#1e293b]/80 backdrop-blur-md text-white transition-all duration-300 border-r border-slate-700/50"
            :class="{
                'fixed inset-y-0 left-0 z-[25000] w-64': isMobile,
                'flex-shrink-0': !isMobile,
                'w-64': sidebarOpen && !isMobile,
                'w-16': !sidebarOpen && !isMobile,
                'translate-x-0': sidebarOpen,
                '-translate-x-full': !sidebarOpen && isMobile
            }"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full">
            
            <div class="flex flex-col h-full">
                <!-- Expanded Sidebar Header -->
                <div x-show="sidebarOpen" class="flex items-center justify-between h-20 border-b border-gray-700 p-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('image/logo-unimus-981x1024.png') }}" alt="Logo UNIMUS" 
                             class="h-12 w-auto transition-all duration-300">
                        <div class="text-white">
                            <div class="font-bold text-sm">UNIMUS</div>
                            <div class="text-xs text-gray-300">Semarang</div>
                        </div>
                    </div>
                    <!-- Toggle Button in Sidebar -->
                    <button @click.stop="sidebarOpen = !sidebarOpen" 
                            class="text-slate-300 hover:text-white transition-colors focus:outline-none p-2 rounded-lg hover:bg-slate-700/50">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                </div>
                
                <!-- Collapsed Sidebar Header with Toggle -->
                <div x-show="!sidebarOpen && !isMobile" class="flex flex-col items-center border-b border-gray-700">
                    <div class="flex items-center justify-center h-16 p-2">
                        <img src="{{ asset('image/logo-unimus-981x1024.png') }}" alt="Logo UNIMUS" 
                             class="h-8 w-auto transition-all duration-300">
                    </div>
                    <div class="pb-3">
                        <button @click.stop="sidebarOpen = !sidebarOpen" 
                                class="text-slate-300 hover:text-white transition-colors focus:outline-none p-2 rounded-lg hover:bg-slate-700/50"
                                title="Buka Sidebar">
                            <i class="fas fa-bars text-base"></i>
                        </button>
                    </div>
                </div>

                <nav class="flex-1 px-2 py-4 space-y-2">
                    <a href="{{ route('dashboard') }}" @click="isMobile && (sidebarOpen = false)" title="Dashboard" 
                       :class="sidebarOpen || !isMobile ? 'justify-start' : 'justify-center'" 
                       class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('dashboard') ? 'bg-slate-700' : '' }}">
                        <i class="fas fa-home-alt w-6 text-center"></i>
                        <span class="ml-3" x-show="sidebarOpen || isMobile">Dashboard</span>
                    </a>
                    <a href="{{ route('tasks.index') }}" @click="isMobile && (sidebarOpen = false)" title="Pengumpulan Tugas" 
                       :class="sidebarOpen || !isMobile ? 'justify-start' : 'justify-center'" 
                       class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('tasks.*') ? 'bg-slate-700' : '' }}">
                        <i class="fas fa-file-upload w-6 text-center"></i>
                        <span class="ml-3" x-show="sidebarOpen || isMobile">Pengumpulan Tugas</span>
                    </a>

                    @if(Auth::user()->isAdmin())
                    <a href="{{ route('team.index') }}" @click="isMobile && (sidebarOpen = false)" title="Mahasiswa" 
                       :class="sidebarOpen || !isMobile ? 'justify-start' : 'justify-center'" 
                       class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('team.*') ? 'bg-slate-700' : '' }}">
                        <i class="fas fa-graduation-cap w-6 text-center"></i>
                        <span class="ml-3" x-show="sidebarOpen || isMobile">Mahasiswa</span>
                    </a>
                    <a href="{{ route('analytics.index') }}" @click="isMobile && (sidebarOpen = false)" title="Laporan" 
                       :class="sidebarOpen || !isMobile ? 'justify-start' : 'justify-center'" 
                       class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('analytics.*') ? 'bg-slate-700' : '' }}">
                        <i class="fas fa-chart-line w-6 text-center"></i>
                        <span class="ml-3" x-show="sidebarOpen || isMobile">Laporan</span>
                    </a>
                    @endif

                </nav>

                <div class="p-4 mt-auto border-t border-gray-700/50">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" title="Logout" 
                                :class="sidebarOpen || !isMobile ? 'justify-start' : 'justify-center'"
                                class="sidebar-logout-btn w-full flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 hover:bg-red-500/10 hover:text-red-400 group">
                            <i class="fas fa-sign-out-alt w-6 text-center group-hover:scale-110 transition-transform duration-200"></i>
                            <span class="ml-3 font-medium" x-show="sidebarOpen">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-slate-900/50 backdrop-blur-md px-4 py-2 flex justify-between items-center border-b border-slate-700/50 relative z-[10000]">
                <div class="flex items-center gap-3">
                    <h1 class="text-xl font-semibold text-slate-100">@yield('header', 'Dashboard')</h1>
                </div>
                
                <div class="flex items-center space-x-3">
                    <!-- Hamburger Toggle in Header -->
                    <button @click.stop="sidebarOpen = !sidebarOpen" 
                            class="text-slate-300 hover:text-white transition-colors focus:outline-none p-2 rounded-lg hover:bg-slate-700/50"
                            title="Toggle Sidebar">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                    
                    <!-- Theme Toggle -->
                    <div class="theme-toggle-header">
                        <label class="theme-toggle-compact">
                            <input type="checkbox" x-model="darkMode">
                            <span class="theme-slider-compact">
                                <i class="fas fa-sun theme-icon-compact sun-icon-compact"></i>
                                <i class="fas fa-moon theme-icon-compact moon-icon-compact"></i>
                            </span>
                        </label>
                    </div>
                    
                    @auth
                    <div x-data="{ open: false }" class="relative z-[9999]">
                        <button @click="open = !open" class="focus:outline-none">
                            <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=3b82f6&color=FFFFFF' }}" alt="{{ Auth::user()->name }}" class="w-8 h-8 rounded-full object-cover">
                        </button>
                        
                        <div x-cloak x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-slate-800 rounded-md shadow-lg py-1 z-[9999] border border-slate-700">
                            <div class="px-4 py-2 text-sm text-slate-300 border-b border-slate-700">
                                <p class="font-semibold text-slate-100">{{ Auth::user()->name }}</p>
                                <p class="text-xs">{{ Auth::user()->isAdmin() ? 'Dosen/Admin' : 'Mahasiswa' }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-300 hover:bg-slate-700">Profil Saya</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-slate-300 hover:bg-slate-700">Logout</button>
                            </form>
                        </div>
                    </div>
                    @endauth
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-6">
                <!-- Toast Notifications -->
                @if(session('success'))
                    <div data-success-message="{{ session('success') }}" class="hidden"></div>
                @endif
                @if(session('error'))
                    <div data-error-message="{{ session('error') }}" class="hidden"></div>
                @endif
                @if(session('warning'))
                    <div data-warning-message="{{ session('warning') }}" class="hidden"></div>
                @endif
                @if(session('info'))
                    <div data-info-message="{{ session('info') }}" class="hidden"></div>
                @endif
                
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="py-2 px-4 bg-slate-900/50 backdrop-blur-md text-center text-xs border-t border-slate-700/50">
                <p class="copyright-text leading-tight">© {{ date('Y') }} Universitas Muhammadiyah Semarang - Sistem Manajemen Tugas</p>
                <p class="designer-credit mt-1 text-xs opacity-75">
                    Design by <a href="https://github.com/aryaakb" target="_blank" rel="noopener noreferrer" class="text-blue-400 hover:text-blue-300 transition-colors">Arya Bintang Cahyono</a>
                </p>
            </footer>
        </div>
    </div>

    <!-- AI Chatbot for Admin/Dosen Only -->
    @if(auth()->user()->isAdmin())
    <div id="ai-chatbot" class="fixed bottom-4 right-4 z-30">
        <!-- Chatbot Toggle Button -->
        <button id="chatbot-toggle" class="bg-gradient-to-r from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 text-white rounded-full p-4 shadow-lg transition-all duration-300 hover:scale-110">
            <i class="fas fa-robot text-xl"></i>
        </button>
        
        <!-- Chatbot Window -->
        <div id="chatbot-window" class="hidden absolute bottom-16 right-0 w-96 h-[500px] bg-white rounded-lg shadow-2xl border border-gray-200 overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-sky-500 to-sky-600 text-white p-4 flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-robot"></i>
                    <span class="font-semibold">AI Assistant UNIMUS</span>
                </div>
                <button id="chatbot-close" class="text-white hover:text-gray-200 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <!-- Chat Messages -->
            <div id="chat-messages" class="flex-1 p-4 h-80 overflow-y-auto bg-gray-100">
                <div class="mb-4">
                    <div class="bg-white border border-sky-200 text-gray-800 p-4 rounded-lg text-sm shadow-sm">
                        <i class="fas fa-robot mr-2"></i>
                        Halo! Saya AI Assistant UNIMUS untuk membantu Anda mengelola sistem. 
                        <br><br>
                        🚀 <strong>Perintah Populer:</strong>
                        <br>
                        • "statistik" - Lihat statistik sistem
                        <br>
                        • "daftar user" - Tampilkan semua pengguna
                        <br>
                        • "tugas pending" - Tugas yang belum selesai
                        <br>
                        • "bantuan" - Lihat semua perintah
                    </div>
                </div>
            </div>
            
            <!-- Input Area -->
            <div class="p-4 border-t border-gray-200 bg-white">
                <div class="flex space-x-2">
                    <input type="text" id="chat-input" placeholder="Ketik perintah Anda..." class="flex-1 border-2 border-gray-300 rounded-lg px-4 py-3 text-sm text-gray-800 bg-white focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500" style="color: #1f2937 !important; background-color: #ffffff !important;">
                    <button id="chat-send" class="bg-sky-500 hover:bg-sky-600 text-white px-5 py-3 rounded-lg transition-colors font-medium shadow-sm">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @stack('scripts')
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const canvas = document.getElementById('constellation-canvas');
            const ctx = canvas.getContext('2d');
            let stars = [];
            let animationFrameId;

            function setCanvasSize() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            }

            function createStars() {
                stars = [];
                const starCount = Math.floor((canvas.width * canvas.height) / 10000);
                for (let i = 0; i < starCount; i++) {
                    stars.push({
                        x: Math.random() * canvas.width,
                        y: Math.random() * canvas.height,
                        radius: Math.random() * 1.5 + 0.5,
                        vx: (Math.random() - 0.5) * 0.3,
                        vy: (Math.random() - 0.5) * 0.3,
                        opacity: Math.random() * 0.5 + 0.2
                    });
                }
            }

            function draw() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                stars.forEach(star => {
                    ctx.beginPath();
                    ctx.arc(star.x, star.y, star.radius, 0, Math.PI * 2);
                    ctx.fillStyle = `rgba(255, 255, 255, ${star.opacity})`;
                    ctx.fill();
                });

                ctx.beginPath();
                for (let i = 0; i < stars.length; i++) {
                    for (let j = i; j < stars.length; j++) {
                        const dist = Math.sqrt(Math.pow(stars[i].x - stars[j].x, 2) + Math.pow(stars[i].y - stars[j].y, 2));
                        if (dist < 120) {
                            ctx.moveTo(stars[i].x, stars[i].y);
                            ctx.lineTo(stars[j].x, stars[j].y);
                            ctx.strokeStyle = `rgba(255, 255, 255, ${(1 - dist / 120) * 0.3})`;
                        }
                    }
                }
                ctx.stroke();
            }

            function update() {
                stars.forEach(star => {
                    star.x += star.vx;
                    star.y += star.vy;

                    if (star.x < 0 || star.x > canvas.width) star.vx *= -1;
                    if (star.y < 0 || star.y > canvas.height) star.vy *= -1;
                });
            }

            function animate() {
                draw();
                update();
                animationFrameId = requestAnimationFrame(animate);
            }

            function init() {
                setCanvasSize();
                createStars();
                if (animationFrameId) {
                    cancelAnimationFrame(animationFrameId);
                }
                animate();
            }

            init();

            window.addEventListener('resize', init);
        });

        // AI Chatbot Functionality
        @if(auth()->user()->isAdmin())
        const chatbotToggle = document.getElementById('chatbot-toggle');
        const chatbotWindow = document.getElementById('chatbot-window');
        const chatbotClose = document.getElementById('chatbot-close');
        const chatInput = document.getElementById('chat-input');
        const chatSend = document.getElementById('chat-send');
        const chatMessages = document.getElementById('chat-messages');

        let isTyping = false;

        // Toggle chatbot window
        chatbotToggle.addEventListener('click', () => {
            chatbotWindow.classList.toggle('hidden');
            if (!chatbotWindow.classList.contains('hidden')) {
                setTimeout(() => {
                    chatInput.focus();
                    chatInput.select();
                }, 100);
            }
        });

        // Close chatbot window
        chatbotClose.addEventListener('click', () => {
            chatbotWindow.classList.add('hidden');
        });

        // Send message on Enter key
        chatInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !isTyping) {
                sendMessage();
            }
        });

        // Send message on button click
        chatSend.addEventListener('click', () => {
            if (!isTyping) {
                sendMessage();
            }
        });

        // Add message to chat
        function addMessage(message, isUser = false) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `mb-3 ${isUser ? 'text-right' : 'text-left'}`;
            
            const messageBubble = document.createElement('div');
            messageBubble.className = isUser 
                ? 'inline-block bg-sky-500 text-white p-3 rounded-lg text-sm max-w-xs shadow-sm font-medium' 
                : 'inline-block bg-white border border-gray-300 text-gray-800 p-3 rounded-lg text-sm max-w-xs shadow-sm';
            
            if (!isUser) {
                messageBubble.innerHTML = `<i class="fas fa-robot mr-2"></i>${message}`;
            } else {
                messageBubble.textContent = message;
            }
            
            messageDiv.appendChild(messageBubble);
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Show typing indicator
        function showTyping() {
            const typingDiv = document.createElement('div');
            typingDiv.id = 'typing-indicator';
            typingDiv.className = 'mb-3 text-left';
            typingDiv.innerHTML = `
                <div class="inline-block bg-white border border-gray-300 text-gray-700 p-3 rounded-lg text-sm shadow-sm">
                    <i class="fas fa-robot mr-2 text-sky-500"></i>
                    <span class="typing-dots">
                        <span>.</span><span>.</span><span>.</span>
                    </span> Sedang mengetik...
                </div>
            `;
            chatMessages.appendChild(typingDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Remove typing indicator
        function hideTyping() {
            const typing = document.getElementById('typing-indicator');
            if (typing) {
                typing.remove();
            }
        }

        // Send message to server
        async function sendMessage() {
            const message = chatInput.value.trim();
            if (!message) return;

            // Add user message
            addMessage(message, true);
            chatInput.value = '';
            isTyping = true;
            chatSend.disabled = true;
            chatInput.disabled = true;

            // Show typing indicator
            showTyping();

            try {
                const response = await fetch('{{ route("ai.command") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ command: message })
                });

                const data = await response.json();
                
                // Simulate typing delay
                setTimeout(() => {
                    hideTyping();
                    addMessage(data.reply);
                    
                    // If success status, reload page after showing message
                    if (data.status === 'success') {
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    }
                    
                    isTyping = false;
                    chatSend.disabled = false;
                    chatInput.disabled = false;
                    chatInput.focus();
                }, 1000);

            } catch (error) {
                hideTyping();
                addMessage('Maaf, terjadi kesalahan. Silakan coba lagi.');
                isTyping = false;
                chatSend.disabled = false;
                chatInput.disabled = false;
                chatInput.focus();
            }
        }

        // Add CSS for typing animation and input styling
        const style = document.createElement('style');
        style.textContent = `
            .typing-dots span {
                animation: typing 1.4s infinite;
                animation-fill-mode: both;
            }
            .typing-dots span:nth-child(2) {
                animation-delay: 0.2s;
            }
            .typing-dots span:nth-child(3) {
                animation-delay: 0.4s;
            }
            @keyframes typing {
                0%, 60%, 100% {
                    transform: translateY(0);
                }
                30% {
                    transform: translateY(-10px);
                }
            }
            
            /* Chatbot Input Styling */
            #chat-input {
                color: #1f2937 !important;
                background-color: #ffffff !important;
                font-weight: 500;
                letter-spacing: 0.01em;
            }
            
            #chat-input::placeholder {
                color: #9ca3af !important;
                font-weight: 400;
            }
            
            #chat-input:focus {
                color: #1f2937 !important;
                background-color: #ffffff !important;
                box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1) !important;
            }
            
            #chat-input:disabled {
                color: #6b7280 !important;
                background-color: #f9fafb !important;
                opacity: 0.7;
            }
            
            #chat-send:disabled {
                opacity: 0.5;
                cursor: not-allowed;
            }
            
            /* Better message styling */
            #chat-messages {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            }
            
            /* Scrollbar styling */
            #chat-messages::-webkit-scrollbar {
                width: 6px;
            }
            
            #chat-messages::-webkit-scrollbar-track {
                background: #f1f5f9;
                border-radius: 3px;
            }
            
            #chat-messages::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 3px;
            }
            
            #chat-messages::-webkit-scrollbar-thumb:hover {
                background: #94a3b8;
            }
        `;
        document.head.appendChild(style);
        @endif
    </script>
</body>
</html>
