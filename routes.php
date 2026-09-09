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
$router->get('/', [IndexController::class, 'index'])->only('auth');

// Auth routes
$router->get('/login', [AuthController::class, 'login'])->only('guest');
$router->post('/login', [AuthController::class, 'storeSession'])->only('guest');
$router->post('/logout', [AuthController::class, 'destroySession'])->only('auth');
$router->get('/register', [AuthController::class, 'register'])->only('guest');
$router->post('/register', [AuthController::class, 'storeCustomer'])->only('guest');

// Customer routes
$router->get('/customer/home', [DashboardController::class, 'customerDashboard'])->only('customer');
$router->get('/customer/profile', [ProfileController::class, 'showCustomerProfile'])->only('customer');
$router->get('/customer/notifications', [NotificationController::class, 'showCustomerNotifications'])->only('customer');
$router->get('/customer/orders', [OrderController::class, 'showCustomerOrders'])->only('customer');
$router->get('/customer/cart', [OrderController::class, 'cart'])->only('customer');
$router->get('/customer/restaurant-details', [RestaurantController::class, 'showRestaurantDetails'])->only('customer');
$router->post('/customer/location', [ProfileController::class, 'updateLocation'])->only('customer');
$router->post('/customer/restaurant-details/review', [RestaurantController::class, 'storeReview'])->only('customer');
$router->post('/customer/coupon/apply', [CouponController::class, 'apply'])->only('customer');
$router->get('/customer/notifications', [NotificationController::class, 'showCustomerNotifications'])->only('customer');
$router->post('/customer/notifications/read', [NotificationController::class, 'markNotificationRead'])->only('customer');
$router->post('/customer/notifications/read-all', [NotificationController::class, 'markAllNotificationsRead'])->only('customer');
$router->post('/customer/profile/update', [ProfileController::class, 'update'])->only('customer');
$router->get('/customer/checkout', [OrderController::class, 'showCheckout'])->only('customer');
$router->post('/customer/checkout', [OrderController::class, 'placeOrder'])->only('customer');

// Restaurant routes
$router->get('/restaurant/dashboard', [RestaurantController::class, 'dashboard'])->only('restaurant');
$router->get('/restaurant/products', [RestaurantController::class, 'products'])->only('restaurant');
$router->get('/restaurant/orders', [RestaurantController::class, 'orders'])->only('restaurant');
$router->get('/restaurant/profile', [RestaurantController::class, 'profile'])->only('restaurant');
$router->post('/restaurant/profile/update', [RestaurantController::class, 'updateProfile'])->only('restaurant');
$router->post('/restaurant/profile/status', [RestaurantController::class, 'updateStatus'])->only('restaurant');
$router->post('/restaurant/orders/status', [OrderController::class, 'updateOrderStatus'])->only('restaurant');
$router->post('/restaurant/products', [ProductController::class, 'addProduct'])->only('restaurant');
$router->post('/restaurant/products/update', [ProductController::class, 'updateProduct'])->only('restaurant');
$router->post('/restaurant/products/availability', [ProductController::class, 'updateProductAvailability'])->only('restaurant');
$router->post('/restaurant/products/delete', [ProductController::class, 'deleteProduct'])->only('restaurant');

// admin routes
$router->get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->only('admin');
$router->get('/admin/restaurants', [RestaurantController::class, 'adminRestaurants'])->only('admin');
$router->post('/admin/restaurants/store', [RestaurantController::class, 'storeRestaurant'])->only('admin');
$router->patch('/admin/restaurants/status', [RestaurantController::class, 'updateRestaurantStatus'])->only('admin');
$router->get('/admin/coupons', [CouponController::class, 'adminCoupons'])->only('admin');
$router->post('/admin/coupons/store', [CouponController::class, 'storeCoupon'])->only('admin');
$router->post('/admin/coupons/update', [CouponController::class, 'updateCoupon'])->only('admin');
$router->patch('/admin/coupons/status', [CouponController::class, 'updateCouponStatus'])->only('admin');
$router->post('/admin/coupons/delete', [CouponController::class, 'deleteCoupon'])->only('admin');
