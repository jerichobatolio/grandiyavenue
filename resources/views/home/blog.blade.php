<!-- Food Categories -->
<div id="blog" class="container-fluid bg-dark text-light py-5 text-center wow fadeIn">
    <style>
        #blog .section-title {
            color: white !important;
        }
    </style>
    <h2 class="section-title py-5" style="color: white !important;">Grandiya Specialties</h2>
    <style>
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 24px;
            width: 92%;
            margin: 0 auto 36px auto;
        }

        .category-card {
            display: flex;
            flex-direction: column;
            background-color: #1b1b1b;
            border: 1px solid skyblue;
            border-radius: 10px;
            text-decoration: none;
            color: white;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .category-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.35);
        }

        .category-card img {
            width: 100%;
            max-height: 200px;
            object-fit: contain;
            background: #111;
        }

        .category-name {
            padding: 12px 14px;
            font-weight: 700;
            font-size: 1.05rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>

    <div class="categories-grid">
        @php
            // Hide Party Tray from the home categories listing
            $categories = App\Models\Category::where('is_active', true)
                ->where('name', '!=', 'Party Tray')
                ->get();
        @endphp
        
        @foreach($categories as $category)
            <a href="{{ url('category/'.$category->name) }}" class="category-card">
                @if($category->image)
                    <img src="{{ asset('assets/imgs/'.$category->image) }}" alt="{{ $category->name }}">
                @else
                    <img src="{{ asset('assets/imgs/default.jpg') }}" alt="{{ $category->name }}">
                @endif
                <span class="category-name">
                    {{ strtolower($category->name) === 'bunddle package' ? 'Bundle Package' : $category->name }}
                </span>
            </a>
        @endforeach
    </div>

    <!-- Foods under selected category -->
    @isset($foods)
    @php
        $displayType = isset($type) && strtolower($type) === 'bunddle package' ? 'Bundle Package' : ($type ?? '');
    @endphp
    <h3 class="text-center mb-4 text-white">Foods under {{ $displayType }}</h3>

    <style>
        .foods-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 24px;
            margin-bottom: 56px;
        }

        .food-card {
            background-color: #1b1b1b;
            border: 1px solid skyblue;
            border-radius: 10px;
            width: 300px;
            text-align: center;
            color: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            transition: transform 0.2s;
            padding-bottom: 16px;
        }

        .food-card:hover {
            transform: scale(1.05);
        }

        .food-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .food-card h5 {
            margin: 14px 18px 8px 18px;
            font-size: 1.15rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: #f8f9fa;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            padding-bottom: 6px;
            text-transform: capitalize;
        }

        .food-card p {
            margin: 6px 0;
            font-size: 0.95rem;
        }

        .badge-type {
            display: inline-block;
            padding: 6px 12px;
            background-color: gold;
            color: black;
            border-radius: 6px;
            font-weight: bold;
            margin-bottom: 12px;
        }

        .btn-sm {
            padding: 8px 14px;
            font-size: 0.95rem;
            margin: 2px;
        }

        .quantity-input {
            width: 64px;
            text-align: center;
            border: none;
            background-color: gray;
            color: white;
            font-weight: bold;
            border-radius: 6px;
            margin-bottom: 6px;
            height: 38px;
            font-size: 0.95rem;
        }
    </style>

    <div class="foods-container">
        @forelse($foods as $food)
        <div class="food-card">
            <img src="{{ asset('food_img/'.$food->image) }}" alt="{{ $food->title }}">
            <h5>{{ $food->title }}</h5>
            <span class="badge-type">{{ $food->type }}</span>
            <p>{{ $food->detail }}</p>
            <p><strong>₱{{ $food->price }}</strong></p>

            <form action="{{ url('cart/add/' . $food->id) }}" method="POST">
                @csrf
                <input type="number" name="quantity" value="1" min="1" class="quantity-input">
                <br>
                <button type="submit" class="btn btn-success btn-sm">Add to Cart</button>
            </form>
        </div>
        @empty
        <p class="text-center text-white">No foods added yet in {{ $type }}.</p>
        @endforelse
    </div>
    @endisset
</div>

<script></script>
