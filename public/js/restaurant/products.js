const searchInput = document.getElementById("search");

if (searchInput) {
  const productCards = document.querySelectorAll(".product-card");

  searchInput.addEventListener("input", function () {
    const query = this.value.trim().toLowerCase();

    productCards.forEach((card) => {
      const name =
        card.querySelector(".product-info h3")?.textContent.toLowerCase() || "";
      const category =
        card.querySelector(".product-category")?.textContent.toLowerCase() ||
        "";

      const matches = name.includes(query) || category.includes(query);

      card.style.display = matches ? "" : "none";
    });
  });
}

document.querySelectorAll(".availability-toggle").forEach((toggle) => {
  toggle.addEventListener("change", async function () {
    const productId = this.dataset.productId;
    const isAvailable = this.checked;

    const formData = new FormData();
    formData.append("id", productId);
    formData.append("is_available", isAvailable ? "1" : "0");

    try {
      const response = await fetch("/restaurant/products/availability", {
        method: "POST",
        body: formData,
      });

      const data = await response.json();

      if (!data.success) {
        this.checked = !isAvailable; // revert on failure
        console.error(data.message);
        return;
      }

      // update the visible availability text on the same card
      const card = this.closest(".product-card");
      const statusText = card.querySelector(".availability-text");

      if (statusText) {
        statusText.textContent = isAvailable ? "Available" : "Unavailable";
        statusText.classList.toggle("is-available", isAvailable);
        statusText.classList.toggle("is-unavailable", !isAvailable);
      }
    } catch (error) {
      this.checked = !isAvailable; // revert on failure
      console.error(error);
    }
  });
});

document.querySelectorAll(".delete-product-button").forEach((button) => {
  button.addEventListener("click", async function (event) {
    event.preventDefault();

    const productIdToDelete = this.dataset.productId;

    if (
      !window.confirm(
        "Are you sure you want to delete this product? This cannot be undone.",
      )
    ) {
      return;
    }

    const formData = new FormData();
    formData.append("id", productIdToDelete);

    try {
      const response = await fetch("/restaurant/products/delete", {
        method: "POST",
        body: formData,
      });

      const data = await response.json();

      if (!data.success) {
        console.error(data.message);
        alert(data.message);
        return;
      }

      const card = this.closest(".product-card");
      if (card) {
        card.remove();
      }
    } catch (error) {
      console.error(error);
      alert("Something went wrong. Please try again.");
    }
  });
});
