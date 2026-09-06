<?php

use Http\Controllers\IndexController;
use Http\Controllers\AuthController;
use Http\Controllers\DashboardController;
use Http\Controllers\ProfileController;
use Http\Controllers\NotificationController;
use Http\Controllers\OrderController;
use Http\Controllers\RestaurantController;
use Http\Controllers\CouponController;

// testing route
$router->get('/', [IndexController::class, 'index']);

// Auth routes
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'storeSession']);
$router->get('/register', [AuthController::class, 'register']);
$router->post('/register', [AuthController::class, 'storeCustomer']);

// Customer routes
$router->get('/customer/home', [DashboardController::class, 'customerDashboard']);
$router->get('/customer/profile', [ProfileController::class, 'showCustomerProfile']);
$router->get('/customer/notifications', [NotificationController::class, 'showCustomerNotifications']);
$router->get('/customer/orders', [OrderController::class, 'showCustomerOrders']);
$router->get('/customer/cart', [OrderController::class, 'cart']);
$router->get('/customer/restaurant-details', [RestaurantController::class, 'showRestaurantDetails']);

// admin routes
$router->get('/admin/dashboard', [DashboardController::class, 'adminDashboard']);
$router->get('/admin/restaurants', [RestaurantController::class, 'adminRestaurants']);
$router->post('/admin/restaurants/store', [RestaurantController::class, 'storeRestaurant']);
$router->patch('/admin/restaurants/status', [RestaurantController::class, 'updateRestaurantStatus']);
$router->get('/admin/coupons', [CouponController::class, 'adminCoupons']);
$router->post('/admin/coupons/store', [CouponController::class, 'storeCoupon']);
$router->post('/admin/coupons/update', [CouponController::class, 'updateCoupon']);
$router->patch('/admin/coupons/status', [CouponController::class, 'updateCouponStatus']);
$router->post('/admin/coupons/delete', [CouponController::class, 'deleteCoupon']);
