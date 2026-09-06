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
}
