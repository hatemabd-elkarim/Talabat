<?php

namespace Models;

use Core\App;
use Core\Database;

class Notification
{
    public static function getForUser(int $userId): array
    {
        $db = App::resolve(Database::class);

        return $db->query(
            "SELECT
                id,
                title,
                message,
                is_read,
                created_at
             FROM notifications
             WHERE user_id = :user_id
             ORDER BY created_at DESC",
            [
                'user_id' => $userId
            ]
        )->get();
    }

    public static function getUnreadCount(int $userId): int
    {
        $db = App::resolve(Database::class);

        $result = $db->query(
            "SELECT COUNT(*) AS unread_count
             FROM notifications
             WHERE user_id = :user_id
               AND is_read = FALSE",
            [
                'user_id' => $userId
            ]
        )->find();

        return (int) $result['unread_count'];
    }

    public static function markAsRead(int $notificationId, int $userId): void
    {
        $db = App::resolve(Database::class);

        $db->query(
            "UPDATE notifications
         SET is_read = TRUE
         WHERE id = :notification_id
           AND user_id = :user_id",
            [
                'notification_id' => $notificationId,
                'user_id' => $userId
            ]
        );
    }

    public static function markAllAsRead(int $userId): void
    {
        $db = App::resolve(Database::class);

        $db->query(
            "UPDATE notifications
         SET is_read = TRUE
         WHERE user_id = :user_id
           AND is_read = FALSE",
            [
                'user_id' => $userId
            ]
        );
    }
}
