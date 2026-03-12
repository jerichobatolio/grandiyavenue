<!DOCTYPE html>
<html lang="en">
<head>
    @include('home.css')
    <title>Checkout | Grandiya Venue & Restaurant</title>
    <style>
        body {
            background-color: #1b1b1b;
            color: white;
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        /* Cart Table */
        .cart-container {
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

        img.cart-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-qty {
            width: 35px;
            height: 35px;
            font-weight: bold;
            font-size: 16px;
            padding: 0;
            background-color: gold;
            border: none;
            color: black;
            cursor: pointer;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .btn-qty:hover {
            background-color: #ffc107;
            transform: scale(1.1);
        }

        input.qty-input {
            width: 50px;
            height: 35px;
            text-align: center;
            border: 2px solid #444;
            background-color: #1a1a1a;
            color: white;
            font-weight: bold;
            border-radius: 8px;
            font-size: 14px;
        }

        .remove-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
        }

        .remove-btn:hover {
            background-color: #c82333;
            transform: scale(1.05);
        }

        .total-price {
            margin-top: 10px;
            font-size: 1.2rem;
            font-weight: bold;
            text-align: center;
            color: white;
        }

        /* Buttons */
        .div_center {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn-custom {
            padding: 10px 20px;
            font-size: 14px;
            border-radius: 20px;
            font-weight: bold;
        }

        .btn-checkout {
            background-color: gold;
            color: black;
        }

        .btn-more {
            background-color: black;
            color: white;
        }

        /* Modal Overlay */
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

        /* Order Summary Modal */
        .order-summary {
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            background-color: #2c2c2c;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            border: 2px solid gold;
            position: relative;
            overflow-y: auto;
            animation: slideIn 0.3s ease;
        }

        .modal-close {
            position: absolute;
            top: 15px;
            right: 20px;
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            transition: color 0.3s;
        }

        .modal-close:hover {
            color: gold;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from { 
                opacity: 0;
                transform: translateY(-50px) scale(0.9);
            }
            to { 
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .order-summary h2 {
            text-align: center;
            margin-bottom: 30px;
            color: gold;
            font-size: 1.8rem;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #444;
        }

        .summary-item:last-child {
            border-bottom: none;
        }

        .item-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .item-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }

        .item-details h4 {
            margin: 0;
            color: white;
            font-size: 1.1rem;
        }

        .item-details p {
            margin: 5px 0 0 0;
            color: #ccc;
            font-size: 0.9rem;
        }

        .item-price {
            text-align: right;
        }

        .item-price .price {
            font-size: 1.1rem;
            font-weight: bold;
            color: gold;
        }

        .item-price .quantity {
            color: #ccc;
            font-size: 0.9rem;
        }

        .total-section {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid gold;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
        }

        .total-row.final {
            font-size: 1.3rem;
            font-weight: bold;
            color: gold;
            border-top: 1px solid #444;
            margin-top: 10px;
            padding-top: 15px;
        }

        /* Main Layout */
        .main-content {
            display: block;
            max-width: 1000px;
            margin: 20px auto;
            padding: 0 20px;
        }

        .cart-section {
            margin-bottom: 30px;
        }

        .checkout-section {
            margin-top: 30px;
        }

        /* Checkout Form */
        .checkout-container {
            background-color: #2c2c2c;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            display: none; /* Initially hidden */
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }

        .checkout-container.show {
            display: block;
        }

        .checkout-container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: gold;
            font-size: 1.8rem;
        }

        .form-row {
            display: block;
            margin-bottom: 0;
        }

        .form-group {
            margin-bottom: 25px;
            width: 100%;
        }

        .checkout-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: white;
            font-size: 1rem;
        }

        .checkout-container input[type="text"],
        .checkout-container input[type="tel"],
        .checkout-container textarea,
        .checkout-container select,
        .checkout-container input[type="file"] {
            width: 100%;
            padding: 15px;
            margin-bottom: 0;
            border: 2px solid #444;
            border-radius: 8px;
            background-color: white;
            color: #333;
            font-size: 16px;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
            display: block;
        }

        .checkout-container input[type="file"] {
            cursor: pointer;
        }

        .checkout-container input:focus,
        .checkout-container textarea:focus,
        .checkout-container select:focus {
            outline: none;
            border-color: gold;
        }

        .checkout-container input[type="file"]:focus {
            outline: none;
            border-color: gold;
        }

        .checkout-container textarea {
            resize: vertical;
            min-height: 80px;
            font-family: inherit;
        }

        .checkout-container select {
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 16px;
            padding-right: 40px;
        }

        .checkout-container .btn-submit {
            width: 100%;
            padding: 15px;
            background-color: gold;
            color: black;
            font-weight: bold;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        .checkout-container .btn-submit:hover {
            background-color: #ffc107;
            transform: translateY(-2px);
        }

        /* Simplified form styling */
        .form-section {
            background-color: #333;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid gold;
        }

        .form-section h3 {
            color: gold;
            margin-bottom: 15px;
            font-size: 1.1rem;
        }

        /* Logout button */
        .logout-btn {
            position: fixed;
            top: 20px;
            right: 20px;
        }

        .back-link:hover {
            color: gold;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .main-content {
                padding: 0 15px;
            }
            
            .checkout-container {
                max-width: 100%;
            }
        }

        @media (max-width: 768px) {
            .order-summary {
                width: 95%;
                max-height: 85vh;
                padding: 20px;
            }
            
            .main-content {
                padding: 0 10px;
            }
            
            .checkout-container {
                margin: 0;
                padding: 15px;
            }
            
            .form-section {
                padding: 15px;
                margin-bottom: 15px;
            }
            
            .checkout-container input[type="text"],
            .checkout-container input[type="tel"],
            .checkout-container textarea,
            .checkout-container select {
                padding: 15px;
                font-size: 16px;
                width: 100%;
                box-sizing: border-box;
                display: block;
            }
            
            .checkout-container .btn-submit {
                padding: 15px;
                font-size: 16px;
            }
            
            .summary-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .item-info {
                width: 100%;
            }
            
            .item-price {
                text-align: left;
                width: 100%;
            }
            
            .cart-container {
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
            
            img.cart-img {
                width: 80px;
                height: 80px;
            }
        }

        @media (max-width: 480px) {
            .order-summary {
                width: 98%;
                max-height: 90vh;
                padding: 15px;
            }
            
            .checkout-container {
                margin: 10px;
                padding: 15px;
            }
            
            .checkout-container h2,
            .order-summary h2 {
                font-size: 1.5rem;
            }
            
            .total-row.final {
                font-size: 1.1rem;
            }
            
            .cart-container {
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
            
            img.cart-img {
                width: 60px;
                height: 60px;
            }
            
            .btn-qty {
                width: 30px;
                height: 30px;
                font-size: 14px;
            }
            
            input.qty-input {
                width: 40px;
                height: 30px;
            }
        }

        .empty-cart-state {
            text-align: center;
            padding: 40px 20px;
            color: #ccc;
        }

        .empty-cart-icon {
            font-size: 4rem;
            margin-bottom: 15px;
        }

        .empty-cart-state h3 {
            color: white;
            margin-bottom: 10px;
        }

        .empty-cart-state p {
            color: #bbb;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <!-- Back to Home button -->
    <div style="text-align: center; margin: 20px 0;">
        <a href="{{ url('/home') }}" class="back-link" style="display: inline-flex; align-items: center; color: skyblue; text-decoration: none; font-size: 1.1rem; transition: color 0.3s ease;">
            <span style="margin-right: 8px; font-size: 1.2rem;">←</span>
            Back to Home
        </a>
    </div>

    <!-- Main Content Layout -->
    <div class="main-content">
        @php
            $total_price = 0;
            $hasCartItems = isset($cartItems) && count($cartItems) > 0;
        @endphp
        <!-- Cart Section -->
        <div class="cart-section">
            <div class="cart-container">
                <h2 style="text-align: center; color: gold; margin-bottom: 20px; font-size: 1.8rem;">🛒 Your Cart Items</h2>
                @if($hasCartItems)
                    <table>
                        <tr>
                            <th>Image</th>
                            <th>Food Title</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>

                        @foreach($cartItems as $item)
                        @php $line_total = $item->price * $item->quantity; $total_price += $line_total; @endphp
                        <tr>
                            <td>
                                <img src="{{ asset('food_img/'.$item->image) }}" alt="{{ $item->title }}" class="cart-img">
                            </td>
                            <td>
                                <div class="food-title">{{ $item->title }}</div>
                            </td>
                            <td>
                                <div class="food-price">₱{{ $item->price }}</div>
                            </td>
                            <td>
                                <form action="{{ url('update_cart', $item->id) }}" method="POST" class="quantity-controls">
                                    @csrf
                                    <button type="submit" name="action" value="decrease" class="btn-qty">-</button>
                                    <input type="text" name="quantity" value="{{ $item->quantity }}" readonly class="qty-input">
                                    <button type="submit" name="action" value="increase" class="btn-qty">+</button>
                                </form>
                            </td>
                            <td>
                                <div class="food-price">₱{{ $line_total }}</div>
                            </td>
                            <td>
                                <a onclick="return confirm('Are you sure to remove this item?')" class="remove-btn" href="{{ url('remove_cart', $item->id) }}">Remove</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>

                    <div class="total-price">
                        <strong>Total Price: ₱{{ $total_price }}</strong>
                    </div>
                @else
                    <div class="empty-cart-state">
                        <div class="empty-cart-icon">🛒</div>
                        <h3>Your cart is empty</h3>
                        <p>Add delicious meals to see them listed here.</p>
                        <a href="{{ route('home') }}#blog" class="btn btn-more btn-custom">Browse Menu</a>
                    </div>
                @endif
            </div>

            <!-- Buttons -->
            <div class="div_center">
                <a href="{{ route('home') }}#blog" class="btn btn-more btn-custom">Add More Items to Cart</a>
                @if($hasCartItems)
                    <button onclick="openOrderSummary()" class="btn btn-checkout btn-custom">Review Order & Checkout</button>
                @endif
            </div>
        </div>

        @if($hasCartItems)
        <!-- Checkout Section -->
        <div class="checkout-section">
            <!-- Checkout Form -->
            <div class="checkout-container">
                <h2>Delivery Information</h2>
                <form action="{{ url('place_order') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Customer Information -->
                    <div class="form-section">
                        <h3>Customer Information</h3>
                        
                        <div class="form-group">
                            <label for="fullname">Full Name</label>
                            <input type="text" name="fullname" id="fullname" placeholder="Enter your full name" required value="{{ old('fullname') }}">
                            @error('fullname')
                                <div style="color: #dc3545; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="contact">Contact Number</label>
                            <input type="tel" name="contact" id="contact" placeholder="Enter your mobile/cell number" required value="{{ old('contact') }}">
                            @error('contact')
                                <div style="color: #dc3545; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="address">Delivery Address</label>
                            <textarea name="address" id="address" placeholder="Enter your complete delivery address (Street, Barangay, City, Province)" required>{{ old('address') }}</textarea>
                            @error('address')
                                <div style="color: #dc3545; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Payment & Instructions -->
                    <div class="form-section">
                        <h3>Payment & Instructions</h3>
                        
                        <div class="form-group">
                            <label for="payment">Payment Method</label>
                            <select name="payment" id="payment" required>
                                <option value="" disabled selected>Select payment method</option>
                                <option value="GCash">GCash</option>
                                <option value="Cash On Delivery">Cash On Delivery</option>
                            </select>
                            @error('payment')
                                <div style="color: #dc3545; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Payment Proof Upload (only visible when GCash is selected) -->
                        <div class="form-group" id="payment-proof-group" style="display: none;">
                            <label for="payment_proof">Upload Payment Receipt (Required for GCash)</label>
                            <input type="file" name="payment_proof" id="payment_proof" accept="image/*,application/pdf">
                            <small style="color: #ccc; display: block; margin-top: 5px;">Upload screenshot or photo of your GCash payment receipt</small>
                            @error('payment_proof')
                                <div style="color: #dc3545; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="notes">Special Instructions (Optional)</label>
                            <textarea name="notes" id="notes" placeholder="Any special instructions, dietary restrictions, or requests for your order"></textarea>
                        </div>
                    </div>

                    <!-- Order Summary in Form -->
                    <div class="form-section">
                        <h3>Order Summary</h3>
                        <div style="background-color: #444; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                <span>Subtotal:</span>
                                <span>₱{{ $total_price }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                <span>Delivery Fee:</span>
                                <span>₱0</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; font-size: 1.2rem; font-weight: bold; color: gold; border-top: 1px solid #666; padding-top: 10px;">
                                <span>Total Amount:</span>
                                <span>₱{{ $total_price }}</span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">Place Order - ₱{{ $total_price }}</button>
                </form>
            </div>
        </div>
        @endif
    </div>

    @if($hasCartItems)
    <!-- Order Summary Modal -->
    <div id="order-summary-modal" class="modal-overlay" onclick="closeOrderSummary(event)">
        <div class="order-summary" onclick="event.stopPropagation()">
            <button class="modal-close" onclick="closeOrderSummary()">&times;</button>
            <h2>Order Summary</h2>
            
            @foreach($cartItems as $item)
            <div class="summary-item">
                <div class="item-info">
                    <img src="{{ asset('food_img/'.$item->image) }}" alt="{{ $item->title }}" class="item-image">
                    <div class="item-details">
                        <h4>{{ $item->title }}</h4>
                        <p>₱{{ $item->price }} each</p>
                    </div>
                </div>
                <div class="item-price">
                    <div class="price">₱{{ $item->price * $item->quantity }}</div>
                    <div class="quantity">Qty: {{ $item->quantity }}</div>
                </div>
            </div>
            @endforeach

            <div class="total-section">
                <div class="total-row">
                    <span>Subtotal:</span>
                    <span>₱{{ $total_price }}</span>
                </div>
                <div class="total-row">
                    <span>Delivery Fee:</span>
                    <span>₱0</span>
                </div>
                <div class="total-row final">
                    <span>Total Amount:</span>
                    <span>₱{{ $total_price }}</span>
                </div>
            </div>
            
            <div style="margin-top: 30px; text-align: center;">
                <button onclick="addMoreItems()" class="btn btn-more btn-custom" style="margin-right: 10px;">Add More Items to Cart</button>
                <button onclick="proceedToCheckout()" class="btn btn-checkout btn-custom">Proceed to Checkout</button>
            </div>
        </div>
    </div>
    @endif

    @if($hasCartItems)
    <!-- GCash QR Code Modal -->
    <div id="gcash-qr-modal" class="modal-overlay" onclick="closeGCashModal(event)">
        <div class="order-summary" onclick="event.stopPropagation()">
            <button class="modal-close" onclick="closeGCashModal()">&times;</button>
            <h2>💳 Pay via GCash</h2>
            
            <div style="text-align: center; padding: 20px;">
                <h3 style="color: white; margin-bottom: 20px;">Total Amount: ₱<span id="qr-modal-total">{{ $total_price }}</span></h3>
                
                <div style="margin: 30px 0;">
                    @if(isset($adminQrCode) && $adminQrCode)
                        <img src="{{ $adminQrCode->image_url }}" alt="GCash QR Code" style="max-width: 300px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.3);">
                    @else
                        <div style="background-color: #ffc107; color: #000; padding: 20px; border-radius: 10px; margin: 20px 0;">
                            <p style="margin: 0; font-weight: bold;">
                                ⚠️ QR Code Not Available<br>
                                Please contact the administrator to set up the payment QR code.
                            </p>
                        </div>
                    @endif
                </div>
                
                <p style="color: #ccc; margin-bottom: 20px;">
                    Scan the QR code using your GCash app to complete payment
                </p>
                
                <div style="background-color: #4d3a00; color: white; padding: 15px; border-radius: 8px; margin: 20px 0;">
                    <strong>Important:</strong> Please keep your GCash transaction receipt as proof of payment. 
                    Only GCash receipts are accepted.
                </div>

                <div style="margin-top: 30px; text-align: center;">
                    <button onclick="closeGCashModal()" class="btn btn-more btn-custom" style="margin-right: 10px;">I'll Pay Later</button>
                    <button onclick="markAsPaid()" class="btn btn-checkout btn-custom">I've Already Paid</button>
                </div>
            </div>
        </div>
    </div>
    @endif


    <script>
        const hasCartItems = @json($hasCartItems);

        // Auto-show modal when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Show the order summary popup automatically
            if (hasCartItems) {
                openOrderSummary();
            }

            // Handle payment method selection
            const paymentSelect = document.getElementById('payment');
            const paymentProofGroup = document.getElementById('payment-proof-group');
            const paymentProof = document.getElementById('payment_proof');
            
            // Check if there are validation errors and set the payment method accordingly
            const hasValidationErrors = document.querySelector('.error') || document.querySelector('[style*="color: #dc3545"]');
            if (hasCartItems && paymentSelect && paymentProofGroup && paymentProof && hasValidationErrors && paymentSelect.value === 'GCash') {
                paymentProofGroup.style.display = 'block';
                paymentProof.setAttribute('required', 'required');
            }
            
            if (paymentSelect && paymentProofGroup && paymentProof && hasCartItems) {
                paymentSelect.addEventListener('change', function() {
                    if (this.value === 'GCash') {
                        // Show GCash QR modal when GCash is selected
                        openGCashModal();
                        // Show payment proof upload field
                        paymentProofGroup.style.display = 'block';
                        paymentProof.setAttribute('required', 'required');
                    } else {
                        // Hide payment proof upload for COD
                        paymentProofGroup.style.display = 'none';
                        paymentProof.removeAttribute('required');
                        paymentProof.value = ''; // Clear the file input
                    }
                });
            }

            // Handle form submission validation for GCash
            const checkoutForm = document.querySelector('.checkout-container form');
            if (hasCartItems && checkoutForm && paymentSelect && paymentProof) {
                checkoutForm.addEventListener('submit', function(e) {
                    const paymentMethod = paymentSelect.value;
                    const hasProof = paymentProof.files.length > 0;
                    
                    if (paymentMethod === 'GCash' && !hasProof) {
                        e.preventDefault();
                        alert('Please upload your GCash payment receipt before submitting the order.');
                        paymentProof.focus();
                        return false;
                    }
                });
            }
        });

        // Modal functionality
        function openOrderSummary() {
            if (!hasCartItems) return;
            const modal = document.getElementById('order-summary-modal');
            if (!modal) return;
            modal.classList.add('show');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        function closeOrderSummary(event) {
            const modal = document.getElementById('order-summary-modal');
            if (!modal) return;
            // Close if clicking on overlay or close button
            if (!event || event.target === event.currentTarget || event.target.classList.contains('modal-close')) {
                modal.classList.remove('show');
                document.body.style.overflow = 'auto'; // Restore scrolling
            }
        }

        function proceedToCheckout() {
            closeOrderSummary();
            // Show the delivery information
            const checkoutContainer = document.querySelector('.checkout-container');
            if (checkoutContainer) {
                checkoutContainer.classList.add('show');
            }
            // Scroll to the checkout section smoothly
            const checkoutSection = document.querySelector('.checkout-section');
            if (checkoutSection) {
                checkoutSection.scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }

        function addMoreItems() {
            closeOrderSummary();
            // Redirect to Homepage Food Categories
            window.location.href = "{{ route('home') }}#blog";
        }

        // GCash QR Modal functionality
        function openGCashModal() {
            if (!hasCartItems) return;
            const modal = document.getElementById('gcash-qr-modal');
            if (!modal) return;
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeGCashModal(event) {
            const modal = document.getElementById('gcash-qr-modal');
            if (!modal) return;
            if (!event || event.target === event.currentTarget || event.target.classList.contains('modal-close')) {
                modal.classList.remove('show');
                document.body.style.overflow = 'auto';
            }
        }

        function markAsPaid() {
            if (!hasCartItems) return;
            closeGCashModal();
            // Scroll to payment proof upload field
            const proofGroup = document.getElementById('payment-proof-group');
            if (proofGroup) {
                proofGroup.scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'center'
                });
            }
            // Focus on the file input
            setTimeout(function() {
                const proofInput = document.getElementById('payment_proof');
                if (proofInput) {
                    proofInput.focus();
                }
            }, 500);
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeOrderSummary();
                closeGCashModal();
            }
        });

        // Prevent modal from closing when clicking inside the modal content
        document.addEventListener('DOMContentLoaded', function() {
            const orderModal = document.getElementById('order-summary-modal');
            const gcashModal = document.getElementById('gcash-qr-modal');
            
            if (orderModal) {
                orderModal.addEventListener('click', function(event) {
                    if (event.target === orderModal) {
                        closeOrderSummary();
                    }
                });
            }

            if (gcashModal) {
                gcashModal.addEventListener('click', function(event) {
                    if (event.target === gcashModal) {
                        closeGCashModal();
                    }
                });
            }
        });
    </script>

</body>
</html>