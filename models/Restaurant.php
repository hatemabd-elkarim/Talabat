<?php

namespace Models;

use Core\App;
use Core\Database;

class Restaurant
{
    public static function findByOwnerId(int $ownerId): ?array
    {
        $db = App::resolve(Database::class);

        $restaurant = $db->query(
            "SELECT
            r.id,
            r.name,
            r.logo,
            r.banner,
            r.cuisine,
            r.delivery_time,
            r.delivery_fee,
            r.min_order,
            r.is_open,
            r.description,
            r.address_text AS address,
            u.phone,

            ROUND(COALESCE(AVG(rt.rating), 0), 1) AS rating,
            COUNT(rt.id) AS review_count

        FROM restaurants r

        INNER JOIN users u
            ON u.id = r.owner_id

        LEFT JOIN ratings rt
            ON rt.restaurant_id = r.id

        WHERE r.owner_id = :owner_id
          AND r.is_enabled = TRUE

        GROUP BY r.id",
            [
                'owner_id' => $ownerId
            ]
        )->find();

        return $restaurant ?: null;
    }

    public static function findById(int $id): ?array
    {
        $db = App::resolve(Database::class);

        $restaurant = $db->query(
            "SELECT
            r.id,
            r.name,
            r.logo,
            r.banner,
            r.cuisine,
            r.delivery_time,
            r.delivery_fee,
            r.min_order,
            r.is_open,
            r.description,
            r.address_text AS address,
            u.phone,

            ROUND(COALESCE(AVG(rt.rating), 0), 1) AS rating,
            COUNT(rt.id) AS review_count,

            CASE
                WHEN cu.latitude IS NOT NULL
                 AND cu.longitude IS NOT NULL
                 AND r.latitude IS NOT NULL
                 AND r.longitude IS NOT NULL
                THEN ROUND(
                    ST_Distance_Sphere(
                        POINT(cu.longitude, cu.latitude),
                        POINT(r.longitude, r.latitude)
                    ) / 1000,
                    1
                )
                ELSE NULL
            END AS distance

        FROM restaurants r

        INNER JOIN users u
            ON u.id = r.owner_id

        LEFT JOIN ratings rt
            ON rt.restaurant_id = r.id

        LEFT JOIN users cu
            ON cu.id = :customer_id

        WHERE r.id = :restaurant_id
          AND r.is_enabled = TRUE

        GROUP BY r.id",
            [
                'customer_id' => $_SESSION['user']['id'],
                'restaurant_id' => $id
            ]
        )->find();

        return $restaurant ?: null;
    }

    public static function getProducts(int $restaurantId): array
    {
        $db = App::resolve(Database::class);

        return $db->query(
            "SELECT
            id,
            name,
            description,
            price,
            image,
            category,
            is_available

        FROM products

        WHERE restaurant_id = :restaurant_id

        ORDER BY category, id",
            [
                'restaurant_id' => $restaurantId
            ]
        )->get();
    }

    public static function getReviews(int $restaurantId): array
    {
        $db = App::resolve(Database::class);

        return $db->query(
            "SELECT
            rt.id,
            u.name AS customer_name,
            rt.rating,
            rt.comment,
            rt.created_at

        FROM ratings rt

        INNER JOIN users u
            ON u.id = rt.customer_id

        WHERE rt.restaurant_id = :restaurant_id

        ORDER BY rt.created_at DESC",
            [
                'restaurant_id' => $restaurantId
            ]
        )->get();
    }

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
            r.name AS restaurant,
            r.id AS restaurant_id,
            r.delivery_fee,
            r.delivery_time

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

    public static function createReview(
        int $customerId,
        int $restaurantId,
        int $rating,
        string $comment
    ): array {
        $db = App::resolve(Database::class);

        $existingReview = $db->query(
            "SELECT id
         FROM ratings
         WHERE customer_id = :customer_id
           AND restaurant_id = :restaurant_id",
            [
                'customer_id' => $customerId,
                'restaurant_id' => $restaurantId
            ]
        )->find();

        if ($existingReview) {

            // User already reviewed → update old review
            $db->query(
                "UPDATE ratings
             SET rating = :rating,
                 comment = :comment,
                 created_at = CURRENT_TIMESTAMP
             WHERE id = :id",
                [
                    'rating' => $rating,
                    'comment' => $comment,
                    'id' => $existingReview['id']
                ]
            );

            $reviewId = $existingReview['id'];
        } else {

            // First review → create new review
            $db->query(
                "INSERT INTO ratings (
                customer_id,
                restaurant_id,
                rating,
                comment
            ) VALUES (
                :customer_id,
                :restaurant_id,
                :rating,
                :comment
            )",
                [
                    'customer_id' => $customerId,
                    'restaurant_id' => $restaurantId,
                    'rating' => $rating,
                    'comment' => $comment
                ]
            );

            $reviewId = $db->query(
                "SELECT LAST_INSERT_ID() AS id"
            )->find()['id'];
        }

        // Get the review after INSERT/UPDATE
        $review = $db->query(
            "SELECT
            rt.id,
            u.name AS customer_name,
            rt.rating,
            rt.comment,
            rt.created_at
         FROM ratings rt
         INNER JOIN users u
             ON u.id = rt.customer_id
         WHERE rt.id = :id",
            [
                'id' => $reviewId
            ]
        )->find();

        // Get updated restaurant statistics
        $stats = $db->query(
            "SELECT
            ROUND(AVG(rating), 1) AS rating,
            COUNT(*) AS review_count
         FROM ratings
         WHERE restaurant_id = :restaurant_id",
            [
                'restaurant_id' => $restaurantId
            ]
        )->find();

        return [
            'review' => $review,
            'rating' => $stats['rating'],
            'review_count' => $stats['review_count']
        ];
    }

    public static function getDashboardStats(int $restaurantId): array
    {
        $db = App::resolve(Database::class);

        $stats = $db->query(
            "SELECT
            COALESCE(SUM(
                CASE
                    WHEN DATE(created_at) = CURDATE()
                    AND status != 'cancelled'
                    THEN total_price
                    ELSE 0
                END
            ), 0) AS today_sales,

            COUNT(
                CASE
                    WHEN DATE(created_at) = CURDATE()
                    THEN 1
                END
            ) AS today_orders,

            COUNT(
                CASE
                    WHEN status IN ('pending')
                    THEN 1
                END
            ) AS pending_orders

        FROM orders

        WHERE restaurant_id = :restaurant_id",
            [
                'restaurant_id' => $restaurantId
            ]
        )->find();

        $productStats = $db->query(
            "SELECT
            COUNT(*) AS total_products,
            COUNT(CASE WHEN is_available = TRUE THEN 1 END) AS available_products,
            COUNT(DISTINCT category) AS total_categories
         FROM products
         WHERE restaurant_id = :restaurant_id",
            [
                'restaurant_id' => $restaurantId
            ]
        )->find();

        $ratingStats = $db->query(
            "SELECT
            COALESCE(ROUND(AVG(rating), 1), 0) AS average_rating
         FROM ratings
         WHERE restaurant_id = :restaurant_id",
            [
                'restaurant_id' => $restaurantId
            ]
        )->find();

        return [
            'today_sales' => (float) $stats['today_sales'],
            'today_orders' => (int) $stats['today_orders'],
            'pending_orders' => (int) $stats['pending_orders'],

            'total_products' => (int) $productStats['total_products'],
            'total_categories' => (int) $productStats['total_categories'],
            'available_products' => (int) $productStats['available_products'],

            'average_rating' => (float) $ratingStats['average_rating'],
        ];
    }

    public static function updateProfile(int $id, array $data): bool
    {
        $db = App::resolve(Database::class);

        $db->query(
            "UPDATE restaurants
         SET
            name = :name,
            description = :description,
            address_text = :address_text,
            delivery_time = :delivery_time,
            delivery_fee = :delivery_fee,
            min_order = :min_order
         WHERE id = :id",
            [
                'id'            => $id,
                'name'          => $data['name'],
                'description'   => $data['description'],
                'address_text'  => $data['address_text'],
                'delivery_time' => $data['delivery_time'],
                'delivery_fee'  => $data['delivery_fee'],
                'min_order'     => $data['min_order'],
            ]
        );

        return true;
    }

    public static function updateStatus(int $id, int $isOpen): bool
    {
        $db = App::resolve(Database::class);

        $db->query(
            "UPDATE restaurants
         SET is_open = :is_open
         WHERE id = :id",
            [
                'id'      => $id,
                'is_open' => $isOpen,
            ]
        );

        return true;
    }
}
