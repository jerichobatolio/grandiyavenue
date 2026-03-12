<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.css')
    <style>
        body {
            background-color: #1b1b1b;
        }
        
        .category-section {
            margin-bottom: 40px;
            background: #2c2c2c;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }
        
        .category-header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #444;
        }
        
        .category-header img {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            margin-right: 15px;
            object-fit: contain;
        }
        
        .category-title {
            color: white;
            font-size: 1.8rem;
            font-weight: 600;
            margin: 0;
        }
        
        .category-count {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-left: auto;
        }
        
        .card {
            background-color: #2c2c2c;
            color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            transition: transform 0.2s;
            border: 1px solid #444;
        }
        
        .card:hover { 
            transform: scale(1.05); 
            box-shadow: 0 6px 15px rgba(0,0,0,0.4);
        }
        
        .card img {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            height: 180px;
            object-fit: contain;
            width: 100%;
            background-color: #1b1b1b;
        }
        
        .card-body { 
            padding: 15px; 
        }
        
        .btn-sm { 
            margin: 2px; 
        }
        
        .badge-subcategory {
            display: inline-block;
            padding: 3px 8px;
            background-color: #667eea;
            color: white;
            border-radius: 12px;
            font-size: 0.8rem;
            margin-bottom: 8px;
        }
        
        .food-title {
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .food-detail {
            color: #ccc;
            font-size: 0.9rem;
            margin-bottom: 10px;
            line-height: 1.4;
        }
        
        .food-price {
            color: #ffd700;
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 15px;
        }
        
        .empty-category {
            text-align: center;
            color: #888;
            font-style: italic;
            padding: 20px;
        }
        
        .page-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .page-title {
            color: white;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .page-subtitle {
            color: #ccc;
            font-size: 1.1rem;
        }
        
        .bundle-info {
            margin-bottom: 10px;
        }
        
        .bundle-info .badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .bundle-price .badge {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .bundle-foods {
            text-align: left;
            margin-top: 8px;
            margin-bottom: 10px;
        }

        .bundle-foods h6 {
            color: #ccc;
            margin: 0 0 4px 0;
            font-size: 0.9rem;
        }

        .bundle-foods ul {
            margin: 0;
            padding-left: 18px;
            color: #ddd;
            font-size: 0.85rem;
        }

        .bundle-foods li {
            margin-bottom: 2px;
        }
    </style>
</head>
<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="container-fluid py-4">
            <div class="page-header">
                <h1 class="page-title">🍽️ Food Menu Management</h1>
                <p class="page-subtitle">View and manage all food items organized by category</p>
            </div>

            @if(session()->has('message'))
                <div class="alert alert-success text-center">{{ session('message') }}</div>
            @endif

            @if($allFoods->isEmpty())
                <div class="text-center text-white">
                    <h3>No foods added yet.</h3>
                    <p>Start by adding your first food item!</p>
                </div>
            @else
                @foreach($categories as $category)
                    @php
                        $categoryFoods = $allFoods->where('category_id', $category->id);
                    @endphp
                    
                    @if($categoryFoods->count() > 0)
                        <div class="category-section">
                            <div class="category-header">
                                @if($category->image)
                                    <img src="{{ asset('assets/imgs/'.$category->image) }}" alt="{{ $category->name }}" style="width: 60px; height: 60px; border-radius: 8px; margin-right: 15px; object-fit: contain;">
                                @endif
                                <div>
                                    <h2 class="category-title">{{ $category->name }}</h2>
                                    @if($category->subtitle)
                                        <p class="text-muted mb-0">{{ $category->subtitle }}</p>
                                    @endif
                                </div>
                                <span class="category-count">{{ $categoryFoods->count() }} items</span>
                            </div>
                            
                            <div class="row">
                                @foreach($categoryFoods as $food)
                                    <div class="col-md-3 mb-4">
                                        <div class="card h-100 text-center">
                                            <img src="{{ asset('food_img/'.$food->image) }}" alt="{{ $food->title }}">
                                            <div class="card-body">
                                                @if(isset($category) && $category->name === 'Party Tray' && $food->bundles->count() > 0)
                                                    @php $bundle = $food->bundles->first(); @endphp
                                                    <div class="bundle-info mb-2">
                                                        <h5 class="food-title mb-1">{{ $bundle->name }}</h5>
                                                        <span class="badge badge-primary">Bundle Package</span>
                                                    </div>

                                                    @if($bundle->description)
                                                        <p class="food-detail">{{ Str::limit($bundle->description, 80) }}</p>
                                                    @endif

                                                    @if($bundle->foods->count() > 0)
                                                        <div class="bundle-foods">
                                                            <h6>Includes:</h6>
                                                            <ul>
                                                                @foreach($bundle->foods as $bundleFood)
                                                                    <li>
                                                                        {{ $bundleFood->title }}
                                                                        @if($bundleFood->pivot->quantity > 1)
                                                                            ({{ $bundleFood->pivot->quantity }}x)
                                                                        @endif
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif

                                                    <div class="bundle-price mt-1 mb-2">
                                                        <span class="badge badge-success">
                                                            Bundle Price: ₱{{ number_format($bundle->bundle_price, 2) }}
                                                        </span>
                                                    </div>
                                                @else
                                                    @if($food->bundles->count() > 0)
                                                        <div class="bundle-info mb-2">
                                                            @php $bundle = $food->bundles->first(); @endphp
                                                            <span class="badge badge-primary">Bundle: {{ $bundle->name }}</span>
                                                            <div class="bundle-price mt-1">
                                                                <span class="badge badge-success">Bundle Price: ₱{{ number_format($bundle->bundle_price, 2) }}</span>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <h5 class="food-title">{{ $food->title }}</h5>

                                                    @if($food->subcategory)
                                                        <span class="badge-subcategory">{{ $food->subcategory }}</span>
                                                    @endif

                                                    @if($food->detail)
                                                        <p class="food-detail">{{ Str::limit($food->detail, 80) }}</p>
                                                    @endif

                                                    @if($food->price > 0)
                                                        <p class="food-price">₱{{ number_format($food->price, 2) }}</p>
                                                    @endif
                                                @endif
                                                
                                                <div class="mt-3">
                                                    <a href="{{ url('update_food', $food->id) }}" class="btn btn-primary btn-sm">
                                                        ✏️ Edit
                                                    </a>
                                                    <a href="{{ url('delete_food', $food->id) }}" class="btn btn-danger btn-sm" 
                                                       onclick="return confirm('Are you sure to delete this food item?')">
                                                        🗑️ Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>

    @include('admin.js')
</body>
</html>
