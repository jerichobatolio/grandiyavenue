<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $type }} | Grandiya Venue & Restaurant</title>
    <link rel="icon" href="{{ asset('assets/imgs/logo.png') }}" type="image/png">
    @include('home.css')

    <style>
        body {
            background-color: #1b1b1b;
            color: white;
            font-family: Arial, sans-serif;
        }

        .subcategories-container {
            max-width: 1000px;
            margin: 100px auto 50px auto;
            padding: 0 20px;
        }

        .subcategories-title {
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

        .no-subcategories {
            text-align: center;
            color: #ccc;
            font-size: 1.2rem;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="subcategories-container">
        <a href="{{ route('home') }}#blog" class="back-link">← Back to Grandiya Specialties</a>
        
        <h1 class="subcategories-title">Choose {{ $type }} Subcategory</h1>
        
        @if($subcategories->count() > 0)
            <div class="subcategory-grid">
                @foreach($subcategories as $subcategory)
                    <a href="{{ url('/category/' . $type . '/subcategory/' . $subcategory->name) }}" class="subcategory-card">
                        @php
                            $subcategoryNameLower = strtolower($subcategory->name);
                            $shouldHideEmoji = in_array($subcategoryNameLower, ['cold', 'alcohol beverages', 'alcohol beverage', 'alcohol', 'beverages', 'beverage']) ||
                                               str_contains($subcategoryNameLower, 'alcohol') ||
                                               str_contains($subcategoryNameLower, 'beverage');
                        @endphp
                        @if(!$shouldHideEmoji)
                            <div class="subcategory-icon">
                                @if($subcategory->emoji)
                                    {{ $subcategory->emoji }}
                                @else
                                    🍽️
                                @endif
                            </div>
                        @endif
                        <div class="subcategory-name">{{ $subcategory->name }}</div>
                        <div class="subcategory-description">
                            Browse {{ $subcategory->name }} items in {{ $type }} category.
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="no-subcategories">
                <p>No subcategories available for {{ $type }}.</p>
                <a href="{{ url('/category/' . $type) }}" class="back-link">View all {{ $type }} items</a>
            </div>
        @endif
    </div>
</body>
</html>
