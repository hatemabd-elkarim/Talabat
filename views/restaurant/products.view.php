<?php include __DIR__ . '/partials/header.view.php'; ?>

<section aria-label="Restaurant products">

    <section class="products-header">

        <div class="products-heading">
            <h2>Products</h2>

            <p>
                <?= $stats['total_products']; ?>
                items across
                <?= $stats['total_categories']; ?>
                categoriess
            </p>

            <button class="add-product-button" type="button" id="openAddProductModal">
                <?php include __DIR__ . '/../../public/assets/icons/plus.php'; ?>
                <span>Add product</span>
            </button>
        </div>

        <div class="products-search">
            <span class="search-icon" aria-hidden="true"></span>
            <input
                type="search"
                name="search"
                id="search"
                placeholder="Search products...">
        </div>

    </section>


    <section class="products-grid">

        <?php foreach ($products as $product): ?>

            <article class="product-card">

                <div class="product-card-media">
                    <img
                        src="<?= htmlspecialchars($product['image']); ?>"
                        alt="<?= htmlspecialchars($product['name']); ?>"
                        class="product-image">
                </div>

                <div class="product-card-body">

                    <div class="product-card-top">

                        <label class="switch">
                            <input
                                type="checkbox"
                                class="availability-toggle"
                                data-product-id="<?= $product['id']; ?>"
                                <?= $product['is_available'] ? 'checked' : ''; ?>>

                            <span class="slider"></span>
                        </label>

                    </div>

                    <span class="product-category">
                        <?= htmlspecialchars($product['category_name']); ?>
                    </span>


                    <div class="product-info">

                        <h3>
                            <?= htmlspecialchars($product['name']); ?>
                        </h3>

                        <p>
                            <?= htmlspecialchars($product['description']); ?>
                        </p>

                    </div>

                    <div class="product-card-actions">

                        <div class="product-meta">
                            <strong>
                                <?= $product['price']; ?> EGP
                            </strong>

                            <span class="availability-text <?= $product['is_available'] ? 'is-available' : 'is-unavailable'; ?>">
                                <?= $product['is_available'] ? 'Available' : 'Unavailable'; ?>
                            </span>
                        </div>

                        <div class="product-actions">
                            <a href="#" aria-label="Edit <?= htmlspecialchars($product['name']); ?>">
                                <?php include __DIR__ . '/../../public/assets/icons/edit.php'; ?>
                            </a>

                            <a href="#" aria-label="Delete <?= htmlspecialchars($product['name']); ?>">
                                <?php include __DIR__ . '/../../public/assets/icons/trash.php'; ?>
                            </a>
                        </div>

                    </div>

                </div>

            </article>

        <?php endforeach; ?>

    </section>

</section>

<div class="add-product-modal" id="addProductModal" aria-hidden="true">
    <div class="add-product-dialog" role="dialog" aria-modal="true" aria-labelledby="addProductTitle">
        <div class="add-product-header">
            <div>
                <p class="add-product-eyebrow">Products</p>
                <h2 id="addProductTitle">Add product</h2>
            </div>

            <button class="close-product-modal" type="button" id="closeAddProductModal" aria-label="Close add product form">
                &times;
            </button>
        </div>

        <form class="add-product-form" id="addProductForm" novalidate>
            <div class="form-group" id="nameGroup">
                <label for="productName">
                    Product name <span class="required" aria-hidden="true">*</span>
                </label>

                <input
                    type="text"
                    id="productName"
                    name="name"
                    placeholder="e.g. Classic Smash Burger"
                    required>

                <span class="form-error" id="productNameError" role="alert"></span>
            </div>

            <div class="form-group">
                <label for="productDescription">Description</label>
                <textarea
                    id="productDescription"
                    name="description"
                    placeholder="Describe your product..."></textarea>
            </div>

            <div class="form-group" id="priceGroup">
                <label for="productPrice">
                    Price ($) <span class="required" aria-hidden="true">*</span>
                </label>

                <input
                    type="number"
                    id="productPrice"
                    name="price"
                    placeholder="0.00"
                    min="0"
                    step="0.01"
                    required>

                <span class="form-error" id="productPriceError" role="alert"></span>
            </div>

            <div class="form-group">
                <label for="productCategory">Category</label>

                <select id="productCategory" name="category">
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['id']); ?>">
                            <?= htmlspecialchars($category['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="productImage">Image URL</label>
                <input
                    type="url"
                    id="productImage"
                    name="image"
                    placeholder="https://...">
            </div>

            <div class="availability-group">
                <div class="availability-info">
                    <span>Available for ordering</span>
                    <span class="availability-status is-available" id="availabilityStatus">Available</span>
                </div>

                <label class="switch" for="availabilityToggle">
                    <input
                        type="checkbox"
                        id="availabilityToggle"
                        name="is_available"
                        checked>
                    <span class="slider"></span>
                </label>
            </div>

            <div id="addProductMessage" class="form-message" role="status" aria-live="polite"></div>

            <div class="form-actions">
                <button class="form-button cancel-button" type="button" id="cancelAddProduct">Cancel</button>
                <button class="form-button submit-button" type="submit">Add product</button>
            </div>
        </form>
    </div>
</div>

<script src="/js/restaurant/products.js"></script>
<script src="/js/restaurant/add-product.js"></script>

<?php include __DIR__ . '/../partials/footer.view.php'; ?>