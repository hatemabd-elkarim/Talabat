<?php
include __DIR__ . '/../partials/header.view.php';
include __DIR__ . '/nav.view.php';
?>

<link rel="stylesheet" href="/CSS/admin-dashboard.css">

<div class="admin-dashboard">

    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-bg-dots"></div>

        <div class="page-header-content">
            <span class="page-header-icon">
                <?php include __DIR__ . '/../../public/assets/icons/shield-check.php' ?>
            </span>

            <div>
                <h1>Admin dashboard</h1>
                <p>Platform-wide performance overview</p>
            </div>
        </div>
    </div>


    <!-- Stat cards -->
    <div class="stat-grid">

        <div class="stat-card">
            <div class="stat-icon" style="background:var(--color-primary-light,#ffe7da); color:var(--color-primary-dark);">
                <?php include __DIR__ . '/../../public/assets/icons/dollar-sign.php' ?>
            </div>
            <div>
                <p class="stat-label">Total Revenue</p>
                <p class="stat-value">EGP <?= number_format($stats['totalRevenue'], 0) ?></p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background:var(--color-info-bg); color:var(--color-info);">
                <?php include __DIR__ . '/../../public/assets/icons/shopping-bag.php' ?>
            </div>
            <div>
                <p class="stat-label">Total Orders</p>
                <p class="stat-value"><?= number_format($stats['totalOrders']) ?></p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background:var(--color-success-bg); color:var(--color-success);">
                <?php include __DIR__ . '/../../public/assets/icons/store.php' ?>
            </div>
            <div>
                <p class="stat-label">Active Restaurants</p>
                <span class="stat-value"><?= $stats['activeRestaurants'] ?></span>
                <span class="stat-sub">of <?= $stats['totalRestaurants'] ?> total</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background:#f3e8ff; color:#9333ea;">
                <?php include __DIR__ . '/../../public/assets/icons/users.php' ?>
            </div>
            <div>
                <p class="stat-label">Customers</p>
                <p class="stat-value"><?= number_format($stats['totalCustomers']) ?></p>
            </div>
        </div>

    </div>


    <!-- Platform snapshot -->
    <div class="card">
        <div class="card-header">
            <h2>Platform snapshot</h2>
            <p>Across all orders to date</p>
        </div>

        <div class="snapshot-grid">
            <div class="snapshot-item">
                <p class="snapshot-value">$<?= number_format($stats['avgOrderValue'], 2) ?></p>
                <p class="snapshot-label">Average order value</p>
            </div>
            <div class="snapshot-item">
                <p class="snapshot-value"><?= number_format($stats['onlineShare'], 0) ?>%</p>
                <p class="snapshot-label">Paid online (rest is cash on delivery)</p>
            </div>
            <div class="snapshot-item">
                <p class="snapshot-value <?= $stats['cancellationRate'] > 10 ? 'text-error' : '' ?>">
                    <?= number_format($stats['cancellationRate'], 1) ?>%
                </p>
                <p class="snapshot-label">Cancellation rate</p>
            </div>
        </div>
    </div>


    <!-- Top restaurants -->
    <div class="card no-padding">
        <div class="table-header">
            <div>
                <h2>Top Restaurants</h2>
                <p>Ranked by revenue</p>
            </div>
            <button onclick="navigate('a-restaurants')" class="view-all-link">View all</button>
        </div>

        <div class="table-scroll">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Restaurant</th>
                        <th>Cuisine</th>
                        <th>Rating</th>
                        <th class="align-right">Orders</th>
                        <th class="align-right">Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($topRestaurants as $r): ?>
                        <tr>
                            <td>
                                <div class="restaurant-cell">
                                    <img
                                        src="/image_uploads/restaurants/<?= htmlspecialchars($r['image']) ?>"
                                        alt="<?= htmlspecialchars($r['name']) ?>">
                                    <div>
                                        <p class="restaurant-name"><?= htmlspecialchars($r['name']) ?></p>
                                        <span class="restaurant-status <?= $r['is_open'] ? 'open' : 'closed' ?>">
                                            <span class="status-dot"></span>
                                            <?= $r['is_open'] ? 'Open' : 'Closed' ?>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="muted"><?= htmlspecialchars($r['cuisine']) ?></td>
                            <td>
                                <span class="rating-cell">
                                    <?php include __DIR__ . '/../../public/assets/icons/star.php' ?>
                                    <?= number_format($r['rating'], 1) ?>
                                </span>
                            </td>
                            <td class="align-right"><?= $r['orderCount'] ?></td>
                            <td class="align-right bold">$<?= number_format($r['revenue'], 0) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php include __DIR__ . '/../partials/footer.view.php'; ?>