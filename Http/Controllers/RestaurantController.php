<?php

namespace Http\Controllers;

use Core\MockData\RestaurantMockData;

class RestaurantController
{
    public function dashboard()
    {
        view('restaurant/dashboard.view.php', [
            'restaurant' => RestaurantMockData::restaurant(),
            'stats' => RestaurantMockData::stats(),
            'recentOrders' => array_slice(RestaurantMockData::orders(), 0, 4),
        ]);
    }

    public function products()
    {
        view('restaurant/products.view.php', [
            'restaurant' => RestaurantMockData::restaurant(),
            'products' => RestaurantMockData::products(),
            'categories' => RestaurantMockData::categories(),
        ]);
    }

    public function categories()
    {
        view('restaurant/categories.view.php', [
            'restaurant' => RestaurantMockData::restaurant(),
            'categories' => RestaurantMockData::categories(),
        ]);
    }

    public function orders()
    {
        view('restaurant/orders.view.php', [
            'restaurant' => RestaurantMockData::restaurant(),
            'orders' => RestaurantMockData::orders(),
        ]);
    }

    public function showRestaurantDetails()
    {
        view('customer/restaurant-details.view.php', [
            'restaurant' => RestaurantMockData::restaurant(),
            'categories' => RestaurantMockData::categories(),
            'products' => RestaurantMockData::products(),
            'reviews' => RestaurantMockData::reviews(),
        ]);
    }
}
