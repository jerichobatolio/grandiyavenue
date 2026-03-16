<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Proof - Grandiya Venue &amp; Restaurant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #000;
            color: #fff;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 16px;
            background: #0b1120;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.6);
        }

        .top-left {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            white-space: nowrap;
        }

        .top-left-logo {
            width: 20px;
            height: 20px;
            border-radius: 999px;
            overflow: hidden;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
            color: #0b1120;
        }

        .top-left-title {
            opacity: 0.9;
        }

        .top-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn {
            border: none;
            border-radius: 999px;
            padding: 6px 12px;
            font-size: 13px;
            cursor: pointer;
            background: #1f2937;
            color: #e5e7eb;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn:hover {
            background: #374151;
        }

        .btn-primary {
            background: #2563eb;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-close {
            background: transparent;
            color: #9ca3af;
            font-size: 18px;
            padding: 4px 8px;
        }

        .btn-close:hover {
            color: #e5e7eb;
            background: rgba(148, 163, 184, 0.2);
        }

        .content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
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
    <div class="top-bar">
        <div class="top-left">
            <div class="top-left-logo">GV</div>
            <div class="top-left-title">Grandiya Venue &amp; Restaurant</div>
        </div>
        <div class="top-actions">
            <button class="btn btn-primary" onclick="downloadImage()">
                ⬇️ Download
            </button>
            <button class="btn btn-close" onclick="window.close()">
                ✕
            </button>
        </div>
    </div>

    <div class="content">
        <div class="image-frame">
            <img src="{{ $imageUrl }}" alt="Payment Proof">
        </div>
    </div>

    <script>
        function downloadImage() {
            const link = document.createElement('a');
            link.href = '{{ $imageUrl }}';
            link.download = '';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
</body>
</html>

