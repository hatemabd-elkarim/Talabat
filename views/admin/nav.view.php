<nav class="admin-navbar">

    <div class="admin-navbar-container">

        <!-- Logo -->
        <button class="admin-logo" onclick="navigate('a-dashboard')">
            <span class="admin-logo-mark">
                <span class="admin-logo-dot"></span>
            </span>

            <span class="admin-logo-text">Talabat</span>

            <span class="admin-role-label">Admin panel</span>
        </button>


        <!-- Links — desktop -->
        <div class="admin-nav-links">

            <button
                class="admin-nav-link <?= $activePage === 'a-dashboard' ? 'active' : '' ?>"
                onclick="navigate('a-dashboard')">
                <?php include __DIR__ . '/../../public/assets/icons/layout-dashboard.php' ?>
                Dashboard
            </button>

            <button
                class="admin-nav-link <?= $activePage === 'a-restaurants' ? 'active' : '' ?>"
                onclick="navigate('a-restaurants')">
                <?php include __DIR__ . '/../../public/assets/icons/store.php' ?>
                Restaurants
            </button>

            <button
                class="admin-nav-link <?= $activePage === 'a-coupons' ? 'active' : '' ?>"
                onclick="navigate('a-coupons')">
                <?php include __DIR__ . '/../../public/assets/icons/coupon.php' ?>
                Coupons
            </button>

        </div>


        <!-- User + sign out — desktop -->
        <div class="admin-user-actions">

            <div class="admin-user">
                <div class="admin-avatar">
                    A
                </div>
                <span class="admin-user-name">
                    Talabat
                </span>
            </div>

            <button class="admin-signout-button" onclick="logout()" aria-label="Sign out">
                <?php include __DIR__ . '/../../public/assets/icons/logout.php' ?>
            </button>

        </div>


        <!-- Mobile hamburger -->
        <button class="admin-mobile-menu-button" onclick="toggleAdminMobileMenu()">
            <?php include __DIR__ . '/../../public/assets/icons/menu.php' ?>
        </button>

    </div>


    <!-- Mobile menu -->
    <div class="admin-mobile-menu" id="adminMobileMenu">

        <button
            class="<?= $activePage === 'a-dashboard' ? 'active' : '' ?>"
            onclick="navigate('a-dashboard')">
            Dashboard
        </button>

        <button
            class="<?= $activePage === 'a-restaurants' ? 'active' : '' ?>"
            onclick="navigate('a-restaurants')">
            Restaurants
        </button>

        <button
            class="<?= $activePage === 'a-coupons' ? 'active' : '' ?>"
            onclick="navigate('a-coupons')">
            Coupons
        </button>

        <div class="admin-mobile-divider"></div>

        <div class="admin-mobile-user">
            <div class="admin-avatar">
                Talabat
            </div>
            <div>
                <p class="admin-mobile-user-name">Admin</p>
                <p class="admin-mobile-user-email">admin@talabat.com</p>
            </div>
        </div>

        <button class="admin-sign-out" onclick="logout()">
            Sign out
        </button>

    </div>

</nav>


<script src="/js/admin-nav.js"></script>