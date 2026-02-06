document.addEventListener('DOMContentLoaded', function() {
    const wrapper = document.querySelector('.booking-form-wrapper');
    if (!wrapper) return;

    const bookingDateEl = document.getElementById('booking_date');
    const durationEl = document.getElementById('duration');
    const durationUnitEl = document.getElementById('duration_unit');
    const totalEl = document.getElementById('total');

    const pricePerMonth = parseFloat(wrapper.dataset.priceMonth || 0);
    const pricePerYear = parseFloat(wrapper.dataset.priceYear || 0);
    const pricePerNight = parseFloat(wrapper.dataset.priceNight || 0);

    function formatRupiah(value) {
        return 'Rp ' + value.toLocaleString('id-ID');
    }

    function updatePrice() {
        const duration = parseInt(durationEl?.value || 0, 10);
        const unit = durationUnitEl?.value || 'month';
        let total = 0;

        if (duration > 0) {
            if (unit === 'month' && pricePerMonth > 0) {
                total = duration * pricePerMonth;
            } else if (unit === 'year' && pricePerYear > 0) {
                total = duration * pricePerYear;
            } else if (unit === 'night' && pricePerNight > 0) {
                total = duration * pricePerNight;
            }
        }

        if (totalEl) {
            totalEl.textContent = total > 0 ? formatRupiah(total) : '–';
        }
    }

    if (durationEl) {
        durationEl.addEventListener('change', updatePrice);
        durationUnitEl && durationUnitEl.addEventListener('change', updatePrice);
        updatePrice();
    }
});