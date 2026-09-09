<?php

use Core\Session;
use Models\Restaurant;

$userId = (int) Session::get('user')['id'];
$restaurant = Restaurant::findByOwnerId($userId);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Talabat Restaurant' ?></title>
    <link rel="stylesheet" href="/CSS/style.css">
</head>

<body>

    <nav class="navbar restaurant-navbar">
        <div class="navbar-container">
            <a class="logo" href="/restaurant/dashboard" aria-label="Restaurant dashboard">
                <span class="logo-mark">
                    <span class="logo-dot"></span>
                </span>
                <span class="logo-text">Talabat</span>
            </a>
            <a class="location restaurant-context" href="/restaurant/dashboard">
                <span class="location-label">Restaurant</span>
                <span class="location-address">Dashboard</span>
            </a>
            <nav class="restaurant-navigation" aria-label="Restaurant navigation">

                <a href="/restaurant/dashboard" class="<?= ($_SERVER['REQUEST_URI'] ?? '') === '/restaurant/dashboard' ? 'active' : '' ?>">
                    Dashboard
                </a>

                <a href="/restaurant/products" class="<?= ($_SERVER['REQUEST_URI'] ?? '') === '/restaurant/products' ? 'active' : '' ?>">
                    Products
                </a>

                <a href="/restaurant/orders" class="<?= ($_SERVER['REQUEST_URI'] ?? '') === '/restaurant/orders' ? 'active' : '' ?>">
                    Orders
                </a>

                <a href="/restaurant/profile" class="<?= ($_SERVER['REQUEST_URI'] ?? '') === '/restaurant/profile' ? 'active' : '' ?>">
                    Profile
                </a>

            </nav>

            <div class="right-actions">
                <div class="profile-container">
                    <button class="profile-button" type="button" onclick="toggleProfile()" aria-label="Open restaurant profile menu">
                        <span class="avatar"><?= strtoupper(
                                                    substr($restaurant['name'], 0, 1) .
                                                        (isset(explode(' ', trim($restaurant['name']))[1])
                                                            ? substr(explode(' ', trim($restaurant['name']))[1], 0, 1)
                                                            : '')
                                                ) ?></span>
                        <span class="profile-name"><?= $restaurant['name'] ?></span>
                    </button>

                    <div class="profile-dropdown" id="profileDropdown">
                        <a href="/restaurant/dashboard">Dashboard</a>
                        <a href="/restaurant/products">Products</a>
                        <a href="/restaurant/orders">Orders</a>
                        <a href="/restaurant/profile">Profile</a>
                        <div class="dropdown-divider"></div>
                        <form action="/logout" method="POST">
                            <button type="submit" class="sign-out">Sign out</button>
                        </form>
                    </div>

                </div>

                <button class="mobile-menu-button" type="button" onclick="toggleMobileMenu()" aria-label="Open restaurant navigation">
                    <?php include __DIR__ . '/../../../public/assets/icons/menu.php' ?>
                </button>

            </div>

        </div>

        <div class="mobile-menu" id="mobileMenu">
            <a href="/restaurant/dashboard">Dashboard</a>
            <a href="/restaurant/products">Products</a>
            <a href="/restaurant/orders">Orders</a>
            <a href="/restaurant/profile">Profile</a>
            <div class="dropdown-divider"></div>
            <form action="/logout" method="POST">
                <button type="submit" class="sign-out">Sign out</button>
            </form>
        </div>

    </nav>

    <script src="/js/customer-nav.js"></script>