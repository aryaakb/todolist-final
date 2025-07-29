/**
 * UNIMUS Interaction Handler
 * Loading states, error handling, dan UX improvements
 */

class UNIMUSInteractions {
    constructor() {
        this.init();
    }

    init() {
        this.setupFormHandlers();
        this.setupLoadingStates();
        this.setupErrorHandling();
        this.setupToastNotifications();
        this.setupModalHandlers();
        this.setupTableEnhancements();
    }

    // === FORM HANDLERS ===
    setupFormHandlers() {
        document.addEventListener('submit', (e) => {
            const form = e.target;
            if (form.tagName === 'FORM') {
                this.handleFormSubmission(form);
            }
        });
    }

    handleFormSubmission(form) {
        const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
        
        if (submitBtn) {
            const originalText = submitBtn.innerHTML;
            const loadingText = submitBtn.dataset.loading || 'Memproses...';
            
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = this.getLoadingHTML(loadingText);
            
            // Restore state after timeout (fallback)
            setTimeout(() => {
                if (submitBtn.disabled) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            }, 10000);
        }
    }

    getLoadingHTML(text) {
        return `
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-current inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            ${text}
        `;
    }

    // === LOADING STATES ===
    setupLoadingStates() {
        // Auto-add loading states to buttons
        document.querySelectorAll('[data-loading]').forEach(btn => {
            btn.addEventListener('click', () => {
                this.showButtonLoading(btn);
            });
        });

        // Page loading indicator
        this.setupPageLoadingIndicator();
    }

    showButtonLoading(button) {
        const originalText = button.innerHTML;
        const loadingText = button.dataset.loading || 'Loading...';
        
        button.disabled = true;
        button.innerHTML = this.getLoadingHTML(loadingText);
        
        // Store original state
        button.dataset.originalText = originalText;
    }

    hideButtonLoading(button) {
        if (button.dataset.originalText) {
            button.disabled = false;
            button.innerHTML = button.dataset.originalText;
            delete button.dataset.originalText;
        }
    }

    setupPageLoadingIndicator() {
        // Show loading bar saat navigasi
        const loadingBar = document.createElement('div');
        loadingBar.id = 'page-loading-bar';
        loadingBar.className = 'fixed top-0 left-0 h-1 bg-gradient-unimus z-toast transition-all duration-300';
        loadingBar.style.width = '0%';
        document.body.appendChild(loadingBar);

        // Show pada link navigation
        document.addEventListener('click', (e) => {
            const link = e.target.closest('a[href]');
            if (link && !link.hasAttribute('target') && !link.href.includes('#')) {
                this.showPageLoading();
            }
        });

        // Hide saat page loaded
        window.addEventListener('load', () => {
            this.hidePageLoading();
        });
    }

    showPageLoading() {
        const bar = document.getElementById('page-loading-bar');
        if (bar) {
            bar.style.width = '30%';
            setTimeout(() => bar.style.width = '60%', 100);
            setTimeout(() => bar.style.width = '90%', 300);
        }
    }

    hidePageLoading() {
        const bar = document.getElementById('page-loading-bar');
        if (bar) {
            bar.style.width = '100%';
            setTimeout(() => {
                bar.style.opacity = '0';
                setTimeout(() => bar.style.width = '0%', 300);
                setTimeout(() => bar.style.opacity = '1', 500);
            }, 100);
        }
    }

    // === ERROR HANDLING ===
    setupErrorHandling() {
        // Global error handler
        window.addEventListener('error', (e) => {
            console.error('Global error:', e.error);
            this.showToast('Terjadi kesalahan tidak terduga', 'error');
        });

        // Unhandled promise rejections
        window.addEventListener('unhandledrejection', (e) => {
            console.error('Unhandled promise rejection:', e.reason);
            this.showToast('Terjadi kesalahan dalam memproses permintaan', 'error');
        });

        // Network errors
        this.setupNetworkErrorHandling();
    }

    setupNetworkErrorHandling() {
        const originalFetch = window.fetch;
        
        window.fetch = async function(...args) {
            try {
                const response = await originalFetch.apply(this, args);
                
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                
                return response;
            } catch (error) {
                console.error('Network error:', error);
                
                if (error.name === 'TypeError' && error.message.includes('Failed to fetch')) {
                    UNIMUSInteractions.instance.showToast('Koneksi internet bermasalah', 'error');
                } else {
                    UNIMUSInteractions.instance.showToast('Gagal memuat data', 'error');
                }
                
                throw error;
            }
        };
    }

    // === TOAST NOTIFICATIONS ===
    setupToastNotifications() {
        // Create toast container
        if (!document.getElementById('toast-container')) {
            const container = document.createElement('div');
            container.id = 'toast-container';
            container.className = 'fixed top-4 right-4 z-toast space-y-2';
            document.body.appendChild(container);
        }

        // Handle Laravel session messages
        this.handleSessionMessages();
    }

    handleSessionMessages() {
        // Check for Laravel flash messages
        const successMsg = document.querySelector('[data-success-message]');
        const errorMsg = document.querySelector('[data-error-message]');
        
        if (successMsg) {
            this.showToast(successMsg.dataset.successMessage, 'success');
            successMsg.remove();
        }
        
        if (errorMsg) {
            this.showToast(errorMsg.dataset.errorMessage, 'error');
            errorMsg.remove();
        }
    }

    showToast(message, type = 'info', duration = 5000) {
        const container = document.getElementById('toast-container');
        if (!container) return;

        const toast = document.createElement('div');
        toast.className = `toast toast-${type} max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto animate-slide-in-right`;
        
        const icons = {
            success: 'fas fa-check-circle text-green-500',
            error: 'fas fa-exclamation-circle text-red-500',
            warning: 'fas fa-exclamation-triangle text-yellow-500',
            info: 'fas fa-info-circle text-blue-500'
        };

        const colors = {
            success: 'border-green-200',
            error: 'border-red-200',
            warning: 'border-yellow-200',
            info: 'border-blue-200'
        };

        toast.innerHTML = `
            <div class="flex items-start p-4 border-l-4 ${colors[type]}">
                <div class="flex-shrink-0">
                    <i class="${icons[type]}"></i>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm text-gray-900">${message}</p>
                </div>
                <div class="ml-4 flex-shrink-0">
                    <button onclick="this.closest('.toast').remove()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `;

        container.appendChild(toast);

        // Auto remove
        if (duration > 0) {
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.style.transform = 'translateX(100%)';
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 300);
                }
            }, duration);
        }
    }

    // === MODAL HANDLERS ===
    setupModalHandlers() {
        // Open modal
        document.addEventListener('click', (e) => {
            const trigger = e.target.closest('[data-modal-target]');
            if (trigger) {
                e.preventDefault();
                const modalId = trigger.dataset.modalTarget;
                this.openModal(modalId);
            }
        });

        // Close modal
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('modal-backdrop') || 
                e.target.closest('[data-modal-close]')) {
                this.closeModal();
            }
        });

        // Close with ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closeModal();
            }
        });
    }

    openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
            
            // Focus trap
            const focusableElements = modal.querySelectorAll(
                'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
            );
            if (focusableElements.length > 0) {
                focusableElements[0].focus();
            }
        }
    }

    closeModal() {
        const modals = document.querySelectorAll('.modal:not(.hidden)');
        modals.forEach(modal => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        });
        document.body.style.overflow = '';
    }

    // === TABLE ENHANCEMENTS ===
    setupTableEnhancements() {
        // Add loading states to table actions
        document.addEventListener('click', (e) => {
            const btn = e.target.closest('.table-action-btn');
            if (btn) {
                this.showButtonLoading(btn);
            }
        });

        // Enhance responsive tables
        this.enhanceResponsiveTables();
    }

    enhanceResponsiveTables() {
        const tables = document.querySelectorAll('.table-responsive');
        
        tables.forEach(table => {
            // Add mobile-friendly data labels
            const headers = table.querySelectorAll('th');
            const rows = table.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                cells.forEach((cell, index) => {
                    if (headers[index]) {
                        cell.setAttribute('data-label', headers[index].textContent.trim());
                    }
                });
            });
        });
    }

    // === PUBLIC API ===
    static getInstance() {
        if (!UNIMUSInteractions.instance) {
            UNIMUSInteractions.instance = new UNIMUSInteractions();
        }
        return UNIMUSInteractions.instance;
    }

    static showToast(message, type = 'info', duration = 5000) {
        return UNIMUSInteractions.getInstance().showToast(message, type, duration);
    }

    static showLoading(element) {
        return UNIMUSInteractions.getInstance().showButtonLoading(element);
    }

    static hideLoading(element) {
        return UNIMUSInteractions.getInstance().hideButtonLoading(element);
    }
}

// Auto-initialize
document.addEventListener('DOMContentLoaded', () => {
    UNIMUSInteractions.getInstance();
});

// Global access
window.UNIMUS = UNIMUSInteractions;