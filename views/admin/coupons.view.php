<?php
include __DIR__ . '/../partials/header.view.php';
include __DIR__ . '/nav.view.php';
?>

<link rel="stylesheet" href="/CSS/admin-coupons.css">

<div class="admin-coupons">

    <!-- Section header -->
    <div class="section-header">
        <div>
            <h1>Coupons</h1>
            <p><?= count($coupons) ?> promo codes, <?= $activeCount ?> active</p>
        </div>

        <button class="btn-primary" onclick="openCouponModal()">
            <?php include __DIR__ . '/../../public/assets/icons/plus.php' ?>
            Add coupon
        </button>
    </div>


    <!-- Search -->
    <div class="search-bar">
        <?php include __DIR__ . '/../../public/assets/icons/coupon.php' ?>
        <input
            type="text"
            id="couponSearch"
            placeholder="Search coupon codes..."
            oninput="filterCoupons(this.value)">
    </div>


    <!-- Grid -->
    <div class="coupon-grid" id="couponGrid">

        <?php foreach ($coupons as $c):
            $expired = strtotime($c['expires_at']) < strtotime('today');
            $statusClass = $expired ? 'badge-expired' : ($c['is_active'] ? 'badge-active' : 'badge-inactive');
            $statusLabel = $expired ? 'Expired' : ($c['is_active'] ? 'Active' : 'Inactive');

            $valueDisplay = (int) $c['discount_percent'] . '% off';

            $usagePercent = $c['usage_limit'] > 0
                ? min(($c['usage_count'] / $c['usage_limit']) * 100, 100)
                : 0;
        ?>
            <div class="coupon-card"
                data-id="<?= $c['id'] ?>"
                data-search="<?= strtolower(htmlspecialchars($c['code'])) ?>"
                data-expires="<?= htmlspecialchars($c['expires_at']) ?>">

                <div class="coupon-top">
                    <div class="coupon-top-left">
                        <span class="coupon-code"><?= htmlspecialchars($c['code']) ?></span>
                        <span class="badge <?= $statusClass ?>" data-status-badge><?= $statusLabel ?></span>
                    </div>

                    <div class="coupon-icon-actions">
                        <button class="icon-btn icon-btn-edit" onclick='openCouponModal(<?= htmlspecialchars(json_encode($c), ENT_QUOTES, "UTF-8") ?>)'>
                            <?php include __DIR__ . '/../../public/assets/icons/edit.php' ?>
                        </button>
                        <button class="icon-btn icon-btn-delete" onclick="openDeleteModal('<?= $c['id'] ?>', '<?= htmlspecialchars($c['code']) ?>')">
                            <?php include __DIR__ . '/../../public/assets/icons/trash.php' ?>
                        </button>
                    </div>
                </div>

                <div class="coupon-details">
                    <div class="detail-label">Discount</div>
                    <div class="detail-value" data-field="value_display"><?= $valueDisplay ?></div>

                    <div class="detail-label">Min order</div>
                    <div class="detail-value">EGP <?= number_format($c['min_order'], 2) ?></div>

                    <div class="detail-label">Max discount</div>
                    <div class="detail-value">EGP <?= number_format($c['max_discount'], 2) ?></div>

                    <div class="detail-label">Usage</div>
                    <div class="detail-value"><?= $c['usage_count'] ?>/<?= $c['usage_limit'] ?></div>

                    <div class="detail-label">Expires</div>
                    <div class="detail-value <?= $expired ? 'text-error' : '' ?>" data-field="expires"><?= htmlspecialchars($c['expires_at']) ?></div>
                </div>

                <div class="usage-bar">
                    <div class="usage-bar-fill" style="width:<?= $usagePercent ?>%"></div>
                </div>

                <label class="toggle-switch">
                    <input
                        type="checkbox"
                        <?= $c['is_active'] ? 'checked' : '' ?>
                        onchange="toggleCouponActive(this, '<?= $c['id'] ?>')">
                    <span class="toggle-slider"></span>
                    <span class="toggle-label" data-toggle-label><?= $c['is_active'] ? 'Active' : 'Inactive' ?></span>
                </label>

            </div>
        <?php endforeach; ?>

    </div>


    <!-- Empty state -->
    <div class="empty-state" id="couponsEmptyState" style="display:none;">
        <div class="empty-icon">
            <?php include __DIR__ . '/../../public/assets/icons/coupon.php' ?>
        </div>
        <h3>No coupons</h3>
        <p>Create your first promo code to attract customers.</p>
        <button class="btn-primary" onclick="openCouponModal()">Add coupon</button>
    </div>

</div>


<!-- Add / Edit modal -->
<div class="modal-overlay" id="couponModalOverlay">
    <div class="modal">

        <div class="modal-header">
            <h2 id="couponModalTitle">Create coupon</h2>
            <button class="modal-close" onclick="closeCouponModal()">
                <?php include __DIR__ . '/../../public/assets/icons/x.php' ?>
            </button>
        </div>

        <form id="couponForm" onsubmit="return saveCoupon(event)">
            <input type="hidden" id="couponId" value="">

            <div class="form-row two-col">
                <div class="field">
                    <label>Coupon code *</label>
                    <input type="text" id="fieldCode" placeholder="SAVE20" style="text-transform:uppercase" required>
                </div>
            </div>

            <div class="form-row two-col" id="valueRow">
                <div class="field">
                    <label id="fieldValueLabel">Discount (%)</label>
                    <input type="number" min="0" step="5" id="fieldDiscountPercent" placeholder="20">
                </div>
                <div class="field">
                    <label>Max discount (EGP)</label>
                    <input type="number" min="0" step="5" id="fieldMaxDiscount" placeholder="10">
                </div>
            </div>

            <div class="form-row two-col">
                <div class="field">
                    <label>Min order (EGP)</label>
                    <input type="number" min="0" step="5" id="fieldMinOrder" placeholder="15">
                </div>
                <div class="field">
                    <label>Usage limit</label>
                    <input type="number" min="0" step="5" id="fieldUsageLimit" placeholder="500">
                </div>
            </div>

            <div class="field">
                <label>Expiry date</label>
                <input type="date" id="fieldExpiresAt">
            </div>

            <label class="toggle-switch">
                <input type="checkbox" id="fieldIsActive" checked>
                <span class="toggle-slider"></span>
                <span class="toggle-label">Active</span>
            </label>

            <div class="modal-footer">
                <button type="button" class="btn-outline" onclick="closeCouponModal()">Cancel</button>
                <button type="submit" class="btn-primary" id="couponSubmitBtn">Create</button>
            </div>
        </form>

    </div>
</div>


<!-- Delete confirm modal -->
<div class="modal-overlay" id="deleteModalOverlay">
    <div class="modal modal-sm">
        <h2 class="confirm-title">Delete coupon?</h2>
        <p class="confirm-message">
            The code <strong id="deleteCouponCode"></strong> will be permanently removed.
        </p>
        <div class="modal-footer">
            <button type="button" class="btn-outline" onclick="closeDeleteModal()">Cancel</button>
            <button type="button" class="btn-danger" onclick="confirmDeleteCoupon()">Delete</button>
        </div>
    </div>
</div>


<!-- Toast host -->
<div class="toast-stack" id="toastStack"></div>


<script src="/js/admin-coupons.js"></script>

<?php include __DIR__ . '/../partials/footer.view.php'; ?>