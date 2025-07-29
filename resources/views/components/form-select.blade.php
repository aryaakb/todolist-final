@props([
    'name',
    'label' => null,
    'placeholder' => 'Pilih opsi...',
    'options' => [],
    'selected' => null,
    'required' => false,
    'error' => null,
    'help' => null,
    'disabled' => false,
    'multiple' => false
])

@php
$hasError = $error || $errors->has($name);
$errorMessage = $error ?: $errors->first($name);
$inputId = 'select_' . $name . '_' . uniqid();

$selectClasses = 'w-full px-4 py-3 border rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-1 bg-white text-gray-900 appearance-none ' . 
    ($hasError 
        ? 'border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500 pr-16' 
        : 'border-gray-300 focus:border-unimus-primary focus:ring-unimus-primary pr-10'
    ) . 
    ($disabled ? ' bg-gray-50 cursor-not-allowed text-gray-500' : '');
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
    
    <div class="relative">
        <select
            id="{{ $inputId }}"
            name="{{ $name }}{{ $multiple ? '[]' : '' }}"
            {{ $required ? 'required' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $multiple ? 'multiple' : '' }}
            {{ $attributes->merge(['class' => $selectClasses]) }}
            @if($hasError) aria-invalid="true" aria-describedby="{{ $inputId }}_error" @endif
            @if($help) aria-describedby="{{ $inputId }}_help" @endif
        >
            @if(!$multiple && $placeholder)
                <option value="" {{ empty($selected) ? 'selected' : '' }}>{{ $placeholder }}</option>
            @endif
            
            @foreach($options as $value => $label)
                <option 
                    value="{{ $value }}" 
                    {{ (old($name, $selected) == $value || (is_array(old($name, $selected)) && in_array($value, old($name, $selected)))) ? 'selected' : '' }}
                >
                    {{ $label }}
                </option>
            @endforeach
        </select>
        
        @if(!$multiple)
            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none z-10">
                <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
            </div>
        @endif
        
        @if($hasError)
            <div class="absolute inset-y-0 right-10 pr-1 flex items-center pointer-events-none z-20">
                <i class="fas fa-exclamation-circle text-red-500 text-sm"></i>
            </div>
        @endif
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
/* Form Select Dark Mode - BRIGHT WHITE TEXT */
body.dark-mode .form-group select {
    background: rgba(55, 65, 81, 0.9) !important;
    border: 1px solid rgba(75, 85, 99, 0.5) !important;
    color: #ffffff !important;
}

body.dark-mode .form-group select:focus {
    border-color: #0ea5e9 !important;
    box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1) !important;
    background: rgba(55, 65, 81, 0.95) !important;
    color: #ffffff !important;
}

body.dark-mode .form-group select option {
    background: rgba(55, 65, 81, 0.95) !important;
    color: #ffffff !important;
}

body.dark-mode .form-group select option:hover,
body.dark-mode .form-group select option:focus,
body.dark-mode .form-group select option:checked {
    background: rgba(14, 165, 233, 0.8) !important;
    color: #ffffff !important;
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
body:not(.dark-mode) .form-group select {
    background: rgba(255, 255, 255, 0.8) !important;
    backdrop-filter: blur(10px) saturate(180%);
    border: 1px solid rgba(255, 255, 255, 0.3) !important;
    color: #1f2937 !important;
    box-shadow: 0 4px 16px rgba(31, 41, 55, 0.05);
}

body:not(.dark-mode) .form-group select:focus {
    background: rgba(255, 255, 255, 0.9) !important;
    backdrop-filter: blur(12px) saturate(200%);
    box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1), 
                0 8px 24px rgba(31, 41, 55, 0.08);
}

body:not(.dark-mode) .form-group select option {
    background: rgba(255, 255, 255, 0.95) !important;
    backdrop-filter: none;
    color: #1f2937 !important;
}

body:not(.dark-mode) .form-group label {
    color: #374151 !important;
    text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);
}
</style>