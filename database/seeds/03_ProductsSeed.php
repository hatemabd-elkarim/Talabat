<?php

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../bootstrap.php';

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$products = [
    [
        'name' => 'Margherita Pizza',
        'description' => 'Classic pizza with cheese and tomato sauce.',
        'price' => 150,
        'image' => 'margherita.jpg',
        'restaurant_id' => 1,
        'category' => 'Pizza',
    ],
    [
        'name' => 'Pepperoni Pizza',
        'description' => 'Pizza with pepperoni and mozzarella cheese.',
        'price' => 180,
        'image' => 'pepperoni.jpg',
        'restaurant_id' => 1,
        'category' => 'Pizza',
    ],
    [
        'name' => 'Whopper',
        'description' => 'Grilled beef burger with fresh vegetables.',
        'price' => 160,
        'image' => 'whopper.jpg',
        'restaurant_id' => 2,
        'category' => 'Burgers',
    ],
    [
        'name' => 'Chicken Burger',
        'description' => 'Crispy chicken burger.',
        'price' => 140,
        'image' => 'chicken-burger.jpg',
        'restaurant_id' => 2,
        'category' => 'Burgers',
    ],
];

foreach ($products as $product) {
    $db->query(
        "INSERT INTO products (
            name,
            description,
            price,
            image,
            restaurant_id,
            category
        ) VALUES (
            :name,
            :description,
            :price,
            :image,
            :restaurant_id,
            :category
        )",
        $product
    );
}

echo "Products seeded successfully.";
