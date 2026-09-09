<?php

namespace Core\Middleware;

class Middleware
{
    const MAP = [
        'guest' => Guest::class,
        'auth' => Auth::class,
        'admin' => AdminAuth::class,
        'restaurant' => RestaurantAuth::class,
        'customer' => CustomerAuth::class,
    ];

    public static function resolve($key)
    {
        if (! $key) {
            return;
        }

        $middleware = static::MAP[$key] ?? false;

        if (! $middleware) {
            throw new \Exception("Middleware is not found for this key: {$key}");
        }

        (new $middleware)->handle();
    }
}
