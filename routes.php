<?php

use Http\Controllers\IndexController;
use Http\Controllers\AuthController;
use Http\Controllers\DashboardController;
use Http\Controllers\ProfileController;
use Http\Controllers\NotificationController;
use Http\Controllers\OrderController;

// testing route
$router->get('/', [IndexController::class, 'index']);

// Auth routes
$router->get('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'register']);

// Customer routes
$router->get('/customer/home', [DashboardController::class, 'customerDashboard']);
$router->get('/customer/profile', [ProfileController::class, 'showCustomerProfile']);
$router->get('/customer/notifications', [NotificationController::class, 'showCustomerNotifications']);
$router->get('/customer/orders', [OrderController::class, 'showCustomerOrders']);
$router->get('/customer/cart', [OrderController::class, 'cart']);
