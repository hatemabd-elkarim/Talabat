<?php

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../bootstrap.php';

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$restaurants = [
    [
        'name' => 'Pizza Hut',
        'description' => 'Delicious pizzas and Italian food.',
        'image' => 'pizza-hut.jpg',
        'cuisine' => 'Italian',
        'address_text' => 'Nasr City, Cairo',
        'latitude' => 30.06263000,
        'longitude' => 31.32606000,
        'delivery_time' => 30,
        'delivery_fee' => 20,
        'min_order' => 100,
        'owner_id' => 2,
    ],
    [
        'name' => 'Burger King',
        'description' => 'Delicious burgers and fast food.',
        'image' => 'burger-king.jpg',
        'cuisine' => 'Fast Food',
        'address_text' => 'Maadi, Cairo',
        'latitude' => 29.96024000,
        'longitude' => 31.25639000,
        'delivery_time' => 35,
        'delivery_fee' => 25,
        'min_order' => 120,
        'owner_id' => 3,
    ],
];

foreach ($restaurants as $restaurant) {
    $db->query(
        "INSERT INTO restaurants (
            name,
            description,
            image,
            cuisine,
            address_text,
            latitude,
            longitude,
            delivery_time,
            delivery_fee,
            min_order,
            owner_id
        ) VALUES (
            :name,
            :description,
            :image,
            :cuisine,
            :address_text,
            :latitude,
            :longitude,
            :delivery_time,
            :delivery_fee,
            :min_order,
            :owner_id
        )",
        $restaurant
    );
}

echo "Restaurants seeded successfully.";
