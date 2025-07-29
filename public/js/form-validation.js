/**
 * UNIMUS Form Validation
 * Client-side validation dengan real-time feedback
 */

class UNIMUSFormValidator {
    constructor() {
        this.rules = {};
        this.messages = {};
        this.init();
    }

    init() {
        this.setupValidationRules();
        this.setupRealTimeValidation();
        this.setupFormSubmission();
    }

    setupValidationRules() {
        // Default validation rules
        this.rules = {
            required: (value) => value.trim() !== '',
            email: (value) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value),
            min: (value, min) => value.length >= min,
            max: (value, max) => value.length <= max,
            numeric: (value) => /^\d+$/.test(value),
            alpha: (value) => /^[a-zA-Z\s]+$/.test(value),
            alphanum: (value) => /^[a-zA-Z0-9\s]+$/.test(value),
            phone: (value) => /^[\+]?[0-9\-\s\(\)]+$/.test(value),
            url: (value) => {
                try {
                    new URL(value);
                    return true;
                } catch {
                    return false;
                }
            },
            same: (value, otherFieldId) => {
                const otherField = document.getElementById(otherFieldId);
                return otherField && value === otherField.value;
            },
            different: (value, otherFieldId) => {
                const otherField = document.getElementById(otherFieldId);
                return !otherField || value !== otherField.value;
            }
        };

        // Default error messages
        this.messages = {
            required: 'Field ini wajib diisi.',
            email: 'Format email tidak valid.',
            min: 'Minimal {min} karakter diperlukan.',
            max: 'Maksimal {max} karakter diperbolehkan.',
            numeric: 'Hanya angka yang diperbolehkan.',
            alpha: 'Hanya huruf yang diperbolehkan.',
            alphanum: 'Hanya huruf dan angka yang diperbolehkan.',
            phone: 'Format nomor telepon tidak valid.',
            url: 'Format URL tidak valid.',
            same: 'Field ini harus sama dengan {field}.',
            different: 'Field ini harus berbeda dengan {field}.'
        };
    }

    setupRealTimeValidation() {
        // Validate on input/change events
        document.addEventListener('input', (e) => {
            if (e.target.hasAttribute('data-validate')) {
                this.validateField(e.target);
            }
        });

        document.addEventListener('change', (e) => {
            if (e.target.hasAttribute('data-validate')) {
                this.validateField(e.target);
            }
        });

        // Validate on blur for better UX
        document.addEventListener('blur', (e) => {
            if (e.target.hasAttribute('data-validate')) {
                this.validateField(e.target);
            }
        }, true);
    }

    setupFormSubmission() {
        document.addEventListener('submit', (e) => {
            const form = e.target;
            if (form.hasAttribute('data-validate-form')) {
                if (!this.validateForm(form)) {
                    e.preventDefault();
                    
                    // Focus first invalid field
                    const firstInvalid = form.querySelector('.is-invalid');
                    if (firstInvalid) {
                        firstInvalid.focus();
                        firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            }
        });
    }

    validateField(field) {
        const rules = field.getAttribute('data-validate').split('|');
        const fieldName = field.getAttribute('name') || field.id;
        let isValid = true;
        let errorMessage = '';

        // Clear previous state
        this.clearFieldError(field);

        for (const rule of rules) {
            const [ruleName, ...params] = rule.split(':');
            const value = field.value;

            // Skip validation for empty non-required fields
            if (!value && ruleName !== 'required') {
                continue;
            }

            if (this.rules[ruleName]) {
                let ruleValid;
                
                if (params.length > 0) {
                    ruleValid = this.rules[ruleName](value, ...params);
                } else {
                    ruleValid = this.rules[ruleName](value);
                }

                if (!ruleValid) {
                    isValid = false;
                    errorMessage = this.getErrorMessage(ruleName, params, fieldName);
                    break;
                }
            }
        }

        if (!isValid) {
            this.showFieldError(field, errorMessage);
        } else {
            this.showFieldSuccess(field);
        }

        return isValid;
    }

    validateForm(form) {
        const fields = form.querySelectorAll('[data-validate]');
        let isFormValid = true;

        fields.forEach(field => {
            if (!this.validateField(field)) {
                isFormValid = false;
            }
        });

        return isFormValid;
    }

    showFieldError(field, message) {
        field.classList.add('is-invalid');
        field.classList.remove('is-valid');
        
        // Update classes for styling
        field.classList.remove('border-gray-300', 'focus:border-unimus-primary', 'focus:ring-unimus-primary');
        field.classList.add('border-red-300', 'focus:border-red-500', 'focus:ring-red-500');

        // Find or create error message element
        const fieldGroup = field.closest('.form-group');
        if (fieldGroup) {
            let errorElement = fieldGroup.querySelector('.field-error');
            
            if (!errorElement) {
                errorElement = document.createElement('p');
                errorElement.className = 'field-error mt-2 text-sm text-red-600 flex items-center';
                errorElement.innerHTML = '<i class="fas fa-exclamation-triangle mr-2"></i><span class="error-text"></span>';
                field.parentNode.insertBefore(errorElement, field.nextSibling);
            }
            
            errorElement.querySelector('.error-text').textContent = message;
            errorElement.style.display = 'flex';
        }

        // Add error icon
        this.addFieldIcon(field, 'fas fa-exclamation-circle text-red-500');
    }

    showFieldSuccess(field) {
        field.classList.add('is-valid');
        field.classList.remove('is-invalid');
        
        // Update classes for styling
        field.classList.remove('border-red-300', 'focus:border-red-500', 'focus:ring-red-500');
        field.classList.add('border-green-300', 'focus:border-green-500', 'focus:ring-green-500');

        this.clearFieldError(field);
        
        // Add success icon
        this.addFieldIcon(field, 'fas fa-check-circle text-green-500');
    }

    clearFieldError(field) {
        field.classList.remove('is-invalid', 'is-valid');
        field.classList.remove('border-red-300', 'focus:border-red-500', 'focus:ring-red-500');
        field.classList.remove('border-green-300', 'focus:border-green-500', 'focus:ring-green-500');
        field.classList.add('border-gray-300', 'focus:border-unimus-primary', 'focus:ring-unimus-primary');

        // Hide error message
        const fieldGroup = field.closest('.form-group');
        if (fieldGroup) {
            const errorElement = fieldGroup.querySelector('.field-error');
            if (errorElement) {
                errorElement.style.display = 'none';
            }
        }

        // Remove icons
        this.removeFieldIcon(field);
    }

    addFieldIcon(field, iconClass) {
        this.removeFieldIcon(field);
        
        const fieldContainer = field.parentNode;
        const icon = document.createElement('div');
        icon.className = 'validation-icon absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none';
        icon.innerHTML = `<i class="${iconClass}"></i>`;
        
        fieldContainer.appendChild(icon);
    }

    removeFieldIcon(field) {
        const fieldContainer = field.parentNode;
        const existingIcon = fieldContainer.querySelector('.validation-icon');
        if (existingIcon) {
            existingIcon.remove();
        }
    }

    getErrorMessage(ruleName, params, fieldName) {
        let message = this.messages[ruleName] || 'Field tidak valid.';
        
        // Replace placeholders
        if (params.length > 0) {
            params.forEach((param, index) => {
                message = message.replace(`{${Object.keys(params)[index] || index}}`, param);
            });
        }
        
        message = message.replace('{field}', fieldName);
        
        return message;
    }

    // Public API
    addRule(name, validator, message) {
        this.rules[name] = validator;
        if (message) {
            this.messages[name] = message;
        }
    }

    setMessages(messages) {
        this.messages = { ...this.messages, ...messages };
    }

    static getInstance() {
        if (!UNIMUSFormValidator.instance) {
            UNIMUSFormValidator.instance = new UNIMUSFormValidator();
        }
        return UNIMUSFormValidator.instance;
    }
}

// Auto-initialize
document.addEventListener('DOMContentLoaded', () => {
    UNIMUSFormValidator.getInstance();
});

// Global access
window.UNIMUSValidator = UNIMUSFormValidator;

// CSS untuk styling validation
const style = document.createElement('style');
style.textContent = `
    .form-group {
        position: relative;
        margin-bottom: 1rem;
    }
    
    .is-invalid {
        border-color: #f87171 !important;
        box-shadow: 0 0 0 3px rgba(248, 113, 113, 0.1) !important;
    }
    
    .is-valid {
        border-color: #34d399 !important;
        box-shadow: 0 0 0 3px rgba(52, 211, 153, 0.1) !important;
    }
    
    .field-error {
        animation: fadeInDown 0.3s ease-out;
    }
    
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .validation-icon {
        z-index: 5;
    }
    
    /* Override untuk select dengan icon */
    select + .validation-icon {
        right: 2rem;
    }
`;
document.head.appendChild(style);