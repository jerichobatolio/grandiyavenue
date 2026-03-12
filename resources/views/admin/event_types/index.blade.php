<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('admin.css')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

    <style>
        body {
            background: #000000;
            color: #ffffff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .event-types-container {
            margin: 20px auto;
            max-width: 1400px;
            padding: 20px;
        }

        .page-title {
            text-align: center;
            color: #ffffff;
            margin-bottom: 30px;
            font-size: 2.5em;
            font-weight: bold;
        }

        .management-tabs {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
            gap: 10px;
            flex-wrap: wrap;
        }

        .management-tab {
            padding: 12px 24px;
            background-color: #f8f9fa;
            border: 2px solid #dee2e6;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: bold;
        }

        .management-tab.active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .management-tab:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .management-section {
            display: none;
        }

        .management-section.active {
            display: block;
        }

        .add-event-type-form {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        .form-group input, .form-group select, .form-group textarea {
            padding: 10px;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            border-color: #007bff;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        .btn-success {
            background-color: #28a745;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9em;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9em;
        }

        .btn-warning {
            background-color: #ffc107;
            color: #333;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9em;
        }

        .btn-info {
            background-color: #17a2b8;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9em;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9em;
        }

        .event-types-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .event-type-card {
            background-color: #f8f9fa;
            border: 3px solid #6c757d;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
            color: #333;
            position: relative;
        }

        .event-type-card.active {
            border-color: #28a745;
            background-color: #d4edda;
        }

        .event-type-card.inactive {
            border-color: #dc3545;
            background-color: #f8d7da;
        }

        .event-type-title {
            font-size: 1.5em;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .event-type-price {
            font-size: 1em;
            margin-bottom: 10px;
        }

        .event-type-status {
            font-size: 0.9em;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 15px;
            margin-bottom: 15px;
        }

        .event-type-status.active {
            background-color: #28a745;
            color: white;
        }

        .event-type-status.inactive {
            background-color: #dc3545;
            color: white;
        }

        .event-type-actions {
            display: flex;
            gap: 5px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .section-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 1.2em;
            font-weight: bold;
        }

        .stats-overview {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }

        .stat-item {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .stat-number {
            font-size: 2em;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 0.9em;
            color: #666;
        }

        .stat-item.total .stat-number { color: #007bff; }
        .stat-item.active .stat-number { color: #28a745; }
        .stat-item.inactive .stat-number { color: #dc3545; }

        .image-preview {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #ddd;
            margin: 5px;
        }

        .file-upload-area {
            border: 2px dashed #ddd;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            background: #f8f9fa;
            transition: all 0.3s ease;
            cursor: pointer;
            margin-bottom: 10px;
        }

        .file-upload-area:hover {
            border-color: #007bff;
            background: #f0f2ff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,123,255,0.2);
        }

        .file-upload-icon {
            font-size: 2em;
            color: #007bff;
            margin-bottom: 10px;
        }

        .file-upload-text {
            color: #666;
            margin-bottom: 5px;
        }

        .file-upload-hint {
            font-size: 0.8em;
            color: #999;
        }

        .preview-image {
            max-width: 100px;
            max-height: 100px;
            border-radius: 8px;
            margin-top: 10px;
            border: 2px solid #ddd;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .alert-dismissible .close {
            position: relative;
            top: -2px;
            right: -21px;
            color: inherit;
        }

        /* Inline editing styles */
        .edit-mode {
            background-color: #fff3cd !important;
            border-color: #ffc107 !important;
        }

        .edit-form {
            display: none;
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            border: 2px solid #ffc107;
        }

        .edit-form.active {
            display: block;
        }

        .view-mode {
            display: block;
        }

        .view-mode.hidden {
            display: none;
        }

        .edit-form input, .edit-form textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .edit-form .form-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 15px;
        }

        .btn-save {
            background-color: #28a745;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-cancel {
            background-color: #6c757d;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-save:hover {
            background-color: #218838;
        }

        .btn-cancel:hover {
            background-color: #5a6268;
        }

        /* Upload button styles */
        #upload-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            background-color: #6c757d;
            border-color: #6c757d;
        }

        #upload-btn:disabled:hover {
            transform: none;
            box-shadow: 0 4px 15px rgba(40,167,69,0.3);
        }

        .btn-lg {
            transition: all 0.3s ease;
        }

        .btn-lg:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        }

        .image-upload-area {
            border: 1px dashed #ddd;
            border-radius: 4px;
            padding: 10px;
            text-align: center;
            background: #f8f9fa;
            margin-bottom: 10px;
            cursor: pointer;
        }

        .image-upload-area:hover {
            border-color: #007bff;
            background: #f0f2ff;
        }

        .current-images {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin: 10px 0;
        }

        .current-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        /* Venue Type Card Styles */
        .venue-type-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            border: 2px solid #dee2e6;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            position: relative;
        }

        .venue-type-card.active {
            border-color: #28a745;
            background-color: #f8fff8;
        }

        .venue-type-card.inactive {
            border-color: #dc3545;
            background-color: #fff8f8;
        }

        .venue-status {
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .venue-status.active {
            background-color: #d4edda;
            color: #155724;
        }

        .venue-status.inactive {
            background-color: #f8d7da;
            color: #721c24;
        }

        .venue-edit-form {
            background: #fff3cd;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            border: 2px solid #ffc107;
        }

        .venue-edit-form input, .venue-edit-form textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        /* Food Package Items table - same layout as Package Inclusions (clean, no scroll) */
        #food-packages-section .food-packages-table-wrapper {
            overflow: visible !important;
        }

        #food-packages-section .table {
            background-color: transparent;
            color: #212529;
        }

        #food-packages-section thead th {
            background-color: #f8f9fa;
            color: #212529;
            border-bottom: 2px solid #dee2e6;
        }

        #food-packages-section tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }

        #food-packages-section tbody tr:nth-child(even) {
            background-color: #fdfdfd;
        }

        #food-packages-section tbody td {
            color: #212529;
            border-top: none;
            vertical-align: top;
        }

        #food-packages-section tbody input.form-control,
        #food-packages-section tbody textarea.form-control {
            background-color: transparent;
            color: inherit;
            border: none;
            box-shadow: none;
            outline: none;
            padding-left: 0;
            padding-right: 0;
            resize: none;
        }

        #food-packages-section tbody input.form-control::placeholder,
        #food-packages-section tbody textarea.form-control::placeholder {
            color: rgba(0, 0, 0, 0.5);
        }

        /* Dishes column - full list visible without scrolling */
        #food-packages-section .food-package-dishes textarea {
            overflow: visible !important;
            min-height: 60px;
            white-space: pre-wrap;
            line-height: 1.5;
        }

        /* Package Inclusions table - clean, borderless layout (no scroll) */
        #inclusions-section .inclusions-table-wrapper {
            overflow: visible !important;
        }

        #inclusions-section .table {
            background-color: transparent;
            color: #212529;
        }

        /* Ensure Details column shows full list without scrolling */
        #inclusions-section .inclusion-details-with-price textarea {
            overflow: visible !important;
            min-height: 60px;
            white-space: pre-wrap; /* preserve line breaks so list items display fully */
            line-height: 1.5;
        }

        #inclusions-section thead th {
            background-color: #f8f9fa;
            color: #212529;
            border-bottom: 2px solid #dee2e6;
        }

        #inclusions-section tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }

        #inclusions-section tbody tr:nth-child(even) {
            background-color: #fdfdfd;
        }

        #inclusions-section tbody td {
            color: #212529;
            border-top: none;
            vertical-align: top;
        }

        #inclusions-section tbody input.form-control,
        #inclusions-section tbody textarea.form-control {
            background-color: transparent;
            color: inherit;
            border: none;
            box-shadow: none;
            outline: none;
            padding-left: 0;
            padding-right: 0;
            resize: none; /* height handled via JS auto-resize */
        }

        #inclusions-section tbody input.form-control::placeholder,
        #inclusions-section tbody textarea.form-control::placeholder {
            color: rgba(0, 0, 0, 0.5);
        }

        /* Price highlight in details */
        .inclusion-price-highlight {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: #fff !important;
            font-weight: bold;
            padding: 4px 10px;
            border-radius: 6px;
        }

        .inclusion-price-input {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.2) 0%, rgba(32, 201, 151, 0.2) 100%) !important;
            border: 2px solid #28a745 !important;
            font-weight: bold;
        }

        .inclusion-price-label {
            font-weight: 600;
            color: #28a745;
        }

        /* Inclusion view/edit mode toggle */
        #inclusions-section tr.editing .inclusion-view-mode { display: none !important; }
        #inclusions-section tr.editing .inclusion-edit-mode { display: block !important; }
        #inclusions-section tr.editing .inclusion-edit-pax { display: flex !important; }
        #inclusions-section tr.editing .inclusion-edit-mode input.form-control { display: inline-block !important; }

        /* Food package view/edit mode toggle */
        #food-packages-section tr.editing .food-pkg-view-mode { display: none !important; }
        #food-packages-section tr.editing .food-pkg-edit-mode { display: block !important; }
        #food-packages-section tr.editing .food-pkg-edit-mode input.form-control { display: inline-block !important; }

        /* Event type inclusions */
        .inclusions-list {
            margin: 10px 0 5px;
            padding-left: 0;
            list-style: none;
        }

        .inclusions-list li {
            font-size: 0.9em;
            color: #333;
            background: #e9f7ef;
            border-radius: 6px;
            padding: 6px 10px;
            margin-bottom: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .inclusions-list li span.inclusion-label {
            font-weight: 600;
        }

        .inclusions-list li span.inclusion-price {
            font-weight: 600;
            color: #28a745;
        }

        .inclusions-form-container {
            margin-top: 10px;
            border-top: 1px dashed #dee2e6;
            padding-top: 10px;
        }

        .inclusion-row {
            display: grid;
            grid-template-columns: 2fr 1fr auto;
            gap: 8px;
            margin-bottom: 8px;
            align-items: center;
        }

        .inclusion-row input[type="text"],
        .inclusion-row input[type="number"] {
            width: 100%;
        }

        .inclusion-row button {
            white-space: nowrap;
        }

        @media (max-width: 768px) {
            .management-tabs {
                flex-direction: column;
                align-items: center;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .event-types-grid {
                grid-template-columns: 1fr;
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
                <div class="event-types-container">
                    <h1 class="page-title">🎉 Event Types Management</h1>
                    
                    <!-- Statistics Overview -->
                    <div class="stats-overview">
                        <div class="stat-item total">
                            <div class="stat-number">{{ $eventTypes->count() }}</div>
                            <div class="stat-label">Total Event Types</div>
                        </div>
                    </div>

                    <!-- Management Tabs -->
                    <div class="management-tabs">
                        <div class="management-tab active" data-section="overview">📊 View All Event Types</div>
                        <div class="management-tab" data-section="add">➕ Add Event Type</div>
                        <div class="management-tab" data-section="time-slots">🕐 Time Slots</div>
                        <div class="management-tab" data-section="inclusions">📦 Package Inclusions</div>
                        <div class="management-tab" data-section="venue-types">🏢 Manage Venue Types</div>
                        <div class="management-tab" data-section="qr-codes">QR Code Management</div>
                        <div class="management-tab" data-section="food-packages">
                            🍽️ Food Package Items
                        </div>
                    </div>

                    @if(session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" onclick="dismissAlert('success-alert')">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" onclick="dismissAlert('error-alert')">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    <!-- Overview Section - View All Event Types with Inline Editing -->
                    <div id="overview-section" class="management-section active">
                        <div class="section-header">📊 View All Event Types - Click to View/Edit</div>
                        
                        @if($eventTypes->count() > 0)
                            <div class="event-types-grid">
                                @foreach($eventTypes as $eventType)
                                    <div class="event-type-card" id="card-{{ $eventType->id }}">
                                        <!-- View Mode -->
                                        <div class="view-mode" id="view-{{ $eventType->id }}">
                                            <div class="event-type-title">{{ $eventType->name }}</div>

                                            @if($eventType->qr_code_image || $eventType->admin_photo)
                                                <div class="current-images">
                                                    @if($eventType->qr_code_image)
                                                        <div style="position: relative; display: inline-block;">
                                                            <img src="{{ $eventType->qr_code_image_url }}" alt="QR Code" class="current-image">
                                                            <form action="{{ route('event_types.delete-qr-code', $eventType) }}" method="POST" style="display: inline; position: absolute; top: -5px; right: -5px;" onsubmit="return confirm('Are you sure you want to delete this QR code?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm" style="padding: 2px 6px; font-size: 10px; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center;">
                                                                    ×
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                    @if($eventType->admin_photo)
                                                        <img src="{{ $eventType->admin_photo_url }}" alt="Admin Photo" class="current-image">
                                                    @endif
                                                </div>
                                            @endif

                                            <div class="event-type-actions">
                                                <button onclick="toggleEditMode({{ $eventType->id }})" class="btn btn-warning">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                                <form action="{{ route('event_types.destroy', $eventType) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this event type? This action cannot be undone!')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Edit Mode -->
                                        <div class="edit-form" id="edit-{{ $eventType->id }}">
                                            <form action="{{ route('event_types.update', $eventType) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                
                                                <div class="form-group">
                                                    <label>Event Type Name *</label>
                                                    <input type="text" name="name" value="{{ $eventType->name }}" required>
                                                </div>

                                                <div class="form-actions">
                                                    <button type="button" class="btn-cancel" onclick="toggleEditMode({{ $eventType->id }})">
                                                        <i class="fas fa-times"></i> Cancel
                                                    </button>
                                                    <button type="submit" class="btn-save">
                                                        <i class="fas fa-save"></i> Save Changes
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div style="text-align: center; padding: 50px; background: #f8f9fa; border-radius: 10px;">
                                <div style="font-size: 4em; color: #6c757d; margin-bottom: 20px;">🎉</div>
                                <h3 style="color: #6c757d;">No Event Types Found</h3>
                                <p style="color: #6c757d;">Start by creating your first event type to manage different types of events.</p>
                                <button class="btn btn-primary" onclick="switchTab('add')">
                                    <i class="fas fa-plus"></i> Create Your First Event Type
                                </button>
                            </div>
                        @endif
                    </div>

                    <!-- Add Event Type Section -->
                    <div id="add-section" class="management-section">
                        <div class="section-header">➕ Add New Event Type</div>
                        <div class="add-event-type-form">
                            <form action="{{ route('event_types.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="name">Event Type Name *</label>
                                        <input type="text" name="name" id="name" class="form-control" 
                                               value="{{ old('name') }}" required 
                                               placeholder="Enter event type name">
                                    </div>
                                </div>

                                <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
                                    <button type="button" class="btn btn-secondary" onclick="switchTab('overview')">
                                        <i class="fas fa-times"></i> Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Create Event Type
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Time Slots Management Section -->
                    <div id="time-slots-section" class="management-section">
                        <div class="section-header">🕐 Time Slots Management</div>
                        <div style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                            @if($errors->any() && request()->get('tab') === 'time-slots')
                                <div class="alert alert-danger">
                                    <ul style="margin: 0; padding-left: 20px;">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <h3 style="color: #333; margin-bottom: 20px;">Time Slots</h3>

                            <!-- Add New Time Slot -->
                            <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; border: 2px solid #dee2e6; margin-bottom: 25px;">
                                <h4 style="color: #333; margin-bottom: 15px;"><i class="fas fa-plus-circle"></i> Add New Time Slot</h4>
                                <form id="time-slot-add-form" method="POST" action="{{ route('event_types.time-slots.store') }}">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="ts_label">Label *</label>
                                            <select name="label" id="ts_label" class="form-control" required>
                                                <option value="AM">AM</option>
                                                <option value="PM">PM</option>
                                                <option value="Whole Day">Whole Day</option>
                                                <option value="_custom_">Other (custom)</option>
                                            </select>
                                            <input type="text" name="label_custom" id="ts_label_custom" class="form-control" placeholder="Custom label" style="display: none; margin-top: 6px;">
                                        </div>
                                        <div class="form-group" id="ts-times-group">
                                            <label for="ts_start_time">Start Time</label>
                                            <input type="time" name="start_time" id="ts_start_time" class="form-control" value="10:00">
                                        </div>
                                        <div class="form-group" id="ts-times-group-end">
                                            <label for="ts_end_time">End Time</label>
                                            <input type="time" name="end_time" id="ts_end_time" class="form-control" value="14:00">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group" style="grid-column: 1 / -1;">
                                            <label for="ts_details">Details</label>
                                            <textarea name="details" id="ts_details" class="form-control" rows="2" placeholder="e.g. 1-3 hours can be extended"></textarea>
                                        </div>
                                    </div>
                                    <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 10px;">
                                        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Add Time Slot</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Existing Time Slots -->
                            <div style="background: #f8f9fa; padding: 20px; border-radius: 10px;">
                                <h4 style="color: #333; margin-bottom: 15px;"><i class="fas fa-list"></i> Existing Time Slots</h4>
                                @if($globalTimeSlots->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead style="background: #343a40; color: #fff;">
                                                <tr>
                                                    <th style="width: 120px;">Label</th>
                                                    <th style="width: 180px;">Time Range</th>
                                                    <th>Details</th>
                                                    <th style="width: 140px; text-align: center;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($globalTimeSlots as $slot)
                                                    <tr>
                                                        <td>{{ $slot->label }}</td>
                                                        <td>{{ $slot->time_range_display }}</td>
                                                        <td>{{ $slot->details ?? '—' }}</td>
                                                        <td style="text-align: center;">
                                                            <button type="button" class="btn btn-warning btn-sm" onclick="editTimeSlotInline({{ $slot->id }})"><i class="fas fa-edit"></i> Edit</button>
                                                            <form action="{{ route('event_types.time-slots.destroy', $slot) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this time slot?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    <tr class="time-slot-edit-row" id="edit-row-{{ $slot->id }}" style="display: none;">
                                                        <td colspan="4" style="background: #fff3cd; padding: 15px;">
                                                            <form action="{{ route('event_types.time-slots.update', $slot) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="form-row">
                                                                    <div class="form-group">
                                                                        <label>Label *</label>
                                                                        <select name="label" class="form-control ts-edit-label">
                                                                            <option value="AM" {{ $slot->label === 'AM' ? 'selected' : '' }}>AM</option>
                                                                            <option value="PM" {{ $slot->label === 'PM' ? 'selected' : '' }}>PM</option>
                                                                            <option value="Whole Day" {{ $slot->label === 'Whole Day' ? 'selected' : '' }}>Whole Day</option>
                                                                            <option value="_custom_" {{ !in_array($slot->label, ['AM','PM','Whole Day']) ? 'selected' : '' }}>Other</option>
                                                                        </select>
                                                                        <input type="text" name="label_custom" class="form-control ts-edit-label-custom" value="{{ !in_array($slot->label, ['AM','PM','Whole Day']) ? $slot->label : '' }}" placeholder="Custom" style="display: {{ !in_array($slot->label, ['AM','PM','Whole Day']) ? 'block' : 'none' }}; margin-top: 4px;">
                                                                    </div>
                                                                    <div class="form-group ts-edit-times">
                                                                        <label>Start</label>
                                                                        <input type="time" name="start_time" class="form-control" value="{{ $slot->start_time_input }}">
                                                                    </div>
                                                                    <div class="form-group ts-edit-times">
                                                                        <label>End</label>
                                                                        <input type="time" name="end_time" class="form-control" value="{{ $slot->end_time_input }}">
                                                                    </div>
                                                                    <div class="form-group" style="grid-column: 1 / -1;">
                                                                        <label>Details</label>
                                                                        <textarea name="details" class="form-control" rows="2">{{ $slot->details }}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 10px;">
                                                                    <button type="button" class="btn btn-secondary btn-sm" onclick="cancelTimeSlotEdit({{ $slot->id }})">Cancel</button>
                                                                    <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> Save</button>
                                                                </div>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p style="color: #6c757d;">No time slots yet. Add one above.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Package Inclusions Management Section -->
                    <div id="inclusions-section" class="management-section">
                        <div class="section-header">📦 Package Inclusions Management</div>

                        <div style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">

                            <div class="stats-overview" style="margin-bottom: 25px;">
                                <div class="stat-item total">
                                    <div class="stat-number">{{ $packageInclusions->count() }}</div>
                                    <div class="stat-label">Total Package Inclusions</div>
                                </div>
                            </div>

                            <!-- Add New Inclusion -->
                            <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; border: 2px solid #dee2e6; margin-bottom: 30px;">
                                <h4 style="color: #333; margin-bottom: 15px;">
                                    <i class="fas fa-plus-circle"></i> Add New Package Inclusion
                                </h4>

                                <form action="{{ route('admin.package_inclusions.store') }}" method="POST">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="new_inclusion_name">Name *</label>
                                            <input type="text"
                                                   id="new_inclusion_name"
                                                   name="name"
                                                   class="form-control"
                                                   placeholder="e.g., 35,000 with decor"
                                                   required>
                                        </div>
                                        <div class="form-group">
                                            <label for="new_inclusion_pax_min">Pax (min–max)</label>
                                            <div style="display: flex; align-items: center; gap: 8px;">
                                                <input type="number"
                                                       id="new_inclusion_pax_min"
                                                       name="pax_min"
                                                       class="form-control"
                                                       placeholder="e.g., 50"
                                                       min="0">
                                                <span>–</span>
                                                <input type="number"
                                                       id="new_inclusion_pax_max"
                                                       name="pax_max"
                                                       class="form-control"
                                                       placeholder="e.g., 80"
                                                       min="0">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="new_inclusion_price">Price *</label>
                                            <input type="text"
                                                   id="new_inclusion_price"
                                                   name="price"
                                                   class="form-control"
                                                   placeholder="e.g., 35,000"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group" style="grid-column: 1 / -1;">
                                            <label for="new_inclusion_details">Details</label>
                                            <textarea id="new_inclusion_details"
                                                      name="details"
                                                      class="form-control"
                                                      rows="3"
                                                      placeholder="One item per line, e.g.:&#10;FOOD (5 main dish, dessert, unlimited rice)&#10;Stylish set-up for all tables&#10;Basic Sound System (DJ included)"></textarea>
                                        </div>
                                    </div>
                                    <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 10px;">
                                        <button type="reset" class="btn btn-secondary btn-sm">
                                            <i class="fas fa-eraser"></i> Clear
                                        </button>
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-save"></i> Add Inclusion
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Existing Inclusions -->
                            <div style="background: #f8f9fa; padding: 20px; border-radius: 10px;">
                                <h4 style="color: #333; margin-bottom: 15px;">
                                    <i class="fas fa-list"></i> Existing Package Inclusions
                                </h4>

                                @if($packageInclusions->count() > 0)
                                    <div class="inclusions-table-wrapper">
                                        <table class="table table-borderless">
                                            <thead>
                                                <tr>
                                                    <th style="width: 60px;">#</th>
                                                    <th style="width: 220px;">Name</th>
                                                    <th style="width: 140px;">Pax (min–max)</th>
                                                    <th style="min-width: 280px;">Details</th>
                                                    <th style="width: 140px; text-align: center;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($packageInclusions as $index => $inclusion)
                                                    @php $formId = 'inclusion-form-' . $inclusion->id; @endphp
                                                    <tr data-inclusion-id="{{ $inclusion->id }}">
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>
                                                            <div class="inclusion-view-mode" data-field="name">{{ $inclusion->name }}</div>
                                                            <input type="text"
                                                                   name="name"
                                                                   form="{{ $formId }}"
                                                                   value="{{ $inclusion->name }}"
                                                                   class="form-control inclusion-edit-mode"
                                                                   required
                                                                   style="display:none;">
                                                        </td>
                                                        <td>
                                                            <div class="inclusion-view-mode" data-field="pax">{{ ($inclusion->pax_min ?? '') ? (($inclusion->pax_min ?? '') . ' – ' . ($inclusion->pax_max ?? '')) : '—' }}</div>
                                                            <div class="inclusion-edit-mode inclusion-edit-pax" style="display:none; align-items: center; gap: 6px;">
                                                                <input type="number" name="pax_min" form="{{ $formId }}" value="{{ $inclusion->pax_min ?? '' }}" class="form-control" placeholder="min" min="0" style="width: 60px;">
                                                                <span>–</span>
                                                                <input type="number" name="pax_max" form="{{ $formId }}" value="{{ $inclusion->pax_max ?? '' }}" class="form-control" placeholder="max" min="0" style="width: 60px;">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="inclusion-view-mode" data-field="details">
                                                                <div style="margin-bottom:4px;"><span class="inclusion-price-label">Price:</span> {{ number_format((float) $inclusion->price, 0, '.', ',') }}</div>
                                                                <div style="white-space: pre-wrap;">{{ $inclusion->details ?? '—' }}</div>
                                                            </div>
                                                            <form id="{{ $formId }}" action="{{ route('admin.package_inclusions.update', $inclusion->id) }}" method="POST" class="package-inclusion-form inclusion-edit-mode" style="display:none;">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="inclusion-details-with-price">
                                                                    <div style="margin-bottom:8px;">
                                                                        <span class="inclusion-price-label">Price:</span>
                                                                        <input type="text" name="price" value="{{ number_format((float) $inclusion->price, 0, '.', ',') }}" class="form-control inclusion-price-input" placeholder="e.g., 35,000" required style="display:inline-block; width:120px; margin-left:6px;">
                                                                    </div>
                                                                    <textarea name="details" class="form-control auto-resize-textarea" rows="1" placeholder="One item per line, e.g.:&#10;FOOD (5 main dish, dessert, unlimited rice)&#10;Stylish set-up for all tables&#10;Basic Sound System (DJ included)">{{ old('details', $inclusion->details) }}</textarea>
                                                                </div>
                                                                <div style="text-align:right; margin-top:6px; display:flex; gap:8px; justify-content:flex-end;">
                                                                    <button type="button" class="btn btn-secondary btn-sm inclusion-cancel-btn" data-inclusion-id="{{ $inclusion->id }}"><i class="fas fa-times"></i> Cancel</button>
                                                                    <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> Save</button>
                                                                </div>
                                                            </form>
                                                        </td>
                                                        <td style="text-align:center;">
                                                            <div class="inclusion-view-mode" style="display:flex; gap:8px; align-items:center; justify-content:center;">
                                                                <button type="button" class="btn btn-info btn-sm inclusion-edit-btn" data-inclusion-id="{{ $inclusion->id }}">
                                                                    <i class="fas fa-edit"></i> Edit
                                                                </button>
                                                                <form action="{{ route('admin.package_inclusions.delete', $inclusion->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this package inclusion? This cannot be undone.');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</button>
                                                                </form>
                                                            </div>
                                                            <div class="inclusion-edit-mode" style="display:none;">
                                                                <form action="{{ route('admin.package_inclusions.delete', $inclusion->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this package inclusion? This cannot be undone.');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div style="text-align:center; padding:30px; color:#6c757d;">
                                        <p>No package inclusions configured yet. Use the form above to add your first one.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Venue Types Management Section -->
                    <div id="venue-types-section" class="management-section">
                        <div class="section-header">🏢 Venue Types Management</div>
                        
                        <!-- Venue Types Statistics -->
                        <div class="stats-overview">
                            <div class="stat-item total">
                                <div class="stat-number">{{ $venueTypes->count() }}</div>
                                <div class="stat-label">Total Venue Types</div>
                            </div>
                        </div>
                        
                        <div style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                            <h3 style="color: #333; margin-bottom: 20px;">🏢 Manage Venue Types</h3>
                            <p style="color: #666; margin-bottom: 30px;">Add, edit, and manage different venue types for your event types. Venue types help categorize and organize your event offerings.</p>
                            
                            <!-- Add New Venue Type Form -->
                            <div style="background: #f8f9fa; padding: 25px; border-radius: 10px; margin-bottom: 30px; border: 2px solid #dee2e6;">
                                <h4 style="color: #333; margin-bottom: 20px;">
                                    <i class="fas fa-plus-circle"></i> Add New Venue Type
                                </h4>
                                
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul style="margin: 0; padding-left: 20px;">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                
                                <form action="{{ route('venue_types.store') }}" method="POST" id="venueTypeForm">
                                    @csrf
                                    <input type="hidden" name="_method" value="POST">
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="venue_name">Venue Type Name *</label>
                                            <input type="text" name="name" id="venue_name" class="form-control" 
                                                   placeholder="e.g., Indoor Hall, Outdoor Garden, Rooftop" 
                                                   value="{{ old('name') }}" required>
                                        </div>
                                    </div>

                                    <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
                                        <button type="button" class="btn btn-secondary" onclick="clearVenueForm()">
                                            <i class="fas fa-times"></i> Clear
                                        </button>
                                        <button type="button" class="btn btn-info" onclick="resetVenueForm()" id="resetVenueBtn" style="display: none;">
                                            <i class="fas fa-undo"></i> Reset to Add New
                                        </button>
                                        <button type="submit" class="btn btn-primary" id="venueSubmitBtn">
                                            <i class="fas fa-save"></i> Add Venue Type
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Existing Venue Types -->
                            <div style="background: #f8f9fa; padding: 25px; border-radius: 10px;">
                                <h4 style="color: #333; margin-bottom: 20px;">
                                    <i class="fas fa-list"></i> Existing Venue Types
                                </h4>

                                @if($venueTypes->count() > 0)
                                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 20px;">
                                        @foreach($venueTypes as $venueType)
                                            <div class="venue-type-card" 
                                                 data-venue-id="{{ $venueType->id }}" id="venue-card-{{ $venueType->id }}">
                                                
                                                <!-- View Mode -->
                                                <div class="venue-view-mode" id="venue-view-{{ $venueType->id }}">
                                                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                                                        <h5 style="color: #333; margin: 0; font-size: 1.2em;" data-field="name">{{ $venueType->name }}</h5>
                                                    </div>
                                                    
                                                    <div style="display: flex; gap: 8px; justify-content: flex-end; flex-wrap: wrap;">
                                                        <button class="btn btn-warning btn-sm" onclick="editVenueTypeInline({{ $venueType->id }})" title="Edit this venue type">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
                                                        <button class="btn btn-info btn-sm" onclick="editVenueType({{ $venueType->id }})" title="Update in form below">
                                                            <i class="fas fa-edit"></i> Quick Update
                                                        </button>
                                                        
                                                        <form action="{{ route('venue_types.destroy', $venueType) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this venue type? This action cannot be undone!')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete this venue type">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>

                                                <!-- Edit Mode -->
                                                <div class="venue-edit-form" id="venue-edit-{{ $venueType->id }}" style="display: none;">
                                                    <form action="{{ route('venue_types.update', $venueType) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        
                                                        <div class="form-group">
                                                            <label>Venue Type Name *</label>
                                                            <input type="text" name="name" value="{{ $venueType->name }}" required>
                                                        </div>
                                                        

                                                        <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 15px;">
                                                            <button type="button" class="btn btn-secondary btn-sm" onclick="cancelVenueEdit({{ $venueType->id }})">
                                                                <i class="fas fa-times"></i> Cancel
                                                            </button>
                                                            <button type="submit" class="btn btn-success btn-sm">
                                                                <i class="fas fa-save"></i> Save Changes
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div style="text-align: center; padding: 40px; color: #6c757d;">
                                        <i class="fas fa-building fa-3x" style="margin-bottom: 20px; opacity: 0.5;"></i>
                                        <h4>No Venue Types Found</h4>
                                        <p>Start by adding your first venue type to organize your event offerings.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- QR Code Management Section -->
                    <div id="qr-codes-section" class="management-section">
                        <div class="section-header">Global QR Code Management</div>
                        
                        <div style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                            <h3 style="color: #333; margin-bottom: 20px;">Manage QR Code</h3>
                            
                            <div style="max-width: 600px; margin: 0 auto;">
                                <!-- Current QR Code Display Section -->
                                @if(isset($adminQrCode) && $adminQrCode)
                                    <div style="background: #e8f5e8; padding: 25px; border-radius: 15px; border: 2px solid #28a745; margin-bottom: 30px;">
                                        <div style="text-align: center;">
                                            <h4 style="color: #28a745; margin-bottom: 20px;">
                                                <i class="fas fa-qrcode"></i> Current QR Code
                                            </h4>
                                            <div style="background: white; padding: 20px; border-radius: 10px; display: inline-block; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                                                <img src="{{ $adminQrCode->image_url }}" 
                                                     alt="Current Global QR Code" 
                                                     style="max-width: 200px; max-height: 200px; border-radius: 8px;">
                                            </div>
                                            <p style="color: #28a745; font-weight: bold; margin-top: 15px;">
                                                <i class="fas fa-check-circle"></i> QR Code Active
                                            </p>
                                            <div style="margin-top: 20px;">
                                                <button type="button" class="btn btn-warning btn-lg" onclick="showUpdateSection()" 
                                                        style="padding: 12px 30px; font-size: 16px; border-radius: 25px; box-shadow: 0 4px 15px rgba(255,193,7,0.3);">
                                                    <i class="fas fa-edit" style="margin-right: 8px;"></i>
                                                    Update QR Code
                                                </button>
                                                <button type="button" class="btn btn-danger btn-lg" onclick="deleteGlobalQrCode()" 
                                                        style="padding: 12px 30px; font-size: 16px; border-radius: 25px; box-shadow: 0 4px 15px rgba(220,53,69,0.3); margin-left: 10px;">
                                                    <i class="fas fa-trash" style="margin-right: 8px;"></i>
                                                    Remove QR Code
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- QR Code Upload/Update Form -->
                                <div style="background: #f8f9fa; padding: 30px; border-radius: 15px; border: 2px solid #dee2e6; margin-bottom: 30px;" 
                                     id="upload-section" style="{{ isset($adminQrCode) && $adminQrCode ? 'display: none;' : '' }}">
                                    <div>
                                        <h4 style="color: #333; margin-bottom: 20px; text-align: center;">
                                                {{ isset($adminQrCode) && $adminQrCode ? 'Update QR Code' : 'Upload QR Code' }}
                                        </h4>
                                        
                                        <!-- Upload Button Section -->
                                        <div style="text-align: center; margin-bottom: 25px;">
                                            <button type="button" class="btn btn-primary btn-lg" onclick="document.getElementById('global_qr_code').click()" 
                                                    style="padding: 15px 40px; font-size: 18px; border-radius: 25px; box-shadow: 0 4px 15px rgba(0,123,255,0.3);">
                                                <i class="fas fa-{{ isset($adminQrCode) && $adminQrCode ? 'edit' : 'upload' }}" style="margin-right: 10px;"></i>
                                                {{ isset($adminQrCode) && $adminQrCode ? 'Choose New QR Code' : 'Choose QR Code' }}
                                            </button>
                                        </div>
                                            
                                        <!-- File Upload Area (Alternative) -->
                                        <div class="file-upload-area" onclick="document.getElementById('global_qr_code').click()" 
                                             style="cursor: pointer; border: 3px dashed #007bff; padding: 30px; text-align: center; border-radius: 10px; background: #f8f9ff; transition: all 0.3s ease; margin-bottom: 20px;">
                                            <div class="file-upload-icon">
                                                <i class="fas fa-qrcode" style="font-size: 32px; color: #007bff; margin-bottom: 15px;"></i>
                                                        </div>
                                            <div class="file-upload-text" style="color: #007bff; font-weight: bold; font-size: 16px; margin-bottom: 5px;">
                                                Or drag & drop QR code here
                                            </div>
                                            <div class="file-upload-hint" style="color: #666; font-size: 14px;">
                                                PNG, JPG, GIF up to 5MB • Recommended: 300x300px
                                            </div>
                                                </div>
                                                
                                        <!-- Preview Section -->
                                        <div id="global-qr-preview" style="text-align: center; margin: 25px 0; display: none;">
                                            <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; border: 2px solid #28a745;">
                                                <h5 style="color: #28a745; margin-bottom: 15px;">
                                                    <i class="fas fa-eye"></i> Preview
                                                </h5>
                                                <img id="global-qr-preview-img" class="preview-image" 
                                                     style="max-width: 200px; max-height: 200px; border: 2px solid #28a745; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                                                <p style="color: #28a745; font-weight: bold; margin-top: 10px;">
                                                    Ready to upload this QR code
                                                </p>
                                                            </div>
                                                        </div>
                                        
                                        <!-- Action Buttons -->
                                        <form action="{{ route('admin.qr-code.update') }}" method="POST" enctype="multipart/form-data" id="qr-upload-form" onsubmit="showUploadProgress()">
                                            @csrf
                                            @method('PUT')
                                            
                                            <!-- Hidden file input inside form -->
                                            <input type="file" name="qr_code_image" id="global_qr_code" 
                                                   accept="image/*" style="display: none;" onchange="previewGlobalQrCode(this)">
                                            
                                            <div style="margin-top: 30px; display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                                                <button type="submit" class="btn btn-success btn-lg" id="upload-btn" disabled
                                                        style="padding: 15px 40px; font-size: 18px; border-radius: 25px; box-shadow: 0 4px 15px rgba(40,167,69,0.3);">
                                                    <i class="fas fa-check-circle" id="upload-icon" style="margin-right: 10px;"></i>
                                                    <span id="upload-text">{{ isset($adminQrCode) && $adminQrCode ? 'Update QR Code' : 'Upload QR Code' }}</span>
                                                </button>
                                                @if(isset($adminQrCode) && $adminQrCode)
                                                    <button type="button" class="btn btn-danger btn-lg" onclick="deleteGlobalQrCode()" 
                                                            style="padding: 15px 40px; font-size: 18px; border-radius: 25px; box-shadow: 0 4px 15px rgba(220,53,69,0.3);">
                                                        <i class="fas fa-trash" style="margin-right: 10px;"></i>
                                                        Remove Current QR Code
                                                                </button>
                                                            @endif
                                                        </div>
                                            
                                            <!-- Progress Indicator -->
                                            <div id="upload-progress" style="display: none; text-align: center; margin-top: 20px;">
                                                <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; border: 2px solid #007bff;">
                                                    <div style="display: flex; align-items: center; justify-content: center; gap: 15px;">
                                                        <div class="spinner-border text-primary" role="status" style="width: 20px; height: 20px;">
                                                            <span class="sr-only">Loading...</span>
                                                </div>
                                                        <span style="color: #007bff; font-weight: bold;">Uploading QR Code...</span>
                                            </div>
                                        </div>
                                </div>
                                        </form>
                                </div>
                                </div>
                                
                                
                            </div>
                        </div>
                    </div>

                    <!-- Food Package Items Management Section -->
                    <div id="food-packages-section" class="management-section">
                        <div class="section-header">🍽️ Food Package Items Management</div>

                        <div style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">

                            <div class="stats-overview" style="margin-bottom: 25px;">
                                <div class="stat-item total">
                                    <div class="stat-number">{{ $foodPackageItems->count() }}</div>
                                    <div class="stat-label">Total Food Package Items</div>
                                </div>
                            </div>

                            <!-- Add New Item -->
                            <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; border: 2px solid #dee2e6; margin-bottom: 30px;">
                                <h4 style="color: #333; margin-bottom: 15px;">
                                    <i class="fas fa-plus-circle"></i> Add New Food Package Item
                                </h4>

                                <form action="{{ route('admin.food_packages.store') }}" method="POST">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="new_food_package_name">Item Name *</label>
                                            <input type="text"
                                                   id="new_food_package_name"
                                                   name="name"
                                                   class="form-control"
                                                   placeholder="e.g., Chicken, Pork, Vegetable, Unlimited rice"
                                                   required>
                                        </div>
                                        <div class="form-group" style="grid-column: 1 / -1;">
                                            <label for="new_food_package_dishes">Dishes</label>
                                            <textarea id="new_food_package_dishes"
                                                      name="dishes"
                                                      class="form-control"
                                                      rows="3"
                                                      placeholder="One item per line, e.g.:&#10;Fried Chicken&#10;Roast Chicken&#10;Chicken Teriyaki"></textarea>
                                        </div>
                                    </div>
                                    <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 10px;">
                                        <button type="reset" class="btn btn-secondary btn-sm">
                                            <i class="fas fa-eraser"></i> Clear
                                        </button>
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-save"></i> Add Item
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Existing Items -->
                            <div style="background: #f8f9fa; padding: 20px; border-radius: 10px;">
                                <h4 style="color: #333; margin-bottom: 15px;">
                                    <i class="fas fa-list"></i> Existing Food Package Items
                                </h4>

                                @if($foodPackageItems->count() > 0)
                                    <div class="food-packages-table-wrapper">
                                        <table class="table table-borderless">
                                            <thead>
                                                <tr>
                                                    <th style="width: 60px;">#</th>
                                                    <th style="width: 220px;">Item Name</th>
                                                    <th style="min-width: 280px;">Dishes in this Package</th>
                                                    <th style="width: 140px; text-align: center;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($foodPackageItems as $index => $item)
                                                    @php $formId = 'food-package-form-' . $item->id; @endphp
                                                    <tr data-food-pkg-id="{{ $item->id }}">
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>
                                                            <div class="food-pkg-view-mode">{{ $item->name }}</div>
                                                            <input type="text"
                                                                   name="name"
                                                                   form="{{ $formId }}"
                                                                   value="{{ $item->name }}"
                                                                   class="form-control food-pkg-edit-mode"
                                                                   required
                                                                   style="display:none;">
                                                        </td>
                                                        <td>
                                                            <div class="food-pkg-view-mode" style="white-space: pre-wrap;">{{ $item->dishes ?? '—' }}</div>
                                                            <form id="{{ $formId }}" action="{{ route('admin.food_packages.update', $item->id) }}" method="POST" class="food-pkg-edit-mode" style="display:none;">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="food-package-dishes">
                                                                    <textarea name="dishes"
                                                                              class="form-control auto-resize-textarea"
                                                                              rows="1"
                                                                              placeholder="One item per line, e.g.:&#10;Fried Chicken&#10;Roast Chicken&#10;Chicken Teriyaki">{{ old('dishes', $item->dishes) }}</textarea>
                                                                </div>
                                                                <div style="text-align:right; margin-top:6px; display:flex; gap:8px; justify-content:flex-end;">
                                                                    <button type="button" class="btn btn-secondary btn-sm food-pkg-cancel-btn" data-food-pkg-id="{{ $item->id }}"><i class="fas fa-times"></i> Cancel</button>
                                                                    <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> Save</button>
                                                                </div>
                                                            </form>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <div class="food-pkg-view-mode" style="display:flex; gap:8px; align-items:center; justify-content:center;">
                                                                <button type="button" class="btn btn-info btn-sm food-pkg-edit-btn" data-food-pkg-id="{{ $item->id }}">
                                                                    <i class="fas fa-edit"></i> Edit
                                                                </button>
                                                                <form action="{{ route('admin.food_packages.delete', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this food package item? This cannot be undone.');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</button>
                                                                </form>
                                                            </div>
                                                            <div class="food-pkg-edit-mode" style="display:none;">
                                                                <form action="{{ route('admin.food_packages.delete', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this food package item? This cannot be undone.');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div style="text-align:center; padding:30px; color:#6c757d;">
                                        <i class="fas fa-utensils fa-3x" style="opacity:0.4; margin-bottom:10px;"></i>
                                        <p>No food package items configured yet. Use the form above to add your first item.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>

<script>
        document.addEventListener('DOMContentLoaded', function() {
            // Switch to Package Inclusions or Time Slots tab if redirected
            const params = new URLSearchParams(window.location.search);
            if (params.get('tab') === 'inclusions') {
                switchTab('inclusions');
            }
            if (params.get('tab') === 'time-slots') {
                switchTab('time-slots');
            }

            // Management tab switching
            const managementTabs = document.querySelectorAll('.management-tab');
            const managementSections = document.querySelectorAll('.management-section');
            
            managementTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const targetSection = this.getAttribute('data-section');
                    
                    // Remove active class from all tabs and sections
                    managementTabs.forEach(t => t.classList.remove('active'));
                    managementSections.forEach(section => section.classList.remove('active'));
                    
                    // Add active class to clicked tab and corresponding section
                    this.classList.add('active');
                    document.getElementById(targetSection + '-section').classList.add('active');
                });
            });

            // Time slot label (AM/PM/Whole Day/Custom) toggle
            const tsLabel = document.getElementById('ts_label');
            if (tsLabel) {
                tsLabel.addEventListener('change', function() {
                    const isWholeDay = this.value === 'Whole Day';
                    const isCustom = this.value === '_custom_';
                    document.getElementById('ts-times-group').style.display = isWholeDay ? 'none' : 'flex';
                    document.getElementById('ts-times-group-end').style.display = isWholeDay ? 'none' : 'flex';
                    document.getElementById('ts_label_custom').style.display = isCustom ? 'block' : 'none';
                });
            }
        });

        function editTimeSlotInline(slotId) {
            document.getElementById('edit-row-' + slotId).style.display = 'table-row';
            const row = document.querySelector('#edit-row-' + slotId + ' .ts-edit-label');
            if (row) {
                row.closest('tr').querySelectorAll('.ts-edit-times').forEach(function(el) {
                    el.style.display = row.value === 'Whole Day' ? 'none' : 'flex';
                });
            }
        }

        function cancelTimeSlotEdit(slotId) {
            document.getElementById('edit-row-' + slotId).style.display = 'none';
        }

        document.querySelectorAll('.ts-edit-label').forEach(function(sel) {
            sel.addEventListener('change', function() {
                const row = this.closest('tr');
                const isWholeDay = this.value === 'Whole Day';
                const isCustom = this.value === '_custom_';
                row.querySelectorAll('.ts-edit-times').forEach(function(el) { el.style.display = isWholeDay ? 'none' : 'flex'; });
                const customInput = row.querySelector('.ts-edit-label-custom');
                if (customInput) customInput.style.display = isCustom ? 'block' : 'none';
            });
        });

        function switchTab(section) {
            const tabs = document.querySelectorAll('.management-tab');
            const sections = document.querySelectorAll('.management-section');
            
            // Remove active class from all tabs and sections
            tabs.forEach(t => t.classList.remove('active'));
            sections.forEach(s => s.classList.remove('active'));
            
            // Add active class to target tab and section
            document.querySelector(`[data-section="${section}"]`).classList.add('active');
            document.getElementById(section + '-section').classList.add('active');
        }

        // Package Inclusion Edit / Cancel
        document.addEventListener('click', function(e) {
            if (e.target.closest('.inclusion-edit-btn')) {
                const btn = e.target.closest('.inclusion-edit-btn');
                const id = btn.getAttribute('data-inclusion-id');
                const row = document.querySelector(`tr[data-inclusion-id="${id}"]`);
                if (row) {
                    row.classList.add('editing');
                    setTimeout(function() { autoResizeInclusionTextareas(); }, 50);
                }
            }
            if (e.target.closest('.inclusion-cancel-btn')) {
                const btn = e.target.closest('.inclusion-cancel-btn');
                const id = btn.getAttribute('data-inclusion-id');
                const row = document.querySelector(`tr[data-inclusion-id="${id}"]`);
                if (row) row.classList.remove('editing');
            }
        });

        // Food Package Edit / Cancel
        document.addEventListener('click', function(e) {
            if (e.target.closest('.food-pkg-edit-btn')) {
                const btn = e.target.closest('.food-pkg-edit-btn');
                const id = btn.getAttribute('data-food-pkg-id');
                const row = document.querySelector(`tr[data-food-pkg-id="${id}"]`);
                if (row) {
                    row.classList.add('editing');
                    setTimeout(function() { autoResizeInclusionTextareas(); }, 50);
                }
            }
            if (e.target.closest('.food-pkg-cancel-btn')) {
                const btn = e.target.closest('.food-pkg-cancel-btn');
                const id = btn.getAttribute('data-food-pkg-id');
                const row = document.querySelector(`tr[data-food-pkg-id="${id}"]`);
                if (row) row.classList.remove('editing');
            }
        });

        function toggleEditMode(eventTypeId) {
            const viewMode = document.getElementById(`view-${eventTypeId}`);
            const editMode = document.getElementById(`edit-${eventTypeId}`);
            const card = document.getElementById(`card-${eventTypeId}`);
            
            if (viewMode.style.display === 'none') {
                // Switch to view mode
                viewMode.style.display = 'block';
                editMode.classList.remove('active');
                card.classList.remove('edit-mode');
            } else {
                // Switch to edit mode
                viewMode.style.display = 'none';
                editMode.classList.add('active');
                card.classList.add('edit-mode');
            }
        }

        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            const file = input.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        }

        // Package inclusions dynamic rows (no longer needed for per-event-type editing)

        function previewGlobalQrCode(input) {
            const preview = document.getElementById('global-qr-preview');
            const previewImg = document.getElementById('global-qr-preview-img');
            const uploadBtn = document.getElementById('upload-btn');
            const file = input.files[0];
            
            if (file) {
                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Please select a valid image file (JPEG, PNG, JPG, or GIF)');
                    input.value = '';
                    return;
                }
                
                // Validate file size (5MB max)
                const maxSize = 5 * 1024 * 1024; // 5MB in bytes
                if (file.size > maxSize) {
                    alert('File size must be less than 5MB');
                    input.value = '';
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.style.display = 'block';
                    uploadBtn.disabled = false;
                    uploadBtn.style.opacity = '1';
                    uploadBtn.style.cursor = 'pointer';
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
                uploadBtn.disabled = true;
                uploadBtn.style.opacity = '0.6';
                uploadBtn.style.cursor = 'not-allowed';
            }
        }

        function showUpdateSection() {
            const uploadSection = document.getElementById('upload-section');
            uploadSection.style.display = 'block';
            uploadSection.scrollIntoView({ behavior: 'smooth' });
        }

        function showUploadProgress() {
            const uploadBtn = document.getElementById('upload-btn');
            const uploadIcon = document.getElementById('upload-icon');
            const uploadText = document.getElementById('upload-text');
            const progressDiv = document.getElementById('upload-progress');
            
            // Disable button and show progress
            uploadBtn.disabled = true;
            uploadIcon.className = 'fas fa-spinner fa-spin';
            uploadText.textContent = 'Uploading...';
            progressDiv.style.display = 'block';
        }

        function deleteGlobalQrCode() {
            if (confirm('Are you sure you want to remove the global QR code? This will affect all event types.')) {
                // Create a form to submit the delete request
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("admin.qr-code.delete") }}';
                
                // Add CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);
                
                // Add method override for DELETE
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                form.appendChild(methodField);
                
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Drag and drop functionality
        document.querySelectorAll('.file-upload-area').forEach(area => {
            area.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.style.borderColor = '#007bff';
                this.style.background = '#f0f2ff';
            });

            area.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.style.borderColor = '#ddd';
                this.style.background = '#f8f9fa';
            });

            area.addEventListener('drop', function(e) {
                e.preventDefault();
                this.style.borderColor = '#ddd';
                this.style.background = '#f8f9fa';
                
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    const input = this.querySelector('input[type="file"]');
                    input.files = files;
                    input.dispatchEvent(new Event('change'));
                }
            });
        });

        // Venue Type Management Functions
        function clearVenueForm() {
            const form = document.getElementById('venueTypeForm');
            const submitBtn = document.getElementById('venueSubmitBtn');
            const resetBtn = document.getElementById('resetVenueBtn');
            
            form.reset();
            form.action = '{{ route("venue_types.store") }}';
            form.querySelector('input[name="_method"]').value = 'POST';
            
            // Reset button text and hide reset button
            submitBtn.innerHTML = '<i class="fas fa-save"></i> Add Venue Type';
            resetBtn.style.display = 'none';
        }


        function editVenueType(venueTypeId) {
            // Find the venue type data and populate the form
            const venueTypeCard = document.querySelector(`[data-venue-id="${venueTypeId}"]`);
            if (venueTypeCard) {
                const name = venueTypeCard.querySelector('[data-field="name"]').textContent;
                const description = venueTypeCard.querySelector('[data-field="description"]').textContent;
                const capacity = venueTypeCard.querySelector('[data-field="capacity"]').textContent;
                
                // Populate the form
                document.getElementById('venue_name').value = name;
                document.getElementById('venue_description').value = description;
                document.getElementById('venue_capacity').value = capacity;
                
                // Change form action to update
                const form = document.getElementById('venueTypeForm');
                form.action = `/venue_types/${venueTypeId}`;
                form.querySelector('input[name="_method"]').value = 'PUT';
                
                // Change submit button text and show reset button
                const submitBtn = document.getElementById('venueSubmitBtn');
                const resetBtn = document.getElementById('resetVenueBtn');
                submitBtn.innerHTML = '<i class="fas fa-save"></i> Update Venue Type';
                resetBtn.style.display = 'inline-block';
                
                // Scroll to form
                form.scrollIntoView({ behavior: 'smooth' });
            }
        }

        function resetVenueForm() {
            const form = document.getElementById('venueTypeForm');
            const submitBtn = document.getElementById('venueSubmitBtn');
            const resetBtn = document.getElementById('resetVenueBtn');
            
            // Reset form to add mode
            form.reset();
            form.action = '{{ route("venue_types.store") }}';
            form.querySelector('input[name="_method"]').value = 'POST';
            
            // Update button text and hide reset button
            submitBtn.innerHTML = '<i class="fas fa-save"></i> Add Venue Type';
            resetBtn.style.display = 'none';
        }

        function editVenueTypeInline(venueTypeId) {
            const viewMode = document.getElementById(`venue-view-${venueTypeId}`);
            const editMode = document.getElementById(`venue-edit-${venueTypeId}`);
            const card = document.getElementById(`venue-card-${venueTypeId}`);
            
            if (viewMode && editMode) {
                viewMode.style.display = 'none';
                editMode.style.display = 'block';
                card.style.borderColor = '#ffc107';
                card.style.backgroundColor = '#fff3cd';
            }
        }

        function cancelVenueEdit(venueTypeId) {
            const viewMode = document.getElementById(`venue-view-${venueTypeId}`);
            const editMode = document.getElementById(`venue-edit-${venueTypeId}`);
            const card = document.getElementById(`venue-card-${venueTypeId}`);
            
            if (viewMode && editMode) {
                viewMode.style.display = 'block';
                editMode.style.display = 'none';
                card.style.borderColor = '';
                card.style.backgroundColor = '';
            }
        }

        function toggleVenueStatus(venueTypeId) {
            if (confirm('Are you sure you want to change the status of this venue type?')) {
                // The form submission will handle this via the route
                return true;
            }
            return false;
        }

        function deleteVenueType(venueTypeId) {
            if (confirm('Are you sure you want to delete this venue type? This action cannot be undone!')) {
                // The form submission will handle this via the route
                return true;
            }
            return false;
        }

        // Auto-dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-dismiss success alerts
            const successAlert = document.getElementById('success-alert');
            if (successAlert) {
                setTimeout(() => {
                    dismissAlert('success-alert');
                }, 5000);
            }
            
            // Auto-dismiss error alerts
            const errorAlert = document.getElementById('error-alert');
            if (errorAlert) {
                setTimeout(() => {
                    dismissAlert('error-alert');
                }, 7000);
            }
            
            // Restore sidebar dropdown states from sessionStorage
            const savedStates = JSON.parse(sessionStorage.getItem('sidebarStates') || '{}');
            
            // Restore each dropdown state
            Object.keys(savedStates).forEach(dropdownId => {
                const dropdown = document.getElementById(dropdownId);
                if (dropdown && savedStates[dropdownId]) {
                    dropdown.classList.add('show');
                    dropdown.style.display = 'block';
                    // Update aria-expanded for the trigger
                    const trigger = document.querySelector(`[data-target="#${dropdownId}"], [href="#${dropdownId}"]`);
                    if (trigger) {
                        trigger.setAttribute('aria-expanded', 'true');
                    }
                }
            });
        });

        // Function to dismiss alerts
        function dismissAlert(alertId) {
            const alert = document.getElementById(alertId);
            if (alert) {
                alert.style.transition = 'opacity 0.5s ease-out';
                alert.style.opacity = '0';
                setTimeout(() => {
                    if (alert.parentElement) {
                        alert.remove();
                    }
                }, 500);
            }
        }

        // Save sidebar dropdown states before page unload
        window.addEventListener('beforeunload', function() {
            const states = {};
            const dropdowns = document.querySelectorAll('.collapse');
            dropdowns.forEach(dropdown => {
                const isOpen = dropdown.classList.contains('show') || dropdown.style.display === 'block';
                states[dropdown.id] = isOpen;
            });
            sessionStorage.setItem('sidebarStates', JSON.stringify(states));
        });

        // Save states when dropdowns are toggled
        document.addEventListener('click', function(e) {
            if (e.target.matches('[data-toggle="collapse"]') || e.target.closest('[data-toggle="collapse"]')) {
                setTimeout(() => {
                    const states = {};
                    const dropdowns = document.querySelectorAll('.collapse');
                    dropdowns.forEach(dropdown => {
                        const isOpen = dropdown.classList.contains('show') || dropdown.style.display === 'block';
                        states[dropdown.id] = isOpen;
                    });
                    sessionStorage.setItem('sidebarStates', JSON.stringify(states));
                }, 100);
            }
        });

        // Enhanced sidebar dropdown functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Force Bootstrap collapse to work properly
            const collapseElements = document.querySelectorAll('[data-toggle="collapse"]');
            collapseElements.forEach(element => {
                element.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('data-target') || this.getAttribute('href');
                    const target = document.querySelector(targetId);
                    
                    if (target) {
                        const isCollapsed = target.classList.contains('show');
                        
                        if (isCollapsed) {
                            target.classList.remove('show');
                            target.style.display = 'none';
                            this.setAttribute('aria-expanded', 'false');
                        } else {
                            target.classList.add('show');
                            target.style.display = 'block';
                            this.setAttribute('aria-expanded', 'true');
                        }
                        
                        // Save state immediately
                        setTimeout(() => {
                            const states = {};
                            const dropdowns = document.querySelectorAll('.collapse');
                            dropdowns.forEach(dropdown => {
                                const isOpen = dropdown.classList.contains('show') || dropdown.style.display === 'block';
                                states[dropdown.id] = isOpen;
                            });
                            sessionStorage.setItem('sidebarStates', JSON.stringify(states));
                        }, 50);
                    }
                });
            });
        });

        // Auto-resize inclusion details textareas so full list is visible (no scroll)
        function autoResizeInclusionTextareas() {
            document.querySelectorAll('.auto-resize-textarea').forEach(function (ta) {
                ta.style.height = '1px';
                ta.style.height = Math.max(60, ta.scrollHeight) + 'px';
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            autoResizeInclusionTextareas();
            document.querySelectorAll('.auto-resize-textarea').forEach(function (ta) {
                ta.addEventListener('input', autoResizeInclusionTextareas);
            });
        });

        // Re-resize when Package Inclusions or Food Package tab is shown (sections hidden initially = wrong scrollHeight)
        document.addEventListener('DOMContentLoaded', function () {
            [document.getElementById('inclusions-section'), document.getElementById('food-packages-section')].forEach(function (section) {
                if (section) {
                    const observer = new MutationObserver(function () {
                        if (section.classList.contains('active')) {
                            setTimeout(autoResizeInclusionTextareas, 50);
                        }
                    });
                    observer.observe(section, { attributes: true, attributeFilter: ['class'] });
                }
            });
        });
    </script>
</body>
</html>