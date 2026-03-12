<!DOCTYPE html>
<html lang="en">
<head>
    @include('home.css')
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <title>Request Return/Refund | Grandiya Venue & Restaurant</title>
    <style>
        body {
            background-color: #1b1b1b;
            color: white;
            font-family: Arial, sans-serif;
            padding: 20px;
            padding-top: 100px;
        }

        .minimal-navbar {
            background-color: #1b1b1b;
            border-bottom: 2px solid gold;
            padding: 15px 0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        .minimal-navbar .back-btn {
            color: skyblue;
            text-decoration: none;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .minimal-navbar .back-btn:hover {
            color: gold;
        }

        .main-content {
            max-width: 800px;
            margin: 20px auto;
            padding: 0 20px;
        }

        .form-container {
            background-color: #2c2c2c;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        }

        h2 {
            color: gold;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: white;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #444;
            border-radius: 5px;
            background-color: #1b1b1b;
            color: white;
            font-size: 1rem;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: gold;
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        .info-box {
            background-color: #333;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid gold;
        }

        .info-box strong {
            color: gold;
        }

        .btn-submit {
            background-color: gold;
            color: black;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #ffd700;
        }

        .btn-cancel {
            background-color: #6c757d;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        .btn-cancel:hover {
            background-color: #5a6268;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            color: skyblue;
            text-decoration: none;
            font-size: 1.1rem;
            margin-bottom: 20px;
        }

        .back-link:hover {
            color: gold;
        }

        .error-message {
            background-color: #dc3545;
            color: white;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .success-message {
            background-color: #28a745;
            color: white;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .alert-danger {
            background-color: #dc3545;
            color: white;
        }

        .alert-success {
            background-color: #28a745;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Minimal Navbar -->
    <nav class="minimal-navbar">
    </nav>

    <div class="main-content">
        <a href="{{ url()->previous() }}" class="back-link">
            <span style="margin-right: 8px; font-size: 1.2rem;">←</span>
            Back
        </a>

        <div class="form-container">
            <h2>📋 Request Return/Refund</h2>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="info-box">
                <strong>Item Information:</strong><br>
                @if($type === 'event_booking')
                    <strong>Event Booking:</strong> {{ $refundable->eventType->name ?? 'N/A' }}<br>
                    <strong>Event Date:</strong> {{ $refundable->event_date->format('M d, Y') }}<br>
                    <strong>Number of Guests:</strong> {{ $refundable->number_of_guests }}<br>
                    <strong>Status:</strong> {{ $refundable->status }}<br>
                    <strong>Amount Paid:</strong> ₱{{ number_format($refundable->amount_paid ?? $refundable->down_payment_amount, 2) }}
                @else
                    <strong>Order:</strong> {{ $refundable->title }}<br>
                    <strong>Quantity:</strong> {{ $refundable->quantity }}<br>
                    <strong>Price per Item:</strong> ₱{{ number_format($refundable->price, 2) }}<br>
                    <strong>Status:</strong> {{ $refundable->delivery_status }}<br>
                    <strong>Total Amount:</strong> ₱{{ number_format($refundAmount, 2) }}
                @endif
            </div>

            <form action="{{ route('return_refunds.store') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="{{ $type }}">
                <input type="hidden" name="refundable_id" value="{{ $refundable->id }}">
                <input type="hidden" name="refund_amount" value="{{ $refundAmount }}">

                <div class="form-group">
                    <label for="refund_type">Request Type *</label>
                    <select name="refund_type" id="refund_type" required>
                        <option value="refund">Refund Only</option>
                        <option value="return">Return & Refund</option>
                    </select>
                    <small style="color: #ccc; display: block; margin-top: 5px;">
                        Select "Refund Only" for a monetary refund, or "Return & Refund" if you need to return the item.
                    </small>
                </div>

                <div class="form-group">
                    <label for="refund_amount_display">Refund Amount</label>
                    <input type="text" id="refund_amount_display" value="₱{{ number_format($refundAmount, 2) }}" readonly style="background-color: #333; cursor: not-allowed;">
                    <small style="color: #ccc; display: block; margin-top: 5px;">
                        This is the amount that will be refunded if your request is approved.
                    </small>
                </div>

                <div class="form-group">
                    <label for="reason">Reason for Return/Refund *</label>
                    <textarea name="reason" id="reason" rows="5" required placeholder="Please provide a detailed reason for your return/refund request...">{{ old('reason') }}</textarea>
                    <small style="color: #ccc; display: block; margin-top: 5px;">
                        Please be as detailed as possible to help us process your request faster.
                    </small>
                </div>

                <button type="submit" class="btn-submit">Submit Request</button>
                <a href="{{ url()->previous() }}" class="btn-cancel" style="display: block; text-align: center;">Cancel</a>
            </form>
        </div>
    </div>

</body>
</html>
