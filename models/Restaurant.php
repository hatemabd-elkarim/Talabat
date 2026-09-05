<?php

namespace Models;

use Core\App;
use Core\Database;

class Restaurant
{
    public static function getTopRestaurants(): array
    {
        $db = App::resolve(Database::class);

        return $db->query(
            "SELECT
                restaurants.id,
                restaurants.name,
                restaurants.cuisine,
                restaurants.image,
                restaurants.is_open,
                restaurants.is_enabled,

                COUNT(orders.id) AS orderCount,

                COALESCE(SUM(orders.total_price), 0) AS revenue,

                COALESCE(AVG(ratings.rating), 0) AS rating

            FROM restaurants

            LEFT JOIN orders
                ON orders.restaurant_id = restaurants.id
                AND orders.status != 'cancelled'

            LEFT JOIN ratings
                ON ratings.restaurant_id = restaurants.id

            GROUP BY restaurants.id

            ORDER BY revenue DESC

            LIMIT 6"
        )->get();
    }
}
