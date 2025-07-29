@props([
    'name',
    'label' => null,
    'type' => 'text',
    'placeholder' => '',
    'required' => false,
    'value' => null,
    'error' => null,
    'help' => null,
    'icon' => null,
    'readonly' => false,
    'disabled' => false
])

@php
$hasError = $error || $errors->has($name);
$errorMessage = $error ?: $errors->first($name);
$inputId = 'input_' . $name . '_' . uniqid();

$inputClasses = 'w-full px-4 py-3 border rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-1 bg-white text-gray-900 placeholder-gray-400 ' . 
    ($hasError 
        ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 pr-10' 
        : 'border-gray-300 focus:border-unimus-primary focus:ring-unimus-primary'
    ) . 
    ($readonly || $disabled ? ' bg-gray-50 cursor-not-allowed text-gray-500' : '');
@endphp

<div class="form-group">
    @if($label)
        <label for="{{ $inputId }}" class="block text-sm font-medium text-gray-700 mb-2">
            {{ $label }}
            @if($required)
                <span class="text-red-500 ml-1">*</span>
            @endif
        </label>
    @endif
    
    <div class="{{ $icon ? 'flex items-center gap-3' : 'relative' }}">
        @if($icon)
            <div class="text-gray-400 pointer-events-none">
                <i class="{{ $icon }} text-sm"></i>
            </div>
        @endif
        
        <div class="relative flex-1">
            <input
                type="{{ $type }}"
                id="{{ $inputId }}"
                name="{{ $name }}"
                value="{{ old($name, $value) }}"
                placeholder="{{ $placeholder }}"
                {{ $required ? 'required' : '' }}
                {{ $readonly ? 'readonly' : '' }}
                {{ $disabled ? 'disabled' : '' }}
                {{ $attributes->merge(['class' => $inputClasses]) }}
                @if($hasError) aria-invalid="true" aria-describedby="{{ $inputId }}_error" @endif
                @if($help) aria-describedby="{{ $inputId }}_help" @endif
            >
            
            @if($hasError)
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none z-10">
                    <i class="fas fa-exclamation-circle text-red-500 text-sm"></i>
                </div>
            @endif
        </div>
    </div>
    
    @if($hasError)
        <p id="{{ $inputId }}_error" class="mt-2 text-sm text-red-600 flex items-center">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            {{ $errorMessage }}
        </p>
    @endif
    
    @if($help && !$hasError)
        <p id="{{ $inputId }}_help" class="mt-2 text-sm text-gray-500">
            {{ $help }}
        </p>
    @endif
</div>

<style>
/* Form Input Dark Mode - BRIGHT WHITE TEXT */
body.dark-mode .form-group input {
    background: rgba(55, 65, 81, 0.9) !important;
    border: 1px solid rgba(75, 85, 99, 0.5) !important;
    color: #ffffff !important;
    caret-color: #ffffff !important;
}

body.dark-mode .form-group input:focus {
    border-color: #0ea5e9 !important;
    box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1) !important;
    background: rgba(55, 65, 81, 0.95) !important;
    color: #ffffff !important;
    caret-color: #ffffff !important;
}

body.dark-mode .form-group input::placeholder {
    color: #9ca3af !important;
    opacity: 0.7 !important;
}

body.dark-mode .form-group label {
    color: #e2e8f0 !important;
}

body.dark-mode .form-group .text-gray-500 {
    color: #94a3b8 !important;
}

body.dark-mode .form-group .text-gray-400 {
    color: #9ca3af !important;
}

/* Light Mode Glass Effect */
body:not(.dark-mode) .form-group input {
    background: rgba(255, 255, 255, 0.8) !important;
    backdrop-filter: blur(10px) saturate(180%);
    border: 1px solid rgba(255, 255, 255, 0.3) !important;
    color: #1f2937 !important;
    box-shadow: 0 4px 16px rgba(31, 41, 55, 0.05);
}

body:not(.dark-mode) .form-group input:focus {
    background: rgba(255, 255, 255, 0.9) !important;
    backdrop-filter: blur(12px) saturate(200%);
    box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1), 
                0 8px 24px rgba(31, 41, 55, 0.08);
}

body:not(.dark-mode) .form-group input::placeholder {
    color: #9ca3af !important;
}

body:not(.dark-mode) .form-group label {
    color: #374151 !important;
    text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);
}
</style>