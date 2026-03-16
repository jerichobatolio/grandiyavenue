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
            max-width: 1100px;
            margin: 96px auto 56px auto;
            padding: 0 20px;
        }

        .subcategories-title {
            text-align: center;
            font-size: 2.4rem;
            margin-bottom: 40px;
            color: white;
        }

        .subcategory-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 28px;
            margin-bottom: 48px;
        }

        .subcategory-card {
            position: relative;
            background: radial-gradient(circle at top left, #1f2937, #020617);
            border-radius: 20px;
            padding: 28px 24px 24px;
            text-align: left;
            text-decoration: none;
            color: white;
            transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease, background 0.18s ease;
            box-shadow: 0 18px 40px rgba(0,0,0,0.75);
            border: 1px solid rgba(56,189,248,0.45);
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .subcategory-card::after {
            content: "→";
            position: absolute;
            right: 20px;
            bottom: 20px;
            font-size: 1.2rem;
            color: rgba(248, 250, 252, 0.75);
            transition: transform 0.18s ease, color 0.18s ease;
        }

        .subcategory-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 24px 52px rgba(0,0,0,0.9);
            border-color: rgba(250,204,21,0.7);
            background: radial-gradient(circle at top left, #334155, #020617);
        }

        .subcategory-card:hover::after {
            transform: translateX(4px);
            color: rgba(250,204,21,0.9);
        }

        .subcategory-icon {
            font-size: 2.8rem;
            margin-bottom: 10px;
        }

        .subcategory-name {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .subcategory-description {
            font-size: 0.98rem;
            color: #e5e7eb;
            line-height: 1.55;
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
