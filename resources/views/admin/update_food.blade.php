<!DOCTYPE html>
<html>
<head>
    <base href="/public">
    @include('admin.css')
    
    <style>
        .update-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .form-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px 10px 0 0;
            margin: -20px -20px 30px -20px;
            text-align: center;
        }
        
        .form-section {
            background: white;
            padding: 25px;
            margin-bottom: 20px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        
        .section-title {
            color: #333;
            font-size: 1.2em;
            font-weight: 600;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        
        .section-title::before {
            content: "📝";
            margin-right: 8px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .form-input, .form-textarea, .form-select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e5e9;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #fff;
        }
        
        .form-input:focus, .form-textarea:focus, .form-select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        .image-preview {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-top: 10px;
        }
        
        .current-image {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #e1e5e9;
        }
        
        .image-info {
            color: #666;
            font-size: 13px;
        }
        
        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 10px;
        }
        
        .category-option {
            display: flex;
            align-items: center;
            padding: 10px;
            border: 2px solid #e1e5e9;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #fff;
        }
        
        .category-option:hover {
            border-color: #667eea;
            background: #f8f9ff;
        }
        
        .category-option input[type="radio"] {
            margin-right: 10px;
        }
        
        .category-option.selected {
            border-color: #667eea;
            background: #f0f4ff;
        }
        
        .subcategory-section {
            margin-top: 15px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 6px;
            border: 1px solid #e1e5e9;
        }
        
        .btn-update {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }
        
        .alert {
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <div class="update-container">
                    <div class="form-header">
                        <h1>🍽️ Update Food Item</h1>
                        <p>Modify food details and categorization</p>
                    </div>

                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            ✅ {{ session('message') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-error">
                            @foreach($errors->all() as $error)
                                ❌ {{ $error }}<br>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{url('edit_food',$food->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information Section -->
                        <div class="form-section">
                            <div class="section-title">Basic Information</div>
                            
                            <div class="form-group">
                                <label class="form-label" for="title">Food Title *</label>
                                <input type="text" name="title" id="title" class="form-input" 
                                       value="{{ old('title', $food->title) }}" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="detail">Food Description (Optional)</label>
                                <textarea name="detail" id="detail" class="form-textarea">{{ old('detail', $food->detail) }}</textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="price">Price *</label>
                                <input type="text" name="price" id="price" class="form-input" 
                                       value="{{ old('price', $food->price) }}" required>
                            </div>
                        </div>

                        <!-- Category Selection Section -->
                        <div class="form-section">
                            <div class="section-title">Food Category</div>
                            
                            <div class="category-grid">
                                @php
                                    $existingCategories = \App\Models\Category::orderBy('name')->get();
                                @endphp

                                @forelse($existingCategories as $category)
                                    @php $label = $category->name; @endphp
                                    <label class="category-option {{ $food->type == $label ? 'selected' : '' }}">
                                        <input type="radio"
                                               name="type"
                                               value="{{ $label }}"
                                               {{ $food->type == $label ? 'checked' : '' }}
                                               onchange="updateCategorySelection(this)">
                                        <span>{{ $label }}</span>
                                    </label>
                                @empty
                                    <p class="text-muted">No categories available. Please add categories first.</p>
                                @endforelse
                            </div>

                            <!-- Subcategory Section -->
                            <div class="subcategory-section" id="subcategoryDiv" 
                                 style="display: {{ $food->type == 'Drinks' ? 'block' : 'none' }};">
                                <label class="form-label" for="subcategory">Drink Type</label>
                                <select name="subcategory" id="subcategory" class="form-select">
                                    <option value="">Select Drink Type</option>
                                    <option value="Cold" {{ $food->subcategory == 'Cold' ? 'selected' : '' }}>❄️ Cold</option>
                                    <option value="Hot" {{ $food->subcategory == 'Hot' ? 'selected' : '' }}>☕ Hot</option>
                                    <option value="Shake" {{ $food->subcategory == 'Shake' ? 'selected' : '' }}>🥤 Shake</option>
                                </select>
                            </div>
                        </div>

                        <!-- Image Section -->
                        <div class="form-section">
                            <div class="section-title">Food Image</div>
                            
                            <div class="image-preview">
                                <img src="{{ asset('food_img/'.$food->image) }}" alt="Current food image" class="current-image">
                                <div class="image-info">
                                    <strong>Current Image:</strong><br>
                                    {{ $food->image }}<br>
                                    <small>Upload a new image to replace this one</small>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="image">Change Image</label>
                                <input type="file" name="image" id="image" class="form-input" accept="image/*">
                                <small style="color: #666;">Recommended: 400x400px, JPG/PNG format</small>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <button type="submit" class="btn-update">
                                💾 Update Food Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('admin.js')

    <script>
        function updateCategorySelection(radio) {
            // Remove selected class from all options
            document.querySelectorAll('.category-option').forEach(option => {
                option.classList.remove('selected');
            });
            
            // Add selected class to clicked option
            radio.closest('.category-option').classList.add('selected');
            
            // Handle subcategory visibility
            const subcategoryDiv = document.getElementById('subcategoryDiv');
            const subcategorySelect = document.getElementById('subcategory');
            
            if (radio.value === 'Drinks') {
                subcategoryDiv.style.display = 'block';
                subcategorySelect.required = true;
            } else {
                subcategoryDiv.style.display = 'none';
                subcategorySelect.required = false;
                subcategorySelect.value = '';
            }
        }

        // Image preview functionality
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('.current-image').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const title = document.getElementById('title').value.trim();
            const price = document.getElementById('price').value.trim();
            const type = document.querySelector('input[name="type"]:checked');
            
            if (!title || !price || !type) {
                e.preventDefault();
                alert('Please fill in all required fields and select a category.');
                return false;
            }
        });
    </script>
</body>
</html>