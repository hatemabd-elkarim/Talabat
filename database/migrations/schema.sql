-- ============================================
-- TALABAT DATABASE SCHEMA
-- ============================================

CREATE DATABASE IF NOT EXISTS talabat;

USE talabat;


-- ============================================
-- USERS
-- Admin, Customer, and Restaurant accounts
-- ============================================

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),

    role ENUM('admin', 'customer', 'restaurant')
        NOT NULL DEFAULT 'customer',

    address_text VARCHAR(255),
    latitude DECIMAL(10,8),
    longitude DECIMAL(11,8),

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- ============================================
-- RESTAURANTS
-- Each restaurant belongs to a Restaurant user
-- ============================================

CREATE TABLE restaurants (
    id INT PRIMARY KEY AUTO_INCREMENT,

    name VARCHAR(100) NOT NULL,
    description TEXT,
    image VARCHAR(255),

    cuisine VARCHAR(100) NOT NULL,

    is_open BOOLEAN DEFAULT TRUE,
    is_enabled BOOLEAN DEFAULT TRUE,

    address_text VARCHAR(255),
    latitude DECIMAL(10,8),
    longitude DECIMAL(11,8),

    delivery_time INT,
    delivery_fee DECIMAL(10,2) DEFAULT 0,
    min_order DECIMAL(10,2) DEFAULT 0,

    owner_id INT NOT NULL,

    CONSTRAINT fk_restaurant_owner
        FOREIGN KEY (owner_id)
        REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- ============================================
-- PRODUCTS
-- Restaurants add food/products
-- ============================================

CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,

    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,

    image VARCHAR(255),

    is_available BOOLEAN DEFAULT TRUE,

    restaurant_id INT NOT NULL,
    category VARCHAR(100) NOT NULL,

    CONSTRAINT fk_product_restaurant
        FOREIGN KEY (restaurant_id)
        REFERENCES restaurants(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);


-- ============================================
-- COUPONS
-- Managed by Admin
-- ============================================

CREATE TABLE coupons (
    id INT PRIMARY KEY AUTO_INCREMENT,

    code VARCHAR(50) NOT NULL UNIQUE,

    discount_percent DECIMAL(5,2) NOT NULL,

    max_discount DECIMAL(10,2) DEFAULT NULL,

    min_order DECIMAL(10,2) DEFAULT 0,

    usage_limit INT DEFAULT NULL,

    expires_at DATETIME,

    is_active BOOLEAN DEFAULT TRUE
);


-- ============================================
-- ORDERS
-- ============================================

CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,

    customer_id INT NOT NULL,
    restaurant_id INT NOT NULL,

    coupon_id INT NULL,

    total_price DECIMAL(10,2) NOT NULL,

    status ENUM(
        'pending',
        'accepted',
        'preparing',
        'out for delivery',
        'delivered',
        'cancelled'
    ) NOT NULL DEFAULT 'pending',

    payment_method ENUM(
        'COD',
        'Online'
    ) NOT NULL DEFAULT 'COD',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_order_customer
        FOREIGN KEY (customer_id)
        REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT fk_order_restaurant
        FOREIGN KEY (restaurant_id)
        REFERENCES restaurants(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT fk_order_coupon
        FOREIGN KEY (coupon_id)
        REFERENCES coupons(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);


-- ============================================
-- ORDER ITEMS
-- Products inside each order
-- ============================================

CREATE TABLE order_items (
    order_id INT NOT NULL,
    product_id INT NOT NULL,

    quantity INT NOT NULL DEFAULT 1,

    -- Store product price at the time of ordering
    price DECIMAL(10,2) NOT NULL,

    PRIMARY KEY (order_id, product_id),

    CONSTRAINT fk_order_item_order
        FOREIGN KEY (order_id)
        REFERENCES orders(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT fk_order_item_product
        FOREIGN KEY (product_id)
        REFERENCES products(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);


-- ============================================
-- RESTAURANT RATINGS
-- ============================================

CREATE TABLE ratings (
    id INT PRIMARY KEY AUTO_INCREMENT,

    customer_id INT NOT NULL,
    restaurant_id INT NOT NULL,

    rating INT NOT NULL,
    comment TEXT,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_rating_customer
        FOREIGN KEY (customer_id)
        REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT fk_rating_restaurant
        FOREIGN KEY (restaurant_id)
        REFERENCES restaurants(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    -- One rating per customer for each restaurant
    UNIQUE(customer_id, restaurant_id)
);


-- ============================================
-- NOTIFICATIONS
-- ============================================

CREATE TABLE notifications (
    id INT PRIMARY KEY AUTO_INCREMENT,

    user_id INT NOT NULL,

    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,

    is_read BOOLEAN DEFAULT FALSE,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_notification_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);