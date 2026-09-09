<?php include __DIR__ . '/partials/header.view.php'; ?>

<link rel="stylesheet" href="/CSS/restaurant/profile.css">

<section class="profile-page" aria-label="Restaurant profile">

    <div class="page-header">
        <div>
            <h2>Restaurant Profile</h2>
            <p>Manage your restaurant information</p>
        </div>
        <button class="btn-edit" type="button" id="editButton"><?php include __DIR__ . '/../../public/assets/icons/edit.php'; ?>Edit</button>
    </div>

    <div class="cover-card">
        <img src="/image_uploads/<?= htmlspecialchars($restaurant['banner'] ?? '') ?>" alt="Cover" class="cover-img">
        <div class="cover-overlay">
            <img src="/image_uploads/<?= htmlspecialchars($restaurant['logo'] ?? '') ?>" alt="Logo" class="cover-logo">
            <div>
                <strong><?= htmlspecialchars($restaurant['name']) ?></strong>
                <span><?= htmlspecialchars($restaurant['cuisine'] ?? '') ?></span>
            </div>
        </div>
    </div>

    <div class="status-card">
        <div>
            <strong>Restaurant Status</strong>
            <p id="statusText"><?= $restaurant['is_open'] ? 'Currently accepting orders' : 'Currently closed' ?></p>
        </div>
        <label class="switch">
            <input type="checkbox" id="statusToggle" <?= $restaurant['is_open'] ? 'checked' : '' ?>>
            <span class="slider"></span>
        </label>
    </div>

    <div id="profileMessage" class="form-message" role="status" aria-live="polite"></div>

    <div class="info-card">
        <h4>Basic Information</h4>

        <div class="form-group">
            <label>Restaurant name</label>
            <input type="text" id="nameValue" value="<?= htmlspecialchars($restaurant['name']) ?>" readonly>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea id="descriptionValue" readonly><?= htmlspecialchars($restaurant['description'] ?? '') ?></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Phone</label>
                <input type="text" id="phoneValue" value="<?= htmlspecialchars($restaurant['phone'] ?? '') ?>" readonly>
            </div>
            <div class="form-group">
                <label>Address</label>
                <input type="text" id="addressValue" value="<?= htmlspecialchars($restaurant['address'] ?? '') ?>" readonly>
            </div>
        </div>
    </div>

    <div class="info-card">
        <h4 class="delivery-title">⏱ Delivery Settings</h4>
        <div class="form-row form-row-3">
            <div class="form-group">
                <label>Delivery time (min)</label>
                <input type="number" id="deliveryTimeValue" value="<?= (int) $restaurant['delivery_time'] ?>" readonly>
            </div>
            <div class="form-group">
                <label>Delivery fee ($)</label>
                <input type="number" step="0.01" id="deliveryFeeValue" value="<?= htmlspecialchars($restaurant['delivery_fee']) ?>" readonly>
            </div>
            <div class="form-group">
                <label>Min order ($)</label>
                <input type="number" id="minOrderValue" value="<?= (int) $restaurant['min_order'] ?>" readonly>
            </div>
        </div>
    </div>

    <form action="/logout" method="POST">
        <button type="submit" class="sign-out-button">Sign out</button>
    </form>

</section>

<script src="/js/restaurant/profile.js"></script>

<?php include __DIR__ . '/../partials/footer.view.php'; ?>