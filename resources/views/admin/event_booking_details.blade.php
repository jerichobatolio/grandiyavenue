<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('admin.css')
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .booking-details-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            margin: 20px;
            padding: 30px;
            min-height: 80vh;
        }

        .page-title {
            color: #2c3e50;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
            background: linear-gradient(45deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .booking-card {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .booking-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e9ecef;
        }

        .customer-info h3 {
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .status-badge {
            padding: 12px 24px;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
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

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }

        .info-section {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .info-section h4 {
            color: #495057;
            margin-bottom: 20px;
            font-size: 1.2rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f1f3f4;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #6c757d;
        }

        .info-value {
            color: #2c3e50;
            font-weight: 500;
        }

        .notes-section {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }

        .notes-content {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
            font-style: italic;
            color: #495057;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 12px 24px;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-back {
            background: #6c757d;
            color: white;
        }

        .btn-status {
            background: #28a745;
            color: white;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn-accept {
            background: #28a745;
            color: white;
        }

        .btn-cancel {
            background: #dc3545;
            color: white;
        }

        .btn-paid {
            background: #17a2b8;
            color: white;
        }

        .btn-complete {
            background: #6f42c1;
            color: white;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .payment-proof {
            text-align: center;
            margin-top: 20px;
        }

        .payment-proof img {
            max-width: 100%;
            max-height: 400px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .no-payment-proof {
            background: #f8f9fa;
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            color: #6c757d;
        }

        .payment-proof-image {
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .payment-proof-image:hover {
            transform: scale(1.02);
        }

        .payment-proof-buttons {
            margin-top: 15px;
        }

        .payment-proof-buttons .btn {
            margin-right: 10px;
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            .booking-details-container {
                margin: 10px;
                padding: 20px;
            }

            .page-title {
                font-size: 2rem;
            }

            .booking-header {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .payment-proof-buttons .btn {
                width: 100%;
                margin-right: 0;
            }
        }
    </style>
</head>
<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <div class="booking-details-container">
                    <h1 class="page-title">🎉 Event Booking Details</h1>
                    
                    <!-- Success/Error Messages -->
                    @if(session('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            ✅ {{ session('message') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            ❌ {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="booking-card">
                        <div class="booking-header">
                            <div class="customer-info">
                                <h3>{{ $booking->full_name }}</h3>
                                <p class="text-muted mb-0">{{ $booking->email }}</p>
                            </div>
                            <span class="status-badge status-{{ strtolower($booking->status) }}">
                                {{ $booking->status }}
                            </span>
                        </div>

                        <div class="info-grid">
                            <!-- Event Information -->
                            <div class="info-section">
                                <h4><i class="fas fa-calendar-alt"></i> Event Information</h4>
                                <div class="info-item">
                                    <span class="info-label">Event Type:</span>
                                    <span class="info-value">{{ $booking->event_type_name }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Venue Type:</span>
                                    <span class="info-value">
                                        @if($booking->venueType)
                                            {{ $booking->venueType->name }}
                                            @if($booking->venueType->capacity)
                                                <span class="badge bg-info ms-2">{{ $booking->venueType->capacity }} capacity</span>
                                            @endif
                                        @else
                                            <span class="text-muted">Not specified</span>
                                        @endif
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Event Date:</span>
                                    <span class="info-value">{{ $booking->event_date->format('F d, Y') }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Time Slot:</span>
                                    <span class="info-value">
                                        @if(!$booking->time_in && !$booking->time_out)
                                            <span class="text-muted">Whole day</span>
                                        @elseif($booking->time_in && $booking->time_out)
                                            {{ $booking->time_in->format('g:i A') }} – {{ $booking->time_out->format('g:i A') }}
                                        @elseif($booking->time_in)
                                            {{ $booking->time_in->format('g:i A') }}
                                        @else
                                            <span class="text-muted">Not set</span>
                                        @endif
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Number of Guests:</span>
                                    <span class="info-value">
                                        {{ $booking->number_of_guests }}
                                        @if($booking->event_type_capacity)
                                            <span class="badge {{ $booking->number_of_guests > $booking->event_type_capacity ? 'bg-danger' : 'bg-success' }} ms-2">
                                                /{{ $booking->event_type_capacity }} capacity
                                            </span>
                                        @endif
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Package Inclusion:</span>
                                    <span class="info-value">
                                        @if($booking->packageInclusion)
                                            @php
                                                $inclusion = $booking->packageInclusion;
                                                $minPax = $inclusion->pax_min;
                                                $maxPax = $inclusion->pax_max;
                                                $price = $inclusion->price;
                                            @endphp
                                            <div>
                                                <strong>{{ $inclusion->name }}</strong>
                                                @if(!is_null($price))
                                                    <span class="badge bg-success ms-2">
                                                        ₱{{ number_format((float) $price, 2) }}
                                                    </span>
                                                @endif
                                                @if(!is_null($minPax) || !is_null($maxPax))
                                                    <span class="badge bg-info ms-2">
                                                        @if(!is_null($minPax) && !is_null($maxPax))
                                                            {{ $minPax }}–{{ $maxPax }} pax
                                                        @elseif(!is_null($minPax))
                                                            {{ $minPax }} pax
                                                        @else
                                                            {{ $maxPax }} pax
                                                        @endif
                                                    </span>
                                                @endif
                                            </div>
                                            @if(!empty($inclusion->details))
                                                <div class="mt-1 text-muted" style="font-size: 0.9rem; white-space: pre-line;">
                                                    {{ $inclusion->details }}
                                                </div>
                                            @endif
                                        @else
                                            <span class="text-muted">Not selected</span>
                                        @endif
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Booking Date:</span>
                                    <span class="info-value">{{ $booking->created_at->format('F d, Y \a\t g:i A') }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Food Package:</span>
                                    <span class="info-value">
                                        @php
                                            $foodItems = $booking->selected_food_items;
                                            if (is_string($foodItems)) {
                                                $decoded = json_decode($foodItems, true);
                                                $foodItems = is_array($decoded) ? $decoded : [];
                                            }
                                        @endphp
                                        @if(is_array($foodItems) && count($foodItems) > 0)
                                            {{ implode(', ', $foodItems) }}
                                        @else
                                            <span class="text-muted">Not specified</span>
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="info-section">
                                <h4><i class="fas fa-user"></i> Contact Information</h4>
                                <div class="info-item">
                                    <span class="info-label">Full Name:</span>
                                    <span class="info-value">{{ $booking->full_name }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Email:</span>
                                    <span class="info-value">{{ $booking->email }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Contact Number:</span>
                                    <span class="info-value">{{ $booking->contact_number }}</span>
                                </div>
                            </div>

                            <!-- Payment Information -->
                            <div class="info-section">
                            <h4><i class="fas fa-credit-card"></i> Payment Information</h4>
                                @php
                                // Pricing: strictly use the selected Package Inclusion's price as full payment
                                $packagePrice = optional($booking->packageInclusion)->price;
                                $totalEventCost = $packagePrice;
                                @endphp
                                @if(!is_null($totalEventCost))
                                <div class="info-item">
                                    <span class="info-label">Total Event Cost:</span>
                                    <span class="info-value">₱{{ number_format($totalEventCost, 2) }}</span>
                                </div>
                                @endif
                                @if(!is_null($booking->amount_paid))
                                <div class="info-item">
                                    <span class="info-label">Amount Paid:</span>
                                    <span class="info-value">₱{{ number_format($booking->amount_paid, 2) }}</span>
                                </div>
                                @endif
                                <div class="info-item">
                                    <span class="info-label">Accepted Payment:</span>
                                    <span class="info-value">GCash Payment</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Payment Status:</span>
                                    <span class="info-value">
                                        @if($booking->payment_proof_path)
                                            <span class="badge bg-success">GCash Proof Uploaded</span>
                                        @else
                                            <span class="badge bg-warning">No GCash Proof</span>
                                        @endif
                                    </span>
                                </div>
                                @if($booking->hasGcashPaymentDetails())
                                <div class="info-item">
                                    <span class="info-label">GCash Reference:</span>
                                    <span class="info-value">{{ $booking->gcash_reference_number }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Transaction ID:</span>
                                    <span class="info-value">{{ $booking->gcash_transaction_id }}</span>
                                </div>
                                @if($booking->gcash_payment_date)
                                <div class="info-item">
                                    <span class="info-label">Payment Date:</span>
                                    <span class="info-value">{{ $booking->gcash_payment_date->format('F d, Y \a\t g:i A') }}</span>
                                </div>
                                @endif
                                @endif
                                @if($booking->payment_confirmed_at)
                                <div class="info-item">
                                    <span class="info-label">Payment Confirmed:</span>
                                    <span class="info-value">{{ $booking->payment_confirmed_at->format('F d, Y \a\t g:i A') }}</span>
                                </div>
                                @endif
                            </div>

                            <!-- Booking Status -->
                            <div class="info-section">
                                <h4><i class="fas fa-info-circle"></i> Booking Status</h4>
                                <div class="info-item">
                                    <span class="info-label">Current Status:</span>
                                    <span class="info-value">
                                        <span class="status-badge status-{{ strtolower($booking->status) }}">
                                            {{ $booking->status }}
                                        </span>
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Booking ID:</span>
                                    <span class="info-value">#{{ $booking->id }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Last Updated:</span>
                                    <span class="info-value">{{ $booking->updated_at->format('F d, Y \a\t g:i A') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Notes -->
                        @php
                            $cleanNotes = null;
                            if (!empty($booking->additional_notes)) {
                                $lines = preg_split('/\r\n|\r|\n/', $booking->additional_notes);
                                $lines = array_filter($lines, function ($line) {
                                    return stripos($line, 'Cancelled by customer on') !== 0;
                                });
                                $cleanNotes = trim(implode(PHP_EOL, $lines));
                            }
                        @endphp
                        @if($cleanNotes)
                        <div class="notes-section">
                            <h4><i class="fas fa-sticky-note"></i> Additional Notes</h4>
                            <div class="notes-content">
                                {{ $cleanNotes }}
                            </div>
                        </div>
                        @endif

                        <!-- Payment Proof -->
                        <div class="info-section">
                            <h4><i class="fa fa-receipt"></i> GCash Payment Proof</h4>
                            @if($booking->payment_proof_path)
                                <div class="payment-proof">
                                    <img src="{{ Storage::url($booking->payment_proof_path) }}" 
                                         alt="Payment Proof" 
                                         class="img-fluid payment-proof-image" 
                                         style="max-height: 400px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);"
                                         onclick="viewPaymentProofLarge('{{ Storage::url($booking->payment_proof_path) }}', '{{ $booking->full_name }}')">
                                    <div class="payment-proof-buttons">
                                        <a href="{{ Storage::url($booking->payment_proof_path) }}" 
                                           class="btn btn-primary" 
                                           download="gcash_proof_{{ $booking->id }}.jpg">
                                            <i class="fa fa-download"></i> Download GCash Proof
                                        </a>
                                        <button class="btn btn-info" 
                                                onclick="viewPaymentProofLarge('{{ Storage::url($booking->payment_proof_path) }}', '{{ $booking->full_name }}')">
                                            <i class="fa fa-expand"></i> View Full Size
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="no-payment-proof">
                                    <i class="fa fa-receipt fa-3x mb-3"></i>
                                    <p>No GCash payment proof uploaded yet</p>
                                </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <a href="{{ route('admin.event_bookings') }}" class="btn-action btn-back">
                                <i class="fas fa-arrow-left"></i> Back to Bookings
                            </a>
                            
                            @if($booking->status === 'Pending')
                                <button class="btn-action btn-mark-paid" onclick="markAsPaidAndAccept({{ $booking->id }})">
                                    <i class="fas fa-check-circle"></i> Accept & Mark Paid
                                </button>
                                <button class="btn-action btn-cancel" onclick="cancelBooking({{ $booking->id }})">
                                    <i class="fas fa-times"></i> Cancel Booking
                                </button>
                            @endif
                            
                            <button class="btn-action btn-status" onclick="updateStatus({{ $booking->id }}, '{{ $booking->status }}')">
                                <i class="fas fa-edit"></i> Update Status
                            </button>
                            <a href="{{ route('admin.event_booking.delete', $booking->id) }}" 
                               class="btn-action btn-delete"
                               onclick="return confirm('Are you sure you want to delete this event booking?')">
                                <i class="fas fa-trash"></i> Delete Booking
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Update Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Event Booking Status</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="statusForm">
                        @csrf
                        <div class="form-group">
                            <label for="statusSelect">Select New Status:</label>
                            <select class="form-control" id="statusSelect" name="status" required>
                                <option value="Pending">⏳ Pending</option>
                                <option value="Paid">💰 Paid</option>
                                <option value="Cancelled">❌ Cancelled (Cancel Booking)</option>
                            </select>
                        </div>
                        <div class="alert alert-info">
                            <strong>Quick Actions:</strong><br>
                            • <strong>Paid</strong> - Mark payment as received<br>
                            • <strong>Cancelled</strong> - Cancel the booking
                        </div>
                        <input type="hidden" id="bookingId" name="booking_id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="submitStatusUpdate()">Update Status</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Proof Large Modal -->
    <div class="modal fade" id="paymentProofLargeModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Payment Proof - <span id="customerNameLarge"></span></h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="paymentProofImageLarge" src="" alt="Payment Proof" class="img-fluid" style="max-height: 80vh; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a id="downloadProofLarge" href="" class="btn btn-primary" download>
                        <i class="fa fa-download"></i> Download
                    </a>
                </div>
            </div>
        </div>
    </div>

    @include('admin.js')
    <script>
        // Status update functionality
        function updateStatus(bookingId, currentStatus) {
            document.getElementById('bookingId').value = bookingId;
            const statusSelect = document.getElementById('statusSelect');
            statusSelect.value = currentStatus;

            // Once a booking is accepted and marked as Paid,
            // do not allow it to be cancelled via the status modal.
            Array.from(statusSelect.options).forEach(opt => {
                opt.disabled = false;
            });
            if (currentStatus === 'Paid') {
                Array.from(statusSelect.options).forEach(opt => {
                    if (opt.value === 'Cancelled') {
                        opt.disabled = true;
                    }
                });
            }
            
            $('#statusModal').modal('show');
        }

        function submitStatusUpdate() {
            const bookingId = document.getElementById('bookingId').value;
            const newStatus = document.getElementById('statusSelect').value;
            
            fetch(`/event_booking/status/${bookingId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    status: newStatus
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error updating status: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating status');
            });
        }

        // Payment proof large viewing functionality
        function viewPaymentProofLarge(imageUrl, customerName) {
            document.getElementById('customerNameLarge').textContent = customerName;
            document.getElementById('paymentProofImageLarge').src = imageUrl;
            document.getElementById('downloadProofLarge').href = imageUrl;
            $('#paymentProofLargeModal').modal('show');
        }


        // Cancel booking functionality
        function cancelBooking(bookingId) {
            if (confirm('Are you sure you want to cancel this booking?')) {
                updateBookingStatus(bookingId, 'Cancelled');
            }
        }

        // Mark as paid functionality
        function markAsPaid(bookingId) {
            if (confirm('Are you sure you want to mark this booking as paid?')) {
                updateBookingStatus(bookingId, 'Paid');
            }
        }


        // Generic status update function
        function updateBookingStatus(bookingId, newStatus) {
            fetch(`/event_booking/status/${bookingId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    status: newStatus
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error updating status: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating status');
            });
        }
    </script>
</body>
</html>
