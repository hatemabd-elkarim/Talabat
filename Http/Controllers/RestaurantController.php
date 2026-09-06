<?php

namespace Http\Controllers;

use Models\Restaurant;
use Http\Forms\RestaurantForm;

class RestaurantController
{
    public function showRestaurantDetails()
    {
        $restaurant = [
            "id" => 1,
            "name" => "Pizza Hut",
            "cover_image" => "https://img.magnific.com/free-psd/food-menu-delicious-pizza-facebook-cover-banner-template_120329-4895.jpg?semt=ais_hybrid&w=740&q=80",
            "cuisine" => "Italian",
            "rating" => 4.5,
            "review_count" => 120,
            "delivery_time" => 30,
            "distance" => 2.5,
            "delivery_fee" => 20,
            "min_order" => 50,
            "is_open" => true,
            "description" => "Delicious pizza delivered fresh.",
            "address" => "Cairo, Egypt",
            "phone" => "01000000000"
        ];

        $categories = [
            ["id" => 1, "name" => "Pizza"],
            ["id" => 2, "name" => "Pasta"],
            ["id" => 3, "name" => "Drinks"]
        ];

        $products = [
            // Pizza
            [
                "id" => 1,
                "name" => "Margherita Pizza",
                "description" => "Fresh mozzarella and tomato sauce Fresh mozzarella and tomato sauceFresh mozzarella and tomato sauceFresh mozzarella and tomato sauceFresh mozzarella and tomato sauceFresh mozzarella and tomato sauce",
                "price" => 150,
                "image" => "https://www.vincenzosplate.com/wp-content/uploads/2020/06/Margherita-pizza_1500x1500-scaled.jpg",
                "category_id" => 1,
                "is_available" => true
            ],
            [
                "id" => 2,
                "name" => "Pepperoni Pizza",
                "description" => "Classic pizza topped with pepperoni and mozzarella",
                "price" => 180,
                "image" => "https://images.unsplash.com/photo-1628840042765-356cda07504e",
                "category_id" => 1,
                "is_available" => true
            ],
            [
                "id" => 3,
                "name" => "Chicken BBQ Pizza",
                "description" => "Grilled chicken, BBQ sauce, mozzarella and onions",
                "price" => 200,
                "image" => "https://images.unsplash.com/photo-1565299624946-b28f40a0ae38",
                "category_id" => 1,
                "is_available" => true
            ],
            [
                "id" => 4,
                "name" => "Vegetarian Pizza",
                "description" => "Fresh vegetables, mushrooms, olives and mozzarella",
                "price" => 170,
                "image" => "https://images.unsplash.com/photo-1579751626657-72bc17010498",
                "category_id" => 1,
                "is_available" => true
            ],
            [
                "id" => 5,
                "name" => "Four Cheese Pizza",
                "description" => "Mozzarella, cheddar, parmesan and blue cheese",
                "price" => 220,
                "image" => "https://images.unsplash.com/photo-1574071318508-1cdbab80d002",
                "category_id" => 1,
                "is_available" => true
            ],

            // Pasta
            [
                "id" => 6,
                "name" => "Chicken Alfredo Pasta",
                "description" => "Creamy Alfredo sauce with grilled chicken and parmesan",
                "price" => 190,
                "image" => "https://images.unsplash.com/photo-1645112411341-6c4fd023714a",
                "category_id" => 2,
                "is_available" => true
            ],
            [
                "id" => 7,
                "name" => "Spaghetti Bolognese",
                "description" => "Spaghetti with rich tomato and minced beef sauce",
                "price" => 170,
                "image" => "https://images.unsplash.com/photo-1551892374-ecf8754cf8b0",
                "category_id" => 2,
                "is_available" => true
            ],
            [
                "id" => 8,
                "name" => "Penne Arrabbiata",
                "description" => "Penne pasta with spicy tomato and garlic sauce",
                "price" => 140,
                "image" => "https://images.unsplash.com/photo-1473093295043-cdd812d0e601",
                "category_id" => 2,
                "is_available" => true
            ],
            [
                "id" => 9,
                "name" => "Lasagna",
                "description" => "Layers of pasta, beef, tomato sauce and melted cheese",
                "price" => 210,
                "image" => "https://images.unsplash.com/photo-1574894709920-11b28e7367e3",
                "category_id" => 2,
                "is_available" => true
            ],
            [
                "id" => 10,
                "name" => "Shrimp Pasta",
                "description" => "Creamy pasta with garlic shrimp and parmesan",
                "price" => 230,
                "image" => "https://images.unsplash.com/photo-1563379926898-05f4575a45d8",
                "category_id" => 2,
                "is_available" => true
            ],

            // Drinks
            [
                "id" => 11,
                "name" => "Pepsi",
                "description" => "Chilled Pepsi soft drink",
                "price" => 30,
                "image" => "https://images.unsplash.com/photo-1629203849820-fdd70d49c38e",
                "category_id" => 3,
                "is_available" => true
            ],
            [
                "id" => 12,
                "name" => "7UP",
                "description" => "Refreshing lemon-lime soft drink",
                "price" => 30,
                "image" => "https://images.unsplash.com/photo-1629203849820-fdd70d49c38e",
                "category_id" => 3,
                "is_available" => true
            ],
            [
                "id" => 13,
                "name" => "Orange Juice",
                "description" => "Freshly squeezed orange juice",
                "price" => 50,
                "image" => "https://images.unsplash.com/photo-1600271886742-f049cd451bba",
                "category_id" => 3,
                "is_available" => true
            ],
            [
                "id" => 14,
                "name" => "Mango Juice",
                "description" => "Fresh and sweet mango juice",
                "price" => 55,
                "image" => "https://images.unsplash.com/photo-1605027990121-cbae9e0642df",
                "category_id" => 3,
                "is_available" => true
            ],
            [
                "id" => 15,
                "name" => "Mineral Water",
                "description" => "Cold bottled mineral water",
                "price" => 15,
                "image" => "https://images.unsplash.com/photo-1564419320461-6870880221ad",
                "category_id" => 3,
                "is_available" => false
            ]
        ];

        $reviews = [
            [
                "id" => 1,
                "customer_name" => "Ahmed Youssef",
                "rating" => 5,
                "comment" => "Best pizza in Cairo, delivered hot and fast!",
                "created_at" => "2026-08-20"
            ],
            [
                "id" => 2,
                "customer_name" => "Mona Adel",
                "rating" => 4,
                "comment" => "Really good, but delivery was a bit late.",
                "created_at" => "2026-08-15"
            ],
            [
                "id" => 3,
                "customer_name" => "Karim Hassan",
                "rating" => 5,
                "comment" => "Margherita pizza is amazing, will order again.",
                "created_at" => "2026-08-10"
            ]
        ];

        view('customer/restaurant-details.view.php', [
            'restaurant' => $restaurant,
            'categories' => $categories,
            'products' => $products,
            'reviews' => $reviews
        ]);
    }

    public function adminRestaurants()
    {
        $restaurants = Restaurant::getRestaurants();

        $enabledCount = count(
            array_filter(
                $restaurants,
                fn($restaurant) => $restaurant['is_enabled']
            )
        );

        view('admin/restaurants.view.php', [
            'activePage' => 'a-restaurants',
            'restaurants' => $restaurants,
            'enabledCount' => $enabledCount,
        ]);
    }

    public function storeRestaurant()
    {
        $form = RestaurantForm::validate([
            'name' => $_POST['name'] ?? '',
            'cuisine' => $_POST['cuisine'] ?? '',
            'address' => $_POST['address'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'email' => $_POST['email'] ?? '',
            'latitude' => $_POST['latitude'] ?? '',
            'longitude' => $_POST['longitude'] ?? '',
            'is_enabled' => $_POST['is_enabled'] ?? 0,

            'logo' => $_FILES['logo'] ?? null,
            'banner' => $_FILES['banner'] ?? null,
        ]);

        $name = $form->attributes['name'];

        $logoName = $this->uploadRestaurantImage(
            $_FILES['logo'] ?? null,
            $name,
            'logo'
        );

        $bannerName = $this->uploadRestaurantImage(
            $_FILES['banner'] ?? null,
            $name,
            'banner'
        );

        $restaurant = Restaurant::createRestaurant([
            'name' => $name,
            'cuisine' => $form->attributes['cuisine'],
            'address' => $form->attributes['address'],
            'phone' => $form->attributes['phone'],
            'email' => $form->attributes['email'],
            'latitude' => $form->attributes['latitude'],
            'longitude' => $form->attributes['longitude'],
            'is_enabled' => $form->attributes['is_enabled'],
            'logo' => $logoName,
            'banner' => $bannerName,
        ]);

        header('Content-Type: application/json');

        echo json_encode([
            'success' => true,
            'restaurant' => $restaurant
        ]);
    }

    private function uploadRestaurantImage(
        ?array $file,
        string $restaurantName,
        string $type
    ): ?string {
        if (!$file || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        $uploadDirectory = __DIR__ . '/../../public/image_uploads/';

        $safeName = preg_replace(
            '/[^A-Za-z0-9_-]/',
            '_',
            $restaurantName
        );

        $extension = strtolower(
            pathinfo($file['name'], PATHINFO_EXTENSION)
        );

        $uniqueHash = bin2hex(random_bytes(6));

        $fileName = $safeName . '_' . $uniqueHash . '_' . $type . '.' . $extension;

        $destination = $uploadDirectory . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new \Exception('Failed to save image');
        }

        return $fileName;
    }
}
