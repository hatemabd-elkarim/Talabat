document.addEventListener("DOMContentLoaded", function () {
  const notifications = document.querySelectorAll(
    ".notification-item[data-notification-id]",
  );
  const markAllReadButton = document.getElementById("markAllRead");
  const unreadCount = document.querySelector(".unread-count");
  const notificationBadge = document.getElementById("notificationBadge");

  // Mark one notification as read
  notifications.forEach(function (notification) {
    notification.addEventListener("click", function () {
      if (notification.dataset.isRead === "1") {
        return;
      }

      const notificationId = notification.dataset.notificationId;

      fetch("/customer/notifications/read", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          notification_id: notificationId,
        }),
      })
        .then(function (response) {
          return response.json();
        })
        .then(function (data) {
          if (!data.success) {
            return;
          }

          notification.classList.remove("unread");

          notification.dataset.isRead = "1";

          if (notificationBadge) {
            let count = parseInt(notificationBadge.textContent, 10);

            count = Math.max(0, count - 1);

            notificationBadge.textContent = count;
          }

          const dot = notification.querySelector(".unread-dot");

          if (dot) {
            dot.remove();
          }

          updateUnreadCount(-1);
        })
        .catch(function (error) {
          console.error("Failed to mark notification as read:", error);
        });
    });
  });

  // Mark all notifications as read
  if (markAllReadButton) {
    markAllReadButton.addEventListener("click", function (event) {
      event.preventDefault();

      fetch("/customer/notifications/read-all", {
        method: "POST",
      })
        .then(function (response) {
          return response.json();
        })
        .then(function (data) {
          if (!data.success) {
            return;
          }

          notifications.forEach(function (notification) {
            notification.classList.remove("unread");

            notification.dataset.isRead = "1";

            const dot = notification.querySelector(".unread-dot");

            if (dot) {
              dot.remove();
            }
          });
          if (notificationBadge) {
            notificationBadge.textContent = "0";
          }

          updateUnreadCountToZero();
        })
        .catch(function (error) {
          console.error("Failed to mark all notifications as read:", error);
        });
    });
  }

  function updateUnreadCount(change) {
    if (!unreadCount) {
      return;
    }

    const currentText = unreadCount.textContent;

    const match = currentText.match(/\d+/);

    if (!match) {
      return;
    }

    let count = parseInt(match[0], 10);

    count += change;

    if (count < 0) {
      count = 0;
    }

    unreadCount.textContent = count + " unread notifications";
  }

  function updateUnreadCountToZero() {
    if (!unreadCount) {
      return;
    }

    unreadCount.textContent = "0 unread notifications";
  }
});
