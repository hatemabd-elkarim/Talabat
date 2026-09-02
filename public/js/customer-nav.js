function toggleProfile() {
  const profileDropdown = document.getElementById("profileDropdown");

  profileDropdown.classList.toggle("show");
}

function toggleMobileMenu() {
  const mobileMenu = document.getElementById("mobileMenu");

  mobileMenu.classList.toggle("show");
}

// Close profile dropdown when clicking outside it
document.addEventListener("click", function (event) {
  const profileContainer = document.querySelector(".profile-container");
  const profileDropdown = document.getElementById("profileDropdown");

  if (
    profileContainer &&
    profileDropdown &&
    !profileContainer.contains(event.target)
  ) {
    profileDropdown.classList.remove("show");
  }
});
