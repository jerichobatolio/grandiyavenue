<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f6fb;
            font-family: Arial, Helvetica, sans-serif;
            color: #1f2937;
        }
        .wrapper {
            width: 100%;
            padding: 24px 12px;
            box-sizing: border-box;
        }
        .card {
            max-width: 640px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            box-shadow: 0 8px 30px rgba(15, 23, 42, 0.08);
        }
        .header {
            padding: 20px 24px;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: #ffffff;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            line-height: 1.4;
        }
        .content {
            padding: 22px 24px;
        }
        .intro {
            margin: 0 0 16px 0;
            color: #374151;
            font-size: 14px;
        }
        .details {
            margin: 0;
            padding: 0;
            list-style: none;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
        }
        .item-image-wrap {
            margin: 0 0 12px 0;
            text-align: center;
        }
        .item-image {
            max-width: 180px;
            max-height: 180px;
            width: auto;
            height: auto;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            display: inline-block;
        }
        .details li {
            padding: 10px 12px;
            font-size: 14px;
            border-bottom: 1px solid #f1f5f9;
        }
        .items-line {
            padding: 10px 12px;
            border-bottom: 1px solid #f1f5f9;
        }
        .items-label {
            display: block;
            font-size: 14px;
            margin-bottom: 8px;
            color: #111827;
        }
        .items-list {
            margin: 0;
            padding: 0;
            list-style: none;
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }
        .items-list li {
            border: 1px solid #dbe3ef;
            background: #f8fbff;
            border-radius: 999px;
            padding: 6px 10px;
            font-size: 13px;
            line-height: 1.2;
            color: #334155;
        }
        .details li:last-child {
            border-bottom: none;
        }
        .plain {
            margin: 0;
            white-space: pre-line;
            font-size: 14px;
            color: #374151;
        }
        .footer {
            border-top: 1px solid #e5e7eb;
            padding: 14px 24px 20px;
            color: #6b7280;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">
            <div class="header">
                <h1>{{ $subject }}</h1>
            </div>
            <div class="content">
                <p class="intro">{{ $introText }}</p>

                @if(!empty($imageUrl))
                    <div class="item-image-wrap">
                        <img src="{{ $imageUrl }}" alt="Order item image" class="item-image">
                    </div>
                @endif

                @if(!empty($messageLines))
                    <ul class="details">
                        @foreach($messageLines as $line)
                            @if(str_starts_with($line, 'Items:'))
                                @php
                                    $itemsValue = trim(substr($line, 6));
                                    $items = array_values(array_filter(array_map('trim', explode(',', $itemsValue)), fn ($v) => $v !== ''));
                                @endphp
                                <li class="items-line">
                                    <span class="items-label">Items:</span>
                                    @if(!empty($items))
                                        <ul class="items-list">
                                            @foreach($items as $item)
                                                <li>{{ $item }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span>{{ $itemsValue }}</span>
                                    @endif
                                </li>
                            @else
                                <li>{{ $line }}</li>
                            @endif
                        @endforeach
                    </ul>
                @else
                    <p class="plain">{{ $messageText }}</p>
                @endif
            </div>
            <div class="footer">
                This is an automated email notification.
            </div>
        </div>
    </div>
</body>
</html>
