// NorthSumateraTrip - Main JavaScript

document.addEventListener('DOMContentLoaded', function () {
    // Initialize all components
    initMobileMenu();
    initSmoothScroll();
    initLazyLoading();
    initScrollAnimations();
    initHeaderHeroCarousels();
    initHorizontalCarousels();
    initAccordions();
    initSearch();
    initAjaxWishlist();
    initAjaxForms();
});

// Mobile Menu Toggle
function initMobileMenu() {
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const closeMenuBtn = document.getElementById('close-menu-btn');

    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', function () {
            mobileMenu.classList.remove('translate-x-full');
            document.body.style.overflow = 'hidden';
        });
    }

    if (closeMenuBtn && mobileMenu) {
        closeMenuBtn.addEventListener('click', function () {
            mobileMenu.classList.add('translate-x-full');
            document.body.style.overflow = '';
        });
    }
}

// Header Hero Slider — Alpine.js component (replaces old data-images carousel)
function heroSlider(count) {
    return {
        current: 0,
        total: count,
        interval: null,
        tx0: 0,
        init() {
            if (this.total > 1) this.startAuto();
        },
        goTo(i) {
            this.current = ((i % this.total) + this.total) % this.total;
            this.restartAuto();
        },
        next() { this.goTo(this.current + 1); },
        prev() { this.goTo(this.current - 1); },
        startAuto() {
            this.stopAuto();
            this.interval = setInterval(() => this.next(), 6000);
        },
        stopAuto() {
            if (this.interval) { clearInterval(this.interval); this.interval = null; }
        },
        restartAuto() { if (this.total > 1) this.startAuto(); },
        pauseAuto() { this.stopAuto(); },
        resumeAuto() { this.startAuto(); },
        touchStart(e) { this.tx0 = e.changedTouches[0].screenX; },
        touchEnd(e) {
            const diff = e.changedTouches[0].screenX - this.tx0;
            if (Math.abs(diff) > 50) { diff < 0 ? this.next() : this.prev(); }
        }
    };
}
// Make globally available for Alpine
window.heroSlider = heroSlider;

// (Legacy) Header Hero — kept for backward compat but now no-op
function initHeaderHeroCarousels() {
    // Handled by Alpine.js heroSlider component
}

// Horizontal scroll carousels for products/cars
function initHorizontalCarousels() {
    const containers = document.querySelectorAll('.horizontal-scroll-container');
    containers.forEach(container => {
        const section = container.closest('section');
        if (!section) return;

        const prev = section.querySelector('.scroll-prev');
        const next = section.querySelector('.scroll-next');

        if (!prev || !next) return;

        next.addEventListener('click', () => {
            container.scrollBy({ left: 320, behavior: 'smooth' });
        });

        prev.addEventListener('click', () => {
            container.scrollBy({ left: -320, behavior: 'smooth' });
        });

        const toggleButtons = () => {
            const isAtStart = container.scrollLeft <= 10;
            const isAtEnd = container.scrollLeft + container.clientWidth >= container.scrollWidth - 10;

            prev.classList.toggle('opacity-30', isAtStart);
            prev.classList.toggle('pointer-events-none', isAtStart);

            next.classList.toggle('opacity-30', isAtEnd);
            next.classList.toggle('pointer-events-none', isAtEnd);
        };

        container.addEventListener('scroll', toggleButtons);
        setTimeout(toggleButtons, 500);
        window.addEventListener('resize', toggleButtons);
    });
}

// Smooth Scroll for Anchor Links
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href === '#') return;
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
}

// Lazy Loading Images
function initLazyLoading() {
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                        img.classList.add('loaded');
                    }
                    observer.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }
}

// Scroll Animations
function initScrollAnimations() {
    const animatedElements = document.querySelectorAll('.animate-on-scroll');
    if ('IntersectionObserver' in window) {
        const animationObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                }
            });
        }, { threshold: 0.1 });

        animatedElements.forEach(el => {
            animationObserver.observe(el);
        });
    }
}

// Helpers
function debounce(func, wait, immediate) {
    let timeout;
    return function (...args) {
        const later = () => {
            timeout = null;
            if (!immediate) func.apply(this, args);
        };
        const callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(this, args);
    };
}

function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `fixed bottom-20 left-1/2 transform -translate-x-1/2 px-6 py-3 rounded-xl shadow-2xl z-[200] ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white font-bold text-sm transition-all duration-300 translate-y-20`;
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.classList.remove('translate-y-20'), 100);
    setTimeout(() => {
        toast.classList.add('translate-y-20', 'opacity-0');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

function initAccordions() {
    // Handled by Alpine.js in home.blade.php but fallback here if needed logic exists
}

function initSearch() {
    const searchInput = document.getElementById('search-input');
    if (searchInput) {
        searchInput.addEventListener('input', debounce(function () {
            console.log('Searching for:', this.value);
        }, 300));
    }
}

// Global exposure
window.NorthSumateraTrip = {
    showToast,
    debounce,
    toggleWishlist
};

// AJAX Wishlist Toggle
function initAjaxWishlist() {
    document.addEventListener('submit', function(e) {
        const form = e.target;
        if (!form.matches('.wishlist-form, form[action*="wishlist/toggle"]')) return;
        e.preventDefault();

        const url = form.action;
        const token = form.querySelector('input[name="_token"]')?.value;
        const btn = form.querySelector('button');
        const svg = btn?.querySelector('svg');

        if (btn) btn.disabled = true;

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token || document.querySelector('meta[name="csrf-token"]')?.content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({})
        })
        .then(res => res.json())
        .then(data => {
            // Update heart icon
            if (svg) {
                if (data.status === 'added') {
                    svg.classList.add('fill-rose-500', 'text-rose-500');
                    svg.classList.remove('fill-none');
                } else {
                    svg.classList.remove('fill-rose-500', 'text-rose-500');
                    svg.classList.add('fill-none');
                }
            }

            // Update all wishlist badges in navbar
            updateWishlistBadge(data.count);

            // Show toast notification
            showToast(data.message, 'success');

            // If we're on wishlist page, remove the card
            if (data.status === 'removed' && window.location.pathname.includes('wishlist')) {
                const card = form.closest('.group');
                if (card) {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.8)';
                    setTimeout(() => {
                        card.remove();
                        // Check if grid is empty
                        const grid = document.querySelector('.grid');
                        if (grid && grid.children.length === 0) {
                            location.reload();
                        }
                    }, 500);
                }
            }
        })
        .catch(() => showToast('Gagal memproses wishlist', 'error'))
        .finally(() => { if (btn) btn.disabled = false; });
    });
}

function toggleWishlist(url, element) {
    const token = document.querySelector('meta[name="csrf-token"]')?.content;
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: JSON.stringify({})
    })
    .then(res => res.json())
    .then(data => {
        updateWishlistBadge(data.count);
        showToast(data.message, 'success');
    })
    .catch(() => showToast('Gagal memproses wishlist', 'error'));
}

function updateWishlistBadge(count) {
    document.querySelectorAll('[data-wishlist-count]').forEach(badge => {
        if (count > 0) {
            badge.textContent = count;
            badge.style.display = 'flex';
        } else {
            badge.style.display = 'none';
        }
    });
}

// AJAX Forms (Contact, Booking Status)
function initAjaxForms() {
    document.querySelectorAll('form[data-ajax]').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const btn = form.querySelector('button[type="submit"]');
            const originalText = btn?.innerHTML;
            const resultContainer = form.closest('section')?.querySelector('[data-ajax-result]');
            
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mengirim...';
            }

            // Clear previous errors
            form.querySelectorAll('.field-error').forEach(el => el.remove());
            form.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));

            const formData = new FormData(form);

            fetch(form.action, {
                method: form.method || 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(async res => {
                const data = await res.json();
                if (!res.ok) throw { status: res.status, data };
                return data;
            })
            .then(data => {
                showToast(data.message || 'Berhasil!', 'success');
                
                if (data.redirect) {
                    setTimeout(() => window.location.href = data.redirect, 1000);
                } else if (data.html && resultContainer) {
                    resultContainer.innerHTML = data.html;
                    resultContainer.style.display = 'block';
                } else {
                    form.reset();
                }
            })
            .catch(err => {
                if (err.status === 422 && err.data?.errors) {
                    Object.entries(err.data.errors).forEach(([field, messages]) => {
                        const input = form.querySelector(`[name="${field}"]`);
                        if (input) {
                            input.classList.add('border-red-500');
                            const errorEl = document.createElement('p');
                            errorEl.className = 'field-error text-red-500 text-xs mt-1';
                            errorEl.textContent = messages[0];
                            input.parentNode.appendChild(errorEl);
                        }
                    });
                    showToast('Mohon periksa kembali data Anda', 'error');
                } else {
                    showToast(err.data?.message || 'Terjadi kesalahan', 'error');
                }
            })
            .finally(() => {
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            });
        });
    });
}