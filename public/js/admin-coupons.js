// =========================
// Add / Edit modal
// =========================

function openCouponModal(coupon) {
  const overlay = document.getElementById("couponModalOverlay");
  const title = document.getElementById("couponModalTitle");
  const submitBtn = document.getElementById("couponSubmitBtn");

  document.getElementById("couponForm").reset();

  if (coupon) {
    title.textContent = "Edit coupon";
    submitBtn.textContent = "Save";

    document.getElementById("couponId").value = coupon.id;
    document.getElementById("fieldCode").value = coupon.code || "";
    document.getElementById("fieldDiscountPercent").value =
      coupon.discount_percent ?? "";
    document.getElementById("fieldMaxDiscount").value =
      coupon.max_discount ?? "";
    document.getElementById("fieldMinOrder").value = coupon.min_order ?? "";
    document.getElementById("fieldUsageLimit").value = coupon.usage_limit ?? "";
    document.getElementById("fieldExpiresAt").value = coupon.expires_at || "";
    document.getElementById("fieldIsActive").checked = !!coupon.is_active;
  } else {
    title.textContent = "Create coupon";
    submitBtn.textContent = "Create";
    document.getElementById("couponId").value = "";
    document.getElementById("fieldIsActive").checked = true;
  }

  overlay.classList.add("show");
}

function closeCouponModal() {
  document.getElementById("couponModalOverlay").classList.remove("show");
}

document.getElementById("couponModalOverlay").addEventListener("click", (e) => {
  if (e.target.id === "couponModalOverlay") closeCouponModal();
});

// =========================
// Live search (client-side)
// =========================

function filterCoupons(query) {
  const q = query.trim().toLowerCase();
  const cards = document.querySelectorAll(".coupon-card");
  let visibleCount = 0;

  cards.forEach((card) => {
    const match = card.dataset.search.includes(q);
    card.style.display = match ? "" : "none";
    if (match) visibleCount++;
  });

  document.getElementById("couponsEmptyState").style.display =
    visibleCount === 0 ? "block" : "none";
}

// =========================
// Toggle active / inactive
// =========================

async function toggleCouponActive(checkbox, couponId) {
  const card = checkbox.closest(".coupon-card");
  const isActive = checkbox.checked;

  const statusBadge = card.querySelector("[data-active-badge]");
  const label = checkbox
    .closest(".toggle-switch")
    .querySelector("[data-toggle-label]");

  // Update UI immediately
  statusBadge.textContent = isActive ? "Active" : "Inactive";
  statusBadge.classList.toggle("badge-active", isActive);
  statusBadge.classList.toggle("badge-inactive", !isActive);

  label.textContent = isActive ? "Active" : "Inactive";

  try {
    const response = await fetch("/admin/coupons/status", {
      method: "PATCH",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `id=${couponId}&is_active=${isActive ? 1 : 0}`,
    });

    const data = await response.json();

    if (!response.ok || !data.success) {
      throw new Error("Failed to update coupon status");
    }

    showToast(isActive ? "Coupon activated" : "Coupon deactivated", "success");
  } catch (error) {
    console.error(error);

    // Revert checkbox
    checkbox.checked = !isActive;

    // Revert UI
    statusBadge.textContent = !isActive ? "Active" : "Inactive";
    statusBadge.classList.toggle("badge-active", !isActive);
    statusBadge.classList.toggle("badge-inactive", isActive);

    label.textContent = !isActive ? "Active" : "Inactive";

    showToast("Failed to update coupon status", "error");
  }
}

// =========================
// Add / Edit submit
// =========================

async function saveCoupon(event) {
  event.preventDefault();

  const id = document.getElementById("couponId").value;

  const data = {
    id: id,
    code: document.getElementById("fieldCode").value.trim().toUpperCase(),
    discount_percent:
      parseFloat(document.getElementById("fieldDiscountPercent").value) || 0,
    max_discount:
      parseFloat(document.getElementById("fieldMaxDiscount").value) || 0,
    min_order: parseFloat(document.getElementById("fieldMinOrder").value) || 0,
    usage_limit:
      parseInt(document.getElementById("fieldUsageLimit").value) || 0,
    expires_at: document.getElementById("fieldExpiresAt").value,
    is_active: document.getElementById("fieldIsActive").checked ? 1 : 0,
  };

  if (!data.code) {
    showToast("Coupon code is required", "error");
    return false;
  }

  try {
    const formData = new FormData();

    if (id) {
      formData.append("id", id);
    }

    formData.append("code", data.code);
    formData.append("discount_percent", data.discount_percent);
    formData.append("max_discount", data.max_discount);
    formData.append("min_order", data.min_order);
    formData.append("usage_limit", data.usage_limit);
    formData.append("expires_at", data.expires_at);
    formData.append("is_active", data.is_active);

    const response = await fetch(
      id ? "/admin/coupons/update" : "/admin/coupons/store",
      {
        method: "POST",
        body: formData,
      },
    );

    const result = await response.json();

    if (!response.ok || !result.success) {
      throw new Error(result.message || "Failed to save coupon");
    }

    const coupon = result.coupon;

    // Update existing coupon or add new one
    if (id) {
      updateCouponCard(coupon.id, coupon);
    } else {
      prependCouponCard(coupon);
    }

    closeCouponModal();

    showToast(
      id ? "Coupon updated successfully" : "Coupon created successfully",
      "success",
    );
  } catch (error) {
    console.error(error);
    showToast(error.message || "Failed to save coupon", "error");
  }

  return false;
}

function valueDisplay(data) {
  return data.discount_percent + "% off";
}

function updateCouponCard(id, data) {
  const card = document.querySelector(`.coupon-card[data-id="${id}"]`);
  if (!card) return;

  card.querySelector(".coupon-code").textContent = data.code;
  card.querySelector('[data-field="value_display"]').textContent =
    valueDisplay(data);
  card.querySelector('[data-field="expires"]').textContent = data.expires_at;
  card.dataset.search = data.code.toLowerCase();
  card.dataset.expires = data.expires_at;
}

function prependCouponCard(data) {
  const grid = document.getElementById("couponGrid");
  const card = document.createElement("div");

  card.className = "coupon-card";
  card.dataset.id = data.id;
  card.dataset.search = data.code.toLowerCase();
  card.dataset.expires = data.expires_at;

  card.innerHTML = `
    <div class="coupon-top">
      <div class="coupon-top-left">
        <span class="coupon-code">${data.code}</span>
        <span class="badge ${data.is_active ? "badge-active" : "badge-inactive"}" data-status-badge>
          ${data.is_active ? "Active" : "Inactive"}
        </span>
      </div>
      <div class="coupon-icon-actions">
        <button class="icon-btn icon-btn-edit" onclick='openCouponModal(${JSON.stringify(data)})'>Edit</button>
        <button class="icon-btn icon-btn-delete" onclick="openDeleteModal('${data.id}', '${data.code}')">Del</button>
      </div>
    </div>
    <div class="coupon-details">
      <div class="detail-label">Discount</div>
      <div class="detail-value" data-field="value_display">${valueDisplay(data)}</div>
      <div class="detail-label">Min order</div>
      <div class="detail-value">EGP ${Number(data.min_order).toFixed(2)}</div>
      <div class="detail-label">Max discount</div>
      <div class="detail-value">EGP ${Number(data.max_discount).toFixed(2)}</div>
      <div class="detail-label">Usage</div>
      <div class="detail-value">0/${data.usage_limit}</div>
      <div class="detail-label">Expires</div>
      <div class="detail-value" data-field="expires">${data.expires_at}</div>
    </div>
    <div class="usage-bar"><div class="usage-bar-fill" style="width:0%"></div></div>
    <label class="toggle-switch">
      <input type="checkbox" ${data.is_active ? "checked" : ""}
             onchange="toggleCouponActive(this, '${data.id}')">
      <span class="toggle-slider"></span>
      <span class="toggle-label" data-toggle-label>${data.is_active ? "Active" : "Inactive"}</span>
    </label>
  `;

  grid.prepend(card);
}

// =========================
// Delete confirm
// =========================

let pendingDeleteId = null;

function openDeleteModal(id, code) {
  pendingDeleteId = id;
  document.getElementById("deleteCouponCode").textContent = code;
  document.getElementById("deleteModalOverlay").classList.add("show");
}

function closeDeleteModal() {
  pendingDeleteId = null;
  document.getElementById("deleteModalOverlay").classList.remove("show");
}

document.getElementById("deleteModalOverlay").addEventListener("click", (e) => {
  if (e.target.id === "deleteModalOverlay") closeDeleteModal();
});

async function confirmDeleteCoupon() {
  if (!pendingDeleteId) return;

  try {
    const formData = new FormData();
    formData.append("id", pendingDeleteId);

    const response = await fetch("/admin/coupons/delete", {
      method: "POST",
      body: formData,
    });

    const data = await response.json();

    if (!response.ok || !data.success) {
      throw new Error(data.message || "Failed to delete coupon");
    }

    const card = document.querySelector(
      `.coupon-card[data-id="${pendingDeleteId}"]`,
    );

    if (card) {
      card.remove();
    }

    closeDeleteModal();

    showToast("Coupon deleted successfully", "success");
  } catch (error) {
    console.error(error);
    showToast(error.message || "Failed to delete coupon", "error");
  }
}

// =========================
// Toasts
// =========================

function showToast(message, type) {
  const stack = document.getElementById("toastStack");
  const toast = document.createElement("div");

  toast.className = "toast" + (type === "info" ? " info" : "");
  toast.textContent = message;

  stack.appendChild(toast);

  setTimeout(() => {
    toast.style.opacity = "0";
    toast.style.transition = "opacity .3s";
    setTimeout(() => toast.remove(), 300);
  }, 2600);
}
