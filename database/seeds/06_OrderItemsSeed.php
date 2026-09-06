<?php

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../bootstrap.php';

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$orderItems = [
    [
        'order_id' => 1,
        'product_id' => 1,
        'quantity' => 1,
        'price' => 150,
    ],
    [
        'order_id' => 2,
        'product_id' => 3,
        'quantity' => 1,
        'price' => 160,
    ],
];

foreach ($orderItems as $item) {
    $db->query(
        "INSERT INTO order_items (
            order_id,
            product_id,
            quantity,
            price
        ) VALUES (
            :order_id,
            :product_id,
            :quantity,
            :price
        )",
        $item
    );
}
