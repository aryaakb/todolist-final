/**
 * UNIMUS Image Optimizer
 * Optimasi loading gambar dengan lazy loading dan placeholder
 */

class ImageOptimizer {
    constructor() {
        this.init();
    }

    init() {
        this.setupLazyLoading();
        this.setupImagePlaceholders();
        this.setupResponsiveImages();
    }

    setupLazyLoading() {
        // Native lazy loading untuk browser yang support
        const images = document.querySelectorAll('img[loading="lazy"]');
        
        // Fallback untuk browser lama
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.classList.remove('lazy');
                            observer.unobserve(img);
                        }
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    }

    setupImagePlaceholders() {
        // Generate placeholder untuk gambar yang belum loaded
        document.querySelectorAll('img').forEach(img => {
            img.addEventListener('load', () => {
                img.classList.add('loaded');
            });

            img.addEventListener('error', () => {
                img.src = this.generatePlaceholder(img.alt || 'Image');
            });
        });
    }

    setupResponsiveImages() {
        // Auto-generate srcset untuk responsive images
        const responsiveImages = document.querySelectorAll('.responsive-img');
        
        responsiveImages.forEach(img => {
            const baseSrc = img.src;
            const fileName = baseSrc.split('/').pop().split('.')[0];
            const extension = baseSrc.split('.').pop();
            const basePath = baseSrc.replace(/\/[^\/]+$/, '');
            
            // Generate srcset untuk berbagai ukuran
            const srcset = [
                `${basePath}/${fileName}-480.${extension} 480w`,
                `${basePath}/${fileName}-768.${extension} 768w`,
                `${basePath}/${fileName}-1024.${extension} 1024w`,
                `${basePath}/${fileName}.${extension} 1200w`
            ].join(', ');
            
            img.srcset = srcset;
            img.sizes = '(max-width: 480px) 480px, (max-width: 768px) 768px, (max-width: 1024px) 1024px, 1200px';
        });
    }

    generatePlaceholder(text) {
        // Generate placeholder SVG
        const svg = `
            <svg width="400" height="300" xmlns="http://www.w3.org/2000/svg">
                <rect width="100%" height="100%" fill="#0ea5e9" opacity="0.1"/>
                <text x="50%" y="50%" font-family="Inter, sans-serif" font-size="16" 
                      text-anchor="middle" dy=".3em" fill="#0ea5e9">
                    ${text}
                </text>
            </svg>
        `;
        return `data:image/svg+xml;base64,${btoa(svg)}`;
    }

    // Utility untuk mengecek format WebP support
    static supportsWebP() {
        return new Promise((resolve) => {
            const webP = new Image();
            webP.onload = webP.onerror = () => resolve(webP.height === 2);
            webP.src = 'data:image/webp;base64,UklGRjoAAABXRUJQVlA4IC4AAACyAgCdASoCAAIALmk0mk0iIiIiIgBoSygABc6WWgAA/veff/0PP8bA//LwYAAA';
        });
    }

    // Lazy load untuk background images
    static loadBackgroundImages() {
        const bgImages = document.querySelectorAll('[data-bg]');
        
        if ('IntersectionObserver' in window) {
            const bgImageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const element = entry.target;
                        element.style.backgroundImage = `url(${element.dataset.bg})`;
                        element.classList.add('bg-loaded');
                        bgImageObserver.unobserve(element);
                    }
                });
            });

            bgImages.forEach(element => bgImageObserver.observe(element));
        }
    }
}

// Auto-initialize ketika DOM ready
document.addEventListener('DOMContentLoaded', () => {
    new ImageOptimizer();
});

// CSS untuk placeholder dan loading states
const style = document.createElement('style');
style.textContent = `
    img.lazy {
        filter: blur(5px);
        transition: filter 0.3s;
    }
    
    img.loaded {
        filter: none;
    }
    
    .image-placeholder {
        background: linear-gradient(90deg, #f0f0f0 25%, transparent 37%, #f0f0f0 63%);
        background-size: 400% 100%;
        animation: shimmer 1.5s ease-in-out infinite;
    }
    
    @keyframes shimmer {
        0% { background-position: 100% 50%; }
        100% { background-position: -100% 50%; }
    }
    
    .bg-loaded {
        background-size: cover;
        background-position: center;
        transition: opacity 0.3s ease-in-out;
    }
`;
document.head.appendChild(style);