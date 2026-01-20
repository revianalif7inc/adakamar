document.addEventListener('DOMContentLoaded', function () {
    // Initialize each .card-slider on the page
    document.querySelectorAll('.card-slider').forEach(initSlider);

    function initSlider(container) {
        const track = container.querySelector('.cards-track');
        if (!track) return;
        let items = Array.from(track.children);
        const prevBtn = container.querySelector('.slider-button.prev');
        const nextBtn = container.querySelector('.slider-button.next');
        const dotsWrapper = container.querySelector('.slider-dots');

        let itemsPerView = 4;
        let itemGap = parseFloat(getComputedStyle(track).gap) || 18;
        let itemWidth = 300;
        let currentIndex = 0;

        function computeItemsPerView() {
            const width = container.clientWidth;
            if (width >= 1100) return 4;
            if (width >= 900) return 3;
            if (width >= 640) return 2;
            return 1;
        }

        function updateMeasurements() {
            // recalc item list and sizes
            items = Array.from(track.children);
            const rect = items[0] ? items[0].getBoundingClientRect() : { width: 260 };
            itemWidth = rect.width + itemGap;

            // Compute a baseline per-view from breakpoints, then refine using actual widths so desktop shows correct count
            let basePerView = computeItemsPerView();
            const calcPerView = Math.max(1, Math.floor(container.clientWidth / itemWidth));
            // Use the smaller of the breakpoint and calculated values so we don't overcount visible items
            itemsPerView = Math.max(1, Math.min(basePerView, calcPerView));

            try { console.debug('updateMeasurements -> containerW:', container.clientWidth, 'itemWidth:', itemWidth, 'itemsPerView:', itemsPerView, 'calcPerView:', calcPerView); } catch (e) {}
        }

        function maxIndex() {
            return Math.max(0, items.length - itemsPerView);
        }

        function animateDot(dotEl) {
            if (!dotEl) return;
            try { console.debug('animateDot -> index:', dotEl.dataset.index); } catch (e) {}
            // remove any existing pop class, force reflow, then add to restart animation
            dotEl.classList.remove('pop');
            void dotEl.offsetWidth;
            dotEl.classList.add('pop');
            dotEl.addEventListener('animationend', () => dotEl.classList.remove('pop'), { once: true });
        }

        function createDots() {
            if (!dotsWrapper) return;
            dotsWrapper.innerHTML = '';
            const count = Math.max(1, Math.ceil(items.length / itemsPerView));
            for (let i = 0; i < count; i++) {
                const btn = document.createElement('button');
                btn.setAttribute('aria-label', 'Slide ' + (i + 1));
                btn.dataset.index = i;
                if (i === 0) btn.classList.add('active');
                // clicking a dot sets the index and recalculates sizes (defensive)
                btn.addEventListener('click', (ev) => {
                    ev.preventDefault();
                    updateMeasurements();
                    // calculate intended index (first item of the page)
                    const newIndex = i * itemsPerView;
                    currentIndex = Math.max(0, Math.min(newIndex, maxIndex()));
                    // remove active from all
                    const all = Array.from(dotsWrapper.children);
                    all.forEach(el => el.classList.remove('active'));
                    // add active + animate
                    btn.classList.add('active');
                    animateDot(btn);
                    update();
                });
                dotsWrapper.appendChild(btn);
            }
        }

        function updateDots() {
            if (!dotsWrapper) return;
            const dots = Array.from(dotsWrapper.children);
            if (!dots.length) return;
            // Determine active item by visual center to be robust across viewports
            const activeItem = getActiveItemIndex();
            let dotIndex = Math.floor(activeItem / Math.max(1, itemsPerView));
            // Clamp dotIndex to valid range
            dotIndex = Math.max(0, Math.min(dotIndex, dots.length - 1));
            try { console.debug('updateDots -> activeItem:', activeItem, 'itemsPerView:', itemsPerView, 'dotIndex:', dotIndex); } catch (e) {}
            dots.forEach((d, i) => {
                if (i === dotIndex) {
                    if (!d.classList.contains('active')) {
                        d.classList.add('active');
                    }
                    // animate the currently active dot so it visibly changes on desktop as well
                    animateDot(d);
                } else {
                    d.classList.remove('active');
                }
            });
        }

        function getActiveItemIndex() {
            // Use container center as reference point to avoid transform/track offset issues
            const containerRect = container.getBoundingClientRect();
            const centerX = containerRect.left + (container.clientWidth / 2);
            let bestIdx = 0; let bestDist = Infinity;
            items.forEach((it, idx) => {
                const r = it.getBoundingClientRect();
                const itemCenter = r.left + r.width / 2;
                const dist = Math.abs(itemCenter - centerX);
                if (dist < bestDist) { bestDist = dist; bestIdx = idx; }
            });
            try { console.debug('getActiveItemIndex -> containerCenter:', Math.round(containerRect.left + containerRect.width/2), 'bestIdx:', bestIdx, 'bestDist:', Math.round(bestDist)); } catch (e) {}
            return bestIdx;
        }

        function update() {
            const targetIndex = Math.min(currentIndex, items.length - 1);
            const target = items[targetIndex];
            // Debug log to verify update path runs
            try { console.debug('update -> currentIndex:', currentIndex, 'targetIndex:', targetIndex, 'itemsPerView:', itemsPerView, 'itemsLen:', items.length); } catch (e) {}
            // Compute offset relative to the track using bounding boxes (more reliable than offsetLeft)
            let offset = 0;
            if (target) {
                const targetRect = target.getBoundingClientRect();
                const trackRect = track.getBoundingClientRect();
                offset = targetRect.left - trackRect.left + track.scrollLeft;
            }
            const finalOffset = Math.max(0, Math.round(offset));
            // If transform doesn't change, add a tiny nudge to force transition in some browsers
            const prevTransform = track.style.transform || '';
            const newTransform = `translateX(-${finalOffset}px)`;
            if (prevTransform === newTransform) {
                // Force a micro change and set back (helps browsers that ignore re-setting the same transform)
                track.style.transform = `translateX(-${Math.max(0, finalOffset - 1)}px)`;
                // Force reflow
                void track.offsetWidth;
            }
            track.style.transform = newTransform;

            // Update nav visibility
            if (prevBtn) prevBtn.style.display = currentIndex === 0 ? 'none' : 'flex';
            if (nextBtn) nextBtn.style.display = currentIndex >= maxIndex() ? 'none' : 'flex';

            // If the track has a CSS transition, wait for transitionend to compute active item and update dots
            const style = window.getComputedStyle(track);
            const transDuration = parseFloat(style.transitionDuration || '0') || 0;
            if (transDuration > 0) {
                // transitionend listener will call updateDots
            } else {
                // No transition: update dots in next animation frame
                requestAnimationFrame(() => updateDots());
            }
        }

        function clampIndex() {
            currentIndex = Math.max(0, Math.min(currentIndex, maxIndex()));
        }

        if (prevBtn) prevBtn.addEventListener('click', () => {
            currentIndex = currentIndex - itemsPerView;
            clampIndex();
            try { console.debug('prev clicked -> currentIndex:', currentIndex); } catch (e) {}
            update();
            try { console.debug('post-update -> dotIndex:', Math.floor(currentIndex / itemsPerView)); } catch (e) {}
        });
        if (nextBtn) nextBtn.addEventListener('click', () => {
            currentIndex = currentIndex + itemsPerView;
            clampIndex();
            try { console.debug('next clicked -> currentIndex:', currentIndex); } catch (e) {}
            update();
            try { console.debug('post-update -> dotIndex:', Math.floor(currentIndex / itemsPerView)); } catch (e) {}
        });

        window.addEventListener('resize', () => {
            const oldPerView = itemsPerView;
            updateMeasurements();
            // refresh item list (in case sizes or markup changed)
            items = Array.from(track.children);
            if (oldPerView !== itemsPerView) {
                createDots();
                currentIndex = Math.floor(currentIndex / itemsPerView) * itemsPerView;
            }
            clampIndex();
            update();
        });

        // Touch drag support (basic)
        let isDown = false; let startX; let scrollStart;
        track.addEventListener('mousedown', (e) => { isDown = true; startX = e.pageX; scrollStart = currentIndex * itemWidth; track.style.transition = 'none'; pauseAutoplay(); });
        window.addEventListener('mouseup', () => { if (isDown) { track.style.transition = ''; isDown = false; resumeAutoplay(); } });
        window.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            const diff = e.pageX - startX;
            const delta = Math.round(-diff / itemWidth);
            currentIndex = Math.max(0, Math.min(maxIndex(), Math.round(scrollStart / itemWidth) + delta));
            update();
        });

        // Touch
        track.addEventListener('touchstart', (e) => { startX = e.touches[0].pageX; scrollStart = currentIndex * itemWidth; pauseAutoplay(); });
        track.addEventListener('touchmove', (e) => {
            const diff = e.touches[0].pageX - startX;
            const delta = Math.round(-diff / itemWidth);
            currentIndex = Math.max(0, Math.min(maxIndex(), Math.round(scrollStart / itemWidth) + delta));
            update();
        });
        track.addEventListener('touchend', () => { resumeAutoplay(); });

        // Autoplay support
        let autoplayTimer = null;
        const autoplayAttr = parseInt(container.getAttribute('data-autoplay') || '0', 10);
        const canAutoplay = autoplayAttr > 0;

        function startAutoplay() {
            if (!canAutoplay) return;
            clearInterval(autoplayTimer);
            autoplayTimer = setInterval(() => {
                currentIndex = Math.min(maxIndex(), currentIndex + itemsPerView);
                if (currentIndex >= maxIndex()) currentIndex = 0;
                try { console.debug('autoplay -> currentIndex:', currentIndex); } catch (e) {}
                update();
            }, autoplayAttr);
        }
        function pauseAutoplay() { if (autoplayTimer) clearInterval(autoplayTimer); }
        function resumeAutoplay() { if (canAutoplay) startAutoplay(); }

        // keyboard navigation
        container.setAttribute('tabindex', '0');
        container.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') { currentIndex = Math.max(0, currentIndex - itemsPerView); clampIndex(); update(); pauseAutoplay(); }
            if (e.key === 'ArrowRight') { currentIndex = Math.min(maxIndex(), currentIndex + itemsPerView); clampIndex(); update(); pauseAutoplay(); }
        });

        // hover pause
        container.addEventListener('mouseenter', pauseAutoplay);
        container.addEventListener('mouseleave', resumeAutoplay);

        // analytics for card clicks
        track.querySelectorAll('a.card-item').forEach(a => {
            a.addEventListener('click', (ev) => {
                try {
                    const payload = { event: 'home_carousel_card_click', label: a.getAttribute('href') };
                    window.dataLayer = window.dataLayer || [];
                    window.dataLayer.push(payload);
                    // fallback console
                    console.info('Analytics:', payload);
                } catch (err) { /* noop */ }
            });
        });

        // Recalculate measurements when images finish loading (fixes offset issues)
        items.forEach(it => {
            const img = it.querySelector('img');
            if (img && !img.complete) {
                img.addEventListener('load', () => {
                    updateMeasurements();
                    clampIndex();
                    update();
                });
            }
        });

        // Ensure dots reflect final position after transition completes
        track.addEventListener('transitionend', (e) => {
            try { console.debug('transitionend -> propertyName:', e.propertyName); } catch (er) {}
            updateDots();
        });

        // Initialize
        updateMeasurements();
        createDots();
        clampIndex();
        update();
        if (canAutoplay) startAutoplay();
    }
});