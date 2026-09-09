<?php

namespace Core\Middleware;

class CustomerAuth
{
    public static function handle()
    {
        if (($_SESSION['user']['role'] ?? null) !== 'customer') {
            abort(403);
        }
    }
}
