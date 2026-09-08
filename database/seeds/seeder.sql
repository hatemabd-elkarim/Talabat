-- ============================================================
-- TALABAT SEED DATA
-- ============================================================
-- Reference customer location:
-- Latitude:  30.03830000
-- Longitude: 31.21020000
--
-- All restaurant locations are within approximately 10 km
-- of the reference location.
-- ============================================================

USE talabat;

START TRANSACTION;


-- ============================================================
-- 1. USERS
-- ============================================================
-- 10 restaurant owners
-- 10 customers
--
-- Password for all seeded accounts:
-- password
--
-- The password below is a valid bcrypt hash for "password".
-- ============================================================

INSERT INTO users
(
    id,
    name,
    email,
    password,
    phone,
    role,
    address_text,
    latitude,
    longitude
)
VALUES

-- Restaurant owners
(
    1001,
    'Burger Factory',
    'burger.factory@talabat.test',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC7Vf6J0y9JY6QX1rK2',
    '01010000001',
    'restaurant',
    'Nasr City, Cairo',
    30.04510000,
    31.21820000
),

(
    1002,
    'Pizza House',
    'pizza.house@talabat.test',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC7Vf6J0y9JY6QX1rK2',
    '01010000002',
    'restaurant',
    'Nasr City, Cairo',
    30.02870000,
    31.22540000
),

(
    1003,
    'Koshary El Tahrir',
    'koshary.tahrir@talabat.test',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC7Vf6J0y9JY6QX1rK2',
    '01010000003',
    'restaurant',
    'Heliopolis, Cairo',
    30.06020000,
    31.20570000
),

(
    1004,
    'Chicken Republic',
    'chicken.republic@talabat.test',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC7Vf6J0y9JY6QX1rK2',
    '01010000004',
    'restaurant',
    'Nasr City, Cairo',
    30.02050000,
    31.19680000
),

(
    1005,
    'Sushi Tokyo',
    'sushi.tokyo@talabat.test',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC7Vf6J0y9JY6QX1rK2',
    '01010000005',
    'restaurant',
    'Heliopolis, Cairo',
    30.05260000,
    31.23010000
),

(
    1006,
    'Grill House',
    'grill.house@talabat.test',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC7Vf6J0y9JY6QX1rK2',
    '01010000006',
    'restaurant',
    'Nasr City, Cairo',
    30.03210000,
    31.18790000
),

(
    1007,
    'Pasta Corner',
    'pasta.corner@talabat.test',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC7Vf6J0y9JY6QX1rK2',
    '01010000007',
    'restaurant',
    'Mokattam, Cairo',
    30.01580000,
    31.21560000
),

(
    1008,
    'Egyptian Kitchen',
    'egyptian.kitchen@talabat.test',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC7Vf6J0y9JY6QX1rK2',
    '01010000008',
    'restaurant',
    'Nasr City, Cairo',
    30.04890000,
    31.19250000
),

(
    1009,
    'Burger Station',
    'burger.station@talabat.test',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC7Vf6J0y9JY6QX1rK2',
    '01010000009',
    'restaurant',
    'Heliopolis, Cairo',
    30.06730000,
    31.21780000
),

(
    1010,
    'Fresh Bites',
    'fresh.bites@talabat.test',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC7Vf6J0y9JY6QX1rK2',
    '01010000010',
    'restaurant',
    'Nasr City, Cairo',
    30.02430000,
    31.23520000
),


-- Customers
(
    1011,
    'Ahmed Hassan',
    'ahmed@talabat.test',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC7Vf6J0y9JY6QX1rK2',
    '01010000011',
    'customer',
    'Nasr City, Cairo',
    30.03830000,
    31.21020000
),

(
    1012,
    'Omar Ali',
    'omar@talabat.test',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC7Vf6J0y9JY6QX1rK2',
    '01010000012',
    'customer',
    'Nasr City, Cairo',
    30.03830000,
    31.21020000
),

(
    1013,
    'Youssef Mohamed',
    'youssef@talabat.test',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC7Vf6J0y9JY6QX1rK2',
    '01010000013',
    'customer',
    'Nasr City, Cairo',
    30.03830000,
    31.21020000
),

(
    1014,
    'Karim Adel',
    'karim@talabat.test',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC7Vf6J0y9JY6QX1rK2',
    '01010000014',
    'customer',
    'Nasr City, Cairo',
    30.03830000,
    31.21020000
),

(
    1015,
    'Mostafa Samir',
    'mostafa@talabat.test',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC7Vf6J0y9JY6QX1rK2',
    '01010000015',
    'customer',
    'Nasr City, Cairo',
    30.03830000,
    31.21020000
),

(
    1016,
    'Mariam Ahmed',
    'mariam@talabat.test',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC7Vf6J0y9JY6QX1rK2',
    '01010000016',
    'customer',
    'Nasr City, Cairo',
    30.03830000,
    31.21020000
),

(
    1017,
    'Sara Mohamed',
    'sara@talabat.test',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC7Vf6J0y9JY6QX1rK2',
    '01010000017',
    'customer',
    'Nasr City, Cairo',
    30.03830000,
    31.21020000
),

(
    1018,
    'Nour Khaled',
    'nour@talabat.test',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC7Vf6J0y9JY6QX1rK2',
    '01010000018',
    'customer',
    'Nasr City, Cairo',
    30.03830000,
    31.21020000
),

(
    1019,
    'Hana Mahmoud',
    'hana@talabat.test',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC7Vf6J0y9JY6QX1rK2',
    '01010000019',
    'customer',
    'Nasr City, Cairo',
    30.03830000,
    31.21020000
),

(
    1020,
    'Salma Tarek',
    'salma@talabat.test',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC7Vf6J0y9JY6QX1rK2',
    '01010000020',
    'customer',
    'Nasr City, Cairo',
    30.03830000,
    31.21020000
);


-- ============================================================
-- 2. RESTAURANTS
-- ============================================================

INSERT INTO restaurants
(
    id,
    name,
    description,
    logo,
    banner,
    cuisine,
    is_open,
    is_enabled,
    address_text,
    latitude,
    longitude,
    delivery_time,
    delivery_fee,
    min_order,
    owner_id
)
VALUES

(
    101,
    'Burger Factory',
    'Fresh beef burgers, crispy fries and delicious sides.',
    'burger_factory_logo.jpg',
    'burger_factory_banner.jpg',
    'Burgers',
    TRUE,
    TRUE,
    'Nasr City, Cairo',
    30.04510000,
    31.21820000,
    30,
    25.00,
    100.00,
    1001
),

(
    102,
    'Pizza House',
    'Handmade Italian-style pizzas with fresh ingredients.',
    'pizza_house_logo.jpg',
    'pizza_house_banner.jpg',
    'Pizza',
    TRUE,
    TRUE,
    'Nasr City, Cairo',
    30.02870000,
    31.22540000,
    35,
    30.00,
    120.00,
    1002
),

(
    103,
    'Koshary El Tahrir',
    'Authentic Egyptian koshary and traditional meals.',
    'koshary_tahrir_logo.jpg',
    'koshary_tahrir_banner.jpg',
    'Egyptian Food',
    TRUE,
    TRUE,
    'Heliopolis, Cairo',
    30.06020000,
    31.20570000,
    25,
    20.00,
    60.00,
    1003
),

(
    104,
    'Chicken Republic',
    'Crispy chicken meals, sandwiches and family combos.',
    'chicken_republic_logo.jpg',
    'chicken_republic_banner.jpg',
    'Chicken',
    TRUE,
    TRUE,
    'Nasr City, Cairo',
    30.02050000,
    31.19680000,
    35,
    25.00,
    100.00,
    1004
),

(
    105,
    'Sushi Tokyo',
    'Japanese sushi, rolls and fresh seafood.',
    'sushi_tokyo_logo.jpg',
    'sushi_tokyo_banner.jpg',
    'Japanese',
    TRUE,
    TRUE,
    'Heliopolis, Cairo',
    30.05260000,
    31.23010000,
    45,
    40.00,
    180.00,
    1005
),

(
    106,
    'Grill House',
    'Grilled meat, chicken and delicious Egyptian sides.',
    'grill_house_logo.jpg',
    'grill_house_banner.jpg',
    'Grills',
    TRUE,
    TRUE,
    'Nasr City, Cairo',
    30.03210000,
    31.18790000,
    30,
    25.00,
    120.00,
    1006
),

(
    107,
    'Pasta Corner',
    'Creamy pasta, Italian classics and fresh sauces.',
    'pasta_corner_logo.jpg',
    'pasta_corner_banner.jpg',
    'Italian',
    TRUE,
    TRUE,
    'Mokattam, Cairo',
    30.01580000,
    31.21560000,
    40,
    30.00,
    100.00,
    1007
),

(
    108,
    'Egyptian Kitchen',
    'Traditional Egyptian dishes prepared fresh every day.',
    'egyptian_kitchen_logo.jpg',
    'egyptian_kitchen_banner.jpg',
    'Egyptian Food',
    TRUE,
    TRUE,
    'Nasr City, Cairo',
    30.04890000,
    31.19250000,
    30,
    20.00,
    70.00,
    1008
),

(
    109,
    'Burger Station',
    'Juicy burgers and loaded fries.',
    'burger_station_logo.jpg',
    'burger_station_banner.jpg',
    'Burgers',
    TRUE,
    TRUE,
    'Heliopolis, Cairo',
    30.06730000,
    31.21780000,
    30,
    25.00,
    100.00,
    1009
),

(
    110,
    'Fresh Bites',
    'Healthy bowls, sandwiches and fresh meals.',
    'fresh_bites_logo.jpg',
    'fresh_bites_banner.jpg',
    'Healthy Food',
    TRUE,
    TRUE,
    'Nasr City, Cairo',
    30.02430000,
    31.23520000,
    30,
    25.00,
    100.00,
    1010
);


-- ============================================================
-- 3. PRODUCTS
-- ============================================================

INSERT INTO products
(
    id,
    name,
    description,
    price,
    image,
    is_available,
    restaurant_id,
    category
)
VALUES

(
    201,
    'Classic Beef Burger',
    'Beef patty with lettuce, tomato and special sauce.',
    180.00,
    'classic_beef_burger.jpg',
    TRUE,
    101,
    'Burgers'
),

(
    202,
    'Margherita Pizza',
    'Classic pizza with tomato sauce, mozzarella and basil.',
    220.00,
    'margherita_pizza.jpg',
    TRUE,
    102,
    'Pizza'
),

(
    203,
    'Koshary Special',
    'Rice, pasta, lentils, chickpeas and crispy onions.',
    90.00,
    'koshary_special.jpg',
    TRUE,
    103,
    'Koshary'
),

(
    204,
    'Chicken Meal',
    'Crispy chicken pieces with fries and coleslaw.',
    200.00,
    'chicken_meal.jpg',
    TRUE,
    104,
    'Chicken'
),

(
    205,
    'California Roll',
    'Fresh sushi roll with crab, avocado and cucumber.',
    280.00,
    'california_roll.jpg',
    TRUE,
    105,
    'Sushi'
),

(
    206,
    'Mixed Grill',
    'Grilled kofta, kebab and chicken with sides.',
    320.00,
    'mixed_grill.jpg',
    TRUE,
    106,
    'Grills'
),

(
    207,
    'Chicken Alfredo',
    'Creamy Alfredo pasta with grilled chicken.',
    240.00,
    'chicken_alfredo.jpg',
    TRUE,
    107,
    'Pasta'
),

(
    208,
    'Molokhia Meal',
    'Traditional Egyptian molokhia served with rice.',
    150.00,
    'molokhia_meal.jpg',
    TRUE,
    108,
    'Egyptian'
),

(
    209,
    'Double Burger',
    'Two beef patties with cheese and special sauce.',
    230.00,
    'double_burger.jpg',
    TRUE,
    109,
    'Burgers'
),

(
    210,
    'Chicken Caesar Bowl',
    'Fresh lettuce, grilled chicken, parmesan and Caesar dressing.',
    190.00,
    'chicken_caesar_bowl.jpg',
    TRUE,
    110,
    'Healthy'
);


INSERT INTO coupons
(
    id,
    code,
    discount_percent,
    max_discount,
    min_order,
    usage_limit,
    expires_at,
    is_active
)
VALUES
(
    301,
    'WELCOME10',
    10.00,
    50.00,
    100.00,
    1000,
    '2027-12-31 23:59:59',
    TRUE
),

(
    302,
    'SAVE20',
    20.00,
    80.00,
    200.00,
    500,
    '2027-12-31 23:59:59',
    TRUE
),

(
    303,
    'SAVE15',
    15.00,
    60.00,
    150.00,
    500,
    '2027-11-30 23:59:59',
    TRUE
),

(
    304,
    'SAVE25',
    25.00,
    100.00,
    300.00,
    300,
    '2027-10-31 23:59:59',
    TRUE
),

(
    305,
    'FOOD10',
    10.00,
    40.00,
    100.00,
    1000,
    '2027-12-31 23:59:59',
    TRUE
),

(
    306,
    'LUNCH20',
    20.00,
    75.00,
    200.00,
    500,
    '2027-09-30 23:59:59',
    TRUE
),

(
    307,
    'DINNER15',
    15.00,
    60.00,
    150.00,
    500,
    '2027-12-15 23:59:59',
    TRUE
),

(
    308,
    'BIGORDER30',
    30.00,
    150.00,
    500.00,
    100,
    '2027-12-31 23:59:59',
    TRUE
),

(
    309,
    'NEWUSER12',
    12.00,
    50.00,
    100.00,
    1000,
    '2027-12-31 23:59:59',
    TRUE
),

(
    310,
    'WEEKEND10',
    10.00,
    50.00,
    100.00,
    500,
    '2027-12-31 23:59:59',
    TRUE
);


-- ============================================================
-- 5. RATINGS
-- ============================================================
-- One rating for each restaurant.
-- This gives every restaurant a rating for testing.
-- ============================================================

INSERT INTO ratings
(
    id,
    customer_id,
    restaurant_id,
    rating,
    comment
)
VALUES

(
    501,
    1011,
    101,
    4,
    'Great burger and fast delivery.'
),

(
    502,
    1012,
    102,
    5,
    'Excellent pizza and fresh ingredients.'
),

(
    503,
    1013,
    103,
    4,
    'Very good koshary.'
),

(
    504,
    1014,
    104,
    5,
    'Amazing chicken meal.'
),

(
    505,
    1015,
    105,
    5,
    'Fresh sushi and excellent quality.'
),

(
    506,
    1016,
    106,
    4,
    'The mixed grill was very good.'
),

(
    507,
    1017,
    107,
    5,
    'Delicious pasta.'
),

(
    508,
    1018,
    108,
    3,
    'Good traditional food.'
),

(
    509,
    1019,
    109,
    4,
    'Good burgers and fries.'
),

(
    510,
    1020,
    110,
    5,
    'Fresh and healthy food.'
);


-- ============================================================
-- 6. ORDERS
-- ============================================================
-- 10 orders.
-- Each order belongs to a customer and restaurant.
-- ============================================================

INSERT INTO orders
(
    id,
    customer_id,
    restaurant_id,
    coupon_id,
    total_price,
    status,
    payment_method,
    created_at
)
VALUES

(
    401,
    1011,
    101,
    301,
    180.00,
    'delivered',
    'COD',
    NOW()
),

(
    402,
    1012,
    102,
    302,
    220.00,
    'delivered',
    'Online',
    NOW()
),

(
    403,
    1013,
    103,
    NULL,
    90.00,
    'delivered',
    'COD',
    NOW()
),

(
    404,
    1014,
    104,
    303,
    200.00,
    'accepted',
    'Online',
    NOW()
),

(
    405,
    1015,
    105,
    305,
    280.00,
    'preparing',
    'Online',
    NOW()
),

(
    406,
    1016,
    106,
    NULL,
    320.00,
    'out for delivery',
    'COD',
    NOW()
),

(
    407,
    1017,
    107,
    306,
    240.00,
    'pending',
    'COD',
    NOW()
),

(
    408,
    1018,
    108,
    NULL,
    150.00,
    'delivered',
    'COD',
    NOW()
),

(
    409,
    1019,
    109,
    308,
    230.00,
    'cancelled',
    'COD',
    NOW()
),

(
    410,
    1020,
    110,
    310,
    190.00,
    'delivered',
    'Online',
    NOW()
);


-- ============================================================
-- 7. ORDER ITEMS
-- ============================================================
-- One product per order for simple initial testing.
-- ============================================================

INSERT INTO order_items
(
    order_id,
    product_id,
    quantity,
    price
)
VALUES

(
    401,
    201,
    1,
    180.00
),

(
    402,
    202,
    1,
    220.00
),

(
    403,
    203,
    1,
    90.00
),

(
    404,
    204,
    1,
    200.00
),

(
    405,
    205,
    1,
    280.00
),

(
    406,
    206,
    1,
    320.00
),

(
    407,
    207,
    1,
    240.00
),

(
    408,
    208,
    1,
    150.00
),

(
    409,
    209,
    1,
    230.00
),

(
    410,
    210,
    1,
    190.00
);


-- ============================================================
-- 8. NOTIFICATIONS
-- ============================================================

INSERT INTO notifications
(
    id,
    user_id,
    title,
    message,
    is_read,
    created_at
)
VALUES

(
    601,
    1011,
    'Order Delivered',
    'Your Burger Factory order has been delivered.',
    TRUE,
    NOW()
),

(
    602,
    1012,
    'Order Delivered',
    'Your Pizza House order has been delivered.',
    TRUE,
    NOW()
),

(
    603,
    1013,
    'Order Delivered',
    'Your Koshary El Tahrir order has been delivered.',
    FALSE,
    NOW()
),

(
    604,
    1014,
    'Order Accepted',
    'Chicken Republic has accepted your order.',
    FALSE,
    NOW()
),

(
    605,
    1015,
    'Order Preparing',
    'Sushi Tokyo is preparing your order.',
    FALSE,
    NOW()
),

(
    606,
    1016,
    'Out for Delivery',
    'Your Grill House order is on the way.',
    FALSE,
    NOW()
),

(
    607,
    1017,
    'Order Received',
    'Your Pasta Corner order is waiting for confirmation.',
    FALSE,
    NOW()
),

(
    608,
    1018,
    'Order Delivered',
    'Your Egyptian Kitchen order has been delivered.',
    TRUE,
    NOW()
),

(
    609,
    1019,
    'Order Cancelled',
    'Your Burger Station order has been cancelled.',
    TRUE,
    NOW()
),

(
    610,
    1020,
    'Order Delivered',
    'Your Fresh Bites order has been delivered.',
    TRUE,
    NOW()
);


-- ============================================================
-- FINISH
-- ============================================================

COMMIT;