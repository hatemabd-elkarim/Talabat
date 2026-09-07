<?php

namespace Http\Controllers;

use Core\App;
use Core\Session;
use Models\User;

class ProfileController
{
    public function showCustomerProfile()
    {
        $db = App::resolve('Core\Database');

        $customerId = $_SESSION['user']['id'] ?? null;

        if (!$customerId) {
            redirect('/login');
        }

        $user = $db->query("
            SELECT id, name, email, phone, role, address_text, created_at
            FROM users
            WHERE id = :id
        ", ['id' => $customerId])->findOrFail();

        $customer = [
            "id"           => $user['id'],
            "name"         => $user['name'],
            "email"        => $user['email'],
            "phone"        => $user['phone'],
            "role"         => ucfirst($user['role']),
            "address"      => $user['address_text'] ?? 'Set your address',
            "member_since" => date('F Y', strtotime($user['created_at'])),
        ];

        view('customer/profile.view.php', [
            'customer' => $customer,
        ]);
    }

    public function updateLocation()
    {
        $latitude = $_POST['latitude'] ?? null;
        $longitude = $_POST['longitude'] ?? null;

        if ($latitude === null || $longitude === null) {
            http_response_code(422);

            header('Content-Type: application/json');

            echo json_encode([
                'success' => false,
                'message' => 'Latitude and longitude are required'
            ]);

            return;
        }

        $user = Session::get('user');

        User::updateLocation(
            $user['id'],
            (float) $latitude,
            (float) $longitude
        );

        header('Content-Type: application/json');

        echo json_encode([
            'success' => true
        ]);
    }
}
