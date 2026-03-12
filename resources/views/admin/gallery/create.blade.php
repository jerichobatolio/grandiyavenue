<!DOCTYPE html>
<html>
<head>
    @include('admin.css')
    
    <style>
        .div_deg {
            padding: 10px;
        }

        label {
            display: inline-block;
            width: 200px;
        }

        .image-preview {
            margin-top: 15px;
            text-align: center;
        }

        .preview-image {
            max-width: 100%;
            max-height: 400px;
            object-fit: contain;
            border: 2px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            background: #f8f9fa;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .preview-container {
            display: none;
            margin-top: 15px;
        }

        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .btn {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            display: inline-block;
        }
    </style>
</head>
<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <h1>Add New Gallery Item</h1>

                <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="div_deg">
                        <label for="image">Image *</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*" required onchange="previewImage(this)">
                        
                        <div class="preview-container" id="previewContainer">
                            <div class="image-preview">
                                <img id="previewImage" class="preview-image" alt="Image Preview">
                            </div>
                        </div>
                    </div>

                    <div class="div_deg">
                        <button type="submit" class="btn btn-primary">Save Gallery Item</button>
                        <a href="{{ route('gallery.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('admin.js')

    <script>
        function previewImage(input) {
            const previewContainer = document.getElementById('previewContainer');
            const previewImage = document.getElementById('previewImage');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.style.display = 'block';
                }
                
                reader.readAsDataURL(input.files[0]);
            } else {
                previewContainer.style.display = 'none';
            }
        }
    </script>
</body>
</html>