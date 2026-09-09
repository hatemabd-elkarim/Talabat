<?php

namespace Core\Middleware;

class Guest
{
    public static function handle()
    {
        if (!isset($_SESSION['user'])) {
            return;
        }

        $role = $_SESSION['user']['role'];

        switch ($role) {
            case 'customer':
                header('Location: /customer/home');
                exit();

            case 'restaurant':
                header('Location: /restaurant/dashboard');
                exit();

            case 'admin':
                header('Location: /admin/dashboard');
                exit();

            default:
                header('Location: /');
                exit();
        }
    }
}
