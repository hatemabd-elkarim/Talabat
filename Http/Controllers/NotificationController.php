<?php

namespace Http\Controllers;

class NotificationController
{
    public function showCustomerNotifications()
    {
        $notifications = [
            [
                "id" => 1,
                "type" => "success",
                "title" => "Order Delivered",
                "message" => "Your order #1024 has been delivered successfully.",
                "time" => "10 minutes ago",
                "is_read" => false
            ],
            [
                "id" => 2,
                "type" => "delivery",
                "title" => "Out for Delivery",
                "message" => "Your order #1025 is on its way.",
                "time" => "1 hour ago",
                "is_read" => false
            ],
            [
                "id" => 3,
                "type" => "preparing",
                "title" => "Preparing Your Order",
                "message" => "Burger Factory is preparing your food.",
                "time" => "2 hours ago",
                "is_read" => true
            ],
            [
                "id" => 4,
                "type" => "promotion",
                "title" => "Special Offer",
                "message" => "Get 20% off your next order using QUICK20.",
                "time" => "Yesterday",
                "is_read" => true
            ]
        ];
        view('customer/notifications.view.php', [
            'notifications' => $notifications
        ]);
    }
}
