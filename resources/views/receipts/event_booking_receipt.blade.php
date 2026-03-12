<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png" href="{{ asset('assets/imgs/logo.png') }}">

    <title>Event Booking Receipt</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        
        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .receipt-header {
            text-align: center;
            border-bottom: 2px solid #28a745;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        
        .receipt-header h1 {
            color: #28a745;
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .receipt-header p {
            color: #666;
            font-size: 12px;
        }
        
        .receipt-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .info-section {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 6px;
        }
        
        .info-section h3 {
            color: #333;
            font-size: 14px;
            margin-bottom: 8px;
            border-bottom: 1px solid #28a745;
            padding-bottom: 4px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
            padding: 4px 0;
            border-bottom: 1px dotted #ddd;
            font-size: 12px;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 600;
            color: #555;
        }
        
        .info-value {
            color: #333;
            text-align: right;
        }
        
        .booking-details {
            background: #e8f5e9;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 15px;
            border-left: 4px solid #28a745;
        }
        
        .booking-details h3 {
            color: #2e7d32;
            font-size: 16px;
            margin-bottom: 10px;
        }
        
        .payment-details {
            background: #fff3cd;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 15px;
            border-left: 4px solid #ffc107;
        }
        
        .payment-details h3 {
            color: #856404;
            font-size: 16px;
            margin-bottom: 10px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-confirmed {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-paid {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        
        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .receipt-footer {
            text-align: center;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 10px;
        }
        
        .receipt-id {
            background: #28a745;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            display: inline-block;
            margin-bottom: 10px;
            font-weight: 600;
            font-size: 13px;
        }
        
        .additional-notes {
            background: #fff9e6;
            padding: 8px;
            border-radius: 4px;
            margin-top: 8px;
            border-left: 2px solid #ffc107;
            font-size: 11px;
        }
        
        .additional-notes strong {
            color: #856404;
        }
        
        #download-content {
            page-break-inside: avoid;
        }
        
        .print-button {
            text-align: center;
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn-print {
            background-color: #28a745;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-print:hover {
            background-color: #218838;
        }
        
        .btn-back {
            background-color: #6c757d;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-back:hover {
            background-color: #5a6268;
        }
        
        @media print {
            body {
                background-color: white;
                padding: 0;
            }
            
            .receipt-container {
                box-shadow: none;
                padding: 20px;
            }
            
            .print-button {
                display: none;
            }
        }
        
        .additional-notes {
            background: #fff9e6;
            padding: 8px;
            border-radius: 4px;
            margin-top: 8px;
            border-left: 2px solid #ffc107;
            font-size: 11px;
        }
        
        .additional-notes strong {
            color: #856404;
        }
        
        #download-content {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #28a745;">
            <strong>✅ {{ session('success') }}</strong>
        </div>
        @endif
        
        <div class="print-button">
            <a href="{{ url('/home') }}" class="btn-back">← Back to Homepage</a>
            <button onclick="downloadAsPDF()" class="btn-print">📥 Download Receipt</button>
        </div>
        
        <!-- Content that will be downloaded -->
        <div id="download-content">
        <div class="receipt-header">
            <h1>🎉 Event Booking Receipt</h1>
            <p>Grandiya Restaurant & Events</p>
        </div>
        
        <div class="receipt-id">
            Booking ID: {{ str_pad($booking->id, 6, "0", STR_PAD_LEFT) }}
        </div>
        
        <div class="receipt-info">
            <div class="info-section">
                <h3>👤 Customer Information</h3>
                <div class="info-row">
                    <span class="info-label">Full Name:</span>
                    <span class="info-value"><strong>{{ $booking->full_name }}</strong></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Contact Number:</span>
                    <span class="info-value"><strong>{{ $booking->contact_number }}</strong></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value"><strong>{{ $booking->email }}</strong></span>
                </div>
            </div>
            
            <div class="info-section">
                <h3>📋 Booking Status</h3>
                @if($booking->payment_option)
                <div class="info-row">
                    <span class="info-label">Payment Option:</span>
                    <span class="info-value"><strong>{{ $booking->payment_option_label }}</strong></span>
                </div>
                @endif
                @if($booking->payment_proof_path)
                <div class="info-row">
                    <span class="info-label">Payment Proof:</span>
                    <span class="info-value"><strong>✅ Uploaded</strong></span>
                </div>
                @endif
            </div>
        </div>
        
        <div class="booking-details">
            <h3>📅 Event Details</h3>
            <div class="info-row">
                <span class="info-label">Event Type:</span>
                <span class="info-value"><strong>{{ $booking->eventType ? $booking->eventType->name : 'N/A' }}</strong></span>
            </div>
            @if($booking->venueType)
            <div class="info-row">
                <span class="info-label">Venue Type:</span>
                <span class="info-value"><strong>{{ $booking->venueType->name }}</strong></span>
            </div>
            @endif
            <div class="info-row">
                <span class="info-label">Event Date:</span>
                <span class="info-value"><strong>{{ $booking->event_date->format('F d, Y') }}</strong></span>
            </div>
            <div class="info-row">
                <span class="info-label">Time In:</span>
                <span class="info-value"><strong>
                    @if($booking->time_in)
                        @php
                            $timeIn = is_string($booking->time_in) ? \Carbon\Carbon::parse($booking->time_in) : $booking->time_in;
                        @endphp
                        {{ $timeIn->format('h:i A') }}
                    @else
                        N/A
                    @endif
                </strong></span>
            </div>
            <div class="info-row">
                <span class="info-label">Time Out:</span>
                <span class="info-value"><strong>
                    @if($booking->time_out)
                        @php
                            $timeOut = is_string($booking->time_out) ? \Carbon\Carbon::parse($booking->time_out) : $booking->time_out;
                        @endphp
                        {{ $timeOut->format('h:i A') }}
                    @else
                        N/A
                    @endif
                </strong></span>
            </div>
            <div class="info-row">
                <span class="info-label">Number of Guests:</span>
                <span class="info-value"><strong>{{ $booking->number_of_guests }} pax</strong></span>
            </div>
            @if($booking->additional_notes)
            <div class="additional-notes">
                <strong>Additional Notes:</strong><br>
                {{ $booking->additional_notes }}
            </div>
            @endif
        </div>
        
        @if($booking->amount_paid || $booking->down_payment_amount)
        <div class="payment-details">
            <h3>💰 Payment Information</h3>
            @if($booking->payment_option === 'full_payment')
                {{-- Show Event Price and Amount Paid for full payment --}}
                @if($booking->eventType)
                <div class="info-row">
                    <span class="info-label">Event Price:</span>
                    <span class="info-value"><strong>₱{{ number_format($booking->eventType->price, 2) }}</strong></span>
                </div>
                @endif
                @if($booking->amount_paid)
                <div class="info-row">
                    <span class="info-label">Amount Paid:</span>
                    <span class="info-value"><strong>₱{{ number_format($booking->amount_paid, 2) }}</strong></span>
                </div>
                @endif
            @else
                {{-- Show Down Payment and Amount Paid for down payment --}}
                <div class="info-row">
                    <span class="info-label">Down Payment:</span>
                    <span class="info-value"><strong>₱{{ number_format($booking->down_payment_amount, 2) }}</strong></span>
                </div>
                @if($booking->amount_paid)
                <div class="info-row">
                    <span class="info-label">Amount Paid:</span>
                    <span class="info-value"><strong>₱{{ number_format($booking->amount_paid, 2) }}</strong></span>
                </div>
                @endif
            @endif
            @if($booking->gcash_reference_number)
            <div class="info-row">
                <span class="info-label">GCash Reference:</span>
                <span class="info-value"><strong>{{ $booking->gcash_reference_number }}</strong></span>
            </div>
            @endif
            @if($booking->gcash_transaction_id)
            <div class="info-row">
                <span class="info-label">Transaction ID:</span>
                <span class="info-value"><strong>{{ $booking->gcash_transaction_id }}</strong></span>
            </div>
            @endif
            @if($booking->gcash_payment_date)
            <div class="info-row">
                <span class="info-label">Payment Date:</span>
                <span class="info-value"><strong>{{ $booking->gcash_payment_date->format('F d, Y h:i A') }}</strong></span>
            </div>
            @endif
        </div>
        @endif
        
        <div class="receipt-footer">
            <p style="margin-bottom: 5px;"><strong>Thank you for booking with us!</strong></p>
            <p style="margin-bottom: 5px;">We'll contact you soon to confirm the final details of your event.</p>
            <p style="margin-top: 8px; margin-bottom: 5px;">This is a computer-generated receipt. No signature required.</p>
            <p style="margin-top: 5px;">Generated on {{ now()->format('F d, Y \a\t h:i A') }}</p>
        </div>
        </div>
        <!-- End of download content -->
    </div>
    
    <script>
        // Download as PDF function
        function downloadAsPDF() {
            // Get only the download content (reservation details + footer)
            const element = document.querySelector('#download-content');
            const receiptId = '{{ str_pad($booking->id, 6, "0", STR_PAD_LEFT) }}';
            const filename = 'Event_Booking_Receipt_' + receiptId + '.pdf';
            
            // Configure PDF options for single page (bond paper size: 8.5" x 11" or A4)
            const opt = {
                margin: [5, 5, 5, 5], // Reduced margins
                filename: filename,
                image: { type: 'jpeg', quality: 0.95 },
                html2canvas: { 
                    scale: 1.5, // Reduced scale for smaller file and better fit
                    useCORS: true,
                    letterRendering: true,
                    logging: false
                },
                jsPDF: { 
                    unit: 'mm', 
                    format: 'letter', // Letter size (8.5" x 11") - standard bond paper
                    orientation: 'portrait',
                    compress: true
                },
                pagebreak: { mode: ['avoid-all', 'css', 'legacy'] } // Prevent page breaks
            };
            
            // Generate and download PDF
            html2pdf().set(opt).from(element).save();
        }
    </script>
</body>
</html>

