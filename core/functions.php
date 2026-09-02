<?php

use core\Session;

function abort($code = 404) {
    http_response_code($code);
    require basePath("views/{$code}.view.php");
    exit();
}

function basePath($path)
{
    return BASE_PATH . $path;
}

function view($path, $attributes = [])
{
    extract($attributes);

    require basePath('views/' . $path);
}

function redirect($path)
{
    header("location: {$path}");
    exit();
}

function old($key, $default = '')
{
    return Session::get('old')[$key] ?? $default;
}