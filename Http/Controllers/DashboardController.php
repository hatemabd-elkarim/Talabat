<?php

namespace Http\Controllers;

use Models\Admin;
use Models\Restaurant;
use Models\User;
use Core\Session;

class DashboardController
{
    public function customerDashboard()
    {
        $user = User::findById(Session::get('user')['id']);

        $nearRestaurants = [];

        if (
            $user &&
            $user['latitude'] !== null &&
            $user['longitude'] !== null
        ) {
            $nearRestaurants = Restaurant::getNearRestaurants(
                (float) $user['latitude'],
                (float) $user['longitude']
            );
        }

        // Take the nearest 10 restaurants
        $topRatedRestaurants = array_slice(
            $nearRestaurants,
            0,
            10
        );

        // Sort those nearby restaurants by rating
        usort(
            $topRatedRestaurants,
            fn($a, $b) => $b['rating'] <=> $a['rating']
        );

        // Keep the top 3
        $topRatedRestaurants = array_slice(
            $topRatedRestaurants,
            0,
            3
        );

        // Pick a random product from those 3 restaurants
        $topRestaurantIds = array_column(
            $topRatedRestaurants,
            'id'
        );

        $featuredProduct =
            Restaurant::getRandomProductFromRestaurants(
                $topRestaurantIds
            );

        $openRestaurantCount = count(
            array_filter(
                $nearRestaurants,
                fn($restaurant) => $restaurant['is_open']
            )
        );

        view('customer/home.view.php', [
            'nearRestaurants' => $nearRestaurants,
            'topRatedRestaurants' => $topRatedRestaurants,
            'featuredProduct' => $featuredProduct,
            'openRestaurantCount' => $openRestaurantCount
        ]);
    }

    public function adminDashboard()
    {
        $stats = Admin::getDashboardStats();

        $topRestaurants = Restaurant::getTopRestaurants();

        view('admin/dashboard.view.php', [
            'activePage' => 'a-dashboard',
            'stats' => $stats,
            'topRestaurants' => $topRestaurants,
        ]);
    }
}
