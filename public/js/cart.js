document.addEventListener("DOMContentLoaded", function () {
  const orderButton = document.getElementById("featuredProductOrder");
  const featuredProduct = document.querySelector(".featured-product");

  if (!orderButton || !featuredProduct) {
    return;
  }

  function addProductToCart(product) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    const existingProduct = cart.find(function (item) {
      return String(item.id) === String(product.id);
    });

    if (existingProduct) {
      existingProduct.qty += 1;
    } else {
      cart.push(product);
    }

    localStorage.setItem("cart", JSON.stringify(cart));
  }

  function showNewCartModal(product) {
    // Remove an existing modal
    const oldModal = document.getElementById("newCartModal");

    if (oldModal) {
      oldModal.remove();
    }

    // Create modal
    const modal = document.createElement("div");

    modal.id = "newCartModal";

    modal.innerHTML = `
            <div class="new-cart-modal">

                <div class="new-cart-icon">
                    <span>+</span>
                </div>

                <h3>Start a new cart?</h3>

                <p>
                    Your cart contains items from another restaurant.
                    Do you want to clear your current cart and start a new one?
                </p>

                <div class="new-cart-actions">

                    <button
                        type="button"
                        class="new-cart-cancel">
                        Cancel
                    </button>

                    <button
                        type="button"
                        class="new-cart-confirm">
                        Start New Cart
                    </button>

                </div>

            </div>
        `;

    document.body.appendChild(modal);

    document.body.style.overflow = "hidden";

    const cancelButton = modal.querySelector(".new-cart-cancel");

    const confirmButton = modal.querySelector(".new-cart-confirm");

    function closeModal() {
      modal.remove();
      document.body.style.overflow = "";
    }

    // Cancel
    cancelButton.addEventListener("click", function () {
      closeModal();
    });

    // Start new cart
    confirmButton.addEventListener("click", function () {
      localStorage.removeItem("cart");

      addProductToCart(product);

      closeModal();

      window.location.href = "/customer/cart";
    });

    // Click outside modal
    modal.addEventListener("click", function (event) {
      if (event.target === modal) {
        closeModal();
      }
    });
  }

  orderButton.addEventListener("click", function () {
    const product = {
      id: featuredProduct.dataset.productId,
      name: featuredProduct.dataset.productName,
      price: parseFloat(featuredProduct.dataset.productPrice),
      image: featuredProduct.dataset.productImage,
      restaurantId: featuredProduct.dataset.restaurantId,
      deliveryFee: parseFloat(featuredProduct.dataset.deliveryFee),
      deliveryTime: parseInt(featuredProduct.dataset.deliveryTime),
      qty: 1,
    };

    const cart = JSON.parse(localStorage.getItem("cart")) || [];

    // Different restaurant
    if (
      cart.length > 0 &&
      String(cart[0].restaurantId) !== String(product.restaurantId)
    ) {
      showNewCartModal(product);

      return;
    }

    // Empty cart or same restaurant
    addProductToCart(product);

    window.location.href = "/customer/cart";
  });
});
