<!DOCTYPE html>
<html lang="en">
<head>
    @include('home.css')
    <title>My Orders | Grandiya Venue & Restaurant</title>
    <style>
        body {
            background-color: #1b1b1b;
            color: white;
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        /* Orders Table */
        .orders-container {
            overflow-x: auto;
            margin: 20px 0;
            padding: 20px;
            background-color: #2c2c2c;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
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

        .food-title {
            font-weight: bold;
            font-size: 1.1rem;
            color: white;
            text-align: left;
            max-width: 200px;
        }

        .food-price {
            font-size: 1.1rem;
            font-weight: bold;
            color: gold;
        }

        img.order-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.3);
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

        .status-processing {
            background-color: #17a2b8;
            color: white;
        }

        .status-on-the-way {
            background-color: #007bff;
            color: white;
        }

        .status-delivered {
            background-color: #28a745;
            color: white;
        }

        .status-cancelled {
            background-color: #dc3545;
            color: white;
        }

        .main-content {
            display: block;
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            color: skyblue;
            text-decoration: none;
            font-size: 1.1rem;
            transition: color 0.3s ease;
            margin-bottom: 20px;
        }

        .back-link:hover {
            color: gold;
        }

        .empty-orders-state {
            text-align: center;
            padding: 40px 20px;
            color: #ccc;
        }

        .empty-orders-icon {
            font-size: 4rem;
            margin-bottom: 15px;
        }

        .empty-orders-state h3 {
            color: white;
            margin-bottom: 10px;
        }

        .empty-orders-state p {
            color: #bbb;
            margin-bottom: 20px;
        }

        .order-date {
            font-size: 0.9rem;
            color: #ccc;
        }

        .order-info {
            text-align: left;
            font-size: 0.9rem;
            color: #ccc;
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

        /* Responsive Design */
        @media (max-width: 768px) {
            .orders-container {
                margin: 0;
                padding: 15px;
            }
            
            table {
                min-width: 600px;
            }
            
            .food-title {
                max-width: 150px;
                font-size: 1rem;
            }
            
            img.order-img {
                width: 80px;
                height: 80px;
            }
        }

        @media (max-width: 480px) {
            .orders-container {
                margin: 5px;
                padding: 10px;
            }
            
            table {
                min-width: 500px;
            }
            
            .food-title {
                max-width: 120px;
                font-size: 0.9rem;
            }
            
            img.order-img {
                width: 60px;
                height: 60px;
            }
        }
    </style>
</head>
<body>
    @include('home.header')

    <!-- Back to Home button -->
    <div style="text-align: center; margin: 20px 0;">
        <a href="{{ url('/home') }}" class="back-link">
            <span style="margin-right: 8px; font-size: 1.2rem;">←</span>
            Back to Home
        </a>
    </div>

    <!-- Main Content Layout -->
    <div class="main-content">
        <!-- Orders Section -->
        <div class="orders-container">
            <h2 style="text-align: center; color: gold; margin-bottom: 20px; font-size: 1.8rem;">📦 My Orders</h2>
            @if(isset($orders) && count($orders) > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Order Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        @php 
                            $line_total = $order->price * $order->quantity;
                            $status = $order->delivery_status ?? 'pending';
                            $statusClass = 'status-' . str_replace(' ', '-', strtolower($status));
                            $canRequestRefund = in_array($status, ['In Progress', 'On The Way', 'Delivered']) && !$order->hasActiveReturnRefund();
                        @endphp
                        <tr>
                            <td>
                                <img src="{{ asset('food_img/'.$order->image) }}" alt="{{ $order->title }}" class="order-img">
                            </td>
                            <td>
                                <div class="food-title">{{ $order->title }}</div>
                                @if($order->address)
                                    <div class="order-info">📍 {{ $order->address }}</div>
                                @endif
                            </td>
                            <td>
                                <div class="food-price">{{ $order->quantity }}</div>
                            </td>
                            <td>
                                <div class="food-price">₱{{ number_format($order->price, 2) }}</div>
                            </td>
                            <td>
                                <div class="food-price">₱{{ number_format($line_total, 2) }}</div>
                            </td>
                            <td>
                                <span class="status-badge {{ $statusClass }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td>
                                <div class="order-date">
                                    {{ $order->created_at->format('M d, Y') }}<br>
                                    <small>{{ $order->created_at->format('h:i A') }}</small>
                                </div>
                            </td>
                            <td>
                                @if($canRequestRefund)
                                    <a href="{{ route('return_refunds.create', ['type' => 'order', 'id' => $order->id]) }}" 
                                       class="btn-view" 
                                       target="_blank"
                                       style="background-color: #ffc107; color: black; padding: 6px 12px; border-radius: 5px; text-decoration: none; font-size: 0.9rem; display: inline-block;">
                                        Request Refund
                                    </a>
                                @elseif($order->hasActiveReturnRefund())
                                    <a href="{{ route('return_refunds.index') }}" 
                                       target="_blank"
                                       style="color: #17a2b8; text-decoration: none; font-size: 0.9rem;">
                                        View Request
                                    </a>
                                @else
                                    <span style="color: #6c757d; font-size: 0.9rem;">N/A</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-orders-state">
                    <div class="empty-orders-icon">📦</div>
                    <h3>No orders yet</h3>
                    <p>Your order history will appear here once you place an order.</p>
                    <a href="{{ url('/#blog') }}" class="btn btn-more btn-custom" style="background-color: gold; color: black; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-weight: bold; display: inline-block; margin-top: 15px;">Browse Menu</a>
                </div>
            @endif
        </div>
    </div>

    @include('home.footer')
</body>
</html>

