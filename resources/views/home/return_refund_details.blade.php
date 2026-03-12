<!DOCTYPE html>
<html lang="en">
<head>
    @include('home.css')
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <title>Return/Refund Details | Grandiya Venue & Restaurant</title>
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
            max-width: 900px;
            margin: 20px auto;
            padding: 0 20px;
        }

        .details-container {
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

        .detail-section {
            margin-bottom: 25px;
            padding: 20px;
            background-color: #333;
            border-radius: 5px;
        }

        .detail-section h3 {
            color: gold;
            margin-bottom: 15px;
            border-bottom: 2px solid gold;
            padding-bottom: 10px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #444;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: bold;
            color: #ccc;
        }

        .detail-value {
            color: white;
        }

        .status-badge {
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.9rem;
            display: inline-block;
        }

        .status-pending {
            background-color: #ffc107;
            color: black;
        }

        .status-approved {
            background-color: #17a2b8;
            color: white;
        }

        .status-rejected {
            background-color: #dc3545;
            color: white;
        }

        .status-refunded {
            background-color: #28a745;
            color: white;
        }

        .status-cancelled {
            background-color: #6c757d;
            color: white;
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

        .btn-cancel {
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        .btn-cancel:hover {
            background-color: #5a6268;
        }

        .amount {
            font-weight: bold;
            color: gold;
            font-size: 1.2rem;
        }

        .reason-box {
            background-color: #1b1b1b;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
            border-left: 4px solid gold;
        }

        .admin-notes-box {
            background-color: #1b1b1b;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
            border-left: 4px solid #17a2b8;
        }
    </style>
</head>
<body>
    <!-- Minimal Navbar -->
    <nav class="minimal-navbar">
    </nav>

    <div class="main-content">
        <a href="{{ route('return_refunds.index') }}" class="back-link">
            <span style="margin-right: 8px; font-size: 1.2rem;">←</span>
            Back to Requests
        </a>

        <div class="details-container">
            <h2>📋 Return/Refund Request Details</h2>

            @php
                $refundable = $returnRefund->refundable;
                $statusClass = 'status-' . $returnRefund->status;
            @endphp

            <!-- Request Information -->
            <div class="detail-section">
                <h3>Request Information</h3>
                <div class="detail-row">
                    <span class="detail-label">Request ID:</span>
                    <span class="detail-value">#{{ $returnRefund->id }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="status-badge {{ $statusClass }}">{{ ucfirst($returnRefund->status) }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Request Type:</span>
                    <span class="detail-value">{{ ucfirst($returnRefund->type) }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Refund Amount:</span>
                    <span class="amount">₱{{ number_format($returnRefund->refund_amount, 2) }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Date Requested:</span>
                    <span class="detail-value">{{ $returnRefund->created_at->format('M d, Y h:i A') }}</span>
                </div>
                @if($returnRefund->processed_at)
                <div class="detail-row">
                    <span class="detail-label">Processed Date:</span>
                    <span class="detail-value">{{ $returnRefund->processed_at->format('M d, Y h:i A') }}</span>
                </div>
                @endif
            </div>

            <!-- Item Information -->
            <div class="detail-section">
                <h3>Item Information</h3>
                @if($returnRefund->refundable_type === 'App\Models\EventBooking')
                    <div class="detail-row">
                        <span class="detail-label">Type:</span>
                        <span class="detail-value">Event Booking</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Event:</span>
                        <span class="detail-value">{{ $refundable->eventType->name ?? 'N/A' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Event Date:</span>
                        <span class="detail-value">{{ $refundable->event_date->format('M d, Y') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Number of Guests:</span>
                        <span class="detail-value">{{ $refundable->number_of_guests }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Booking Status:</span>
                        <span class="detail-value">{{ $refundable->status }}</span>
                    </div>
                @else
                    <div class="detail-row">
                        <span class="detail-label">Type:</span>
                        <span class="detail-value">Order</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Item:</span>
                        <span class="detail-value">{{ $refundable->title ?? 'N/A' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Quantity:</span>
                        <span class="detail-value">{{ $refundable->quantity }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Price per Item:</span>
                        <span class="detail-value">₱{{ number_format($refundable->price, 2) }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Order Status:</span>
                        <span class="detail-value">{{ $refundable->delivery_status }}</span>
                    </div>
                @endif
            </div>

            <!-- Reason -->
            <div class="detail-section">
                <h3>Reason for Return/Refund</h3>
                <div class="reason-box">
                    {{ $returnRefund->reason }}
                </div>
            </div>

            <!-- Admin Notes -->
            @if($returnRefund->admin_notes)
            <div class="detail-section">
                <h3>Admin Response</h3>
                <div class="admin-notes-box">
                    {{ $returnRefund->admin_notes }}
                </div>
            </div>
            @endif

            @if($returnRefund->approval_image_path)
            <div class="detail-section">
                <h3>Approval Image</h3>
                <img src="{{ asset('storage/' . $returnRefund->approval_image_path) }}" alt="Approval image" style="max-width: 100%; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.4);">
            </div>
            @endif

            <!-- Refund Processing Details -->
            @if($returnRefund->status === 'refunded')
            <div class="detail-section">
                <h3>Refund Processing Details</h3>
                <div class="detail-row">
                    <span class="detail-label">Refund Method:</span>
                    <span class="detail-value">{{ $returnRefund->refund_method ?? 'N/A' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Reference Number:</span>
                    <span class="detail-value">{{ $returnRefund->refund_reference ?? 'N/A' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Processed Date:</span>
                    <span class="detail-value">{{ $returnRefund->processed_at ? $returnRefund->processed_at->format('M d, Y h:i A') : 'N/A' }}</span>
                </div>
            </div>
            @endif

            @if($returnRefund->status === 'pending')
                <form action="{{ route('return_refunds.cancel', $returnRefund->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-cancel" onclick="return confirm('Are you sure you want to cancel this request?')">Cancel Request</button>
                </form>
            @endif
        </div>
    </div>

</body>
</html>
