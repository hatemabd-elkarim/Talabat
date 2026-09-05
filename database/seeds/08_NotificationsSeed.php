<?php

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../bootstrap.php';

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$notifications = [
    [
        'user_id' => 4,
        'title' => 'Order Delivered',
        'message' => 'Your order has been delivered successfully.',
    ],
    [
        'user_id' => 5,
        'title' => 'Order Update',
        'message' => 'Your order is currently being prepared.',
    ],
];

foreach ($notifications as $notification) {
    $db->query(
        "INSERT INTO notifications (
            user_id,
            title,
            message
        ) VALUES (
            :user_id,
            :title,
            :message
        )",
        $notification
    );
}
