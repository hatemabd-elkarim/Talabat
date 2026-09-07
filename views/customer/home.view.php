<?php
include __DIR__ . '/../partials/header.view.php';
include __DIR__ . '/nav.view.php';
?>
<link rel="stylesheet" href="/CSS/customer-home.css">
<main class="customer-home">
    <section class="customer-hero">

        <div class="delivery-location">

            <?php include '../public/assets/icons/map-pin.php' ?>

            <span class="delivery-location-label">Deliver to</span>

            <span class="delivery-location-address">
                <?= htmlspecialchars($currentUser['address_text'] ?? 'Set your location') ?>
            </span>
        </div>
        <div class="restaurant-status">
            &#128293; <?= htmlspecialchars((string) $openRestaurantCount) ?> restaurants open
        </div>
        <div class="customer-hero-content">
            <h1 class="customer-hero-title">
                What are you craving today?
            </h1>

            <div class="restaurant-search">
                <input class="restaurant-search-input" type="search" name="search" id="search" placeholder="Search restaurants or cuisines...">
            </div>
        </div>
    </section>

    <section class="food-categories" aria-labelledby="categories-title">
        <h2 id="categories-title">Browse categories</h2>
        <div class="category-list">
            <?php
            $categories = [
                ['name' => 'Burgers', 'image' => '/assets/images/categories/burger.jpg'],
                ['name' => 'Pizza', 'image' => '/assets/images/categories/pizza.jpg'],
                ['name' => 'Sushi', 'image' => '/assets/images/categories/sushi.jpg'],
                ['name' => 'Healthy', 'image' => '/assets/images/categories/healthy.jpg'],
                ['name' => 'Indian', 'image' => '/assets/images/categories/indian.jpg'],
                ['name' => 'Mexican', 'image' => '/assets/images/categories/mexican.jpg'],
                ['name' => 'Pasta', 'image' => '/assets/images/categories/pasta.jpg'],
                ['name' => 'Desserts', 'image' => '/assets/images/categories/dessert.jpg'],
            ];
            foreach ($categories as $category):
            ?>
                <article class="category-card">
                    <img
                        class="category-image"
                        src="<?= htmlspecialchars($category['image']) ?>"
                        alt="<?= htmlspecialchars($category['name']) ?> category"
                        loading="lazy">
                    <span class="category-name"><?= htmlspecialchars($category['name']) ?></span>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="recommended-section" aria-labelledby="recommended-title">
        <div class="recommended-heading">
            <span class="recommended-icon" aria-hidden="true">&#128293;</span>
            <h2 id="recommended-title">Recommended for you</h2>
        </div>

        <?php if ($featuredProduct !== null): ?>
            <article
                class="featured-product"
                data-product-id="<?= htmlspecialchars((string) $featuredProduct['id']) ?>">
                <div class="featured-product-content">
                    <span class="featured-product-label">Today's special</span>
                    <h3><?= htmlspecialchars($featuredProduct['name']) ?></h3>
                    <p class="featured-product-description">
                        <?= htmlspecialchars($featuredProduct['category']) ?> from <?= htmlspecialchars($featuredProduct['restaurant']) ?>
                    </p>
                    <div class="featured-product-footer">
                        <strong class="featured-product-price">
                            <?= htmlspecialchars((string) $featuredProduct['price']) ?> EGP
                        </strong>
                        <button
                            type="button"
                            class="featured-product-action"
                            onclick="window.location.href='/product?id=<?= htmlspecialchars((string) $featuredProduct['id']) ?>'">
                            Order now
                        </button>
                    </div>
                </div>

                <div class="featured-product-media">
                    <img
                        class="featured-product-image"
                        src="/image_uploads/<?= htmlspecialchars($featuredProduct['image']) ?>"
                        alt="<?= htmlspecialchars($featuredProduct['name']) ?>"
                        loading="lazy">
                </div>
            </article>
        <?php else: ?>
            <p class="empty-state">No recommended products available.</p>
        <?php endif; ?>
    </section>

    <section class="restaurant-section" aria-labelledby="near-restaurants-title">
        <div class="section-heading">
            <h2 id="near-restaurants-title">Restaurants near you</h2>
        </div>

        <div class="restaurant-grid">
            <?php if ($nearRestaurants): ?>
                <?php foreach ($nearRestaurants as $restaurant): ?>
                    <article class="restaurant-card"
                        data-search="<?= htmlspecialchars(strtolower($restaurant['name'] . ' ' . $restaurant['cuisine'])) ?>"
                        onclick="window.location.href='/customer/restaurant-details?id=<?= htmlspecialchars((string) $restaurant['id']) ?>'">

                        <div class="restaurant-card-image">

                            <img
                                src="/image_uploads/<?= htmlspecialchars($restaurant['image']) ?>"
                                alt="<?= htmlspecialchars($restaurant['name']) ?>"
                                loading="lazy">

                            <div class="restaurant-card-overlay">
                                <h3><?= htmlspecialchars($restaurant['name']) ?></h3>
                                <p><?= htmlspecialchars($restaurant['cuisine']) ?></p>
                            </div>

                            <span class="restaurant-rating">
                                <?php include '../public/assets/icons/star.php' ?>
                                <?= htmlspecialchars((string) $restaurant['rating']) ?>
                            </span>

                        </div>

                        <div class="restaurant-card-content">

                            <div class="restaurant-card-meta">

                                <span>
                                    <?php include '../public/assets/icons/time.php' ?>
                                    <?= htmlspecialchars($restaurant['delivery_time']) ?> min
                                </span>

                                <span>
                                    <?php include '../public/assets/icons/map-pin.php' ?>
                                    <?= htmlspecialchars($restaurant['distance']) ?> KM
                                </span>

                                <span>
                                    <?= htmlspecialchars((string) $restaurant['delivery_fee']) ?> EGP
                                </span>

                            </div>

                        </div>

                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="empty-state">Please set up your location.</p>
            <?php endif; ?>
        </div>
    </section>

    <section class="restaurant-section" aria-labelledby="top-rated-title">

        <h2 id="top-rated-title">Top rated restaurants</h2>

        <div class="restaurant-grid">
            <?php if ($topRatedRestaurants): ?>
                <?php foreach ($topRatedRestaurants as $restaurant): ?>
                    <article class="restaurant-card"
                        data-search="<?= htmlspecialchars(strtolower($restaurant['name'] . ' ' . $restaurant['cuisine'])) ?>"
                        onclick="window.location.href='/customer/restaurant-details?id=<?= htmlspecialchars((string) $restaurant['id']) ?>'">

                        <div class="restaurant-card-image">

                            <img
                                src="/image_uploads/<?= htmlspecialchars($restaurant['image']) ?>"
                                alt="<?= htmlspecialchars($restaurant['name']) ?>"
                                loading="lazy">

                            <div class="restaurant-card-overlay">
                                <h3><?= htmlspecialchars($restaurant['name']) ?></h3>
                                <p><?= htmlspecialchars($restaurant['cuisine']) ?></p>
                            </div>

                            <span class="restaurant-rating">
                                <?php include '../public/assets/icons/star.php' ?>
                                <?= htmlspecialchars((string) $restaurant['rating']) ?>
                            </span>

                        </div>

                        <div class="restaurant-card-content">

                            <div class="restaurant-card-meta">

                                <span>
                                    <?php include '../public/assets/icons/time.php' ?>
                                    <?= htmlspecialchars($restaurant['delivery_time']) ?> min
                                </span>

                                <span>
                                    <?php include '../public/assets/icons/map-pin.php' ?>
                                    <?= htmlspecialchars($restaurant['distance']) ?> KM
                                </span>

                                <span>
                                    <?= htmlspecialchars((string) $restaurant['delivery_fee']) ?> EGP
                                </span>

                            </div>

                        </div>

                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="empty-state">Please set up your location.</p>
            <?php endif; ?>
        </div>
    </section>

</main>

<script src="/js/location.js"></script>
<script src="/js/search.js"></script>

<?php
include __DIR__ . '/../partials/footer.view.php';
?>