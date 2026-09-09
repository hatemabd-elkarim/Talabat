document.querySelectorAll('.availability-toggle').forEach(toggle => {
    toggle.addEventListener('change', function () {

        const card = this.closest('.product-card');
        const status = card.querySelector('.availability-text');

        if (this.checked) {
            status.textContent = 'Available';

            status.classList.remove('is-unavailable');
            status.classList.add('is-available');
        } else {
            status.textContent = 'Unavailable';

            status.classList.remove('is-available');
            status.classList.add('is-unavailable');
        }
    });
});