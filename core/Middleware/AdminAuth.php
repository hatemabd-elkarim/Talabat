<?php

namespace Core\Middleware;

class AdminAuth
{
    public static function handle()
    {
        if (($_SESSION['user']['role'] ?? null) !== 'admin') {
            abort(403);
        }
    }
}
