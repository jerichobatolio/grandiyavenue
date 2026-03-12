<!-- Book Event Section -->
<section id="book-event" class="book-event-section py-5" style="background-color: #1b1b1b; color: white;">
    <style>
        /* Improved Text Visibility and Typography */
        #book-event {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        #book-event h2 {
            color: white !important;
            font-size: 2.5rem;
            font-weight: 700;
            letter-spacing: -0.5px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        #book-event .lead {
            color: #e0e0e0 !important;
            font-size: 1.25rem;
            font-weight: 400;
            line-height: 1.6;
            opacity: 0.95;
        }
        
        #book-event .form-label {
            color: white !important;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 8px;
            letter-spacing: 0.3px;
        }
        
        #book-event .form-control,
        #book-event .form-select,
        #book-event select {
            background-color: #3c3c3c !important;
            border: 2px solid #555 !important;
            color: white !important;
            font-size: 1rem;
            padding: 10px 15px;
            border-radius: 6px;
            font-weight: 500;
            width: 100% !important;
        }

        /* Ensure select placeholder text is not clipped by the dropdown arrow */
        #book-event select.form-control,
        #book-event .form-select {
            padding-right: 3.5rem !important; /* extra space for caret */
            overflow: visible !important;
            text-overflow: clip !important;
            white-space: nowrap !important;
            min-height: 44px; /* make text more legible */
        }
        
        #book-event .form-control:focus,
        #book-event .form-select:focus {
            background-color: #3c3c3c !important;
            border-color: skyblue !important;
            color: white !important;
            box-shadow: 0 0 0 0.2rem rgba(135, 206, 235, 0.25);
        }
        
        #book-event .card {
            font-size: 1.05rem;
            line-height: 1.7;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            margin-top: -25px;
        }
        
        #book-event .card-header,
        #book-event .card-footer {
            flex-shrink: 0;
        }
        
        #book-event .card-body {
            flex: 1 1 auto;
            overflow-y: auto;
            padding-right: 1rem;
        }
        
        #book-event .booking-summary-table .table {
            background-color: #1f1f1f;
            color: white;
            border-color: rgba(255, 255, 255, 0.1);
        }
        
        #book-event .booking-summary-table th,
        #book-event .booking-summary-table td {
            vertical-align: middle;
        }
        
        #book-event .booking-summary-table th {
            width: 35%;
            font-weight: 600;
            color: #ffc107;
        }
        
        #book-event .booking-summary-table tbody tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.03);
        }
        
        #book-event .payment-option-box {
            background-color: rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            padding: 15px;
            color: white;
        }
        
        #book-event .payment-option-box strong {
            color: #ffc107;
        }
        
        #book-event .card-header h3 {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        
        #book-event .card-header p {
            font-size: 1rem;
            font-weight: 400;
        }
        
        #book-event button {
            font-size: 1.1rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        @media (max-width: 992px) {
            #book-event .card {
                max-height: none;
                margin-top: 0;
            }
            #book-event .card-body {
                overflow-y: visible;
                padding-right: 0;
            }
        }
        
        #book-event .alert {
            font-size: 1rem;
            font-weight: 500;
            line-height: 1.6;
        }
        
        #book-event .text-muted,
        #book-event .form-text.text-muted,
        #book-event small.text-muted {
            color: #e0e0e0 !important;
            font-size: 0.95rem;
            font-weight: 600;
        }
        
        /* Better visibility for select options */
        #book-event select option {
            background-color: #3c3c3c;
            color: white;
            padding: 10px;
            white-space: normal; /* allow full text in options list */
        }

        /* Food package buttons - keep dark theme when active (no white background) */
        #book-event .food-package-btn {
            border-radius: 999px;
        }

        #book-event .food-package-btn.active,
        #book-event .food-package-btn:active,
        #book-event .food-package-btn:focus {
            background-color: #ffc107 !important;
            border-color: #ffc107 !important;
            color: #000 !important;
            box-shadow: 0 0 0 0.15rem rgba(255, 193, 7, 0.35);
        }

        /* Improve small text visibility */
        #book-event small,
        #book-event .small {
            font-size: 0.95rem;
            color: #e0e0e0 !important;
            font-weight: 600;
        }
        
        /* Better visibility in modals */
        .modal-content {
            color: white !important;
        }
        
        .modal-content .text-muted,
        .modal-content .form-text.text-muted,
        .modal-content small.text-muted,
        .modal-content span.text-muted {
            color: #e0e0e0 !important;
            font-weight: 600 !important;
        }
        
        .modal-body p,
        .modal-body span,
        .modal-body li {
            color: white !important;
            font-weight: 500;
        }
        
        /* Better visibility for placeholders */
        #book-event ::placeholder {
            color: #b0b0b0 !important;
            opacity: 1;
            font-weight: 500;
        }
        
        /* Better visibility for disabled buttons */
        #book-event button:disabled {
            font-size: 1.1rem;
            font-weight: 600;
            color: #fff !important;
        }

    </style>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center mb-5">
                <h2 class="display-4 font-weight-bold mb-3" style="color: white !important;">📅 Book Your Special Event</h2>
                <p class="lead">Create unforgettable memories with us for birthdays, weddings, anniversaries, and more!</p>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card" style="background-color: #2c2c2c; border: 1px solid skyblue; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.3);">
                    <div class="card-header text-center" style="background: linear-gradient(135deg, #007bff, #0056b3); border-bottom: 1px solid skyblue;">
                        <h3 class="mb-0 text-white">🎉 Event Booking Form</h3>
                        <p class="mb-0 text-white">Fill out the form below to book your special event</p>
                    </div>
                    <div class="card-body p-4">
                        <!-- Event Booking Form -->
                        @php
                            $user = auth()->user();

                            // Prefer dedicated first_name / last_name fields when available,
                            // and only fall back to splitting the generic "name" field.
                            if ($user) {
                                $defaultFirstName = $user->first_name ?? '';
                                $defaultLastName = $user->last_name ?? '';

                                // If first/last are not set but a full name exists, split it.
                                if ((!$defaultFirstName || !$defaultLastName) && !empty($user->name)) {
                                    $nameParts = explode(' ', trim($user->name), 2);
                                    $defaultFirstName = $defaultFirstName ?: ($nameParts[0] ?? '');
                                    $defaultLastName = $defaultLastName ?: ($nameParts[1] ?? '');
                                }
                            } else {
                                $defaultFirstName = '';
                                $defaultLastName = '';
                            }

                            $defaultContactNumber = $user ? ($user->phone ?? '') : '';
                            $defaultEmail = $user ? ($user->email ?? '') : '';
                        @endphp
                        <form id="eventBookingForm">
                            @csrf
                            <input type="hidden" id="full_name" name="full_name">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="first_name" class="form-label text-white" style="color: white !important;">First Name *</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $defaultFirstName) }}" required style="background-color: #3c3c3c; border: 1px solid #555; color: white;">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="last_name" class="form-label text-white" style="color: white !important;">Last Name *</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $defaultLastName) }}" required style="background-color: #3c3c3c; border: 1px solid #555; color: white;">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="contact_number" class="form-label text-white" style="color: white !important;">Contact Number *</label>
                                    <input type="tel" class="form-control" id="contact_number" name="contact_number" value="{{ old('contact_number', $defaultContactNumber) }}" pattern="\d{11}" maxlength="11" placeholder="09XXXXXXXXX" title="Enter exactly 11 digits" required style="background-color: #3c3c3c; border: 1px solid #555; color: white;">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label text-white" style="color: white !important;">Email Address *</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $defaultEmail) }}" required style="background-color: #3c3c3c; border: 1px solid #555; color: white;">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="event_date" class="form-label text-white" style="color: white !important;">Event Date *</label>
                                    <input type="date" class="form-control" id="event_date" name="event_date" required style="background-color: #3c3c3c; border: 1px solid #555; color: white;">
                                    <div id="booking_conflict_warning" class="mt-2 p-2 rounded small" style="display: none; background-color: rgba(220, 53, 69, 0.15); border: 1px solid rgba(220, 53, 69, 0.45); color: #f1f1f1; font-size: 0.9rem;">
                                        <strong class="text-danger">Warning:</strong>
                                        <span id="booking_conflict_warning_text">This date and time slot may already have an existing event booking or table reservation.</span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="event_time_slot_id" class="form-label text-white" style="color: white !important;">Select time slot</label>
                                    <select class="form-control form-select" id="event_time_slot_id" name="event_time_slot_id" title="Select time slot. If someone has already selected a slot, then selection is required." required style="background-color: #3c3c3c; border: 1px solid #555; color: white;">
                                        <option value="">Select time slot</option>
                                    </select>
                                    <div id="time_slot_details_display" class="mt-2 p-2 rounded small" style="display: none; background-color: rgba(255, 193, 7, 0.15); border: 1px solid rgba(255, 193, 7, 0.4); color: #e0e0e0; font-size: 0.9rem;"></div>
                                    <input type="hidden" name="time_in" id="time_in" value="">
                                    <input type="hidden" name="time_out" id="time_out" value="">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="event_type_id" class="form-label text-white" style="color: white !important;">Event Type *</label>
                                <select class="form-control" id="event_type_id" name="event_type_id" title="Select Event Type" required style="background-color: #3c3c3c; border: 1px solid #555; color: white;">
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
                                <label for="venue_type" class="form-label text-white" style="color: white !important;">Venue Type *</label>
                                <select class="form-control" id="venue_type" name="venue_type_id" title="Select Venue Type" required style="background-color: #3c3c3c; border: 1px solid #555; color: white;">
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
                                <div class="mt-2" id="capacity-info" style="display: none;">
                                    <small class="text-info">ℹ️ Venue capacity: <span id="capacity-info-value"></span> pax</small>
                                </div>
                            </div>

                            <!-- Package Inclusions (select dropdown) -->
                            @if(isset($packageInclusions) && $packageInclusions->count() > 0)
                            <div class="mb-3">
                                <label for="package_inclusion_id" class="form-label text-white" style="color: white !important;">📦 Package Inclusion</label>
                                <select class="form-control form-select" id="package_inclusion_id" name="package_inclusion_id" style="background-color: #3c3c3c; border: 1px solid #555; color: white;">
                                    <option value="">Select Package Inclusion</option>
                                    @foreach($packageInclusions as $inclusion)
                                    @php
                                        $minPax = $inclusion->pax_min;
                                        $maxPax = $inclusion->pax_max;
                                    @endphp
                                    <option value="{{ $inclusion->id }}"
                                            data-name="{{ $inclusion->name }}"
                                            data-price="{{ $inclusion->price }}"
                                            data-details="{{ e($inclusion->details ?? '') }}">
                                        {{ $inclusion->name }}
                                        @if(!is_null($minPax) || !is_null($maxPax))
                                            –
                                            @if(!is_null($minPax) && !is_null($maxPax))
                                                {{ $minPax }}–{{ $maxPax }} pax
                                            @elseif(!is_null($minPax))
                                                {{ $minPax }} pax
                                            @else
                                                {{ $maxPax }} pax
                                            @endif
                                        @endif
                                    </option>
                                    @endforeach
                                </select>
                                <div id="package_inclusion_details_display" class="mt-2 p-3 rounded" style="display: none; background-color: #3c3c3c; border: 1px solid #555; color: #b0b0b0; font-size: 0.95rem;">
                                    <strong class="text-white d-block mb-1">Details:</strong>
                                    <span id="package_inclusion_details_text"></span>
                                </div>
                                <small class="text-muted d-block mt-1">Select the package inclusion that fits your event needs.</small>
                            </div>
                            @endif

                            <!-- Food Package (select a category like "Chicken" to see dishes) -->
                            <div class="mb-3" id="food_package_section" style="display: none;">
                                <label class="form-label text-white" style="color: white !important;">Food Package</label>
                                
                                {{-- Top row: clickable simple items (Chicken, Vegetable, etc.) --}}
                                <div id="food_package_selector" class="mb-2">
                                    @if(isset($foodPackageItems) && $foodPackageItems->count() > 0)
                                        @foreach($foodPackageItems as $item)
                                            <button type="button"
                                                    class="btn btn-outline-light btn-sm me-2 mb-2 food-package-btn"
                                                    data-package-name="{{ $item->name }}">
                                                {{ $item->name }}
                                            </button>
                                        @endforeach
                                    @else
                                        <div style="color: #999;">No food package items configured.</div>
                                    @endif
                                </div>

                                {{-- Dynamic list: dishes belonging to the selected package --}}
                                <div id="food_package_display"
                                     style="background-color: #3c3c3c; border: 1px solid #555; border-radius: 6px; padding: 15px; color: white; min-height: 52px;">
                                    <div id="food_package_placeholder" style="color: #999;"></div>
                                    <div id="food_package_items_list"></div>
                                </div>

                            </div>
                            
                            <div class="mb-3">
                                <div id="capacity-warning" class="alert alert-warning mt-2" style="display: none; background-color: #4d3a00; border-color: #ffc107; color: white;">
                                    <i class="fas fa-exclamation-triangle"></i> 
                                    <span id="capacity-warning-text"></span>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="additional_notes" class="form-label text-white" style="color: white !important;">Additional Notes</label>
                                <textarea class="form-control" id="additional_notes" name="additional_notes" rows="3" placeholder="Any special requirements or requests..." style="background-color: #3c3c3c; border: 1px solid #555; color: white;"></textarea>
                            </div>
                            
                            <div class="text-center">
                                <div class="alert alert-info" style="background-color: #0c5460; border-color: #17a2b8; color: white;">
                                    <i class="fas fa-info-circle"></i> Complete all fields above to book your event
                                </div>
                                <button type="button" class="btn btn-primary btn-lg mt-3" id="bookEventBtn" disabled style="background-color: gold; border-color: gold; color: black; font-weight: bold; padding: 12px 30px;" title="Login required to book events">
                                    Book Event (Login Required)
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Booking Summary Modal -->
<div class="modal fade" id="bookingSummaryModal" tabindex="-1" aria-labelledby="bookingSummaryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background-color: #2c2c2c; border: 1px solid skyblue;">
            <div class="modal-header" style="background: linear-gradient(135deg, #28a745, #1e7e34); border-bottom: 1px solid #555;">
                <h5 class="modal-title text-white" id="bookingSummaryModalLabel">📋 Booking Summary</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-white" style="max-height: 500px; overflow-y: auto;">
                <div class="booking-summary-table">
                    <div class="table-responsive">
                        <table class="table table-dark table-striped table-bordered align-middle mb-4">
                            <thead>
                                <tr>
                                    <th colspan="2" class="text-center text-uppercase">📋 Book Summary</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">Name</th>
                                    <td><span id="summary_name"></span></td>
                                </tr>
                                <tr>
                                    <th scope="row">Contact Number</th>
                                    <td><span id="summary_contact"></span></td>
                                </tr>
                                <tr>
                                    <th scope="row">Email</th>
                                    <td><span id="summary_email"></span></td>
                                </tr>
                                <tr>
                                    <th scope="row">Event Type</th>
                                    <td><span id="summary_event_type"></span></td>
                                </tr>
                                <tr>
                                    <th scope="row">Venue Type</th>
                                    <td><span id="summary_venue_type"></span></td>
                                </tr>
                                <tr>
                                    <th scope="row">Event Date</th>
                                    <td><span id="summary_event_date"></span></td>
                                </tr>
                                <tr>
                                    <th scope="row">Schedule</th>
                                    <td><span id="summary_schedule">To be scheduled with admin</span></td>
                                </tr>
                                <tr>
                                    <th scope="row">Additional Notes</th>
                                    <td><span id="summary_notes"></span></td>
                                </tr>
                                <tr>
                                    <th scope="row">Food Package</th>
                                    <td><span id="summary_food_package"></span></td>
                                </tr>
                                @if(isset($packageInclusions) && $packageInclusions->count() > 0)
                                <tr>
                                    <th scope="row">Package Inclusion</th>
                                    <td><span id="summary_package_inclusion"></span></td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Terms & Conditions Section -->
                <hr class="my-4">
                <h6 class="text-warning">📋 Terms & Conditions</h6>
                <div class="mb-3">
                    <h6 class="text-white">💰 PAYMENT TERMS</h6>
                    <ul class="text-white">
                        <li>All payment recieved shall be considered non-refundable & non-consumable but transferrablesubject for Management Approval.</li>
                    </ul>
                </div>
                

                <div class="mb-3">
                    <h6 class="text-white">❌ CANCELLATION POLICY</h6>
                    <ul class="text-white">
                        <li>Cancellation of event 60days (2months)before the evenet, shall be charged 10% of the total contract value or total amount of down payment which ever is higher. </li>
                        <li>Cancellation of event less than 45days before the event shall be charged 50% of the full contract value.</li>
                        <li>Cancellation of event less than 30days before the event shall be charged full amount of the full contract value.</li>
                        <li>This charge is to cover the opportunity loss incurred by the Management during the time of the slot date was reserved for the Client.</li>
                    </ul>
                </div>
    
                <div class="mb-3">
                    <h6 class="text-white">MENU & FOOD QUANTITIES</h6>
                    <ul class="text-white">
                        <li>Grandiya Venue & Restaurant will prepare based on the final number of guests in the contract. Excess plate /guest shall be charged according to the package (Minimum 20pax for Excess plate/guest).</li>
                        <li>The client is allowed to bring in thier own food subject to additional charge with agreement that we not liable for any food that may result there from .The management has the right to refuse any smelly or spoiled food. 300/per dish: Pasta; Pansit; Dessert; Pika2x 500/per 5kl & below: Any Main Dish 1000/above 5kl: Any Main Dish 1500/20pcs & below: Any Packed Meals.</li>
                        <li>We shall endorse all leftovers to an authorizes representative of the client. However, Grandiya Venue & Restaurant shall not be responsible for any food taken home ny the client or guest.</li>
                    </ul>
                </div>

                <div class="mb-3">
                    <h6 class="text-white">OTHER CONDITIONS</h6>
                    <ul class="text-white">
                        <li>We reserve the right to charge for any missing or damaged item by the Client or invited guest.</li>
                        <li>The Client should advise all the thier guest with children to supervise them at all the times, including thier belongings.</li>
                        <li>Pets are strictly not allowed inside the venue.</li>
                        <li>It is agreed and understood that Grandiya Venue & Restaurant is relieved from any and all liabilities as a result of any accident,calamity or pandemic (lockdown) or any uncontrollable that may affect the normal operations.</li>
                    </ul>
                </div>


                <div class="form-check mt-4 p-3" style="background-color: #3c3c3c; border: 1px solid #555; border-radius: 5px;">
                    <input class="form-check-input" type="checkbox" id="agreeTermsSummary" required style="transform: scale(1.2);">
                    <label class="form-check-label text-white fw-bold" for="agreeTermsSummary" style="font-size: 1.1em;">
                        I agree to the Terms & Conditions and understand the payment and cancellation policies
                    </label>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #555;">
                <button type="button" class="btn btn-secondary" id="editBookingBtn">Edit Booking</button>
                <button type="button" class="btn btn-primary text-dark" id="proceedToPaymentBtn" disabled style="background-color: gold; border-color: gold; color: black;">✓ Check Box Above to Continue to Payment</button>
            </div>
        </div>
    </div>
</div>

<!-- Terms & Conditions Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background-color: #2c2c2c; border: 1px solid skyblue;">
            <div class="modal-header" style="background: linear-gradient(135deg, #ffc107, #e0a800); border-bottom: 1px solid #555;">
                <h5 class="modal-title text-dark" id="termsModalLabel">📋 Terms & Conditions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-white" style="max-height: 400px; overflow-y: auto;">
                <h6 class="text-white">📋 Booking Terms & Conditions</h6>
                <div class="mb-3">
                    <h6 class="text-white">💰 Payment Terms</h6>
                    <ul class="text-white">
                        <li>Full payment required to confirm your booking</li>
                        <li>Payment must be made via GCash only</li>
                        <li>Payment must be completed before the event date</li>
                    </ul>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-white">❌ Cancellation Policy</h6>
                    <ul class="text-white">
                        <li>Free cancellation up to 7 days before the event</li>
                        <li>50% refund for cancellations 3-7 days before the event</li>
                        <li>No refund for cancellations within 3 days of the event</li>
                        <li>Payment is non-refundable 3 days before the event</li>
                    </ul>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-white">📅 Event Guidelines</h6>
                    <ul class="text-white">
                        <li>Event time must be confirmed 48 hours in advance</li>
                        <li>Any changes to guest count must be communicated 24 hours before</li>
                        <li>Additional charges may apply for extra services</li>
                        <li>Venue damage charges will be applied if applicable</li>
                    </ul>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-white">📞 Contact Information</h6>
                    <p class="text-white">For any questions or concerns, please contact us at:</p>
                    <ul class="text-white">
                        <li>Phone: (02) 123-4567</li>
                        <li>Email: events@grandiya.com</li>
                        <li>Address: Grandiya Street, City Center</li>
                    </ul>
                </div>
                
                <div class="form-check mt-4 p-3" style="background-color: #3c3c3c; border: 1px solid #555; border-radius: 5px;">
                    <input class="form-check-input" type="checkbox" id="agreeTerms" required style="transform: scale(1.2);">
                    <label class="form-check-label text-white fw-bold" for="agreeTerms" style="font-size: 1.1em;">
                        I agree to the Terms & Conditions and understand the payment and cancellation policies
                    </label>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #555;">
                <button type="button" class="btn btn-secondary" id="paymentModalCancelBtnSection" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary text-dark" id="continueToPaymentBtn" disabled style="background-color: gold; border-color: gold; color: black;">✓ Check Box Above to Continue to Payment</button>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background-color: #2c2c2c; border: 1px solid skyblue;">
            <div class="modal-header" style="background: linear-gradient(135deg, #17a2b8, #138496); border-bottom: 1px solid #555;">
                <h5 class="modal-title text-white" id="paymentModalLabel">💳 GCash Payment</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center text-white">
                <h4 class="text-white">Pay via GCash</h4>
                <div class="my-4">
                    @if(isset($adminQrCode) && $adminQrCode && $adminQrCode->is_active)
                        <img src="{{ $adminQrCode->image_url }}" alt="GCash QR Code" class="img-fluid" style="max-width: 300px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                    @else
                        <div class="alert alert-warning" style="background-color: #4d3a00; border-color: #ffc107; color: white;">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>QR Code Not Available</strong><br>
                            Please contact the administrator to set up the payment QR code.
                        </div>
                    @endif
                </div>
                <p class="text-muted">Scan the QR code using your GCash app to complete payment</p>
                <div class="alert alert-warning" style="background-color: #4d3a00; border-color: #ffc107; color: white;">
                    <strong>Important:</strong> Please keep your payment receipt as proof of transaction
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #555;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="uploadProofBtn">I've Paid – Upload Proof</button>
            </div>
        </div>
    </div>
</div>

<!-- Payment Proof Upload Modal -->
<div class="modal fade" id="proofUploadModal" tabindex="-1" aria-labelledby="proofUploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #2c2c2c; border: 1px solid skyblue;">
            <div class="modal-header" style="background: linear-gradient(135deg, #28a745, #1e7e34); border-bottom: 1px solid #555;">
                <h5 class="modal-title text-white" id="proofUploadModalLabel">📸 Upload Payment Proof</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-white">
                <form id="proofUploadForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="booking_id" name="booking_id">
                    <input type="hidden" name="payment_option" value="full_payment">
                    <div class="mb-3">
                        <label for="payment_proof" class="form-label text-white">Upload GCash Transaction Receipt * <small class="text-warning">(can only upload legit GCash receipt)</small></label>
                        <input type="file" class="form-control" id="payment_proof" name="payment_proof" accept="image/jpeg,image/png,image/jpg" required style="background-color: #3c3c3c; border: 1px solid #555; color: white;">
                        <div class="form-text text-muted">
                            <strong>Important:</strong> We cannot accept other photos (selfies, IDs, random images, etc.). Only official GCash transaction receipts are accepted.
                            <br>• Upload a clear screenshot or photo of your GCash payment confirmation
                            <br>• Image must be at least 200x200 pixels
                            <br>• File size must be less than 2MB
                            <br>• Only JPG and PNG formats are allowed
                        </div>
                        <div id="gcash-validation-message" class="alert alert-danger mt-2" style="display: none; background-color: #721c24; border-color: #f5c6cb; color: white;">
                            <i class="fas fa-exclamation-triangle"></i> <span id="gcash-error-text"></span>
                        </div>
                        <div id="gcash-success-message" class="alert alert-success mt-2" style="display: none; background-color: #155724; border-color: #c3e6cb; color: white;">
                            <i class="fas fa-check-circle"></i> Valid GCash receipt detected!
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Submit Proof</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Final Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #2c2c2c; border: 1px solid #555; color: #ffffff;">
            <div class="modal-header" style="background: linear-gradient(135deg, #28a745, #1e7e34); border-bottom: 1px solid #555;">
                <h5 class="modal-title" id="confirmationModalLabel">✅ Booking Confirmed!</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="mb-3">
                    <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                </div>
                <h4>Payment Sent!</h4>
                <div class="alert alert-info" style="background-color: #1f1f1f; border: 1px solid #555; color: #ffffff;">
                    <strong>Booking ID:</strong> <span id="confirmed_booking_id" style="color: #00ff7f; font-weight: 600;"></span><br>
                    <strong>Event Date:</strong> <span id="confirmed_event_date" style="color: #00ff7f; font-weight: 600;"></span><br>
                    <strong>Time:</strong> <span id="confirmed_event_time" style="color: #00ff7f; font-weight: 600;"></span><br>
                    <strong>Event Type:</strong> <span id="confirmed_event_type" style="color: #00ff7f; font-weight: 600;"></span>
                </div>
                <p class="small">We'll contact you soon to confirm the final details of your event.</p>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #555;">
                <a href="#" id="downloadReceiptBtn" class="btn btn-success" style="background-color: #28a745; border-color: #28a745; color: white; text-decoration: none;">
                    <i class="fas fa-download"></i> Download Receipt
                </a>
                <button type="button" class="btn btn-primary" id="confirmationCloseBtnSection" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@php
$bookingTimeSlotsList = [];
try {
    if (!isset($globalTimeSlots) || $globalTimeSlots === null) {
        $globalTimeSlots = \App\Models\EventTypeTimeSlot::whereNull('event_type_id')->orderBy('sort_order')->get();
    }
    if ($globalTimeSlots->isEmpty()) {
        $globalTimeSlots = \App\Models\EventTypeTimeSlot::orderBy('sort_order')->get();
    }
    if ($globalTimeSlots->count() > 0) {
        $bookingTimeSlotsList = $globalTimeSlots->map(function ($s) {
            return [
                'id' => $s->id,
                'label' => $s->label,
                'start_time' => $s->start_time ? substr((string) $s->start_time, 0, 5) : null,
                'end_time' => $s->end_time ? substr((string) $s->end_time, 0, 5) : null,
                'display' => $s->time_range_display,
                'details' => $s->details ?? '',
            ];
        })->values()->all();
    }
} catch (\Throwable $e) {
    $bookingTimeSlotsList = [];
}
@endphp
<script>
window.bookingTimeSlots = @json($bookingTimeSlotsList);

let currentBooking = null;
let bookingCleanupPending = false;
let navigatingToProofUpload = false;
let bookingFinalized = false;

document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 BOOK EVENT SECTION - Loading...');
    
    // Set minimum date to tomorrow
    const eventDateField = document.getElementById('event_date');
    if (eventDateField) {
        eventDateField.min = new Date(Date.now() + 86400000).toISOString().split('T')[0];
    }
    
    // Get elements
    const form = document.getElementById('eventBookingForm');
    const bookEventBtn = document.getElementById('bookEventBtn');
    const editBookingBtn = document.getElementById('editBookingBtn');
    const agreeTermsSummaryCheckbox = document.getElementById('agreeTermsSummary');
    const proceedToPaymentBtn = document.getElementById('proceedToPaymentBtn');
    const agreeTermsCheckbox = document.getElementById('agreeTerms');
    const continueToPaymentBtn = document.getElementById('continueToPaymentBtn');
    const uploadProofBtn = document.getElementById('uploadProofBtn');
    const proofUploadForm = document.getElementById('proofUploadForm');
    const firstNameField = document.getElementById('first_name');
    const lastNameField = document.getElementById('last_name');
    const fullNameField = document.getElementById('full_name');
    const eventTypeSelect = document.getElementById('event_type_id');
    const summaryVenueField = document.getElementById('summary_venue_type');
    const confirmationCloseBtnSection = document.getElementById('confirmationCloseBtnSection');
    const paymentModalElement = document.getElementById('paymentModal');
    const proofUploadModalElement = document.getElementById('proofUploadModal');
    const paymentModalCancelBtnSection = document.getElementById('paymentModalCancelBtnSection');
    
    console.log('Elements found:', {
        form: !!form,
        bookEventBtn: !!bookEventBtn,
        editBookingBtn: !!editBookingBtn,
        agreeTermsSummaryCheckbox: !!agreeTermsSummaryCheckbox,
        proceedToPaymentBtn: !!proceedToPaymentBtn,
        agreeTermsCheckbox: !!agreeTermsCheckbox,
        continueToPaymentBtn: !!continueToPaymentBtn
    });
    
    const requiredFields = ['first_name', 'last_name', 'contact_number', 'email', 'event_date', 'event_time_slot_id', 'event_type_id', 'venue_type', 'package_inclusion_id'];

    // Time slot dropdown: populated from admin-created slots per event type
    const eventTimeSlotSelect = document.getElementById('event_time_slot_id');
    const timeInHidden = document.getElementById('time_in');
    const timeOutHidden = document.getElementById('time_out');

    // Warning note for conflicts (existing event bookings / table reservations)
    const bookingConflictWarning = document.getElementById('booking_conflict_warning');
    const bookingConflictWarningText = document.getElementById('booking_conflict_warning_text');
    let conflictCheckTimer = null;

    function hideBookingConflictWarning() {
        if (bookingConflictWarning) bookingConflictWarning.style.display = 'none';
    }

    function showBookingConflictWarning(message) {
        if (!bookingConflictWarning) return;
        if (bookingConflictWarningText) {
            bookingConflictWarningText.textContent = message || 'This date and time slot may already be booked.';
        }
        bookingConflictWarning.style.display = 'block';
    }

    function scheduleConflictCheck() {
        if (conflictCheckTimer) clearTimeout(conflictCheckTimer);
        conflictCheckTimer = setTimeout(checkBookingConflicts, 250);
    }

    async function checkBookingConflicts() {
        const date = eventDateField ? (eventDateField.value || '') : '';
        const timeIn = timeInHidden ? (timeInHidden.value || '') : '';
        const timeOut = timeOutHidden ? (timeOutHidden.value || '') : '';

        if (!date) {
            hideBookingConflictWarning();
            return;
        }

        // Detect if the selected slot is configured as "Whole Day"
        let isWholeDaySelection = false;
        if (eventTimeSlotSelect && eventTimeSlotSelect.value) {
            const opt = eventTimeSlotSelect.options[eventTimeSlotSelect.selectedIndex];
            if (opt) {
                const label = (opt.getAttribute('data-display') || opt.textContent || '').toLowerCase();
                const startAttr = opt.getAttribute('data-start-time') || '';
                const endAttr = opt.getAttribute('data-end-time') || '';
                isWholeDaySelection = !startAttr && !endAttr && label.includes('whole day');
            }
        }

        // For non-whole-day: require both start and end times to run the check
        if (!isWholeDaySelection && (!timeIn || !timeOut)) {
            hideBookingConflictWarning();
            return;
        }

        try {
            const baseParams = { date };
            if (!isWholeDaySelection) {
                baseParams.time_in = timeIn;
                baseParams.time_out = timeOut;
            }
            const params = new URLSearchParams(baseParams);
            const res = await fetch('/api/booking-conflicts?' + params.toString(), {
                method: 'GET',
                headers: { 'Accept': 'application/json' }
            });

            if (!res.ok) {
                hideBookingConflictWarning();
                return;
            }

            const data = await res.json();
            if (!data || !data.success) {
                hideBookingConflictWarning();
                return;
            }

            if (data.whole_day_event) {
                showBookingConflictWarning('This date is fully booked for an event. Please choose another date.');
                return;
            }

            if (data.conflict) {
                showBookingConflictWarning('Warning: This date and time slot overlaps an existing booking or reservation. Please choose another slot.');
                return;
            }

            hideBookingConflictWarning();
        } catch (e) {
            hideBookingConflictWarning();
        }
    }

    function populateTimeSlots() {
        if (!eventTimeSlotSelect) return;
        // Keep any already-selected time slot if it still exists; otherwise show the placeholder.
        const previousValue = eventTimeSlotSelect.value;
        const slots = window.bookingTimeSlots || [];
        eventTimeSlotSelect.innerHTML = '';
        hideBookingConflictWarning();
        const firstOpt = document.createElement('option');
        firstOpt.value = '';
        firstOpt.textContent = slots.length ? 'Select time slot' : 'No time slots configured. Admin can add them under Event Types → Time Slots.';
        eventTimeSlotSelect.appendChild(firstOpt);
        slots.forEach(function (slot) {
            const opt = document.createElement('option');
            opt.value = slot.id;
            opt.textContent = slot.display || (slot.start_time && slot.end_time ? slot.start_time + ' - ' + slot.end_time : slot.label);
            opt.setAttribute('data-start-time', slot.start_time || '');
            opt.setAttribute('data-end-time', slot.end_time || '');
            opt.setAttribute('data-display', slot.display || '');
            opt.setAttribute('data-details', slot.details || '');
            eventTimeSlotSelect.appendChild(opt);
        });

        // If the previously-selected value still exists in the new options, keep it selected.
        // Otherwise, fall back to the placeholder ("Select time slot").
        if (previousValue && eventTimeSlotSelect.querySelector('option[value=\"' + previousValue + '\"]')) {
            eventTimeSlotSelect.value = previousValue;
        } else {
            eventTimeSlotSelect.selectedIndex = 0;
            if (timeInHidden) timeInHidden.value = '';
            if (timeOutHidden) timeOutHidden.value = '';
            const detailsEl = document.getElementById('time_slot_details_display');
            if (detailsEl) { detailsEl.style.display = 'none'; detailsEl.textContent = ''; }
        }
    }

    function updateTimeSlotDetails() {
        const detailsEl = document.getElementById('time_slot_details_display');
        if (!detailsEl || !eventTimeSlotSelect) return;
        const opt = eventTimeSlotSelect.options[eventTimeSlotSelect.selectedIndex];
        const details = opt && opt.value ? (opt.getAttribute('data-details') || '') : '';
        if (details.trim()) {
            detailsEl.innerHTML = '<strong class="text-warning">Details:</strong> ' + escapeHtml(details);
            detailsEl.style.display = 'block';
        } else {
            detailsEl.textContent = '';
            detailsEl.style.display = 'none';
        }
    }
    function escapeHtml(s) {
        const div = document.createElement('div');
        div.textContent = s;
        return div.innerHTML;
    }

    if (eventTypeSelect) {
        eventTypeSelect.addEventListener('change', populateTimeSlots);
    }
    if (eventDateField) {
        eventDateField.addEventListener('change', scheduleConflictCheck);
        eventDateField.addEventListener('input', scheduleConflictCheck);
    }
    if (eventTimeSlotSelect) {
        eventTimeSlotSelect.addEventListener('change', function () {
            const opt = this.options[this.selectedIndex];
            if (!opt || !opt.value) {
                if (timeInHidden) timeInHidden.value = '';
                if (timeOutHidden) timeOutHidden.value = '';
                try { sessionStorage.removeItem('book_event_time_slot_id'); } catch (e) {}
                updateTimeSlotDetails();
                hideBookingConflictWarning();
                return;
            }
            const start = opt.getAttribute('data-start-time') || '';
            const end = opt.getAttribute('data-end-time') || '';
            if (timeInHidden) timeInHidden.value = start;
            if (timeOutHidden) timeOutHidden.value = end;
            try { sessionStorage.setItem('book_event_time_slot_id', opt.value); } catch (e) {}
            updateTimeSlotDetails();
            scheduleConflictCheck();
        });
    }
    populateTimeSlots();

    function updateFullNameField() {
        if (!fullNameField) return;
        const first = firstNameField ? firstNameField.value.trim() : '';
        const last = lastNameField ? lastNameField.value.trim() : '';
        const combined = [first, last].filter(Boolean).join(' ').trim();
        fullNameField.value = combined;
    }

    function parseMoney(value) {
        if (value === null || value === undefined) return null;
        const n = parseFloat(value);
        return Number.isFinite(n) ? n : null;
    }

    function formatCurrency(amount) {
        const safe = Number.isFinite(amount) ? amount : 0;
        return '₱' + safe.toLocaleString('en-US', { minimumFractionDigits: 2 });
    }

    // Pricing source priority:
    // 1) Package inclusion price (when user selected a package inclusion)
    // 2) Event type pricing via event type dropdown data attributes
    // 3) Safe defaults
    function getSelectedPricing() {
        const packageSelect = document.getElementById('package_inclusion_id');
        const packageOpt = packageSelect && packageSelect.options[packageSelect.selectedIndex] ? packageSelect.options[packageSelect.selectedIndex] : null;
        const packagePrice = packageOpt && packageOpt.value ? parseMoney(packageOpt.getAttribute('data-price')) : null;

        const evtOpt = eventTypeSelect ? eventTypeSelect.options[eventTypeSelect.selectedIndex] : null;
        const evtDown = evtOpt ? parseMoney(evtOpt.getAttribute('data-down-payment')) : null;
        const evtFull = evtOpt ? parseMoney(evtOpt.getAttribute('data-price')) : null;

        // Use package inclusion price as full amount when selected; down payment PHP 10,000 per terms or event type
        if (packagePrice !== null && Number.isFinite(packagePrice) && packagePrice > 0) {
            return {
                down: evtDown ?? 10000,
                full: packagePrice,
            };
        }
        return {
            down: evtDown ?? 2000,
            full: evtFull ?? 4000,
        };
    }

    if (confirmationCloseBtnSection) {
        confirmationCloseBtnSection.addEventListener('click', function() {
            window.location.href = '/home';
        });
    }

    if (paymentModalCancelBtnSection) {
        paymentModalCancelBtnSection.addEventListener('click', function() {
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
    
    // Form validation
    function checkFormCompletion() {
        console.log('🔍 Checking form completion...');
        
        if (!form || !bookEventBtn) {
            console.error('Form or button not found!');
            return;
        }
        
        let allFieldsFilled = true;
        let missingFields = [];
        
        requiredFields.forEach(fieldName => {
            const field = document.getElementById(fieldName);
            if (!field) {
                console.error(`Field ${fieldName} not found!`);
                allFieldsFilled = false;
                missingFields.push(fieldName + ' (not found)');
            } else {
                const value = field.value.trim();
                if (value === '' || value === null || value === undefined) {
                    allFieldsFilled = false;
                    missingFields.push(fieldName);
                    console.log(`❌ ${fieldName} is empty or invalid`);
                } else {
                    console.log(`✅ ${fieldName}: "${value}"`);
                }
            }
        });
        
        // Also require at least one food package item when the section is visible
        const foodSection = document.getElementById('food_package_section');
        if (foodSection && foodSection.style.display !== 'none') {
            const anyFoodChecked = document.querySelector('input[name="selected_food_items[]"]:checked');
            if (!anyFoodChecked) {
                allFieldsFilled = false;
                missingFields.push('selected_food_items');
                console.log('❌ No food package items selected');
            }
        }

        console.log('Validation result:', {allFieldsFilled, missingFields});
        
        if (allFieldsFilled) {
            console.log('✅ All fields filled - enabling button');
            bookEventBtn.disabled = false;
            bookEventBtn.textContent = 'Book Event';
            bookEventBtn.style.backgroundColor = 'gold';
            bookEventBtn.style.borderColor = 'gold';
            bookEventBtn.style.color = 'black';
        } else {
            console.log('❌ Missing fields - disabling button');
            bookEventBtn.disabled = true;
            bookEventBtn.textContent = 'Complete Form to Book';
            bookEventBtn.style.backgroundColor = '#6c757d';
            bookEventBtn.style.borderColor = '#6c757d';
            bookEventBtn.style.color = 'white';
        }
    }
    
    // Add form listeners
    requiredFields.forEach(fieldName => {
        const field = document.getElementById(fieldName);
        if (field) {
            field.addEventListener('input', checkFormCompletion);
            field.addEventListener('change', checkFormCompletion);
        } else {
            console.error(`Field not found: ${fieldName}`);
        }
    });
    
    // Additional specific listeners for time fields
    const timeInField = document.getElementById('time_in');
    const timeOutField = document.getElementById('time_out');
    
    if (timeInField) {
        timeInField.addEventListener('change', function() {
            checkFormCompletion();
        });
    }
    
    if (timeOutField) {
        timeOutField.addEventListener('change', function() {
            checkFormCompletion();
        });
    }
    
    const additionalNotes = document.getElementById('additional_notes');
    if (additionalNotes) {
        additionalNotes.addEventListener('input', checkFormCompletion);
    }
    
    const nameFields = [firstNameField, lastNameField];
    nameFields.forEach(field => {
        if (field) {
            field.addEventListener('input', () => {
                updateFullNameField();
                checkFormCompletion();
            });
            field.addEventListener('blur', updateFullNameField);
        }
    });

    updateFullNameField();
    checkFormCompletion();
    
    
    // Venue capacity info (no guest-count restriction)
    const venueTypeSelect = document.getElementById('venue_type');
    const capacityWarning = document.getElementById('capacity-warning');
    const capacityWarningText = document.getElementById('capacity-warning-text');

    function getVenueCapacity(selectedOption) {
        if (!selectedOption) return null;
        const dataCap = parseInt(selectedOption.getAttribute('data-capacity'));
        if (!isNaN(dataCap)) return dataCap;
        const map = { indoor: 100, outdoor: 150, rooftop: 80, private: 20, vip: 10, banquet: 200 };
        const key = (selectedOption.value || '').toLowerCase();
        return map[key] || null;
    }

    function updateCapacityInfoOnly() {
        if (!venueTypeSelect) return;
        const selected = venueTypeSelect.options[venueTypeSelect.selectedIndex];
        const venueCapacity = getVenueCapacity(selected);
        const capacityInfo = document.getElementById('capacity-info');
        const capacityInfoValue = document.getElementById('capacity-info-value');

        if (capacityInfo && capacityInfoValue && venueCapacity) {
            capacityInfo.style.display = 'block';
            capacityInfoValue.textContent = venueCapacity;
        } else if (capacityInfo) {
            capacityInfo.style.display = 'none';
        }

        if (capacityWarning) {
            capacityWarning.style.display = 'none';
        }
    }

    if (venueTypeSelect) {
        venueTypeSelect.addEventListener('change', updateCapacityInfoOnly);
        updateCapacityInfoOnly();
    }
    
    // Package inclusion details display when selection changes
    const packageInclusionSelect = document.getElementById('package_inclusion_id');
    const packageDetailsDisplay = document.getElementById('package_inclusion_details_display');
    const packageDetailsText = document.getElementById('package_inclusion_details_text');
    const foodPackageSection = document.getElementById('food_package_section');
    const foodPackageSelector = document.getElementById('food_package_selector');
    const foodPackageItemsList = document.getElementById('food_package_items_list');
    const foodPackagePlaceholder = document.getElementById('food_package_placeholder');
    function updatePackageInclusionDetails() {
        if (!packageInclusionSelect || !packageDetailsDisplay || !packageDetailsText) return;
        const selectedOpt = packageInclusionSelect.options[packageInclusionSelect.selectedIndex];
        const rawDetails = selectedOpt && selectedOpt.value ? (selectedOpt.getAttribute('data-details') || '').trim() : '';
        const rawPrice = selectedOpt && selectedOpt.value ? (selectedOpt.getAttribute('data-price') || '').trim() : '';
        let html = '';

        const numericPrice = parseFloat(rawPrice);
        if (!isNaN(numericPrice) && numericPrice > 0) {
            html += `<div><strong>Price:</strong> ${formatCurrency(numericPrice)}</div>`;
        }

        if (rawDetails) {
            const escapedDetails = rawDetails
                .replace(/&/g,'&amp;')
                .replace(/</g,'&lt;')
                .replace(/>/g,'&gt;')
                .replace(/"/g,'&quot;')
                .replace(/\n/g, '<br>');
            html += `<div class="mt-1">${escapedDetails}</div>`;
        }

        if (html) {
            packageDetailsText.innerHTML = html;
            packageDetailsDisplay.style.display = 'block';
        } else {
            packageDetailsText.textContent = '';
            packageDetailsDisplay.style.display = 'none';
        }

        // Show/hide Food Package section based on Package Inclusion selection
        if (foodPackageSection) {
            if (selectedOpt && selectedOpt.value) {
                // Show food package options
                foodPackageSection.style.display = 'block';
            } else {
                // Hide food package section and clear any temporary state
                foodPackageSection.style.display = 'none';

                // Deactivate all food package buttons
                if (foodPackageSelector) {
                    foodPackageSelector.querySelectorAll('.food-package-btn').forEach(function (btn) {
                        btn.classList.remove('active');
                    });
                }

                // Clear dynamic dishes UI (checkboxes remain in DOM only if user re-opens)
                if (foodPackageItemsList) {
                    foodPackageItemsList.innerHTML = '';
                }
                if (foodPackagePlaceholder) {
                    foodPackagePlaceholder.textContent = '';
                }
            }
        }
    }
    if (packageInclusionSelect) {
        packageInclusionSelect.addEventListener('change', updatePackageInclusionDetails);
        updatePackageInclusionDetails(); // initial state
    }
    
    // Book Event Button
    if (bookEventBtn) {
        bookEventBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Book Event clicked!');
            
            if (bookEventBtn.disabled) {
                console.log('Button disabled');
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
                    // User is not authenticated, redirect to login
                    alert('Please login to book an event. You will be redirected to the login page.');
                    window.location.href = '/login';
                    return;
                }
                
                // User is authenticated, proceed with booking
                // Update button text to show user is authenticated
                bookEventBtn.textContent = 'Book Event';
                bookEventBtn.title = 'Book your event';
                
                updateFullNameField();
                const formData = new FormData(form);
                
                const contactNumber = formData.get('contact_number') || '';
                if (!/^\d{11}$/.test(contactNumber)) {
                    alert('Contact number must be exactly 11 digits (e.g., 09XXXXXXXXX).');
                    document.getElementById('contact_number').focus();
                    return;
                }
                
                // Populate summary modal
                const summaryName = formData.get('full_name') || [formData.get('first_name'), formData.get('last_name')].filter(Boolean).join(' ').trim();
                document.getElementById('summary_name').textContent = summaryName;
                document.getElementById('summary_contact').textContent = formData.get('contact_number');
                document.getElementById('summary_email').textContent = formData.get('email');
                
                // Get selected event type
                const eventTypeSelect = document.getElementById('event_type_id');
                const selectedEventType = eventTypeSelect.options[eventTypeSelect.selectedIndex];
                const eventTypeName = selectedEventType ? selectedEventType.text : 'Custom Event';
                const pricing = getSelectedPricing();
                
                // Get selected venue type
                const venueTypeSelect = document.getElementById('venue_type');
                const selectedVenueType = venueTypeSelect.options[venueTypeSelect.selectedIndex];
                const venueTypeName = selectedVenueType ? selectedVenueType.text : 'Custom Venue';
                
                document.getElementById('summary_event_type').textContent = eventTypeName;
                if (summaryVenueField) {
                    summaryVenueField.textContent = venueTypeName;
                }
                document.getElementById('summary_event_date').textContent = formData.get('event_date');
                const scheduleEl = document.getElementById('summary_schedule');
                if (scheduleEl) {
                    const timeSlotOpt = eventTimeSlotSelect && eventTimeSlotSelect.options[eventTimeSlotSelect.selectedIndex];
                    const display = timeSlotOpt && timeSlotOpt.value ? (timeSlotOpt.getAttribute('data-display') || timeSlotOpt.textContent) : 'To be scheduled with admin';
                    scheduleEl.textContent = display;
                }
                document.getElementById('summary_notes').textContent = formData.get('additional_notes') || 'None';
                
                // Populate food package items
                let foodPackageText = 'None';
                const selectedFoodCheckboxes = Array.from(document.querySelectorAll('input[name="selected_food_items[]"]:checked'));
                const foodItems = selectedFoodCheckboxes
                    .map(cb => (cb.value || '').trim())
                    .filter(text => text !== '');
                if (foodItems.length > 0) {
                    foodPackageText = foodItems.join(', ');
                }
                document.getElementById('summary_food_package').textContent = foodPackageText;
                
                // Populate package inclusion summary (include details)
                const packageInclusionSelect = document.getElementById('package_inclusion_id');
                const summaryPackageInclusion = document.getElementById('summary_package_inclusion');
                if (packageInclusionSelect && summaryPackageInclusion) {
                    const selectedOpt = packageInclusionSelect.options[packageInclusionSelect.selectedIndex];
                    if (selectedOpt && selectedOpt.value) {
                        const name = selectedOpt.getAttribute('data-name') || selectedOpt.text || 'Selected';
                        const details = selectedOpt.getAttribute('data-details') || '';
                                        const esc = s => String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/\n/g, '<br>');
                        summaryPackageInclusion.innerHTML = details
                            ? `<strong>${esc(name)}</strong><br><span style="color:#b0b0b0;font-size:0.9em;">${esc(details)}</span>`
                            : esc(name);
                    } else {
                        summaryPackageInclusion.textContent = 'None';
                    }
                }
                
                // Set payment amounts based on Pax Management (fallback to event type)
                const formattedDownPayment = formatCurrency(pricing.down);
                const formattedTotalPrice = formatCurrency(pricing.full);
                const summaryDownEl = document.getElementById('summary_down_payment');
                const summaryTotalEl = document.getElementById('summary_total_price');
                if (summaryDownEl) summaryDownEl.textContent = formattedDownPayment;
                if (summaryTotalEl) summaryTotalEl.textContent = formattedTotalPrice;
                
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
    
    // Edit Booking Button
    if (editBookingBtn) {
        editBookingBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Edit Booking clicked!');
            
            // Close the summary modal
            const summaryModalElement = document.getElementById('bookingSummaryModal');
            const summaryModal = bootstrap.Modal.getInstance(summaryModalElement);
            if (summaryModal) {
                summaryModal.hide();
            }
        });
    }
    
    // Terms checkbox in summary modal
    if (agreeTermsSummaryCheckbox) {
        agreeTermsSummaryCheckbox.addEventListener('change', function() {
            console.log('Terms summary checkbox changed:', this.checked);
            
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
            console.log('Terms checkbox changed:', this.checked);
            
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
            console.log('Proceed to Payment clicked!');
            
            if (proceedToPaymentBtn.disabled) {
                console.log('Payment button disabled');
                return;
            }
            
            updateFullNameField();
            const formData = new FormData(form);
            
            // Validate form data before sending
            const submissionRequiredFields = ['first_name', 'last_name', 'contact_number', 'email', 'event_date', 'event_time_slot_id', 'event_type_id', 'venue_type_id', 'package_inclusion_id'];
            let missingFields = [];
            
            submissionRequiredFields.forEach(fieldName => {
                const value = formData.get(fieldName);
                if (!value || value.trim() === '') {
                    missingFields.push(fieldName);
                }
            });

            // Require at least one food package item to be selected
            const selectedFoodItems = document.querySelectorAll('input[name="selected_food_items[]"]:checked');
            if (!selectedFoodItems.length) {
                missingFields.push('selected_food_items (at least one food item)');
            }
            
            if (missingFields.length > 0) {
                alert('Please fill in all required fields: ' + missingFields.join(', '));
                return;
            }
            
            const contactNumber = formData.get('contact_number') || '';
            if (!/^\d{11}$/.test(contactNumber)) {
                alert('Contact number must be exactly 11 digits (e.g., 09XXXXXXXXX).');
                document.getElementById('contact_number').focus();
                return;
            }
            
            console.log('Form data being sent:', Object.fromEntries(formData));
            console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            
            fetch('/book-event', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                console.log('Response type:', response.type);
                console.log('Response URL:', response.url);
                
                if (response.status === 401 || response.status === 403) {
                    // User is not authenticated
                    alert('Please login to book an event. You will be redirected to the login page.');
                    window.location.href = '/login';
                    return;
                }
                
                if (!response.ok) {
                    // Try to get error details from response
                    return response.text().then(text => {
                        console.error('Error response text:', text);
                        let errorMessage = `HTTP error! status: ${response.status}`;
                        try {
                            const errorData = JSON.parse(text);
                            if (errorData.message) {
                                errorMessage = errorData.message;
                            } else if (errorData.errors) {
                                errorMessage = 'Validation errors: ' + JSON.stringify(errorData.errors);
                            }
                        } catch (e) {
                            console.log('Could not parse error response as JSON');
                        }
                        throw new Error(errorMessage);
                    });
                }
                
                // Check if response is JSON
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    throw new Error('Response is not JSON. Content-Type: ' + contentType);
                }
                
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
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
                    
                    // Show payment modal
                    const paymentModalElement = document.getElementById('paymentModal');
                    const paymentModal = new bootstrap.Modal(paymentModalElement);
                    paymentModal.show();
                } else {
                    console.error('Booking error:', data);
                    let errorMessage = 'Error creating booking. Please try again.';
                    
                    if (data.message) {
                        errorMessage = data.message;
                    } else if (data.errors) {
                        errorMessage = 'Validation errors: ' + JSON.stringify(data.errors);
                    }
                    
                    alert(errorMessage);
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                console.error('Error details:', error.message);
                alert('Error creating booking. Please try again. Error: ' + error.message);
            });
        });
    }
    
    // Upload Proof Button
    if (uploadProofBtn) {
        uploadProofBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Upload Proof button clicked');
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

        if (errorMessage) errorMessage.style.display = 'none';
        if (successMessage) successMessage.style.display = 'none';

        // 1) Validate file type (only images)
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!allowedTypes.includes(file.type)) {
            if (errorText) errorText.textContent = 'Only JPG, PNG, and JPEG images are allowed. Please upload a GCash receipt image.';
            if (errorMessage) errorMessage.style.display = 'block';
            return false;
        }

        // 2) Validate file size (<= 2MB)
        if (file.size > 2 * 1024 * 1024) {
            if (errorText) errorText.textContent = 'File size must be less than 2MB. Please compress your GCash receipt image.';
            if (errorMessage) errorMessage.style.display = 'block';
            return false;
        }

        // 3) Basic filename heuristic – strongly discourage non‑GCash photos
        const originalName = (file.name || '').toLowerCase();
        if (!originalName.includes('gcash') && !originalName.includes('receipt')) {
            if (errorText) errorText.textContent = 'File name must clearly indicate it is a GCash receipt (include "gcash" or "receipt"). Please rename and upload your actual GCash receipt.';
            if (errorMessage) errorMessage.style.display = 'block';
            return false;
        }

        // 4) Light-weight image validity check via Image decode and dimensions (async, for UX only)
        const img = new Image();
        img.onload = function() {
            if (img.width < 200 || img.height < 200) {
                if (errorText) errorText.textContent = 'Image is too small. Please upload a clear, high-resolution GCash receipt (minimum 200x200 pixels).';
                if (errorMessage) errorMessage.style.display = 'block';
                return;
            }
            if (successMessage) successMessage.style.display = 'block';
        };
        img.onerror = function() {
            if (errorText) errorText.textContent = 'Invalid image file. Please upload a valid GCash receipt image.';
            if (errorMessage) errorMessage.style.display = 'block';
        };

        const reader = new FileReader();
        reader.onload = function(e) { img.src = e.target.result; };
        reader.readAsDataURL(file);

        // Synchronous checks passed
        return true;
    }

    // Proof Upload Form
    if (proofUploadForm) {
        proofUploadForm.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('Proof upload form submitted');
            
            // Validate file before submission
            const fileInput = document.getElementById('payment_proof');
            if (fileInput.files.length === 0) {
                alert('Please select a GCash receipt file to upload.');
                return;
            }
            
            const file = fileInput.files[0];

            // Run basic GCash validation (type/size/name) before submitting
            if (!validateGCashReceipt(file)) {
                alert('Please upload a valid GCash receipt image (correct file name, JPG/PNG only, max 2MB, minimum 200x200px).');
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
                    const timeIn = data.booking.time_in;
                    const timeOut = data.booking.time_out;
                    let timeStr = 'To be scheduled with admin';
                    if (timeIn || timeOut) {
                        const fmt = function (t) {
                            if (!t) return '';
                            if (typeof t !== 'string') t = t.toString();
                            const m = t.match(/(\d{1,2}):(\d{2})/);
                            if (!m) return t;
                            const h = parseInt(m[1], 10);
                            const ampm = h >= 12 ? 'PM' : 'AM';
                            const h12 = h % 12 || 12;
                            return h12 + ':' + m[2] + ' ' + ampm;
                        };
                        timeStr = (fmt(timeIn) && fmt(timeOut)) ? (fmt(timeIn) + ' - ' + fmt(timeOut)) : (fmt(timeIn) || fmt(timeOut));
                    }
                    const confirmedTimeEl = document.getElementById('confirmed_event_time');
                    if (confirmedTimeEl) confirmedTimeEl.textContent = timeStr;
                    document.getElementById('confirmed_event_type').textContent = data.booking.event_type ? data.booking.event_type.name : 'Custom Event';
                    
                    // Set receipt download link
                    const downloadReceiptBtn = document.getElementById('downloadReceiptBtn');
                    if (downloadReceiptBtn) {
                        downloadReceiptBtn.href = '/event-booking/receipt/' + data.booking.id;
                        downloadReceiptBtn.onclick = function(e) {
                            e.preventDefault();
                            window.location.href = '/event-booking/receipt/' + data.booking.id;
                        };
                    }
                    
                    // Show confirmation modal
                    const confirmationModalElement = document.getElementById('confirmationModal');
                    const confirmationModal = new bootstrap.Modal(confirmationModalElement);
                    confirmationModal.show();
                    
                    // Reset form
                    document.getElementById('eventBookingForm').reset();
                    populateTimeSlots();
                    currentBooking = null;
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

    // -------------------- Food Package → Dishes dynamic view --------------------
    (function setupFoodPackageSelection() {
        const selector = document.getElementById('food_package_selector');
        const itemsList = document.getElementById('food_package_items_list');
        const placeholder = document.getElementById('food_package_placeholder');
        const baseUrl = "{{ url('/food-packages') }}";

        if (!selector || !itemsList || !baseUrl) {
            return;
        }

        // Map a package button name (e.g. "Chicken", "Dessert", "Rice", "Soup", "Bottomless Drinks")
        // into a logical category used for selection limits.
        function getCategoryForPackage(packageName) {
            if (!packageName) return null;
            const lower = String(packageName).toLowerCase();

            // Desserts
            if (lower.includes('dessert') || lower.includes('sweet')) {
                return 'dessert';
            }

            // Rice
            if (lower.includes('rice')) {
                return 'rice';
            }

            // Soup
            if (lower.includes('soup')) {
                return 'soup';
            }

            // Bottomless drinks / beverages
            if (lower.includes('bottomless') || lower.includes('drink') || lower.includes('beverage')) {
                return 'drink';
            }

            // Main dish categories: chicken, fish, vegetable, pork, beef
            const mainKeywords = ['chicken', 'fish', 'vegetable', 'veggie', 'pork', 'beef'];
            if (mainKeywords.some(k => lower.includes(k))) {
                return 'main';
            }

            return null;
        }

        function setButtonActive(btn, isActive) {
            if (!btn) return;
            if (isActive) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        }

        function updatePlaceholderVisibility() {
            if (!placeholder) return;
            const hasBlocks = !!itemsList.querySelector('.food-package-block');
            const hasActiveButtons = !!selector.querySelector('.food-package-btn.active');
            if (hasBlocks || hasActiveButtons) {
                placeholder.style.display = 'none';
            } else {
                // No active food package and no dishes shown: keep it blank.
                placeholder.textContent = '';
                placeholder.style.display = 'block';
            }
        }

        function renderFoods(foods, packageName) {
            // Replace or create block for this specific package only
            let block = itemsList.querySelector(`[data-package-block="${packageName}"]`);
            if (block) {
                block.innerHTML = '';
            } else {
                block = document.createElement('div');
                block.className = 'food-package-block';
                block.setAttribute('data-package-block', packageName);
                itemsList.appendChild(block);
            }

            // Ensure this package block is visible
            block.style.display = 'block';

            if (placeholder) {
                placeholder.style.display = 'none';
            }

            if (!foods || foods.length === 0) {
                block.innerHTML = `<div style="color:#ccc;">No dishes found for "${packageName}". Please ask our staff for today&apos;s menu.</div>`;
                itemsList.appendChild(block);
                updatePlaceholderVisibility();
                return;
            }

            const heading = document.createElement('div');
            heading.style.color = '#ddd';
            heading.style.margin = '6px 0';
            heading.style.fontWeight = '600';
            heading.textContent = `Select dishes for "${packageName}":`;
            block.appendChild(heading);

            const category = getCategoryForPackage(packageName);

            foods.forEach(food => {
                const row = document.createElement('label');
                row.style.display = 'flex';
                row.style.justifyContent = 'space-between';
                row.style.alignItems = 'center';
                row.style.padding = '5px 0';
                row.style.borderBottom = '1px solid rgba(255,255,255,0.08)';
                row.style.cursor = 'pointer';

                const left = document.createElement('div');
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.name = 'selected_food_items[]';
                checkbox.value = food.title || '';
                if (category) {
                    checkbox.setAttribute('data-food-category', category);
                }
                checkbox.style.marginRight = '8px';

                const textWrapper = document.createElement('span');
                textWrapper.innerHTML = `<strong>${food.title}</strong>` + (food.detail ? `<br><small style="color:#bbb;">${food.detail}</small>` : '');

                left.appendChild(checkbox);
                left.appendChild(textWrapper);

                const right = document.createElement('div');
                right.style.whiteSpace = 'nowrap';
                if (food.price !== null && food.price !== undefined) {
                    const amount = Number(food.price) || 0;
                    right.textContent = '₱' + amount.toLocaleString('en-US', { minimumFractionDigits: 2 });
                }

                row.appendChild(left);
                row.appendChild(right);
                block.appendChild(row);
            });

            updatePlaceholderVisibility();
        }

        selector.addEventListener('click', function (e) {
            const btn = e.target.closest('.food-package-btn');
            if (!btn) return;

            const packageName = btn.getAttribute('data-package-name');
            if (!packageName) return;

            const wasActive = btn.classList.contains('active');

            // If clicking the already active button, hide its block but keep selections
            if (wasActive) {
                setButtonActive(btn, false);
                const thisBlock = itemsList.querySelector(`[data-package-block="${packageName}"]`);
                if (thisBlock) {
                    thisBlock.style.display = 'none';
                }

                // If no other active button, show placeholder
                const anyActive = selector.querySelector('.food-package-btn.active');
                if (!anyActive) {
                    updatePlaceholderVisibility();
                }
                return;
            }

            // Make this the only active button
            selector.querySelectorAll('.food-package-btn').forEach(function (b) {
                setButtonActive(b, b === btn);
            });

            // Hide all other package blocks
            itemsList.querySelectorAll('.food-package-block').forEach(function (block) {
                block.style.display = 'none';
            });

            // If we already loaded this package once, just show it
            const existingBlock = itemsList.querySelector(`[data-package-block="${packageName}"]`);
            if (existingBlock) {
                existingBlock.style.display = 'block';
                updatePlaceholderVisibility();
                return;
            }

            if (placeholder) {
                placeholder.textContent = `Loading dishes for "${packageName}"...`;
                placeholder.style.display = 'block';
            }

            const url = `${baseUrl}/${encodeURIComponent(packageName)}/foods`;

            fetch(url, {
                headers: {
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (!data || !data.success) {
                        throw new Error('Unable to load dishes for this package.');
                    }
                    renderFoods(data.items || [], packageName);
                })
                .catch(error => {
                    console.error('Error loading food package items:', error);
                    if (placeholder) {
                        placeholder.textContent = `Unable to load dishes for "${packageName}". Please try again later.`;
                        placeholder.style.display = 'block';
                    }
                });
        });
    })();

    // Enforce per-category limits on selected dishes:
    // - Up to 5 main dishes across Chicken/Fish/Vegetable/Pork/Beef
    // - Up to 2 rice dishes
    // - Up to 2 soups
    // - Up to 2 desserts
    // - Up to 2 bottomless drinks
    document.addEventListener('change', function (e) {
        const target = e.target;
        if (!target || target.name !== 'selected_food_items[]' || !target.checked) {
            return;
        }

        const category = target.getAttribute('data-food-category');
        if (!category) {
            return;
        }

        const limits = {
            main: 5,
            rice: 2,
            soup: 2,
            dessert: 2,
            drink: 2,
        };

        const max = limits[category];
        if (!max) return;

        const selector = `input[name="selected_food_items[]"][data-food-category="${category}"]:checked`;
        const count = document.querySelectorAll(selector).length;
        if (count > max) {
            // Revert this selection and inform the user
            target.checked = false;

            let msg;
            if (category === 'main') {
                msg = 'You can only select up to 5 main dishes (chicken, fish, vegetable, pork, beef) in total.';
            } else if (category === 'rice') {
                msg = 'You can only select up to 2 rice dishes.';
            } else if (category === 'soup') {
                msg = 'You can only select up to 2 soups.';
            } else if (category === 'dessert') {
                msg = 'You can only select up to 2 desserts.';
            } else {
                msg = 'You can only select up to 2 bottomless drinks.';
            }
            alert(msg);
        }
    });

    console.log('✅ All listeners attached');
});
</script>
