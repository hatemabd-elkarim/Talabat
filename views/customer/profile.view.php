<?php
include __DIR__ . '/../partials/header.view.php';
include __DIR__ . '/nav.view.php';

$user_name    = "Alex Johnson";
$user_email   = "customer@demo.com";
$user_phone   = "+971 50 123 4567";
$user_role    = "Customer";
$user_address = "123 Marina Walk, Dubai Marina, Dubai";
$user_image   = "https://i.pravatar.cc/150?img=12";
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
            <img src="<?php echo $user_image; ?>" alt="<?php echo $user_name; ?>">
            <div class="profile-info">
                <h2><?php echo $user_name; ?></h2>
                <p><?php echo $user_email; ?></p>
                <span class="role-badge"><?php echo $user_role; ?></span>
            </div>
        </div>

        <div class="personal-information">
            <h3>Personal information</h3>

            <div class="full-name">
                <label>Full name</label>
                <div class="value-box">
                    <i class="fa-solid fa-user"></i>
                    <span><?php echo $user_name; ?></span>
                </div>
            </div>

            <div class="email-address">
                <label>Email address</label>
                <div class="value-box">
                    <i class="fa-solid fa-envelope"></i>
                    <span><?php echo $user_email; ?></span>
                </div>
            </div>

            <div class="phone-number">
                <label>Phone number</label>
                <div class="value-box">
                    <i class="fa-solid fa-phone"></i>
                    <span><?php echo $user_phone; ?></span>
                </div>
            </div>
        </div>

        <div class="delivery-address">
            <h3><i class="fa-solid fa-location-dot"></i> Delivery address</h3>

            <div class="street-address">
                <label>Street address</label>
                <div class="value-box">
                    <span><?php echo $user_address; ?></span>
                </div>
            </div>
        </div>

        <div class="account">
            <h3>Account</h3>
            <button class="sign-out-button" type="button">
                <i class="fa-solid fa-right-from-bracket"></i> Sign out
            </button>
        </div>

    </div>
</div>

<?php
include __DIR__ . '/../partials/footer.view.php';