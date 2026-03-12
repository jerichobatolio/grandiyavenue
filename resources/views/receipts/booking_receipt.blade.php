<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png" href="{{ asset('assets/imgs/logo.png') }}">

    <title>Booking Receipt</title>
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
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .receipt-header {
            text-align: center;
            border-bottom: 3px solid #28a745;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .receipt-header h1 {
            color: #28a745;
            font-size: 32px;
            margin-bottom: 10px;
        }
        
        .receipt-header p {
            color: #666;
            font-size: 14px;
        }
        
        .receipt-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .info-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
        }
        
        .info-section h3 {
            color: #333;
            font-size: 18px;
            margin-bottom: 15px;
            border-bottom: 2px solid #28a745;
            padding-bottom: 8px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 8px 0;
            border-bottom: 1px dotted #ddd;
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
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 30px;
            border-left: 5px solid #28a745;
        }
        
        .booking-details h3 {
            color: #2e7d32;
            font-size: 20px;
            margin-bottom: 20px;
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
        
        .status-approved {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .receipt-footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #ddd;
            color: #666;
            font-size: 12px;
        }
        
        .receipt-id {
            background: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            margin-bottom: 20px;
            font-weight: 600;
            font-size: 16px;
        }
        
        .print-button {
            text-align: center;
            margin-bottom: 20px;
            display: flex;
            gap: 15px;
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
            transition: background-color 0.3s ease;
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
            transition: background-color 0.3s ease;
        }
        
        .btn-back:hover {
            background-color: #5a6268;
            color: white;
            text-decoration: none;
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
        
        .special-requests {
            background: #fff9e6;
            padding: 15px;
            border-radius: 5px;
            margin-top: 15px;
            border-left: 3px solid #ffc107;
        }
        
        .special-requests strong {
            color: #856404;
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
        <div class="booking-details">
            <h3>📅 Reservation Details</h3>
            <div class="info-row">
                <span class="info-label">Table Number:</span>
                <span class="info-value"><strong>{{ $booking->table_number }}</strong></span>
            </div>
            @if($booking->table_section)
            <div class="info-row">
                <span class="info-label">Section:</span>
                <span class="info-value"><strong>{{ $booking->table_section }}</strong></span>
            </div>
            @endif
            <div class="info-row">
                <span class="info-label">Reservation Date:</span>
                <span class="info-value"><strong>{{ $booking->date->format('F d, Y') }}</strong></span>
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
                <span class="info-label">Number of Guests:</span>
                <span class="info-value"><strong>{{ $booking->guest }} {{ $booking->guest == 1 ? 'Guest' : 'Guests' }}</strong></span>
            </div>
            <div class="info-row">
                <span class="info-label">Occasion:</span>
                <span class="info-value"><strong>{{ ucfirst($booking->occasion ?? 'Casual Dining') }}</strong></span>
            </div>
            @if($booking->special_requests)
            <div class="special-requests">
                <strong>Special Requests:</strong><br>
                {{ $booking->special_requests }}
            </div>
            @endif
        </div>
        
        <div class="receipt-footer">
            <p><strong>Thank you for your reservation!</strong></p>
            <p>Please arrive on time for your booking. If you need to make changes, please contact us.</p>
            <p style="margin-top: 15px;">This is a computer-generated receipt. No signature required.</p>
            <p style="margin-top: 10px; font-size: 11px;">Generated on {{ now()->format('F d, Y \a\t h:i A') }}</p>
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
            const filename = 'Booking_Receipt_' + receiptId + '.pdf';
            
            // Configure PDF options
            const opt = {
                margin: [10, 10, 10, 10],
                filename: filename,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { 
                    scale: 2,
                    useCORS: true,
                    letterRendering: true
                },
                jsPDF: { 
                    unit: 'mm', 
                    format: 'a4', 
                    orientation: 'portrait' 
                }
            };
            
            // Generate and download PDF, then redirect to homepage
            html2pdf().set(opt).from(element).save().then(function() {
                // Wait a moment for the download to complete, then redirect
                setTimeout(function() {
                    window.location.href = '{{ url("/home") }}';
                }, 1000);
            }).catch(function(error) {
                console.error('PDF generation error:', error);
                // Even if there's an error, still redirect after a delay
                setTimeout(function() {
                    window.location.href = '{{ url("/home") }}';
                }, 2000);
            });
        }
    </script>
</body>
</html>

