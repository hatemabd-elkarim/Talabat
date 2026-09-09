const orderTabs = document.querySelectorAll(".orders-tab");
const orders = document.querySelectorAll(".orders-content");

const statusMap = {
  all: ["all"],
  pending: ["pending"],
  active: ["accepted", "preparing", "out for delivery"],
  completed: ["delivered"],
};

const searchInput = document.getElementById("search");

searchInput.addEventListener("input", () => {
  const searchValue = searchInput.value.trim().toLowerCase();

  orders.forEach((order) => {
    const orderId = order.dataset.orderId.toLowerCase();

    const customerName = order
      .querySelector(".order-customer p:first-child")
      .textContent.trim()
      .toLowerCase();

    const matches =
      orderId.includes(searchValue) || customerName.includes(searchValue);

    order.style.display = matches ? "" : "none";
  });
});

function filterOrders(selectedStatus) {
  const selectedStatuses = statusMap[selectedStatus];

  orders.forEach((order) => {
    const orderStatus = order.dataset.orderStatus;

    if (
      selectedStatuses.includes("all") ||
      selectedStatuses.includes(orderStatus)
    ) {
      order.style.display = "";
    } else {
      order.style.display = "none";
    }
  });
}

// =========================
// Order tabs
// =========================

orderTabs.forEach((tab) => {
  tab.addEventListener("click", () => {
    orderTabs.forEach((tab) => {
      tab.classList.remove("active");
    });

    tab.classList.add("active");

    filterOrders(tab.dataset.status);
  });
});

// =========================
// Order actions
// =========================

const actionMap = {
  pending: {
    text: "Accept Order",
    nextStatus: "accepted",
  },

  accepted: {
    text: "Start Preparing",
    nextStatus: "preparing",
  },

  preparing: {
    text: "Send for Delivery",
    nextStatus: "out for delivery",
  },

  "out for delivery": {
    text: "Mark as Delivered",
    nextStatus: "delivered",
  },

  delivered: {
    text: "Delivered",
    nextStatus: null,
  },
};

function createOrderButton(action, order) {
  const currentStatus = order.dataset.orderStatus;
  const actionData = actionMap[currentStatus];

  if (!actionData) {
    return;
  }

  const button = document.createElement("button");

  button.textContent = actionData.text;
  button.classList.add("order-action-button");

  action.appendChild(button);
}

document.querySelectorAll(".order-actions").forEach((action) => {
  const order = action.closest(".orders-content");

  createOrderButton(action, order);

  action.addEventListener("click", async (event) => {
    if (!event.target.classList.contains("order-action-button")) {
      return;
    }

    const currentStatus = order.dataset.orderStatus;
    const nextStatus = actionMap[currentStatus]?.nextStatus;

    if (!nextStatus) {
      return;
    }

    const orderId = order.dataset.orderId;

    try {
      const response = await fetch("/restaurant/orders/status", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: new URLSearchParams({
          order_id: orderId,
          status: nextStatus,
        }),
      });

      const data = await response.json();

      if (!data.success) {
        return;
      }

      // Refresh the whole dashboard
      window.location.reload();
    } catch (error) {
      console.error(error);
    }
  });
});