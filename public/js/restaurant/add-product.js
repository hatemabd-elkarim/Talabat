document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('addProductModal');
    const openButton = document.getElementById('openAddProductModal');
    const closeButton = document.getElementById('closeAddProductModal');
    const cancelButton = document.getElementById('cancelAddProduct');
    const form = document.getElementById('addProductForm');
    const productName = document.getElementById('productName');
    const productPrice = document.getElementById('productPrice');
    const availabilityToggle = document.getElementById('availabilityToggle');
    const availabilityStatus = document.getElementById('availabilityStatus');
    const message = document.getElementById('addProductMessage');
    const nameGroup = document.getElementById('nameGroup');
    const priceGroup = document.getElementById('priceGroup');
    const nameError = document.getElementById('productNameError');
    const priceError = document.getElementById('productPriceError');

    function updateAvailability() {
        const isAvailable = availabilityToggle.checked;

        availabilityStatus.textContent = isAvailable ? 'Available' : 'Unavailable';
        availabilityStatus.classList.toggle('is-available', isAvailable);
        availabilityStatus.classList.toggle('is-unavailable', !isAvailable);
    }

    function clearValidation() {
        nameGroup.classList.remove('has-error');
        priceGroup.classList.remove('has-error');
        productName.removeAttribute('aria-invalid');
        productPrice.removeAttribute('aria-invalid');
        nameError.textContent = '';
        priceError.textContent = '';
        message.textContent = '';
        message.className = 'form-message';
    }

    function resetForm() {
        form.reset();
        availabilityToggle.checked = true;
        updateAvailability();
        clearValidation();
    }

    function closeModal() {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    function confirmClose() {
        if (window.confirm('Are you sure you want to cancel?')) {
            resetForm();
            closeModal();
        }
    }

    openButton.addEventListener('click', function () {
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        productName.focus();
    });

    closeButton.addEventListener('click', confirmClose);
    cancelButton.addEventListener('click', confirmClose);
    availabilityToggle.addEventListener('change', updateAvailability);

    modal.addEventListener('click', function (event) {
        if (event.target === modal) {
            confirmClose();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && modal.classList.contains('is-open')) {
            confirmClose();
        }
    });

    form.addEventListener('submit', function (event) {
        event.preventDefault();
        clearValidation();

        let isValid = true;

        if (!productName.value.trim()) {
            nameGroup.classList.add('has-error');
            productName.setAttribute('aria-invalid', 'true');
            nameError.textContent = 'Product name is required.';
            isValid = false;
        }

        if (!productPrice.value.trim()) {
            priceGroup.classList.add('has-error');
            productPrice.setAttribute('aria-invalid', 'true');
            priceError.textContent = 'Price is required.';
            isValid = false;
        }

        if (!isValid) {
            message.textContent = 'Please complete the required fields.';
            message.className = 'form-message error';
            (productName.value.trim() ? productPrice : productName).focus();
            return;
        }

        message.textContent = 'Product added successfully!';
        message.className = 'form-message success';
    });

    productName.addEventListener('input', function () {
        if (productName.value.trim()) {
            nameGroup.classList.remove('has-error');
            productName.removeAttribute('aria-invalid');
            nameError.textContent = '';
        }
    });

    productPrice.addEventListener('input', function () {
        if (productPrice.value.trim()) {
            priceGroup.classList.remove('has-error');
            productPrice.removeAttribute('aria-invalid');
            priceError.textContent = '';
        }
    });
});
