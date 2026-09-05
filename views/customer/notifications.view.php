<?php
include __DIR__ . '/../partials/header.view.php';
include __DIR__ . '/nav.view.php';

$unread_count = 2;

$notifications = [
    [
        "icon" => "fa-box",
        "icon_color" => "orange",
        "title" => "Order Delivered!",
        "text" => "Your BurgerCo order #ORD-2847 has been delivered. Enjoy your meal!",
        "date" => "Nov 20, 05:15 PM",
        "unread" => true,
        "group" => "NEW"
    ],
    [
        "icon" => "fa-box",
        "icon_color" => "orange",
        "title" => "Your order is on the way",
        "text" => "Your Sushi Palace order #ORD-2901 is out for delivery. ETA 10 minutes.",
        "date" => "Nov 21, 02:45 PM",
        "unread" => true,
        "group" => "NEW"
    ],
    [
        "icon" => "fa-tag",
        "icon_color" => "green",
        "title" => "Limited Time Offer 🎉",
        "text" => "Use code WELCOME20 for 20% off your next order. Valid until Dec 31!",
        "date" => "Nov 18, 11:00 AM",
        "unread" => false,
        "group" => "EARLIER"
    ],
    [
        "icon" => "fa-box",
        "icon_color" => "orange",
        "title" => "Order Accepted",
        "text" => "Pizza Express has accepted your order #ORD-2934 and started preparing it.",
        "date" => "Nov 21, 03:40 PM",
        "unread" => false,
        "group" => "EARLIER"
    ],
    [
        "icon" => "fa-tag",
        "icon_color" => "green",
        "title" => "Weekend Special",
        "text" => "Free delivery on all orders over AED 30 this weekend only!",
        "date" => "Nov 15, 10:00 AM",
        "unread" => false,
        "group" => "EARLIER"
    ],
    [
        "icon" => "fa-box",
        "icon_color" => "orange",
        "title" => "Order Cancelled",
        "text" => "Your Green Bowl order #ORD-2788 was cancelled. A full refund has been processed.",
        "date" => "Nov 19, 12:05 PM",
        "unread" => false,
        "group" => "EARLIER"
    ]
];
?>

<link rel="stylesheet" href="/Talabat/public/CSS/notifications.css">

<div class="notifications-page">
    <div class="notifications-container">

        <div class="notifications-header">
            <div>
                <h1>Notifications</h1>
                <p class="unread-count"><?php echo $unread_count; ?> unread notifications</p>
            </div>
            <a href="#" class="mark-all-read">Mark all read</a>
        </div>

        <?php
        $current_group = "";
        foreach ($notifications as $item) {
            if ($item["group"] != $current_group) {
                $current_group = $item["group"];
                echo "<p class='section-title'>" . $current_group . "</p>";
            }
        ?>

        <div class="notification-item <?php echo $item["unread"] ? "unread" : ""; ?>">
            <div class="notification-icon <?php echo $item["icon_color"]; ?>">
                <i class="fa-solid <?php echo $item["icon"]; ?>"></i>
            </div>
            <div class="notification-content">
                <p class="notification-title"><?php echo $item["title"]; ?></p>
                <p class="notification-text"><?php echo $item["text"]; ?></p>
                <p class="notification-date"><?php echo $item["date"]; ?></p>
            </div>
            <?php if ($item["unread"]) { ?>
                <span class="unread-dot"></span>
            <?php } ?>
        </div>

        <?php } ?>

    </div>
</div>

<?php
include __DIR__ . '/../partials/footer.view.php';