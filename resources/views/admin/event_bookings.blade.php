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

        .event-bookings-container {
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

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 1rem;
            opacity: 0.9;
        }

        .section-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .section-tab {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            padding: 12px 20px;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            color: #6c757d;
        }

        .section-tab.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: #667eea;
        }

        .section-tab:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .search-filter {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .search-input, .filter-select {
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 25px;
            font-size: 14px;
            transition: all 0.3s ease;
            min-width: 200px;
        }

        .search-input:focus, .filter-select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .event-bookings-section {
            display: none;
        }

        .event-bookings-section.active {
            display: block;
        }

        .orders-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        th {
            font-weight: 600;
            font-size: 12px;
            text-align: left;
            padding: 10px 6px;
            white-space: nowrap;
            color: white;
            border-bottom: 2px solid #5a6fd8;
        }

        tbody tr {
            border-bottom: 1px solid #e5e7eb;
            transition: all 0.3s ease;
        }

        tbody tr:hover {
            background-color: #f9fafb;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        td {
            padding: 8px 6px;
            color: #1f2937;
            font-size: 12px;
            vertical-align: middle;
            word-wrap: break-word;
            max-width: 120px;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 15px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-paid {
            background: #d4edda;
            color: #155724;
        }

        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }

        .venue-badge {
            max-width: 140px;
            display: inline-block;
            white-space: normal;
            word-break: break-word;
        }

        /* Make Package Inclusion column wrap nicely so full text is visible */
        .col-package-inclusion {
            white-space: normal;
            max-width: 220px;
        }

        .package-inclusion-cell {
            max-width: 220px;
            white-space: normal;
            word-break: break-word;
        }

        .action-buttons {
            display: flex;
            gap: 4px;
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 4px 8px;
            border: none;
            border-radius: 15px;
            font-size: 0.7rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 3px;
        }


        .btn-edit {
            background: #ffc107;
            color: #212529;
        }

        .btn-archive {
            background: #6c757d;
            color: white;
        }

        .btn-status {
            background: #28a745;
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

        .btn-mark-paid {
            background: #17a2b8;
            color: white;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .no-data {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .no-data i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0;
            border: none;
        }

        .modal-title {
            font-weight: 600;
        }

        .btn-close {
            filter: invert(1);
        }

        .alert {
            border-radius: 10px;
            border: none;
            font-weight: 500;
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
        }

        .payment-proof-btn {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
            border: none;
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(23, 162, 184, 0.3);
        }

        .payment-proof-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(23, 162, 184, 0.4);
            color: white;
        }

        .payment-proof-btn i {
            margin-right: 5px;
        }

        .no-proof-text {
            color: #6c757d;
            font-style: italic;
            font-size: 0.8rem;
        }

        .food-list-modal-body {
            max-height: 400px;
            overflow-y: auto;
            background-color: #ffffff;
        }

        .food-list-modal-body ul {
            list-style: none;
            padding-left: 0;
            margin: 0;
        }

        .food-list-modal-body li {
            padding: 6px 10px;
            font-size: 0.9rem;
            color: #000000;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            th, td {
                padding: 6px 4px;
                font-size: 11px;
            }
            
            .page-title {
                font-size: 24px;
            }
        }

        @media (max-width: 768px) {
            .event-bookings-container {
                margin: 10px;
                padding: 15px;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .stats-cards {
                grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            }

            .search-filter {
                flex-direction: column;
            }

            .search-input, .filter-select {
                min-width: 100%;
            }
            
            th, td {
                padding: 4px 2px;
                font-size: 10px;
            }

            .action-buttons {
                flex-direction: column;
                gap: 2px;
            }

            .btn-action {
                font-size: 0.6rem;
                padding: 3px 6px;
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
                <div class="event-bookings-container">
                    <h1 class="page-title" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
                        <span>🎉 Event Bookings Management</span>
                        <a href="{{ route('admin.archived_event_bookings') }}" style="background: rgba(108, 117, 125, 0.2); padding: 8px 16px; border-radius: 6px; text-decoration: none; color: #6c757d; font-size: 14px; font-weight: normal; border: 1px solid #6c757d;">
                            View Archived Bookings
                        </a>
                    </h1>
                    
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
                    
                    <!-- Statistics Cards -->
                    <div class="stats-cards">
                        <div class="stat-card">
                            <div class="stat-number">{{ $eventBookings->count() }}</div>
                            <div class="stat-label">Total Bookings</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">{{ $eventBookings->where('status', 'Pending')->count() }}</div>
                            <div class="stat-label">Pending</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">{{ $eventBookings->where('status', 'Paid')->count() }}</div>
                            <div class="stat-label">Paid</div>
                        </div>
                        <div class="stat-card">
                            @php
                                $totalRevenue = $eventBookings
                                    ->where('status', 'Paid')
                                    ->sum(function ($booking) {
                                        return !is_null($booking->amount_paid)
                                            ? (float) $booking->amount_paid
                                            : (float) $booking->down_payment_amount;
                                    });
                            @endphp
                            <div class="stat-number">₱{{ number_format($totalRevenue, 2) }}</div>
                            <div class="stat-label">Total Revenue</div>
                        </div>
                    </div>

                    <!-- Section Tabs -->
                    <div class="section-tabs">
                        <div class="section-tab active" data-section="all">📊 All Bookings</div>
                        <div class="section-tab" data-section="pending">⏳ Pending</div>
                        <div class="section-tab" data-section="paid">💰 Paid</div>
                        <div class="section-tab" data-section="cancelled">❌ Cancelled</div>
                    </div>

                    <!-- Search and Filter -->
                    <div class="search-filter">
                        <input type="text" class="search-input" placeholder="🔍 Search by name or email..." id="searchInput">
                        <select class="filter-select" id="dateFilter">
                            <option value="">📅 All Dates</option>
                            <option value="today">Today</option>
                            <option value="tomorrow">Tomorrow</option>
                            <option value="week">This Week</option>
                            <option value="month">This Month</option>
                        </select>
                    </div>

                    <!-- All Bookings Section -->
                    <div id="all-section" class="event-bookings-section active">
                        <div class="orders-container">
                            <table>
                                <thead>
                                    <tr>
                                        <th>👤 Customer</th>
                                        <th>📧 Email</th>
                                        <th>📱 Contact</th>
                                        <th>🎉 Event</th>
                                        <th>🏢 Venue</th>
                                        <th>📅 Date</th>
                                        <th>🕐 Time Slot</th>
                                        <th class="col-package-inclusion">📦 Package Inclusion</th>
                                        <th>🍽 Food Package</th>
                                        <th>💰 Payment</th>
                                        <th>📊 Status</th>
                                        <th>💳 Proof</th>
                                        <th>📝 Notes</th>
                                        <th>⚡ Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($eventBookings as $booking)
                                    <tr>
                                        <td class="package-inclusion-cell">
                                            <strong>{{ $booking->full_name }}</strong>
                                        </td>
                                        <td>{{ $booking->email }}</td>
                                        <td>{{ $booking->contact_number }}</td>
                                        <td>
                                            @if($booking->eventType)
                                                <span class="venue-badge">{{ $booking->eventType->name }}</span>
                                            @else
                                                <span class="text-muted">Not specified</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($booking->venueType)
                                                <span class="venue-badge">
                                                    {{ $booking->venueType->name }}
                                                </span>
                                                @if($booking->venueType->capacity)
                                                    <br><small class="text-muted">{{ $booking->venueType->capacity }} pax capacity</small>
                                                @endif
                                            @else
                                                <span class="text-muted">Not specified</span>
                                            @endif
                                        </td>
                                        <td>{{ $booking->event_date->format('M d, Y') }}</td>
                                        <td>
                                            @if(!$booking->time_in && !$booking->time_out)
                                                <span class="text-muted">Whole day</span>
                                            @elseif($booking->time_in && $booking->time_out)
                                                {{ $booking->time_in->format('h:i A') }} – {{ $booking->time_out->format('h:i A') }}
                                            @elseif($booking->time_in)
                                                {{ $booking->time_in->format('h:i A') }}
                                            @else
                                                <span class="text-muted">Not set</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($booking->packageInclusion)
                                                @php
                                                    $minPax = $booking->packageInclusion->pax_min;
                                                    $maxPax = $booking->packageInclusion->pax_max;
                                                    $details = $booking->packageInclusion->details ?? null;
                                                @endphp
                                                <span class="venue-badge">
                                                    {{ $booking->packageInclusion->name }}
                                                </span>
                                                @if(!is_null($minPax) || !is_null($maxPax))
                                                    <br>
                                                    <small class="text-muted">
                                                        @if(!is_null($minPax) && !is_null($maxPax))
                                                            {{ $minPax }}–{{ $maxPax }} pax
                                                        @elseif(!is_null($minPax))
                                                            {{ $minPax }} pax
                                                        @else
                                                            {{ $maxPax }} pax
                                                        @endif
                                                    </small>
                                                @endif
                                                @if(!empty($details))
                                                    <br>
                                                    <button
                                                        type="button"
                                                        class="payment-proof-btn btn-sm btn-package-details"
                                                        data-name="{{ $booking->packageInclusion->name }}"
                                                        data-details="{{ e($details) }}"
                                                    >
                                                        <i class="fa fa-info-circle"></i> View Details
                                                    </button>
                                                @endif
                                            @else
                                                <span class="text-muted">Not selected</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $foodItems = $booking->selected_food_items;
                                                if (is_string($foodItems)) {
                                                    $decoded = json_decode($foodItems, true);
                                                    $foodItems = is_array($decoded) ? $decoded : [];
                                                }
                                                $hasFood = is_array($foodItems) && count($foodItems) > 0;
                                            @endphp
                                            @if($hasFood)
                                                <button
                                                    type="button"
                                                    class="payment-proof-btn btn-sm btn-food-list"
                                                    data-food='@json($foodItems)'
                                                    data-name="{{ $booking->full_name }}"
                                                >
                                                    <i class="fa fa-list"></i> View Food List
                                                </button>
                                            @else
                                                <span class="text-muted">Not specified</span>
                                            @endif
                                        </td>
                                        <td>
                                        @php
                                            $paymentLabel = $booking->payment_option === 'full_payment' ? 'Full Payment' : null;
                                            $paidAmount = !is_null($booking->amount_paid) ? $booking->amount_paid : $booking->down_payment_amount;
                                        @endphp
                                            <strong>₱{{ number_format($paidAmount, 2) }}</strong>
                                            @if($paymentLabel)
                                                <br><small class="text-muted">{{ $paymentLabel }}</small>
                                            @else
                                                <br><small class="text-muted">Pending selection</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="status-badge status-{{ strtolower($booking->status) }}">
                                                {{ $booking->status }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($booking->payment_proof_path)
                                                <button class="payment-proof-btn" onclick="viewPaymentProof('{{ Storage::url($booking->payment_proof_path) }}', '{{ $booking->full_name }}')">
                                                    <i class="fa fa-eye"></i> View GCash
                                                </button>
                                                @if($booking->hasGcashPaymentDetails())
                                                    <br><small class="text-muted">Ref: {{ $booking->gcash_reference_number }}</small>
                                                @endif
                                            @else
                                                <span class="no-proof-text">No GCash proof</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($booking->additional_notes)
                                                <span title="{{ $booking->additional_notes }}">
                                                    {{ Str::limit($booking->additional_notes, 30) }}
                                                </span>
                                            @else
                                                <span class="text-muted">No notes</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                @if($booking->status == 'Pending')
                                                    <button class="btn-action btn-mark-paid" onclick="markAsPaidAndAccept({{ $booking->id }})">
                                                        <i class="fas fa-check-circle"></i> Accept & Mark Paid
                                                    </button>
                                                    <button class="btn-action btn-cancel" onclick="cancelBooking({{ $booking->id }})">
                                                        <i class="fas fa-times"></i> Cancel
                                                    </button>
                                                @endif
                                                <a href="{{ route('admin.event_booking.delete', $booking->id) }}" 
                                                   class="btn-action btn-archive"
                                                   onclick="return confirm('Are you sure you want to archive this event booking?')">
                                                    <i class="fas fa-archive"></i> Archive
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="14" class="no-data">
                                            <i class="fas fa-calendar-times"></i>
                                            <h4>No Event Bookings Found</h4>
                                            <p>There are no event bookings to display at the moment.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Filtered Sections -->
                    @foreach(['pending', 'paid', 'cancelled'] as $status)
                    <div id="{{ $status }}-section" class="event-bookings-section">
                        <div class="orders-container">
                            <table>
                                <thead>
                                    <tr>
                                        <th>👤 Customer</th>
                                        <th>📧 Email</th>
                                        <th>📱 Contact</th>
                                        <th>🎉 Event</th>
                                        <th>🏢 Venue</th>
                                        <th>📅 Date</th>
                                        <th>🕐 Time Slot</th>
                                        <th class="col-package-inclusion">📦 Package Inclusion</th>
                                        <th>🍽 Food Package</th>
                                        <th>💰 Payment</th>
                                        <th>📊 Status</th>
                                        <th>💳 Proof</th>
                                        <th>📝 Notes</th>
                                        <th>⚡ Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $filteredBookings = $eventBookings->where('status', ucfirst($status));
                                    @endphp
                                    @forelse($filteredBookings as $booking)
                                    <tr>
                                        <td>
                                            <strong>{{ $booking->full_name }}</strong>
                                        </td>
                                        <td>{{ $booking->email }}</td>
                                        <td>{{ $booking->contact_number }}</td>
                                        <td>
                                            @if($booking->eventType)
                                                <span class="venue-badge">{{ $booking->eventType->name }}</span>
                                            @else
                                                <span class="text-muted">Not specified</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($booking->venueType)
                                                <span class="venue-badge">
                                                    {{ $booking->venueType->name }}
                                                </span>
                                                @if($booking->venueType->capacity)
                                                    <br><small class="text-muted">{{ $booking->venueType->capacity }} pax capacity</small>
                                                @endif
                                            @else
                                                <span class="text-muted">Not specified</span>
                                            @endif
                                        </td>
                                        <td>{{ $booking->event_date->format('M d, Y') }}</td>
                                        <td>
                                            @if(!$booking->time_in && !$booking->time_out)
                                                <span class="text-muted">Whole day</span>
                                            @elseif($booking->time_in && $booking->time_out)
                                                {{ $booking->time_in->format('h:i A') }} – {{ $booking->time_out->format('h:i A') }}
                                            @elseif($booking->time_in)
                                                {{ $booking->time_in->format('h:i A') }}
                                            @else
                                                <span class="text-muted">Not set</span>
                                            @endif
                                        </td>
                                        <td class="package-inclusion-cell">
                                            @if($booking->packageInclusion)
                                                @php
                                                    $minPax = $booking->packageInclusion->pax_min;
                                                    $maxPax = $booking->packageInclusion->pax_max;
                                                    $details = $booking->packageInclusion->details ?? null;
                                                @endphp
                                                <span class="venue-badge">
                                                    {{ $booking->packageInclusion->name }}
                                                </span>
                                                @if(!is_null($minPax) || !is_null($maxPax))
                                                    <br>
                                                    <small class="text-muted">
                                                        @if(!is_null($minPax) && !is_null($maxPax))
                                                            {{ $minPax }}–{{ $maxPax }} pax
                                                        @elseif(!is_null($minPax))
                                                            {{ $minPax }} pax
                                                        @else
                                                            {{ $maxPax }} pax
                                                        @endif
                                                    </small>
                                                @endif
                                                @if(!empty($details))
                                                    <br>
                                                    <button
                                                        type="button"
                                                        class="payment-proof-btn btn-sm btn-package-details"
                                                        data-name="{{ $booking->packageInclusion->name }}"
                                                        data-details="{{ e($details) }}"
                                                    >
                                                        <i class="fa fa-info-circle"></i> View Details
                                                    </button>
                                                @endif
                                            @else
                                                <span class="text-muted">Not selected</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $foodItems = $booking->selected_food_items;
                                                if (is_string($foodItems)) {
                                                    $decoded = json_decode($foodItems, true);
                                                    $foodItems = is_array($decoded) ? $decoded : [];
                                                }
                                                $hasFood = is_array($foodItems) && count($foodItems) > 0;
                                            @endphp
                                            @if($hasFood)
                                                <button
                                                    type="button"
                                                    class="payment-proof-btn btn-sm btn-food-list"
                                                    data-food='@json($foodItems)'
                                                    data-name="{{ $booking->full_name }}"
                                                >
                                                    <i class="fa fa-list"></i> View Food List
                                                </button>
                                            @else
                                                <span class="text-muted">Not specified</span>
                                            @endif
                                        </td>
                                        <td>
                                        @php
                                            $paymentLabel = $booking->payment_option === 'full_payment' ? 'Full Payment' : null;
                                            $paidAmount = !is_null($booking->amount_paid) ? $booking->amount_paid : $booking->down_payment_amount;
                                        @endphp
                                            <strong>₱{{ number_format($paidAmount, 2) }}</strong>
                                            @if($paymentLabel)
                                                <br><small class="text-muted">{{ $paymentLabel }}</small>
                                            @else
                                                <br><small class="text-muted">Pending selection</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="status-badge status-{{ strtolower($booking->status) }}">
                                                {{ $booking->status }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($booking->payment_proof_path)
                                                <button class="payment-proof-btn" onclick="viewPaymentProof('{{ Storage::url($booking->payment_proof_path) }}', '{{ $booking->full_name }}')">
                                                    <i class="fa fa-eye"></i> View GCash
                                                </button>
                                                @if($booking->hasGcashPaymentDetails())
                                                    <br><small class="text-muted">Ref: {{ $booking->gcash_reference_number }}</small>
                                                @endif
                                            @else
                                                <span class="no-proof-text">No GCash proof</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($booking->additional_notes)
                                                <span title="{{ $booking->additional_notes }}">
                                                    {{ Str::limit($booking->additional_notes, 30) }}
                                                </span>
                                            @else
                                                <span class="text-muted">No notes</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                @if($booking->status == 'Pending')
                                                    <button class="btn-action btn-mark-paid" onclick="markAsPaidAndAccept({{ $booking->id }})">
                                                        <i class="fas fa-check-circle"></i> Accept & Mark Paid
                                                    </button>
                                                    <button class="btn-action btn-cancel" onclick="cancelBooking({{ $booking->id }})">
                                                        <i class="fas fa-times"></i> Cancel
                                                    </button>
                                                @endif
                                                <a href="{{ route('admin.event_booking.delete', $booking->id) }}" 
                                                   class="btn-action btn-archive"
                                                   onclick="return confirm('Are you sure you want to archive this event booking?')">
                                                    <i class="fas fa-archive"></i> Archive
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="14" class="no-data">
                                            <i class="fas fa-calendar-times"></i>
                                            <h4>No {{ ucfirst($status) }} Bookings</h4>
                                            <p>There are no {{ $status }} event bookings at the moment.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endforeach
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
                                <option value="Cancelled">❌ Cancelled</option>
                            </select>
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

    <!-- Payment Proof Modal -->
    <div class="modal fade" id="paymentProofModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Payment Proof - <span id="customerName"></span></h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="paymentProofImage" src="" alt="Payment Proof" class="img-fluid" style="max-height: 500px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a id="downloadProof" href="" class="btn btn-primary" download>
                        <i class="fa fa-download"></i> Download
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Food List Modal -->
    <div class="modal fade" id="foodListModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Food Package - <span id="foodListCustomerName"></span></h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body food-list-modal-body">
                    <ul id="foodListModalItems"></ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Package Inclusion Details Modal -->
    <div class="modal fade" id="packageDetailsModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Package Details - <span id="packageDetailsName"></span></h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="packageDetailsBody" style="white-space: pre-line;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @include('admin.js')
    <script>
        // Tab switching functionality
        document.querySelectorAll('.section-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active class from all tabs and sections
                document.querySelectorAll('.section-tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.event-bookings-section').forEach(s => s.classList.remove('active'));
                
                // Add active class to clicked tab
                this.classList.add('active');
                
                // Show corresponding section
                const sectionId = this.getAttribute('data-section') + '-section';
                document.getElementById(sectionId).classList.add('active');
            });
        });

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const activeSection = document.querySelector('.event-bookings-section.active');
            const table = activeSection.querySelector('table');
            const rows = table.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Filter functionality
        document.getElementById('dateFilter').addEventListener('change', function() {
            filterTable();
        });

        function filterTable() {
            const dateFilter = document.getElementById('dateFilter').value;
            const activeSection = document.querySelector('.event-bookings-section.active');
            const table = activeSection.querySelector('table');
            const rows = table.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                let show = true;
                
                // Date filter
                if (dateFilter) {
                    const dateCell = row.cells[5]; // Event date column (adjusted for new layout)
                    if (dateCell) {
                        const eventDate = new Date(dateCell.textContent);
                        const today = new Date();
                        
                        switch(dateFilter) {
                            case 'today':
                                if (eventDate.toDateString() !== today.toDateString()) show = false;
                                break;
                            case 'tomorrow':
                                const tomorrow = new Date(today);
                                tomorrow.setDate(tomorrow.getDate() + 1);
                                if (eventDate.toDateString() !== tomorrow.toDateString()) show = false;
                                break;
                            case 'week':
                                const weekFromNow = new Date(today);
                                weekFromNow.setDate(weekFromNow.getDate() + 7);
                                if (eventDate < today || eventDate > weekFromNow) show = false;
                                break;
                            case 'month':
                                if (eventDate.getMonth() !== today.getMonth() || eventDate.getFullYear() !== today.getFullYear()) show = false;
                                break;
                        }
                    }
                }
                
                row.style.display = show ? '' : 'none';
            });
        }

        // Status update functionality
        function updateStatus(bookingId, currentStatus) {
            document.getElementById('bookingId').value = bookingId;
            const statusSelect = document.getElementById('statusSelect');
            statusSelect.value = currentStatus;

            // By business rule: once a booking is accepted and marked as Paid,
            // it should no longer be possible to cancel it.
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

        // Payment proof viewing functionality
        function viewPaymentProof(imageUrl, customerName) {
            document.getElementById('customerName').textContent = customerName;
            document.getElementById('paymentProofImage').src = imageUrl;
            document.getElementById('downloadProof').href = imageUrl;
            $('#paymentProofModal').modal('show');
        }

        function refreshBookings() {
            location.reload();
        }


        // Cancel booking function
        function cancelBooking(bookingId) {
            if (confirm('Are you sure you want to cancel this booking?')) {
                updateBookingStatus(bookingId, 'Cancelled', 'Booking cancelled successfully!');
            }
        }

        // Mark as paid function
        function markAsPaid(bookingId) {
            if (confirm('Mark this booking as paid?')) {
                updateBookingStatus(bookingId, 'Paid', 'Booking marked as paid successfully!');
            }
        }

        // Mark as paid and accept function
        function markAsPaidAndAccept(bookingId) {
            if (confirm('Accept the booking and mark as paid?')) {
                updateBookingStatus(bookingId, 'Paid', 'Booking accepted and marked as paid successfully!');
            }
        }

        // Generic function to update booking status
        function updateBookingStatus(bookingId, status, successMessage) {
            fetch(`/event_booking/status/${bookingId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    status: status
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    showNotification(successMessage, 'success');
                    // Reload the page to update the UI
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showNotification('Error updating booking: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error updating booking status', 'error');
            });
        }

        // Show notification function
        function showNotification(message, type) {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const icon = type === 'success' ? '✅' : '❌';
            
            const notification = document.createElement('div');
            notification.className = `alert ${alertClass} alert-dismissible fade show`;
            notification.innerHTML = `
                ${icon} ${message}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            `;
            
            // Insert at the top of the container
            const container = document.querySelector('.event-bookings-container');
            container.insertBefore(notification, container.firstChild);
            
            // Auto-dismiss after 5 seconds
            setTimeout(() => {
                notification.remove();
            }, 5000);
        }
        
        // Auto-hide any server-rendered success alerts after 5 seconds
        const initialSuccess = document.querySelectorAll('.alert.alert-success');
        if (initialSuccess.length) {
            setTimeout(() => {
                initialSuccess.forEach(el => el.remove());
            }, 5000);
        }

        // Food list modal
        document.querySelectorAll('.btn-food-list').forEach(btn => {
            btn.addEventListener('click', function () {
                const foodJson = this.getAttribute('data-food');
                const customerName = this.getAttribute('data-name') || '';

                let items = [];
                try {
                    items = foodJson ? JSON.parse(foodJson) : [];
                } catch (e) {
                    items = [];
                }

                const listContainer = document.getElementById('foodListModalItems');
                const nameSpan = document.getElementById('foodListCustomerName');

                if (nameSpan) {
                    nameSpan.textContent = customerName;
                }

                if (listContainer) {
                    listContainer.innerHTML = '';

                    if (Array.isArray(items) && items.length > 0) {
                        items.forEach(item => {
                            const li = document.createElement('li');
                            li.textContent = item;
                            listContainer.appendChild(li);
                        });
                    } else {
                        const li = document.createElement('li');
                        li.textContent = 'No food items selected.';
                        listContainer.appendChild(li);
                    }
                }

                $('#foodListModal').modal('show');
            });
        });

        // Package inclusion details modal
        document.querySelectorAll('.btn-package-details').forEach(btn => {
            btn.addEventListener('click', function () {
                const name = this.getAttribute('data-name') || '';
                const rawDetails = this.getAttribute('data-details') || '';

                const nameSpan = document.getElementById('packageDetailsName');
                const bodyDiv = document.getElementById('packageDetailsBody');

                if (nameSpan) {
                    nameSpan.textContent = name;
                }

                if (bodyDiv) {
                    const decoded = rawDetails
                        .replace(/&lt;/g, '<')
                        .replace(/&gt;/g, '>')
                        .replace(/&quot;/g, '"')
                        .replace(/&#039;/g, "'")
                        .replace(/&amp;/g, '&');
                    bodyDiv.innerHTML = decoded.replace(/\r?\n/g, '<br>');
                }

                $('#packageDetailsModal').modal('show');
            });
        });
    </script>
</body>
</html>
