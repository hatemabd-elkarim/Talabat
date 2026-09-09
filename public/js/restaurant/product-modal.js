document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById("productModal");
  const openAddButton = document.getElementById("openAddProductModal");
  const closeButton = document.getElementById("closeProductModal");
  const cancelButton = document.getElementById("cancelProductForm");
  const form = document.getElementById("productForm");
  const modalTitle = document.getElementById("productModalTitle");
  const submitButton = document.getElementById("submitProductButton");

  const productId = document.getElementById("productId");
  const productName = document.getElementById("productName");
  const productDescription = document.getElementById("productDescription");
  const productPrice = document.getElementById("productPrice");
  const productCategory = document.getElementById("productCategory");
  const availabilityToggle = document.getElementById("availabilityToggle");
  const availabilityStatus = document.getElementById("availabilityStatus");
  const message = document.getElementById("productFormMessage");
  const nameGroup = document.getElementById("nameGroup");
  const priceGroup = document.getElementById("priceGroup");
  const nameError = document.getElementById("productNameError");
  const priceError = document.getElementById("productPriceError");
  const productImage = document.getElementById("productImage");
  const productImagePreview = document.getElementById("productImagePreview");
  const imageUploadContent = document.getElementById("imageUploadContent");

  let mode = "add";

  function updateAvailability() {
    const isAvailable = availabilityToggle.checked;
    availabilityStatus.textContent = isAvailable ? "Available" : "Unavailable";
    availabilityStatus.classList.toggle("is-available", isAvailable);
    availabilityStatus.classList.toggle("is-unavailable", !isAvailable);
  }

  function clearValidation() {
    nameGroup.classList.remove("has-error");
    priceGroup.classList.remove("has-error");
    productName.removeAttribute("aria-invalid");
    productPrice.removeAttribute("aria-invalid");
    nameError.textContent = "";
    priceError.textContent = "";
    message.textContent = "";
    message.className = "form-message";
  }

  function resetForm() {
    form.reset();
    productId.value = "";

    availabilityToggle.checked = true;
    updateAvailability();
    clearValidation();

    productImagePreview.style.display = "none";
    productImagePreview.src = "";
    imageUploadContent.style.display = "flex";
  }

  function closeModal() {
    modal.classList.remove("is-open");
    modal.setAttribute("aria-hidden", "true");
    document.body.style.overflow = "";
  }

  function confirmClose() {
    if (window.confirm("Are you sure you want to cancel?")) {
      resetForm();
      closeModal();
    }
  }

  function openModal() {
    modal.classList.add("is-open");
    modal.setAttribute("aria-hidden", "false");
    document.body.style.overflow = "hidden";
    productName.focus();
  }

  function setMode(newMode) {
    mode = newMode;

    if (mode === "edit") {
      modalTitle.textContent = "Edit product";
      submitButton.textContent = "Save changes";
    } else {
      modalTitle.textContent = "Add product";
      submitButton.textContent = "Add product";
    }
  }

  openAddButton.addEventListener("click", function () {
    resetForm();
    setMode("add");
    openModal();
  });

  closeButton.addEventListener("click", confirmClose);
  cancelButton.addEventListener("click", confirmClose);
  availabilityToggle.addEventListener("change", updateAvailability);

  modal.addEventListener("click", function (event) {
    if (event.target === modal) {
      confirmClose();
    }
  });

  document.addEventListener("keydown", function (event) {
    if (event.key === "Escape" && modal.classList.contains("is-open")) {
      confirmClose();
    }
  });

  form.addEventListener("submit", async function (event) {
    event.preventDefault();
    clearValidation();

    let isValid = true;

    if (!productName.value.trim()) {
      nameGroup.classList.add("has-error");
      productName.setAttribute("aria-invalid", "true");
      nameError.textContent = "Product name is required.";
      isValid = false;
    }

    if (!productPrice.value.trim()) {
      priceGroup.classList.add("has-error");
      productPrice.setAttribute("aria-invalid", "true");
      priceError.textContent = "Price is required.";
      isValid = false;
    }

    if (!isValid) {
      message.textContent = "Please complete the required fields.";
      message.className = "form-message error";
      (productName.value.trim() ? productPrice : productName).focus();
      return;
    }

    const formData = new FormData(form);
    const isEdit = mode === "edit";
    const url = isEdit ? "/restaurant/products/update" : "/restaurant/products";

    try {
      const response = await fetch(url, {
        method: "POST",
        body: formData,
      });

      const data = await response.json();

      if (!data.success) {
        message.textContent = data.message;
        message.className = "form-message error";
        return;
      }

      message.textContent = data.message;
      message.className = "form-message success";

      setTimeout(() => {
        resetForm();
        closeModal();
        window.location.reload();
      }, 1000);
    } catch (error) {
      console.error(error);
      message.textContent = "Something went wrong. Please try again.";
      message.className = "form-message error";
    }
  });

  productName.addEventListener("input", function () {
    if (productName.value.trim()) {
      nameGroup.classList.remove("has-error");
      productName.removeAttribute("aria-invalid");
      nameError.textContent = "";
    }
  });

  productPrice.addEventListener("input", function () {
    if (productPrice.value.trim()) {
      priceGroup.classList.remove("has-error");
      productPrice.removeAttribute("aria-invalid");
      priceError.textContent = "";
    }
  });

  productImage.addEventListener("change", () => {
    const file = productImage.files[0];

    if (!file) {
      productImagePreview.style.display = "none";
      imageUploadContent.style.display = "flex";
      productImagePreview.src = "";
      return;
    }

    const reader = new FileReader();

    reader.onload = (event) => {
      productImagePreview.src = event.target.result;
      productImagePreview.style.display = "block";
      imageUploadContent.style.display = "none";
    };

    reader.readAsDataURL(file);
  });

  document.querySelectorAll(".edit-product-button").forEach((button) => {
    button.addEventListener("click", function (event) {
      event.preventDefault();

      resetForm();
      setMode("edit");

      productId.value = this.dataset.productId;
      productName.value = this.dataset.productName;
      productDescription.value = this.dataset.productDescription;
      productPrice.value = this.dataset.productPrice;
      productCategory.value = this.dataset.productCategory;

      const available = this.dataset.productAvailable === "1";
      availabilityToggle.checked = available;
      updateAvailability();

      const image = this.dataset.productImage;

      if (image) {
        productImagePreview.src = image;
        productImagePreview.style.display = "block";
        imageUploadContent.style.display = "none";
      }

      openModal();
    });
  });
});
