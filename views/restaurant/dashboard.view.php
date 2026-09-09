<?php include __DIR__ . '/partials/header.view.php'; ?>

<main class="restaurant-dashboard">

    <section class="dashboard-header">
        <div class="restaurant-icon">
            <?php include __DIR__ . '/../../public/assets/icons/store.php'; ?>
        </div>
        <h2><?= $restaurant['name'] ?></h2>
        <p>Dashboard overview</p>
        <strong>
            <?php if ($restaurant['is_open']): ?>
                <?= 'open' ?>
            <? else: ?>
                <?= 'closed' ?>
            <?php endif ?>
        </strong>
    </section>

    <section class="dashboard-stats">
        <div class="stat-card">
            <span class="stat-title">Today's Revenue</span>
            <h3 class="stat-value">
                <?= $stats['today_sales'] ?> EGP
            </h3>
            <div class="stat-icon revenue-icon">
                <?php include __DIR__ . '/../../public/assets/icons/dollar-sign.php'; ?>
            </div>
        </div>
        <div class="stat-card">
            <span class="stat-title">Total Orders</span>
            <h3 class="stat-value">
                <?= $stats['today_orders'] ?>
            </h3>
            <div class="stat-icon orders-icon">
                <?php include __DIR__ . '/../../public/assets/icons/shopping-bag.php'; ?>
            </div>
        </div>
        <div class="stat-card">
            <span class="stat-title">Pending Orders</span>
            <h3 class="stat-value">
                <?= $stats['pending_orders'] ?>
            </h3>
            <div class="stat-icon pending-icon">
                <?php include __DIR__ . '/../../public/assets/icons/time.php'; ?>
            </div>
            <p class="stat-note">Needs attention</p>
        </div>
        <div class="stat-card">
            <span class="stat-title">Avg. Rating</span>
            <h3 class="stat-value">
                <?= $stats['average_rating'] ?>
            </h3>
            <div class="stat-icon rating-icon">
                <?php include __DIR__ . '/../../public/assets/icons/star.php'; ?>
            </div>
            <p class="stat-note"><?= $restaurant['review_count'] ?> reviews</p>
        </div>
    </section>

    <section class="recent-orders">

        <div class="recent-orders-header">
            <h4>Pending Orders</h4>
            <a href="#">View all</a>
        </div>

        <div class="orders-list">
            <?php foreach (array_slice($pendingOrders, 0, 3) as $order): ?>
                <div class="order-row">
                    <div class="order-info">
                        <strong>
                            <?= htmlspecialchars($order['customer_name']) ?>
                        </strong>
                        <span>
                            #ORD-<?= htmlspecialchars($order['id']) ?>
                            <b>•</b>
                            <?= htmlspecialchars($order['items']) ?>
                        </span>
                    </div>
                    <div class="order-status">
                        <span class="status-badge status-<?= strtolower($order['status']) ?>">
                            <i></i>
                            <?= ucfirst(htmlspecialchars($order['status'])) ?>
                        </span>
                        <strong>
                            <?= number_format($order['total_price'], 2) ?> EGP
                        </strong>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

</main>
<script>
    const today = new Date().toLocaleDateString();
    const elements = document.querySelectorAll('.stat-card:nth-child(-n+2)');
    elements.forEach((element) => {
        element.style.setProperty('--today-date', `"${today}"`);
    });
</script>
<?php include __DIR__ . '/../partials/footer.view.php'; ?>