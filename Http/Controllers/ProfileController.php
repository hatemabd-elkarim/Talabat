<?php

namespace Http\Controllers;

class ProfileController
{
    public function showCustomerProfile()
    {
        $customer = [
            "id" => 1,
            "name" => "Hatem Ayman",
            "email" => "hatem@example.com",
            "phone" => "+20 10 1234 5678",
            "address" => "Cairo, Egypt",
            "image" => "https://placehold.co/200x200",
            "member_since" => "September 2026",
            "total_orders" => 12
        ];

        view('customer/profile.view.php', [
            'customer' => $customer
        ]);
    }
}
