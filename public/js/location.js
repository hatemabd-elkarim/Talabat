function updateCustomerLocation() {
  if (!navigator.geolocation) {
    console.error("Geolocation is not supported by this browser");
    return;
  }

  navigator.geolocation.getCurrentPosition(
    async function (position) {
      const latitude = position.coords.latitude;
      const longitude = position.coords.longitude;

      try {
        const response = await fetch("/customer/location", {
          method: "POST",

          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },

          body: `latitude=${latitude}&longitude=${longitude}`,
        });

        const data = await response.json();

        if (data.success) {
          console.log("Location updated successfully");
        }
      } catch (error) {
        console.error("Failed to update location:", error);
      }
    },

    function (error) {
      console.error("Location error:", error.message);
    },

    {
      enableHighAccuracy: true,
      timeout: 10000,
      maximumAge: 300000,
    },
  );
}

updateCustomerLocation();
