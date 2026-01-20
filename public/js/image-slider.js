document.addEventListener('DOMContentLoaded', function () {
    const slider = document.getElementById('imageSlider');
    if (!slider) return;
    const slides = slider.querySelectorAll('.image-slider-item');
    const dotsContainer = document.getElementById('dotsContainer');
    let currentSlideIndex = 0;

    // create dots
    if (dotsContainer) {
        dotsContainer.innerHTML = '';
        slides.forEach((_, idx) => {
            const dot = document.createElement('div');
            dot.className = 'slider-dot' + (idx === 0 ? ' active' : '');
            dot.addEventListener('click', () => currentSlide(idx));
            dotsContainer.appendChild(dot);
        });
    }

    function render() {
        const translateValue = -currentSlideIndex * 100;
        slider.style.transform = `translateX(${translateValue}%)`;

        const dots = document.querySelectorAll('.slider-dot');
        dots.forEach(dot => dot.classList.remove('active'));
        if (dots[currentSlideIndex]) dots[currentSlideIndex].classList.add('active');

        // Sync thumbnails (if present)
        const thumbs = document.querySelectorAll('.thumb-item');
        thumbs.forEach(t => t.classList.remove('active'));
        if (thumbs[currentSlideIndex]) {
            thumbs[currentSlideIndex].classList.add('active');
            try { thumbs[currentSlideIndex].scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' }); } catch (e) { }
        }
    }

    window.slideImage = function (n) {
        currentSlideIndex += n;
        if (currentSlideIndex >= slides.length) currentSlideIndex = 0;
        if (currentSlideIndex < 0) currentSlideIndex = slides.length - 1;
        render();
    }

    window.currentSlide = function (n) {
        currentSlideIndex = n;
        render();
    }

    // keyboard navigation
    document.addEventListener('keydown', function (event) {
        if (event.key === 'ArrowLeft') window.slideImage(-1);
        if (event.key === 'ArrowRight') window.slideImage(1);
    });

    // attach safe click handlers to nav buttons and thumbnail items to prevent default page navigation
    const prevBtn = document.querySelector('.slider-nav-button.prev');
    const nextBtn = document.querySelector('.slider-nav-button.next');
    if (prevBtn) prevBtn.addEventListener('click', function (e) { e.preventDefault(); e.stopPropagation(); window.slideImage(-1); });
    if (nextBtn) nextBtn.addEventListener('click', function (e) { e.preventDefault(); e.stopPropagation(); window.slideImage(1); });

    const thumbItems = document.querySelectorAll('.thumb-item');
    thumbItems.forEach((t) => {
        const idx = parseInt(t.getAttribute('data-index'), 10);
        t.addEventListener('click', function (e) { e.preventDefault(); e.stopPropagation(); if (!isNaN(idx)) window.currentSlide(idx); });
        // keyboard accessibility
        t.addEventListener('keydown', function (e) { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); if (!isNaN(idx)) window.currentSlide(idx); } });
    });

    // init
    render();
});