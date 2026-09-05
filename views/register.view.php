<?php
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="/CSS/style.css">
    <link rel="stylesheet" href="/CSS/register.css">
</head>

<body>
    <main class="register-page">
        <div class="register-card">
            <div class="register-header">
                <div class="register-logo">
                    <span class="register-logo-icon"></span>
                    <span class="logo-text">Talabat</span>
                </div>

                <h1>Create your account</h1>
                <p>Join thousands of happy customers getting food delivered.</p>
            </div>

            <form class="register-form" method="POST" action="/register">
                <div class="register-fullname-field">
                    <label for="fullname">Full name</label>
                    <input type="text" name="fullname" id="fullname" placeholder="Your full name" required value="<?= old('name') ?? '' ?>">
                    <span class="fullname-error">
                        <?php if (!empty($errors['name'])): ?>
                            <?= htmlspecialchars($errors['name']) ?>
                        <?php endif; ?>
                    </span>
                </div>

                <div class="register-email-field">
                    <label for="email">Email address</label>
                    <input type="email" name="email" id="email" placeholder="you@example.com" required value="<?= old('email') ?? '' ?>">
                    <span class="email-error">
                        <?php if (!empty($errors['email'])): ?>
                            <?= htmlspecialchars($errors['email']) ?>
                        <?php endif; ?>
                    </span>
                </div>

                <div class="register-phone-field">
                    <label for="phone">Phone number</label>
                    <input type="tel" name="phone" id="phone" placeholder="+201000000000" required value="<?= old('phone') ?? '' ?>">
                    <span class="phone-error">
                        <?php if (!empty($errors['phone'])): ?>
                            <?= htmlspecialchars($errors['phone']) ?>
                        <?php endif; ?>
                    </span>
                </div>


                <div class="register-password-field">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Min. 8 characters" minlength="8" required>
                    <span class="password-error">
                        <?php if (!empty($errors['password'])): ?>
                            <?= htmlspecialchars($errors['password']) ?>
                        <?php endif; ?>
                    </span>
                </div>

                <div class="register-repeat-password-field">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" name="confirm-password" id="confirm-password" placeholder="Repeat password" required>
                    <span class="repeat-password-error">
                        <?php if (!empty($errors['confirm-password'])): ?>
                            <?= htmlspecialchars($errors['confirm-password']) ?>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="register-location-field">
                    <label for="location">Delivery location</label>
                    <input type="text" name="address" id="location" placeholder="Your delivery address" required value="<?= old('address') ?? '' ?>">
                    <span class="location-error">
                        <?php if (!empty($errors['address'])): ?>
                            <?= htmlspecialchars($errors['address']) ?>
                        <?php endif; ?>
                    </span>
                </div>

                <div class="register-submit-field">
                    <input type="submit" value="Create account">
                </div>

                <div class="register-signup">
                    <p>Already have an account? <a href="/login">Sign in</a></p>
                </div>
            </form>
        </div>
    </main>
</body>

</html>