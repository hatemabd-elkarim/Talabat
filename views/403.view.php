<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>403 - Access Denied</title>

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

            --color-error: #dc2626;
            --color-error-bg: #fee2e2;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            min-height: 100%;
        }

        body {
            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 24px;

            font-family: "Inter", sans-serif;

            background-color: var(--color-background);
            color: var(--color-secondary);

            -webkit-font-smoothing: antialiased;

            overflow: hidden;
        }

        h1,
        h2,
        h3 {
            font-family: "Poppins", sans-serif;
            letter-spacing: -0.02em;
        }

        /* =========================
           Background decoration
        ========================= */

        .error-page {
            width: 100%;
            max-width: 900px;
            min-height: 600px;

            display: flex;
            align-items: center;
            justify-content: center;

            position: relative;

            isolation: isolate;
        }

        .error-page::before,
        .error-page::after {
            content: "";

            position: absolute;

            border-radius: 50%;

            z-index: -1;

            pointer-events: none;
        }

        .error-page::before {
            width: 350px;
            height: 350px;

            top: -120px;
            right: -100px;

            background: rgba(255, 90, 31, 0.08);

            animation: float 7s ease-in-out infinite;
        }

        .error-page::after {
            width: 250px;
            height: 250px;

            bottom: -100px;
            left: -80px;

            background: rgba(255, 143, 92, 0.08);

            animation: float 9s ease-in-out infinite reverse;
        }

        /* =========================
           Card
        ========================= */

        .error-card {
            width: 100%;

            padding: 60px 40px;

            background: var(--color-surface);

            border: 1px solid var(--color-border);

            border-radius: 28px;

            text-align: center;

            box-shadow:
                0 20px 60px rgba(36, 31, 27, 0.08);

            animation: cardIn 0.7s ease forwards;
        }

        /* =========================
           Error icon
        ========================= */

        .error-icon {
            width: 110px;
            height: 110px;

            margin: 0 auto 28px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: var(--color-error-bg);

            color: var(--color-error);

            font-family: "Poppins", sans-serif;
            font-size: 42px;
            font-weight: 800;

            position: relative;

            animation: iconIn 0.8s ease 0.15s both;
        }

        .error-icon::after {
            content: "";

            position: absolute;

            inset: -8px;

            border: 1px solid rgba(220, 38, 38, 0.12);

            border-radius: 50%;

            animation: pulse 2.5s ease-in-out infinite;
        }

        /* =========================
           Text
        ========================= */

        .error-code {
            margin-bottom: 8px;

            font-size: clamp(64px, 10vw, 96px);
            line-height: 1;

            font-weight: 800;

            color: var(--color-secondary);

            animation: textIn 0.6s ease 0.25s both;
        }

        .error-title {
            margin-bottom: 14px;

            font-size: clamp(24px, 4vw, 34px);
            font-weight: 700;

            animation: textIn 0.6s ease 0.35s both;
        }

        .error-message {
            max-width: 520px;

            margin: 0 auto 32px;

            color: var(--color-muted-fg);

            font-size: 16px;
            line-height: 1.7;

            animation: textIn 0.6s ease 0.45s both;
        }

        /* =========================
           Button
        ========================= */

        .error-actions {
            display: flex;
            justify-content: center;
            gap: 12px;

            animation: textIn 0.6s ease 0.55s both;
        }

        .btn {
            min-width: 150px;

            padding: 13px 24px;

            border-radius: 10px;

            font-family: "Inter", sans-serif;
            font-size: 14px;
            font-weight: 600;

            text-decoration: none;

            cursor: pointer;

            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease,
                background 0.2s ease;
        }

        .btn-primary {
            color: white;

            background: var(--color-primary);

            border: 1px solid var(--color-primary);

            box-shadow: 0 5px 15px rgba(255, 90, 31, 0.2);
        }

        .btn-primary:hover {
            background: var(--color-primary-dark);

            transform: translateY(-2px);

            box-shadow: 0 8px 20px rgba(255, 90, 31, 0.25);
        }

        .btn-secondary {
            color: var(--color-secondary);

            background: var(--color-background);

            border: 1px solid var(--color-border);
        }

        .btn-secondary:hover {
            background: var(--color-muted);

            transform: translateY(-2px);
        }

        .btn:active {
            transform: translateY(0);
        }

        /* =========================
           Grain
        ========================= */

        .grain {
            position: fixed;

            inset: 0;

            pointer-events: none;

            opacity: 0.035;

            z-index: 10;

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

        @keyframes iconIn {
            from {
                opacity: 0;
                transform: scale(0.7);
            }

            to {
                opacity: 1;
                transform: scale(1);
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

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.6;
            }

            50% {
                transform: scale(1.08);
                opacity: 0.15;
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

        @media (max-width: 600px) {
            body {
                padding: 16px;
            }

            .error-page {
                min-height: auto;
            }

            .error-card {
                padding: 45px 24px;
                border-radius: 22px;
            }

            .error-icon {
                width: 90px;
                height: 90px;

                font-size: 34px;
            }

            .error-message {
                font-size: 14px;
            }

            .error-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <div class="grain"></div>

    <main class="error-page">

        <section class="error-card">

            <div class="error-icon">
                !
            </div>

            <h1 class="error-code">403</h1>

            <h2 class="error-title">
                Access Denied
            </h2>

            <p class="error-message">
                You don't have permission to access this page.
                Please make sure you're using the correct account
                or return to your dashboard.
            </p>

            <div class="error-actions">

                <a href="/" class="btn btn-primary">
                    Go Home
                </a>

                <button class="btn btn-secondary" onclick="goBack()">
                    Go Back
                </button>

            </div>

        </section>

    </main>

    <script>
        function goBack() {
            if (window.history.length > 1) {
                window.history.back();
            } else {
                window.location.href = "/";
            }
        }
    </script>

</body>

</html>