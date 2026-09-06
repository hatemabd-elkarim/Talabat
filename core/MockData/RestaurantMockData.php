<?php

namespace Core\MockData;

class RestaurantMockData
{
    public static function restaurant()
    {
        return [
            'id' => 1,
            'name' => 'Pizza Hut',
            'cuisine' => 'Italian',
            'status' => 'open',
            'rating' => 4.5,
            'review_count' => 120,
            'cover_image' => 'https://img.magnific.com/free-psd/food-menu-delicious-pizza-facebook-cover-banner-template_120329-4895.jpg?semt=ais_hybrid&w=740&q=80',
            'delivery_time' => 30,
            'distance' => 2.5,
            'delivery_fee' => 20,
            'min_order' => 50,
            'is_open' => true,
            'description' => 'Delicious pizza delivered fresh.',
            'address' => 'Cairo, Egypt',
            'phone' => '01000000000',
        ];
    }

    public static function categories()
    {
        return [
            ['id' => 1, 'name' => 'Pizza', 'description' => 'Hand-tossed pizzas and signature toppings', 'products_count' => 5, 'is_active' => true],
            ['id' => 2, 'name' => 'Pasta', 'description' => 'Classic pasta dishes made to order', 'products_count' => 5, 'is_active' => true],
            ['id' => 3, 'name' => 'Drinks', 'description' => 'Cold drinks and fresh juices', 'products_count' => 4, 'is_active' => true],
            ['id' => 4, 'name' => 'Desserts', 'description' => 'Sweet treats for the perfect finish', 'products_count' => 1, 'is_active' => false],
        ];
    }

    public static function products()
    {
        return [
            ['id' => 1, 'name' => 'Margherita Pizza', 'category_id' => 1, 'category_name' => 'Pizza', 'price' => 150, 'is_available' => true, 'description' => 'Fresh mozzarella and tomato sauce Fresh mozzarella and tomato sauceFresh mozzarella and tomato sauceFresh mozzarella and tomato sauceFresh mozzarella and tomato sauceFresh mozzarella and tomato sauce', 'image' => 'https://www.vincenzosplate.com/wp-content/uploads/2020/06/Margherita-pizza_1500x1500-scaled.jpg'],
            ['id' => 2, 'name' => 'Pepperoni Pizza', 'category_id' => 1, 'category_name' => 'Pizza', 'price' => 180, 'is_available' => true, 'description' => 'Classic pizza topped with pepperoni and mozzarella', 'image' => 'https://images.unsplash.com/photo-1628840042765-356cda07504e'],
            ['id' => 3, 'name' => 'Chicken BBQ Pizza', 'category_id' => 1, 'category_name' => 'Pizza', 'price' => 200, 'is_available' => true, 'description' => 'Grilled chicken, BBQ sauce, mozzarella and onions', 'image' => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38'],
            ['id' => 4, 'name' => 'Vegetarian Pizza', 'category_id' => 1, 'category_name' => 'Pizza', 'price' => 170, 'is_available' => true, 'description' => 'Fresh vegetables, mushrooms, olives and mozzarella', 'image' => 'https://images.unsplash.com/photo-1579751626657-72bc17010498'],
            ['id' => 5, 'name' => 'Four Cheese Pizza', 'category_id' => 1, 'category_name' => 'Pizza', 'price' => 220, 'is_available' => true, 'description' => 'Mozzarella, cheddar, parmesan and blue cheese', 'image' => 'https://images.unsplash.com/photo-1574071318508-1cdbab80d002'],
            ['id' => 6, 'name' => 'Chicken Alfredo Pasta', 'category_id' => 2, 'category_name' => 'Pasta', 'price' => 190, 'is_available' => true, 'description' => 'Creamy Alfredo sauce with grilled chicken and parmesan', 'image' => 'https://images.unsplash.com/photo-1645112411341-6c4fd023714a'],
            ['id' => 7, 'name' => 'Spaghetti Bolognese', 'category_id' => 2, 'category_name' => 'Pasta', 'price' => 170, 'is_available' => true, 'description' => 'Spaghetti with rich tomato and minced beef sauce', 'image' => 'https://images.unsplash.com/photo-1551892374-ecf8754cf8b0'],
            ['id' => 8, 'name' => 'Penne Arrabbiata', 'category_id' => 2, 'category_name' => 'Pasta', 'price' => 140, 'is_available' => true, 'description' => 'Penne pasta with spicy tomato and garlic sauce', 'image' => 'https://images.unsplash.com/photo-1473093295043-cdd812d0e601'],
            ['id' => 9, 'name' => 'Lasagna', 'category_id' => 2, 'category_name' => 'Pasta', 'price' => 210, 'is_available' => true, 'description' => 'Layers of pasta, beef, tomato sauce and melted cheese', 'image' => 'https://images.unsplash.com/photo-1574894709920-11b28e7367e3'],
            ['id' => 10, 'name' => 'Shrimp Pasta', 'category_id' => 2, 'category_name' => 'Pasta', 'price' => 230, 'is_available' => true, 'description' => 'Creamy pasta with garlic shrimp and parmesan', 'image' => 'https://images.unsplash.com/photo-1563379926898-05f4575a45d8'],
            ['id' => 11, 'name' => 'Pepsi', 'category_id' => 3, 'category_name' => 'Drinks', 'price' => 30, 'is_available' => true, 'description' => 'Chilled Pepsi soft drink', 'image' => 'https://images.unsplash.com/photo-1629203849820-fdd70d49c38e'],
            ['id' => 12, 'name' => 'Orange Juice', 'category_id' => 3, 'category_name' => 'Drinks', 'price' => 50, 'is_available' => true, 'description' => 'Freshly squeezed orange juice', 'image' => 'https://images.unsplash.com/photo-1600271886742-f049cd451bba'],
            ['id' => 13, 'name' => 'Mango Juice', 'category_id' => 3, 'category_name' => 'Drinks', 'price' => 55, 'is_available' => true, 'description' => 'Fresh and sweet mango juice', 'image' => 'https://images.unsplash.com/photo-1605027990121-cbae9e0642df'],
            ['id' => 14, 'name' => 'Mineral Water', 'category_id' => 3, 'category_name' => 'Drinks', 'price' => 15, 'is_available' => false, 'description' => 'Cold bottled mineral water', 'image' => 'https://images.unsplash.com/photo-1564419320461-6870880221ad'],
            ['id' => 15, 'name' => 'Chocolate Cake', 'category_id' => 4, 'category_name' => 'Desserts', 'price' => 85, 'is_available' => true, 'description' => 'Rich chocolate cake with chocolate sauce', 'image' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587'],
        ];
    }

    public static function reviews()
    {
        return [
            ['id' => 1, 'customer_name' => 'Ahmed Youssef', 'rating' => 5, 'comment' => 'Best pizza in Cairo, delivered hot and fast!', 'created_at' => '2026-08-20'],
            ['id' => 2, 'customer_name' => 'Mona Adel', 'rating' => 4, 'comment' => 'Really good, but delivery was a bit late.', 'created_at' => '2026-08-15'],
            ['id' => 3, 'customer_name' => 'Karim Hassan', 'rating' => 5, 'comment' => 'Margherita pizza is amazing, will order again.', 'created_at' => '2026-08-10'],
        ];
    }

    public static function orders()
    {
        return [
            ['id' => 1048, 'customer_name' => 'Mona Adel', 'items' => ['Pepperoni Pizza x1', 'Orange Juice x2'], 'total' => 280, 'status' => 'preparing', 'payment_method' => 'Online payment', 'created_at' => '2026-09-06 12:30', 'delivery_address' => 'Nasr City, Cairo'],
            ['id' => 1047, 'customer_name' => 'Ahmed Youssef', 'items' => ['Chicken Alfredo Pasta x2'], 'total' => 380, 'status' => 'accepted', 'payment_method' => 'Cash on delivery', 'created_at' => '2026-09-06 12:08', 'delivery_address' => 'Heliopolis, Cairo'],
            ['id' => 1046, 'customer_name' => 'Karim Hassan', 'items' => ['Margherita Pizza x1', 'Pepsi x1'], 'total' => 180, 'status' => 'delivered', 'payment_method' => 'Online payment', 'created_at' => '2026-09-05 20:15', 'delivery_address' => 'Maadi, Cairo'],
            ['id' => 1045, 'customer_name' => 'Sara Mostafa', 'items' => ['Lasagna x1', 'Mango Juice x1'], 'total' => 265, 'status' => 'delivered', 'payment_method' => 'Cash on delivery', 'created_at' => '2026-09-05 18:42', 'delivery_address' => 'New Cairo, Cairo'],
            ['id' => 1044, 'customer_name' => 'Omar Samir', 'items' => ['Four Cheese Pizza x1'], 'total' => 220, 'status' => 'cancelled', 'payment_method' => 'Online payment', 'created_at' => '2026-09-05 16:20', 'delivery_address' => 'Dokki, Cairo'],
        ];
    }

    public static function stats()
    {
        return [
            'today_sales' => 15840,
            'today_orders' => 42,
            'pending_orders' => 7,
            'total_products' => count(self::products()),
            'available_products' => 14,
            'average_rating' => 4.5,
            'sales_change' => 12.4,
            'orders_change' => 8.1,
            'sales_by_day' => [
                ['day' => 'Sat', 'sales' => 12400],
                ['day' => 'Sun', 'sales' => 13800],
                ['day' => 'Mon', 'sales' => 11600],
                ['day' => 'Tue', 'sales' => 14900],
                ['day' => 'Wed', 'sales' => 13200],
                ['day' => 'Thu', 'sales' => 17100],
                ['day' => 'Fri', 'sales' => 15840],
            ],
        ];
    }
}
