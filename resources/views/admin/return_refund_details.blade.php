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

        .details-container {
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
        }

        .page-header-content {
            padding: 20px;
            background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .detail-section {
            margin-bottom: 25px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 4px solid #6c757d;
        }

        .detail-section h3 {
            color: #6c757d;
            margin-bottom: 15px;
            font-size: 1.2rem;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #dee2e6;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #495057;
        }

        .detail-value {
            color: #212529;
        }

        .status-badge {
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-block;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-approved {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-rejected {
            background: #f8d7da;
            color: #721c24;
        }

        .status-refunded {
            background: #d4edda;
            color: #155724;
        }

        .status-cancelled {
            background: #e2e3e5;
            color: #383d41;
        }

        .reason-box, .admin-notes-box {
            background: white;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
            border: 1px solid #dee2e6;
        }

        .reason-box {
            border-left: 4px solid #ffc107;
        }

        .admin-notes-box {
            border-left: 4px solid #17a2b8;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-approve {
            background: #28a745;
            color: white;
        }

        .btn-approve:hover {
            background: #218838;
        }

        .btn-reject {
            background: #dc3545;
            color: white;
        }

        .btn-reject:hover {
            background: #c82333;
        }

        .btn-refunded {
            background: #17a2b8;
            color: white;
        }

        .btn-refunded:hover {
            background: #138496;
        }

        .btn-back {
            background: #6c757d;
            color: white;
        }

        .btn-back:hover {
            background: #5a6268;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .modal-header {
            margin-bottom: 20px;
        }

        .modal-header h3 {
            margin: 0;
            color: #6c757d;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #495057;
        }

        .form-group textarea,
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: #000;
        }

        .amount {
            font-weight: bold;
            color: #28a745;
            font-size: 1.2rem;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .breadcrumb-nav {
            margin-top: 10px;
            font-size: 0.95rem;
            opacity: 0.95;
        }

        .breadcrumb-nav a {
            color: rgba(255,255,255,0.9);
            text-decoration: none;
        }

        .breadcrumb-nav a:hover {
            text-decoration: underline;
        }

        .breadcrumb-sep {
            margin: 0 6px;
            opacity: 0.7;
        }

        .requested-ago {
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: 4px;
        }

        .modal .alert-danger {
            margin-bottom: 15px;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 4px;
        }

        .form-group.is-invalid textarea,
        .form-group.is-invalid input,
        .form-group.is-invalid select {
            border-color: #dc3545;
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
                        <span><i class="fas fa-undo"></i> Return/Refund Request Details</span>
                    </h1>
                    <nav class="breadcrumb-nav" aria-label="Breadcrumb">
                        <a href="{{ route('admin.return_refunds.index') }}">Return/Refunds</a>
                        <span class="breadcrumb-sep">/</span>
                        <span>Request #{{ $returnRefund->id }}</span>
                    </nav>
                </div>

                <div class="details-container">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @php
                        $refundable = $returnRefund->refundable;
                    @endphp

                    <!-- Request Information -->
                    <div class="detail-section">
                        <h3>Request Information</h3>
                        <div class="detail-row">
                            <span class="detail-label">Request ID:</span>
                            <span class="detail-value">#{{ $returnRefund->id }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Status:</span>
                            <span class="status-badge status-{{ $returnRefund->status }}">{{ ucfirst($returnRefund->status) }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Request Type:</span>
                            <span class="detail-value">{{ ucfirst($returnRefund->type) }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Refund Amount:</span>
                            <span class="amount">₱{{ number_format($returnRefund->refund_amount, 2) }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Date Requested:</span>
                            <span class="detail-value">{{ $returnRefund->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                        <div class="requested-ago">
                            Requested {{ $returnRefund->created_at->diffForHumans() }}
                        </div>
                        @if($returnRefund->processed_at)
                        <div class="detail-row">
                            <span class="detail-label">Processed Date:</span>
                            <span class="detail-value">{{ $returnRefund->processed_at->format('M d, Y h:i A') }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- Customer Information -->
                    <div class="detail-section">
                        <h3>Customer Information</h3>
                        <div class="detail-row">
                            <span class="detail-label">Name:</span>
                            <span class="detail-value">{{ $returnRefund->user->name ?? 'N/A' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Email:</span>
                            <span class="detail-value">{{ $returnRefund->user->email ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <!-- Item Information -->
                    <div class="detail-section">
                        <h3>Item Information</h3>
                        @if($returnRefund->refundable_type === 'App\Models\EventBooking')
                            <div class="detail-row">
                                <span class="detail-label">Type:</span>
                                <span class="detail-value">Event Booking</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Event:</span>
                                <span class="detail-value">{{ $refundable->eventType->name ?? 'N/A' }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Event Date:</span>
                                <span class="detail-value">{{ $refundable->event_date->format('M d, Y') }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Number of Guests:</span>
                                <span class="detail-value">{{ $refundable->number_of_guests }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Booking Status:</span>
                                <span class="detail-value">{{ $refundable->status }}</span>
                            </div>
                        @else
                            <div class="detail-row">
                                <span class="detail-label">Type:</span>
                                <span class="detail-value">Order</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Item:</span>
                                <span class="detail-value">{{ $refundable->title ?? 'N/A' }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Quantity:</span>
                                <span class="detail-value">{{ $refundable->quantity }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Price per Item:</span>
                                <span class="detail-value">₱{{ number_format($refundable->price, 2) }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Order Status:</span>
                                <span class="detail-value">{{ $refundable->delivery_status }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Reason -->
                    <div class="detail-section">
                        <h3>Reason for Return/Refund</h3>
                        <div class="reason-box">
                            {{ $returnRefund->reason }}
                        </div>
                    </div>

                    <!-- Admin Notes -->
                    @if($returnRefund->admin_notes)
                    <div class="detail-section">
                        <h3>Admin Notes</h3>
                        <div class="admin-notes-box">
                            {{ $returnRefund->admin_notes }}
                        </div>
                    </div>
                    @endif

                    @if($returnRefund->approval_image_path)
                    <div class="detail-section">
                        <h3>Approval Image</h3>
                        <img src="{{ asset('storage/' . $returnRefund->approval_image_path) }}" alt="Approval image" style="max-width: 100%; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                    </div>
                    @endif

                    <!-- Refund Processing Details -->
                    @if($returnRefund->status === 'refunded')
                    <div class="detail-section">
                        <h3>Refund Processing Details</h3>
                        <div class="detail-row">
                            <span class="detail-label">Refund Method:</span>
                            <span class="detail-value">{{ $returnRefund->refund_method ?? 'N/A' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Reference Number:</span>
                            <span class="detail-value">{{ $returnRefund->refund_reference ?? 'N/A' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Processed Date:</span>
                            <span class="detail-value">{{ $returnRefund->processed_at ? $returnRefund->processed_at->format('M d, Y h:i A') : 'N/A' }}</span>
                        </div>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        @if($returnRefund->status === 'pending')
                            <button onclick="openApproveModal()" class="btn btn-approve">Approve</button>
                            <button onclick="openRejectModal()" class="btn btn-reject">Reject</button>
                        @elseif($returnRefund->status === 'approved')
                            <button onclick="openRefundedModal()" class="btn btn-refunded">Mark as Refunded</button>
                        @endif
                        <a href="{{ route('admin.return_refunds.index') }}" class="btn btn-back">Back to List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Approve Modal -->
    <div id="approveModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeModal('approveModal')">&times;</span>
                <h3>Approve Return/Refund Request</h3>
            </div>
            <form action="{{ route('admin.return_refunds.approve', $returnRefund->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(session('return_refund_modal') === 'approve' && $errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 list-unstyled">
                            @foreach($errors->all() as $msg)<li>{{ $msg }}</li>@endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group {{ $errors->has('admin_notes') ? 'is-invalid' : '' }}">
                    <label for="admin_notes_approve">Admin Notes (Optional):</label>
                    <textarea name="admin_notes" id="admin_notes_approve" placeholder="Add any notes about this approval...">{{ old('admin_notes') }}</textarea>
                </div>
                <div class="form-group {{ $errors->has('approval_image') ? 'is-invalid' : '' }}">
                    <label for="approval_image">Approval Image (Optional):</label>
                    <input type="file" name="approval_image" id="approval_image" accept="image/*">
                    @if($errors->has('approval_image'))<div class="invalid-feedback">{{ $errors->first('approval_image') }}</div>@endif
                </div>
                <div class="action-buttons">
                    <button type="submit" class="btn btn-approve">Confirm Approval</button>
                    <button type="button" onclick="closeModal('approveModal')" class="btn btn-back">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeModal('rejectModal')">&times;</span>
                <h3>Reject Return/Refund Request</h3>
            </div>
            <form action="{{ route('admin.return_refunds.reject', $returnRefund->id) }}" method="POST">
                @csrf
                @if($errors->has('admin_notes') && session('return_refund_modal') === 'reject')
                    <div class="alert alert-danger">{{ $errors->first('admin_notes') }}</div>
                @endif
                <div class="form-group {{ $errors->has('admin_notes') ? 'is-invalid' : '' }}">
                    <label for="admin_notes_reject">Reason for Rejection *:</label>
                    <textarea name="admin_notes" id="admin_notes_reject" required placeholder="Please provide a reason for rejection...">{{ old('admin_notes') }}</textarea>
                </div>
                <div class="action-buttons">
                    <button type="submit" class="btn btn-reject">Confirm Rejection</button>
                    <button type="button" onclick="closeModal('rejectModal')" class="btn btn-back">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Refunded Modal -->
    <div id="refundedModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeModal('refundedModal')">&times;</span>
                <h3>Mark as Refunded</h3>
            </div>
            <form action="{{ route('admin.return_refunds.refunded', $returnRefund->id) }}" method="POST">
                @csrf
                @if((session('return_refund_modal') === 'refunded') && $errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 list-unstyled">
                            @foreach($errors->all() as $msg)<li>{{ $msg }}</li>@endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group {{ $errors->has('refund_method') ? 'is-invalid' : '' }}">
                    <label for="refund_method">Refund Method *:</label>
                    <select name="refund_method" id="refund_method" required>
                        <option value="">Select method...</option>
                        <option value="GCash" {{ old('refund_method') === 'GCash' ? 'selected' : '' }}>GCash</option>
                        <option value="Bank Transfer" {{ old('refund_method') === 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        <option value="PayPal" {{ old('refund_method') === 'PayPal' ? 'selected' : '' }}>PayPal</option>
                        <option value="Store Credit" {{ old('refund_method') === 'Store Credit' ? 'selected' : '' }}>Store Credit</option>
                        <option value="Cash" {{ old('refund_method') === 'Cash' ? 'selected' : '' }}>Cash</option>
                        <option value="Other" {{ old('refund_method') === 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @if($errors->has('refund_method'))<div class="invalid-feedback">{{ $errors->first('refund_method') }}</div>@endif
                </div>
                <div class="form-group {{ $errors->has('refund_reference') ? 'is-invalid' : '' }}">
                    <label for="refund_reference">Reference Number *:</label>
                    <input type="text" name="refund_reference" id="refund_reference" value="{{ old('refund_reference') }}" required placeholder="Transaction reference number">
                    @if($errors->has('refund_reference'))<div class="invalid-feedback">{{ $errors->first('refund_reference') }}</div>@endif
                </div>
                <div class="form-group">
                    <label for="admin_notes_refunded">Admin Notes (Optional):</label>
                    <textarea name="admin_notes" id="admin_notes_refunded" placeholder="Add any additional notes...">{{ old('admin_notes') }}</textarea>
                </div>
                <div class="action-buttons">
                    <button type="submit" class="btn btn-refunded">Mark as Refunded</button>
                    <button type="button" onclick="closeModal('refundedModal')" class="btn btn-back">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openApproveModal() {
            document.getElementById('approveModal').style.display = 'block';
            setTimeout(function() { document.getElementById('admin_notes_approve')?.focus(); }, 100);
        }

        function openRejectModal() {
            document.getElementById('rejectModal').style.display = 'block';
            setTimeout(function() { document.getElementById('admin_notes_reject')?.focus(); }, 100);
        }

        function openRefundedModal() {
            document.getElementById('refundedModal').style.display = 'block';
            setTimeout(function() { document.getElementById('refund_method')?.focus(); }, 100);
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        };

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                document.querySelectorAll('.modal').forEach(function(m) { m.style.display = 'none'; });
            }
        });

        (function() {
            var modalToOpen = '{{ session('return_refund_modal', '') }}';
            if (modalToOpen === 'approve') openApproveModal();
            else if (modalToOpen === 'reject') openRejectModal();
            else if (modalToOpen === 'refunded') openRefundedModal();
        })();
    </script>

    @include('admin.js')
</body>
</html>
