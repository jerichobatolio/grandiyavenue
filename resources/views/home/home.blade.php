<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Dynamic tab title -->
    <title>{{ $type }} | Grandiya Venue & Restaurant</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/imgs/logo.png') }}" type="image/png">

    @include('home.css')

    <style>
        body {
            background-color: #1b1b1b;
            color: white;
            font-family: Arial, sans-serif;
        }

        h3 {
            margin-top: 100px;
        }

        .foods-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 20px;
            width: 90%;
            margin: 0 auto 50px auto;
        }

        .food-row {
            display: flex;
            flex-direction: column;
            background-color: #2c2c2c;
            border: 1px solid skyblue;
            border-radius: 10px;
            padding: 15px;
            color: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            transition: transform 0.2s;
        }

        .food-row:hover {
            transform: scale(1.02);
        }

        .food-row img {
            width: 100%;
            max-height: 220px;
            object-fit: contain;
            background-color: #111;
            border-radius: 10px;
            margin-bottom: 12px;
        }

        .food-details {
            text-align: left;
        }

        .food-meta {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .food-details h5 {
            margin: 0;
            font-size: 1.05rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 65%;
        }

        .food-details p {
            margin: 8px 0 0 0;
            font-size: 0.9rem;
            color: #ddd;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .btn-add {
            padding: 8px 15px;
            background-color: gold;
            color: black;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-add:hover {
            background-color: #ffc107;
            transform: translateY(-1px);
        }

        .add-form {
            margin-left: auto;
        }


        .back-link:hover {
            color: gold;
        }

        /* Bundle-specific styles */
        .bundle-row {
            border: 2px solid gold !important;
            background-color: #2c2c2c !important;
        }

        .bundle-placeholder {
            width: 200px;
            height: 200px;
            background-color: #2c2c2c;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
        }

        .bundle-foods ul {
            margin: 0;
            padding-left: 20px;
            color: #ddd;
            font-size: 0.9rem;
        }

        .bundle-foods li {
            margin-bottom: 2px;
        }

        .badge-bundle {
            background-color: gold;
            color: black;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            margin-left: 10px;
        }
    </style>
</head>
<body>

    <!-- Foods under selected category -->
    @isset($foods)

    @php
        $displayType = isset($type) && strtolower($type) === 'bunddle package' ? 'Bundle Package' : ($type ?? '');
    @endphp

    <div style="text-align: center; margin: 20px 0;">
        <a href="{{ route('home') }}#blog" class="back-link" style="display: inline-flex; align-items: center; color: skyblue; text-decoration: none; font-size: 1.1rem; transition: color 0.3s ease;">
            <span style="margin-right: 8px; font-size: 1.2rem;">←</span>
            Back to Grandiya Specialties
        </a>
    </div>
    
    <h3 class="text-center mb-4 text-white">
        @if(isset($subcategory))
            {{ $subcategory }} {{ $displayType }}
        @else
            {{ $displayType }}
        @endif
    </h3>

    <div class="foods-container">
        @if(isset($isBundle) && $isBundle && isset($bundles))
            <!-- Bundle Package Display -->
            @forelse($bundles as $bundle)
            <div class="food-row bundle-row">
                @if($bundle->image)
                    <img src="{{ asset('food_img/'.$bundle->image) }}" alt="{{ $bundle->name }}">
                @else
                    <div class="bundle-placeholder" style="width: 200px; height: 200px; background-color: #2c2c2c; display: flex; align-items: center; justify-content: center; border-radius: 10px;">
                        <i class="fas fa-box" style="font-size: 3rem; color: #666;"></i>
                    </div>
                @endif
                <div class="food-details">
                    <div class="food-meta">
                        <h5 title="{{ $bundle->name }}">{{ $bundle->name }}</h5>
                        <span class="badge badge-bundle" style="background-color: gold; color: black; padding: 2px 8px; border-radius: 4px; font-size: 0.8rem;">Bundle Package</span>
                    </div>
                    <p>{{ $bundle->description }}</p>
                    
                    <!-- Bundle Foods List -->
                    <div class="bundle-foods">
                        <h6 style="color: #ccc; margin: 8px 0 4px 0;">Includes:</h6>
                        <ul style="margin: 0; padding-left: 20px; color: #ddd; font-size: 0.9rem;">
                            @foreach($bundle->foods as $food)
                                <li>{{ $food->title }} 
                                    @if($food->pivot->quantity > 1)
                                        ({{ $food->pivot->quantity }}x)
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <p style="color: gold; font-weight: bold; margin: 8px 0;">
                        Bundle Price: ₱{{ number_format($bundle->bundle_price, 2) }}
                        @if($bundle->total_individual_price > $bundle->bundle_price)
                            <br><small style="color: #4CAF50;">Save ₱{{ number_format($bundle->savings, 2) }} ({{ $bundle->savings_percentage }}%)</small>
                        @endif
                    </p>
                    
                    <div class="add-form">
                        <form action="{{ url('cart/add-bundle/' . $bundle->id) }}" method="POST" class="bundle-form">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn-add">Add Bundle to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-center text-white">No bundle packages added yet in {{ $displayType }}.</p>
            @endforelse
        @else
            <!-- Regular Individual Items -->
            @forelse($foods as $food)
            <div class="food-row">
                <img src="{{ asset('food_img/'.$food->image) }}" alt="{{ $food->title }}">
                <div class="food-details">
                    <div class="food-meta">
                        @if(method_exists($food, 'bundles') && $food->bundles->count() > 0)
                            @php $bundle = $food->bundles->first(); @endphp
                            <span class="badge-bundle">Bundle: {{ $bundle->name }}</span>
                            <span style="color: gold; font-weight: bold; margin-left: 8px;">
                                ₱{{ number_format($bundle->bundle_price, 2) }}
                            </span>
                        @endif
                        <h5 title="{{ $food->title }}">{{ $food->title }}</h5>
                    </div>
                    <p>{{ $food->detail }}</p>
                    @if(isset($isBundle) && $isBundle && $food->bundle_price)
                        <p style="color: gold; font-weight: bold; margin: 8px 0;">
                            Bundle Price: ₱{{ $food->bundle_price }}
                            @if($food->price != $food->bundle_price)
                                <br><small style="color: #ccc;">Regular: ₱{{ $food->price }}</small>
                            @endif
                        </p>
                    @else
                        <p style="color: gold; font-weight: bold; margin: 8px 0;">₱{{ $food->price }}</p>
                    @endif
                    <div class="add-form">
                        <form action="{{ url('cart/add/' . $food->id) }}" method="POST" class="food-form">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn-add">Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-center text-white">
                No foods added yet in 
                @if(isset($subcategory))
                    {{ $subcategory }} {{ $displayType }}.
                @else
                    {{ $displayType }}.
                @endif
            </p>
            @endforelse
        @endif
    </div>

    @endisset

    <script>
        // Handle AJAX form submissions for adding items to cart
        document.addEventListener('DOMContentLoaded', function() {
            // Handle food form submissions
            document.querySelectorAll('.food-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    const url = this.action;
                    
                    fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success message
                            showMessage(data.message, 'success');
                            // Update cart count if available
                            if (data.cart_count) {
                                updateCartCount(data.cart_count);
                            }
                        } else {
                            showMessage(data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showMessage('An error occurred. Please try again.', 'error');
                    });
                });
            });

            // Handle bundle form submissions
            document.querySelectorAll('.bundle-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    const url = this.action;
                    
                    fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = "{{ route('my_cart') }}";
                        } else {
                            showMessage(data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showMessage('An error occurred. Please try again.', 'error');
                    });
                });
            });
        });

        function showMessage(message, type) {
            // Create a temporary message element
            const messageDiv = document.createElement('div');
            messageDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'}`;
            messageDiv.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                padding: 15px 20px;
                border-radius: 5px;
                color: white;
                font-weight: bold;
                max-width: 300px;
                ${type === 'success' ? 'background-color: #28a745;' : 'background-color: #dc3545;'}
            `;
            messageDiv.textContent = message;
            
            document.body.appendChild(messageDiv);
            
            // Remove message after 3 seconds
            setTimeout(() => {
                messageDiv.remove();
            }, 3000);
        }

        function updateCartCount(count) {
            // Update cart count in header if element exists
            const cartCountElement = document.querySelector('.cart-count');
            if (cartCountElement) {
                cartCountElement.textContent = count;
            }
        }
    </script>

</body>
</html>
