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

        .edit-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            margin-left: 300px;
            margin-right: 20px;
            margin-top: 90px;
            margin-bottom: 20px;
            padding: 30px;
            max-width: calc(100% - 320px);
            min-height: calc(100vh - 130px);
            box-sizing: border-box;
            overflow-y: auto;
        }

        .page-title {
            color: #2c3e50;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 1rem;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        .review-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
        }

        .review-info-item {
            margin-bottom: 10px;
            color: #495057;
        }

        .review-info-label {
            font-weight: 600;
            color: #2c3e50;
        }

        .review-rating-display {
            color: #ffc107;
            font-size: 1.5rem;
            margin: 10px 0;
        }

        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s ease;
            width: 100%;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-back {
            background: #6c757d;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
            transition: background 0.3s ease;
        }

        .btn-back:hover {
            background: #5a6268;
            color: white;
            text-decoration: none;
        }

        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="edit-container">
        <a href="{{ route('admin.reviews') }}" class="btn-back">← Back to Reviews</a>
        
        <h1 class="page-title">Edit Review</h1>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="review-info">
            <div class="review-info-item">
                <span class="review-info-label">Rating:</span>
                <div class="review-rating-display">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $review->rating)
                            ★
                        @else
                            ☆
                        @endif
                    @endfor
                    <span style="color: #6c757d; font-size: 1rem; margin-left: 10px;">({{ $review->rating }}/5)</span>
                </div>
            </div>
            <div class="review-info-item">
                <span class="review-info-label">Status:</span> 
                <span style="text-transform: uppercase; font-weight: 600; color: {{ $review->status == 'approved' ? '#28a745' : ($review->status == 'rejected' ? '#dc3545' : '#ffc107') }};">
                    {{ $review->status }}
                </span>
            </div>
            <div class="review-info-item">
                <span class="review-info-label">Submitted:</span> {{ $review->created_at->format('M d, Y h:i A') }}
            </div>
        </div>

        <form method="POST" action="{{ route('admin.review.update', $review->id) }}">
            @csrf
            <div class="form-group">
                <label for="customer_name" class="form-label">Customer Name</label>
                <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ $review->customer_name }}" required>
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Review Description</label>
                <textarea class="form-control" id="description" name="description" placeholder="Enter review description...">{{ $review->description }}</textarea>
            </div>

            <button type="submit" class="btn-submit">Update Review</button>
        </form>
    </div>

    @include('admin.js')
</body>
</html>

