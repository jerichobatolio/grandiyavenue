<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 30px;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
            margin-bottom: 20px;
        }
        .status-confirmed {
            background: #d1ecf1;
            color: #0c5460;
        }
        .status-paid {
            background: #d4edda;
            color: #155724;
        }
        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }
        .status-completed {
            background: #e2e3e5;
            color: #383d41;
        }
        .booking-details {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .booking-details h3 {
            margin-top: 0;
            color: #495057;
            font-size: 18px;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 5px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: #6c757d;
        }
        .detail-value {
            color: #495057;
        }
        .message {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 20px;
            margin: 20px 0;
            border-radius: 0 8px 8px 0;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            margin: 20px 0;
        }
        .btn:hover {
            opacity: 0.9;
        }
        @media (max-width: 600px) {
            .container {
                margin: 10px;
                border-radius: 0;
            }
            .header, .content, .footer {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $title }}</h1>
        </div>
        
        <div class="content">
            <div class="status-badge status-{{ strtolower($status) }}">
                {{ $status }}
            </div>
            
            <p>Hello {{ $booking->full_name }},</p>
            
            <div class="message">
                <strong>{{ $message }}</strong>
            </div>
            
            <div class="booking-details">
                <h3>📋 Booking Details</h3>
                <div class="detail-row">
                    <span class="detail-label">Event Date:</span>
                    <span class="detail-value">{{ $event_date }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Number of Guests:</span>
                    <span class="detail-value">{{ $guests }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Down Payment:</span>
                    <span class="detail-value">₱{{ $amount }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Contact Number:</span>
                    <span class="detail-value">{{ $booking->contact_number }}</span>
                </div>
                @if($booking->additional_notes)
                <div class="detail-row">
                    <span class="detail-label">Additional Notes:</span>
                    <span class="detail-value">{{ $booking->additional_notes }}</span>
                </div>
                @endif
            </div>
            
            @if($status == 'Paid')
            <p>💰 <strong>Payment Received!</strong> Thank you for your payment. Your event is now fully confirmed.</p>
            @elseif($status == 'Cancelled')
            <p>❌ <strong>Booking Cancelled</strong> - If you have any questions or would like to reschedule, please don't hesitate to contact us.</p>
            @endif
            
            <p>If you have any questions or concerns, please don't hesitate to contact us.</p>
            
            <p>Best regards,<br>
            <strong>{{ config('app.name') }} Team</strong></p>
        </div>
        
        <div class="footer">
            <p>This is an automated notification. Please do not reply to this email.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
