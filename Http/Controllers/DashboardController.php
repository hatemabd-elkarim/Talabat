<?php

namespace Http\Controllers;

class DashboardController
{
    public function customerDashboard()
    {
        // mock data for testing
        $nearRestaurants = [
            [
                "id" => 1,
                "name" => "Burger Factory",
                "image" => "https://placehold.co/600x400",
                "cuisine" => "Burgers",
                "rating" => 4.6,
                "reviews" => 120,
                "distance" => "1.2 km",
                "delivery_time" => "25-35 min",
                "delivery_fee" => 25,
                "is_open" => true
            ],
            [
                "id" => 2,
                "name" => "Pizza House",
                "image" => "https://placehold.co/600x400",
                "cuisine" => "Pizza",
                "rating" => 4.5,
                "reviews" => 95,
                "distance" => "2.1 km",
                "delivery_time" => "30-40 min",
                "delivery_fee" => 30,
                "is_open" => true
            ],
            [
                "id" => 3,
                "name" => "Koshary El Tahrir",
                "image" => "https://placehold.co/600x400",
                "cuisine" => "Egyptian Food",
                "rating" => 4.7,
                "reviews" => 230,
                "distance" => "2.8 km",
                "delivery_time" => "20-30 min",
                "delivery_fee" => 20,
                "is_open" => false
            ]
        ];


        $topRatedRestaurants = [
            [
                "id" => 4,
                "name" => "Chicken Republic",
                "image" => "https://placehold.co/600x400",
                "cuisine" => "Chicken",
                "rating" => 4.9,
                "reviews" => 340,
                "distance" => "3.5 km",
                "delivery_time" => "30-45 min",
                "delivery_fee" => 25,
                "is_open" => true
            ],
            [
                "id" => 5,
                "name" => "Sushi Tokyo",
                "image" => "https://placehold.co/600x400",
                "cuisine" => "Japanese",
                "rating" => 4.8,
                "reviews" => 180,
                "distance" => "4.2 km",
                "delivery_time" => "35-50 min",
                "delivery_fee" => 40,
                "is_open" => true
            ]
        ];

        $recommendedProducts = [
            [
                "id" => 1,
                "name" => "Classic Beef Burger",
                "restaurant" => "Burger Factory",
                "category" => "Burgers",
                "image" => "https://placehold.co/400x300",
                "price" => 180,
                "rating" => 4.7
            ],
            [
                "id" => 2,
                "name" => "Margherita Pizza",
                "restaurant" => "Pizza House",
                "category" => "Pizza",
                "image" => "https://placehold.co/400x300",
                "price" => 220,
                "rating" => 4.8
            ],
            [
                "id" => 3,
                "name" => "Chicken Meal",
                "restaurant" => "Chicken Republic",
                "category" => "Chicken",
                "image" => "https://placehold.co/400x300",
                "price" => 200,
                "rating" => 4.6
            ]
        ];

        $featuredProduct = !empty($recommendedProducts)
            ? $recommendedProducts[array_rand($recommendedProducts)]
            : null;

        $allRestaurants = array_merge($nearRestaurants, $topRatedRestaurants);

        $openRestaurantCount = count(array_filter(
            $allRestaurants,
            static fn(array $restaurant): bool => $restaurant['is_open']
        ));

        view('customer/home.view.php', [
            'nearRestaurants' => $nearRestaurants,
            'topRatedRestaurants' => $topRatedRestaurants,
            'recommendedProducts' => $recommendedProducts,
            'featuredProduct' => $featuredProduct,
            'openRestaurantCount' => $openRestaurantCount
        ]);
    }
}
