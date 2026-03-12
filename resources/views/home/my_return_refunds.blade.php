<!DOCTYPE html>
<html lang="en">
<head>
    @include('home.css')
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <title>My Return/Refund Requests | Grandiya Venue & Restaurant</title>
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

        .btn-view {
            background-color: #007bff;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: background-color 0.3s ease;
        }

        .btn-view:hover {
            background-color: #0056b3;
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

        .item-type {
            font-size: 0.9rem;
            color: #ccc;
        }

        .amount {
            font-weight: bold;
            color: gold;
            font-size: 1.1rem;
        }

        .btn-request {
            background-color: #ffc107;
            color: black;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: bold;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-request:hover {
            background-color: #ffb300;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(255, 193, 7, 0.3);
        }

        .section-title {
            color: gold;
            font-size: 1.5rem;
            margin: 30px 0 20px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid gold;
        }

        .eligible-item {
            background-color: #333;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            border-left: 4px solid #ffc107;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }

        .eligible-item:hover {
            background-color: #3a3a3a;
            transform: translateX(5px);
        }

        .item-info {
            flex: 1;
        }

        .item-info h4 {
            color: white;
            margin: 0 0 5px 0;
            font-size: 1.1rem;
        }

        .item-info p {
            color: #ccc;
            margin: 5px 0;
            font-size: 0.9rem;
        }

        .item-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .item-amount {
            color: gold;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            border-bottom: 2px solid #444;
        }

        .tab {
            padding: 10px 20px;
            background: transparent;
            border: none;
            color: #ccc;
            cursor: pointer;
            font-size: 1rem;
            border-bottom: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .tab.active {
            color: gold;
            border-bottom-color: gold;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        @media (max-width: 768px) {
            .back-link {
                top: 70px;
                left: 10px;
                font-size: 0.9rem;
                padding: 8px 12px;
            }

            .main-content {
                padding-top: 50px;
            }

            .orders-container {
                max-height: calc(100vh - 150px);
                margin: 10px 0;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Minimal Navbar -->
    <nav class="minimal-navbar">
    </nav>

    <div class="main-content">
        <a href="{{ url('/home') }}" class="back-link">
            <span style="margin-right: 8px; font-size: 1.2rem;">←</span>
            Back to Home
        </a>

        <div class="orders-container">
            <h2>🔄 Return/Refund Management</h2>

            @if(session('success'))
                <div style="background-color: #28a745; color: white; padding: 12px; border-radius: 5px; margin-bottom: 20px;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background-color: #dc3545; color: white; padding: 12px; border-radius: 5px; margin-bottom: 20px;">
                    ❌ {{ session('error') }}
                </div>
            @endif

            <!-- Tabs -->
            <div class="tabs">
                <button class="tab active" onclick="showTab('eligible', this)">📦 Request Return/Refund</button>
                <button class="tab" onclick="showTab('requests', this)">📋 My Requests ({{ $returnRefunds->count() }})</button>
            </div>

            <!-- Eligible Items Tab -->
            <div id="eligible-tab" class="tab-content active">
                <h3 class="section-title">Eligible Items for Return/Refund</h3>
                
                @php
                    // Ensure we have collections and remove duplicate orders by title (e.g., "Chicken Sisig")
                    $eligibleOrders = ($eligibleOrders ?? collect())->unique('title');
                @endphp
                
                @if($eligibleOrders->count() > 0)
                    <h4 style="color: #ffc107; margin: 20px 0 15px 0; font-size: 1.2rem;">🛒 Orders</h4>
                    @foreach($eligibleOrders as $order)
                        <div class="eligible-item">
                            <div class="item-info">
                                <h4>{{ $order->title }}</h4>
                                <p>
                                    <strong>Quantity:</strong> {{ $order->quantity }} | 
                                    <strong>Status:</strong> {{ $order->delivery_status }} | 
                                    <strong>Date:</strong> {{ $order->created_at->format('M d, Y') }}
                                </p>
                                @if($order->address)
                                    <p style="color: #999; font-size: 0.85rem;">📍 {{ $order->address }}</p>
                                @endif
                            </div>
                            <div class="item-actions">
                                <span class="item-amount">₱{{ number_format($order->refund_amount, 2) }}</span>
                                <a href="{{ route('return_refunds.create', ['type' => 'order', 'id' => $order->id]) }}" class="btn-request" target="_blank">
                                    Request Refund
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">📦</div>
                        <h3>No Eligible Items</h3>
                        <p>You don't have any orders eligible for return/refund at the moment.</p>
                        <p style="margin-top: 10px; color: #999;">Eligible items include orders that are "In Progress", "On The Way", or "Delivered".</p>
                    </div>
                @endif
            </div>

            <!-- My Requests Tab -->
            <div id="requests-tab" class="tab-content">
                <h3 class="section-title">My Return/Refund Requests</h3>

                @if($returnRefunds->count() > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Item</th>
                                <th>Request Type</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date Requested</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($returnRefunds as $returnRefund)
                            @php
                                $refundable = $returnRefund->refundable;
                                $itemName = '';
                                if ($returnRefund->refundable_type === 'App\Models\EventBooking') {
                                    $itemName = ($refundable->eventType->name ?? 'Event') . ' - ' . ($refundable->event_date ? $refundable->event_date->format('M d, Y') : 'N/A');
                                } else {
                                    $itemName = $refundable->title ?? 'Order #' . $refundable->id;
                                }
                                $statusClass = 'status-' . $returnRefund->status;
                            @endphp
                            <tr>
                                <td>
                                    <span class="item-type">
                                        {{ $returnRefund->refundable_type === 'App\Models\EventBooking' ? 'Event Booking' : 'Order' }}
                                    </span>
                                </td>
                                <td style="text-align: left;">
                                    <strong>{{ $itemName }}</strong>
                                </td>
                                <td>
                                    {{ ucfirst($returnRefund->type) }}
                                </td>
                                <td>
                                    <span class="amount">₱{{ number_format($returnRefund->refund_amount, 2) }}</span>
                                </td>
                                <td>
                                    <span class="status-badge {{ $statusClass }}">
                                        {{ ucfirst($returnRefund->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div style="font-size: 0.9rem;">
                                        {{ $returnRefund->created_at->format('M d, Y') }}<br>
                                        <small style="color: #ccc;">{{ $returnRefund->created_at->format('h:i A') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('return_refunds.show', $returnRefund->id) }}" class="btn-view" target="_blank">View Details</a>
                                    @if($returnRefund->status === 'pending')
                                        <form action="{{ route('return_refunds.cancel', $returnRefund->id) }}" method="POST" style="display: inline-block; margin-left: 5px;">
                                            @csrf
                                            <button type="submit" class="btn-cancel" onclick="return confirm('Are you sure you want to cancel this request?')">Cancel</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">🔄</div>
                        <h3>No Return/Refund Requests</h3>
                        <p>You haven't submitted any return/refund requests yet.</p>
                        <p style="margin-top: 10px;">Click on "Request Return/Refund" tab to see eligible items.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Ensure scripts are loaded before initializing
        (function() {
            // Wait for all scripts to load
            function initReturnRefundPage() {
                // Re-initialize Bootstrap dropdowns
                if (typeof bootstrap !== 'undefined') {
                    try {
                        var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
                        dropdownElementList.forEach(function(dropdownToggleEl) {
                            // Dispose existing instance if any
                            var existingDropdown = bootstrap.Dropdown.getInstance(dropdownToggleEl);
                            if (existingDropdown) {
                                existingDropdown.dispose();
                            }
                            // Create new instance
                            new bootstrap.Dropdown(dropdownToggleEl);
                        });
                    } catch(e) {
                        console.log('Error re-initializing dropdowns:', e);
                    }
                }
            }
            
            // Run initialization after a short delay to ensure all scripts are loaded
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function() {
                    setTimeout(initReturnRefundPage, 200);
                });
            } else {
                setTimeout(initReturnRefundPage, 200);
            }
        })();
        
        // Namespace the function to avoid conflicts
        function showTab(tabName, element) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });
            
            // Remove active class from all tabs
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Show selected tab content
            const tabContent = document.getElementById(tabName + '-tab');
            if (tabContent) {
                tabContent.classList.add('active');
            }
            
            // Add active class to clicked tab
            if (element) {
                element.classList.add('active');
            } else if (event && event.target) {
                event.target.classList.add('active');
            }
        }

        // Initialize tabs and re-initialize Bootstrap components on page load
        // Use setTimeout to ensure this runs after other DOMContentLoaded listeners
        setTimeout(function() {
            // Ensure first tab is active
            const firstTab = document.querySelector('.tab.active');
            if (firstTab) {
                const tabName = firstTab.getAttribute('onclick');
                if (tabName && tabName.includes('eligible')) {
                    showTab('eligible', firstTab);
                }
            }
            
            // Re-initialize Bootstrap dropdowns to ensure they work after page navigation
            if (typeof bootstrap !== 'undefined') {
                try {
                    var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
                    var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                        // Destroy existing dropdown if any
                        var existingDropdown = bootstrap.Dropdown.getInstance(dropdownToggleEl);
                        if (existingDropdown) {
                            existingDropdown.dispose();
                        }
                        // Create new dropdown instance
                        return new bootstrap.Dropdown(dropdownToggleEl);
                    });
                } catch(e) {
                    console.log('Error initializing dropdowns:', e);
                }
            }
            
            // Re-initialize any other Bootstrap components if needed
            if (typeof bootstrap !== 'undefined') {
                try {
                    // Re-initialize tooltips if any
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                        var existingTooltip = bootstrap.Tooltip.getInstance(tooltipTriggerEl);
                        if (existingTooltip) {
                            existingTooltip.dispose();
                        }
                        return new bootstrap.Tooltip(tooltipTriggerEl);
                    });
                } catch(e) {
                    console.log('Error initializing tooltips:', e);
                }
            }
        }, 100);
        
        // Also run on DOMContentLoaded as backup
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(function() {
                    // Re-initialize Bootstrap dropdowns
                    if (typeof bootstrap !== 'undefined') {
                        try {
                            var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
                            var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                                var existingDropdown = bootstrap.Dropdown.getInstance(dropdownToggleEl);
                                if (existingDropdown) {
                                    existingDropdown.dispose();
                                }
                                return new bootstrap.Dropdown(dropdownToggleEl);
                            });
                        } catch(e) {
                            console.log('Error initializing dropdowns:', e);
                        }
                    }
                }, 50);
            });
        }
    </script>
</body>
</html>
