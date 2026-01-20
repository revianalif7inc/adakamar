// Global JavaScript functions

document.addEventListener('DOMContentLoaded', function() {
    // Add smooth scroll behavior
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    // Add form validation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!this.checkValidity()) {
                e.preventDefault();
                console.log('Form validation failed');
            }
        });
    });
});

// Format currency
function formatCurrency(value) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(value);
}

// Format date
function formatDate(dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
}

// Show toast notification
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.textContent = message;
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        background-color: ${type === 'success' ? '#27ae60' : type === 'error' ? '#c0392b' : '#3498db'};
        color: white;
        border-radius: 4px;
        z-index: 9999;
        animation: slideIn 0.3s ease-in-out;
    `;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease-in-out';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Mobile search overlay handlers
(function() {
    function openMobileSearch() {
        const overlay = document.getElementById('mobileSearchOverlay');
        if (!overlay) return;
        overlay.classList.remove('d-none');
        setTimeout(() => overlay.classList.add('show'), 10);
        const input = overlay.querySelector('input[name="search"]');
        if (input) setTimeout(() => input.focus(), 120);
        document.body.style.overflow = 'hidden';
    }

    function closeMobileSearch() {
        const overlay = document.getElementById('mobileSearchOverlay');
        if (!overlay) return;
        overlay.classList.remove('show');
        setTimeout(() => overlay.classList.add('d-none'), 240);
        document.body.style.overflow = '';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const openBtn = document.getElementById('mobileSearchBtn');
        const closeBtn = document.getElementById('mobileSearchClose');
        if (openBtn) openBtn.addEventListener('click', function(e) { e.preventDefault(); openMobileSearch(); });
        if (closeBtn) closeBtn.addEventListener('click', function(e) { e.preventDefault(); closeMobileSearch(); });

        // mobile menu toggle (top-left hamburger)
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                const toggler = document.querySelector('.header-inner .navbar-toggler');
                if (toggler) toggler.click();
            });
        }

        // Mobile article category selector navigation
        const mobileCat = document.getElementById('mobileArticleCategorySelect');
        if (mobileCat) {
            mobileCat.addEventListener('change', function(e) {
                const val = this.value;
                if (!val) {
                    window.location.href = '/artikel';
                } else {
                    window.location.href = '/artikel/kategori/' + encodeURIComponent(val);
                }
            });
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeMobileSearch();
        });
    });
})();

// Rating helpers: star pickers and quick-rate AJAX
function initStarPickers() {
    // In-page review star pickers
    document.querySelectorAll('.star-picker').forEach(picker => {
        const input = picker.closest('form')?.querySelector('input[name="rating"]') || picker.querySelector('input[name="rating"]') || document.getElementById('reviewRating');
        const currentValue = parseInt(input?.value || 0, 10);

        function setActiveStars(value, container) {
            container.querySelectorAll('.star-toggle').forEach(star => {
                const val = parseInt(star.dataset.value, 10);
                star.style.opacity = val <= value ? '1' : '0.35';
            });
        }

        setActiveStars(currentValue, picker);

        picker.querySelectorAll('.star-toggle').forEach(star => {
            star.addEventListener('click', function (e) {
                const v = parseInt(this.dataset.value, 10);
                if (input) input.value = v;
                setActiveStars(v, picker);
            });
            star.addEventListener('mouseover', function () {
                setActiveStars(parseInt(this.dataset.value, 10), picker);
            });
            star.addEventListener('mouseout', function () {
                setActiveStars(parseInt(input?.value || 0, 10), picker);
            });
        });
    });

    // Quick-rate (home cards) handlers
    document.querySelectorAll('.quick-rate .star-toggle').forEach(star => {
        star.addEventListener('click', function () {
            const homestayId = this.closest('.quick-rate').dataset.homestayId;
            const value = this.dataset.value;
            const tokenMeta = document.querySelector('meta[name="csrf-token"]');
            const token = tokenMeta ? tokenMeta.getAttribute('content') : null;

            fetch(`/kamar/${homestayId}/review`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ rating: parseInt(value, 10) })
            }).then(r => r.json()).then(data => {
                if (data && data.success) {
                    // update badge UI
                    const card = document.querySelector(`.kamar-card[href*="/kamar/${homestayId}"]`);
                    if (card) {
                        const badge = card.querySelector('.badge-rating');
                        if (badge) badge.textContent = '★ ' + (parseFloat(data.rating).toFixed(2));
                    }
                    showToast('Terima kasih atas rating Anda', 'success');
                    // set visual stars
                    const container = document.querySelector(`.quick-rate[data-homestay-id="${homestayId}"]`);
                    if (container) container.querySelectorAll('.star-toggle').forEach(s => s.style.opacity = s.dataset.value <= data.rating ? '1' : '0.35');
                } else {
                    showToast('Gagal menyimpan rating', 'error');
                }
            }).catch(err => {
                console.error(err);
                showToast('Terjadi kesalahan saat mengirim rating', 'error');
            });
        });
    });
}

document.addEventListener('DOMContentLoaded', initStarPickers);

