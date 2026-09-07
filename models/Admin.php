<?php

namespace Models;

use Core\App;
use Core\Database;

class Admin
{
    public static function getDashboardStats(): array
    {
        $db = App::resolve(Database::class);

        $today = "DATE(created_at) = CURDATE()";

        $todayOrders = $db->query(
            "SELECT
                COUNT(*) AS total_orders,
                COALESCE(SUM(
                    CASE
                        WHEN status = 'delivered' THEN total_price
                        ELSE 0
                    END
                ), 0) AS total_revenue,

                SUM(status = 'cancelled') AS cancelled_orders,
                SUM(payment_method = 'Online') AS online_orders

            FROM orders
            WHERE $today"
        )->find();

        $newCustomers = $db->query(
            "SELECT COUNT(*) AS total
             FROM users
             WHERE role = 'customer'
             AND DATE(created_at) = CURDATE()"
        )->find()['total'];

        $restaurantStats = $db->query(
            "SELECT
                COUNT(*) AS total_restaurants,
                SUM(is_open = TRUE AND is_enabled = TRUE) AS active_restaurants
             FROM restaurants"
        )->find();

        $totalOrders = (int) $todayOrders['total_orders'];
        $totalRevenue = (float) $todayOrders['total_revenue'];
        $cancelledOrders = (int) ($todayOrders['cancelled_orders'] ?? 0);
        $onlineOrders = (int) ($todayOrders['online_orders'] ?? 0);

        return [
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,

            'activeRestaurants' => (int) ($restaurantStats['active_restaurants'] ?? 0),
            'totalRestaurants' => (int) $restaurantStats['total_restaurants'],

            'totalCustomers' => (int) $newCustomers,

            'avgOrderValue' => $totalOrders
                ? $totalRevenue / $totalOrders
                : 0,

            'cancellationRate' => $totalOrders
                ? ($cancelledOrders / $totalOrders) * 100
                : 0,

            'onlineShare' => $totalOrders
                ? ($onlineOrders / $totalOrders) * 100
                : 0,
        ];
    }
}
