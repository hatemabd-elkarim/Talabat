<?php

namespace Models;

use Core\App;
use Core\Database;

class Restaurant
{
    public static function getNearRestaurants(
        float $latitude,
        float $longitude
    ): array {
        $db = App::resolve(Database::class);

        return $db->query(
            "SELECT
            r.id,
            r.name,
            r.logo AS image,
            r.cuisine,
            r.delivery_time,
            r.delivery_fee,
            r.is_open,

            ROUND(COALESCE(AVG(rt.rating), 0), 1) AS rating,
            COUNT(rt.id) AS reviews,

            ROUND(
                ST_Distance_Sphere(
                    POINT(:longitude, :latitude),
                    POINT(r.longitude, r.latitude)
                ) / 1000,
                1
            ) AS distance

        FROM restaurants r

        LEFT JOIN ratings rt
            ON rt.restaurant_id = r.id

        WHERE r.is_enabled = TRUE
          AND r.latitude IS NOT NULL
          AND r.longitude IS NOT NULL

        GROUP BY r.id

        HAVING distance <= 10

        ORDER BY distance ASC",
            [
                'latitude' => $latitude,
                'longitude' => $longitude
            ]
        )->get();
    }

    public static function getRandomProductFromRestaurants(
        array $restaurantIds
    ): ?array {
        if (empty($restaurantIds)) {
            return null;
        }

        $db = App::resolve(Database::class);

        $placeholders = [];

        foreach ($restaurantIds as $index => $id) {
            $placeholders[] = ":restaurant{$index}";
        }

        $sql = "
        SELECT
            p.id,
            p.name,
            p.description,
            p.price,
            p.image,
            p.category,
            r.name AS restaurant

        FROM products p

        INNER JOIN restaurants r
            ON r.id = p.restaurant_id

        WHERE p.restaurant_id IN (" . implode(',', $placeholders) . ")
          AND p.is_available = TRUE
          AND r.is_enabled = TRUE

        ORDER BY RAND()

        LIMIT 1
    ";

        $params = [];

        foreach ($restaurantIds as $index => $id) {
            $params["restaurant{$index}"] = $id;
        }

        $product = $db->query($sql, $params)->find();

        return $product ?: null;
    }


    public static function getTopRestaurants(): array
    {
        $db = App::resolve(Database::class);

        return $db->query(
            "SELECT
                restaurants.id,
                restaurants.name,
                restaurants.cuisine,
                restaurants.logo,
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

    public static function getRestaurants(): array
    {
        $db = App::resolve(Database::class);

        return $db->query(
            "SELECT
            restaurants.id,
            restaurants.name,
            restaurants.cuisine,
            restaurants.logo,
            restaurants.banner,

            restaurants.address_text AS address,

            restaurants.latitude,
            restaurants.longitude,

            restaurants.is_open,
            restaurants.is_enabled,

            users.phone,
            users.email,

            COALESCE(AVG(ratings.rating), 0) AS rating,
            COUNT(DISTINCT ratings.id) AS review_count

        FROM restaurants

        INNER JOIN users
            ON users.id = restaurants.owner_id

        LEFT JOIN ratings
            ON ratings.restaurant_id = restaurants.id

        GROUP BY
            restaurants.id,
            restaurants.name,
            restaurants.cuisine,
            restaurants.logo,
            restaurants.address_text,
            restaurants.latitude,
            restaurants.longitude,
            restaurants.is_open,
            restaurants.is_enabled,
            users.phone,
            users.email

        ORDER BY restaurants.id DESC"
        )->get();
    }

    public static function createRestaurant(array $attributes): array
    {
        $db = App::resolve(Database::class);

        $db->connection->beginTransaction();

        try {
            // 1. Create restaurant owner
            $password = password_hash('restaurant123', PASSWORD_DEFAULT);

            $db->query(
                "INSERT INTO users
            (name, email, password, phone, role)
            VALUES
            (:name, :email, :password, :phone, 'restaurant')",
                [
                    'name' => $attributes['name'],
                    'email' => $attributes['email'],
                    'password' => $password,
                    'phone' => $attributes['phone'],
                ]
            );

            $ownerId = (int) $db->connection->lastInsertId();

            // 2. Create restaurant
            $db->query(
                "INSERT INTO restaurants
            (
                name,
                cuisine,
                address_text,
                latitude,
                longitude,
                is_enabled,
                logo,
                banner,
                owner_id
            )
            VALUES
            (
                :name,
                :cuisine,
                :address_text,
                :latitude,
                :longitude,
                :is_enabled,
                :logo,
                :banner,
                :owner_id
            )",
                [
                    'name' => $attributes['name'],
                    'cuisine' => $attributes['cuisine'],
                    'address_text' => $attributes['address'],
                    'latitude' => $attributes['latitude'],
                    'longitude' => $attributes['longitude'],
                    'is_enabled' => $attributes['is_enabled'],
                    'logo' => $attributes['logo'],
                    'banner' => $attributes['banner'],
                    'owner_id' => $ownerId,
                ]
            );

            $restaurantId = (int) $db->connection->lastInsertId();

            $db->connection->commit();

            return [
                'id' => $restaurantId,
                'owner_id' => $ownerId,
                'name' => $attributes['name'],
                'cuisine' => $attributes['cuisine'],
                'logo' => $attributes['logo'],
                'banner' => $attributes['banner'],
            ];
        } catch (\Throwable $e) {
            $db->connection->rollBack();

            throw $e;
        }
    }

    public static function updateRestaurantStatus(
        int $id,
        int $isEnabled
    ): void {
        $db = App::resolve(Database::class);

        $db->query(
            "UPDATE restaurants
         SET is_enabled = :is_enabled
         WHERE id = :id",
            [
                'is_enabled' => $isEnabled,
                'id' => $id
            ]
        );
    }
}
