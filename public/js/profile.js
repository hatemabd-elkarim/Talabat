document.addEventListener("DOMContentLoaded", function () {
  const editButton = document.getElementById("editButton");

  const inputs = [
    document.getElementById("nameValue"),
    document.getElementById("emailValue"),
    document.getElementById("phoneValue"),
    document.getElementById("addressValue"),
  ];

  let editMode = false;

  const locationAddress = document.getElementById("locationAddress");
  const emailError = document.getElementById("emailError");
  const phoneError = document.getElementById("phoneError");

  editButton.addEventListener("click", function () {
    // =========================
    // Enter edit mode
    // =========================

    if (!editMode) {
      inputs.forEach(function (input) {
        input.removeAttribute("readonly");
      });

      editButton.innerHTML = `
                <i class="fa-solid fa-check"></i> Save changes
            `;

      editButton.classList.add("saving");

      editMode = true;

      return;
    }

    // =========================
    // Save changes
    // =========================

    const data = {
      name: document.getElementById("nameValue").value,
      email: document.getElementById("emailValue").value,
      phone: document.getElementById("phoneValue").value,
      address: document.getElementById("addressValue").value,
    };

    emailError.textContent = "";
    phoneError.textContent = "";

    fetch("/customer/profile/update", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
    })
      .then(function (response) {
        return response.json();
      })
      .then(function (data) {
        if (!data.success) {
          if (data.field === "email") {
            emailError.textContent = data.message;
          }

          if (data.field === "phone") {
            phoneError.textContent = data.message;
          }

          return;
        }

        // Make inputs read-only again
        inputs.forEach(function (input) {
          input.setAttribute("readonly", true);
        });

        if (locationAddress) {
          locationAddress.textContent = data.address;
        }

        // Change button back to Edit
        editButton.innerHTML = `
                    <i class="fa-solid fa-pen"></i> Edit
                `;

        editButton.classList.remove("saving");

        editMode = false;
      })
      .catch(function (error) {
        console.error("Failed to update profile:", error);
      });
  });
});
