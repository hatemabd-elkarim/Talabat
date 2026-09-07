<?php

namespace Http\Controllers;

use Core\Session;
use Models\Notification;

class NotificationController
{
    public function showCustomerNotifications()
    {
        $userId = (int) Session::get('user')['id'];

        $notifications = Notification::getForUser($userId);

        $unreadCount = Notification::getUnreadCount($userId);

        view('customer/notifications.view.php', [
            'notifications' => $notifications,
            'unreadCount' => $unreadCount
        ]);
    }

    public function markNotificationRead()
    {
        $userId = (int) Session::get('user')['id'];

        $data = json_decode(file_get_contents('php://input'), true);

        $notificationId = (int) ($data['notification_id'] ?? 0);

        if ($notificationId <= 0) {
            http_response_code(400);

            echo json_encode([
                'success' => false,
                'message' => 'Invalid notification ID'
            ]);

            return;
        }

        Notification::markAsRead(
            $notificationId,
            $userId
        );

        echo json_encode([
            'success' => true
        ]);
    }

    public function markAllNotificationsRead()
    {
        $userId = (int) Session::get('user')['id'];

        Notification::markAllAsRead($userId);

        echo json_encode([
            'success' => true
        ]);
    }
}
