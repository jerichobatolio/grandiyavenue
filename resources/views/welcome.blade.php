<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Grandiya Venue And Restaurant — Booking and Reservation System</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/imgs/logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: #333333;
            overflow-x: hidden;
        }


        /* Hero Section */
        .hero {
            height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), 
                        url('{{ asset("assets/imgs/main.jpg") }}') center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            position: relative;
        }

        .hero-content {
            max-width: 800px;
            padding: 0 2rem;
            animation: fadeInUp 1s ease-out;
        }

        .hero h1 {
            font-size: 2.6rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            color: #ffffff !important;
        }

        .hero h2 {
            font-size: 1.8rem;
            font-weight: 500;
            margin-bottom: 2rem;
            color: #ffffff !important;
            opacity: 0.95;
        }

        .hero p {
            font-size: 1.3rem;
            margin-bottom: 2.5rem;
            opacity: 0.9;
            font-weight: 300;
            display: none;
        }

        .hero-buttons {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: #0099CC;
            color: white;
            padding: 1rem 2.5rem;
            border: none;
            border-radius: 30px;
            font-size: 1.1rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 153, 204, 0.3);
        }

        .btn-primary:hover {
            background: #007aa3;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 153, 204, 0.4);
        }

        .btn-secondary {
            background: transparent;
            color: white;
            padding: 1rem 2.5rem;
            border: 2px solid white;
            border-radius: 30px;
            font-size: 1.1rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: white;
            color: #0099CC;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.3);
        }

        /* Content Sections */
        .content-section {
            padding: 4rem 0;
            max-width: 1200px;
            margin: 0 auto;
            padding-left: 2rem;
            padding-right: 2rem;
        }

        .section-title {
            font-size: 2.8rem;
            font-weight: 700;
            color: #0099CC;
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, #0099CC, #007aa3);
            border-radius: 2px;
        }

        .section-content {
            font-size: 1.2rem;
            line-height: 1.8;
            color: #444;
            text-align: center;
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem 0;
        }

        .about-content {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 20px;
            padding: 3rem;
            margin: 2rem 0;
            box-shadow: 0 10px 30px rgba(0, 153, 204, 0.1);
        }

        .about-content h3 {
            color: #0099CC;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .about-content p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #555;
            text-align: justify;
            margin-bottom: 0;
        }

        .guidelines {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 20px;
            padding: 3rem;
            margin-top: 2rem;
            box-shadow: 0 10px 30px rgba(0, 153, 204, 0.1);
            border: 1px solid #e9ecef;
        }

        .guidelines h3 {
            color: #0099CC;
            font-size: 1.8rem;
            margin-bottom: 2rem;
            text-align: center;
            animation: typewriter 2s steps(20) forwards;
            overflow: hidden;
            white-space: nowrap;
            border-right: 2px solid #0099CC;
            width: 0;
        }

        @keyframes typewriter {
            from {
                width: 0;
            }
            to {
                width: 100%;
            }
        }

        .guidelines ul {
            list-style: none;
            text-align: left;
            max-width: 700px;
            margin: 0 auto;
        }

        .guidelines li {
            padding: 1.2rem 0;
            border-bottom: 1px solid #e9ecef;
            position: relative;
            padding-left: 3rem;
            font-size: 1.1rem;
            line-height: 1.6;
            color: #555;
            opacity: 0;
            transform: translateX(-30px);
            transition: all 0.6s ease;
            animation: slideInGuideline 0.8s ease forwards;
        }

        .guidelines li:nth-child(1) { animation-delay: 0.1s; }
        .guidelines li:nth-child(2) { animation-delay: 0.2s; }
        .guidelines li:nth-child(3) { animation-delay: 0.3s; }
        .guidelines li:nth-child(4) { animation-delay: 0.4s; }
        .guidelines li:nth-child(5) { animation-delay: 0.5s; }
        .guidelines li:nth-child(6) { animation-delay: 0.6s; }

        .guidelines li:hover {
            transform: translateX(10px);
            color: #0099CC;
            background: rgba(0, 153, 204, 0.05);
            border-radius: 8px;
            padding-left: 3.5rem;
            transition: all 0.3s ease;
        }

        .guidelines li:last-child {
            border-bottom: none;
        }

        .guidelines li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: #0099CC;
            font-weight: bold;
            font-size: 1.5rem;
            background: #e3f2fd;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            top: 50%;
            transform: translateY(-50%);
            animation: pulseCheckmark 2s ease-in-out infinite;
            animation-delay: calc(var(--item-index) * 0.2s);
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, #0099CC 0%, #007aa3 100%);
            color: white;
            padding: 3rem 0 2rem;
            margin-top: 4rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            text-align: center;
        }

        .footer-logo {
            height: 60px;
            width: auto;
            margin-bottom: 1.5rem;
            background: white;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .footer h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .footer p {
            font-size: 1rem;
            opacity: 0.9;
            margin-bottom: 1.5rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding-top: 1.5rem;
            margin-top: 2rem;
            font-size: 0.9rem;
            opacity: 0.8;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInGuideline {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulseCheckmark {
            0% {
                transform: translateY(-50%) scale(1);
            }
            50% {
                transform: translateY(-50%) scale(1.1);
            }
            100% {
                transform: translateY(-50%) scale(1);
            }
        }

        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1.1rem;
            }

            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn-primary, .btn-secondary {
                width: 100%;
                max-width: 300px;
            }

            .section-title {
                font-size: 2rem;
            }

            .content-section {
                padding: 3rem 1rem;
            }

            .guidelines {
                padding: 2rem;
            }
        }

        @media (max-width: 480px) {
            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .section-title {
                font-size: 1.8rem;
            }
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Loading animation */
        .loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 1;
            transition: opacity 0.5s ease;
        }

        .loading.hidden {
            opacity: 0;
            pointer-events: none;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #0099CC;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Review Section Styles */
        .star-rating-input .star:hover,
        .star-rating-input .star.active {
            color: #ffc107 !important;
            transform: scale(1.2);
        }
        
        .review-card-modern {
            animation: cardFadeIn 0.6s ease-out;
        }
        
        @keyframes cardFadeIn {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        
        .review-card-modern:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 15px 40px rgba(0,0,0,0.4), 0 0 30px rgba(255,215,42,0.2) !important;
            border-color: rgba(255,255,255,0.4) !important;
        }
        
        .rating-badge {
            animation: badgePulse 0.6s ease-out;
            transition: all 0.3s ease;
        }
        
        .rating-badge:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(0,0,0,0.4), 0 0 15px rgba(255,255,255,0.3) !important;
        }
        
        @keyframes badgePulse {
            0% {
                opacity: 0;
                transform: scale(0.5) rotate(-10deg);
            }
            50% {
                transform: scale(1.1) rotate(5deg);
            }
            100% {
                opacity: 1;
                transform: scale(1) rotate(0deg);
            }
        }
        
        .star-rating span {
            transition: all 0.3s ease;
        }
        
        .review-card-modern:hover .star-rating span {
            transform: scale(1.1);
            filter: drop-shadow(0 0 5px rgba(255,215,0,1)) !important;
        }
        
        @keyframes starPulse {
            0%, 100% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.2);
                opacity: 0.8;
            }
        }

        @media (max-width: 768px) {
            .review-card-modern {
                margin-bottom: 25px;
            }
        }
    </style>
</head>
<body>
    <!-- Loading Screen -->
    <div class="loading" id="loading">
        <div class="spinner"></div>
    </div>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Grandiya Venue And Restaurant</h1>
            <h2>Booking and Reservation &amp; System</h2>
            <div class="hero-buttons">
                <a href="{{ route('register') }}" class="btn-primary">Sign Up</a>
                <a href="{{ route('login') }}" class="btn-secondary">Login</a>
            </div>
        </div>
    </section>

    <!-- Overview Section -->
    <section class="content-section">
        <h2 class="section-title fade-in">System Overview</h2>
        <div class="section-content fade-in">
            <p>Experience seamless reservation management with our comprehensive booking platform designed specifically for Grandiya. Our system streamlines the entire process from table reservations to event bookings, ensuring efficiency and customer satisfaction.</p>
        </div>
    </section>

    <!-- About Grandiya Section -->
    <section class="content-section">
        <h2 class="section-title fade-in">About Grandiya</h2>
        <div class="about-content fade-in">
            
            <p>The first cruise-ship inspired restaurant known for its elegant interior design that has become one of the tourist destinations in our region. We aim to provide delicious yet affordable foods that warm the heart and bring family and friends together. Our team upholds integrity and hospitality that guarantees customer satisfaction.</p>
        </div>
    </section>

    <!-- User Guidelines Section -->
    <section class="content-section">
        <h2 class="section-title fade-in">User Guidelines</h2>
        <div class="guidelines fade-in">
            <h3>Important Information</h3>
            <ul>
                <li>Create an account before making any reservations or delivery orders</li>
                <li>Confirm your reservations through system notifications or email</li>
                <li>Follow our payment and cancellation policies as outlined in our terms</li>
                <li>Provide accurate contact details when making reservations</li>
                <li>Respect booking time slots and notify us of any changes in advance</li>
                <li>Keep your account information updated for better service experience</li>
            </ul>
        </div>
    </section>

    <!-- Customer Reviews Section -->
    <section style="background: linear-gradient(135deg, #0099CC 0%, #007aa3 100%); padding: 4rem 0; margin-top: 4rem;">
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
            <h2 class="section-title fade-in" style="color: #ffffff; text-shadow: 0 2px 8px rgba(0,0,0,0.3); margin-bottom: 3rem;">
                <span style="position: relative; z-index: 1; display: inline-block;">⭐ CUSTOMER REVIEWS ⭐</span>
            </h2>

            <!-- Display Approved Reviews -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                @if(isset($reviews) && $reviews->count() > 0)
                    @foreach($reviews as $review)
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
                                1 => 'linear-gradient(135deg, #ff4757 0%, #ee5a6f 100%)',
                                2 => 'linear-gradient(135deg, #ffa502 0%, #ff6348 100%)',
                                3 => 'linear-gradient(135deg, #ffd32a 0%, #ffc107 100%)',
                                4 => 'linear-gradient(135deg, #2ed573 0%, #1e90ff 100%)',
                                5 => 'linear-gradient(135deg, #00d2ff 0%, #3a7bd5 100%)'
                            ];
                            $ratingColor = $ratingColors[$review->rating] ?? 'linear-gradient(135deg, #ffd32a 0%, #ffc107 100%)';
                            $cardGradients = [
                                1 => 'linear-gradient(135deg, rgba(255, 71, 87, 0.15) 0%, rgba(238, 90, 111, 0.08) 100%)',
                                2 => 'linear-gradient(135deg, rgba(255, 165, 2, 0.15) 0%, rgba(255, 99, 72, 0.08) 100%)',
                                3 => 'linear-gradient(135deg, rgba(255, 211, 42, 0.15) 0%, rgba(255, 193, 7, 0.08) 100%)',
                                4 => 'linear-gradient(135deg, rgba(46, 213, 115, 0.15) 0%, rgba(30, 144, 255, 0.08) 100%)',
                                5 => 'linear-gradient(135deg, rgba(0, 210, 255, 0.15) 0%, rgba(58, 123, 213, 0.08) 100%)'
                            ];
                            $cardGradient = $cardGradients[$review->rating] ?? 'linear-gradient(135deg, rgba(255, 211, 42, 0.15) 0%, rgba(255, 193, 7, 0.08) 100%)';
                        @endphp
                        <div class="review-card-modern fade-in" style="background: {{ $cardGradient }}; padding: 30px; border-radius: 20px; border: 2px solid rgba(255,255,255,0.2); transition: all 0.4s ease; box-shadow: 0 8px 25px rgba(0,0,0,0.3), 0 0 20px rgba(255,215,42,0.1); position: relative; overflow: hidden;">
                            <div style="position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); border-radius: 50%;"></div>
                            <div style="margin-bottom: 1rem; display: flex; justify-content: space-between; align-items: center; position: relative; z-index: 1;">
                                <div class="star-rating" style="color: #ffd700; font-size: 1.5rem; letter-spacing: 3px; text-shadow: 0 0 10px rgba(255,215,0,0.5), 0 0 20px rgba(255,215,0,0.3);">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <span style="filter: drop-shadow(0 0 3px rgba(255,215,0,0.8));">★</span>
                                        @else
                                            <span style="color: #555; opacity: 0.5;">☆</span>
                                        @endif
                                    @endfor
                                </div>
                                <span class="rating-badge" style="background: {{ $ratingColor }}; color: white; padding: 8px 16px; border-radius: 25px; font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; box-shadow: 0 4px 15px rgba(0,0,0,0.3), 0 0 10px rgba(255,255,255,0.2); text-shadow: 0 1px 2px rgba(0,0,0,0.3);">
                                    {{ $ratingLabel }}
                                </span>
                            </div>
                            <h3 style="color: #fff; font-size: 1.5rem; font-weight: 800; margin-bottom: 0.5rem; text-shadow: 0 2px 4px rgba(0,0,0,0.3); position: relative; z-index: 1;">{{ $review->customer_name }}</h3>
                            @if($review->customer_email)
                                <h6 style="color: #d4d4d4; font-size: 0.95rem; margin-bottom: 1rem; font-weight: 500; position: relative; z-index: 1;">{{ $review->customer_email }}</h6>
                            @endif
                            <div style="min-height: 80px; position: relative; z-index: 1;">
                                <p style="color: #f0f0f0; line-height: 1.9; font-size: 1.05rem; margin-bottom: 0; text-shadow: 0 1px 2px rgba(0,0,0,0.2);">
                                    @if($review->description)
                                        "{{ $review->description }}"
                                    @else
                                        <em style="color: #aaa;">No description provided.</em>
                                    @endif
                                </p>
                            </div>
                            <div style="margin-top: 1rem; padding-top: 1rem; border-top: 2px solid rgba(255,255,255,0.15); position: relative; z-index: 1;">
                                <div style="color: #ccc; font-size: 0.9rem; display: flex; align-items: center; justify-content: space-between; font-weight: 500;">
                                    <span>{{ $review->created_at->format('M d, Y') }}</span>
                                    <span style="color: #ffd700; font-weight: 700; font-size: 1rem; text-shadow: 0 0 10px rgba(255,215,0,0.5);">{{ $review->rating }}/5 ⭐</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div style="grid-column: 1 / -1; text-align: center;">
                        <div style="background: linear-gradient(135deg, rgba(255,215,42,0.1) 0%, rgba(255,193,7,0.05) 100%); padding: 50px; border-radius: 20px; border: 2px dashed rgba(255,215,42,0.4); box-shadow: 0 0 30px rgba(255,215,42,0.1);">
                            <div style="font-size: 4rem; margin-bottom: 20px; animation: starPulse 2s ease-in-out infinite;">
                                <span style="color: #ffd700; text-shadow: 0 0 20px rgba(255,215,0,0.8);">⭐</span>
                            </div>
                            <p style="color: #ffd700; font-size: 1.4rem; margin: 0; font-weight: 600; text-shadow: 0 0 10px rgba(255,215,0,0.5);">No reviews yet. Be the first to share your experience!</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <img src="{{ asset('assets/imgs/logo.png') }}" alt="Grandiya Logo" class="footer-logo">
            <h3>Grandiya Reservation and Booking System</h3>
            <p>Experience the elegance of cruise-ship inspired dining with seamless online reservations and bookings.</p>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Grandiya. All rights reserved. | Where elegance meets convenience.</p>
            </div>
        </div>
    </footer>

    <script>
        // Loading screen
        window.addEventListener('load', function() {
            setTimeout(function() {
                document.getElementById('loading').classList.add('hidden');
            }, 1000);
        });

        // Scroll animations
        function checkScroll() {
            const elements = document.querySelectorAll('.fade-in');
            elements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                const elementVisible = 150;
                
                if (elementTop < window.innerHeight - elementVisible) {
                    element.classList.add('visible');
                }
            });
        }

        window.addEventListener('scroll', checkScroll);
        checkScroll(); // Check on load

        // Smooth hover effects for buttons
        document.querySelectorAll('.btn-primary, .btn-secondary').forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-3px)';
            });
            
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>
