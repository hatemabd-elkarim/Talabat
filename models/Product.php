<?php

namespace Models;

use Core\App;
use Core\Database;

class Product
{

    public static function findById(int $id): ?array
    {
        $db = App::resolve(Database::class);

        return $db->query(
            "SELECT *
         FROM products
         WHERE id = :id",
            [
                'id' => $id
            ]
        )->find();
    }

    public static function getRestaurantProducts(int $restaurantId): array
    {
        $db = App::resolve(Database::class);

        return $db->query(
            "SELECT
            id,
            name,
            category,
            price,
            is_available,
            description,
            image
        FROM products
        WHERE restaurant_id = :restaurant_id
        ORDER BY category, id DESC",
            [
                'restaurant_id' => $restaurantId
            ]
        )->get();
    }

    public static function createProduct(array $attributes): array
    {
        $db = App::resolve(Database::class);

        $db->query(
            "INSERT INTO products (
                name,
                description,
                price,
                image,
                is_available,
                restaurant_id,
                category
            ) VALUES (
                :name,
                :description,
                :price,
                :image,
                :is_available,
                :restaurant_id,
                :category
            )",
            [
                'name' => $attributes['name'],
                'description' => $attributes['description'],
                'price' => $attributes['price'],
                'image' => $attributes['image'],
                'is_available' => $attributes['is_available'],
                'restaurant_id' => $attributes['restaurant_id'],
                'category' => $attributes['category']
            ]
        );

        return $attributes;
    }

    public static function updateProduct(int $productId, int $restaurantId, array $attributes): bool
    {
        $db = App::resolve(Database::class);

        $db->query(
            "UPDATE products
         SET
            name = :name,
            description = :description,
            price = :price,
            category = :category,
            is_available = :is_available,
            image = :image
         WHERE id = :product_id
           AND restaurant_id = :restaurant_id",
            [
                'name' => $attributes['name'],
                'description' => $attributes['description'],
                'price' => $attributes['price'],
                'category' => $attributes['category'],
                'is_available' => $attributes['is_available'],
                'image' => $attributes['image'],
                'product_id' => $productId,
                'restaurant_id' => $restaurantId
            ]
        );

        return true;
    }

    public static function updateAvailability(
        int $productId,
        int $restaurantId,
        bool $isAvailable
    ): bool {
        $db = App::resolve(Database::class);

        $db->query(
            "UPDATE products
         SET is_available = :is_available
         WHERE id = :product_id
           AND restaurant_id = :restaurant_id",
            [
                'is_available' => $isAvailable ? 1 : 0,
                'product_id' => $productId,
                'restaurant_id' => $restaurantId
            ]
        );

        return true;
    }

    public static function deleteProduct(
        int $productId,
        int $restaurantId
    ): bool {
        $db = App::resolve(Database::class);

        $db->query(
            "DELETE FROM products
         WHERE id = :product_id
           AND restaurant_id = :restaurant_id",
            [
                'product_id' => $productId,
                'restaurant_id' => $restaurantId
            ]
        );

        return true;
    }
}
