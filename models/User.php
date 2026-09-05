<?php

namespace Models;

use Core\App;
use Core\Database;

class User
{
    public static function findByEmail(string $email): ?array
    {
        $db = App::resolve(Database::class);

        $result = $db->query(
            'select * from users where email = :email',
            [
                'email' => $email
            ]
        )->find();

        return $result ?: null;
    }

    public static function findByPhone(string $phone): ?array
    {
        $db = App::resolve(Database::class);

        $result = $db->query(
            'SELECT * FROM users WHERE phone = :phone',
            [
                'phone' => $phone
            ]
        )->find();

        return $result ?: null;
    }

    public static function create($attributes)
    {
        $db = App::resolve(Database::class);

        $name = $attributes['name'] ?? '';
        $email = $attributes['email'] ?? '';
        $password = $attributes['password'] ?? '';
        $confirmPassword = $attributes['confirm-password'] ?? '';
        $phone = $attributes['phone'] ?? '';
        $address_text = $attributes['address'] ?? '';

        $hashedpassword = password_hash($password, PASSWORD_BCRYPT);

        $db->query(
            "INSERT INTO users (name, email, password, phone, address_text) 
                VALUES (:name, :email, :password, :phone, :address_text)",
            [
                'name' => $name,
                'email' => $email,
                'password' => $hashedpassword,
                'phone' => $phone,
                'address_text' => $address_text,
            ]
        );

        $lastId = $db->connection->lastInsertId();

        return [
            'id' => (int) $lastId,
            'name' => $name,
            'email' => $email,
            'role' => 'customer',
        ];
    }

    public static function login(array $user): void
    {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email'],
            'name' => $user['name'],
            'role' => $user['role'],
        ];

        session_regenerate_id(true);
    }

    public static function logout(): void
    {
        session_unset();
        session_destroy();

        // to delete the session cookie
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
}
