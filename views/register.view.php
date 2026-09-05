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

            <form class="register-form">
                <div class="register-fullname-field">
                    <label for="fullname">Full name</label>
                    <input type="text" name="fullname" id="fullname" placeholder="Your full name" required>
                    <span class="fullname-error"></span>
                </div>

                <div class="register-email-field">
                    <label for="email">Email address</label>
                    <input type="email" name="email" id="email" placeholder="you@example.com" required>
                    <span class="email-error"></span>
                </div>

                <div class="register-phone-field">
                    <label for="phone">Phone number</label>
                    <input type="tel" name="phone" id="phone" placeholder="+201000000000" required>
                    <span class="phone-error"></span>
                </div>


                <div class="register-password-field">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Min. 6 characters" minlength="6" required>
                    <span class="password-error"></span>
                </div>

                <div class="register-repeat-password-field">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" name="confirm-password" id="confirm-password" placeholder="Repeat password" required>
                    <span class="repeat-password-error"></span>
                </div>
                <div class="register-location-field">
                    <label for="location">Delivery location</label>
                    <input type="text" name="location" id="location" placeholder="Your city or delivery address" required>
                    <span class="location-error"></span>
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