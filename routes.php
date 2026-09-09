<?php

use Http\Controllers\IndexController;
use Http\Controllers\AuthController;
use Http\Controllers\DashboardController;
use Http\Controllers\ProfileController;
use Http\Controllers\NotificationController;
use Http\Controllers\OrderController;
use Http\Controllers\RestaurantController;
use Http\Controllers\CouponController;
use Http\Controllers\ProductController;

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
$router->post('/customer/location', [ProfileController::class, 'updateLocation']);
$router->post('/customer/restaurant-details/review', [RestaurantController::class, 'storeReview']);
$router->post('/customer/coupon/apply', [CouponController::class, 'apply']);
$router->get('/customer/notifications', [NotificationController::class, 'showCustomerNotifications']);
$router->post('/customer/notifications/read', [NotificationController::class, 'markNotificationRead']);
$router->post('/customer/notifications/read-all', [NotificationController::class, 'markAllNotificationsRead']);
$router->post('/customer/profile/update', [ProfileController::class, 'update']);
$router->get('/customer/checkout', [OrderController::class, 'showCheckout']);
$router->post('/customer/checkout', [OrderController::class, 'placeOrder']);

// Restaurant routes
$router->get('/restaurant/dashboard', [RestaurantController::class, 'dashboard']);
$router->get('/restaurant/products', [RestaurantController::class, 'products']);
$router->get('/restaurant/orders', [RestaurantController::class, 'orders']);
$router->get('/restaurant/profile', [RestaurantController::class, 'profile']);
$router->post('/restaurant/profile/update', [RestaurantController::class, 'updateProfile']);
$router->post('/restaurant/profile/status', [RestaurantController::class, 'updateStatus']);
$router->post('/restaurant/orders/status', [OrderController::class, 'updateOrderStatus']);
$router->post('/restaurant/products', [ProductController::class, 'addProduct']);
$router->post('/restaurant/products/update', [ProductController::class, 'updateProduct']);
$router->post('/restaurant/products/availability', [ProductController::class, 'updateProductAvailability']);
$router->post('/restaurant/products/delete', [ProductController::class, 'deleteProduct']);

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
