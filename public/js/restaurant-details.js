document.addEventListener("DOMContentLoaded", function () {
  // =========================
  // TABS
  // =========================

  const tabs = document.querySelectorAll(".tab");
  const tabContents = document.querySelectorAll(".tab-content");

  tabs.forEach(function (tab) {
    tab.addEventListener("click", function () {
      const tabName = tab.dataset.tab;

      tabs.forEach(function (item) {
        item.classList.remove("active");
      });

      tabContents.forEach(function (content) {
        content.classList.remove("active");
      });

      tab.classList.add("active");

      const content = document.getElementById(tabName);

      if (content) {
        content.classList.add("active");
      }
    });
  });

  // =========================
  // CATEGORIES
  // =========================

  const categories = document.querySelectorAll(".category");
  const products = document.querySelectorAll(".product-card");

  function filterProductsByCategory(category) {
    products.forEach(function (product) {
      product.style.display =
        product.dataset.category === category ? "flex" : "none";
    });
  }

  categories.forEach(function (category) {
    category.addEventListener("click", function () {
      const categoryName = category.dataset.category;

      categories.forEach(function (item) {
        item.classList.remove("active");
      });

      category.classList.add("active");

      filterProductsByCategory(categoryName);
    });
  });

  const initialCategory = document.querySelector(".category.active");

  if (initialCategory) {
    filterProductsByCategory(initialCategory.dataset.category);
  }

  // =========================
  // ADD TO CART
  // =========================

  const addButtons = document.querySelectorAll(".add-product");

  addButtons.forEach(function (button) {
    button.addEventListener("click", function (event) {
      event.stopPropagation();

     const product = {
       id: button.dataset.productId,
       name: button.dataset.productName,
       price: parseFloat(button.dataset.productPrice),
       image: button.dataset.productImage,
       restaurantId: button.dataset.restaurantId,
       deliveryFee: parseFloat(button.dataset.deliveryFee),
       deliveryTime: parseInt(button.dataset.deliveryTime),
       qty: 1,
     };

      let cart = JSON.parse(localStorage.getItem("cart")) || [];

      // Cart is empty
      if (cart.length === 0) {
        addProductToCart(product);
        return;
      }

      // Check if product belongs to the same restaurant
      const sameRestaurant = cart.every(function (item) {
        return String(item.restaurantId) === String(product.restaurantId);
      });

      if (sameRestaurant) {
        addProductToCart(product);
        return;
      }

      // Different restaurant
      showNewCartModal(product);
    });
  });

  function addProductToCart(product) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    const existing = cart.find(function (item) {
      return item.id === product.id;
    });

    if (existing) {
      existing.qty += 1;
    } else {
      cart.push(product);
    }

    localStorage.setItem("cart", JSON.stringify(cart));

    updateCartBadge();
  }

  function updateCartBadge() {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const badge = document.querySelector(".cart-badge");

    if (!badge) {
      return;
    }

    const totalQty = cart.reduce(function (sum, item) {
      return sum + item.qty;
    }, 0);

    badge.textContent = totalQty;
  }

  // =========================
  // NEW CART MODAL
  // =========================

  function showNewCartModal(product) {
    const existingModal = document.getElementById("newCartModal");

    if (existingModal) {
      existingModal.remove();
    }

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
        <button type="button" class="new-cart-cancel">
          Cancel
        </button>

        <button type="button" class="new-cart-confirm">
          Start New Cart
        </button>
      </div>

    </div>
  `;

    document.body.appendChild(modal);

    document.body.style.overflow = "hidden";

    const cancelButton = modal.querySelector(".new-cart-cancel");
    const confirmButton = modal.querySelector(".new-cart-confirm");

    function closeNewCartModal() {
      modal.remove();
      document.body.style.overflow = "";
    }

    cancelButton.addEventListener("click", function () {
      closeNewCartModal();
    });

    confirmButton.addEventListener("click", function () {
      localStorage.removeItem("cart");

      addProductToCart(product);

      closeNewCartModal();
    });

    modal.addEventListener("click", function (event) {
      if (event.target === modal) {
        closeNewCartModal();
      }
    });
  }

  // =========================
  // REVIEW MODAL
  // =========================

  const reviewModal = document.getElementById("reviewModal");
  const openReviewModalBtn = document.getElementById("openReviewModal");
  const closeReviewModalBtn = document.getElementById("closeReviewModal");
  const reviewForm = document.getElementById("reviewForm");
  const starPicker = document.getElementById("starPicker");
  const starInputs = document.querySelectorAll(".star-input");
  const ratingValueInput = document.getElementById("ratingValue");
  const reviewsList = document.getElementById("reviewsList");

  let selectedRating = 0;

  // =========================
  // OPEN / CLOSE MODAL
  // =========================

  function openModal() {
    if (!reviewModal) {
      return;
    }

    reviewModal.classList.add("active");
    document.body.style.overflow = "hidden";
  }

  function closeModal() {
    if (!reviewModal) {
      return;
    }

    reviewModal.classList.remove("active");
    document.body.style.overflow = "";

    if (reviewForm) {
      reviewForm.reset();
    }

    selectedRating = 0;

    updateStarDisplay(0);
  }

  if (openReviewModalBtn) {
    openReviewModalBtn.addEventListener("click", openModal);
  }

  if (closeReviewModalBtn) {
    closeReviewModalBtn.addEventListener("click", closeModal);
  }

  if (reviewModal) {
    reviewModal.addEventListener("click", function (event) {
      if (event.target === reviewModal) {
        closeModal();
      }
    });
  }

  // =========================
  // STAR PICKER
  // =========================

  function updateStarDisplay(value) {
    starInputs.forEach(function (star) {
      const starValue = parseInt(star.dataset.value);

      star.classList.toggle("selected", starValue <= value);
    });
  }

  starInputs.forEach(function (star) {
    star.addEventListener("mouseenter", function () {
      updateStarDisplay(parseInt(star.dataset.value));
    });

    star.addEventListener("click", function () {
      selectedRating = parseInt(star.dataset.value);

      ratingValueInput.value = selectedRating;

      updateStarDisplay(selectedRating);
    });
  });

  if (starPicker) {
    starPicker.addEventListener("mouseleave", function () {
      updateStarDisplay(selectedRating);
    });
  }

  // =========================
  // SUBMIT REVIEW
  // =========================

  if (reviewForm) {
    reviewForm.addEventListener("submit", function (event) {
      event.preventDefault();

      const commentInput = document.getElementById("reviewComment");

      const comment = commentInput.value.trim();

      if (selectedRating === 0 || !comment) {
        return;
      }

      const restaurantId = new URLSearchParams(window.location.search).get(
        "id",
      );

      if (!restaurantId) {
        return;
      }

      const submitButton = reviewForm.querySelector(".submit-review-btn");

      submitButton.disabled = true;

      fetch("/customer/restaurant-details/review", {
        method: "POST",

        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },

        body: new URLSearchParams({
          restaurant_id: restaurantId,
          rating: selectedRating,
          comment: comment,
        }),
      })
        .then(function (response) {
          return response.json().then(function (data) {
            if (!response.ok) {
              throw new Error(data.message || "Failed to submit review.");
            }

            return data;
          });
        })

        .then(function (data) {
          if (!data.success) {
            throw new Error(data.message || "Failed to submit review.");
          }

          updateReviewList(data.review);

          updateRestaurantRating(data.rating, data.review_count);

          closeModal();
        })

        .catch(function (error) {
          console.error("Review submission failed:", error);
        })

        .finally(function () {
          submitButton.disabled = false;
        });
    });
  }

  // =========================
  // UPDATE REVIEW LIST
  // =========================

  function updateReviewList(review) {
    if (!reviewsList) {
      return;
    }

    const existingReview = reviewsList.querySelector(
      `[data-review-id="${review.id}"]`,
    );

    if (existingReview) {
      existingReview.outerHTML = createReviewCard(review);
      return;
    }

    const emptyState = reviewsList.querySelector(".empty-state");

    if (emptyState) {
      emptyState.remove();
    }

    reviewsList.insertAdjacentHTML("afterbegin", createReviewCard(review));
  }

  // =========================
  // CREATE REVIEW CARD
  // =========================

  function createReviewCard(review) {
    const initial = review.customer_name
      ? review.customer_name.charAt(0).toUpperCase()
      : "?";

    return `
      <article
        class="review-card"
        data-review-id="${review.id}">

        <div class="review-header">

          <div class="review-avatar">
            ${escapeHtml(initial)}
          </div>

          <div>
            <strong>
              ${escapeHtml(review.customer_name)}
            </strong>

            <p>
              ${escapeHtml(review.created_at)}
            </p>
          </div>

          <div class="review-rating">
            ${"★".repeat(Number(review.rating))}
          </div>

        </div>

        <p class="review-comment">
          ${escapeHtml(review.comment)}
        </p>

      </article>
    `;
  }

  // =========================
  // UPDATE RESTAURANT RATING
  // =========================

  function updateRestaurantRating(rating, reviewCount) {
    const numericRating = Number(rating);

    // Reviews average
    const reviewsAverage = document.querySelector(".reviews-avg");

    if (reviewsAverage) {
      reviewsAverage.textContent = numericRating;
    }

    // Reviews count
    const reviewsCountText = document.querySelector(".reviews-count-text");

    if (reviewsCountText) {
      reviewsCountText.textContent = "Based on " + reviewCount + " reviews";
    }

    // Reviews stars
    const reviewsStars = document.getElementById("reviewsStars");

    if (reviewsStars) {
      const roundedRating = Math.round(numericRating);

      reviewsStars.textContent =
        "★".repeat(roundedRating) + "☆".repeat(5 - roundedRating);
    }

    // Restaurant stats
    const stats = document.querySelectorAll(".restaurant-stats .stat");

    if (stats.length > 0) {
      const ratingElement = stats[0].querySelector("strong");

      if (ratingElement) {
        ratingElement.textContent = numericRating;
      }

      const reviewCountElement = stats[0].querySelector(".review-count");

      if (reviewCountElement) {
        reviewCountElement.textContent = "(" + reviewCount + " reviews)";
      }
    }
  }

  // =========================
  // ESCAPE HTML
  // =========================

  function escapeHtml(value) {
    const div = document.createElement("div");

    div.textContent = value ?? "";

    return div.innerHTML;
  }
});
