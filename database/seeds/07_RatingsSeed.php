<?php

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../bootstrap.php';

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$ratings = [
    [
        'customer_id' => 4,
        'restaurant_id' => 1,
        'rating' => 5,
        'comment' => 'Excellent pizza and fast delivery.',
    ],
    [
        'customer_id' => 5,
        'restaurant_id' => 2,
        'rating' => 4,
        'comment' => 'Very good burger.',
    ],
];

foreach ($ratings as $rating) {
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
        $rating
    );
}
