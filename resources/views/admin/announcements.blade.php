<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('admin.css')
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .announcements-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            margin-left: 300px;
            margin-right: 20px;
            margin-top: 90px;
            margin-bottom: 20px;
            padding: 30px;
            min-height: calc(100vh - 130px);
            max-height: calc(100vh - 130px);
            width: calc(100% - 320px);
            box-sizing: border-box;
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* Image container for better display */
        .announcement-image-container {
            text-align: center;
            margin: 20px 0;
            padding: 10px;
            background: white;
            border-radius: 8px;
        }

        .page-title {
            color: #2c3e50;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
            background: linear-gradient(45deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .form-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
            border: 2px dashed #667eea;
            overflow: visible;
            max-height: none;
        }

        .form-card h5 {
            color: #667eea;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .announcement-item {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 4px solid #667eea;
            transition: all 0.3s ease;
            position: relative;
            overflow: visible;
            width: 100%;
            box-sizing: border-box;
        }

        .announcement-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .announcement-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
            flex-wrap: wrap;
            gap: 15px;
        }


        .announcement-image {
            max-width: 100%;
            max-height: 400px;
            width: auto;
            height: auto;
            border-radius: 8px;
            object-fit: contain;
            margin: 15px 0;
            display: block;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .announcement-content {
            color: #495057;
            line-height: 1.8;
            margin: 15px 0;
            font-size: 1rem;
            white-space: pre-wrap;
            word-wrap: break-word;
            padding: 15px;
            background: white;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }

        .announcement-meta {
            display: flex;
            gap: 20px;
            margin-top: 15px;
            font-size: 0.9rem;
            color: #6c757d;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-active {
            background: #28a745;
            color: white;
        }

        .status-inactive {
            background: #6c757d;
            color: white;
        }

        .status-pending {
            background: #ffc107;
            color: #000;
        }

        .status-approved {
            background: #28a745;
            color: white;
        }

        .status-rejected {
            background: #dc3545;
            color: white;
        }

        .btn-approve {
            background: #28a745;
            color: white;
        }

        .btn-approve:hover {
            background: #218838;
            transform: translateY(-2px);
        }

        .btn-reject {
            background: #dc3545;
            color: white;
        }

        .btn-reject:hover {
            background: #c82333;
            transform: translateY(-2px);
        }

        .btn-action {
            margin: 5px;
            padding: 8px 15px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .btn-edit {
            background: #667eea;
            color: white;
        }

        .btn-edit:hover {
            background: #5568d3;
            transform: translateY(-2px);
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background: #c82333;
            transform: translateY(-2px);
        }

        .btn-create {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            margin-bottom: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-create:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .edit-form {
            display: none;
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-top: 20px;
            border: 2px solid #667eea;
            overflow: visible;
            width: 100%;
            box-sizing: border-box;
        }

        .edit-form.active {
            display: block;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .image-preview {
            max-width: 200px;
            max-height: 150px;
            width: auto;
            height: auto;
            border-radius: 8px;
            margin-top: 10px;
            object-fit: cover;
            display: block;
            clear: both;
        }

        .form-group {
            clear: both;
            overflow: visible;
        }

        .form-group input[type="file"] {
            margin-bottom: 10px;
        }

        /* Ensure image previews don't break layout */
        .form-group img.image-preview {
            max-width: 200px;
            max-height: 150px;
            width: auto;
            height: auto;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        /* Keep announcements list scrollable */
        .announcements-list {
            overflow: visible;
            position: relative;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }
    </style>
</head>
<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="announcements-container">
        <h1 class="page-title">📢 Announcement Management</h1>

        @if(session()->has('message'))
            <div class="alert alert-success">
                <i class="fa fa-check-circle"></i> {{ session('message') }}
            </div>
        @endif

        @if(session()->has('error'))
            <div class="alert alert-danger">
                <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <!-- Create Announcement Form -->
        <div class="form-card">
            <h5><i class="fa fa-plus-circle"></i> Create New Announcement</h5>
            <form action="{{ route('admin.announcements.store') }}" method="POST" enctype="multipart/form-data" id="createForm">
                @csrf
                <div class="form-group">
                    <label for="content">Content *</label>
                    <textarea name="content" id="content" class="form-control" required placeholder="Enter announcement content"></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" style="position: relative;">
                            <label for="image">Image (Optional)</label>
                            <input type="file" name="image" id="image" class="form-control" accept="image/*" onchange="previewImage(this, 'createPreview')">
                            <div style="margin-top: 10px;">
                                <img id="createPreview" class="image-preview" style="display: none; max-width: 200px; max-height: 150px;">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- All announcements are active by default -->
                    </div>
                </div>
                <button type="submit" class="btn-create">
                    <i class="fa fa-save"></i> Create Announcement
                </button>
            </form>
        </div>

        <!-- Announcements List -->
        <div class="announcements-list">
            @if($announcements->count() > 0)
                @foreach($announcements as $announcement)
                    <div class="announcement-item">
                        <div class="announcement-header">
                            <div style="flex: 1;">
                                <span class="status-badge status-{{ $announcement->status ?? 'pending' }}" style="margin-left: 10px;">
                                    {{ ucfirst($announcement->status ?? 'pending') }}
                                </span>
                            </div>
                            <div style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
                                @if($announcement->status == 'pending')
                                    <button type="button" class="btn-action btn-approve" onclick="approveAnnouncement({{ $announcement->id }})">
                                        <i class="fa fa-check"></i> Approve
                                    </button>
                                    <button type="button" class="btn-action btn-reject" onclick="rejectAnnouncement({{ $announcement->id }})">
                                        <i class="fa fa-times"></i> Reject
                                    </button>
                                @endif
                                <button type="button" class="btn-action btn-edit" onclick="toggleEditForm({{ $announcement->id }})">
                                    <i class="fa fa-edit"></i> Edit
                                </button>
                                <button type="button" class="btn-action btn-delete" onclick="deleteAnnouncement({{ $announcement->id }})">
                                    <i class="fa fa-trash"></i> Delete
                                </button>
                            </div>
                        </div>

                        <div class="announcement-content">
                            {!! nl2br(e($announcement->content)) !!}
                        </div>

                        @if($announcement->image)
                            <div class="announcement-image-container">
                                <img src="{{ asset('assets/imgs/' . $announcement->image) }}" alt="Announcement Image" class="announcement-image">
                            </div>
                        @endif

                        <div class="announcement-meta">
                            <span><i class="fa fa-calendar"></i> Created: {{ $announcement->created_at->format('M d, Y h:i A') }}</span>
                        </div>

                        <!-- Edit Form -->
                        <div class="edit-form" id="editForm{{ $announcement->id }}">
                            <h5><i class="fa fa-edit"></i> Edit Announcement</h5>
                            <form action="{{ route('admin.announcements.update', $announcement->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="edit_content{{ $announcement->id }}">Content *</label>
                                    <textarea name="content" id="edit_content{{ $announcement->id }}" class="form-control" required>{{ $announcement->content }}</textarea>
                                </div>
                                @if($announcement->image)
                                    <div class="form-group">
                                        <label>Current Image</label>
                                        <div style="text-align: center; margin: 15px 0; padding: 15px; background: #f8f9fa; border-radius: 8px;">
                                            <img src="{{ asset('assets/imgs/' . $announcement->image) }}" alt="Current Image" id="currentImage{{ $announcement->id }}" style="max-width: 100%; max-height: 400px; width: auto; height: auto; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                        </div>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group" style="position: relative;">
                                            <label for="edit_image{{ $announcement->id }}">Change Image (Optional)</label>
                                            <input type="file" name="image" id="edit_image{{ $announcement->id }}" class="form-control" accept="image/*" onchange="previewImage(this, 'editPreview{{ $announcement->id }}')">
                                            <div style="margin-top: 10px; text-align: center;">
                                                <img id="editPreview{{ $announcement->id }}" class="image-preview" style="display: none; max-width: 100%; max-height: 400px; width: auto; height: auto; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6"></div>
                                </div>
                                <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 20px;">
                                    <button type="submit" class="btn-create">
                                        <i class="fa fa-save"></i> Update Announcement
                                    </button>
                                    <button type="button" class="btn-action btn-delete" onclick="toggleEditForm({{ $announcement->id }})">
                                        <i class="fa fa-times"></i> Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <i class="fa fa-bullhorn"></i>
                    <h3>No Announcements Yet</h3>
                    <p>Create your first announcement using the form above.</p>
                </div>
            @endif
        </div>
    </div>

    @include('admin.js')

    <script>
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    // Hide current image if editing and show new preview
                    const announcementId = previewId.replace('editPreview', '');
                    const currentImage = document.getElementById('currentImage' + announcementId);
                    if (currentImage && currentImage.closest('.form-group')) {
                        currentImage.closest('.form-group').style.display = 'none';
                    }
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                // If file input is cleared, show current image again
                const announcementId = previewId.replace('editPreview', '');
                const currentImage = document.getElementById('currentImage' + announcementId);
                if (currentImage && currentImage.closest('.form-group')) {
                    currentImage.closest('.form-group').style.display = 'block';
                }
                preview.style.display = 'none';
            }
        }

        function toggleEditForm(id) {
            const form = document.getElementById('editForm' + id);
            form.classList.toggle('active');
        }

        function deleteAnnouncement(id) {
            if (confirm('Are you sure you want to delete this announcement? This action cannot be undone.')) {
                window.location.href = '{{ route("admin.announcements.delete", ":id") }}'.replace(':id', id);
            }
        }

        function approveAnnouncement(id) {
            if (confirm('Are you sure you want to approve this announcement? It will be visible on the home page.')) {
                window.location.href = '{{ route("admin.announcements.approve", ":id") }}'.replace(':id', id);
            }
        }

        function rejectAnnouncement(id) {
            if (confirm('Are you sure you want to reject this announcement? It will not be visible on the home page.')) {
                window.location.href = '{{ route("admin.announcements.reject", ":id") }}'.replace(':id', id);
            }
        }
    </script>
</body>
</html>
