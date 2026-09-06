// =========================
// Image upload preview
// =========================

function previewImage(input, imgId, placeholderId, hiddenFieldId) {
  const file = input.files && input.files[0];
  if (!file) return;

  const reader = new FileReader();
  reader.onload = (e) => {
    const img = document.getElementById(imgId);
    img.src = e.target.result;
    img.style.display = "block";
    document.getElementById(placeholderId).style.display = "none";
    document.getElementById(hiddenFieldId).value = e.target.result;
    img.closest(".upload-box").classList.add("has-image");
  };
  reader.readAsDataURL(file);
}

function setImagePreview(imgId, placeholderId, hiddenFieldId, url) {
  const img = document.getElementById(imgId);
  if (url) {
    img.src = url;
    img.style.display = "block";
    document.getElementById(placeholderId).style.display = "none";
    document.getElementById(hiddenFieldId).value = url;
    img.closest(".upload-box").classList.add("has-image");
  } else {
    img.src = "";
    img.style.display = "none";
    document.getElementById(placeholderId).style.display = "flex";
    document.getElementById(hiddenFieldId).value = "";
    img.closest(".upload-box").classList.remove("has-image");
  }
}

// =========================
// Modal open / close
// =========================

function openRestaurantModal(restaurant) {
  const overlay = document.getElementById("restaurantModalOverlay");
  const title = document.getElementById("restaurantModalTitle");
  const submitBtn = document.getElementById("restaurantSubmitBtn");

  document.getElementById("restaurantForm").reset();
  document.getElementById("fieldCoverFile").value = "";
  document.getElementById("fieldLogoFile").value = "";

  if (restaurant) {
    // Edit mode — prefill from the card's data
    title.textContent = "Edit restaurant";
    submitBtn.textContent = "Save changes";

    document.getElementById("restaurantId").value = restaurant.id;
    document.getElementById("fieldName").value = restaurant.name || "";
    document.getElementById("fieldCuisine").value = restaurant.cuisine || "";
    document.getElementById("fieldAddress").value = restaurant.address || "";
    document.getElementById("fieldPhone").value = restaurant.phone || "";
    document.getElementById("fieldEmail").value = restaurant.email || "";
    document.getElementById("fieldLat").value = restaurant.latitude ?? "";
    document.getElementById("fieldLng").value = restaurant.longitude ?? "";
    document.getElementById("fieldIsEnabled").checked = !!restaurant.is_enabled;

    setImagePreview(
      "coverPreviewImg",
      "coverPlaceholder",
      "fieldCoverDataUrl",
      restaurant.cover_image || "",
    );
    setImagePreview(
      "logoPreviewImg",
      "logoPlaceholder",
      "fieldLogoDataUrl",
      restaurant.logo || "",
    );
  } else {
    // Create mode
    title.textContent = "Add restaurant";
    submitBtn.textContent = "Add restaurant";
    document.getElementById("restaurantId").value = "";
    document.getElementById("fieldIsEnabled").checked = true;
    initRestaurantMap(null, null);

    setImagePreview(
      "coverPreviewImg",
      "coverPlaceholder",
      "fieldCoverDataUrl",
      "",
    );
    setImagePreview(
      "logoPreviewImg",
      "logoPlaceholder",
      "fieldLogoDataUrl",
      "",
    );
  }

  overlay.classList.add("show");
}

function closeRestaurantModal() {
  document.getElementById("restaurantModalOverlay").classList.remove("show");
}

// close on backdrop click
document
  .getElementById("restaurantModalOverlay")
  .addEventListener("click", (e) => {
    if (e.target.id === "restaurantModalOverlay") closeRestaurantModal();
  });

// =========================
// Live search (client-side)
// =========================

function filterRestaurants(query) {
  const q = query.trim().toLowerCase();
  const cards = document.querySelectorAll(".restaurant-card");
  let visibleCount = 0;

  cards.forEach((card) => {
    const match = card.dataset.search.includes(q);
    card.style.display = match ? "" : "none";
    if (match) visibleCount++;
  });

  document.getElementById("restaurantsEmptyState").style.display =
    visibleCount === 0 ? "block" : "none";
}

// =========================
// Toggle enable / disable
// =========================

async function toggleRestaurantEnabled(checkbox, restaurantId) {
  const card = checkbox.closest(".restaurant-card");

  const badge = card.querySelector("[data-enabled-badge]");

  const label = checkbox
    .closest(".toggle-switch")
    .querySelector("[data-toggle-label]");

  const isEnabled = checkbox.checked;

  // Update UI
  badge.textContent = isEnabled ? "Enabled" : "Disabled";

  badge.classList.toggle("badge-enabled", isEnabled);
  badge.classList.toggle("badge-disabled", !isEnabled);

  label.textContent = isEnabled ? "Enabled" : "Disabled";

  // Send PATCH request
  try {
    const response = await fetch("/admin/restaurants/status", {
      method: "PATCH",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `id=${restaurantId}&is_enabled=${isEnabled ? 1 : 0}`,
    });

    const data = await response.json();

    if (!data.success) {
      throw new Error("Failed to update restaurant");
    }

    showToast(
      isEnabled ? "Restaurant enabled" : "Restaurant disabled",
      "success",
    );
  } catch (error) {
    console.error(error);

    // Revert UI if request failed
    checkbox.checked = !isEnabled;

    badge.textContent = !isEnabled ? "Enabled" : "Disabled";

    badge.classList.toggle("badge-enabled", !isEnabled);
    badge.classList.toggle("badge-disabled", isEnabled);

    label.textContent = !isEnabled ? "Enabled" : "Disabled";

    showToast("Failed to update restaurant", "error");
  }
}

// =========================
// Add / Edit submit
// =========================

async function saveRestaurant(event) {
  event.preventDefault();

  const formData = new FormData();

  formData.append("name", document.getElementById("fieldName").value);

  formData.append("cuisine", document.getElementById("fieldCuisine").value);

  formData.append("address", document.getElementById("fieldAddress").value);

  formData.append("phone", document.getElementById("fieldPhone").value);

  formData.append("email", document.getElementById("fieldEmail").value);

  formData.append("latitude", document.getElementById("fieldLat").value);

  formData.append("longitude", document.getElementById("fieldLng").value);

  formData.append(
    "is_enabled",
    document.getElementById("fieldIsEnabled").checked ? "1" : "0",
  );

  const logoFile = document.getElementById("fieldLogoFile").files[0];

  if (logoFile) {
    formData.append("logo", logoFile);
  }

  const bannerFile = document.getElementById("fieldCoverFile").files[0];

  if (bannerFile) {
    formData.append("banner", bannerFile);
  }

  try {
    const response = await fetch("/admin/restaurants/store", {
      method: "POST",
      body: formData,
    });

    const data = await response.json();

    if (!data.success) {
      console.error(data);
      return false;
    }

    closeRestaurantModal();

    location.reload();
  } catch (error) {
    console.error(error);
  }

  return false;
}

function updateRestaurantCard(data) {
  const card = document.querySelector(`.restaurant-card[data-id="${data.id}"]`);
  if (!card) return;

  card.querySelector(".restaurant-card-name").textContent = data.name;
  card.querySelector(".restaurant-card-cuisine").textContent = data.cuisine;
  card.querySelector(".restaurant-email").lastChild.textContent =
    " " + data.email;
  card.dataset.search = (data.name + " " + data.cuisine).toLowerCase();

  const cover = card.querySelector(".restaurant-cover");
  cover.style.backgroundImage = `url('${data.cover_image}')`;
  card.querySelector(".restaurant-logo").src = data.logo;
}

function prependRestaurantCard(data) {
  const grid = document.getElementById("restaurantGrid");
  const card = document.createElement("div");

  card.className = "restaurant-card";
  card.dataset.id = data.id;
  card.dataset.search = (data.name + " " + data.cuisine).toLowerCase();

  card.innerHTML = `
    <div class="restaurant-cover" style="background-image:url('${data.cover_image}')">
      <div class="restaurant-cover-scrim"></div>
      <div class="restaurant-cover-identity">
        <img class="restaurant-logo" src="${data.logo}" alt="">
        <div>
          <p class="restaurant-card-name">${data.name}</p>
          <p class="restaurant-card-cuisine">${data.cuisine}</p>
        </div>
      </div>
      <div class="restaurant-cover-badges">
        <span class="badge badge-closed">Closed</span>
        <span class="badge ${data.is_enabled ? "badge-enabled" : "badge-disabled"}" data-enabled-badge>
          ${data.is_enabled ? "Enabled" : "Disabled"}
        </span>
      </div>
    </div>
    <div class="restaurant-body">
      <div class="restaurant-meta">
        <span>0.0 (0)</span>
        <span>— km</span>
        <span class="restaurant-email">${data.email}</span>
      </div>
      <div class="restaurant-actions">
        <label class="toggle-switch">
          <input type="checkbox" ${data.is_enabled ? "checked" : ""}
                 onchange="toggleRestaurantEnabled(this, '${data.id}')">
          <span class="toggle-slider"></span>
          <span class="toggle-label" data-toggle-label>${data.is_enabled ? "Enabled" : "Disabled"}</span>
        </label>
        <button class="btn-outline btn-sm" onclick='openRestaurantModal(${JSON.stringify(data)})'>
          Edit
        </button>
      </div>
    </div>
  `;

  grid.prepend(card);
}

// =========================
// Map picker
// =========================

let restaurantMap = null;
let restaurantMarker = null;

function initRestaurantMap(lat, lng) {
  const startLat = lat || 30.0444; // Cairo fallback
  const startLng = lng || 31.2357;

  if (!restaurantMap) {
    restaurantMap = L.map("restaurantMap").setView([startLat, startLng], 12);

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
      attribution: "© OpenStreetMap contributors",
    }).addTo(restaurantMap);

    restaurantMap.on("click", (e) => {
      setRestaurantMarker(e.latlng.lat, e.latlng.lng);
    });
  } else {
    restaurantMap.setView([startLat, startLng], 12);
  }

  if (lat && lng) {
    setRestaurantMarker(lat, lng);
  } else if (restaurantMarker) {
    restaurantMap.removeLayer(restaurantMarker);
    restaurantMarker = null;
  }

  // Leaflet needs a resize kick since the modal was just made visible
  setTimeout(() => restaurantMap.invalidateSize(), 200);
}

function setRestaurantMarker(lat, lng) {
  if (restaurantMarker) {
    restaurantMarker.setLatLng([lat, lng]);
  } else {
    restaurantMarker = L.marker([lat, lng], { draggable: true }).addTo(
      restaurantMap,
    );
    restaurantMarker.on("dragend", () => {
      const pos = restaurantMarker.getLatLng();
      updateLatLngFields(pos.lat, pos.lng);
    });
  }
  updateLatLngFields(lat, lng);
}

function updateLatLngFields(lat, lng) {
  document.getElementById("fieldLat").value = lat.toFixed(6);
  document.getElementById("fieldLng").value = lng.toFixed(6);
}

// =========================
// Toasts
// =========================

function showToast(message, type) {
  const stack = document.getElementById("toastStack");
  const toast = document.createElement("div");

  toast.className = "toast";
  toast.textContent = message;

  stack.appendChild(toast);

  setTimeout(() => {
    toast.style.opacity = "0";
    toast.style.transition = "opacity .3s";
    setTimeout(() => toast.remove(), 300);
  }, 2600);
}
