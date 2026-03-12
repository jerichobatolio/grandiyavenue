<!DOCTYPE html>
<html>
<head>
    @include('admin.css')
    
    <style>
        .gallary {
            margin-top: 20px;
        }
        .gallary-item {
            position: relative;
            margin-bottom: 20px;
        }
        .gallary-img {
            width: 100%;
            height: auto;
            max-height: none;
            border-radius: 4px;
            transition: transform 0.3s ease;
            display: block;
            max-width: 100%;
            border: 1px solid #ddd;
            object-fit: contain;
        }
        .gallary-img:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        .gallery-actions {
            position: absolute;
            top: 10px;
            right: 10px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .gallary-item:hover .gallery-actions {
            opacity: 1;
        }
        .btn-sm {
            padding: 8px 15px;
            font-size: 12px;
            margin: 3px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        .btn-warning {
            background-color: #ffc107;
            color: #212529;
            border: 1px solid #ffc107;
        }
        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        .btn-danger {
            background-color: #dc3545;
            color: white;
            border: 1px solid #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
            border: 1px solid #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        .btn:active {
            transform: translateY(0);
            box-shadow: 0 1px 2px rgba(0,0,0,0.2);
        }
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        .gallery-actions {
            transition: all 0.3s ease;
        }
        .gallery-actions:hover {
            transform: scale(1.02);
        }
        .no-gallery-items {
            text-align: center;
            padding: 50px 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            margin-top: 20px;
        }
        .no-gallery-items h3 {
            color: #333;
            margin-bottom: 10px;
        }
        .no-gallery-items p {
            color: #666;
            margin-bottom: 20px;
        }
        .btn {
            padding: 6px 12px;
            margin: 2px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        .btn-warning {
            background-color: #ffc107;
            color: #212529;
        }
        .btn-danger {
            background-color: #dc3545;
            color: white;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
        }
        .badge-success {
            background-color: #28a745;
            color: white;
        }
        .badge-danger {
            background-color: #dc3545;
            color: white;
        }
        .page-header {
            padding: 20px;
        }
        .header-actions {
            margin-bottom: 20px;
        }
        
        /* Image Modal/Lightbox Styles */
        .image-modal {
            display: none;
            position: fixed;
            z-index: 10000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            overflow: auto;
            animation: fadeIn 0.3s;
        }
        
        .image-modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .image-modal-content {
            position: relative;
            max-width: 90%;
            max-height: 90vh;
            margin: auto;
            animation: zoomIn 0.3s;
        }
        
        .image-modal-content img {
            width: 100%;
            height: auto;
            max-height: 90vh;
            object-fit: contain;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
        }
        
        .image-modal-close {
            position: absolute;
            top: -40px;
            right: 0;
            color: #fff;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s;
            z-index: 10001;
        }
        
        .image-modal-close:hover {
            color: #ffc107;
        }
        
        .image-modal-title {
            position: absolute;
            bottom: -40px;
            left: 0;
            color: #fff;
            font-size: 18px;
            text-align: center;
            width: 100%;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes zoomIn {
            from { transform: scale(0.8); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        
        .gallary-img {
            cursor: pointer;
        }
        
        .view-full-btn {
            background-color: #17a2b8;
            color: white;
            border: 1px solid #17a2b8;
        }
        
        .view-full-btn:hover {
            background-color: #138496;
            border-color: #117a8b;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <h2>Gallery Management</h2>
                
                <div class="header-actions">
                    <a href="{{ route('gallery.create') }}" class="btn btn-primary">
                        ➕ Add New Gallery Item
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($galleries->count() > 0)
                    <div class="gallary row">
                        @foreach($galleries as $gallery)
                            <div class="col-sm-6 col-lg-3 gallary-item" style="margin-bottom: 20px; padding: 10px;">
                                <div style="background: #f8f9fa; padding: 10px; border-radius: 8px; border: 1px solid #ddd; display: flex; align-items: center; justify-content: center; min-height: 200px;">
                                    <img src="{{ asset('storage/' . $gallery->image_path) }}" 
                                         alt="{{ $gallery->title ?? 'Gallery Image' }}" 
                                         class="gallary-img"
                                         style="width: 100%; height: auto; object-fit: contain; border-radius: 4px; display: block;"
                                         onclick="openImageModal('{{ asset('storage/' . $gallery->image_path) }}', '{{ $gallery->title ?? 'Gallery Image' }}')">
                                </div>
                                <div class="gallery-actions" style="margin-top: 15px; text-align: center;">
                                    <div style="display: flex; gap: 8px; justify-content: center; flex-wrap: wrap;">
                                        <a href="{{ route('gallery.edit', $gallery->id) }}" 
                                           class="btn btn-warning btn-sm"
                                           style="min-width: 80px;">
                                            ✏️ Edit
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="no-gallery-items">
                        <h3>No Gallery Items Found</h3>
                        <p>Click "Add New Gallery Item" to start adding images to your gallery.</p>
                        <a href="{{ route('gallery.create') }}" class="btn btn-primary">
                            ➕ Add Your First Gallery Item
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Image Modal/Lightbox -->
    <div id="imageModal" class="image-modal" onclick="closeImageModal()">
        <div class="image-modal-content" onclick="event.stopPropagation()">
            <span class="image-modal-close" onclick="closeImageModal()">&times;</span>
            <img id="modalImage" src="" alt="">
            <div class="image-modal-title" id="modalTitle"></div>
        </div>
    </div>

    <script>
        function openImageModal(imageSrc, imageTitle) {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            const modalTitle = document.getElementById('modalTitle');
            
            modalImg.src = imageSrc;
            modalTitle.textContent = imageTitle;
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        
        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';
        }
        
        // Close modal on Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeImageModal();
            }
        });
        
        // Close modal when clicking outside the image
        document.getElementById('imageModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeImageModal();
            }
        });
    </script>

    @include('admin.js')
</body>
</html>