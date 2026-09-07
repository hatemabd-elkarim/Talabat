<?php

namespace Http\Controllers;

use Core\App;
use Core\Session;
use Models\User;
use Core\Database;

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

    public function update()
    {
        $userId = (int) Session::get('user')['id'];

        $data = json_decode(
            file_get_contents('php://input'),
            true
        );

        $name = trim($data['name'] ?? '');
        $email = trim($data['email'] ?? '');
        $phone = trim($data['phone'] ?? '');
        $address = trim($data['address'] ?? '');

        if (
            $name === '' ||
            $email === '' ||
            $phone === '' ||
            $address === ''
        ) {
            http_response_code(400);

            echo json_encode([
                'success' => false,
                'message' => 'All fields are required.'
            ]);

            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);

            echo json_encode([
                'success' => false,
                'field' => 'email',
                'message' => 'Invalid email address.'
            ]);

            return;
        }

        $existingEmail = User::findByEmail($email);

        if ($existingEmail && (int) $existingEmail['id'] !== $userId) {
            http_response_code(409);

            echo json_encode([
                'success' => false,
                'field' => 'email',
                'message' => 'This email is already taken.'
            ]);

            return;
        }

        $existingPhone = User::findByPhone($phone);

        if ($existingPhone && (int) $existingPhone['id'] !== $userId) {
            http_response_code(409);

            echo json_encode([
                'success' => false,
                'field' => 'phone',
                'message' => 'This phone number is already taken.'
            ]);

            return;
        }

        $db = App::resolve(Database::class);

        $db->query(
            "UPDATE users
             SET name = :name,
                 email = :email,
                 phone = :phone,
                 address_text = :address
             WHERE id = :id",
            [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'id' => $userId
            ]
        );

        // Update the session data as well
        $user = Session::get('user');

        $user['name'] = $name;
        $user['email'] = $email;
        $user['phone'] = $phone;
        $user['address_text'] = $address;

        Session::put('user', $user);

        echo json_encode([
            'success' => true,
            'message' => 'Profile updated successfully.',
            'address' => $address
        ]);
    }
}
