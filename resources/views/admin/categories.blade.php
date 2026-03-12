<!DOCTYPE html>
<html>
<head>
    @include('admin.css')
    <style>
        .category-item {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            background-color: #f9f9f9;
            margin-bottom: 20px;
        }

        .subcategory-item {
            display: inline-block;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .edit-form {
            display: none;
        }

        .edit-form.active {
            display: block;
        }

        .category-image-preview {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <h2>Category Management</h2>
                
                @if(session()->has('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif

                @if(session()->has('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <!-- Add Category Form -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Add New Category</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('add_category') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="name">Category Name *</label>
                                        <input type="text" name="name" id="name" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="subtitle">Subtitle (Optional)</label>
                                        <input type="text" name="subtitle" id="subtitle" class="form-control" placeholder="Brief description">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="image">Category Image</label>
                                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="btn btn-primary btn-block">Add Category</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Categories List -->
                <div class="card">
                    <div class="card-header">
                        <h5>Categories & Subcategories</h5>
                    </div>
                    <div class="card-body">
                        @if($categories->count() > 0)
                            @foreach($categories as $category)
                                <div class="category-item mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="d-flex align-items-center">
                                            @if($category->image)
                                                <img src="{{ asset('assets/imgs/'.$category->image) }}" alt="{{ $category->name }}" class="category-image-preview mr-3">
                                            @endif
                                            <div>
                                                <h6 class="mb-0">{{ $category->name }}</h6>
                                                @if($category->subtitle)
                                                    <small class="text-muted">{{ $category->subtitle }}</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            <button class="btn btn-sm btn-info" onclick="toggleEdit({{ $category->id }})">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addSubcategoryModal{{ $category->id }}">
                                                <i class="fas fa-plus"></i> Add Subcategory
                                            </button>
                                            <a href="{{ url('delete_category/' . $category->id) }}" class="btn btn-sm btn-danger" 
                                               onclick="return confirm('Are you sure you want to delete this category? This will also delete all its subcategories and foods!')">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <!-- Edit Form -->
                                    <div class="edit-form" id="editForm{{ $category->id }}">
                                        <form action="{{ url('update_category/'.$category->id) }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Category Name *</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Subtitle</label>
                                                        <input type="text" name="subtitle" class="form-control" value="{{ $category->subtitle }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Change Image</label>
                                                        <input type="file" name="image" class="form-control" accept="image/*">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>&nbsp;</label>
                                                        <button type="submit" class="btn btn-success btn-block">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    
                                    @if($category->subcategories->count() > 0)
                                        <div class="subcategories ml-3 mt-3">
                                            <h6 class="text-muted">Subcategories:</h6>
                                            <div class="row">
                                                @foreach($category->subcategories as $subcategory)
                                                    <div class="col-md-4 mb-2">
                                                        <div class="d-flex justify-content-between align-items-center bg-light p-2 rounded">
                                                            <span id="subcatName{{ $subcategory->id }}">{{ $subcategory->name }}</span>
                                                            <div>
                                                                <button class="btn btn-sm btn-outline-primary" onclick="toggleSubcatEdit({{ $subcategory->id }})">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                                <a href="{{ url('delete_subcategory/' . $subcategory->id) }}" 
                                                                   class="btn btn-sm btn-outline-danger" 
                                                                   onclick="return confirm('Are you sure you want to delete this subcategory?')">
                                                                    <i class="fas fa-times"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <!-- Subcategory Edit Form -->
                                                        <div class="edit-form mt-2" id="editSubcatForm{{ $subcategory->id }}">
                                                            <form action="{{ url('update_subcategory/'.$subcategory->id) }}" method="post">
                                                                @csrf
                                                                <div class="d-flex">
                                                                    <input type="text" name="name" class="form-control form-control-sm mr-2" value="{{ $subcategory->name }}" required>
                                                                    <button type="submit" class="btn btn-sm btn-success">Update</button>
                                                                    <button type="button" class="btn btn-sm btn-secondary" onclick="toggleSubcatEdit({{ $subcategory->id }})">Cancel</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <p class="text-muted ml-3">No subcategories yet.</p>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">No categories found. Add your first category above!</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.js')

    <!-- Add Subcategory Modals for each category -->
    @foreach($categories as $category)
        <div class="modal fade" id="addSubcategoryModal{{ $category->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Subcategory to {{ $category->name }}</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('add_subcategory') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="category_id" value="{{ $category->id }}">
                            <div class="form-group">
                                <label for="subcategory_name{{ $category->id }}">Subcategory Name *</label>
                                <input type="text" name="name" id="subcategory_name{{ $category->id }}" class="form-control" required>
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
    @endforeach

    <script>
        function toggleEdit(categoryId) {
            const editForm = document.getElementById('editForm' + categoryId);
            editForm.classList.toggle('active');
        }

        function toggleSubcatEdit(subcategoryId) {
            const editForm = document.getElementById('editSubcatForm' + subcategoryId);
            editForm.classList.toggle('active');
        }

        // Auto-refresh page after form submission
        document.addEventListener('DOMContentLoaded', function() {
            if (document.querySelector('.alert-success')) {
                setTimeout(function() {
                    window.location.reload();
                }, 2000);
            }
        });
    </script>
</body>
</html>
