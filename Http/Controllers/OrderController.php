<?php

namespace Http\Controllers;

class OrderController
{
    public function showCustomerOrders()
    {
        $orders = [
            [
                "id" => 1024,
                "restaurant" => "Burger Factory",
                "restaurant_image" => "https://placehold.co/100x100",
                "date" => "Sep 2, 2026",
                "items" => ["Classic Beef Burger", "French Fries", "Coca-Cola"],
                "total" => 260,
                "payment_method" => "Cash on Delivery",
                "status" => "Preparing"
            ],
            [
                "id" => 1023,
                "restaurant" => "Pizza House",
                "restaurant_image" => "https://placehold.co/100x100",
                "date" => "Sep 1, 2026",
                "items" => ["Margherita Pizza", "Garlic Bread"],
                "total" => 310,
                "payment_method" => "Online Payment",
                "status" => "Delivered"
            ],
            [
                "id" => 1022,
                "restaurant" => "Chicken Republic",
                "restaurant_image" => "https://placehold.co/100x100",
                "date" => "Aug 30, 2026",
                "items" => ["Chicken Meal"],
                "total" => 200,
                "payment_method" => "Cash on Delivery",
                "status" => "Cancelled"
            ]
        ];
        view('customer/orders/index.view.php', ['orders' => $orders]);
    }

    public function cart()
    {
        view('customer/cart.view.php');
    }
}
