<?php

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../bootstrap.php';

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$password = password_hash('password', PASSWORD_DEFAULT);

$db->query(
    "UPDATE users
     SET password = :password
     WHERE id BETWEEN 1001 AND 1020",
    [
        'password' => $password
    ]
);

echo "Passwords updated successfully.";