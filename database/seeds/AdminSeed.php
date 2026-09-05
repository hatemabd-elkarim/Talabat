<?php

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../bootstrap.php';

use Core\App;
use Core\Database;

$hashedpassword = password_hash('admin123', PASSWORD_BCRYPT);

$db = App::resolve(Database::class);

$db->query("
    INSERT INTO users (name, email, password, role)
    VALUES (:name, :email, :password, :role);
", [
    'name' => 'Talabat',
    'email' => 'admin@talabat.com',
    'password' => $hashedpassword,
    'role' => 'admin'
]);
