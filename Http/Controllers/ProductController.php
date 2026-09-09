<?php

namespace Http\Controllers;

use Core\Session;
use Models\Product;
use Models\Restaurant;

class ProductController
{
    public function addProduct()
    {
        $userId = (int) Session::get('user')['id'];

        $restaurant = Restaurant::findByOwnerId($userId);

        if (!$restaurant) {
            http_response_code(404);

            echo json_encode([
                'success' => false,
                'message' => 'Restaurant not found'
            ]);

            return;
        }

        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $price = $_POST['price'] ?? '';
        $category = trim($_POST['category'] ?? '');

        $isAvailable = isset($_POST['is_available']) ? 1 : 0;

        if ($name === '' || $price === '') {
            http_response_code(422);

            echo json_encode([
                'success' => false,
                'message' => 'Name and price are required.'
            ]);

            return;
        }

        $imagePath = null;

        /*
     * Handle image
     */
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

            $file = $_FILES['image'];

            $allowedTypes = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/webp' => 'webp'
            ];

            $mimeType = mime_content_type($file['tmp_name']);

            if (!isset($allowedTypes[$mimeType])) {
                http_response_code(422);

                echo json_encode([
                    'success' => false,
                    'message' => 'Only JPG, PNG and WEBP images are allowed.'
                ]);

                return;
            }

            /*
         * Create a safe version of the product name
         */
            $safeName = strtolower($name);
            $safeName = preg_replace('/[^a-z0-9]+/', '-', $safeName);
            $safeName = trim($safeName, '-');

            /*
         * Generate hash
         */
            $hash = substr(
                hash(
                    'sha256',
                    $name . microtime(true) . random_bytes(16)
                ),
                0,
                12
            );

            $extension = $allowedTypes[$mimeType];

            $fileName = $safeName . '-' . $hash . '.' . $extension;

            /*
         * Upload directory
         */
            $uploadDirectory = __DIR__ . '/../../public/image_uploads/';

            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }

            $destination = $uploadDirectory . $fileName;

            if (!move_uploaded_file($file['tmp_name'], $destination)) {
                http_response_code(500);

                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to upload image.'
                ]);

                return;
            }

            $imagePath = $fileName;
        }

        Product::createProduct([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'image' => $imagePath,
            'is_available' => $isAvailable,
            'restaurant_id' => $restaurant['id'],
            'category' => $category
        ]);

        header('Content-Type: application/json');

        echo json_encode([
            'success' => true,
            'message' => 'Product added successfully.'
        ]);
    }
    public function updateProduct()
    {
        $userId = (int) Session::get('user')['id'];

        $restaurant = Restaurant::findByOwnerId($userId);

        if (!$restaurant) {
            http_response_code(404);

            echo json_encode([
                'success' => false,
                'message' => 'Restaurant not found.'
            ]);

            return;
        }

        $productId = $_POST['id'];

        $product = Product::findById($productId);

        if (!$product || (int) $product['restaurant_id'] !== (int) $restaurant['id']) {
            http_response_code(404);

            echo json_encode([
                'success' => false,
                'message' => 'Product not found.'
            ]);

            return;
        }

        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $price = $_POST['price'] ?? '';
        $category = trim($_POST['category'] ?? '');

        $isAvailable = isset($_POST['is_available']) ? 1 : 0;

        if ($name === '' || $price === '') {
            http_response_code(422);

            echo json_encode([
                'success' => false,
                'message' => 'Name and price are required.'
            ]);

            return;
        }

        /*
     * Keep the existing image unless
     * a new image was uploaded.
     */
        $imagePath = $product['image'];

        if (
            isset($_FILES['image']) &&
            $_FILES['image']['error'] === UPLOAD_ERR_OK
        ) {

            $file = $_FILES['image'];

            $allowedTypes = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/webp' => 'webp'
            ];

            $mimeType = mime_content_type($file['tmp_name']);

            if (!isset($allowedTypes[$mimeType])) {
                http_response_code(422);

                echo json_encode([
                    'success' => false,
                    'message' => 'Only JPG, PNG and WEBP images are allowed.'
                ]);

                return;
            }

            $safeName = strtolower($name);
            $safeName = preg_replace('/[^a-z0-9]+/', '-', $safeName);
            $safeName = trim($safeName, '-');

            $hash = substr(
                hash(
                    'sha256',
                    $name . microtime(true) . random_bytes(16)
                ),
                0,
                12
            );

            $extension = $allowedTypes[$mimeType];

            $fileName =
                $safeName . '-' . $hash . '.' . $extension;

            $uploadDirectory =
                __DIR__ . '/../../public/image_uploads';

            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }

            $destination =
                $uploadDirectory . '/' . $fileName;

            if (!move_uploaded_file(
                $file['tmp_name'],
                $destination
            )) {
                http_response_code(500);

                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to upload image.'
                ]);

                return;
            }

            $imagePath = $fileName;
        }

        Product::updateProduct(
            $productId,
            $restaurant['id'],
            [
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'category' => $category,
                'is_available' => $isAvailable,
                'image' => $imagePath
            ]
        );

        header('Content-Type: application/json');

        echo json_encode([
            'success' => true,
            'message' => 'Product updated successfully.'
        ]);
    }

    public function updateProductAvailability()
    {
        $userId = (int) Session::get('user')['id'];

        $restaurant = Restaurant::findByOwnerId($userId);

        if (!$restaurant) {
            http_response_code(404);

            echo json_encode([
                'success' => false,
                'message' => 'Restaurant not found.'
            ]);

            return;
        }

        $productId = $_POST['id'];

        $isAvailable =
            isset($_POST['is_available']) &&
            (int) $_POST['is_available'] === 1;

        Product::updateAvailability(
            $productId,
            $restaurant['id'],
            $isAvailable
        );

        header('Content-Type: application/json');

        echo json_encode([
            'success' => true,
            'message' => $isAvailable
                ? 'Product is now available.'
                : 'Product is now unavailable.'
        ]);
    }

    public function deleteProduct()
    {
        $userId = (int) Session::get('user')['id'];
        $restaurant = Restaurant::findByOwnerId($userId);

        if (!$restaurant) {
            http_response_code(404);

            echo json_encode([
                'success' => false,
                'message' => 'Restaurant not found.'
            ]);

            return;
        }

        $productId = (int) ($_POST['id'] ?? 0);

        if ($productId <= 0) {
            http_response_code(422);

            echo json_encode([
                'success' => false,
                'message' => 'Invalid product.'
            ]);

            return;
        }

        $product = Product::findById($productId);

        if (
            !$product ||
            (int) $product['restaurant_id'] !== (int) $restaurant['id']
        ) {
            http_response_code(404);

            echo json_encode([
                'success' => false,
                'message' => 'Product not found.'
            ]);

            return;
        }

        Product::deleteProduct(
            $productId,
            $restaurant['id']
        );

        header('Content-Type: application/json');

        echo json_encode([
            'success' => true,
            'message' => 'Product deleted successfully.'
        ]);
    }
}
