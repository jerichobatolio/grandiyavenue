<!DOCTYPE html>
<html>
<head>
    @include('admin.css')
</head>
<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <h2>Add Food</h2>
                
                @if(session()->has('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif

                @if(session()->has('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ url('upload_food') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group">
                        <label for="title">Food Title</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="detail">Food Description</label>
                        <textarea name="detail" id="detail" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="price">Price (₱) *</label>
                        <input type="number" name="price" id="price" class="form-control" min="0" step="0.01" placeholder="0.00" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category_id">Food Category *</label>
                                <div class="input-group">
                                    <select name="category_id" id="category_id" class="form-control" required onchange="updateSubcategory()">
                                        <option value="">Select Food Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="subcategoryDiv" style="display: none;">
                                <label for="subcategory_id">Subcategory</label>
                                <div class="input-group">
                                    <select name="subcategory_id" id="subcategory_id" class="form-control">
                                        <option value="">Select Subcategory</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="image">Food Image</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Food</button>
                </form>

                <!-- Add Category Modal -->
                <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add New Category</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <form action="{{ url('add_category') }}" method="post">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="category_name">Category Name *</label>
                                        <input type="text" name="name" id="category_name" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="category_emoji">Emoji (Optional)</label>
                                        <input type="text" name="emoji" id="category_emoji" class="form-control" placeholder="🍗">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Add Category</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Add Subcategory Modal -->
                <div class="modal fade" id="addSubcategoryModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add New Subcategory</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <form action="{{ url('add_subcategory') }}" method="post">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="subcategory_category">Parent Category *</label>
                                        <select name="category_id" id="subcategory_category" class="form-control" required>
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="subcategory_name">Subcategory Name *</label>
                                        <input type="text" name="name" id="subcategory_name" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="subcategory_emoji">Emoji (Optional)</label>
                                        <input type="text" name="emoji" id="subcategory_emoji" class="form-control" placeholder="❄️">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success">Add Subcategory</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.js')

    <script>
        function updateSubcategory() {
            const categorySelect = document.getElementById('category_id');
            const subcategoryDiv = document.getElementById('subcategoryDiv');
            const subcategorySelect = document.getElementById('subcategory_id');
            
            // Clear existing options
            subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
            
            const selectedCategoryId = categorySelect.value;
            
            if (selectedCategoryId) {
                // Fetch subcategories for the selected category
                fetch(`/get_subcategories/${selectedCategoryId}`)
                    .then(response => response.json())
                    .then(subcategories => {
                        if (subcategories.length > 0) {
                            subcategoryDiv.style.display = 'block';
                            subcategorySelect.required = false; // Make it optional
                            
                            subcategories.forEach(subcategory => {
                                const optionElement = document.createElement('option');
                                optionElement.value = subcategory.id;
                                optionElement.textContent = subcategory.name;
                                subcategorySelect.appendChild(optionElement);
                            });
                        } else {
                            subcategoryDiv.style.display = 'none';
                            subcategorySelect.required = false;
                            subcategorySelect.value = '';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching subcategories:', error);
                        subcategoryDiv.style.display = 'none';
                        subcategorySelect.required = false;
                        subcategorySelect.value = '';
                    });
            } else {
                subcategoryDiv.style.display = 'none';
                subcategorySelect.required = false;
                subcategorySelect.value = '';
            }
        }

        // Auto-refresh page after modal form submission
        document.addEventListener('DOMContentLoaded', function() {
            // Check if there's a success message and refresh the page after a short delay
            if (document.querySelector('.alert-success')) {
                setTimeout(function() {
                    window.location.reload();
                }, 2000);
            }
        });
    </script>
</body>
</html>
