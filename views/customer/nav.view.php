<?php

$currentUser = $_SESSION['user'] ?? null;
?>
<nav class="navbar">

    <div class="navbar-container">

        <button class="logo" onclick="navigate('c-home')">
            <span class="logo-mark">
                <span class="logo-dot"></span>
            </span>

            <span class="logo-text">Talabat</span>
        </button>


        <button class="location" onclick="navigate('c-profile')">
            <span class="location-label">Deliver to</span>

            <?php include '../public/assets/icons/map-pin.php' ?>

            <span class="location-address">
                <?= htmlspecialchars($currentUser['address_text'] ?? 'Set your location') ?>
            </span>

            <?php include '../public/assets/icons/chevron-down.php' ?>
        </button>


        <div class="right-actions">

            <button
                class="icon-button"
                onclick="navigate('c-cart')"
                aria-label="Cart">
                <?php include '../public/assets/icons/shopping-cart.php' ?>

                <span class="badge cart-badge">2</span>
            </button>


            <button
                class="icon-button"
                onclick="navigate('c-notifications')"
                aria-label="Notifications">
                <?php include '../public/assets/icons/bell.php' ?>

                <span class="badge notification-badge">3</span>
            </button>


            <div class="profile-container">

                <button
                    class="profile-button"
                    onclick="toggleProfile()">

                    <div class="avatar">
                        <?php if (!empty($currentUser['name'])): ?>
                            <?= strtoupper(substr($currentUser['name'], 0, 1)) ?>
                        <?php else: ?>
                            U
                        <?php endif; ?>
                    </div>

                    <span class="profile-name">
                        <?= htmlspecialchars($currentUser['name'] ?? 'User') ?>
                    </span>

                </button>


                <div
                    class="profile-dropdown"
                    id="profileDropdown">

                    <button onclick="navigate('c-home')">
                        Home
                    </button>

                    <button onclick="navigate('c-orders')">
                        My Orders
                    </button>

                    <button onclick="navigate('c-notifications')">
                        Notifications
                    </button>

                    <button onclick="navigate('c-profile')">
                        Profile
                    </button>

                    <div class="dropdown-divider"></div>

                    <button
                        class="sign-out"
                        onclick="logout()">
                        Sign out
                    </button>

                </div>

            </div>


            <button
                class="mobile-menu-button"
                onclick="toggleMobileMenu()">
                <?php include '../public/assets/icons/menu.php' ?>
            </button>

        </div>

    </div>


    <div
        class="mobile-menu"
        id="mobileMenu">

        <button onclick="navigate('c-home')">
            Home
        </button>

        <button onclick="navigate('c-orders')">
            My Orders
        </button>

        <button onclick="navigate('c-notifications')">
            Notifications
        </button>

        <button onclick="navigate('c-profile')">
            Profile
        </button>

        <div class="mobile-divider"></div>

        <button
            class="sign-out"
            onclick="logout()">
            Sign out
        </button>

    </div>

</nav>


<script src="/js/customer-nav.js"></script>