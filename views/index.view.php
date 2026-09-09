<?php
$role = $_SESSION['user']['role'] ?? null;
?>

<style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap");
    @import url("https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap");

    :root {
        --color-primary: #ff5a1f;
        --color-primary-light: #ff8f5c;
        --color-primary-dark: #e14a0f;

        --color-secondary: #241f1b;

        --color-background: #faf6f1;
        --color-surface: #ffffff;
        --color-muted: #f1ebe1;
        --color-border: #ece3d8;
        --color-muted-fg: #857a6e;

        --color-success: #1e9e5a;
    }

    /* =========================
       Home Page
    ========================= */

    .home-page {
        min-height: calc(100vh - 80px);

        display: flex;
        align-items: center;
        justify-content: center;

        padding: 60px 24px;

        position: relative;
        overflow: hidden;

        background: var(--color-background);
        isolation: isolate;
    }

    /* =========================
       Decorative circles
    ========================= */

    .home-page::before,
    .home-page::after {
        content: "";

        position: absolute;

        border-radius: 50%;

        pointer-events: none;

        z-index: -1;
    }

    .home-page::before {
        width: 450px;
        height: 450px;

        top: -180px;
        right: -120px;

        background: rgba(255, 90, 31, 0.07);

        animation: float 8s ease-in-out infinite;
    }

    .home-page::after {
        width: 350px;
        height: 350px;

        bottom: -180px;
        left: -120px;

        background: rgba(255, 143, 92, 0.08);

        animation: float 10s ease-in-out infinite reverse;
    }

    /* =========================
       Container
    ========================= */

    .home-container {
        width: 100%;
        max-width: 1100px;

        position: relative;
    }

    /* =========================
       Hero Card
    ========================= */

    .home-card {
        width: 100%;

        padding: 70px 60px;

        background: var(--color-surface);

        border: 1px solid var(--color-border);

        border-radius: 28px;

        box-shadow:
            0 20px 60px rgba(36, 31, 27, 0.08);

        text-align: center;

        animation: cardIn 0.7s ease forwards;
    }

    /* =========================
       Badge
    ========================= */

    .home-badge {
        display: inline-flex;
        align-items: center;

        padding: 8px 14px;

        margin-bottom: 22px;

        border-radius: 999px;

        background: var(--color-muted);

        color: var(--color-primary-dark);

        font-size: 13px;
        font-weight: 600;

        animation: textIn 0.6s ease 0.15s both;
    }

    .home-badge::before {
        content: "";

        width: 7px;
        height: 7px;

        margin-right: 8px;

        border-radius: 50%;

        background: var(--color-success);
    }

    /* =========================
       Heading
    ========================= */

    .home-title {
        max-width: 800px;

        margin: 0 auto 18px;

        font-family: "Poppins", sans-serif;

        font-size: clamp(38px, 7vw, 68px);

        line-height: 1.05;

        font-weight: 800;

        letter-spacing: -0.04em;

        color: var(--color-secondary);

        animation: textIn 0.6s ease 0.25s both;
    }

    .home-title span {
        color: var(--color-primary);
    }

    .home-description {
        max-width: 620px;

        margin: 0 auto 36px;

        color: var(--color-muted-fg);

        font-size: 16px;

        line-height: 1.7;

        animation: textIn 0.6s ease 0.35s both;
    }

    /* =========================
       Actions
    ========================= */

    .home-actions {
        display: flex;

        align-items: center;
        justify-content: center;

        gap: 12px;

        animation: textIn 0.6s ease 0.45s both;
    }

    .home-btn {
        min-width: 160px;

        padding: 14px 26px;

        border-radius: 10px;

        font-family: "Inter", sans-serif;

        font-size: 14px;

        font-weight: 600;

        text-decoration: none;

        transition:
            transform 0.2s ease,
            box-shadow 0.2s ease,
            background 0.2s ease;
    }

    .home-btn-primary {
        color: white;

        background: var(--color-primary);

        border: 1px solid var(--color-primary);

        box-shadow:
            0 6px 18px rgba(255, 90, 31, 0.2);
    }

    .home-btn-primary:hover {
        background: var(--color-primary-dark);

        transform: translateY(-2px);

        box-shadow:
            0 9px 24px rgba(255, 90, 31, 0.25);
    }

    .home-btn-secondary {
        color: var(--color-secondary);

        background: var(--color-background);

        border: 1px solid var(--color-border);
    }

    .home-btn-secondary:hover {
        background: var(--color-muted);

        transform: translateY(-2px);
    }

    /* =========================
       Feature cards
    ========================= */

    .home-features {
        display: grid;

        grid-template-columns: repeat(3, 1fr);

        gap: 16px;

        margin-top: 18px;

        animation: textIn 0.6s ease 0.55s both;
    }

    .feature {
        padding: 22px;

        background: var(--color-surface);

        border: 1px solid var(--color-border);

        border-radius: 16px;

        text-align: left;

        transition:
            transform 0.2s ease,
            box-shadow 0.2s ease;
    }

    .feature:hover {
        transform: translateY(-4px);

        box-shadow:
            0 10px 30px rgba(36, 31, 27, 0.07);
    }

    .feature-icon {
        width: 42px;
        height: 42px;

        display: flex;
        align-items: center;
        justify-content: center;

        margin-bottom: 14px;

        border-radius: 10px;

        background: var(--color-muted);

        color: var(--color-primary);

        font-family: "Poppins", sans-serif;
        font-size: 18px;
        font-weight: 700;
    }

    .feature h3 {
        margin-bottom: 6px;

        font-size: 16px;
        font-weight: 600;
    }

    .feature p {
        color: var(--color-muted-fg);

        font-size: 13px;

        line-height: 1.6;
    }

    /* =========================
       Grain
    ========================= */

    .home-grain {
        position: fixed;

        inset: 0;

        pointer-events: none;

        opacity: 0.035;

        z-index: 100;

        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='120'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
    }

    /* =========================
       Animations
    ========================= */

    @keyframes cardIn {
        from {
            opacity: 0;
            transform: translateY(25px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes textIn {
        from {
            opacity: 0;
            transform: translateY(12px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(20px);
        }
    }

    /* =========================
       Responsive
    ========================= */

    @media (max-width: 700px) {
        .home-page {
            padding: 35px 16px;
        }

        .home-card {
            padding: 45px 24px;

            border-radius: 22px;
        }

        .home-title {
            font-size: 42px;
        }

        .home-description {
            font-size: 14px;
        }

        .home-actions {
            flex-direction: column;
        }

        .home-btn {
            width: 100%;
        }

        .home-features {
            grid-template-columns: 1fr;
        }
    }
</style>


<?php
/*
|--------------------------------------------------------------------------
| Role-based Navigation
|--------------------------------------------------------------------------
*/

switch ($role) {

    case 'customer':
        include 'partials/header.view.php';
        include 'customer/nav.view.php';
        break;

    case 'restaurant':
        include 'restaurant/partials/header.view.php';
        break;

    case 'admin':
        include 'partials/header.view.php';
        include 'admin/nav.view.php';
        break;
}
?>


<div class="home-grain"></div>

<main class="home-page">

    <div class="home-container">

        <section class="home-card">

            <?php if ($role): ?>

                <h1 class="home-title">
                    Welcome back<span>.</span>
                </h1>

                <p class="home-description">
                    Everything you need is right here.
                    Use your dashboard to manage your account
                    and get started.
                </p>

                <div class="home-actions">

                    <?php
                    $dashboardUrl = match ($role) {
                        'customer' => '/customer/home',
                        'restaurant' => '/restaurant/dashboard',
                        'admin' => '/admin/dashboard',
                        default => '/',
                    };
                    ?>

                    <a href="<?= $dashboardUrl ?>" class="home-btn home-btn-primary">
                        Go to Dashboard
                    </a>

                </div>

            <?php else: ?>

                <div class="home-badge">
                    Welcome
                </div>

                <h1 class="home-title">
                    Good food,<br>
                    <span>delivered.</span>
                </h1>

                <p class="home-description">
                    Discover restaurants, explore delicious meals,
                    and get your favorite food delivered right to your door.
                </p>

                <div class="home-actions">

                    <a href="/login" class="home-btn home-btn-primary">
                        Get Started
                    </a>

                    <a href="/register" class="home-btn home-btn-secondary">
                        Create Account
                    </a>

                </div>

            <?php endif; ?>

        </section>


        <section class="home-features">

            <div class="feature">

                <div class="feature-icon">
                    01
                </div>

                <h3>
                    Discover
                </h3>

                <p>
                    Find restaurants and meals that match
                    what you're craving.
                </p>

            </div>


            <div class="feature">

                <div class="feature-icon">
                    02
                </div>

                <h3>
                    Order
                </h3>

                <p>
                    Choose your favorite meals and place
                    your order easily.
                </p>

            </div>


            <div class="feature">

                <div class="feature-icon">
                    03
                </div>

                <h3>
                    Enjoy
                </h3>

                <p>
                    Sit back and enjoy your food while
                    your order makes its way to you.
                </p>

            </div>

        </section>

    </div>

</main>


<script>
    document.addEventListener("DOMContentLoaded", () => {

        const card = document.querySelector(".home-card");

        if (!card) return;

        card.addEventListener("mousemove", (event) => {

            const rect = card.getBoundingClientRect();

            const x = event.clientX - rect.left;
            const y = event.clientY - rect.top;

            const rotateX = ((y / rect.height) - 0.5) * -2;
            const rotateY = ((x / rect.width) - 0.5) * 2;

            card.style.transform =
                `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
        });

        card.addEventListener("mouseleave", () => {

            card.style.transform =
                "perspective(1000px) rotateX(0) rotateY(0)";
        });

    });
</script>


<?php include 'partials/footer.view.php'; ?>