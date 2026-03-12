
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Grandiya Venue & Restaurant</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">

    <!-- Font Awesome for Bell Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Improved Typography and Text Visibility */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 1rem;
            line-height: 1.6;
            color: #333;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-weight: 700;
            line-height: 1.3;
            letter-spacing: -0.3px;
        }
        
        h1 { font-size: 2.5rem; }
        h2 { font-size: 2rem; }
        h3 { font-size: 1.75rem; }
        h4 { font-size: 1.5rem; }
        h5 { font-size: 1.25rem; }
        h6 { font-size: 1.1rem; }

        
        p {
            font-size: 1.05rem;
            line-height: 1.7;
            color: #333;
        }
        
        .text-muted {
            font-weight: 500;
        }
        
        small, .small {
            font-size: 0.95rem;
            font-weight: 500;
        }
        
        button, .btn {
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: 0.3px;
        }
        
        .form-control, .form-select, input, select, textarea {
            font-size: 1rem;
            font-weight: 500;
            line-height: 1.5;
        }
        
        .nav-link {
            font-size: 1rem;
            font-weight: 500;
            letter-spacing: 0.2px;
        }
        
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: -0.3px;
        }
        
        /* Navbar Notification */
        .position-relative .badge {
            position: absolute;
            top: 0;
            right: 0;
            font-size: 10px;
            background-color: yellow !important;
            color: black !important;
        }
        
        #notifCount {
            background-color: yellow !important;
            color: black !important;
        }

        .nav-link .fa-bell {
            font-size: 20px;
            color: white;
        }
        
        /* Cart emoji styling */
        .nav-link[href*="my_cart"] {
            font-size: 1.5rem;
            line-height: 1;
        }
        
        /* Return/Refund button styling */
        .nav-link.return-refund-btn {
            font-size: 1rem;
            white-space: nowrap;
            pointer-events: auto !important;
            cursor: pointer !important;
            z-index: 1001 !important;
            position: relative;
            display: inline-block;
            text-decoration: none !important;
        }
        
        .nav-link.return-refund-btn:hover {
            opacity: 0.8;
            transform: translateY(-1px);
            text-decoration: none !important;
        }
        
        .nav-link.return-refund-btn:active {
            transform: translateY(0);
        }

        /* Ensure notification bell is clickable */
        #notifDropdown {
            cursor: pointer !important;
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            position: relative;
            z-index: 1000;
            pointer-events: auto !important;
        }
        
        /* Ensure navigation links are clickable */
        .navbar-nav .nav-link {
            pointer-events: auto !important;
            cursor: pointer !important;
            z-index: 1000 !important;
            position: relative;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 4px;
        }
        
        /* Navigation link hover effects */
        .navbar-nav .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
            transform: translateY(-1px);
            color: #fff !important;
        }
        
        .navbar-nav .nav-link:active {
            transform: translateY(0);
            background-color: rgba(255, 255, 255, 0.2) !important;
        }
        
        /* Ensure navbar is clickable */
        .navbar-nav {
            pointer-events: auto !important;
            z-index: 1000 !important;
        }
        
        .navbar-nav .nav-item {
            pointer-events: auto !important;
            z-index: 1000 !important;
        }

        #notifDropdown:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
        }

        #notifDropdown:active {
            background-color: rgba(255, 255, 255, 0.2) !important;
        }

        .fa-bell {
            pointer-events: none;
        }

        /* Ensure the nav item is clickable */
        .nav-item.dropdown {
            position: relative;
            z-index: 1000;
        }

        /* Chatbot */
        .chatbot-icon { position: fixed; bottom: 100px; right: 20px; z-index: 3100; cursor: pointer; }
        .chatbot-icon img { width: 90px; height: 90px; border-radius: 50%; }
        .chatbot-animate { animation: bounce 2s infinite; }
        @keyframes bounce { 0%,100%{transform:translateY(0);}50%{transform:translateY(-10px);} }
        .chatbot-popup { display: none; position: fixed; bottom: 20px; right: 20px; width: 320px; background: #ffe6f0; border-radius: 12px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.3); z-index: 3000; font-family: Arial, sans-serif; }
        /* Ensure header overlay does not block navbar */
        .header .overlay { position: relative; z-index: 1000; }
        .chatbot-header { background: skyblue; color: black; padding: 12px; font-weight: bold; display:flex; justify-content:space-between; align-items:center; }
        .chatbot-body { max-height: 300px; overflow-y:auto; padding: 10px; }
        .chatbot-footer { display:flex; border-top:1px solid #ccc; }
        .chatbot-footer input { flex:1; padding:8px; border:none; outline:none; }
        .chatbot-footer button { background: skyblue; border:none; padding:8px 12px; cursor:pointer; font-weight:bold; }
        .chatbot-footer button:hover { background: deepskyblue; }
        .bot-msg { background:#f1f1f1; color:black; padding:8px 12px; margin:5px 0; border-radius:8px; text-align:left; max-width:80%; }
        .user-msg { background:#007bff; color:white; padding:8px 12px; margin:5px 0; border-radius:8px; text-align:right; max-width:80%; margin-left:auto; }
        .close-btn { cursor:pointer; font-size:18px; }
        .faq-questions { margin-top:10px; display:flex; flex-direction:column; gap:6px; }
        .faq-questions button { background:#fff; border:1px solid #ccc; border-radius:6px; padding:6px 10px; text-align:left; cursor:pointer; transition: background 0.3s; }
        .faq-questions button:hover { background:#e0f2ff; }

        /* Ensure navbar dropdown shows above overlays and is clickable */
        .navbar .dropdown-menu { 
            z-index: 2050; 
            position: absolute;
            top: 100%;
            right: 0;
            left: auto;
            transform: none;
            margin-top: 0;
        }
        .dropdown-menu .dropdown-item { cursor: pointer; }
        .custom-navbar { z-index: 2600; }
        
        /* Notification dropdown specific positioning */
        .nav-item.dropdown .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            left: auto;
            transform: none;
            margin-top: 0;
            z-index: 3000;
            border: 1px solid rgba(0,0,0,.15);
            border-radius: 0.375rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.175);
            background-color: white;
        }
        
        /* Ensure notification dropdown doesn't interfere with header content */
        .notification-item {
            position: relative;
            z-index: 1;
        }
        
        /* Fix notification item structure */
        .notification-item {
            display: block !important;
            width: 100% !important;
            text-decoration: none !important;
            color: inherit !important;
            border: none !important;
            background: transparent !important;
        }
        
        .notification-item:hover {
            background-color: #f8f9fa !important;
            text-decoration: none !important;
            color: inherit !important;
        }
        
        /* Ensure proper spacing in notification dropdown */
        .dropdown-menu .notification-item {
            padding: 10px 15px;
            margin: 0;
            border-left: 3px solid #e9ecef;
        }
        
        .dropdown-menu .notification-item.unread {
            border-left-color: #007bff;
            background-color: #f8f9ff;
        }
        
        /* Notification actions styling */
        .notification-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .delete-notification-btn {
            padding: 4px 8px;
            border: 1px solid #dc3545;
            background: transparent;
            color: #dc3545;
            border-radius: 4px;
            transition: all 0.2s ease;
            opacity: 1;
            cursor: pointer;
            font-size: 12px;
            min-width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            visibility: visible !important;
        }
        
        .delete-notification-btn:hover {
            background-color: #dc3545;
            color: white;
            opacity: 1;
            transform: scale(1.1);
        }
        
        .delete-notification-btn:active {
            transform: scale(0.95);
        }
        
        .delete-notification-btn:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.25);
        }
        
        /* Ensure dropdown positioning is correct */
        .navbar-nav .nav-item.dropdown {
            position: relative;
        }
        
        .navbar-nav .nav-item.dropdown .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            left: auto;
            transform: none;
            margin-top: 0;
            z-index: 3000;
        }
        
        .notif-dropdown-menu {
            min-width: 350px;
            max-width: 400px;
        }
        
        /* Fix any potential overflow issues */
        .navbar-nav .nav-item.dropdown .dropdown-menu.show {
            display: block;
            position: absolute;
            top: 100%;
            right: 0;
            left: auto;
        }


        /* Profile Avatar Styles */
        .profile-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            border: 2px solid #007bff;
        }

        .profile-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-img-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            font-size: 16px;
        }

        .profile-avatar-large {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto;
            background-color: #f8f9fa;
            border: 3px solid #007bff;
        }

        .profile-img-large {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-img-placeholder-large {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            font-size: 24px;
        }

        /* Profile Modal Styles */
        .profile-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 3000;
            align-items: center;
            justify-content: center;
        }

        .profile-modal.show {
            display: flex !important;
        }

        .profile-modal-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 500px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
        }

        .photo-upload-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 3000;
            align-items: center;
            justify-content: center;
        }

        .photo-upload-modal.show {
            display: flex !important;
        }

        .photo-upload-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 400px;
            width: 90%;
        }

        /* Notification Styles */
        .notification-item {
            transition: all 0.3s ease;
            cursor: pointer;
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            display: block;
            text-decoration: none;
            color: inherit;
        }

        .notification-item:hover {
            background-color: #f8f9fa !important;
            text-decoration: none;
            color: inherit;
        }

        .notification-item.unread {
            background-color: #f8f9ff;
        }

        .notification-item.read {
            opacity: 0.8;
        }

        .notification-item:active {
            background-color: #e9ecef !important;
        }

        .notification-item:focus {
            outline: 2px solid #007bff;
            outline-offset: -2px;
        }

        .notification-content p {
            font-size: 0.9rem;
        }

        .unread-indicator {
            margin-top: 5px;
        }

        /* Ensure notification items are clickable */
        .notification-item * {
            pointer-events: none;
        }

        .notification-item {
            pointer-events: auto;
            position: relative;
            z-index: 10;
        }
        
        /* Make delete button clickable */
        .delete-notification-btn {
            pointer-events: auto !important;
            z-index: 20;
            position: relative;
        }
        
        .notification-actions {
            pointer-events: auto !important;
            z-index: 20;
            position: relative;
        }
        
        /* Ensure button is always clickable */
        .notification-item .delete-notification-btn {
            pointer-events: auto !important;
            z-index: 30 !important;
            position: relative !important;
            cursor: pointer !important;
        }
        
        /* Add visual feedback for clickability */
        .notification-item:hover .delete-notification-btn {
            opacity: 1 !important;
            transform: scale(1.1);
        }
        
        /* Ensure delete button is always visible */
        .notification-actions .delete-notification-btn {
            opacity: 1 !important;
            visibility: visible !important;
            display: flex !important;
        }

        /* Override any Bootstrap dropdown interference */
        .dropdown-menu .notification-item {
            position: relative;
            z-index: 1000;
        }

        /* Mobile: dropdowns and modals fit viewport */
        @media (max-width: 991.98px) {
            .nav-item.dropdown .dropdown-menu,
            .dropdown-menu[aria-labelledby="notifDropdown"],
            .notif-dropdown-menu {
                min-width: 0 !important;
                max-width: min(400px, calc(100vw - 1.5rem)) !important;
            }
            .dropdown-menu[aria-labelledby="profileDropdown"] {
                min-width: 0 !important;
                max-width: min(320px, calc(100vw - 1.5rem)) !important;
            }
        }
        @media (max-width: 575.98px) {
            .chatbot-popup {
                left: 0.5rem;
                right: 0.5rem;
                width: auto !important;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="custom-navbar navbar navbar-expand-lg navbar-dark fixed-top" data-spy="affix" data-offset-top="10" style="background-color: rgba(33, 37, 41, 0.95);">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="#home" onclick="scrollToSection('home'); return false;">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="#about" onclick="scrollToSection('about'); return false;">About</a></li>
            <li class="nav-item"><a class="nav-link" href="#gallary" onclick="scrollToSection('gallary'); return false;">Menu</a></li>
            <li class="nav-item"><a class="nav-link" href="#book-table" onclick="scrollToSection('book-table'); return false;">Reservation</a></li>
            <li class="nav-item"><a class="nav-link" href="#book-event" onclick="scrollToSection('book-event'); return false;">📅 Book Event</a></li>
        </ul>

        <a class="navbar-brand m-auto" href="{{ url('/') }}">
            <span class="brand-txt">Grandiya Venue & Restaurant</span>
        </a>

        <ul class="navbar-nav">
            @if (Route::has('login'))
                @auth
                    <!-- Return/Refund Button -->
                    @php
                        try {
                            $buttonSettings = \App\Models\ReturnRefundButtonSetting::getSettings();
                        } catch (\Exception $e) {
                            $buttonSettings = null;
                        }
                    @endphp
                    @if($buttonSettings && $buttonSettings->is_enabled)
                        @php
                            $buttonUrl = $buttonSettings->button_link ?? '/return-refunds';
                            // Ensure the link starts with / if it's a relative path
                            if (!empty($buttonUrl) && !str_starts_with($buttonUrl, 'http') && !str_starts_with($buttonUrl, '/')) {
                                $buttonUrl = '/' . $buttonUrl;
                            }
                        @endphp
                        <li class="nav-item">
                            <a class="nav-link return-refund-btn" href="{{ url($buttonUrl) }}" title="{{ $buttonSettings->description ?? 'Return/Refund' }}">
                                {{ $buttonSettings->button_icon ?? '🔄' }} {{ $buttonSettings->button_text ?? 'Return/Refund' }}
                            </a>
                        </li>
                    @endif

                    <li class="nav-item"><a class="nav-link" href="{{url('my_cart')}}">🛒</a></li>

                    <!-- Notification Bell -->
                    <li class="nav-item dropdown">
                        <a class="nav-link position-relative" href="#" id="notifDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            <span class="badge badge-warning" id="notifCount" style="display: none;">0</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end notif-dropdown-menu" aria-labelledby="notifDropdown" style="max-height: 400px; overflow-y: auto;">
                            <div class="dropdown-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Notifications</h6>
                                <small class="text-muted" id="notifCountText">No new notifications</small>
                            </div>
                            <div class="dropdown-divider"></div>
                            <div id="notifList">
                                @forelse($notifications ?? [] as $notification)
                                    @php
                                        $data = $notification->data ?? [];
                                        $isRead = $notification->is_read;
                                        $type = $notification->type ?? 'order_status';
                                        
                                        // Handle different notification types
                                        if ($type === 'reservation_pending') {
                                            // Reservation pending notification
                                            $reservationId = $data['reservation_id'] ?? 'N/A';
                                            $date = $data['date'] ?? 'N/A';
                                            $time = $data['time'] ?? 'N/A';
                                            $timeOut = $data['time_out'] ?? null;
                                            $table = $data['table'] ?? 'N/A';
                                            $guests = $data['guests'] ?? 'N/A';
                                            $status = 'Pending';
                                            $badgeClass = 'warning';
                                        } elseif ($type === 'reservation_approved' || $type === 'reservation_cancelled') {
                                            $reservationId = $data['reservation_id'] ?? 'N/A';
                                            $date = $data['date'] ?? 'N/A';
                                            $time = $data['time'] ?? 'N/A';
                                            $timeOut = $data['time_out'] ?? null;
                                            $table = $data['table'] ?? 'N/A';
                                            $guests = $data['guests'] ?? 'N/A';
                                            $status = $type === 'reservation_approved' ? 'Approved' : 'Cancelled';
                                            $badgeClass = $type === 'reservation_approved' ? 'success' : 'danger';
                                        } elseif (
                                            $type === 'return_refund_request' ||
                                            $type === 'return_refund_approved' ||
                                            $type === 'return_refund_rejected' ||
                                            $type === 'return_refund_processed'
                                        ) {
                                            $requestId = $data['return_refund_id'] ?? 'N/A';
                                            $amount = $data['amount'] ?? null;
                                            if ($type === 'return_refund_request') {
                                                $status = 'Pending';
                                                $badgeClass = 'warning';
                                            } elseif ($type === 'return_refund_approved') {
                                                $status = 'Approved';
                                                $badgeClass = 'info';
                                            } elseif ($type === 'return_refund_rejected') {
                                                $status = 'Rejected';
                                                $badgeClass = 'danger';
                                            } else { // return_refund_processed
                                                $status = 'Refunded';
                                                $badgeClass = 'success';
                                            }
                                        } elseif ($type === 'event_booking') {
                                            // Event booking notification
                                            $bookingId = $data['booking_id'] ?? 'N/A';
                                            $status = $data['status'] ?? 'Pending';
                                            $eventDate = $data['event_date'] ?? 'N/A';
                                            $packageInclusion = $data['package_inclusion'] ?? null;
                                            $timeSlot = $data['time_slot'] ?? null;
                                            $amount = $data['amount'] ?? 0;
                                            $badgeClass = $status === 'Paid' ? 'success' : ($status === 'Cancelled' ? 'danger' : 'warning');
                                        } else {
                                            // Order notification
                                            $status = ucfirst(strtolower($data['status'] ?? 'pending'));
                                            $orderId = $data['order_id'] ?? $notification->order_id;
                                            $title = $data['title'] ?? 'Order';
                                            $price = $data['price'] ?? 0;
                                            $quantity = $data['quantity'] ?? 1;

                                            // If grouped order data exists, use real totals from notification payload
                                            $hasTotalData = is_array($data) && isset($data['total_items'], $data['total_price']);

                                            $displayTitle = $hasTotalData
                                                ? ($data['title'] ?? ($data['total_items'] . ' items'))
                                                : $title;

                                            $displayQuantity = $hasTotalData
                                                ? $data['total_items']
                                                : $quantity;

                                            $displayTotal = $hasTotalData
                                                ? $data['total_price']
                                                : ($price * $quantity);

                                            if ($hasTotalData && isset($data['delivery_status'])) {
                                                $status = ucfirst(strtolower($data['delivery_status']));
                                            }
                                        }
                                    @endphp
                                    <a href="#" class="notification-item {{ $isRead ? 'read' : 'unread' }}" 
                                       data-notification-id="{{ $notification->id }}"
                                       onclick="handleNotificationClick(event, {{ $notification->id }})">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center mb-1">
                                                    @if($type === 'reservation_pending' || $type === 'reservation_approved' || $type === 'reservation_cancelled')
                                                        <span class="badge badge-{{ $badgeClass }} mr-2">
                                                            {{ $status }}
                                                        </span>
                                                    @elseif(
                                                        $type === 'return_refund_request' ||
                                                        $type === 'return_refund_approved' ||
                                                        $type === 'return_refund_rejected' ||
                                                        $type === 'return_refund_processed'
                                                    )
                                                        <span class="badge badge-{{ $badgeClass }} mr-2">
                                                            {{ $status }}
                                                        </span>
                                                    @elseif($type === 'event_booking')
                                                        <span class="badge badge-{{ $badgeClass }} mr-2">
                                                            {{ $status }}
                                                        </span>
                                                    @else
                                                        <span class="badge badge-{{ $status === 'Delivered' ? 'success' : ($status === 'On the Way' ? 'warning' : ($status === 'Cancelled' ? 'danger' : ($status === 'Pending' ? 'warning' : 'primary'))) }} mr-2">
                                                            {{ $status }}
                                                        </span>
                                                    @endif
                                                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                                </div>
                                                <div class="notification-content">
                                                    @if($type === 'reservation_pending' || $type === 'reservation_approved' || $type === 'reservation_cancelled')
                                                        <strong>Reservation #{{ $reservationId }}</strong>
                                                        <p class="mb-1 text-dark">{{ $notification->message }}</p>
                                                        <small class="text-muted">
                                                            Date: {{ $date }} | Time In: {{ $time }}
                                                            @if(!empty($timeOut))
                                                                | Time Out: {{ $timeOut }}
                                                            @endif
                                                        </small><br>
                                                        <small class="text-muted">Table: {{ $table }} | Guests: {{ $guests }}</small>
                                                    @elseif(
                                                        $type === 'return_refund_request' ||
                                                        $type === 'return_refund_approved' ||
                                                        $type === 'return_refund_rejected' ||
                                                        $type === 'return_refund_processed'
                                                    )
                                                        <strong>Return/Refund #{{ $requestId }}</strong>
                                                        <p class="mb-1 text-dark">{{ $notification->message }}</p>
                                                        @if(!is_null($amount))
                                                            <small class="text-muted">Amount: ₱{{ number_format($amount, 2) }}</small>
                                                        @endif
                                                    @elseif($type === 'event_booking')
                                                        <strong>Event Booking #{{ $bookingId }}</strong>
                                                        <p class="mb-1 text-dark">{{ $notification->message }}</p>
                                                        <small class="text-muted">
                                                            Event Date: {{ $eventDate }}
                                                            @if(!empty($timeSlot))
                                                                | Time: {{ $timeSlot }}
                                                            @endif
                                                        </small><br>
                                                        @if(!empty($packageInclusion))
                                                            <small class="text-muted">Package: {{ $packageInclusion }}</small><br>
                                                        @endif
                                                        <small class="text-muted">Amount: ₱{{ number_format($amount, 2) }}</small>
                                                    @else
                                                        <strong>Order #{{ $orderId }}</strong>
                                                        <p class="mb-1 text-dark">
                                                            {{ $displayTitle }} (Qty: {{ $displayQuantity }})
                                                        </p>
                                                        <small class="text-muted">Customer: {{ $data['customer_name'] ?? 'N/A' }}</small><br>
                                                        <small class="text-muted">
                                                            Total: ₱{{ number_format($displayTotal, 2) }}
                                                        </small>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="notification-actions">
                                                @if(!$isRead)
                                                    <div class="unread-indicator">
                                                        <i class="fas fa-circle text-primary" style="font-size: 8px;"></i>
                                                    </div>
                                                @endif
                                                <button class="btn btn-sm btn-outline-danger delete-notification-btn" 
                                                        onclick="deleteNotification(event, {{ $notification->id }})"
                                                        title="Delete notification"
                                                        type="button"
                                                        aria-label="Delete notification"
                                                        style="opacity: 1 !important; visibility: visible !important;">
                                                    <i class="fas fa-trash" style="font-size: 12px;"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </a>
                                    @if(!$loop->last)
                                        <div class="dropdown-divider"></div>
                                    @endif
                                @empty
                                    <div class="text-center py-3">
                                        <i class="fas fa-bell-slash text-muted mb-2" style="font-size: 2rem;"></i>
                                        <p class="text-muted mb-0">No notifications yet</p>
                                        <small class="text-muted">You'll see order, reservation, and event booking updates here</small>
                                    </div>
                                @endforelse
                            </div>
                            @if(count($notifications ?? []) > 0)
                                <div class="dropdown-divider"></div>
                                <div class="text-center py-2">
                                    <small class="text-muted">
                                        <i class="fas fa-hand-pointer mr-1"></i>
                                        Click on a notification to mark as read
                                    </small>
                                </div>
                            @endif
                        </div>
                    </li>

                    <li class="nav-item"><a class="nav-link" href="#blog">Delivery</a></li>

                    <!-- Profile Account Dropdown (uses Jetstream URL + cache bust so new photo shows after upload) -->
                    @php
                        $authUser = auth()->user();
                        $profilePhotoSrc = $authUser && $authUser->profile_photo_path
                            ? ($authUser->profile_photo_url . '?v=' . ($authUser->updated_at?->timestamp ?? time()))
                            : null;
                    @endphp
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="profile-avatar">
                                @if($profilePhotoSrc)
                                    <img src="{{ $profilePhotoSrc }}" alt="Profile" class="profile-img">
                                @else
                                    <div class="profile-img-placeholder">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                            </div>
                            <span class="ml-2">{{ $authUser ? $authUser->name : 'User' }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown" style="min-width: 250px;">
                            <div class="dropdown-header text-center">
                                <div class="profile-avatar-large mb-2">
                                    @if($profilePhotoSrc)
                                        <img src="{{ $profilePhotoSrc }}" alt="Profile" class="profile-img-large">
                                    @else
                                        <div class="profile-img-placeholder-large">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    @endif
                                </div>
                                <h6 class="mb-0">{{ $authUser ? $authUser->name : 'User' }}</h6>
                                <small class="text-muted">{{ $authUser ? $authUser->email : 'user@example.com' }}</small>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" onclick="openProfileModal(); return false;">
                                <i class="fas fa-user-edit mr-2"></i>Edit Profile
                            </a>
                            <a class="dropdown-item" href="#" onclick="openPhotoUpload(); return false;">
                                <i class="fas fa-camera mr-2"></i>Change Photo
                            </a>
                            <div class="dropdown-divider"></div>
                            <form action="{{route('logout')}}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </button>
                            </form>
                        </div>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="#blog">Delivery</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('login')}}">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('register')}}">Register</a></li>
                @endauth
            @endif
        </ul>
    </div>
</nav>

<!-- header -->
<header id="home" class="header" style="background-image: url('{{ asset('assets/imgs/main.jpg') }}'); background-size: cover; background-position: center; min-height: 750px;">
    <div class="overlay text-white text-center" style="padding-top: 18vh; padding-bottom: 12vh;">
        <h1 class="display-2 font-weight-bold my-3">Grandiya Venue And Restaurant</h1>
        <h2 class="display-4 mb-5 text-white">Booking and Reservation System</h2>
        <a class="btn btn-lg btn-primary" href="#gallary">View Our Menu</a>
    </div>
</header>

<!-- Chatbot Icon -->
<div id="chatbotIcon" class="chatbot-icon">
    <img src="{{ asset('assets/imgs/chatbot.png') }}" class="chatbot-animate" alt="">
</div>

<!-- Chatbot Popup -->
<div id="chatbotPopup" class="chatbot-popup">
    <div class="chatbot-header">
        <strong>Grandiya Assistant (FAQ)</strong>
        <span class="close-btn" id="chatbotClose">×</span>
    </div>
    <div class="chatbot-body">
        <div class="bot-msg">Hello! How can I help you today?</div>
    </div>
    <div class="chatbot-footer">
        <input type="text" id="userInput" placeholder="Type a message...">
        <button onclick="sendMessageBtn()">Send</button>
    </div>
</div>

<!-- Profile Edit Modal -->
<div id="profileModal" class="profile-modal" onclick="closeProfileModal(event)">
    <div class="profile-modal-content" onclick="event.stopPropagation()">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Edit Profile</h4>
            <button type="button" class="close" onclick="closeProfileModal()">&times;</button>
        </div>
        <form id="profileForm" action="{{ route('profile.inline.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ auth()->check() ? auth()->user()->name : '' }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ auth()->check() ? auth()->user()->email : '' }}" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" class="form-control" id="phone" name="phone" value="{{ auth()->check() ? (auth()->user()->phone ?? '') : '' }}">
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <textarea class="form-control" id="address" name="address" rows="3">{{ auth()->check() ? (auth()->user()->address ?? '') : '' }}</textarea>
            </div>
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-secondary mr-2" onclick="closeProfileModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<!-- Photo Upload Modal -->
<div id="photoUploadModal" class="photo-upload-modal" onclick="closePhotoUpload(event)">
    <div class="photo-upload-content" onclick="event.stopPropagation()">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Change Profile Photo</h4>
            <button type="button" class="close" onclick="closePhotoUpload()">&times;</button>
        </div>
        <form id="photoUploadForm" action="{{ route('profile.inline.photo') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="text-center mb-3">
                <div class="profile-avatar-large mb-3" id="currentPhotoPreview">
                    @if($profilePhotoSrc ?? null)
                        <img src="{{ $profilePhotoSrc }}" alt="Profile" class="profile-img-large">
                    @else
                        <div class="profile-img-placeholder-large">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                </div>
                <p class="text-muted">Current photo</p>
            </div>
            <div class="form-group">
                <label for="photo">Select New Photo</label>
                <input type="file" class="form-control-file" id="photo" name="photo" accept="image/*" onchange="previewPhoto(this)">
            </div>
            <div class="text-center mb-3" id="newPhotoPreview" style="display: none;">
                <div class="profile-avatar-large mb-2">
                    <img id="previewImg" src="" alt="Preview" class="profile-img-large">
                </div>
                <p class="text-muted">New photo preview</p>
            </div>
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-secondary mr-2" onclick="closePhotoUpload()">Cancel</button>
                <button type="submit" class="btn btn-primary">Update Photo</button>
            </div>
        </form>
    </div>
</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Prepare FAQ data for chatbot (fallback to defaults if none configured)
    @php
        $faqItems = isset($faqs) && count($faqs)
            ? $faqs->map(function ($faq) {
                return [
                    'question' => $faq->question,
                    'answer' => $faq->answer,
                ];
            })->toArray()
            : [
                [
                    'question' => 'How do I reserve a table?',
                    'answer' => "Navigate to the 'Reservation' section, fill in your details and preferred date/time, then submit your reservation.",
                ],
                [
                    'question' => 'How do I book an event?',
                    'answer' => "Go to the 'Book Event' section, provide event details including event type, venue, date, and number of guests, then complete your booking.",
                ],
                [
                    'question' => 'What payment methods do you accept?',
                    'answer' => 'We accept cash and online payments. A deposit is required upon booking with the balance due on event day.',
                ],
                [
                    'question' => 'Can I cancel my reservation?',
                    'answer' => 'Yes. You can cancel reservations from your account. Please review our cancellation policy for any applicable fees.',
                ],
            ];
    @endphp
    const GRANDIYA_FAQS = @json($faqItems);

    // Enable Bootstrap 5 dropdowns explicitly
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize all dropdowns using Bootstrap 5 API
        var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
        var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
            return new bootstrap.Dropdown(dropdownToggleEl);
        });
        
        // Ensure clicking the trigger with href="#" doesn't navigate (only for dropdown toggles)
        document.addEventListener('click', function(e) {
            if (e.target.matches('a.dropdown-toggle[href="#"]')) {
                e.preventDefault();
            }
        });
        
        // Keep dropdown open while interacting with forms inside
        document.addEventListener('click', function(e) {
            if (e.target.closest('.dropdown-menu.keep-open-on-click, .dropdown-menu .keep-open-on-click, .dropdown-menu input, .dropdown-menu label, .dropdown-menu button')) {
                e.stopPropagation();
            }
        });

        // Force dropdown to work on notification bell
        const notifDropdown = document.getElementById('notifDropdown');
        if (notifDropdown) {
            notifDropdown.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Toggle dropdown manually using Bootstrap 5
                const dropdownMenu = this.nextElementSibling;
                const bsDropdown = bootstrap.Dropdown.getInstance(this) || new bootstrap.Dropdown(this);
                
                if (dropdownMenu.classList.contains('show')) {
                    bsDropdown.hide();
                } else {
                    bsDropdown.show();
                }
            });
        }

        // Force dropdown to work on profile dropdown
        const profileDropdown = document.getElementById('profileDropdown');
        if (profileDropdown) {
            profileDropdown.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Profile dropdown clicked');
                
                // Toggle dropdown manually using Bootstrap 5
                const dropdownMenu = this.nextElementSibling;
                const bsDropdown = bootstrap.Dropdown.getInstance(this) || new bootstrap.Dropdown(this);
                
                if (dropdownMenu.classList.contains('show')) {
                    bsDropdown.hide();
                } else {
                    bsDropdown.show();
                }
            });
        }
    });

    // Chatbot logic
    const chatbotIcon = document.getElementById("chatbotIcon");
    const chatbotPopup = document.getElementById("chatbotPopup");
    const chatbotClose = document.getElementById("chatbotClose");
    const chatbotBody = document.querySelector(".chatbot-body");

    chatbotIcon.addEventListener("click", () => {
        chatbotIcon.style.display = "none";
        chatbotPopup.style.display = "block";
        if (!document.querySelector(".faq-questions")) {
            let faqDiv = document.createElement("div");
            faqDiv.className = "faq-questions";

            if (Array.isArray(GRANDIYA_FAQS) && GRANDIYA_FAQS.length > 0) {
                GRANDIYA_FAQS.forEach((item) => {
                    const question = (item && item.question ? String(item.question) : "").trim();
                    const answer = item && item.answer != null ? String(item.answer) : "";

                    if (!question) return;

                    const btn = document.createElement("button");
                    btn.type = "button";
                    btn.textContent = question;
                    btn.addEventListener("click", () => faqReply(question, answer));
                    faqDiv.appendChild(btn);
                });
            }
            chatbotBody.appendChild(faqDiv);
        }
    });

    chatbotClose.addEventListener("click", () => {
        chatbotPopup.style.display = "none";
        chatbotIcon.style.display = "block";
    });

    function faqReply(question, answerFromDb) {
        let userMsg = document.createElement("div");
        userMsg.className = "user-msg";
        userMsg.innerText = question;
        chatbotBody.appendChild(userMsg);

        let botMsg = document.createElement("div");
        botMsg.className = "bot-msg";
        if (answerFromDb && answerFromDb.trim() !== "") {
            botMsg.innerText = answerFromDb;
        } else if (question.toLowerCase().includes("reserve a table") || question.toLowerCase().includes("book a table")) {
            botMsg.innerText = "Navigate to the 'Reservation' section, fill in your details and preferred date/time, then submit your reservation.";
        } else if (question.toLowerCase().includes("book an event") || question.toLowerCase().includes("event")) {
            botMsg.innerText = "Go to the 'Book Event' section, provide event details including event type, venue, date, and number of guests, then complete your booking.";
        } else if (question.toLowerCase().includes("payment")) {
            botMsg.innerText = "We accept cash and online payments. A deposit is required upon booking with balance due on event day.";
        } else if (question.toLowerCase().includes("cancel")) {
            botMsg.innerText = "Yes. You can cancel reservations from your account. Please review our cancellation policy for any applicable fees.";
        } else {
            botMsg.innerText = "Thanks for your question! Feel free to ask more about our services.";
        }
        chatbotBody.appendChild(botMsg);
        chatbotBody.scrollTop = chatbotBody.scrollHeight;
    }

    function sendMessageBtn() {
        let input = document.getElementById("userInput");
        let msg = input.value.trim(); if (msg === "") return;
        let userMsg = document.createElement("div");
        userMsg.className = "user-msg";
        userMsg.innerText = msg;
        chatbotBody.appendChild(userMsg);

        let botMsg = document.createElement("div");
        botMsg.className = "bot-msg";
        // Try to answer from configured FAQs (admin-managed)
        const msgLower = msg.toLowerCase();
        const match = Array.isArray(GRANDIYA_FAQS)
            ? GRANDIYA_FAQS.find((item) => {
                const q = (item && item.question ? String(item.question) : "").toLowerCase();
                return q && (q === msgLower || q.includes(msgLower) || msgLower.includes(q));
            })
            : null;

        if (match && match.answer && String(match.answer).trim() !== "") {
            botMsg.innerText = String(match.answer);
        } else {
            botMsg.innerText = "Thanks for your message!";
        }
        chatbotBody.appendChild(botMsg);

        chatbotBody.scrollTop = chatbotBody.scrollHeight;
        input.value = "";
    }

    // Profile Modal Functions
    function openProfileModal() {
        console.log('Opening profile modal...');
        const modal = document.getElementById('profileModal');
        if (modal) {
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
            console.log('Profile modal opened successfully');
        } else {
            console.error('Profile modal element not found');
        }
    }

    function closeProfileModal(event) {
        if (!event || event.target === event.currentTarget || event.target.classList.contains('close')) {
            document.getElementById('profileModal').classList.remove('show');
            document.body.style.overflow = 'auto';
        }
    }

    function openPhotoUpload() {
        console.log('Opening photo upload modal...');
        const modal = document.getElementById('photoUploadModal');
        if (modal) {
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
            console.log('Photo upload modal opened successfully');
        } else {
            console.error('Photo upload modal element not found');
        }
    }

    function closePhotoUpload(event) {
        if (!event || event.target === event.currentTarget || event.target.classList.contains('close')) {
            document.getElementById('photoUploadModal').classList.remove('show');
            document.body.style.overflow = 'auto';
        }
    }


    function previewPhoto(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('newPhotoPreview').style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Close modals with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeProfileModal();
            closePhotoUpload();
        }
    });

    // Simple notification click handler
    function handleNotificationClick(event, notificationId) {
        event.preventDefault();
        event.stopPropagation();
        
        console.log('handleNotificationClick called for notification:', notificationId);
        
        // Mark as read automatically
        markNotificationAsRead(notificationId);
        
        return false;
    }

    // Mark notification as read
    function markNotificationAsRead(notificationId) {
        console.log('Attempting to mark notification as read:', notificationId);
        fetch(`/customer/notifications/${notificationId}/read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                // Update the notification item visually
                const notificationItem = document.querySelector(`[data-notification-id="${notificationId}"]`);
                if (notificationItem) {
                    notificationItem.classList.remove('unread');
                    notificationItem.classList.add('read');
                    notificationItem.style.borderLeftColor = '#e9ecef';
                    
                    // Remove unread indicator
                    const unreadIndicator = notificationItem.querySelector('.unread-indicator');
                    if (unreadIndicator) {
                        unreadIndicator.remove();
                    }
                }
                
                console.log('Notification marked as read successfully');
                
                // Sync with server to get the updated count
                updateNotificationCount();
            } else {
                console.error('Failed to mark as read - response:', data);
            }
        })
        .catch(error => {
            console.error('Error marking notification as read:', error);
        });
    }

    // Track previous notification count
    let previousNotificationCount = null; // Will be set on first load
    let notificationPollingInterval = null;
    let isFirstLoad = true; // Flag to prevent notification on initial load

    // Format notification date
    function formatNotificationDate(dateString) {
        if (!dateString) return 'N/A';
        const date = new Date(dateString);
        const now = new Date();
        const diffMs = now - date;
        const diffMins = Math.floor(diffMs / 60000);
        const diffHours = Math.floor(diffMs / 3600000);
        const diffDays = Math.floor(diffMs / 86400000);
        
        if (diffMins < 1) return 'just now';
        if (diffMins < 60) return `${diffMins} minute${diffMins > 1 ? 's' : ''} ago`;
        if (diffHours < 24) return `${diffHours} hour${diffHours > 1 ? 's' : ''} ago`;
        if (diffDays < 7) return `${diffDays} day${diffDays > 1 ? 's' : ''} ago`;
        return date.toLocaleDateString();
    }

    // Render notification item HTML
    function renderNotificationItem(notification) {
        const data = notification.data || {};
        const isRead = notification.is_read;
        const type = notification.type || 'order_status';
        let badgeHtml = '';
        let contentHtml = '';
        
        if (type === 'reservation_pending') {
            const reservationId = data.reservation_id || 'N/A';
            const date = data.date || 'N/A';
            const time = data.time || 'N/A';
            const timeOut = data.time_out || null;
            const table = data.table || 'N/A';
            const guests = data.guests || 'N/A';
            const status = 'Pending';
            const badgeClass = 'warning';
            
            badgeHtml = `<span class="badge badge-${badgeClass} mr-2">${status}</span>`;
            contentHtml = `
                <strong>Reservation #${reservationId}</strong>
                <p class="mb-1 text-dark">${notification.message || 'Reservation update'}</p>
                <small class="text-muted">
                    Date: ${date} | Time In: ${time}${timeOut ? ' | Time Out: ' + timeOut : ''}
                </small><br>
                <small class="text-muted">Table: ${table} | Guests: ${guests}</small>
            `;
        } else if (type === 'reservation_approved' || type === 'reservation_cancelled') {
            const reservationId = data.reservation_id || 'N/A';
            const date = data.date || 'N/A';
            const time = data.time || 'N/A';
            const timeOut = data.time_out || null;
            const table = data.table || 'N/A';
            const guests = data.guests || 'N/A';
            const status = type === 'reservation_approved' ? 'Approved' : 'Cancelled';
            const badgeClass = type === 'reservation_approved' ? 'success' : 'danger';
            
            badgeHtml = `<span class="badge badge-${badgeClass} mr-2">${status}</span>`;
            contentHtml = `
                <strong>Reservation #${reservationId}</strong>
                <p class="mb-1 text-dark">${notification.message || 'Reservation update'}</p>
                <small class="text-muted">
                    Date: ${date} | Time In: ${time}${timeOut ? ' | Time Out: ' + timeOut : ''}
                </small><br>
                <small class="text-muted">Table: ${table} | Guests: ${guests}</small>
            `;
        } else if (
            type === 'return_refund_request' ||
            type === 'return_refund_approved' ||
            type === 'return_refund_rejected' ||
            type === 'return_refund_processed'
        ) {
            const requestId = data.return_refund_id || 'N/A';
            const amount = data.amount || null;
            let status = '';
            let badgeClass = '';
            
            if (type === 'return_refund_request') {
                status = 'Pending';
                badgeClass = 'warning';
            } else if (type === 'return_refund_approved') {
                status = 'Approved';
                badgeClass = 'info';
            } else if (type === 'return_refund_rejected') {
                status = 'Rejected';
                badgeClass = 'danger';
            } else { // return_refund_processed
                status = 'Refunded';
                badgeClass = 'success';
            }
            
            badgeHtml = `<span class="badge badge-${badgeClass} mr-2">${status}</span>`;
            contentHtml = `
                <strong>Return/Refund #${requestId}</strong>
                <p class="mb-1 text-dark">${notification.message || 'Return/Refund update'}</p>
                ${amount !== null ? `<small class="text-muted">Amount: ₱${parseFloat(amount).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</small>` : ''}
            `;
        } else if (type === 'event_booking') {
            const bookingId = data.booking_id || 'N/A';
            const status = data.status || 'Pending';
            const eventDate = data.event_date || 'N/A';
            const packageInclusion = data.package_inclusion || null;
            const timeSlot = data.time_slot || null;
            const amount = (data.amount !== undefined && data.amount !== null) ? data.amount : 0;
            const badgeClass = status === 'Paid' ? 'success' : (status === 'Cancelled' ? 'danger' : 'warning');
            
            badgeHtml = `<span class="badge badge-${badgeClass} mr-2">${status}</span>`;

            const detailsLineParts = [`Event Date: ${eventDate}`];
            if (timeSlot) {
                detailsLineParts.push(`Time: ${timeSlot}`);
            }

            contentHtml = `
                <strong>Event Booking #${bookingId}</strong>
                <p class="mb-1 text-dark">${notification.message || 'Event booking update'}</p>
                <small class="text-muted">${detailsLineParts.join(' | ')}</small><br>
                ${packageInclusion ? `<small class="text-muted">Package: ${packageInclusion}</small><br>` : ''}
                <small class="text-muted">Amount: ₱${parseFloat(amount).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</small>
            `;
        } else {
            // Order notification
            const statusRaw = data.status || 'pending';
            const status = statusRaw.charAt(0).toUpperCase() + statusRaw.slice(1).toLowerCase();
            const orderId = data.order_id || notification.order_id || 'N/A';
            const title = data.title || 'Order';
            const price = data.price || 0;
            const quantity = data.quantity || 1;
            const badgeClass = status === 'Delivered' ? 'success' : (status === 'On the Way' ? 'warning' : (status === 'Cancelled' ? 'danger' : (status === 'Pending' ? 'warning' : 'primary')));
            
            badgeHtml = `<span class="badge badge-${badgeClass} mr-2">${status}</span>`;
            contentHtml = `
                <strong>Order #${orderId}</strong>
                <p class="mb-1 text-dark">${title} (Qty: ${quantity})</p>
                <small class="text-muted">Customer: ${data.customer_name || 'N/A'}</small><br>
                <small class="text-muted">Total: ₱${(parseFloat(price) * parseInt(quantity)).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</small>
            `;
        }
        
        const unreadIndicator = !isRead ? '<div class="unread-indicator"><i class="fas fa-circle text-primary" style="font-size: 8px;"></i></div>' : '';
        const readClass = isRead ? 'read' : 'unread';
        
        return `
            <a href="#" class="notification-item ${readClass}" 
               data-notification-id="${notification.id}"
               onclick="handleNotificationClick(event, ${notification.id}); return false;">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center mb-1">
                            ${badgeHtml}
                            <small class="text-muted">${formatNotificationDate(notification.created_at)}</small>
                        </div>
                        <div class="notification-content">
                            ${contentHtml}
                        </div>
                    </div>
                    <div class="notification-actions">
                        ${unreadIndicator}
                        <button class="btn btn-sm btn-outline-danger delete-notification-btn" 
                                onclick="deleteNotification(event, ${notification.id}); return false;"
                                title="Delete notification"
                                type="button"
                                aria-label="Delete notification"
                                style="opacity: 1 !important; visibility: visible !important;">
                            <i class="fas fa-trash" style="font-size: 12px;"></i>
                        </button>
                    </div>
                </div>
            </a>
        `;
    }

    // Update notification count and list
    // Badge only shows when unread count > 0; hides when all read; persists correctly on refresh
    function updateNotificationCount() {
        if (!document.getElementById('notifCount')) return; // User not logged in, no notification bell
        fetch('/customer/notifications')
        .then(response => response.json())
        .then(notifications => {
            // Treat as unread when is_read is 0, false, null, or "0" (from DB)
            const unreadCount = notifications.filter(n => n.is_read != 1 && n.is_read !== true && n.is_read !== '1').length;
            const notifCountElement = document.getElementById('notifCount');
            const notifCountTextElement = document.getElementById('notifCountText');
            const notifListElement = document.getElementById('notifList');
            
            // Check for new notifications (count increased)
            if (previousNotificationCount !== null && !isFirstLoad && unreadCount > previousNotificationCount) {
                // Show browser notification if page is not in focus
                if (document.hidden && 'Notification' in window && Notification.permission === 'granted') {
                    new Notification('New Notification!', {
                        body: `You have ${unreadCount - previousNotificationCount} new notification(s)`,
                        icon: '/favicon.ico'
                    });
                }
            }
            
            // Update count
            previousNotificationCount = unreadCount;
            
            // Mark first load as complete
            if (isFirstLoad) {
                isFirstLoad = false;
            }
            
            // Update UI elements
            if (notifCountElement) {
                notifCountElement.textContent = unreadCount;
                notifCountElement.style.display = unreadCount > 0 ? 'inline' : 'none';
            }
            
            if (notifCountTextElement) {
                notifCountTextElement.textContent = unreadCount > 0 ? `${unreadCount} unread` : 'No new notifications';
            }
            
            // Update notification list if it exists and we have notifications
            if (notifListElement && notifications.length > 0) {
                let listHtml = '';
                notifications.forEach((notification, index) => {
                    listHtml += renderNotificationItem(notification);
                    if (index < notifications.length - 1) {
                        listHtml += '<div class="dropdown-divider"></div>';
                    }
                });
                notifListElement.innerHTML = listHtml;
            } else if (notifListElement && notifications.length === 0) {
                notifListElement.innerHTML = `
                    <div class="text-center py-3">
                        <i class="fas fa-bell-slash text-muted mb-2" style="font-size: 2rem;"></i>
                        <p class="text-muted mb-0">No notifications yet</p>
                        <small class="text-muted">You'll see order, reservation, and event booking updates here</small>
                    </div>
                `;
            }
        })
        .catch(error => console.error('Error updating notification count:', error));
    }

    // Delete notification function
    function deleteNotification(event, notificationId) {
        event.preventDefault();
        event.stopPropagation();
        
        // Show confirmation dialog
        if (!confirm('Are you sure you want to delete this notification?')) {
            return false;
        }
        
        fetch(`/customer/notifications/${notificationId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the notification item from the DOM
                const notificationItem = document.querySelector(`[data-notification-id="${notificationId}"]`);
                if (notificationItem) {
                    // Add fade out effect
                    notificationItem.style.transition = 'opacity 0.3s ease';
                    notificationItem.style.opacity = '0';
                    
                    setTimeout(() => {
                        notificationItem.remove();
                        
                        // Check if there are any notifications left
                        const remainingNotifications = document.querySelectorAll('.notification-item');
                        if (remainingNotifications.length === 0) {
                            // Show "no notifications" message
                            const notifList = document.getElementById('notifList');
                            if (notifList) {
                                notifList.innerHTML = `
                                    <div class="text-center py-3">
                                        <i class="fas fa-bell-slash text-muted mb-2" style="font-size: 2rem;"></i>
                                        <p class="text-muted mb-0">No notifications yet</p>
                                        <small class="text-muted">You'll see updates here</small>
                                    </div>
                                `;
                            }
                        }
                        
                        // Update notification count
                        updateNotificationCount();
                    }, 300);
                }
            } else {
                alert('Failed to delete notification. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to delete notification. Please try again.');
        });
        
        return false;
    }

    // Poll for new notifications every 15 seconds
    function startNotificationPolling() {
        notificationPollingInterval = setInterval(() => {
            updateNotificationCount();
        }, 15000); // 15 seconds
    }

    // Stop polling when page is hidden
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            clearInterval(notificationPollingInterval);
        } else {
            startNotificationPolling();
            updateNotificationCount(); // Update immediately when page becomes visible
        }
    });

    // Request browser notification permission
    function requestNotificationPermission() {
        if ('Notification' in window && Notification.permission === 'default') {
            Notification.requestPermission().then(function (permission) {
                if (permission === 'granted') {
                    console.log('Notification permission granted');
                } else {
                    console.log('Notification permission denied');
                }
            });
        }
    }

    // Initialize notification system
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, starting notification system');
        
        // Request notification permission
        requestNotificationPermission();
        
        // Fetch notification count immediately - badge only shows when there are unread notifications
        // This ensures: no badge on refresh if all read; badge appears only for new unread; disappears when read
        updateNotificationCount();
        
        // Start polling for new notifications
        startNotificationPolling();
        
    });
    
    // Navigation scroll function
    function scrollToSection(sectionId) {
        console.log('Scrolling to section:', sectionId);
        
        // Function to perform the actual scrolling
        function performScroll() {
            const element = document.getElementById(sectionId);
            if (element) {
                // Get navbar height to offset for fixed navbar
                const navbar = document.querySelector('.custom-navbar');
                const navbarHeight = navbar ? navbar.offsetHeight : 0;
                
                // Calculate the position to scroll to
                const elementPosition = element.offsetTop - navbarHeight - 20; // 20px extra padding
                
                // Smooth scroll to the calculated position
                window.scrollTo({
                    top: elementPosition,
                    behavior: 'smooth'
                });
                
                console.log('Successfully scrolled to section:', sectionId);
                return true;
            } else {
                console.log('Section not found:', sectionId);
                // Try to find the element with different selectors
                const alternativeElement = document.querySelector(`[id*="${sectionId}"]`);
                if (alternativeElement) {
                    console.log('Found alternative element:', alternativeElement);
                    const navbar = document.querySelector('.custom-navbar');
                    const navbarHeight = navbar ? navbar.offsetHeight : 0;
                    const elementPosition = alternativeElement.offsetTop - navbarHeight - 20;
                    window.scrollTo({
                        top: elementPosition,
                        behavior: 'smooth'
                    });
                    return true;
                }
            }
            return false;
        }
        
        // Try to scroll immediately
        if (performScroll()) {
            return;
        }
        
        // If element not found, wait a bit and try again (for dynamic content)
        setTimeout(() => {
            if (!performScroll()) {
                console.warn('Could not find section:', sectionId);
                // Fallback: scroll to top
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        }, 100);
    }
    
    // Add click event listeners to navigation links as backup
    document.addEventListener('DOMContentLoaded', function() {
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link[href^="#"]');
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const href = this.getAttribute('href');
                const sectionId = href.substring(1); // Remove the #
                scrollToSection(sectionId);
            });
        });
    });
</script>
