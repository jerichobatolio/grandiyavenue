<!DOCTYPE html>
<html>
<head>
    @include('admin.css')
    <title>Bundle Management</title>
</head>
<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <h2>Bundle Management</h2>
                
                @if(session()->has('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif

                @if(session()->has('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <!-- Add Bundle Button -->
                <div class="mb-3">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addBundleModal">
                        <i class="fas fa-plus"></i> Add New Bundle
                    </button>
                </div>

                <!-- Bundles Table -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Subcategory</th>
                                <th>Bundle Price</th>
                                <th>Food Names</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bundles as $bundle)
                                <tr>
                                    <td>
                                        @if($bundle->image)
                                            <img src="{{ asset('food_img/' . $bundle->image) }}" alt="{{ $bundle->name }}" style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $bundle->name }}</td>
                                    <td>{{ $bundle->category->name }}</td>
                                    <td>{{ $bundle->subcategory ? $bundle->subcategory->name : 'N/A' }}</td>
                                    <td>₱{{ number_format($bundle->bundle_price, 2) }}</td>
                                    <td>
                                        @if($bundle->foods->count() > 0)
                                            @foreach($bundle->foods as $food)
                                                <span class="badge badge-info mr-1 mb-1">{{ $food->title }}</span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">No foods added</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#manageFoodsModal{{ $bundle->id }}" title="Manage Foods">
                                                <i class="fas fa-utensils"></i> Foods
                                            </button>
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editBundleModal{{ $bundle->id }}" title="Edit Bundle">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <a href="{{ url('delete_bundle/' . $bundle->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this bundle?')" title="Delete Bundle">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            <strong>No bundles found!</strong><br>
                                            Click "Add New Bundle" to create your first bundle.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Bundle Modal -->
    <div class="modal fade" id="addBundleModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Bundle</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="{{ url('create_bundle') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bundle_name">Bundle Name *</label>
                                    <input type="text" name="name" id="bundle_name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bundle_price">Bundle Price (₱) *</label>
                                    <input type="number" name="bundle_price" id="bundle_price" class="form-control" min="0" step="0.01" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="bundle_description">Description</label>
                            <textarea name="description" id="bundle_description" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bundle_category">Category *</label>
                                    <select name="category_id" id="bundle_category" class="form-control" required onchange="updateBundleSubcategory()">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="bundleSubcategoryDiv" style="display: none;">
                                    <label for="bundle_subcategory">Subcategory</label>
                                    <select name="subcategory_id" id="bundle_subcategory" class="form-control">
                                        <option value="">Select Subcategory</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="bundle_image">Bundle Image</label>
                            <input type="file" name="image" id="bundle_image" class="form-control" accept="image/*">
                        </div>

                        <div class="form-group">
                            <label>Bundle Foods</label>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                <strong>Note:</strong> Add food titles that will be visible individually on the public home page. 
                                You can add existing foods or create new food titles for this bundle.
                            </div>
                            
                            <!-- Food Type Selection -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label>Add Food Type:</label>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-primary active" id="existingFoodBtn">
                                            <i class="fas fa-list"></i> Existing Food
                                        </button>
                                        <button type="button" class="btn btn-outline-success" id="newFoodBtn">
                                            <i class="fas fa-plus"></i> New Food Title
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Existing Foods Section -->
                            <div id="existingFoodsSection">
                                <div id="foodsContainer">
                                    <div class="food-item mb-2">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <select name="food_ids[]" class="form-control food-select">
                                                    <option value="">Select Food (Optional)</option>
                                                    @foreach($foods as $food)
                                                        <option value="{{ $food->id }}" data-price="{{ $food->price }}">
                                                            {{ $food->title }} - ₱{{ number_format($food->price, 2) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="number" name="quantities[]" class="form-control" min="1" value="1" placeholder="Qty">
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-danger btn-sm remove-food" style="display: none;">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success btn-sm" id="addFoodBtn">
                                    <i class="fas fa-plus"></i> Add Existing Food
                                </button>
                            </div>

                            <!-- New Food Titles Section -->
                            <div id="newFoodsSection" style="display: none;">
                                <div id="newFoodsContainer">
                                    <div class="new-food-item mb-3 p-3 border rounded">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label>Food Title *</label>
                                                    <input type="text" name="new_food_titles[]" class="form-control" placeholder="Enter food title...">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                    <button type="button" class="btn btn-danger btn-sm remove-new-food" style="display: none;">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <textarea name="new_food_descriptions[]" class="form-control" rows="2" placeholder="Optional description..."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Food Image</label>
                                                    <input type="file" name="new_food_images[]" class="form-control" accept="image/*">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success btn-sm" id="addNewFoodBtn">
                                    <i class="fas fa-plus"></i> Add New Food Title
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Bundle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Manage Foods Modal for each bundle -->
    @foreach($bundles as $bundle)
    <div class="modal fade" id="manageFoodsModal{{ $bundle->id }}" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Manage Foods - {{ $bundle->name }}</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Current Foods in Bundle -->
                    <div class="mb-4">
                        <h6>Current Foods in Bundle:</h6>
                        @if($bundle->foods->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Food</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bundle->foods as $food)
                                        <tr id="food-row-{{ $bundle->id }}-{{ $food->id }}">
                                            <td>{{ $food->title }}</td>
                                            <td>
                                                <form action="{{ url('update_food_quantity_in_bundle/' . $bundle->id . '/' . $food->id) }}" method="post" class="d-inline update-quantity-form">
                                                    @csrf
                                                    <div class="input-group input-group-sm" style="width: 120px;">
                                                        <input type="number" name="quantity" class="form-control quantity-input" value="{{ $food->pivot->quantity }}" min="1" style="width: 60px;">
                                                        <div class="input-group-append">
                                                            <button type="submit" class="btn btn-success btn-sm" title="Update Quantity">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </td>
                                            <td>₱{{ number_format($food->price, 2) }}</td>
                                            <td>
                                                <a href="{{ url('remove_food_from_bundle/' . $bundle->id . '/' . $food->id) }}" 
                                                   class="btn btn-sm btn-danger" 
                                                   onclick="return confirm('Remove {{ $food->title }} from bundle?')"
                                                   title="Remove Food">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">No foods added to this bundle yet.</p>
                        @endif
                    </div>

                    <!-- Add New Food to Bundle -->
                    <div>
                        <h6>Add Food to Bundle:</h6>
                        <form action="{{ url('add_food_to_bundle/' . $bundle->id) }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Food Name *</label>
                                        <input type="text" name="food_name" class="form-control" placeholder="Type food name..." required>
                                        <small class="form-text text-muted">Type the name of the food item</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Quantity *</label>
                                        <input type="number" name="quantity" class="form-control" min="1" value="1" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="btn btn-success btn-block">
                                            <i class="fas fa-plus"></i> Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label>Description (Optional)</label>
                                        <textarea name="food_description" class="form-control" rows="2" placeholder="Optional food description..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Edit Bundle Modal for each bundle -->
    @foreach($bundles as $bundle)
    <div class="modal fade" id="editBundleModal{{ $bundle->id }}" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Bundle - {{ $bundle->name }}</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="{{ url('update_bundle/' . $bundle->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_bundle_name{{ $bundle->id }}">Bundle Name *</label>
                                    <input type="text" name="name" id="edit_bundle_name{{ $bundle->id }}" class="form-control" value="{{ $bundle->name }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_bundle_price{{ $bundle->id }}">Bundle Price (₱) *</label>
                                    <input type="number" name="bundle_price" id="edit_bundle_price{{ $bundle->id }}" class="form-control" min="0" step="0.01" value="{{ $bundle->bundle_price }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_bundle_description{{ $bundle->id }}">Description</label>
                            <textarea name="description" id="edit_bundle_description{{ $bundle->id }}" class="form-control" rows="3">{{ $bundle->description }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_bundle_category{{ $bundle->id }}">Category *</label>
                                    <select name="category_id" id="edit_bundle_category{{ $bundle->id }}" class="form-control" required onchange="updateEditBundleSubcategory({{ $bundle->id }})">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ $bundle->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="editBundleSubcategoryDiv{{ $bundle->id }}" style="display: {{ $bundle->subcategory_id ? 'block' : 'none' }};">
                                    <label for="edit_bundle_subcategory{{ $bundle->id }}">Subcategory</label>
                                    <select name="subcategory_id" id="edit_bundle_subcategory{{ $bundle->id }}" class="form-control">
                                        <option value="">Select Subcategory</option>
                                        @if($bundle->subcategory_id)
                                            @foreach($subcategories->where('category_id', $bundle->category_id) as $subcategory)
                                                <option value="{{ $subcategory->id }}" {{ $bundle->subcategory_id == $subcategory->id ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_bundle_image{{ $bundle->id }}">Bundle Image</label>
                            @if($bundle->image)
                                <div class="mb-2">
                                    <img src="{{ asset('food_img/' . $bundle->image) }}" alt="{{ $bundle->name }}" style="width: 100px; height: 100px; object-fit: cover; border: 1px solid #ddd; border-radius: 4px;">
                                    <p class="text-muted small mt-1">Current image</p>
                                </div>
                            @endif
                            <input type="file" name="image" id="edit_bundle_image{{ $bundle->id }}" class="form-control" accept="image/*">
                            <small class="form-text text-muted">Leave empty to keep current image</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Bundle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    @include('admin.js')

    <script>
        function updateBundleSubcategory() {
            const categorySelect = document.getElementById('bundle_category');
            const subcategoryDiv = document.getElementById('bundleSubcategoryDiv');
            const subcategorySelect = document.getElementById('bundle_subcategory');
            
            subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
            
            const selectedCategoryId = categorySelect.value;
            
            if (selectedCategoryId) {
                fetch(`/get_subcategories/${selectedCategoryId}`)
                    .then(response => response.json())
                    .then(subcategories => {
                        if (subcategories.length > 0) {
                            subcategoryDiv.style.display = 'block';
                            
                            subcategories.forEach(subcategory => {
                                const optionElement = document.createElement('option');
                                optionElement.value = subcategory.id;
                                optionElement.textContent = subcategory.name;
                                subcategorySelect.appendChild(optionElement);
                            });
                        } else {
                            subcategoryDiv.style.display = 'none';
                            subcategorySelect.value = '';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching subcategories:', error);
                        subcategoryDiv.style.display = 'none';
                        subcategorySelect.value = '';
                    });
            } else {
                subcategoryDiv.style.display = 'none';
                subcategorySelect.value = '';
            }
        }

        function updateEditBundleSubcategory(bundleId) {
            const categorySelect = document.getElementById('edit_bundle_category' + bundleId);
            const subcategoryDiv = document.getElementById('editBundleSubcategoryDiv' + bundleId);
            const subcategorySelect = document.getElementById('edit_bundle_subcategory' + bundleId);
            
            subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
            
            const selectedCategoryId = categorySelect.value;
            
            if (selectedCategoryId) {
                fetch(`/get_subcategories/${selectedCategoryId}`)
                    .then(response => response.json())
                    .then(subcategories => {
                        if (subcategories.length > 0) {
                            subcategoryDiv.style.display = 'block';
                            
                            subcategories.forEach(subcategory => {
                                const optionElement = document.createElement('option');
                                optionElement.value = subcategory.id;
                                optionElement.textContent = subcategory.name;
                                subcategorySelect.appendChild(optionElement);
                            });
                        } else {
                            subcategoryDiv.style.display = 'none';
                            subcategorySelect.value = '';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching subcategories:', error);
                        subcategoryDiv.style.display = 'none';
                        subcategorySelect.value = '';
                    });
            } else {
                subcategoryDiv.style.display = 'none';
                subcategorySelect.value = '';
            }
        }

        // Add/Remove food items dynamically
        document.getElementById('addFoodBtn').addEventListener('click', function() {
            const container = document.getElementById('foodsContainer');
            const foodItem = container.querySelector('.food-item').cloneNode(true);
            
            // Clear the selected value
            foodItem.querySelector('.food-select').value = '';
            foodItem.querySelector('input[name="quantities[]"]').value = '1';
            
            // Show remove button
            foodItem.querySelector('.remove-food').style.display = 'block';
            
            container.appendChild(foodItem);
        });

        // Remove food item
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-food')) {
                e.target.closest('.food-item').remove();
            }
        });

        // Initialize bundle creation functionality
        document.addEventListener('DOMContentLoaded', function() {
            initializeBundleCreation();
        });

        function initializeBundleCreation() {
            const existingFoodBtn = document.getElementById('existingFoodBtn');
            const newFoodBtn = document.getElementById('newFoodBtn');
            const existingFoodsSection = document.getElementById('existingFoodsSection');
            const newFoodsSection = document.getElementById('newFoodsSection');
            const addFoodBtn = document.getElementById('addFoodBtn');
            const addNewFoodBtn = document.getElementById('addNewFoodBtn');

            // Food type toggle functionality
            if (existingFoodBtn && newFoodBtn) {
                existingFoodBtn.addEventListener('click', function() {
                    this.classList.add('active');
                    newFoodBtn.classList.remove('active');
                    existingFoodsSection.style.display = 'block';
                    newFoodsSection.style.display = 'none';
                });

                newFoodBtn.addEventListener('click', function() {
                    this.classList.add('active');
                    existingFoodBtn.classList.remove('active');
                    existingFoodsSection.style.display = 'none';
                    newFoodsSection.style.display = 'block';
                });
            }

            // Add existing food functionality
            if (addFoodBtn) {
                addFoodBtn.addEventListener('click', function() {
                    const container = document.getElementById('foodsContainer');
                    const foodItem = container.querySelector('.food-item').cloneNode(true);
                    
                    // Clear the selected value
                    foodItem.querySelector('.food-select').value = '';
                    foodItem.querySelector('input[name="quantities[]"]').value = '1';
                    
                    // Show remove button
                    foodItem.querySelector('.remove-food').style.display = 'block';
                    
                    container.appendChild(foodItem);
                });
            }

            // Add new food title functionality
            if (addNewFoodBtn) {
                addNewFoodBtn.addEventListener('click', function() {
                    const container = document.getElementById('newFoodsContainer');
                    const newFoodItem = container.querySelector('.new-food-item').cloneNode(true);
                    
                    // Clear all inputs
                    newFoodItem.querySelector('input[name="new_food_titles[]"]').value = '';
                    newFoodItem.querySelector('textarea[name="new_food_descriptions[]"]').value = '';
                    newFoodItem.querySelector('input[name="new_food_images[]"]').value = '';
                    
                    // Show remove button
                    newFoodItem.querySelector('.remove-new-food').style.display = 'block';
                    
                    container.appendChild(newFoodItem);
                });
            }

            // Remove food item functionality
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-food')) {
                    const foodItems = document.querySelectorAll('.food-item');
                    if (foodItems.length > 1) {
                        e.target.closest('.food-item').remove();
                    }
                }
                
                if (e.target.classList.contains('remove-new-food')) {
                    const newFoodItems = document.querySelectorAll('.new-food-item');
                    if (newFoodItems.length > 1) {
                        e.target.closest('.new-food-item').remove();
                    }
                }
            });

            // Show remove buttons for multiple items on page load
            const foodItems = document.querySelectorAll('.food-item');
            if (foodItems.length > 1) {
                foodItems.forEach(item => {
                    item.querySelector('.remove-food').style.display = 'block';
                });
            }

            const newFoodItems = document.querySelectorAll('.new-food-item');
            if (newFoodItems.length > 1) {
                newFoodItems.forEach(item => {
                    item.querySelector('.remove-new-food').style.display = 'block';
                });
            }
        }

        // Handle quantity update forms with AJAX for better UX
        document.addEventListener('submit', function(e) {
            if (e.target.classList.contains('update-quantity-form')) {
                e.preventDefault();
                
                const form = e.target;
                const formData = new FormData(form);
                const actionUrl = form.action;
                const submitButton = form.querySelector('button[type="submit"]');
                const originalHtml = submitButton.innerHTML;
                
                // Disable button and show loading
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                
                fetch(actionUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalHtml;
                    
                    if (data.success) {
                        // Show success message
                        const modalBody = form.closest('.modal-body');
                        let alertDiv = modalBody.querySelector('.quantity-update-alert');
                        if (!alertDiv) {
                            alertDiv = document.createElement('div');
                            alertDiv.className = 'alert alert-success alert-dismissible fade show quantity-update-alert';
                            modalBody.insertBefore(alertDiv, modalBody.firstChild);
                        }
                        alertDiv.innerHTML = '<strong>Success!</strong> ' + data.message + 
                            '<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>';
                        
                        // Auto-dismiss after 3 seconds
                        setTimeout(() => {
                            if (alertDiv && alertDiv.parentNode) {
                                alertDiv.remove();
                            }
                        }, 3000);
                    } else {
                        alert('Error: ' + (data.message || 'Failed to update quantity'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalHtml;
                    // Fallback to form submission if AJAX fails
                    form.submit();
                });
            }
        });
    </script>
</body>
</html>
