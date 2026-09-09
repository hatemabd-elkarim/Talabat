<?php

namespace Models;

use Core\App;
use Core\Database;

class Order
{
    public static function getRestuarantOrders(int $restaurantId): array
    {
        $db = App::resolve(Database::class);

        return $db->query(
            "SELECT
            o.id,
            u.name AS customer_name,
            u.phone AS customer_phone,
            u.address_text AS customer_address,
            o.total_price,
            o.status,
            o.payment_method,
            o.created_at,

            GROUP_CONCAT(
                CONCAT(p.name, ' x', oi.quantity)
                ORDER BY p.name
                SEPARATOR ', '
            ) AS items

        FROM orders o

        INNER JOIN users u
            ON u.id = o.customer_id

        LEFT JOIN order_items oi
            ON oi.order_id = o.id

        LEFT JOIN products p
            ON p.id = oi.product_id

        WHERE o.restaurant_id = :restaurant_id

        GROUP BY
            o.id,
            u.name,
            u.phone,
            u.address_text,
            o.total_price,
            o.status,
            o.payment_method,
            o.created_at

        ORDER BY o.created_at DESC",
            [
                'restaurant_id' => $restaurantId
            ]
        )->get();
    }

    public static function updateOrderStatus(
        int $orderId,
        int $restaurantId,
        string $status
    ): bool {
        $db = App::resolve(Database::class);

        $allowedStatuses = [
            'pending',
            'accepted',
            'preparing',
            'out for delivery',
            'delivered',
            'cancelled'
        ];

        if (!in_array($status, $allowedStatuses, true)) {
            return false;
        }

        $db->query(
            "UPDATE orders
         SET status = :status
         WHERE id = :order_id
           AND restaurant_id = :restaurant_id",
            [
                'status' => $status,
                'order_id' => $orderId,
                'restaurant_id' => $restaurantId
            ]
        );

        return true;
    }
}
