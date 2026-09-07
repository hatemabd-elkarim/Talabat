<?php
include __DIR__ . '/../partials/header.view.php';
include __DIR__ . '/nav.view.php';
?>

<link rel="stylesheet" href="/CSS/notifications.css">

<div class="notifications-page">
    <div class="notifications-container">

        <div class="notifications-header">
            <div>
                <h1>Notifications</h1>

                <p class="unread-count">
                    <?= $unreadCount ?> unread notifications
                </p>
            </div>

            <a href="#" class="mark-all-read" id="markAllRead">
                Mark all read
            </a>
        </div>

        <?php if (empty($notifications)): ?>

            <p class="section-title">NO NOTIFICATIONS</p>

            <div class="notification-item">
                <div class="notification-content">
                    <p class="notification-text">
                        You don't have any notifications yet.
                    </p>
                </div>
            </div>

        <?php else: ?>

            <?php
            $currentGroup = "";
            ?>

            <?php foreach ($notifications as $item): ?>

                <?php
                $isUnread = !$item['is_read'];

                /*
                 * Group notifications by date.
                 */
                $notificationDate = date(
                    'Y-m-d',
                    strtotime($item['created_at'])
                );

                $today = date('Y-m-d');

                if ($notificationDate === $today) {
                    $group = 'NEW';
                } else {
                    $group = 'EARLIER';
                }

                /*
                 * Choose icon based on notification title.
                 */
                if (stripos($item['title'], 'order') !== false) {
                    $icon = 'delivery-box.php';
                    $iconColor = 'orange';
                } else {
                    $icon = 'coupon.php';
                    $iconColor = 'green';
                }
                ?>

                <!-- this separate today's notifcation's from earlier ones -->
                <?php if ($group !== $currentGroup): ?>

                    <?php $currentGroup = $group; ?>

                    <p class="section-title">
                        <?= $group ?>
                    </p>

                <?php endif; ?>


                <div
                    class="notification-item <?= $isUnread ? 'unread' : '' ?>"
                    data-notification-id="<?= (int) $item['id'] ?>"
                    data-is-read="<?= $isUnread ? '0' : '1' ?>">

                    <div class="notification-icon <?= $iconColor ?>">
                        <?php include __DIR__ . '/../../public/assets/icons/' . $icon; ?>
                    </div>

                    <div class="notification-content">

                        <p class="notification-title">
                            <?= htmlspecialchars($item['title']) ?>
                        </p>

                        <p class="notification-text">
                            <?= htmlspecialchars($item['message']) ?>
                        </p>

                        <p class="notification-date">
                            <?= date(
                                'M d, h:i A',
                                strtotime($item['created_at'])
                            ) ?>
                        </p>

                    </div>

                    <?php if ($isUnread): ?>

                        <span class="unread-dot"></span>

                    <?php endif; ?>

                </div>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>
</div>

<script src="/js/notifications.js"></script>
<?php
include __DIR__ . '/../partials/footer.view.php';
?>