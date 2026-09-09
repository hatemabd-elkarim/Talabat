<?php
$restaurant = [
    'name'          => 'BurgerCo',
    'cuisine'       => 'American',
    'cover_image'   => 'https://via.placeholder.com/700x180',
    'logo'          => 'https://via.placeholder.com/50',
    'is_active'     => true,
    'description'   => 'Smash burgers crafted from 100% prime beef, loaded with fresh toppings and our signature sauces. Every patty is pressed to crispy-edged perfection.',
    'phone'         => '+971 4 123 4567',
    'email'         => 'info@burgerco.ae',
    'delivery_time' => 15,
    'delivery_fee'  => 1.99,
    'min_order'     => 10,
];
?>
<?php include __DIR__ . '/partials/header.view.php'; ?>

<link rel="stylesheet" href="/Talabat/public/CSS/restaurant-profile.css">

<section class="profile-page" aria-label="Restaurant profile">

    <div class="page-header">
        <div>
            <h2>Restaurant Profile</h2>
            <p>Manage your restaurant information</p>
        </div>
        <button class="btn-edit">✎ Edit</button>
    </div>

    <div class="cover-card">
        <img src="<?= htmlspecialchars($restaurant['cover_image']) ?>" alt="Cover" class="cover-img">
        <div class="cover-overlay">
            <img src="<?= htmlspecialchars($restaurant['logo']) ?>" alt="Logo" class="cover-logo">
            <div>
                <strong><?= htmlspecialchars($restaurant['name']) ?></strong>
                <span><?= htmlspecialchars($restaurant['cuisine']) ?></span>
            </div>
        </div>
    </div>

    <div class="status-card">
        <div>
            <strong>Restaurant Status</strong>
            <p>Currently accepting orders</p>
        </div>
        <label class="switch">
            <input type="checkbox" <?= $restaurant['is_active'] ? 'checked' : '' ?>>
            <span class="slider"></span>
        </label>
    </div>

    <div class="info-card">
        <h4>Basic Information</h4>

        <div class="form-group">
            <label>Restaurant name</label>
            <input type="text" value="<?= htmlspecialchars($restaurant['name']) ?>">
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea><?= htmlspecialchars($restaurant['description']) ?></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Phone</label>
                <input type="text" value="<?= htmlspecialchars($restaurant['phone']) ?>">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" value="<?= htmlspecialchars($restaurant['email']) ?>">
            </div>
        </div>
    </div>

    <div class="info-card">
        <h4 class="delivery-title">⏱ Delivery Settings</h4>
        <div class="form-row form-row-3">
            <div class="form-group">
                <label>Delivery time (min)</label>
                <input type="number" value="<?= (int) $restaurant['delivery_time'] ?>">
            </div>
            <div class="form-group">
                <label>Delivery fee ($)</label>
                <input type="number" step="0.01" value="<?= htmlspecialchars($restaurant['delivery_fee']) ?>">
            </div>
            <div class="form-group">
                <label>Min order ($)</label>
                <input type="number" value="<?= (int) $restaurant['min_order'] ?>">
            </div>
        </div>
    </div>

</section>

<?php include __DIR__ . '/../partials/footer.view.php'; ?>