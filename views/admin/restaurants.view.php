<?php
include __DIR__ . '/../partials/header.view.php';
include __DIR__ . '/nav.view.php';
?>

<link rel="stylesheet" href="/CSS/admin-restaurants.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<div class="admin-restaurants">

    <!-- Section header -->
    <div class="section-header">
        <div>
            <h1>Restaurants</h1>
            <p><?= count($restaurants) ?> restaurants, <?= $enabledCount ?> enabled</p>
        </div>

        <button class="btn-primary" onclick="openRestaurantModal()">
            <?php include __DIR__ . '/../../public/assets/icons/plus.php' ?>
            Add restaurant
        </button>
    </div>


    <!-- Search -->
    <div class="search-bar">
        <?php include __DIR__ . '/../../public/assets/icons/store.php' ?>
        <input
            type="text"
            id="restaurantSearch"
            placeholder="Search by name or cuisine..."
            oninput="filterRestaurants(this.value)">
    </div>


    <!-- Grid -->
    <div class="restaurant-grid" id="restaurantGrid">

        <?php foreach ($restaurants as $r): ?>
            <div class="restaurant-card"
                data-id="<?= $r['id'] ?>"
                data-search="<?= strtolower(htmlspecialchars($r['name'] . ' ' . $r['cuisine'])) ?>">

                <div class="restaurant-cover" style="background-image:url('/image_uploads/restaurants/<?= htmlspecialchars($r['image']) ?>')">
                    <div class="restaurant-cover-scrim"></div>

                    <div class="restaurant-cover-identity">
                        <img class="restaurant-logo" src="/image_uploads/restaurants/<?= htmlspecialchars($r['image']) ?>"
                            alt="<?= htmlspecialchars($r['name']) ?>">
                        <div>
                            <p class="restaurant-card-name"><?= htmlspecialchars($r['name']) ?></p>
                            <p class="restaurant-card-cuisine"><?= htmlspecialchars($r['cuisine']) ?></p>
                        </div>
                    </div>

                    <div class="restaurant-cover-badges">
                        <span class="badge <?= $r['is_open'] ? 'badge-open' : 'badge-closed' ?>">
                            <?= $r['is_open'] ? 'Open' : 'Closed' ?>
                        </span>
                        <span class="badge <?= $r['is_enabled'] ? 'badge-enabled' : 'badge-disabled' ?>" data-enabled-badge>
                            <?= $r['is_enabled'] ? 'Enabled' : 'Disabled' ?>
                        </span>
                    </div>
                </div>

                <div class="restaurant-body">

                    <div class="restaurant-meta">
                        <span>
                            <?php include __DIR__ . '/../../public/assets/icons/star.php' ?>
                            <?= number_format($r['rating'], 1) ?> (<?= $r['review_count'] ?>)
                        </span>
                        <span class="restaurant-email">
                            <?php include __DIR__ . '/../../public/assets/icons/mail.php' ?>
                            <?= htmlspecialchars($r['email']) ?>
                        </span>
                    </div>

                    <div class="restaurant-actions">
                        <label class="toggle-switch">
                            <input
                                type="checkbox"
                                <?= $r['is_enabled'] ? 'checked' : '' ?>
                                onchange="toggleRestaurantEnabled(this, '<?= $r['id'] ?>')">
                            <span class="toggle-slider"></span>
                            <span class="toggle-label" data-toggle-label>
                                <?= $r['is_enabled'] ? 'Enabled' : 'Disabled' ?>
                            </span>
                        </label>

                        <!-- <button class="btn-outline btn-sm" onclick='openRestaurantModal(<?= htmlspecialchars(json_encode($r), ENT_QUOTES, "UTF-8") ?>)'>
                            <?php include __DIR__ . '/../../public/assets/icons/edit.php' ?>
                            Edit
                        </button> -->
                    </div>

                </div>
            </div>
        <?php endforeach; ?>

    </div>


    <!-- Empty state (hidden unless search matches nothing) -->
    <div class="empty-state" id="restaurantsEmptyState" style="display:none;">
        <div class="empty-icon">
            <?php include __DIR__ . '/../../public/assets/icons/store.php' ?>
        </div>
        <h3>No restaurants</h3>
        <p>No restaurants match your search.</p>
    </div>

</div>


<!-- Add / Edit modal -->
<div class="modal-overlay" id="restaurantModalOverlay">
    <div class="modal">

        <div class="modal-header">
            <h2 id="restaurantModalTitle">Add restaurant</h2>
            <button class="modal-close" onclick="closeRestaurantModal()">
                <?php include __DIR__ . '/../../public/assets/icons/x.php' ?>
            </button>
        </div>

        <form id="restaurantForm" onsubmit="return saveRestaurant(event)">
            <input type="hidden" id="restaurantId" value="">
            <input type="hidden" id="fieldCoverDataUrl" value="">
            <input type="hidden" id="fieldLogoDataUrl" value="">

            <div class="field">
                <label>Cover image (banner)</label>
                <div class="upload-box upload-box-cover" onclick="document.getElementById('fieldCoverFile').click()">
                    <img id="coverPreviewImg" class="upload-preview" style="display:none;" alt="">
                    <div class="upload-placeholder" id="coverPlaceholder">
                        <?php include __DIR__ . '/../../public/assets/icons/image.php' ?>
                        <span>Click to upload cover image</span>
                        <span class="upload-hint">PNG or JPG, recommended 1200×400</span>
                    </div>
                    <div class="upload-overlay">Change image</div>
                </div>
                <input type="file" id="fieldCoverFile" accept="image/*" hidden onchange="previewImage(this, 'coverPreviewImg', 'coverPlaceholder', 'fieldCoverDataUrl')">
            </div>

            <div class="field">
                <label>Logo image</label>
                <div class="upload-row">
                    <div class="upload-box upload-box-logo" onclick="document.getElementById('fieldLogoFile').click()">
                        <img id="logoPreviewImg" class="upload-preview" style="display:none;" alt="">
                        <div class="upload-placeholder upload-placeholder-logo" id="logoPlaceholder">
                            <?php include __DIR__ . '/../../public/assets/icons/image.php' ?>
                        </div>
                        <div class="upload-overlay upload-overlay-logo">Change</div>
                    </div>
                    <p class="upload-row-hint">Square image works best.<br>PNG or JPG, at least 200×200.</p>
                </div>
                <input type="file" id="fieldLogoFile" accept="image/*" hidden onchange="previewImage(this, 'logoPreviewImg', 'logoPlaceholder', 'fieldLogoDataUrl')">
            </div>

            <div class="form-row two-col">
                <div class="field">
                    <label>Restaurant name *</label>
                    <input type="text" id="fieldName" placeholder="e.g. Burger Junction" required>
                </div>
                <div class="field">
                    <label>Cuisine type</label>
                    <input type="text" id="fieldCuisine" placeholder="e.g. American">
                </div>
            </div>

            <div class="field">
                <label>Address</label>
                <div class="input-icon">
                    <?php include __DIR__ . '/../../public/assets/icons/map-pin.php' ?>
                    <input type="text" id="fieldAddress" placeholder="Street, area, city">
                </div>
            </div>

            <div class="form-row two-col">
                <div class="field">
                    <label>Phone</label>
                    <div class="input-icon">
                        <?php include __DIR__ . '/../../public/assets/icons/phone.php' ?>
                        <input type="text" id="fieldPhone" placeholder="+20 100 000 0000">
                    </div>
                </div>
                <div class="field">
                    <label>Email</label>
                    <div class="input-icon">
                        <?php include __DIR__ . '/../../public/assets/icons/mail.php' ?>
                        <input type="email" id="fieldEmail" placeholder="info@restaurant.com">
                    </div>
                </div>
            </div>

            <div class="field">
                <label>Location (click on the map to set the pin)</label>
                <div id="restaurantMap" class="location-map"></div>
            </div>

            <div class="form-row two-col">
                <div class="field">
                    <label>Latitude</label>
                    <input type="number" step="any" id="fieldLat" placeholder="30.0626" readonly>
                </div>
                <div class="field">
                    <label>Longitude</label>
                    <input type="number" step="any" id="fieldLng" placeholder="31.3219" readonly>
                </div>
            </div>

            <label class="toggle-switch">
                <input type="checkbox" id="fieldIsEnabled" checked>
                <span class="toggle-slider"></span>
                <span class="toggle-label">Enable restaurant on platform</span>
            </label>

            <div class="modal-footer">
                <button type="button" class="btn-outline" onclick="closeRestaurantModal()">Cancel</button>
                <button type="submit" class="btn-primary" id="restaurantSubmitBtn">Add restaurant</button>
            </div>
        </form>

    </div>
</div>


<!-- Toast host -->
<div class="toast-stack" id="toastStack"></div>


<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="/js/admin-restaurants.js"></script>

<?php include __DIR__ . '/../partials/footer.view.php'; ?>