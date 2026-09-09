<?php

namespace Core\Middleware;

class RestaurantAuth
{
    public static function handle()
    {
        if (($_SESSION['user']['role'] ?? null) !== 'restaurant') {
            abort(403);
        }
    }
}
