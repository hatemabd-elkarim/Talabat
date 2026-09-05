<?php
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/CSS/style.css">
    <link rel="stylesheet" href="/CSS/login.css">
</head>


<body>
    <main class="login-page">
        <div class="login-card">
            <div class="login-header">
                <div class="logo">
                    <span class="logo-icon"></span>
                    <span class="logo-text">Talabat</span>
                </div>

                <h1>Welcome back</h1>
                <p>Sign in to your account to continue.</p>
            </div>

            <form class="login-form" method="POST" action="/login">
                <div class="email-field">
                    <label for="email">Email address</label>
                    <input type="email" name="email" id="email" placeholder="you@example.com" required value="<?= old('email') ?? '' ?>">
                    <span class="email-error">
                        <?php if (!empty($errors['email'])): ?>
                            <?= htmlspecialchars($errors['email']) ?>
                        <?php endif; ?>

                        <?php if (!empty($errors['Invalid_Credentials'])): ?>
                            <?= htmlspecialchars($errors['Invalid_Credentials']) ?>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="password-field">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="*******" requried>
                    <span class="password-error">
                        <?php if (!empty($errors['password'])): ?>
                            <?= htmlspecialchars($errors['password']) ?>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="remember-field">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Remember me</label>
                </div>
                <div class="submit-field">
                    <input type="submit" value="Sign in">
                </div>
                <div class="login-signup">
                    <p>Don't have an account? <a href="/register">Create one</a></p>
                </div>
            </form>

        </div>
    </main>
</body>

</html>