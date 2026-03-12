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

        .notifications-container {
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

        .notification-item {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            border-left: 4px solid #667eea;
            transition: all 0.3s ease;
            position: relative;
        }

        .notification-item.unread {
            background: #e3f2fd;
            border-left-color: #2196f3;
            box-shadow: 0 5px 15px rgba(33, 150, 243, 0.1);
        }

        .notification-item.read {
            background: #f8f9fa;
            border-left-color: #ced4da;
            opacity: 0.9;
        }

        .notification-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .notification-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .notification-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2c3e50;
            margin: 0;
        }

        .notification-time {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .notification-message {
            color: #495057;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .notification-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .btn-mark-read {
            background: #28a745;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-mark-read:hover {
            background: #218838;
            transform: translateY(-1px);
        }

        .btn-delete {
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-delete:hover {
            background: #c82333;
            transform: translateY(-1px);
        }

        .search-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .search-form {
            display: flex;
            gap: 10px;
            align-items: center;
            flex: 1;
            justify-content: flex-end;
        }

        .search-input {
            min-width: 260px;
            max-width: 420px;
            width: 100%;
            padding: 10px 14px;
            border-radius: 999px;
            border: 1px solid #dee2e6;
            outline: none;
        }

        .search-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
        }

        .notification-type {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .type-event_booking {
            background: #e3f2fd;
            color: #1976d2;
        }

        .type-order, .type-order_placed, .type-order_status {
            background: #f3e5f5;
            color: #7b1fa2;
        }

        .type-reservation_approved {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .type-reservation_cancelled {
            background: #ffebee;
            color: #c62828;
        }

        .unread-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: bold;
        }

        .no-notifications {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .no-notifications i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .pagination .page-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 10px 15px;
            margin: 0 5px;
            border-radius: 20px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .pagination .page-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .pagination .page-item.active .page-link {
            background: #495057;
        }

        @media (max-width: 768px) {
            .notifications-container {
                margin: 10px;
                padding: 20px;
            }

            .page-title {
                font-size: 2rem;
            }

            .stats-cards {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            }

            .notification-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .notification-actions {
                margin-top: 10px;
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
                <div class="notifications-container">
                    <h1 class="page-title">🔔 Notifications Management</h1>
                    
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

                    <div class="search-row">
                        <div>
                            <a class="btn-mark-read" href="{{ route('admin.notification.mark_all_read') }}">Mark all as read</a>
                        </div>
                        <form class="search-form" method="GET" action="{{ route('admin.notifications') }}">
                            <input class="search-input" type="text" name="q" value="{{ request('q') }}" placeholder="Search notifications (title, message, type)..." />
                            <button class="btn-mark-read" type="submit">Search</button>
                            @if(request()->filled('q'))
                                <a class="btn-delete" href="{{ route('admin.notifications') }}">Clear</a>
                            @endif
                        </form>
                    </div>
                    
                    <!-- Notifications List -->
                    @if($notifications->count() > 0)
                        @foreach($notifications as $notification)
                        <div class="notification-item {{ $notification->is_read ? 'read' : 'unread' }}">
                            @if(!$notification->is_read)
                                <div class="unread-badge">!</div>
                            @endif
                            
                            <div class="notification-header">
                                <div>
                                    <h3 class="notification-title">{{ $notification->title ?? 'Notification' }}</h3>
                                    <span class="notification-type type-{{ $notification->type }}">
                                        {{ ucfirst(str_replace('_', ' ', $notification->type)) }}
                                    </span>
                                </div>
                                <div class="notification-time">
                                    {{ $notification->created_at->diffForHumans() }}
                                </div>
                            </div>
                            
                            <div class="notification-message">
                                {{ $notification->message }}
                            </div>
                            
                            @if($notification->order)
                            @php
                                $data = $notification->data ?? [];
                                $hasTotalData = is_array($data) && isset($data['total_items'], $data['total_price']);

                                $itemLabel = $hasTotalData
                                    ? ($data['title'] ?? ($data['total_items'] . ' items'))
                                    : $notification->order->title;

                                $quantityLabel = $hasTotalData
                                    ? $data['total_items']
                                    : $notification->order->quantity;

                                $amountValue = $hasTotalData
                                    ? $data['total_price']
                                    : $notification->order->price * $notification->order->quantity;

                                $statusLabel = $hasTotalData && isset($data['delivery_status'])
                                    ? $data['delivery_status']
                                    : $notification->order->delivery_status;
                            @endphp
                            <div style="background: #f8f9fa; padding: 10px; border-radius: 5px; margin: 10px 0; font-size: 0.9rem;">
                                <strong>🧑 Customer:</strong> {{ $notification->order->name }}
                                | <strong>📦 Item:</strong> {{ $itemLabel }} x{{ $quantityLabel }}
                                | <strong>💰 Amount:</strong> ₱{{ number_format($amountValue, 2) }}
                                | <strong>🚚 Status:</strong> {{ $statusLabel }}
                                @if($notification->order->payment_proof_path)
                                    | <strong>🧾 Payment:</strong> Proof uploaded
                                @endif
                            </div>
                            @endif

                            @if($notification->eventBooking)
                            <div style="background: #f8f9fa; padding: 10px; border-radius: 5px; margin: 10px 0; font-size: 0.9rem;">
                                <strong>🧑 Customer:</strong> {{ $notification->eventBooking->full_name }}
                                <strong>📅 Event:</strong> {{ $notification->eventBooking->event_date->format('M d, Y') }} 
                                | <strong>👥 Guests:</strong> {{ $notification->eventBooking->number_of_guests }}
                                | <strong>💰 Down Payment:</strong> ₱{{ number_format($notification->eventBooking->down_payment_amount, 2) }}
                                @if($notification->eventBooking->payment_proof_path)
                                    | <strong>🧾 Payment:</strong> Proof uploaded
                                @endif
                            </div>
                            @endif
                            
                            <div class="notification-actions">
                                <small class="text-muted">
                                    {{ $notification->created_at->format('M d, Y \a\t g:i A') }}
                                </small>

                                @if(!$notification->is_read)
                                    <a class="btn-mark-read" href="{{ route('admin.notification.mark_read', $notification->id) }}">Mark as read</a>
                                @else
                                    <span class="notification-type" style="background:#e9ecef;color:#495057;">Read</span>
                                @endif

                                <form method="POST" action="{{ route('admin.notification.delete', $notification->id) }}" onsubmit="return confirm('Delete this notification?');" style="margin:0;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-delete" type="submit">Delete</button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                        
                        <!-- Pagination -->
                        <div style="margin-top: 30px;">
                            {{ $notifications->onEachSide(1)->links('vendor.pagination.numbers-only') }}
                        </div>
                    @else
                        <div class="no-notifications">
                            <i class="fas fa-bell-slash"></i>
                            <h4>No Notifications</h4>
                            <p>There are no notifications to display at the moment.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('admin.js')
</body>
</html>
