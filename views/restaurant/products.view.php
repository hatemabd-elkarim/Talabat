<?php include __DIR__ . '/partials/header.view.php'; ?>

<section aria-label="Restaurant products">

    <section class="products-header">

        <div class="products-heading">
            <h2>Products</h2>

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
                placeholder="Search products and categories...">
        </div>

    </section>


    <section class="products-grid">

        <?php foreach ($products as $product): ?>

            <article class="product-card">

                <div class="product-card-media">
                    <img
                        src="/image_uploads/<?= htmlspecialchars($product['image']); ?>"
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
                        <?= htmlspecialchars($product['category']); ?>
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
                            <a
                                href="#"
                                class="edit-product-button"
                                data-product-id="<?= $product['id']; ?>"
                                data-product-name="<?= htmlspecialchars($product['name']); ?>"
                                data-product-description="<?= htmlspecialchars($product['description'] ?? ''); ?>"
                                data-product-price="<?= htmlspecialchars($product['price']); ?>"
                                data-product-category="<?= htmlspecialchars($product['category'] ?? ''); ?>"
                                data-product-available="<?= $product['is_available']; ?>"
                                data-product-image="/image_uploads/<?= htmlspecialchars($product['image'] ?? ''); ?>"
                                aria-label="Edit <?= htmlspecialchars($product['name']); ?>">
                                <?php include __DIR__ . '/../../public/assets/icons/edit.php'; ?>
                            </a>

                            <a
                                href="#"
                                class="delete-product-button"
                                data-product-id="<?= $product['id']; ?>"
                                aria-label="Delete <?= htmlspecialchars($product['name']); ?>">
                                <?php include __DIR__ . '/../../public/assets/icons/trash.php'; ?>
                            </a>
                        </div>

                    </div>

                </div>

            </article>

        <?php endforeach; ?>

    </section>

</section>

<div class="product-modal" id="productModal" aria-hidden="true">
    <div class="product-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="productModalTitle">
        <div class="product-modal-header">
            <div>
                <p class="product-modal-eyebrow">Products</p>
                <h2 id="productModalTitle">Add product</h2>
            </div>

            <button class="close-product-modal" type="button" id="closeProductModal" aria-label="Close product form">
                &times;
            </button>
        </div>

        <form
            class="product-modal-form"
            id="productForm"
            enctype="multipart/form-data"
            novalidate>

            <input type="hidden" id="productId" name="id" value="">

            <div class="form-group" id="nameGroup">
                <label for="productName">
                    Product name <span class="required" aria-hidden="true">*</span>
                </label>
                <input type="text" id="productName" name="name" placeholder="e.g. Classic Smash Burger" required>
                <span class="form-error" id="productNameError" role="alert"></span>
            </div>

            <div class="form-group">
                <label for="productDescription">Description</label>
                <textarea id="productDescription" name="description" placeholder="Describe your product..."></textarea>
            </div>

            <div class="form-group" id="priceGroup">
                <label for="productPrice">
                    Price ($) <span class="required" aria-hidden="true">*</span>
                </label>
                <input type="number" id="productPrice" name="price" placeholder="0.00" min="0" step="0.01" required>
                <span class="form-error" id="productPriceError" role="alert"></span>
            </div>

            <div class="form-group">
                <label for="productCategory">Category</label>
                <input type="text" id="productCategory" name="category" placeholder="e.g. Pizza">
            </div>

            <div class="form-group">
                <label for="productImage">Product image</label>

                <label class="image-upload" for="productImage">
                    <div class="image-upload-content" id="imageUploadContent">
                        <span class="image-upload-icon">+</span>
                        <span class="image-upload-text">Upload product image</span>
                        <span class="image-upload-hint">PNG, JPG or WEBP</span>
                    </div>

                    <img id="productImagePreview" class="product-image-preview" src="" alt="Product preview">

                    <input type="file" id="productImage" name="image" accept="image/*">
                </label>
            </div>

            <div class="availability-group">
                <div class="availability-info">
                    <span>Available for ordering</span>
                    <span class="availability-status is-available" id="availabilityStatus">Available</span>
                </div>

                <label class="switch" for="availabilityToggle">
                    <input type="checkbox" id="availabilityToggle" name="is_available" checked>
                    <span class="slider"></span>
                </label>
            </div>

            <div id="productFormMessage" class="form-message" role="status" aria-live="polite"></div>

            <div class="form-actions">
                <button class="form-button cancel-button" type="button" id="cancelProductForm">Cancel</button>
                <button class="form-button submit-button" type="submit" id="submitProductButton">Add product</button>
            </div>
        </form>
    </div>
</div>

<script src="/js/restaurant/products.js"></script>
<script src="/js/restaurant/product-modal.js"></script>

<?php include __DIR__ . '/../partials/footer.view.php'; ?>