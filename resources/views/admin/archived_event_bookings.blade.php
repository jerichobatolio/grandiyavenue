<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('admin.css')
    <style>
        body {
            background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
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
            color: white;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 15px;
        }

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            color: white;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border: 1px solid rgba(255,255,255,0.2);
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

        .orders-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        thead {
            background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
            color: white;
        }

        th {
            font-weight: 600;
            font-size: 12px;
            text-align: left;
            padding: 10px 6px;
            white-space: nowrap;
            color: white;
            border-bottom: 2px solid #5a6268;
        }

        tbody tr {
            border-bottom: 1px solid #e5e7eb;
            transition: all 0.3s ease;
            opacity: 0.85;
        }

        tbody tr:hover {
            background-color: #f9fafb;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            opacity: 1;
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

        /* Let Package Inclusion column wrap fully */
        .col-package-inclusion {
            white-space: normal;
            max-width: 220px;
        }

        .package-inclusion-cell {
            max-width: 220px;
            white-space: normal;
            word-break: break-word;
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

        .payment-proof-btn {
            background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
            border: none;
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(108, 117, 125, 0.3);
        }

        .payment-proof-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(108, 117, 125, 0.4);
            color: white;
        }

        .no-proof-text {
            color: #6c757d;
            font-style: italic;
            font-size: 0.8rem;
        }

        .page-header-content {
            padding: 20px;
            background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
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
            
            th, td {
                padding: 4px 2px;
                font-size: 10px;
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
                <div class="page-header-content">
                    <h1 class="page-title">
                        <span>Archived Event Bookings History</span>
                        <a href="{{ route('admin.event_bookings') }}" style="background: rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 6px; text-decoration: none; color: white; font-size: 14px; font-weight: normal; border: 1px solid rgba(255,255,255,0.3);">
                            View Active Bookings
                        </a>
                    </h1>
                    
                    @if(!$eventBookings->isEmpty())
                        <div class="stats-cards">
                            <div class="stat-card">
                                <div class="stat-number">{{ $eventBookings->count() }}</div>
                                <div class="stat-label">Total Archived Bookings</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-number">{{ $eventBookings->where('status', 'Paid')->count() }}</div>
                                <div class="stat-label">Paid</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-number">{{ $eventBookings->where('status', 'Cancelled')->count() }}</div>
                                <div class="stat-label">Cancelled</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-number">₱{{ number_format($eventBookings->where('status', 'Paid')->sum('down_payment_amount'), 2) }}</div>
                                <div class="stat-label">Total Value</div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="event-bookings-container">
                    @if($eventBookings->isEmpty())
                        <div class="no-data">
                            <i class="fas fa-archive"></i>
                            <h4>No Archived Event Bookings</h4>
                            <p>Archived event bookings will appear here when you archive them from the active bookings page.</p>
                        </div>
                    @else
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
                                        <th>💰 Payment</th>
                                        <th>📊 Status</th>
                                        <th>💳 Proof</th>
                                        <th>📝 Notes</th>
                                        <th>📦 Archived Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($eventBookings as $booking)
                                    <tr>
                                        <td class="package-inclusion-cell">
                                            <strong>{{ $booking->full_name }}</strong>
                                        </td>
                                        <td>{{ $booking->email }}</td>
                                        <td>{{ $booking->contact_number }}</td>
                                        <td>
                                            @if($booking->eventType)
                                                <span class="badge bg-primary">{{ $booking->eventType->name }}</span>
                                            @else
                                                <span class="text-muted">Not specified</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($booking->venueType)
                                                <span class="badge bg-info">{{ $booking->venueType->name }}</span>
                                                @if($booking->venueType->capacity)
                                                    <br><small class="text-muted">{{ $booking->venueType->capacity }} pax capacity</small>
                                                @endif
                                            @else
                                                <span class="text-muted">Not specified</span>
                                            @endif
                                        </td>
                                        <td>{{ $booking->event_date->format('M d, Y') }}</td>
                                        <td>
                                            @if($booking->time_in && $booking->time_out)
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
                                                @endphp
                                                <span class="badge bg-secondary">
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
                                            @else
                                                <span class="text-muted">Not selected</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $paymentLabel = $booking->payment_option === 'full_payment' ? 'Full Payment' : ($booking->payment_option === 'down_payment' ? 'Down Payment' : null);
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
                                                @if($booking->gcash_reference_number)
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
                                            <div style="font-size: 11px; color: #6b7280;">
                                                {{ $booking->updated_at->format('M d, Y H:i') }}
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Proof Modal -->
    <div class="modal fade" id="paymentProofModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentProofModalLabel">Payment Proof</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="paymentProofImage" src="" alt="Payment Proof" style="max-width: 100%; border-radius: 10px;">
                </div>
            </div>
        </div>
    </div>

    <script>
        function viewPaymentProof(imageSrc, customerName) {
            document.getElementById('paymentProofImage').src = imageSrc;
            document.getElementById('paymentProofModalLabel').textContent = 'Payment Proof - ' + customerName;
            $('#paymentProofModal').modal('show');
        }
    </script>

    @include('admin.js')
</body>
</html>
