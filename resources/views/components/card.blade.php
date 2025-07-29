@props([
    'title' => null,
    'subtitle' => null,
    'footer' => null,
    'padding' => 'md',
    'shadow' => 'md',
    'glassmorphism' => false
])

@php
$baseClasses = 'unimus-card bg-white border border-gray-200 transition-all duration-200';

$paddings = [
    'none' => '',
    'sm' => 'p-4',
    'md' => 'p-6',
    'lg' => 'p-8',
];

$shadows = [
    'none' => '',
    'sm' => 'shadow-sm',
    'md' => 'shadow-md hover:shadow-lg',
    'lg' => 'shadow-lg hover:shadow-xl',
    'xl' => 'shadow-xl hover:shadow-2xl',
];

$classes = $baseClasses . ' ' . $shadows[$shadow] . ' rounded-xl';

if ($glassmorphism) {
    $classes .= ' backdrop-blur-md bg-white/90 border-white/20';
}
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    @if($title || $subtitle)
        <div class="{{ $padding !== 'none' ? 'px-6 py-4' : '' }} {{ $footer ? 'border-b border-gray-200' : '' }}">
            @if($title)
                <h3 class="unimus-card-title text-lg font-semibold text-gray-900 mb-1">{{ $title }}</h3>
            @endif
            @if($subtitle)
                <p class="unimus-card-content text-sm text-gray-600">{{ $subtitle }}</p>
            @endif
        </div>
    @endif
    
    <div class="{{ $paddings[$padding] }}">
        {{ $slot }}
    </div>
    
    @if($footer)
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-xl">
            {{ $footer }}
        </div>
    @endif
</div>

<style>
/* Card Component Dark Mode */
body.dark-mode .unimus-card {
    background: rgba(30, 41, 59, 0.9) !important;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(75, 85, 99, 0.3) !important;
}

body.dark-mode .unimus-card-title {
    color: #f1f5f9 !important;
}

body.dark-mode .unimus-card-content {
    color: #94a3b8 !important;
}

body.dark-mode .unimus-card .bg-gray-50 {
    background: rgba(55, 65, 81, 0.5) !important;
}

body.dark-mode .unimus-card .border-gray-200 {
    border-color: rgba(75, 85, 99, 0.3) !important;
}

/* Light Mode Glass Effect */
body:not(.dark-mode) .unimus-card {
    background: rgba(255, 255, 255, 0.8) !important;
    backdrop-filter: blur(12px) saturate(180%);
    border: 1px solid rgba(255, 255, 255, 0.3) !important;
    box-shadow: 0 8px 32px rgba(31, 41, 55, 0.12), 
                0 2px 8px rgba(31, 41, 55, 0.08);
}

body:not(.dark-mode) .unimus-card-title {
    color: #111827 !important;
    text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);
}

body:not(.dark-mode) .unimus-card-content {
    color: #4b5563 !important;
}

/* Glassmorphism enhancement */
body:not(.dark-mode) .unimus-card:hover {
    background: rgba(255, 255, 255, 0.85) !important;
    transform: translateY(-2px);
    box-shadow: 0 12px 40px rgba(31, 41, 55, 0.15), 
                0 4px 12px rgba(31, 41, 55, 0.1);
}

body:not(.dark-mode) .unimus-card .bg-gray-50 {
    background: rgba(248, 250, 252, 0.8) !important;
    backdrop-filter: blur(8px);
}
</style>