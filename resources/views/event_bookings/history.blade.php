<!DOCTYPE html>
<html lang="en">
<head>
    @include('home.css')
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <title>My Event Bookings | Grandiya Venue &amp; Restaurant</title>
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

        .main-content {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
            padding-top: 60px;
        }

        .orders-container {
            overflow-x: auto;
            overflow-y: auto;
            margin: 20px 0;
            padding: 20px;
            background-color: #2c2c2c;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            max-height: calc(100vh - 180px);
            -webkit-overflow-scrolling: touch;
        }

        h2 {
            text-align: center;
            color: gold;
            margin-bottom: 20px;
            font-size: 1.8rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }

        th, td {
            padding: 15px 10px;
            text-align: center;
            border: 1px solid #444;
        }

        th {
            background-color: gold;
            color: black;
            font-weight: bold;
            font-size: 1rem;
        }

        td {
            color: white;
            vertical-align: middle;
        }

        tr:nth-child(even) {
            background-color: #333;
        }

        tr:hover {
            background-color: #444;
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

        .status-cancelled {
            background-color: #dc3545;
            color: white;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            color: skyblue;
            text-decoration: none;
            font-size: 1.1rem;
            margin-bottom: 20px;
            position: fixed;
            top: 80px;
            left: 20px;
            z-index: 999;
            background-color: rgba(27, 27, 27, 0.95);
            padding: 10px 15px;
            border-radius: 5px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }

        .back-link:hover {
            color: gold;
            background-color: rgba(27, 27, 27, 1);
            transform: translateX(-3px);
        }

        .btn-cancel {
            background-color: #6c757d;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: background-color 0.3s ease;
        }

        .btn-cancel:hover {
            background-color: #5a6268;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #ccc;
        }

        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <!-- Minimal Navbar -->
    <nav class="minimal-navbar">
    </nav>

    <div class="main-content">
        <a href="{{ route('home') }}" class="back-link">
            <span style="margin-right: 8px; font-size: 1.2rem;">←</span>
            Back to Home
        </a>

        <h2>📖 My Event Bookings</h2>

        <div class="orders-container">
            @if($bookings->isEmpty())
                <div class="empty-state">
                    <div class="empty-state-icon">📭</div>
                    <h4>No pending event bookings</h4>
                    <p>You currently have no pending event bookings. Start by booking a new event.</p>
                    <a href="{{ route('book.event') }}" class="btn btn-warning mt-3" style="font-weight: bold;">Book a New Event</a>
                </div>
            @else
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Event Date</th>
                                <th>Time</th>
                                <th>Guests</th>
                                <th>Event Type</th>
                                <th>Venue</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                                <tr data-booking-row="{{ $booking->id }}">
                                    <td>{{ $booking->event_date?->format('M d, Y') ?? '-' }}</td>
                                    <td>
                                        @php
                                            $timeIn = $booking->time_in ? \Carbon\Carbon::parse($booking->time_in)->format('h:i A') : null;
                                            $timeOut = $booking->time_out ? \Carbon\Carbon::parse($booking->time_out)->format('h:i A') : null;
                                        @endphp
                                        {{ $timeIn && $timeOut ? $timeIn . ' - ' . $timeOut : '-' }}
                                    </td>
                                    <td>{{ $booking->number_of_guests }}</td>
                                    <td>{{ optional($booking->eventType)->name ?? '-' }}</td>
                                    <td>{{ optional($booking->venueType)->name ?? '-' }}</td>
                                    <td>
                                        @php
                                            $statusClass = 'status-pending';
                                            if ($booking->status === 'Cancelled') {
                                                $statusClass = 'status-cancelled';
                                            }
                                        @endphp
                                        <span class="status-badge {{ $statusClass }}">{{ $booking->status }}</span>
                                        @if($booking->payment_proof_path)
                                            <div class="text-muted small mt-1">Payment submitted</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($booking->status === 'Pending')
                                            <button
                                                type="button"
                                                class="btn-cancel cancel-booking-btn"
                                                data-booking-id="{{ $booking->id }}">
                                                Cancel Booking
                                            </button>
                                        @else
                                            <span class="text-muted small">No actions</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.cancel-booking-btn');

        buttons.forEach(function (btn) {
            btn.addEventListener('click', function () {
                const bookingId = this.getAttribute('data-booking-id');
                if (!bookingId) return;

                if (!confirm('Are you sure you want to cancel this pending booking?')) {
                    return;
                }

                fetch("{{ route('book.event.cancel') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ booking_id: bookingId }),
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message || 'Request completed.');
                    if (data.success) {
                        const row = document.querySelector('tr[data-booking-row="' + bookingId + '"]');
                        if (row) {
                            const statusBadge = row.querySelector('.status-badge');
                            if (statusBadge) {
                                statusBadge.textContent = 'Cancelled';
                                statusBadge.classList.remove('status-pending');
                                statusBadge.classList.add('status-cancelled');
                            }

                            const cancelButton = row.querySelector('.cancel-booking-btn');
                            if (cancelButton) {
                                cancelButton.disabled = true;
                                cancelButton.textContent = 'Cancelled';
                                cancelButton.classList.add('disabled');
                            }
                        }
                    }
                })
                .catch(() => {
                    alert('An error occurred while cancelling the booking. Please try again.');
                });
            });
        });
    });
    </script>
</body>
</html>