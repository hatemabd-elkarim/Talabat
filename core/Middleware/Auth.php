<?php

namespace Core\Middleware;

class Auth {
    public static function handle() {
        if (! ($_SESSION['user'] ?? false)) {
            header('location: /login'); // maybe updated then
            exit();
        }
    }
}