document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("search");
  const restaurantCards = document.querySelectorAll(".restaurant-card");

  searchInput.addEventListener("input", function () {
    const searchTerm = searchInput.value.trim().toLowerCase();

    restaurantCards.forEach(function (card) {
      const searchData = card.dataset.search || "";

      if (searchData.includes(searchTerm)) {
        card.style.display = "";
      } else {
        card.style.display = "none";
      }
    });
  });
});
