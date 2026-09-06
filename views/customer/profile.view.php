<?php
include __DIR__ . '/../partials/header.view.php';
include __DIR__ . '/nav.view.php';

$user_name    = $customer['name'];
$user_email   = $customer['email'];
$user_phone   = $customer['phone'];
$user_role    = $customer['role'];
$user_address = $customer['address'];
$user_image   = "https://ui-avatars.com/api/?name=" . urlencode($user_name) . "&background=f3402c&color=fff&size=150";
?>

<link rel="stylesheet" href="/Talabat/public/CSS/profile.css">

<div class="profile-page">

    <div class="circle-right"></div>
    <div class="circle-left"></div>

    <div class="profile-container">

        <div class="profile-header">
            <h1>My Profile</h1>
            <button class="edit-button" type="button">
                <i class="fa-solid fa-pen"></i> Edit
            </button>
        </div>

        <div class="profile-summary">
            <img src="<?php echo htmlspecialchars($user_image); ?>" alt="<?php echo htmlspecialchars($user_name); ?>">
            <div class="profile-info">
                <h2><?php echo htmlspecialchars($user_name); ?></h2>
                <p><?php echo htmlspecialchars($user_email); ?></p>
                <span class="role-badge"><?php echo htmlspecialchars($user_role); ?></span>
            </div>
        </div>

        <div class="personal-information">
            <h3>Personal information</h3>

            <div class="full-name">
                <label>Full name</label>
                <div class="value-box">
                    <i class="fa-solid fa-user"></i>
                    <span><?php echo htmlspecialchars($user_name); ?></span>
                </div>
            </div>

            <div class="email-address">
                <label>Email address</label>
                <div class="value-box">
                    <i class="fa-solid fa-envelope"></i>
                    <span><?php echo htmlspecialchars($user_email); ?></span>
                </div>
            </div>

            <div class="phone-number">
                <label>Phone number</label>
                <div class="value-box">
                    <i class="fa-solid fa-phone"></i>
                    <span><?php echo htmlspecialchars($user_phone); ?></span>
                </div>
            </div>
        </div>

        <div class="delivery-address">
            <h3><i class="fa-solid fa-location-dot"></i> Delivery address</h3>

            <div class="street-address">
                <label>Street address</label>
                <div class="value-box">
                    <span><?php echo htmlspecialchars($user_address); ?></span>
                </div>
            </div>
        </div>

        <div class="account">
            <h3>Account</h3>
            <button class="sign-out-button" type="button" onclick="logout()">
                <i class="fa-solid fa-right-from-bracket"></i> Sign out
            </button>
        </div>

    </div>
</div>

<?php
include __DIR__ . '/../partials/footer.view.php';