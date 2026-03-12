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
            min-height: 100vh;
            overflow-x: hidden;
        }

        .reviews-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            margin-left: 300px;
            margin-right: 20px;
            margin-top: 90px;
            margin-bottom: 20px;
            padding: 30px;
            min-height: calc(100vh - 130px);
            max-height: calc(100vh - 130px);
            width: calc(100% - 320px);
            box-sizing: border-box;
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
        }

        .reviews-list-scroll {
            max-height: calc(100vh - 380px);
            overflow-y: auto;
            overflow-x: hidden;
            padding-right: 8px;
            -webkit-overflow-scrolling: touch;
            scroll-behavior: smooth;
        }

        .reviews-list-scroll::-webkit-scrollbar {
            width: 8px;
        }

        .reviews-list-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .reviews-list-scroll::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 4px;
        }

        .reviews-list-scroll::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #5a6fd6, #6a4190);
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

        .review-item {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            border-left: 4px solid #667eea;
            transition: all 0.3s ease;
        }

        .review-item.pending {
            border-left-color: #ffc107;
            background: #fffbf0;
        }

        .review-item.approved {
            border-left-color: #28a745;
            background: #f0fff4;
        }

        .review-item.rejected {
            border-left-color: #dc3545;
            background: #fff5f5;
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .review-name {
            font-size: 1.3rem;
            font-weight: 600;
            color: #2c3e50;
            margin: 0;
        }

        .review-email {
            color: #6c757d;
            font-size: 0.9rem;
            margin-top: 5px;
        }

        .review-rating {
            color: #ffc107;
            font-size: 1.5rem;
            margin: 10px 0;
        }

        .review-description {
            color: #495057;
            line-height: 1.6;
            margin: 15px 0;
            font-size: 1rem;
        }

        .review-status {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending {
            background: #ffc107;
            color: #000;
        }

        .status-approved {
            background: #28a745;
            color: white;
        }

        .status-rejected {
            background: #dc3545;
            color: white;
        }

        .review-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .btn-action {
            padding: 8px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
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
            transform: translateY(-2px);
        }

        .btn-reject {
            background: #dc3545;
            color: white;
        }

        .btn-reject:hover {
            background: #c82333;
            transform: translateY(-2px);
        }

        .btn-edit {
            background: #007bff;
            color: white;
        }

        .btn-edit:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }

        .btn-delete {
            background: #6c757d;
            color: white;
        }

        .btn-delete:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 20px;
        }

        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
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

        .review-view-mode {
            display: block;
        }

        .review-edit-mode {
            display: none;
        }

        .review-item.editing .review-view-mode {
            display: none;
        }

        .review-item.editing .review-edit-mode {
            display: block;
        }

        .edit-form {
            margin-top: 15px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
            font-family: inherit;
        }

        .btn-save {
            background: #28a745;
            color: white;
        }

        .btn-save:hover {
            background: #218838;
            transform: translateY(-2px);
        }

        .btn-cancel {
            background: #6c757d;
            color: white;
        }

        .btn-cancel:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }

        .edit-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="reviews-container">
        <h1 class="page-title">Customer Reviews Management</h1>

        @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Statistics Cards -->
        <div class="stats-cards">
            <div class="stat-card">
                <div class="stat-number">{{ $reviews->count() }}</div>
                <div class="stat-label">Total Reviews</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $reviews->where('status', 'pending')->count() }}</div>
                <div class="stat-label">Pending</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $reviews->where('status', 'approved')->count() }}</div>
                <div class="stat-label">Approved</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $reviews->where('status', 'rejected')->count() }}</div>
                <div class="stat-label">Rejected</div>
            </div>
        </div>

        <!-- Reviews List (scrollable) -->
        <div class="reviews-list-scroll">
        @if($reviews->count() > 0)
            @foreach($reviews as $review)
                <div class="review-item {{ $review->status }}" id="review-{{ $review->id }}">
                    <!-- View Mode -->
                    <div class="review-view-mode">
                        <div class="review-header">
                            <div>
                                <h3 class="review-name" id="view-name-{{ $review->id }}">{{ $review->customer_name }}</h3>
                                @if($review->customer_email)
                                    <div class="review-email">{{ $review->customer_email }}</div>
                                @endif
                            </div>
                            <span class="review-status status-{{ $review->status }}">{{ $review->status }}</span>
                        </div>
                        
                        <div class="review-rating" style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
                            <div style="display: flex; align-items: center; gap: 5px;">
                                <div style="color: #ffc107; font-size: 1.5rem; letter-spacing: 2px;">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            ★
                                        @else
                                            <span style="color: #ddd;">☆</span>
                                        @endif
                                    @endfor
                                </div>
                                <span style="color: #6c757d; font-size: 1rem; font-weight: 600;">({{ $review->rating }}/5)</span>
                            </div>
                            @php
                                $ratingLabels = [
                                    1 => 'Bad',
                                    2 => 'Poor',
                                    3 => 'Good',
                                    4 => 'Very Good',
                                    5 => 'Excellent'
                                ];
                                $ratingLabel = $ratingLabels[$review->rating] ?? 'Good';
                                $ratingColors = [
                                    1 => '#dc3545',
                                    2 => '#ff9800',
                                    3 => '#ffc107',
                                    4 => '#28a745',
                                    5 => '#17a2b8'
                                ];
                                $ratingColor = $ratingColors[$review->rating] ?? '#ffc107';
                            @endphp
                            <span style="background: {{ $ratingColor }}; color: white; padding: 6px 15px; border-radius: 20px; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                                {{ $ratingLabel }}
                            </span>
                        </div>

                        <div class="review-description" id="view-description-{{ $review->id }}">
                            @if($review->description)
                                "{{ $review->description }}"
                            @else
                                <em style="color: #999;">No description provided.</em>
                            @endif
                        </div>

                        <div style="color: #6c757d; font-size: 0.85rem; margin-top: 10px;">
                            Submitted: {{ $review->created_at->format('M d, Y h:i A') }}
                        </div>

                        <div class="review-actions">
                            @if($review->status == 'pending')
                                <a href="{{ route('admin.review.approve', $review->id) }}" class="btn-action btn-approve">Approve</a>
                                <a href="{{ route('admin.review.reject', $review->id) }}" class="btn-action btn-reject">Reject</a>
                            @endif
                            <a href="{{ route('admin.review.delete', $review->id) }}" class="btn-action btn-delete" onclick="return confirm('Are you sure you want to delete this review?')">Delete</a>
                        </div>
                    </div>

                    <!-- Edit Mode -->
                    <div class="review-edit-mode">
                        <div class="review-header">
                            <div>
                                <h3 class="review-name">Edit Review</h3>
                            </div>
                            <span class="review-status status-{{ $review->status }}">{{ $review->status }}</span>
                        </div>

                        <form class="edit-form" id="edit-form-{{ $review->id }}" onsubmit="saveReview(event, {{ $review->id }})" data-update-url="{{ route('admin.review.update', $review->id) }}">
                            @csrf
                            <div class="form-group">
                                <label for="customer_name_{{ $review->id }}" class="form-label">Customer Name</label>
                                <input type="text" class="form-control" id="customer_name_{{ $review->id }}" name="customer_name" value="{{ $review->customer_name }}" required>
                            </div>

                            <div class="form-group">
                                <label for="description_{{ $review->id }}" class="form-label">Review Description</label>
                                <textarea class="form-control" id="description_{{ $review->id }}" name="description" placeholder="Enter review description...">{{ $review->description }}</textarea>
                            </div>

                            <div class="edit-actions">
                                <button type="submit" class="btn-action btn-save">Save</button>
                                <button type="button" class="btn-action btn-cancel" onclick="cancelEdit({{ $review->id }})">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <div class="empty-state-icon">📝</div>
                <h2>No Reviews Yet</h2>
                <p>Customer reviews will appear here once they are submitted.</p>
            </div>
        @endif
        </div>
    </div>

    @include('admin.js')
    <script>
        function toggleEdit(reviewId) {
            const reviewItem = document.getElementById('review-' + reviewId);
            reviewItem.classList.add('editing');
        }

        function cancelEdit(reviewId) {
            const reviewItem = document.getElementById('review-' + reviewId);
            reviewItem.classList.remove('editing');
            // Restore original values from view mode
            const viewName = document.getElementById('view-name-' + reviewId).textContent;
            const viewDesc = document.getElementById('view-description-' + reviewId);
            const descText = viewDesc.textContent.replace(/^"|"$/g, '').trim();
            
            document.getElementById('customer_name_' + reviewId).value = viewName;
            document.getElementById('description_' + reviewId).value = descText === 'No description provided.' ? '' : descText;
        }

        function saveReview(event, reviewId) {
            event.preventDefault();
            
            const form = document.getElementById('edit-form-' + reviewId);
            const formData = new FormData(form);
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Show loading state
            const saveBtn = form.querySelector('.btn-save');
            const originalText = saveBtn.textContent;
            saveBtn.textContent = 'Saving...';
            saveBtn.disabled = true;

            const updateUrl = form.getAttribute('data-update-url');
            
            fetch(updateUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success || data.message) {
                    // Update view mode with new values
                    const customerName = document.getElementById('customer_name_' + reviewId).value;
                    const description = document.getElementById('description_' + reviewId).value;
                    
                    document.getElementById('view-name-' + reviewId).textContent = customerName;
                    
                    const descElement = document.getElementById('view-description-' + reviewId);
                    if (description.trim()) {
                        descElement.innerHTML = '"' + description + '"';
                    } else {
                        descElement.innerHTML = '<em style="color: #999;">No description provided.</em>';
                    }
                    
                    // Exit edit mode
                    cancelEdit(reviewId);
                    
                    // Show success message
                    showMessage('Review updated successfully!', 'success');
                } else {
                    showMessage(data.error || 'Failed to update review', 'error');
                    saveBtn.textContent = originalText;
                    saveBtn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('An error occurred while updating the review', 'error');
                saveBtn.textContent = originalText;
                saveBtn.disabled = false;
            });
        }

        function showMessage(message, type) {
            // Remove existing alerts
            const existingAlerts = document.querySelectorAll('.alert');
            existingAlerts.forEach(alert => alert.remove());
            
            // Create new alert
            const alert = document.createElement('div');
            alert.className = 'alert alert-' + (type === 'success' ? 'success' : 'danger');
            alert.textContent = message;
            
            // Insert after page title
            const pageTitle = document.querySelector('.page-title');
            pageTitle.parentNode.insertBefore(alert, pageTitle.nextSibling);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                alert.remove();
            }, 5000);
        }
    </script>
</body>
</html>

