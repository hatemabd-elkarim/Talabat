<?php

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../bootstrap.php';

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$coupons = [
    [
        'code' => 'WELCOME10',
        'discount_percent' => 10,
        'max_discount' => 50,
        'min_order' => 100,
        'usage_limit' => 100,
        'expires_at' => '2027-01-01 00:00:00',
    ],
    [
        'code' => 'SAVE20',
        'discount_percent' => 20,
        'max_discount' => 100,
        'min_order' => 200,
        'usage_limit' => 50,
        'expires_at' => '2027-01-01 00:00:00',
    ],
];

foreach ($coupons as $coupon) {
    $db->query(
        "INSERT INTO coupons (
            code,
            discount_percent,
            max_discount,
            min_order,
            usage_limit,
            expires_at
        ) VALUES (
            :code,
            :discount_percent,
            :max_discount,
            :min_order,
            :usage_limit,
            :expires_at
        )",
        $coupon
    );
}
