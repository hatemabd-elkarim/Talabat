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

      document.getElementById(tabName).classList.add("active");
    });
  });

    // =========================
  // CATEGORIES
  // =========================

  const categories = document.querySelectorAll(".category");
  const products = document.querySelectorAll(".product-card");

  function filterProductsByCategory(categoryId) {
    products.forEach(function (product) {
      if (product.dataset.category === categoryId) {
        product.style.display = "flex";
      } else {
        product.style.display = "none";
      }
    });
  }

  categories.forEach(function (category) {
    category.addEventListener("click", function () {
      const categoryId = category.dataset.category;

      categories.forEach(function (item) {
        item.classList.remove("active");
      });

      category.classList.add("active");

      filterProductsByCategory(categoryId);
    });
  });

  // Apply filtering for the initially active category on page load
  const initialCategory = document.querySelector(".category.active");

  if (initialCategory) {
    filterProductsByCategory(initialCategory.dataset.category);
  }

  // =========================
  // ADD TO CART
  // =========================

  const addButtons = document.querySelectorAll(".add-product");

  addButtons.forEach(function (button) {
    button.addEventListener("click", function () {
      const productId = button.dataset.productId;

      console.log("Add product:", productId);
    });
  });
});

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

function openModal() {
  reviewModal.classList.add("active");
  document.body.style.overflow = "hidden";
}

function closeModal() {
  reviewModal.classList.remove("active");
  document.body.style.overflow = "";
  reviewForm.reset();
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
  reviewModal.addEventListener("click", function (e) {
    if (e.target === reviewModal) {
      closeModal();
    }
  });
}

// Star picker interaction
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

// Submit handler
if (reviewForm) {
  reviewForm.addEventListener("submit", function (e) {
    e.preventDefault();

    if (selectedRating === 0) {
      alert("Please select a star rating.");
      return;
    }

    const comment = document.getElementById("reviewComment").value.trim();

    if (!comment) {
      alert("Please write a comment.");
      return;
    }

    // TODO: replace with real POST request to backend
    const newReview = {
      customer_name: "You",
      rating: selectedRating,
      comment: comment,
      created_at: new Date().toISOString().split("T")[0],
    };

    prependReviewCard(newReview);
    closeModal();
  });
}

function prependReviewCard(review) {
  // Remove empty state if present
  const emptyState = reviewsList.querySelector(".empty-state");
  if (emptyState) {
    emptyState.remove();
  }

  const card = document.createElement("article");
  card.className = "review-card";

  card.innerHTML = `
      <div class="review-header">
        <div class="review-avatar">${review.customer_name[0].toUpperCase()}</div>
        <div>
          <strong>${review.customer_name}</strong>
          <p>${review.created_at}</p>
        </div>
        <div class="review-rating">${"★".repeat(review.rating)}</div>
      </div>
      <p class="review-comment">${review.comment}</p>
    `;

  reviewsList.prepend(card);
}
