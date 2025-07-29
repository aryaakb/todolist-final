@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'icon' => null,
    'iconPosition' => 'left',
    'loading' => false,
    'disabled' => false,
    'href' => null,
    'target' => null
])

@php
$baseClasses = 'inline-flex items-center justify-center font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';

$variants = [
    'primary' => 'bg-unimus-primary hover:bg-unimus-blue-dark text-white focus:ring-unimus-primary shadow-unimus',
    'secondary' => 'bg-unimus-secondary hover:bg-unimus-blue-dark text-white focus:ring-unimus-secondary',
    'outline' => 'border-2 border-unimus-primary text-unimus-primary hover:bg-unimus-primary hover:text-white focus:ring-unimus-primary',
    'ghost' => 'text-unimus-primary hover:bg-unimus-primary hover:bg-opacity-10 focus:ring-unimus-primary',
    'success' => 'bg-unimus-green hover:bg-unimus-green-dark text-white focus:ring-unimus-green',
    'warning' => 'bg-unimus-gold hover:bg-unimus-gold-dark text-white focus:ring-unimus-gold',
    'danger' => 'bg-red-500 hover:bg-red-600 text-white focus:ring-red-500',
];

$sizes = [
    'xs' => 'px-2 py-1 text-xs rounded',
    'sm' => 'px-3 py-1.5 text-sm rounded-md',
    'md' => 'px-4 py-2 text-sm rounded-lg',
    'lg' => 'px-6 py-3 text-base rounded-lg',
    'xl' => 'px-8 py-4 text-lg rounded-xl',
];

$classes = $baseClasses . ' ' . $variants[$variant] . ' ' . $sizes[$size];
$element = $href ? 'a' : 'button';
@endphp

<{{ $element }}
    @if($href) href="{{ $href }}" @endif
    @if($target) target="{{ $target }}" @endif
    @if(!$href) type="{{ $type }}" @endif
    {{ $attributes->merge(['class' => $classes]) }}
    @if($disabled || $loading) disabled @endif
    @if($loading) x-data="{ loading: true }" @endif
>
    @if($loading)
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span>Loading...</span>
    @else
        @if($icon && $iconPosition === 'left')
            <i class="{{ $icon }} mr-2"></i>
        @endif
        
        {{ $slot }}
        
        @if($icon && $iconPosition === 'right')
            <i class="{{ $icon }} ml-2"></i>
        @endif
    @endif
</{{ $element }}>