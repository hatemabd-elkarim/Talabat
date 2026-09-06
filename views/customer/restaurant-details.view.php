<?php
include __DIR__ . '/../partials/header.view.php';
include __DIR__ . '/nav.view.php';
?>
<link rel="stylesheet" href="/CSS/restaurant-details.css">
<main class="restaurant-page">

    <!-- Hero -->

    <section
        class="restaurant-hero"
        style="background-image: url('<?= htmlspecialchars($restaurant['cover_image']) ?>')">

        <div class="hero-overlay"></div>

        <a href="/customer/home" class="back-button">
            <?php include '../public/assets/icons/arrow-left.php' ?>
        </a>

        <div class="restaurant-hero-content">

            <div class="restaurant-badges">

                <?php if ($restaurant['is_open']): ?>

                    <span class="status open">
                        Open now
                    </span>

                <?php else: ?>

                    <span class="status closed">
                        Closed
                    </span>

                <?php endif; ?>

                <span class="cuisine">
                    <?= htmlspecialchars($restaurant['cuisine']) ?>
                </span>

            </div>

            <h1>
                <?= htmlspecialchars($restaurant['name']) ?>
            </h1>

        </div>

    </section>


    <!-- Restaurant Stats -->

    <section class="restaurant-stats">

        <div class="stats-container">

            <div class="stat">

                <span class="star"><?php include "../public/assets/icons/star.php"; ?></span>

                <strong>
                    <?= $restaurant['rating'] ?>
                </strong>

                <span>
                    (<?= $restaurant['review_count'] ?> reviews)
                </span>

            </div>


            <div class="stat">

                <span><?php include "../public/assets/icons/time.php"; ?></span>

                <span>
                    <?= $restaurant['delivery_time'] ?>
                    –
                    <?= $restaurant['delivery_time'] + 5 ?>
                    min
                </span>

            </div>


            <div class="stat">

                <?php include "../public/assets/icons/map-pin.php"; ?>

                <span>
                    <?= $restaurant['distance'] ?> km away
                </span>

            </div>


            <div class="stat">

                <?php include "../public/assets/icons/shopping-cart.php"; ?>

                <span>
                    <?= $restaurant['delivery_fee'] ?> EGP delivery
                </span>

            </div>


            <div class="stat">

                Min order:
                <?= $restaurant['min_order'] ?> EGP

            </div>

        </div>

    </section>


    <!-- Tabs -->

    <section class="restaurant-tabs">

        <div class="tabs-container">

            <button class="tab active" data-tab="menu">
                Menu
            </button>

            <button class="tab" data-tab="info">
                Info
            </button>

            <button class="tab" data-tab="reviews">
                Reviews
            </button>

        </div>

    </section>


    <div class="restaurant-content">


        <!-- MENU -->

        <section class="tab-content active" id="menu">

            <div class="menu-layout">


                <!-- Categories -->

                <aside class="categories">

                    <?php foreach ($categories as $index => $category): ?>

                        <button
                            class="category <?= $index === 0 ? 'active' : '' ?>"
                            data-category="<?= $category['id'] ?>">

                            <?= htmlspecialchars($category['name']) ?>

                        </button>

                    <?php endforeach; ?>

                </aside>


                <!-- Products -->

                <div class="products">

                    <?php foreach ($products as $product): ?>

                        <article
                            class="product-card <?= !$product['is_available'] ? 'unavailable-card' : '' ?>"
                            data-category="<?= $product['category_id'] ?>">

                            <?php if (!$product['is_available']): ?>

                                <span class="unavailable-badge">
                                    Unavailable
                                </span>

                            <?php endif; ?>

                            <img
                                src="<?= htmlspecialchars($product['image']) ?>"
                                alt="<?= htmlspecialchars($product['name']) ?>"
                                class="product-image">


                            <div class="product-content">

                                <h3>
                                    <?= htmlspecialchars($product['name']) ?>
                                </h3>

                                <p>
                                    <?= htmlspecialchars($product['description']) ?>
                                </p>


                                <div class="product-bottom">

                                    <strong class="product-price">

                                        <?= number_format($product['price'], 2) ?>
                                        EGP

                                    </strong>


                                    <?php if ($product['is_available']): ?>

                                        <button
                                            class="add-product"
                                            data-product-id="<?= $product['id'] ?>">
                                            +
                                        </button>

                                    <?php endif; ?>

                                </div>

                            </div>

                        </article>

                    <?php endforeach; ?>

                </div>

            </div>

        </section>


        <!-- INFO -->

        <section class="tab-content" id="info">

            <div class="info-card">

                <div class="info-about">

                    <h2>About</h2>

                    <p>
                        <?= htmlspecialchars($restaurant['description']) ?>
                    </p>

                </div>


                <div class="info-divider"></div>


                <div class="info-details">

                    <div class="info-row">

                        <?php include '../public/assets/icons/map-pin.php' ?>

                        <span>
                            <?= htmlspecialchars($restaurant['address']) ?>
                        </span>

                    </div>


                    <div class="info-row">

                        <?php include '../public/assets/icons/phone.php' ?>

                        <span>
                            <?= htmlspecialchars($restaurant['phone']) ?>
                        </span>

                    </div>


                    <div class="info-row">

                        <?php include '../public/assets/icons/time.php' ?>

                        <span>

                            Status:

                            <?php if ($restaurant['is_open']): ?>

                                <strong class="open-text">
                                    Open now
                                </strong>

                            <?php else: ?>

                                <strong class="closed-text">
                                    Closed
                                </strong>

                            <?php endif; ?>

                        </span>

                    </div>

                </div>


                <div class="info-divider"></div>


                <div class="info-stats">

                    <div class="info-stat">

                        <strong>
                            <?= $restaurant['delivery_time'] ?>
                        </strong>

                        <span>Delivery time</span>

                    </div>


                    <div class="info-stat">

                        <strong>
                            <?= $restaurant['delivery_fee'] ?> EGP
                        </strong>

                        <span>Delivery fee</span>

                    </div>


                    <div class="info-stat">

                        <strong>
                            <?= $restaurant['rating'] ?>
                        </strong>

                        <span>Rating</span>

                    </div>

                </div>

            </div>

        </section>


        <!-- REVIEWS -->

        <section class="tab-content" id="reviews">

            <div class="reviews-header">

                <div class="reviews-summary">

                    <strong class="reviews-avg">
                        <?= $restaurant['rating'] ?>
                    </strong>

                    <div>
                        <div class="reviews-stars">
                            <?= str_repeat('★', round($restaurant['rating'])) ?>
                            <?= str_repeat('☆', 5 - round($restaurant['rating'])) ?>
                        </div>

                        <span class="reviews-count-text">
                            Based on <?= $restaurant['review_count'] ?> reviews
                        </span>
                    </div>

                </div>

                <button class="write-review-btn" id="openReviewModal">
                    Write a Review
                </button>

            </div>

            <div class="reviews-container" id="reviewsList">

                <?php if (empty($reviews)): ?>

                    <div class="empty-state">

                        <h3>No reviews yet</h3>

                        <p>
                            Be the first to leave a review!
                        </p>

                    </div>

                <?php else: ?>

                    <?php foreach ($reviews as $review): ?>

                        <article class="review-card">

                            <div class="review-header">

                                <div class="review-avatar">

                                    <?= strtoupper($review['customer_name'][0]) ?>

                                </div>


                                <div>

                                    <strong>

                                        <?= htmlspecialchars($review['customer_name']) ?>

                                    </strong>

                                    <p>

                                        <?= htmlspecialchars($review['created_at']) ?>

                                    </p>

                                </div>


                                <div class="review-rating">

                                    <?= str_repeat('★', $review['rating']) ?>
                                </div>

                            </div>


                            <p class="review-comment">

                                <?= htmlspecialchars($review['comment']) ?>

                            </p>

                        </article>

                    <?php endforeach; ?>

                <?php endif; ?>

            </div>

        </section>

    </div>


    <!-- WRITE REVIEW MODAL -->

    <div class="modal-overlay" id="reviewModal">

        <div class="modal">

            <div class="modal-header">

                <h3>Write a Review</h3>

                <button class="modal-close" id="closeReviewModal">
                    ✕
                </button>

            </div>

            <form id="reviewForm" class="modal-body">

                <label class="modal-label">Your Rating</label>

                <div class="star-picker" id="starPicker">
                    <span class="star-input" data-value="1">★</span>
                    <span class="star-input" data-value="2">★</span>
                    <span class="star-input" data-value="3">★</span>
                    <span class="star-input" data-value="4">★</span>
                    <span class="star-input" data-value="5">★</span>
                </div>

                <input type="hidden" name="rating" id="ratingValue" value="0">

                <label class="modal-label" for="reviewComment">Your Comment</label>

                <textarea
                    id="reviewComment"
                    name="comment"
                    rows="4"
                    placeholder="Tell others about your experience..."
                    required></textarea>

                <button type="submit" class="submit-review-btn">
                    Submit Review
                </button>

            </form>

        </div>

    </div>

</main>

<script src="/js/restaurant-details.js"></script>

<?php include __DIR__ . '/../partials/footer.view.php'; ?>