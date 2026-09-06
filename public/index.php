<?php

use Core\Session;
use Core\Router;
use Core\ValidationException;

// 1. Constants and Autoloading
const BASE_PATH = __DIR__ . '/../'; // Standardized naming convention
require BASE_PATH . 'vendor/autoload.php';

// 2. Start Session (Only once!)
session_start();

// 3. Load Helper Functions and Bootstrap
require BASE_PATH . 'core/functions.php';
require basePath('bootstrap.php');

// 4. Initialize the Router
$router = new Router();
require basePath('routes.php'); // This file should interact with the $router instance

// 5. Capture Request Details
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$basePath = '/Talabat';

if (str_starts_with($uri, $basePath)) {
    $uri = substr($uri, strlen($basePath));
}

$uri = $uri ?: '/';
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

// 6. Routing and Exception Handling
try {
    $router->route($uri, $method);
} catch (ValidationException $exception) {
    // Flash errors and old input to the session for the next request
    Session::flash('errors', $exception->errors);
    Session::flash('old', $exception->old);

    return redirect($router->previousUrl());
}

// 7. Cleanup
// Only clear flashed data AFTER the response is prepared
unset($_SESSION['_flash']);
