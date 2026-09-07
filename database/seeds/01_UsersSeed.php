<?php

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../bootstrap.php';

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$users = [
    [
        'name' => 'Pizza Hut Owner',
        'email' => 'pizzahut@talabat.com',
        'password' => 'restaurant123',
        'phone' => '01000000002',
        'role' => 'restaurant',
        'address' => 'Nasr City, Cairo',
    ],
    [
        'name' => 'Burger King Owner',
        'email' => 'burgerking@talabat.com',
        'password' => 'restaurant123',
        'phone' => '01000000003',
        'role' => 'restaurant',
        'address' => 'Maadi, Cairo',
    ],
    [
        'name' => 'Hatem Ayman',
        'email' => 'hatem@example.com',
        'password' => 'customer123',
        'phone' => '01000000004',
        'role' => 'customer',
        'address' => 'Zagazig, Sharqia',
    ],
    [
        'name' => 'Ahmed Mohamed',
        'email' => 'ahmed@example.com',
        'password' => 'customer123',
        'phone' => '01000000005',
        'role' => 'customer',
        'address' => 'Cairo, Egypt',
    ],
];

foreach ($users as $user) {
    $db->query(
        "INSERT INTO users
        (name, email, password, phone, role, address_text)
        VALUES
        (:name, :email, :password, :phone, :role, :address_text)",
        [
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => password_hash($user['password'], PASSWORD_BCRYPT),
            'phone' => $user['phone'],
            'role' => $user['role'],
            'address_text' => $user['address'],
        ]
    );
}

echo "Users seeded successfully.";
