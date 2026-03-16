<!DOCTYPE html>
<html>
<head> 
    @include('admin.css')

    <style>
        .page-header-content {
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .page-title {
            color: white;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .page-title i {
            font-size: 32px;
        }

        .stats-container {
            display: flex;
            gap: 20px;
            margin-top: 15px;
            flex-wrap: wrap;
        }

        .stat-box {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            padding: 15px 20px;
            border-radius: 8px;
            color: white;
            flex: 1;
            min-width: 150px;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .stat-number {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 14px;
            opacity: 0.9;
        }

        .orders-container {
            background: white;
            border-radius: 10px;
            overflow-x: auto;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 10px 12px 0 12px;
        }

        .orders-container table {
            min-width: 1100px;
        }

        .proof-cell {
            min-width: 120px;
            max-width: 180px;
            white-space: normal;
            word-break: break-word;
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
            font-size: 14px;
            text-align: left;
            padding: 15px 12px;
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
            padding: 12px;
            color: #1f2937;
            font-size: 14px;
            vertical-align: middle;
        }

        .food-image {
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .food-image:hover {
            transform: scale(1.05);
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-progress {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .status-way {
            background-color: #fce7f3;
            color: #9f1239;
        }

        .status-delivered {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-cancelled {
            background-color: #fee2e2;
            color: #991b1b;
        }

        /* Payment Proof Modal Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            z-index: 1000;
            animation: fadeIn 0.3s ease;
        }

        .modal-overlay.show {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #2c2c2c;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            border: 2px solid gold;
            position: relative;
            max-width: 800px;
            max-height: 80vh;
            overflow-y: auto;
        }

        .modal-close {
            position: absolute;
            top: 15px;
            right: 20px;
            background: none;
            border: none;
            color: white;
            font-size: 30px;
            cursor: pointer;
            transition: color 0.3s;
        }

        .modal-close:hover {
            color: gold;
        }

        .proof-image {
            max-width: 100%;
            max-height: 70vh;
            width: auto;
            height: auto;
            object-fit: contain;
            display: block;
            margin-left: auto;
            margin-right: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            margin: 20px 0;
        }

        .payment-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
        }

        .payment-gcash {
            background-color: #11A869;
            color: white;
        }

        .payment-cod {
            background-color: #f59e0b;
            color: white;
        }

        .view-proof-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 6px 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 2px 4px rgba(102, 126, 234, 0.3);
        }

        .view-proof-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(102, 126, 234, 0.4);
        }

        .no-proof {
            color: #f59e0b;
            font-weight: 500;
            font-style: italic;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }

        .action-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-onway {
            background: linear-gradient(135deg, #06b6d4, #0891b2);
            color: white;
        }

        .btn-delivered {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .btn-cancel {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .btn-archive {
            background: linear-gradient(135deg, #6c757d, #5a6268);
            color: white;
        }

        .btn-delete-permanent {
            background: linear-gradient(135deg, #b91c1c, #991b1b);
            color: white;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            table {
                font-size: 13px;
            }
            
            th, td {
                padding: 10px 8px;
            }
            
            .page-title {
                font-size: 24px;
            }
        }

        @media (max-width: 768px) {
            .stats-container {
                flex-direction: column;
            }
            
            .stat-box {
                width: 100%;
            }
            
            .page-title {
                font-size: 20px;
                flex-direction: column;
                align-items: flex-start;
            }
            
            .orders-container {
                overflow-x: scroll;
            }
            
            table {
                min-width: 1200px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .action-btn {
                width: 100%;
                text-align: center;
            }
        }

        /* Empty state improvements */
        .empty-state-icon {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        /* Expandable Order Groups */
        .summary-row {
            cursor: pointer;
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .summary-row:hover {
            background-color: #e9ecef !important;
        }

        .summary-row.expanded {
            background-color: #e3f2fd;
        }

        .expand-toggle {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 999px;
            margin-right: 10px;
            background: linear-gradient(135deg, #1d4ed8, #3b82f6);
            color: #f9fafb;
            box-shadow: 0 6px 15px rgba(37, 99, 235, 0.35);
            transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
            font-size: 11px;
        }

        .summary-row:hover .expand-toggle {
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.45);
        }

        .summary-row.expanded .expand-toggle {
            background: linear-gradient(135deg, #059669, #10b981);
            transform: rotate(90deg);
        }

        .order-details-row {
            display: none;
            background-color: transparent;
        }

        .order-details-row.expanded {
            display: table-row;
        }

        .summary-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .item-count-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: #f9fafb;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(124, 58, 237, 0.35);
        }

        .item-count-badge i {
            font-size: 11px;
        }

        .summary-total {
            color: #10b981;
            font-weight: 700;
            font-size: 16px;
        }

        /* Card-style layout for items inside a grouped order */
        .group-items-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            padding: 12px 4px 4px;
        }

        .group-item-card {
            flex: 1 1 260px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            background: #ffffff;
            border-radius: 12px;
            padding: 10px 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.08);
        }

        .group-item-card-main {
            flex: 1;
        }

        .group-item-title {
            font-weight: 600;
            color: #111827;
            margin-bottom: 2px;
        }

        .group-item-meta {
            font-size: 12px;
            color: #6b7280;
        }

        .group-item-price {
            font-size: 14px;
            font-weight: 600;
            color: #10b981;
            margin-top: 4px;
        }

        .group-item-notes {
            font-size: 12px;
            color: #6b7280;
            margin-top: 6px;
            word-wrap: break-word;
        }
    </style>
</head>
<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                
                <!-- Page Header with Stats -->
                <div class="page-header-content">
                    <h1 class="page-title">
                        Orders Management
                        <a href="{{ route('admin.archived_orders') }}" style="margin-left: auto; background: rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 6px; text-decoration: none; color: white; font-size: 14px; font-weight: normal;">
                            View Archived Orders
                        </a>
                    </h1>
                    
                    @if(!$orders->isEmpty())
                        @php
                            // Count based on grouped orders (what the table actually shows)
                            $groupedInProgressCount = $groupedOrders->filter(function ($customerOrders) {
                                $firstOrder = $customerOrders->first();
                                $statuses = $customerOrders->pluck('delivery_status')->unique();
                                $groupStatus = $firstOrder->delivery_status ?: ($statuses->first() ?: 'Pending');
                                return $groupStatus === 'In Progress';
                            })->count();

                            $groupedDeliveredCount = $groupedOrders->filter(function ($customerOrders) {
                                $firstOrder = $customerOrders->first();
                                $statuses = $customerOrders->pluck('delivery_status')->unique();
                                $groupStatus = $firstOrder->delivery_status ?: ($statuses->first() ?: 'Pending');
                                return $groupStatus === 'Delivered';
                            })->count();
                        @endphp

                        <div class="stats-container">
                            <div class="stat-box">
                                <div class="stat-number">{{ $groupedOrders->count() }}</div>
                                <div class="stat-label">Total Orders</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-number">{{ $groupedInProgressCount }}</div>
                                <div class="stat-label">In Progress</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-number">{{ $groupedDeliveredCount }}</div>
                                <div class="stat-label">Delivered</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-number">{{ $orders->where('payment_mode', 'GCash')->count() }}</div>
                                <div class="stat-label">GCash Orders</div>
                            </div>
                        </div>
                    @endif
                </div>

                @if($orders->isEmpty())
                    <div style="text-align: center; padding: 60px 20px; background: white; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                        <i class="fas fa-shopping-cart empty-state-icon" style="font-size: 64px; color: #cbd5e0; margin-bottom: 20px;"></i>
                        <h3 style="color: #6b7280; font-size: 24px; margin-bottom: 10px;">No Orders Yet</h3>
                        <p style="color: #9ca3af; font-size: 16px;">New orders will appear here when customers place them.</p>
                    </div>
                @else
                    <div class="orders-container">
                        <div style="display:flex; justify-content: flex-end; align-items:center; gap:8px; margin-bottom:10px;">
                            <button type="button"
                                    class="action-btn btn-delete-permanent"
                                    id="toggleOrderDeleteMode"
                                    onclick="toggleOrderDeleteMode()"
                                    style="padding:6px 12px;">
                                🗑 Select to delete
                            </button>
                            <span class="delete-mode-actions-orders" style="display:none; align-items:center; gap:8px;">
                                <button type="button"
                                        class="action-btn btn-delete-permanent"
                                        onclick="deleteSelectedOrders()"
                                        style="padding:6px 12px;">
                                    🗑 Delete Selected
                                </button>
                                <button type="button"
                                        class="action-btn btn-cancel"
                                        onclick="toggleOrderDeleteMode()"
                                        style="padding:6px 12px;">
                                    Cancel
                                </button>
                            </span>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th class="th-checkbox" style="display:none;">
                                        <input type="checkbox" id="select-all-orders">
                                    </th>
                                    <th>Image</th>
                                    <th>Customer</th>
                                    <th>Contact</th>
                                    <th>Item Details</th>
                                    <th>Payment</th>
                                    <th>Proof</th>
                                    <th>Status</th>
                                    <th>Notes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($groupedOrders as $customerKey => $customerOrders)
                                    @php
                                        $firstOrder = $customerOrders->first();
                                        $totalItems = $customerOrders->count();
                                        $totalPrice = $customerOrders->sum(function($order) {
                                            return (float)$order->price * (int)$order->quantity;
                                        });
                                        $groupKey = md5($customerKey);
                                        $hasProof = $customerOrders->whereNotNull('payment_proof_path')->count() > 0;
                                        $proofOrder = $customerOrders->whereNotNull('payment_proof_path')->first();
                                        $statuses = $customerOrders->pluck('delivery_status')->unique();
                                        $isMultipleOrders = $totalItems > 1;
                                        $orderIds = $customerOrders->pluck('id')->toArray();
                                        // Use the first order's status for all orders in the group
                                        $groupStatus = $firstOrder->delivery_status ?: ($statuses->first() ?: 'Pending');
                                    @endphp
                                    
                                    @if($isMultipleOrders)
                                    <!-- Summary Row (for multiple orders) -->
                                    <tr class="summary-row" onclick="toggleOrderDetails('{{ $groupKey }}')" data-group="{{ $groupKey }}" data-order-ids="{{ implode(',', $orderIds) }}">
                                        <td class="td-checkbox" style="display:none;">
                                            <input type="checkbox" class="order-select" value="{{ implode(',', $orderIds) }}" onclick="event.stopPropagation();">
                                        </td>
                                        <td>
                                            <div class="summary-info">
                                                <div class="expand-toggle">
                                                    <i class="fas fa-chevron-right" aria-hidden="true"></i>
                                                </div>
                                                @if($firstOrder->image)
                                                    <img width="50" height="50" src="{{ asset('food_img/'.$firstOrder->image) }}" alt="Order" class="food-image" style="object-fit: cover; border-radius: 6px;" onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2250%22 height=%2250%22 viewBox=%220 0 50 50%22%3E%3Crect fill=%22%23e5e7eb%22 width=%2250%22 height=%2250%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 fill=%229ca3af%22 font-size=%2220%22 font-family=%22sans-serif%22%3E%F0%9F%8D%94%3C/text%3E%3C/svg%3E';">
                                                @else
                                                    <div style="width: 50px; height: 50px; background: #e5e7eb; border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-shopping-cart" style="color: #9ca3af;"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div style="font-weight: 600; color: #111827;">{{ $firstOrder->name }}</div>
                                            <div style="font-size: 12px; color: #6b7280;">{{ $firstOrder->email }}</div>
                                        </td>
                                        <td>
                                            <div style="font-size: 13px;">{{ $firstOrder->phone }}</div>
                                            <div style="font-size: 12px; color: #6b7280; max-width: 150px;">{{ $firstOrder->address }}</div>
                                        </td>
                                        <td>
                                            <div class="summary-info">
                                                <span class="item-count-badge">
                                                    <i class="fas fa-layer-group"></i>
                                                    {{ $totalItems }} {{ $totalItems == 1 ? 'item' : 'items' }}
                                                </span>
                                                <span class="summary-total">Total: PHP {{ number_format($totalPrice, 2) }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if($firstOrder->payment_mode)
                                                @if($firstOrder->payment_mode == 'GCash')
                                                    <span class="payment-badge payment-gcash"><i class="fas fa-wallet"></i> GCash</span>
                                                @elseif($firstOrder->payment_mode == 'Cash On Delivery')
                                                    <span class="payment-badge payment-cod"><i class="fas fa-hand-holding-usd"></i> COD</span>
                                                @else
                                                    <span class="payment-badge">{{ $firstOrder->payment_mode }}</span>
                                                @endif
                                            @else
                                                <span class="no-proof">Not specified</span>
                                            @endif
                                        </td>
                                        <td class="proof-cell">
                                            @if($hasProof && $proofOrder)
                                                <a href="javascript:void(0);"
                                                   onclick="event.stopPropagation(); viewPaymentProof('{{ route('orders.payment_proof', $proofOrder->id) }}');"
                                                   class="view-proof-btn">
                                                    <i class="fas fa-eye"></i> View Proof
                                                </a>
                                            @else
                                                <span class="no-proof">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($groupStatus == 'In Progress')
                                                <span class="status-badge status-progress">In Progress</span>
                                            @elseif($groupStatus == 'On the Way')
                                                <span class="status-badge status-way">On the Way</span>
                                            @elseif($groupStatus == 'Delivered')
                                                <span class="status-badge status-delivered"><i class="fas fa-check"></i> Delivered</span>
                                            @elseif($groupStatus == 'Cancelled')
                                                <span class="status-badge status-cancelled"><i class="fas fa-times"></i> Cancelled</span>
                                            @else
                                                <span class="status-badge status-pending">{{ $groupStatus }}</span>
                                            @endif
                                        </td>
                                        <td style="max-width: 200px;">
                                            <div style="font-size: 13px; color: #6b7280; word-wrap: break-word;">
                                                {{ $firstOrder->notes ? (strlen($firstOrder->notes) > 50 ? substr($firstOrder->notes, 0, 50) . '...' : $firstOrder->notes) : '-' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="action-buttons" onclick="event.stopPropagation();">
                                                <a onclick="return updateAllOrdersStatus([{{ implode(',', $orderIds) }}], 'On the Way', 'Change status to: On the Way for all {{ $totalItems }} items?')" class="action-btn btn-onway" href="javascript:void(0);">
                                                    <i class="fas fa-truck"></i> On Way
                                                </a>
                                                <a onclick="return updateAllOrdersStatus([{{ implode(',', $orderIds) }}], 'Delivered', 'Mark all {{ $totalItems }} items as Delivered?')" class="action-btn btn-delivered" href="javascript:void(0);">
                                                    <i class="fas fa-check"></i> Delivered
                                                </a>
                                                <a onclick="return updateAllOrdersStatus([{{ implode(',', $orderIds) }}], 'Cancelled', 'Cancel all {{ $totalItems }} items?')" class="action-btn btn-cancel" href="javascript:void(0);">
                                                    <i class="fas fa-times"></i> Cancel
                                                </a>
                                                <a onclick="return archiveAllOrders([{{ implode(',', $orderIds) }}], 'Are you sure you want to archive all {{ $totalItems }} items?')" class="action-btn btn-archive" href="javascript:void(0);">
                                                    <i class="fas fa-archive"></i> Archive
                                                </a>
                                                <a onclick="return deleteAllOrders([{{ implode(',', $orderIds) }}], 'Permanently delete all {{ $totalItems }} orders? This cannot be undone.')" class="action-btn btn-delete-permanent" href="javascript:void(0);">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <!-- Expanded Details: show items as cards instead of table rows -->
                                    <tr class="order-details-row" data-group="{{ $groupKey }}">
                                        <td colspan="9">
                                            <div class="group-items-grid">
                                                @foreach($customerOrders as $order)
                                                    <div class="group-item-card">
                                                        <div>
                                                            @if(!empty($order->image))
                                                                <img width="60" height="60" src="{{ asset('food_img/'.$order->image) }}" alt="{{ $order->title }}" class="food-image" style="object-fit: cover; border-radius: 8px;" onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2260%22 height=%2260%22 viewBox=%220 0 60 60%22%3E%3Crect fill=%22%23e5e7eb%22 width=%2260%22 height=%2260%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 fill=%229ca3af%22 font-size=%2224%22%3E%F0%9F%8D%94%3C/text%3E%3C/svg%3E';">
                                                            @else
                                                                <div style="width: 60px; height: 60px; background: #e5e7eb; border-radius: 8px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-utensils" style="color: #9ca3af;"></i></div>
                                                            @endif
                                                        </div>
                                                        <div class="group-item-card-main">
                                                            <div class="group-item-title">{{ $order->title }}</div>
                                                            <div class="group-item-meta">
                                                                Qty: {{ $order->quantity }} • PHP {{ number_format($order->price, 2) }} each
                                                            </div>
                                                            <div class="group-item-price">
                                                                PHP {{ number_format($order->price * $order->quantity, 2) }}
                                                            </div>
                                                            @if(!empty($order->notes))
                                                                <div class="group-item-notes">
                                                                    {{ $order->notes }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                    @else
                                    <!-- Single Order Row (show all actions) -->
                                    @foreach($customerOrders as $order)
                                        <tr data-order-id="{{ $order->id }}">
                                            <td class="td-checkbox" style="display:none;">
                                                <input type="checkbox" class="order-select" value="{{ $order->id }}">
                                            </td>
                                            <td>
                                                @if(!empty($order->image))
                                                    <img width="70" height="70" src="{{ asset('food_img/'.$order->image) }}" alt="{{ $order->title }}" class="food-image" style="object-fit: cover;" onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2270%22 height=%2270%22 viewBox=%220 0 70 70%22%3E%3Crect fill=%22%23e5e7eb%22 width=%2270%22 height=%2270%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 fill=%229ca3af%22 font-size=%2228%22%3E%F0%9F%8D%94%3C/text%3E%3C/svg%3E';">
                                                @else
                                                    <div style="width: 70px; height: 70px; background: #e5e7eb; border-radius: 8px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-utensils" style="color: #9ca3af; font-size: 1.5rem;"></i></div>
                                                @endif
                                            </td>
                                            <td>
                                                <div style="font-weight: 600; color: #111827;">{{ $order->name }}</div>
                                                <div style="font-size: 12px; color: #6b7280;">{{ $order->email }}</div>
                                            </td>
                                            <td>
                                                <div style="font-size: 13px;">{{ $order->phone }}</div>
                                                <div style="font-size: 12px; color: #6b7280; max-width: 150px;">{{ $order->address }}</div>
                                            </td>
                                            <td>
                                                <div style="font-weight: 600;">{{ $order->title }}</div>
                                                <div style="font-size: 13px; color: #6b7280;">Qty: {{ $order->quantity }}</div>
                                                <div style="font-size: 14px; color: #10b981; font-weight: 600;">PHP {{ number_format($order->price * $order->quantity, 2) }}</div>
                                            </td>
                                            <td>
                                                @if($order->payment_mode)
                                                    @if($order->payment_mode == 'GCash')
                                                        <span class="payment-badge payment-gcash"><i class="fas fa-wallet"></i> GCash</span>
                                                    @elseif($order->payment_mode == 'Cash On Delivery')
                                                        <span class="payment-badge payment-cod"><i class="fas fa-hand-holding-usd"></i> COD</span>
                                                    @else
                                                        <span class="payment-badge">{{ $order->payment_mode }}</span>
                                                    @endif
                                                @else
                                                    <span class="no-proof">Not specified</span>
                                                @endif
                                            </td>
                                            <td class="proof-cell">
                                                @if($order->payment_proof_path)
                                                    <a href="javascript:void(0);"
                                                       onclick="viewPaymentProof('{{ route('orders.payment_proof', $order->id) }}');"
                                                       class="view-proof-btn">
                                                        <i class="fas fa-eye"></i> View Proof
                                                    </a>
                                                @else
                                                    <span class="no-proof">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($order->delivery_status == 'In Progress')
                                                    <span class="status-badge status-progress">In Progress</span>
                                                @elseif($order->delivery_status == 'On the Way')
                                                    <span class="status-badge status-way">On the Way</span>
                                                @elseif($order->delivery_status == 'Delivered')
                                                    <span class="status-badge status-delivered"><i class="fas fa-check"></i> Delivered</span>
                                                @elseif($order->delivery_status == 'Cancelled')
                                                    <span class="status-badge status-cancelled"><i class="fas fa-times"></i> Cancelled</span>
                                                @else
                                                    <span class="status-badge status-pending">{{ $order->delivery_status }}</span>
                                                @endif
                                            </td>
                                            <td style="max-width: 200px;">
                                                <div style="font-size: 13px; color: #6b7280; word-wrap: break-word;">
                                                    {{ $order->notes ? $order->notes : '-' }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a onclick="return confirm('Change status to: On the Way?')" class="action-btn btn-onway" href="{{ route('order.status', ['id' => $order->id, 'status' => 'On the Way']) }}">
                                                        <i class="fas fa-truck"></i> On Way
                                                    </a>
                                                    <a onclick="return confirm('Mark as Delivered?')" class="action-btn btn-delivered" href="{{ route('order.status', ['id' => $order->id, 'status' => 'Delivered']) }}">
                                                        <i class="fas fa-check"></i> Delivered
                                                    </a>
                                                    <a onclick="return confirm('Cancel this order?')" class="action-btn btn-cancel" href="{{ route('order.status', ['id' => $order->id, 'status' => 'Cancelled']) }}">
                                                        <i class="fas fa-times"></i> Cancel
                                                    </a>
                                                    <a onclick="return confirm('Are you sure you want to archive this order?')" class="action-btn btn-archive" href="{{ route('order.delete', $order->id) }}">
                                                        <i class="fas fa-archive"></i> Archive
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <!-- Payment Proof Modal -->
    <div id="payment-proof-modal" class="modal-overlay" onclick="closeProofModal(event)">
        <div class="modal-content" onclick="event.stopPropagation()">
            <button class="modal-close" onclick="closeProofModal()">&times;</button>
            <div style="text-align: center;">
                <i class="fas fa-receipt" style="font-size: 48px; color: gold; margin-bottom: 15px;"></i>
                <h2 style="color: gold; margin-bottom: 20px; font-size: 24px;">Payment Proof Receipt</h2>
                <p style="color: #ccc; margin-bottom: 25px; font-size: 14px;">Customer's uploaded payment proof</p>
            </div>
            <img id="proof-image" class="proof-image" src="" alt="Payment Proof" onerror="this.style.display='none'; document.getElementById('proof-fallback').style.display='block';">
            <div id="proof-fallback" style="display: none; text-align: center; padding: 40px 20px; background: #1f2937; border-radius: 12px; margin: 0 auto 20px; max-width: 400px;">
                <i class="fas fa-image" style="font-size: 48px; color: #6b7280; margin-bottom: 12px;"></i>
                <p style="color: #9ca3af; margin: 0; font-size: 15px;">Proof image is not available (e.g. file not on server).</p>
            </div>
            <div style="text-align: center; margin-top: 25px;">
                <button onclick="closeProofModal()" class="view-proof-btn" style="min-width: 120px;">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>

    <script>
        function viewPaymentProof(imageSrc) {
            var img = document.getElementById('proof-image');
            var fallback = document.getElementById('proof-fallback');
            img.style.display = 'block';
            fallback.style.display = 'none';
            img.src = imageSrc;
            document.getElementById('payment-proof-modal').classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeProofModal(event) {
            if (!event || event.target === event.currentTarget || event.target.classList.contains('modal-close')) {
                document.getElementById('payment-proof-modal').classList.remove('show');
                document.body.style.overflow = 'auto';
            }
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeProofModal();
            }
        });

        // Toggle order details expansion
        function toggleOrderDetails(groupKey) {
            const summaryRow = document.querySelector(`.summary-row[data-group="${groupKey}"]`);
            const detailRows = document.querySelectorAll(`.order-details-row[data-group="${groupKey}"]`);
            
            if (summaryRow && detailRows.length > 0) {
                const isExpanded = summaryRow.classList.contains('expanded');
                
                if (isExpanded) {
                    // Collapse
                    summaryRow.classList.remove('expanded');
                    detailRows.forEach(row => row.classList.remove('expanded'));
                } else {
                    // Expand
                    summaryRow.classList.add('expanded');
                    detailRows.forEach(row => row.classList.add('expanded'));
                }
            }
        }

        // Update all orders in a group with the same status
        function updateAllOrdersStatus(orderIds, status, confirmMessage) {
            if (!confirm(confirmMessage)) {
                return false;
            }

            // Disable buttons to prevent multiple clicks
            const buttons = event.target.closest('.action-buttons').querySelectorAll('a');
            buttons.forEach(btn => {
                btn.style.opacity = '0.5';
                btn.style.pointerEvents = 'none';
            });

            // Call a dedicated endpoint once to update the whole group
            const idsParam = orderIds.join(',');

            fetch(`/orders/group-status?ids=${encodeURIComponent(idsParam)}&status=${encodeURIComponent(status)}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (!data || !data.success) {
                    console.error('Group status update failed:', data);
                }
                // Reload to reflect updated statuses regardless
                window.location.reload();
            })
            .catch(error => {
                console.error('Error updating group status:', error);
                window.location.reload();
            });

            return false; // Prevent default link behavior
        }

        // Permanently delete all orders in a group (existing helper)
        function deleteAllOrders(orderIds, confirmMessage) {
            if (!confirm(confirmMessage)) {
                return false;
            }
            const ids = orderIds.join(',');
            window.location.href = '{{ url("orders/force-delete-group") }}?ids=' + encodeURIComponent(ids);
            return false;
        }

        function toggleOrderDeleteMode() {
            const on = document.body.classList.toggle('orders-delete-mode');
            const ths = document.querySelectorAll('th.th-checkbox');
            const tds = document.querySelectorAll('td.td-checkbox');
            const toggleBtn = document.getElementById('toggleOrderDeleteMode');
            const actions = document.querySelector('.delete-mode-actions-orders');

            ths.forEach(el => el.style.display = on ? 'table-cell' : 'none');
            tds.forEach(el => el.style.display = on ? 'table-cell' : 'none');

            if (toggleBtn) toggleBtn.style.display = on ? 'none' : 'inline-flex';
            if (actions) actions.style.display = on ? 'inline-flex' : 'none';

            if (!on) {
                document.querySelectorAll('.order-select').forEach(cb => cb.checked = false);
                const selectAll = document.getElementById('select-all-orders');
                if (selectAll) selectAll.checked = false;
            }
        }

        // Bulk delete selected orders (summary rows + single rows)
        function deleteSelectedOrders() {
            const checkboxes = document.querySelectorAll('.order-select:checked');
            if (!checkboxes.length) {
                alert('Please select at least one order.');
                return;
            }
            if (!confirm('Permanently delete selected orders? This cannot be undone.')) {
                return;
            }
            const allIds = [];
            checkboxes.forEach(cb => {
                const parts = String(cb.value).split(',');
                parts.forEach(id => {
                    const trimmed = id.trim();
                    if (trimmed && !allIds.includes(trimmed)) {
                        allIds.push(trimmed);
                    }
                });
            });
            if (!allIds.length) {
                alert('No valid order IDs selected.');
                return;
            }
            window.location.href = '{{ url("orders/force-delete-group") }}?ids=' + encodeURIComponent(allIds.join(','));
        }

        document.addEventListener('DOMContentLoaded', function () {
            const selectAll = document.getElementById('select-all-orders');
            if (selectAll) {
                selectAll.addEventListener('change', function () {
                    document.querySelectorAll('.order-select').forEach(cb => {
                        cb.checked = selectAll.checked;
                    });
                });
            }
        });

        // Archive all orders in a group
        function archiveAllOrders(orderIds, confirmMessage) {
            if (!confirm(confirmMessage)) {
                return false;
            }

            // Disable buttons to prevent multiple clicks
            const buttons = event.target.closest('.action-buttons').querySelectorAll('a');
            buttons.forEach(btn => {
                btn.style.opacity = '0.5';
                btn.style.pointerEvents = 'none';
            });

            let completed = 0;
            const total = orderIds.length;

            // Archive each order
            orderIds.forEach((orderId, index) => {
                fetch(`/order/delete/${orderId}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    completed++;
                    if (completed === total) {
                        // All orders archived, reload the page
                        window.location.reload();
                    }
                })
                .catch(error => {
                    console.error(`Error archiving order ${orderId}:`, error);
                    completed++;
                    if (completed === total) {
                        // Even if some failed, reload to show current state
                        window.location.reload();
                    }
                });
            });

            return false; // Prevent default link behavior
        }
    </script>

    @include('admin.js')
</body>
</html>
