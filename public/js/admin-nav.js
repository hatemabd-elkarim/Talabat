function toggleAdminMobileMenu() {
  const mobileMenu = document.getElementById("adminMobileMenu");

  mobileMenu.classList.toggle("show");
}

function navigate(page) {
  const routes = {
    "a-dashboard": "/admin/dashboard",
    "a-restaurants": "/admin/restaurants",
    "a-coupons": "/admin/coupons",
  };

  if (routes[page]) {
    window.location.href = routes[page];
  }
}

function logout() {
  window.location.href = "/logout";
}
