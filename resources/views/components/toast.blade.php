@props([
    'type' => 'success',
    'title' => null,
    'dismissible' => true,
    'duration' => 5000
])

@php
$types = [
    'success' => [
        'bg' => 'bg-green-50',
        'border' => 'border-green-400',
        'text' => 'text-green-800',
        'icon' => 'fas fa-check-circle text-green-400',
    ],
    'error' => [
        'bg' => 'bg-red-50',
        'border' => 'border-red-400', 
        'text' => 'text-red-800',
        'icon' => 'fas fa-exclamation-circle text-red-400',
    ],
    'warning' => [
        'bg' => 'bg-yellow-50',
        'border' => 'border-yellow-400',
        'text' => 'text-yellow-800', 
        'icon' => 'fas fa-exclamation-triangle text-yellow-400',
    ],
    'info' => [
        'bg' => 'bg-blue-50',
        'border' => 'border-blue-400',
        'text' => 'text-blue-800',
        'icon' => 'fas fa-info-circle text-blue-400',
    ],
];

$config = $types[$type];
$classes = "fixed top-4 right-4 max-w-sm w-full {$config['bg']} border {$config['border']} {$config['text']} px-4 py-3 rounded-lg shadow-lg z-toast animate-slide-in-right";
@endphp

<div 
    x-data="{ 
        show: true,
        init() {
            @if($duration > 0)
                setTimeout(() => this.show = false, {{ $duration }})
            @endif
        }
    }"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="transform translate-x-full opacity-0"
    x-transition:enter-end="transform translate-x-0 opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="transform translate-x-0 opacity-100"
    x-transition:leave-end="transform translate-x-full opacity-0"
    {{ $attributes->merge(['class' => $classes]) }}
    role="alert"
>
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <i class="{{ $config['icon'] }}"></i>
        </div>
        
        <div class="ml-3 flex-1">
            @if($title)
                <h4 class="font-medium mb-1">{{ $title }}</h4>
            @endif
            <div class="text-sm">
                {{ $slot }}
            </div>
        </div>
        
        @if($dismissible)
            <div class="ml-4 flex-shrink-0">
                <button 
                    @click="show = false"
                    class="inline-flex text-gray-400 hover:text-gray-600 focus:outline-none focus:text-gray-600 transition ease-in-out duration-150"
                >
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif
    </div>
</div>