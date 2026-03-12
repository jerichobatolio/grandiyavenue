<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Book Event | Grandiya Venue & Restaurant</title>
    
    @include('home.css')
    
    @php
        use Illuminate\Support\Facades\Storage;
    @endphp
    
    <style>
        body {
            background-color: #343a40;
            color: white;
            font-family: Arial, sans-serif;
        }
        
        .container {
            margin-top: 100px;
            margin-bottom: 50px;
        }
        
        .form-container {
            min-height: 100vh;
            padding: 20px 0;
        }
        
        /* Form styling for dark theme */
        .form-control {
            background-color: #495057;
            border: 1px solid #343a40;
            color: white;
        }
        
        .form-control:focus {
            background-color: #495057;
            border-color: #ff214f;
            color: white;
            box-shadow: 0 0 0 0.2rem rgba(255, 33, 79, 0.25);
        }
        
        .form-control::placeholder {
            color: white;
        }
        
        .form-label {
            color: white;
        }
        
        .card {
            background-color: #495057;
            border: 1px solid #ff214f;
            color: white;
        }
        
        .card-header {
            background: linear-gradient(135deg, #ff214f, #c41e3a);
            border-bottom: 1px solid #ff214f;
        }
        
        .btn-primary {
            background-color: gold;
            border-color: gold;
            color: black;
            font-weight: bold;
        }
        
        .btn-primary:hover {
            background-color: #ffc107;
            border-color: #ffc107;
            color: black;
        }
        
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        
        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: black;
        }
        
        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }
        
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        
        .modal-content {
            background-color: #495057;
            border: 1px solid #ff214f;
        }
        
        .modal-header {
            border-bottom: 1px solid #343a40;
        }
        
        .modal-body {
            color: white;
        }
        
        .modal-footer {
            border-top: 1px solid #343a40;
        }
        
        .alert {
            background-color: #495057;
            border: 1px solid #343a40;
            color: white;
        }
        
        .alert-success {
            background-color: #1e4d2b;
            border-color: #28a745;
        }
        
        .alert-warning {
            background-color: #4d3a00;
            border-color: #ffc107;
        }
        
        .alert-info {
            background-color: #0c5460;
            border-color: #17a2b8;
        }
        
        .alert-danger {
            background-color: #4d1a1a;
            border-color: #dc3545;
        }
        
        .text-muted,
        .form-text.text-muted,
        small.text-muted,
        span.text-muted {
            color: #e0e0e0 !important;
            font-weight: 600 !important;
            font-size: 0.95rem;
        }
        
        .modal-content .text-muted,
        .modal-content .form-text.text-muted,
        .modal-content small.text-muted {
            color: #e0e0e0 !important;
            font-weight: 600 !important;
        }
        
        .modal-body p,
        .modal-body span,
        .modal-body li {
            color: white !important;
            font-weight: 500;
        }
        
        .text-muted-original {
            color: white !important;
        }
        
        .text-white {
            color: white !important;
        }
        
        .text-dark {
            color: white !important;
        }
        
        .text-success {
            color: white !important;
        }
        
        .text-warning {
            color: white !important;
        }
        
        .text-danger {
            color: white !important;
        }
        
        .text-info {
            color: white !important;
        }
        
        .bg-primary {
            background-color: #007bff !important;
        }
        
        .bg-success {
            background-color: #28a745 !important;
        }
        
        .bg-warning {
            background-color: #ffc107 !important;
        }
        
        .bg-info {
            background-color: #17a2b8 !important;
        }
        
        .bg-danger {
            background-color: #dc3545 !important;
        }
        
        .bg-secondary {
            background-color: #6c757d !important;
        }
        
        .badge {
            color: white;
        }
        
        .table {
            color: white;
        }
        
        .table th {
            border-color: #343a40;
        }
        
        .table td {
            border-color: #343a40;
        }
        
        /* Ensure all text elements are white */
        h1, h2, h3, h4, h5, h6 {
            color: white !important;
        }
        
        p, span, div, a, li, ul, ol {
            color: white !important;
        }
        
        .form-text, .form-help {
            color: white !important;
        }
        
        .small, small {
            color: white !important;
        }
        
        .lead {
            color: white !important;
        }
        
        .display-1, .display-2, .display-3, .display-4 {
            color: white !important;
        }
    </style>
</head>
<body>
<div class="form-container">
    <style>
        .form-container h2 {
            color: white !important;
        }
        .form-container .form-label {
            color: white !important;
        }
    </style>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h2 class="mb-0" style="color: white !important;">Book Your Special Event</h2>
                        <p class="mb-0">Create unforgettable memories with us</p>
                    </div>
                    <div class="card-body p-4">
                        <!-- Event Booking Form -->
                        @php
                            $user = auth()->user();
                            $defaultFullName = $user ? trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) : '';
                            if (!$defaultFullName && $user && !empty($user->name)) {
                                $defaultFullName = $user->name;
                            }
                            $defaultContactNumber = $user ? ($user->phone ?? '') : '';
                            $defaultEmail = $user ? ($user->email ?? '') : '';
                        @endphp
                        <form id="eventBookingForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="full_name" class="form-label" style="color: white !important;">Full Name *</label>
                                    <input type="text"
                                           class="form-control"
                                           id="full_name"
                                           name="full_name"
                                           value="{{ old('full_name', $defaultFullName) }}"
                                           required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="contact_number" class="form-label" style="color: white !important;">Contact Number *</label>
                                    <input type="tel"
                                           class="form-control"
                                           id="contact_number"
                                           name="contact_number"
                                           value="{{ old('contact_number', $defaultContactNumber) }}"
                                           pattern="\d{11}"
                                           maxlength="11"
                                           placeholder="09XXXXXXXXX"
                                           title="Enter exactly 11 digits"
                                           required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label" style="color: white !important;">Email Address *</label>
                                <input type="email"
                                       class="form-control"
                                       id="email"
                                       name="email"
                                       value="{{ old('email', $defaultEmail) }}"
                                       required>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="event_date" class="form-label" style="color: white !important;">Event Date *</label>
                                    <input type="date" class="form-control" id="event_date" name="event_date" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="event_type_id" class="form-label" style="color: white !important;">Event Type *</label>
                                <select class="form-control" id="event_type_id" name="event_type_id" required>
                                    <option value="">Select Event Type</option>
                                    @if(isset($eventTypes) && $eventTypes->count() > 0)
                                        @foreach($eventTypes as $eventType)
                                            <option value="{{ $eventType->id }}"
                                                    data-price="{{ $eventType->price }}"
                                                    data-down-payment="{{ $eventType->down_payment }}"
                                                    data-description="{{ $eventType->description }}">
                                                {{ $eventType->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="venue_type" class="form-label" style="color: white !important;">Venue Type *</label>
                                <select class="form-control" id="venue_type" name="venue_type_id" required>
                                    <option value="">Select Venue Type</option>
                                    @if(isset($venueTypes) && $venueTypes->count() > 0)
                                        @foreach($venueTypes as $venueType)
                                            <option value="{{ $venueType->id }}"
                                                    data-capacity="{{ $venueType->capacity }}"
                                                    data-description="{{ $venueType->description }}">
                                                {{ $venueType->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <!-- Food Package Items (view-only from admin Food Package Management) -->
                            <div class="mb-3">
                                <label class="form-label" style="color: white !important;">Food Package</label>
                                <div class="form-control" style="background-color: #495057; border: 1px solid #343a40; color: white;" readonly>
                                    @if(isset($foodPackageItems) && $foodPackageItems->count() > 0)
                                        <ul class="mb-0" style="padding-left: 18px;">
                                            @foreach($foodPackageItems as $item)
                                                <li>{{ $item->name }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span>No food package items configured by admin.</span>
                                    @endif
                                </div>
                                <small class="text-muted d-block mt-1">
                                    These items (e.g., chicken, vegetable, unlimited plain rice) are configured by the admin and will be arranged with our staff after your booking.
                                </small>
                            </div>
                            
                            <div class="mb-4">
                                <label for="additional_notes" class="form-label" style="color: white !important;">Additional Notes</label>
                                <textarea class="form-control" id="additional_notes" name="additional_notes" rows="3" placeholder="Any special requirements or requests..."></textarea>
                            </div>
                            
                            <div class="text-center">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Complete all fields above to book your event
                                </div>
                                <button type="button" class="btn btn-primary btn-lg mt-3" id="bookEventBtn" disabled style="background-color: #6c757d; border-color: #6c757d; color: white; font-weight: bold; padding: 12px 30px;" title="Complete all fields to book your event">
                                    Complete Form to Book
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Booking Summary Modal -->
<div class="modal fade" id="bookingSummaryModal" tabindex="-1" aria-labelledby="bookingSummaryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="bookingSummaryModalLabel">📋 Booking Summary</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                <div class="row">
                    <div class="col-md-6">
                        <h6>👤 Contact Information</h6>
                        <p style="word-wrap: break-word; overflow-wrap: break-word; white-space: normal;"><strong>Name:</strong> <span id="summary_name"></span></p>
                        <p style="word-wrap: break-word; overflow-wrap: break-word; white-space: normal;"><strong>Contact:</strong> <span id="summary_contact"></span></p>
                        <p style="word-wrap: break-word; overflow-wrap: break-word; white-space: normal;"><strong>Email:</strong> <span id="summary_email"></span></p>
                    </div>
                    <div class="col-md-6">
                        <h6>🎉 Event Details</h6>
                        <p style="word-wrap: break-word; overflow-wrap: break-word; white-space: normal;"><strong>Event Type:</strong> <span id="summary_event_type"></span></p>
                        <p style="word-wrap: break-word; overflow-wrap: break-word; white-space: normal;"><strong>Package Inclusion:</strong> <span id="summary_package_inclusion"></span></p>
                        <p style="word-wrap: break-word; overflow-wrap: break-word; white-space: normal;"><strong>Date:</strong> <span id="summary_event_date"></span></p>
                    </div>
                </div>
                <div class="mt-3">
                    <h6>📝 Additional Notes</h6>
                    <p id="summary_notes" class="text-muted" style="word-wrap: break-word; overflow-wrap: break-word; white-space: normal; max-width: 100%;"></p>
                </div>
                <div class="alert alert-info" id="payment-info-section" style="display: none;">
                    <h6>💰 GCash Payment Information</h6>
                    <p class="mb-1" style="word-wrap: break-word; overflow-wrap: break-word; white-space: normal;"><strong>Full Payment Amount:</strong> <span id="summary_down_payment">₱2,000.00</span></p>
                    <p class="mb-1" style="word-wrap: break-word; overflow-wrap: break-word; white-space: normal;"><strong>Total Event Cost:</strong> <span id="summary_total_price" style="display: none;">₱4,000.00</span></p>
                    <small class="text-muted" style="word-wrap: break-word; overflow-wrap: break-word; white-space: normal;">Full payment must be made via GCash only. Upload your GCash transaction receipt as proof.</small>
                </div>
                
                <!-- Terms & Conditions Section -->
                <hr class="my-4">
                <h6 class="text-warning">📋 Terms & Conditions</h6>
                <div class="mb-3">
                    <h6>💰 GCash Payment Terms</h6>
                    <ul>
                        <li>Full payment required to confirm your booking</li>
                        <li>Payment must be made via GCash only - no other payment methods accepted</li>
                        <li>Upload your GCash transaction receipt as proof of payment</li>
                        <li>Payment must be completed before the event date</li>
                    </ul>
                </div>
                
                <div class="mb-3">
                    <h6>❌ Cancellation Policy</h6>
                    <ul>
                        <li>Free cancellation up to 7 days before the event</li>
                        <li>50% refund for cancellations 3-7 days before the event</li>
                        <li>No refund for cancellations within 3 days of the event</li>
                        <li>Payment is non-refundable 3 days before the event</li>
                    </ul>
                </div>
                
                <div class="mb-3">
                    <h6>Event Guidelines</h6>
                    <ul>
                        <li>Event time must be confirmed 48 hours in advance</li>
                        <li>Any changes to guest count must be communicated 24 hours before</li>
                        <li>Additional charges may apply for extra services</li>
                        <li>Venue damage charges will be applied if applicable</li>
                    </ul>
                </div>
                
                <div class="form-check mt-4 p-3" style="background-color: #495057; border: 1px solid #343a40; border-radius: 5px;">
                    <input class="form-check-input" type="checkbox" id="agreeTermsSummary" required style="transform: scale(1.2);">
                    <label class="form-check-label fw-bold" for="agreeTermsSummary" style="font-size: 1.1em;">
                        ✅ I agree to the Terms & Conditions and understand the payment and cancellation policies
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Edit Booking</button>
                <button type="button" class="btn btn-primary" id="proceedToPaymentBtn" disabled style="background-color: gold; border-color: gold; color: black;">✓ Check Box Above to Continue to Payment</button>
            </div>
        </div>
    </div>
</div>

<!-- Terms & Conditions Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="termsModalLabel">📋 Terms & Conditions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                <h6>📋 Booking Terms & Conditions</h6>
                <div class="mb-3">
                    <h6>💰 GCash Payment Terms</h6>
                    <ul>
                        <li>Full payment required to confirm your booking</li>
                        <li>Payment must be made via GCash only - no other payment methods accepted</li>
                        <li>Upload your GCash transaction receipt as proof of payment</li>
                        <li>Payment must be completed before the event date</li>
                    </ul>
                </div>
                
                <div class="mb-3">
                    <h6>❌ Cancellation Policy</h6>
                    <ul>
                        <li>Free cancellation up to 7 days before the event</li>
                        <li>50% refund for cancellations 3-7 days before the event</li>
                        <li>No refund for cancellations within 3 days of the event</li>
                        <li>Payment is non-refundable 3 days before the event</li>
                    </ul>
                </div>
                
                <div class="mb-3">
                    <h6>Event Guidelines</h6>
                    <ul>
                        <li>Event time must be confirmed 48 hours in advance</li>
                        <li>Any changes to guest count must be communicated 24 hours before</li>
                        <li>Additional charges may apply for extra services</li>
                        <li>Venue damage charges will be applied if applicable</li>
                    </ul>
                </div>
                
                <div class="mb-3">
                    <h6>📞 Contact Information</h6>
                    <p>For any questions or concerns, please contact us at:</p>
                    <ul>
                        <li>Phone: (02) 123-4567</li>
                        <li>Email: events@grandiya.com</li>
                        <li>Address: Grandiya Street, City Center</li>
                    </ul>
                </div>
                
                <div class="form-check mt-4 p-3" style="background-color: #495057; border: 1px solid #343a40; border-radius: 5px;">
                    <input class="form-check-input" type="checkbox" id="agreeTerms" required style="transform: scale(1.2);">
                    <label class="form-check-label fw-bold" for="agreeTerms" style="font-size: 1.1em;">
                        ✅ I agree to the Terms & Conditions and understand the payment and cancellation policies
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="paymentModalCancelBtn" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="continueToPaymentBtn" disabled>✓ Check Box Above to Continue to Payment</button>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="paymentModalLabel">💳 GCash Payment</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h4>Pay <span id="payment_amount">₱2,000.00</span> via GCash</h4>
                <div class="my-4">
                    @if(isset($globalQrCode) && $globalQrCode)
                        <img id="admin_qr_code" src="{{ Storage::url($globalQrCode) }}" alt="GCash QR Code" class="img-fluid" style="max-width: 300px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>QR Code Not Available</strong><br>
                            Please contact the administrator to set up the payment QR code.
                        </div>
                    @endif
                </div>
                <p class="text-muted">Scan the QR code using your GCash app to complete payment</p>
                <div class="alert alert-warning">
                    <strong>Important:</strong> Please keep your GCash transaction receipt as proof of payment. Only GCash receipts are accepted.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="uploadProofBtn">I've Paid – Upload Proof</button>
            </div>
        </div>
    </div>
</div>

<!-- Payment Proof Upload Modal -->
<div class="modal fade" id="proofUploadModal" tabindex="-1" aria-labelledby="proofUploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="proofUploadModalLabel">📸 Upload GCash Transaction Receipt</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="proofUploadForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="booking_id" name="booking_id">
                    <input type="hidden" name="payment_option" value="full_payment">
                    <div class="mb-3">
                        <label for="payment_proof" class="form-label">Upload GCash Transaction Receipt *</label>
                        <input type="file" class="form-control" id="payment_proof" name="payment_proof" accept="image/jpeg,image/png,image/jpg" required>
                        <div class="form-text">
                            <strong>Important:</strong> Only GCash transaction receipts are accepted. 
                            <br>• Upload a clear screenshot of your GCash payment confirmation
                            <br>• Image must be at least 200x200 pixels
                            <br>• File size must be less than 2MB
                            <br>• Only JPG, PNG, and JPEG formats are allowed
                        </div>
                        <div id="gcash-validation-message" class="alert alert-danger mt-2" style="display: none;">
                            <i class="fas fa-exclamation-triangle"></i> <span id="gcash-error-text"></span>
                        </div>
                        <div id="gcash-success-message" class="alert alert-success mt-2" style="display: none;">
                            <i class="fas fa-check-circle"></i> Image accepted. Admin will verify if this is a valid GCash receipt.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="gcash_reference_number" class="form-label">GCash Reference Number *</label>
                        <input type="text" class="form-control" id="gcash_reference_number" name="gcash_reference_number" placeholder="Enter GCash reference number" required>
                        <div class="form-text">Found in your GCash transaction receipt</div>
                    </div>
                    <div class="mb-3">
                        <label for="gcash_transaction_id" class="form-label">Transaction ID *</label>
                        <input type="text" class="form-control" id="gcash_transaction_id" name="gcash_transaction_id" placeholder="Enter transaction ID" required>
                        <div class="form-text">Found in your GCash transaction receipt</div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Submit GCash Proof</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Final Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="confirmationModalLabel">✅ Booking Confirmed!</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="mb-3">
                    <i class="fas fa-clock text-warning" style="font-size: 4rem;"></i>
                </div>
                <h4 class="text-warning">Payment Submitted for Verification!</h4>
                <p>Your <span id="confirmed_payment_label">Full Payment</span> of <span id="confirmed_payment_amount">₱2,000.00</span> has been submitted and is pending admin verification. Thank you for booking with us.</p>
                <div class="alert alert-info" style="background-color: #ffffff; color: #000000;">
                    <strong class="text-dark">Booking ID:</strong>
                    <span id="confirmed_booking_id" style="color: #28a745; font-weight: 700;"></span><br>
                    <strong class="text-dark">Event Date:</strong>
                    <span id="confirmed_event_date" style="color: #28a745; font-weight: 700;"></span><br>
                    <strong class="text-dark">Event Type:</strong>
                    <span id="confirmed_event_type" style="color: #28a745; font-weight: 700;"></span>
                </div>
                <p class="text-muted">We'll contact you soon to confirm the final details of your event.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="confirmationCloseBtn" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
let currentBooking = null;
let bookingCleanupPending = false;
let navigatingToProofUpload = false;
let bookingFinalized = false;

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 BOOK EVENT - DOM Loaded, initializing...');
    
    // Set minimum date to tomorrow
    const eventDateField = document.getElementById('event_date');
    if (eventDateField) {
        eventDateField.min = new Date(Date.now() + 86400000).toISOString().split('T')[0];
    }
    
    // Get all form elements
    const form = document.getElementById('eventBookingForm');
    const bookEventBtn = document.getElementById('bookEventBtn');
    const agreeTermsSummaryCheckbox = document.getElementById('agreeTermsSummary');
    const proceedToPaymentBtn = document.getElementById('proceedToPaymentBtn');
    const agreeTermsCheckbox = document.getElementById('agreeTerms');
    const continueToPaymentBtn = document.getElementById('continueToPaymentBtn');
    const uploadProofBtn = document.getElementById('uploadProofBtn');
    const proofUploadForm = document.getElementById('proofUploadForm');
    const confirmationCloseBtn = document.getElementById('confirmationCloseBtn');
    const paymentOptionDownLabel = document.getElementById('payment_option_down_amount');
    const paymentOptionFullLabel = document.getElementById('payment_option_full_amount');
    const paymentOptionDownRadio = document.getElementById('payment_option_down');
    const paymentOptionFullRadio = document.getElementById('payment_option_full');
    const DEFAULT_DOWN_PAYMENT = 2000;
    const DEFAULT_FULL_PAYMENT = 4000;
    const paymentModalElement = document.getElementById('paymentModal');
    const proofUploadModalElement = document.getElementById('proofUploadModal');
    const paymentModalCancelBtn = document.getElementById('paymentModalCancelBtn');
    
    // Must match backend validation in EventBookingController@storeBooking
    const requiredFields = [
        'full_name',
        'contact_number',
        'email',
        'event_date',
        'event_type_id',
        'venue_type'
    ];

    function formatCurrency(value) {
        const numericValue = parseFloat(value) || 0;
        return '₱' + numericValue.toLocaleString('en-US', { minimumFractionDigits: 2 });
    }

    function updatePaymentOptionDisplays(downAmountLabel, fullAmountLabel) {
        if (paymentOptionDownLabel && downAmountLabel) {
            paymentOptionDownLabel.textContent = downAmountLabel;
        }
        if (paymentOptionFullLabel && fullAmountLabel) {
            paymentOptionFullLabel.textContent = fullAmountLabel;
        }
    }

    updatePaymentOptionDisplays(formatCurrency(DEFAULT_DOWN_PAYMENT), formatCurrency(DEFAULT_FULL_PAYMENT));

    if (confirmationCloseBtn) {
        confirmationCloseBtn.addEventListener('click', function() {
            window.location.href = '/';
        });
    }

    async function cancelIncompleteBooking(reason = 'user_cancelled') {
        if (!currentBooking || !bookingCleanupPending) {
            return;
        }

        try {
            const response = await fetch('/cancel-booking', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    booking_id: currentBooking.id,
                    reason
                })
            });

            if (!response.ok) {
                console.warn('Failed to cancel incomplete booking', await response.text());
            } else {
                console.log('Incomplete booking cancelled:', reason);
            }
        } catch (error) {
            console.error('Error cancelling booking:', error);
        } finally {
            currentBooking = null;
            bookingCleanupPending = false;
            bookingFinalized = false;
            navigatingToProofUpload = false;
        }
    }

    if (paymentModalCancelBtn) {
        paymentModalCancelBtn.addEventListener('click', function() {
            cancelIncompleteBooking('payment_modal_cancel_button');
        });
    }

    if (paymentModalElement) {
        paymentModalElement.addEventListener('hidden.bs.modal', function() {
            if (currentBooking && bookingCleanupPending && !navigatingToProofUpload && !bookingFinalized) {
                cancelIncompleteBooking('payment_modal_hidden');
            }
        });
    }

    if (proofUploadModalElement) {
        proofUploadModalElement.addEventListener('shown.bs.modal', function() {
            navigatingToProofUpload = false;
        });

        proofUploadModalElement.addEventListener('hidden.bs.modal', function() {
            if (currentBooking && bookingCleanupPending && !bookingFinalized) {
                cancelIncompleteBooking('proof_modal_hidden');
            }
        });
    }
    
    // Enhanced form validation function
    function validateForm() {
        console.log('🔍 Validating form...');
        
        if (!bookEventBtn) {
            console.error('❌  button not found!');
            return false;
        }
        
        let isValid = true;
        let emptyFields = [];
        
        // Check each required field
        requiredFields.forEach(fieldName => {
            const field = document.getElementById(fieldName);
            if (!field) {
                console.error(`❌ Field ${fieldName} not found!`);
                isValid = false;
                emptyFields.push(fieldName + ' (missing)');
            } else {
                const value = field.value.trim();
                if (value === '') {
                    isValid = false;
                    emptyFields.push(fieldName);
                    console.log(`❌ ${fieldName} is empty`);
                } else {
                    console.log(`✅ ${fieldName}: "${value}"`);
                }
            }
        });
        
        // Update button state
        if (isValid) {
            console.log('✅ All fields valid - enabling button');
            bookEventBtn.disabled = false;
            bookEventBtn.textContent = 'Book Event';
            bookEventBtn.className = 'btn btn-primary btn-lg mt-3';
            bookEventBtn.style.backgroundColor = 'gold';
            bookEventBtn.style.borderColor = 'gold';
            bookEventBtn.style.color = 'black';
            bookEventBtn.title = 'Click to book your event';
        } else {
            console.log('❌ Form invalid - disabling button');
            bookEventBtn.disabled = true;
            bookEventBtn.textContent = 'Complete Form to Book';
            bookEventBtn.className = 'btn btn-primary btn-lg mt-3';
            bookEventBtn.style.backgroundColor = '#6c757d';
            bookEventBtn.style.borderColor = '#6c757d';
            bookEventBtn.style.color = 'white';
            bookEventBtn.title = 'Complete all fields to book your event';
        }
        
        console.log('Button state:', {
            disabled: bookEventBtn.disabled,
            text: bookEventBtn.textContent,
            emptyFields: emptyFields
        });
        
        return isValid;
    }
    
    // Add event listeners to all form fields
    function setupFormListeners() {
        console.log('🔧 Setting up form listeners...');
        
        // Add listeners to required fields
        requiredFields.forEach(fieldName => {
            const field = document.getElementById(fieldName);
            if (field) {
                console.log(`📝 Adding listeners to ${fieldName}`);
                
                // Multiple event types to catch all user interactions
                ['input', 'change', 'keyup', 'blur'].forEach(eventType => {
                    field.addEventListener(eventType, function() {
                        console.log(`${eventType} on ${fieldName}: "${this.value}"`);
                        validateForm();
                    });
                });
            } else {
                console.error(`❌ Field ${fieldName} not found for listeners`);
            }
        });
        
    // Add listener to additional notes
    const additionalNotes = document.getElementById('additional_notes');
    if (additionalNotes) {
        additionalNotes.addEventListener('input', validateForm);
    }
    
    // Capacity validation removed (no number of guests field)
        
        console.log('✅ Form listeners setup complete');
    }
    
    // Initialize everything
    function initializeForm() {
        console.log('🚀 Initializing form...');
        
        // Setup listeners
        setupFormListeners();
        
        // Run initial validation
        validateForm();
        
        
        console.log('✅ Form initialization complete');
    }
    
    // Start initialization after a short delay
    setTimeout(initializeForm, 100);
    
    //  Button
    if (bookEventBtn) {
        bookEventBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (bookEventBtn.disabled) {
                return;
            }
            
            // Check if user is authenticated
            fetch('/check-auth', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (!data.authenticated) {
                    alert('Please login to book an event. You will be redirected to the login page.');
                    window.location.href = '/login';
                    return;
                }
                
                const formData = new FormData(form);
                
                // Populate summary modal
                document.getElementById('summary_name').textContent = formData.get('full_name');
                document.getElementById('summary_contact').textContent = formData.get('contact_number');
                document.getElementById('summary_email').textContent = formData.get('email');
                
                // Get selected event type
                const eventTypeSelect = document.getElementById('event_type_id');
                const selectedEventType = eventTypeSelect && eventTypeSelect.selectedIndex >= 0
                    ? eventTypeSelect.options[eventTypeSelect.selectedIndex]
                    : null;
                const eventTypeName = selectedEventType ? selectedEventType.text : 'Custom Event';
                
                document.getElementById('summary_event_type').textContent = eventTypeName;
                document.getElementById('summary_event_date').textContent = formData.get('event_date');
                document.getElementById('summary_notes').textContent = formData.get('additional_notes') || 'None';
                
                // Set payment amounts for venue booking
                const downPaymentLabel = formatCurrency(DEFAULT_DOWN_PAYMENT);
                const fullPaymentLabel = formatCurrency(DEFAULT_FULL_PAYMENT);
                document.getElementById('summary_down_payment').textContent = downPaymentLabel;
                document.getElementById('summary_total_price').textContent = fullPaymentLabel;
                updatePaymentOptionDisplays(downPaymentLabel, fullPaymentLabel);
                
                // Show summary modal
                const summaryModalElement = document.getElementById('bookingSummaryModal');
                const summaryModal = new bootstrap.Modal(summaryModalElement);
                summaryModal.show();
            })
            .catch(error => {
                console.error('Authentication check error:', error);
                alert('Please login to book an event. You will be redirected to the login page.');
                window.location.href = '/login';
            });
        });
    }
    
    // Terms checkbox in summary modal
    if (agreeTermsSummaryCheckbox) {
        agreeTermsSummaryCheckbox.addEventListener('change', function() {
            if (proceedToPaymentBtn) {
                proceedToPaymentBtn.disabled = !this.checked;
                
                if (this.checked) {
                    proceedToPaymentBtn.textContent = '✅ Proceed to Payment';
                    proceedToPaymentBtn.classList.remove('btn-primary');
                    proceedToPaymentBtn.classList.add('btn-success');
                    proceedToPaymentBtn.style.backgroundColor = '#28a745';
                    proceedToPaymentBtn.style.borderColor = '#28a745';
                    proceedToPaymentBtn.style.color = 'white';
                } else {
                    proceedToPaymentBtn.textContent = '✓ Check Box Above to Continue to Payment';
                    proceedToPaymentBtn.classList.remove('btn-success');
                    proceedToPaymentBtn.classList.add('btn-primary');
                    proceedToPaymentBtn.style.backgroundColor = 'gold';
                    proceedToPaymentBtn.style.borderColor = 'gold';
                    proceedToPaymentBtn.style.color = 'black';
                }
            }
        });
    }
    
    // Terms checkbox
    if (agreeTermsCheckbox) {
        agreeTermsCheckbox.addEventListener('change', function() {
            if (continueToPaymentBtn) {
                continueToPaymentBtn.disabled = !this.checked;
                
                if (this.checked) {
                    continueToPaymentBtn.textContent = '✅ Continue to Payment';
                    continueToPaymentBtn.classList.remove('btn-primary');
                    continueToPaymentBtn.classList.add('btn-success');
                    continueToPaymentBtn.style.backgroundColor = '#28a745';
                    continueToPaymentBtn.style.borderColor = '#28a745';
                    continueToPaymentBtn.style.color = 'white';
                } else {
                    continueToPaymentBtn.textContent = '✓ Check Box Above to Continue to Payment';
                    continueToPaymentBtn.classList.remove('btn-success');
                    continueToPaymentBtn.classList.add('btn-primary');
                    continueToPaymentBtn.style.backgroundColor = 'gold';
                    continueToPaymentBtn.style.borderColor = 'gold';
                    continueToPaymentBtn.style.color = 'black';
                }
            }
        });
    }
    
    // Proceed to Payment Button (from summary modal)
    if (proceedToPaymentBtn) {
        proceedToPaymentBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (proceedToPaymentBtn.disabled) {
                return;
            }
            
            const formData = new FormData(form);
            
            // Validate form data before sending (must match backend)
            const requiredFields = [
                'full_name',
                'contact_number',
                'email',
                'event_date',
                'event_type_id',
                'venue_type_id'
            ];
            let missingFields = [];
            
            requiredFields.forEach(fieldName => {
                const value = formData.get(fieldName);
                if (!value || value.trim() === '') {
                    missingFields.push(fieldName);
                }
            });
            
            if (missingFields.length > 0) {
                alert('Please fill in all required fields: ' + missingFields.join(', '));
                return;
            }
            
            fetch('/book-event', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(async response => {
                if (response.status === 401 || response.status === 403) {
                    alert('Please login to book an event. You will be redirected to the login page.');
                    window.location.href = '/login';
                    return null;
                }

                const contentType = response.headers.get('content-type') || '';
                let data = null;
                if (contentType.includes('application/json')) {
                    data = await response.json();
                } else {
                    const text = await response.text();
                    throw new Error('Unexpected response: ' + text);
                }

                if (!response.ok) {
                    throw new Error(data?.message || 'Unable to create booking. Please try another date.');
                }

                return data;
            })
            .then(data => {
                if (!data) return;
                if (data.success) {
                    currentBooking = data.booking;
                    bookingCleanupPending = true;
                    bookingFinalized = false;
                    document.getElementById('booking_id').value = data.booking.id;
                    
                    // Close summary modal
                    const summaryModalElement = document.getElementById('bookingSummaryModal');
                    const summaryModal = bootstrap.Modal.getInstance(summaryModalElement);
                    if (summaryModal) {
                        summaryModal.hide();
                    }
                    
                    // Update payment modal with selected amount
                    const downPaymentLabel = formatCurrency(DEFAULT_DOWN_PAYMENT);
                    const fullPaymentLabel = formatCurrency(DEFAULT_FULL_PAYMENT);
                    document.getElementById('payment_amount').textContent = downPaymentLabel;
                    updatePaymentOptionDisplays(downPaymentLabel, fullPaymentLabel);
                    
                    // Show payment modal
                    const paymentModalElement = document.getElementById('paymentModal');
                    const paymentModal = new bootstrap.Modal(paymentModalElement);
                    paymentModal.show();
                } else {
                    alert('Error creating booking: ' + (data.message || JSON.stringify(data.errors || 'Please try again')));
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                alert(error.message || 'Error creating booking. Please try again.');
            });
        });
    }
    
    // Upload Proof Button
    if (uploadProofBtn) {
        uploadProofBtn.addEventListener('click', function(e) {
            e.preventDefault();
            navigatingToProofUpload = true;
            
            // Close payment modal
            const paymentModal = paymentModalElement ? bootstrap.Modal.getInstance(paymentModalElement) : null;
            if (paymentModal) {
                paymentModal.hide();
            }
            
            // Show proof upload modal
            const proofUploadModal = proofUploadModalElement ? new bootstrap.Modal(proofUploadModalElement) : null;
            if (proofUploadModal) {
                proofUploadModal.show();
            } else {
                navigatingToProofUpload = false;
            }
        });
    }
    
    // GCash Receipt Validation
    const paymentProofInput = document.getElementById('payment_proof');
    if (paymentProofInput) {
        paymentProofInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                validateGCashReceipt(file);
            }
        });
    }
    
    function validateGCashReceipt(file) {
        const errorMessage = document.getElementById('gcash-validation-message');
        const successMessage = document.getElementById('gcash-success-message');
        const errorText = document.getElementById('gcash-error-text');
        
        // Hide previous messages
        errorMessage.style.display = 'none';
        successMessage.style.display = 'none';
        
        // Check file type
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!allowedTypes.includes(file.type)) {
            errorText.textContent = 'Only JPG, PNG, and JPEG images are allowed. Please upload a GCash receipt in one of these formats.';
            errorMessage.style.display = 'block';
            return false;
        }
        
        // Check file size (max 2MB)
        if (file.size > 2 * 1024 * 1024) {
            errorText.textContent = 'File size must be less than 2MB. Please compress your GCash receipt image.';
            errorMessage.style.display = 'block';
            return false;
        }
        
        // Create image element to analyze
        const img = new Image();
        img.onload = function() {
            // Create canvas to extract text (basic validation)
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            canvas.width = img.width;
            canvas.height = img.height;
            ctx.drawImage(img, 0, 0);
            
            // Basic validation - check if image has reasonable dimensions
            if (img.width < 200 || img.height < 200) {
                errorText.textContent = 'Image is too small. Please upload a clear, high-resolution GCash receipt (minimum 200x200 pixels).';
                errorMessage.style.display = 'block';
                return false;
            }
            
            // Check if image is too large
            if (img.width > 4000 || img.height > 4000) {
                errorText.textContent = 'Image is too large. Please upload a smaller GCash receipt image (maximum 4000x4000 pixels).';
                errorMessage.style.display = 'block';
                return false;
            }
            
            // For now, we'll do basic validation and let the backend handle detailed validation
            // In a real implementation, you might use OCR libraries like Tesseract.js
            successMessage.style.display = 'block';
            return true;
        };
        
        img.onerror = function() {
            errorText.textContent = 'Invalid image file. Please upload a valid image.';
            errorMessage.style.display = 'block';
            return false;
        };
        
        // Load the image
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }

    // Proof Upload Form
    if (proofUploadForm) {
        proofUploadForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate file before submission
            const fileInput = document.getElementById('payment_proof');
            if (fileInput.files.length === 0) {
                alert('Please select a GCash receipt file to upload.');
                return;
            }
            
            const file = fileInput.files[0];
            if (!validateGCashReceipt(file)) {
                alert('Please upload a valid GCash receipt before submitting.');
                return;
            }
            
            const formData = new FormData(this);
            
            fetch('/upload-payment-proof', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }

            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close proof upload modal
                    const proofUploadModalElement = document.getElementById('proofUploadModal');
                    const proofUploadModal = bootstrap.Modal.getInstance(proofUploadModalElement);
                    if (proofUploadModal) {
                        proofUploadModal.hide();
                    }
                    bookingCleanupPending = false;
                    bookingFinalized = true;
                    navigatingToProofUpload = false;
                    
                    // Show confirmation
                    document.getElementById('confirmed_booking_id').textContent = data.booking.id;
                    document.getElementById('confirmed_event_date').textContent = data.booking.event_date;
                    document.getElementById('confirmed_event_type').textContent = data.booking.event_type ? data.booking.event_type.name : 'Custom Event';
                    
                    // Set the confirmed payment details
                    const amountPaidValue = data.booking.amount_paid ?? data.booking.down_payment_amount ?? DEFAULT_DOWN_PAYMENT;
                    const confirmedAmount = formatCurrency(amountPaidValue);
                    const paymentLabel = data.booking.payment_option === 'full_payment' ? 'Full Payment' : 'Down Payment';
                    document.getElementById('confirmed_payment_amount').textContent = confirmedAmount;
                    const confirmedPaymentLabelEl = document.getElementById('confirmed_payment_label');
                    if (confirmedPaymentLabelEl) {
                        confirmedPaymentLabelEl.textContent = paymentLabel;
                    }
                    
                    // Show confirmation modal
                    const confirmationModalElement = document.getElementById('confirmationModal');
                    const confirmationModal = new bootstrap.Modal(confirmationModalElement);
                    confirmationModal.show();
                    
                    // Reset form
                    document.getElementById('eventBookingForm').reset();
                    currentBooking = null;
                    if (paymentOptionDownRadio) {
                        paymentOptionDownRadio.checked = true;
                    }
                    updatePaymentOptionDisplays(formatCurrency(DEFAULT_DOWN_PAYMENT), formatCurrency(DEFAULT_FULL_PAYMENT));
                } else {
                    alert('Error uploading proof: ' + (data.message || 'Please try again'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error uploading proof. Please try again.');
            });
        });
    }
});
</script>

</body>
</html>
