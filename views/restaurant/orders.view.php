<?php include __DIR__ . '/partials/header.view.php'; ?>

<section aria-label="Restaurant orders">

    <div class="orders-header">

        <div class="orders-heading">
            <h2>Orders</h2>
            <p>Manage incoming and active orders</p>
        </div>

        <div class="orders-search">
            <input type="search" name="search" id="search" placeholder="Search by order # or customer...">
        </div>

    </div>

    <div class="orders-tabs">
        <?php
        $allOrders = count($orders);

        $pendingOrders = count(array_filter($orders, fn($order) => $order['status'] === 'preparing'));

        $activeOrders = count(array_filter($orders, fn($order) => $order['status'] === 'accepted'));

        $completedOrders = count(array_filter($orders, fn($order) => $order['status'] === 'delivered'));
        ?>
        <button class="orders-tab active" data-status="all">All <?= $allOrders ?></button>
        <button class="orders-tab" data-status="pending">Pending <?= $pendingOrders ?></button>
        <button class="orders-tab" data-status="active">Active <?= $activeOrders ?></button>
        <button class="orders-tab" data-status="completed">Completed <?= $completedOrders ?></button>
    </div>

    <?php foreach ($orders as $order): ?>
        <div class="orders-content" data-order-status="<?= $order['status'] ?>">

            <div class="order-info">
                <h3>#ORD<?= $order['id'] ?></h3>
                <p><?= $order['status'] ?></p>
                <p><?= $order['created_at'] ?></p>
            </div>

            <div class="order-customer">
                <p><?= $order['customer_name'] ?></p>
                <p><?= implode(', ', $order['items']) ?></p>
            </div>

            <div class="order-payment">
                <h3><?= $order['total'] ?>EGP</h3>
                <h3><?= $order['payment_method'] ?></h3>
            </div>

            <div class="order-actions"></div>

        </div>
    <?php endforeach; ?>

</section>

<script src="/js/restaurant/orders.js"></script>

<?php include __DIR__ . '/../partials/footer.view.php'; ?>