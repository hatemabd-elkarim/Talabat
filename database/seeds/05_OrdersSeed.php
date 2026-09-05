<?php

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../bootstrap.php';

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$orders = [
    [
        'customer_id' => 4,
        'restaurant_id' => 1,
        'coupon_id' => 1,
        'total_price' => 150,
        'status' => 'delivered',
        'payment_method' => 'COD',
    ],
    [
        'customer_id' => 5,
        'restaurant_id' => 2,
        'coupon_id' => null,
        'total_price' => 160,
        'status' => 'preparing',
        'payment_method' => 'Online',
    ],
];

foreach ($orders as $order) {
    $db->query(
        "INSERT INTO orders (
            customer_id,
            restaurant_id,
            coupon_id,
            total_price,
            status,
            payment_method
        ) VALUES (
            :customer_id,
            :restaurant_id,
            :coupon_id,
            :total_price,
            :status,
            :payment_method
        )",
        $order
    );
}
