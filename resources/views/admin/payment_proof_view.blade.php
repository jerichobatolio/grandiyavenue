<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Grandiya Venue &amp; Restaurant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            margin: 0;
            padding: 16px 0 24px;
            background: #000;
            color: #fff;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: 100vh;
        }

        .logo-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            gap: 4px;
        }

        .logo-wrap img {
            width: 40px;
            height: 40px;
            border-radius: 999px;
            object-fit: cover;
            background: #fff;
        }

        .logo-wrap span {
            font-size: 13px;
            opacity: 0.8;
        }

        .image-frame {
            max-width: 430px;
            width: 100%;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.9);
            background: #020617;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-frame img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        @media (max-width: 640px) {
            .image-frame {
                max-width: 100%;
                border-radius: 0;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="logo-wrap">
        <img src="{{ asset('assets/imgs/logo.png') }}" alt="Grandiya Logo">
        <span>Grandiya Venue &amp; Restaurant</span>
    </div>

    <div class="image-frame">
        <img src="{{ $imageUrl }}" alt="Payment Proof">
    </div>
</body>
</html>

