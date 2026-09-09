<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>404 - Page Not Found</title>

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

            background: var(--color-background);
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
           Page
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

        /* Decorative circles */

        .error-page::before {
            content: "";

            position: absolute;

            width: 420px;
            height: 420px;

            top: -180px;
            left: -150px;

            border-radius: 50%;

            background: rgba(255, 90, 31, 0.07);

            z-index: -1;

            animation: float 8s ease-in-out infinite;
        }

        .error-page::after {
            content: "";

            position: absolute;

            width: 280px;
            height: 280px;

            right: -120px;
            bottom: -120px;

            border-radius: 50%;

            background: rgba(255, 143, 92, 0.08);

            z-index: -1;

            animation: float 10s ease-in-out infinite reverse;
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
           404 illustration
        ========================= */

        .illustration {
            height: 120px;

            margin-bottom: 24px;

            display: flex;
            align-items: center;
            justify-content: center;

            position: relative;

            animation: illustrationIn 0.8s ease 0.15s both;
        }

        .number {
            font-family: "Poppins", sans-serif;

            font-size: clamp(70px, 12vw, 110px);

            font-weight: 800;

            line-height: 1;

            color: var(--color-primary);

            letter-spacing: -0.06em;

            position: relative;
        }

        .number:first-child {
            transform: rotate(-7deg);
        }

        .number:last-child {
            transform: rotate(7deg);
        }

        .plate {
            width: 82px;
            height: 82px;

            margin: 0 4px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: var(--color-muted);

            border: 8px solid var(--color-primary);

            position: relative;

            transform: translateY(5px);

            box-shadow:
                0 8px 20px rgba(36, 31, 27, 0.08);
        }

        .plate::before,
        .plate::after {
            content: "";

            position: absolute;

            width: 8px;
            height: 8px;

            border-radius: 50%;

            background: var(--color-secondary);
        }

        .plate::before {
            left: 21px;
            top: 25px;
        }

        .plate::after {
            right: 21px;
            top: 25px;
        }

        .mouth {
            position: absolute;

            width: 28px;
            height: 13px;

            left: 50%;
            bottom: 18px;

            transform: translateX(-50%);

            border-top: 3px solid var(--color-secondary);

            border-radius: 50%;
        }

        /* =========================
           Text
        ========================= */

        .error-title {
            margin-bottom: 14px;

            font-size: clamp(25px, 4vw, 34px);

            font-weight: 700;

            animation: textIn 0.6s ease 0.3s both;
        }

        .error-message {
            max-width: 520px;

            margin: 0 auto 32px;

            color: var(--color-muted-fg);

            font-size: 16px;

            line-height: 1.7;

            animation: textIn 0.6s ease 0.4s both;
        }

        /* =========================
           Actions
        ========================= */

        .error-actions {
            display: flex;

            justify-content: center;

            gap: 12px;

            animation: textIn 0.6s ease 0.5s both;
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

            box-shadow:
                0 5px 15px rgba(255, 90, 31, 0.2);
        }

        .btn-primary:hover {
            background: var(--color-primary-dark);

            transform: translateY(-2px);

            box-shadow:
                0 8px 20px rgba(255, 90, 31, 0.25);
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

        @keyframes illustrationIn {
            from {
                opacity: 0;
                transform: scale(0.75) translateY(15px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
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

            .illustration {
                height: 90px;
            }

            .number {
                font-size: 68px;
            }

            .plate {
                width: 62px;
                height: 62px;

                border-width: 6px;
            }

            .plate::before,
            .plate::after {
                width: 6px;
                height: 6px;

                top: 19px;
            }

            .plate::before {
                left: 15px;
            }

            .plate::after {
                right: 15px;
            }

            .mouth {
                width: 22px;
                height: 10px;

                bottom: 13px;
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

            <div class="illustration">

                <span class="number">4</span>

                <div class="plate">
                    <div class="mouth"></div>
                </div>

                <span class="number">4</span>

            </div>

            <h1 class="error-title">
                Page Not Found
            </h1>

            <p class="error-message">
                Looks like this page took a wrong turn.
                The page you're looking for doesn't exist,
                has been moved, or the URL might be incorrect.
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