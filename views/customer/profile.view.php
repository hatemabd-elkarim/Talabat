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
            <button class="edit-button" type="button" id="editButton">
                <?php include __DIR__ . '/../../public/assets/icons/edit.php'; ?>Edit
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
                    <?php include __DIR__ . '/../../public/assets/icons/users.php'; ?>
                    <input
                        type="text"
                        id="nameValue"
                        value="<?php echo htmlspecialchars($user_name); ?>"
                        readonly>
                </div>
            </div>

            <div class="email-address">
                <label>Email address</label>
                <div class="value-box">
                    <?php include __DIR__ . '/../../public/assets/icons/mail.php'; ?>
                    <input
                        type="email"
                        id="emailValue"
                        value="<?php echo htmlspecialchars($user_email); ?>"
                        readonly>
                </div>
                <small class="field-error" id="emailError"></small>
            </div>

            <div class="phone-number">
                <label>Phone number</label>
                <div class="value-box">
                    <?php include __DIR__ . '/../../public/assets/icons/phone.php'; ?>
                    <input
                        type="text"
                        id="phoneValue"
                        value="<?php echo htmlspecialchars($user_phone); ?>"
                        readonly>
                </div>
                <small class="field-error" id="phoneError"></small>
            </div>
        </div>

        <div class="delivery-address">
            <h3><i class="fa-solid fa-location-dot"></i> Delivery address</h3>

            <div class="street-address">
                <label>Street address</label>
                <div class="value-box">
                    <?php include __DIR__ . '/../../public/assets/icons/map-pin.php'; ?>
                    <input
                        type="text"
                        id="addressValue"
                        value="<?php echo htmlspecialchars($user_address); ?>"
                        readonly>
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

<script src="/js/profile.js"></script>
<?php
include __DIR__ . '/../partials/footer.view.php';
