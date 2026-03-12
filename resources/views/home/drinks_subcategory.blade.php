<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drinks | Grandiya Venue & Restaurant</title>
    <link rel="icon" href="{{ asset('assets/imgs/logo.png') }}" type="image/png">
    @include('home.css')

    <style>
        body {
            background-color: #1b1b1b;
            color: white;
            font-family: Arial, sans-serif;
        }

        .drinks-container {
            max-width: 800px;
            margin: 100px auto 50px auto;
            padding: 0 20px;
        }

        .drinks-title {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 50px;
            color: white;
        }

        .subcategory-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }

        .subcategory-card {
            background-color: #2c2c2c;
            border: 2px solid skyblue;
            border-radius: 15px;
            padding: 40px;
            text-align: center;
            text-decoration: none;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        }

        .subcategory-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.4);
            border-color: gold;
        }

        .subcategory-icon {
            font-size: 4rem;
            margin-bottom: 20px;
        }

        .cold-icon {
            color: #87CEEB; /* Sky blue */
        }

        .hot-icon {
            color: #FF6347; /* Tomato red */
        }

        .shake-icon {
            color: #FFD700; /* Gold */
        }

        .subcategory-name {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .subcategory-description {
            font-size: 1rem;
            color: #ccc;
            line-height: 1.5;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            color: skyblue;
            text-decoration: none;
            font-size: 1.1rem;
            margin-bottom: 30px;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: gold;
        }

        .back-link::before {
            content: "←";
            margin-right: 8px;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    <div class="drinks-container">
        <a href="{{ route('home') }}#blog" class="back-link">← Back to Grandiya Specialties</a>
        
        <h1 class="drinks-title">Choose Your Drinks</h1>
        
        <div class="subcategory-grid">
            <a href="{{ url('/drinks/Cold') }}" class="subcategory-card">
                <div class="subcategory-name">Cold Drinks</div>
                <div class="subcategory-description">
                    Refreshing cold beverages including sodas, iced teas, smoothies, and chilled drinks perfect for any occasion.
                </div>
            </a>
            
            <a href="{{ url('/drinks/Hot') }}" class="subcategory-card">
                <div class="subcategory-icon hot-icon">☕</div>
                <div class="subcategory-name">Hot Drinks</div>
                <div class="subcategory-description">
                    Warm and comforting beverages including coffee, tea, hot chocolate, and other steaming drinks to warm your soul.
                </div>
            </a>
            
            <a href="{{ url('/drinks/Shake') }}" class="subcategory-card">
                <div class="subcategory-icon shake-icon">🥤</div>
                <div class="subcategory-name">Shakes</div>
                <div class="subcategory-description">
                    Creamy and delicious milkshakes, smoothies, and blended drinks with various flavors to satisfy your sweet cravings.
                </div>
            </a>
        </div>
    </div>
</body>
</html>
