document.body.style.overflow = "visible";
document.documentElement.style.overflow = "visible";
document.body.style.height = "auto";
document.documentElement.style.height = "auto";

document.addEventListener("DOMContentLoaded", function () {
  const editButton = document.getElementById("editButton");
  const message = document.getElementById("profileMessage");

  const inputs = [
    document.getElementById("nameValue"),
    document.getElementById("descriptionValue"),
    document.getElementById("phoneValue"),
    document.getElementById("addressValue"),
    document.getElementById("deliveryTimeValue"),
    document.getElementById("deliveryFeeValue"),
    document.getElementById("minOrderValue"),
  ];

  let editMode = false;

  function clearMessage() {
    message.textContent = "";
    message.className = "form-message";
  }

  editButton.addEventListener("click", function () {
    if (!editMode) {
      inputs.forEach((input) => input.removeAttribute("readonly"));
      editButton.textContent = "✓ Save changes";
      editMode = true;
      return;
    }

    const data = {
      name: document.getElementById("nameValue").value,
      description: document.getElementById("descriptionValue").value,
      phone: document.getElementById("phoneValue").value,
      address: document.getElementById("addressValue").value,
      delivery_time: document.getElementById("deliveryTimeValue").value,
      delivery_fee: document.getElementById("deliveryFeeValue").value,
      min_order: document.getElementById("minOrderValue").value,
    };

    clearMessage();

    fetch("/restaurant/profile/update", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data),
    })
      .then((response) => response.json())
      .then((result) => {
        if (!result.success) {
          message.textContent = result.message;
          message.className = "form-message error";
          return;
        }

        inputs.forEach((input) => input.setAttribute("readonly", true));
        editButton.textContent = "✎ Edit";
        editMode = false;

        message.textContent = result.message;
        message.className = "form-message success";
      })
      .catch((error) => {
        console.error(error);
        message.textContent = "Something went wrong. Please try again.";
        message.className = "form-message error";
      });
  });

  const statusToggle = document.getElementById("statusToggle");
  const statusText = document.getElementById("statusText");

  statusToggle.addEventListener("change", function () {
    const isOpen = this.checked;

    fetch("/restaurant/profile/status", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ is_open: isOpen ? 1 : 0 }),
    })
      .then((response) => response.json())
      .then((result) => {
        if (!result.success) {
          statusToggle.checked = !isOpen;
          console.error(result.message);
          return;
        }

        statusText.textContent = isOpen
          ? "Currently accepting orders"
          : "Currently closed";
      })
      .catch((error) => {
        statusToggle.checked = !isOpen;
        console.error(error);
      });
  });
});
