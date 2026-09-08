<?php

namespace Http\Controllers;

use Models\Restaurant;
use Http\Forms\RestaurantForm;
use Core\MockData\RestaurantMockData;

class RestaurantController
{
    public function dashboard()
    {
        $restaurant = RestaurantMockData::restaurant();
        $stats = RestaurantMockData::stats();
        $orders = RestaurantMockData::orders();

        view('restaurant/dashboard.view.php', [
            'restaurant' => $restaurant,
            'stats' => $stats,
            'orders' => $orders
        ]);
    }

    public function products()
    {
        view('restaurant/products.view.php');
    }

    public function categories()
    {
        view('restaurant/categories.view.php');
    }

    public function orders()
    {
        view('restaurant/orders.view.php');
    }

    public function profile()
    {
        view('restaurant/profile.view.php');
    }

    public function showRestaurantDetails()
    {
        $restaurantId = (int) ($_GET['id'] ?? 0);

        if ($restaurantId <= 0) {
            abort(404);
        }

        $restaurant = Restaurant::findById($restaurantId);

        if (!$restaurant) {
            abort(404);
        }

        $products = Restaurant::getProducts($restaurantId);

        $reviews = Restaurant::getReviews($restaurantId);

        // Get unique categories from the products
        $categories = [];

        foreach ($products as $product) {
            if (!in_array($product['category'], $categories, true)) {
                $categories[] = $product['category'];
            }
        }

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

    public function updateRestaurantStatus()
    {
        parse_str(file_get_contents('php://input'), $data);

        $id = $data['id'] ?? null;
        $isEnabled = $data['is_enabled'] ?? null;

        if ($id === null || $isEnabled === null) {
            http_response_code(422);

            header('Content-Type: application/json');

            echo json_encode([
                'success' => false,
                'message' => 'Invalid data'
            ]);

            return;
        }

        Restaurant::updateRestaurantStatus(
            (int) $id,
            (int) $isEnabled
        );

        header('Content-Type: application/json');

        echo json_encode([
            'success' => true
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

    public function storeReview()
    {
        $restaurantId = (int) ($_POST['restaurant_id'] ?? 0);
        $rating = (int) ($_POST['rating'] ?? 0);
        $comment = trim($_POST['comment'] ?? '');

        $customerId = (int) $_SESSION['user']['id'];

        if ($restaurantId <= 0) {
            abort(400);
        }

        if ($rating < 1 || $rating > 5) {
            abort(400);
        }

        if ($comment === '') {
            abort(400);
        }

        try {
            $result = Restaurant::createReview(
                $customerId,
                $restaurantId,
                $rating,
                $comment
            );

            header('Content-Type: application/json');

            echo json_encode([
                'success' => true,
                'review' => $result['review'],
                'rating' => $result['rating'],
                'review_count' => $result['review_count']
            ]);

            exit;
        } catch (\PDOException $e) {

            header('Content-Type: application/json');
            http_response_code(409);

            echo json_encode([
                'success' => false,
                'message' => 'You have already reviewed this restaurant.'
            ]);

            exit;
        }
    }
}
