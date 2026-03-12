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
        }

        .settings-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            margin: 20px;
            padding: 30px;
            min-height: 80vh;
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

        .form-section {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 25px;
            border-left: 4px solid #667eea;
        }

        .form-section h3 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #495057;
            font-size: 0.95rem;
        }

        .form-group input[type="text"],
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-group input[type="text"]:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .form-check-input {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        .form-check-label {
            font-weight: 600;
            color: #495057;
            cursor: pointer;
            margin: 0;
        }

        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            max-width: 300px;
            margin: 0 auto;
            display: block;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .alert {
            border-radius: 10px;
            border: none;
            font-weight: 500;
            padding: 15px 20px;
            margin-bottom: 25px;
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
        }

        .preview-section {
            background: #e9ecef;
            padding: 20px;
            border-radius: 10px;
            margin-top: 25px;
        }

        .preview-section h4 {
            color: #495057;
            margin-bottom: 15px;
        }

        .button-preview {
            display: inline-block;
            padding: 10px 20px;
            background: #667eea;
            color: white;
            border-radius: 5px;
            font-size: 1rem;
            margin-top: 10px;
        }

        .help-text {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .settings-container {
                margin: 10px;
                padding: 15px;
            }

            .page-title {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <div class="settings-container">
                    <h1 class="page-title">
                        <span>🔄 Return/Refund Button Settings</span>
                    </h1>
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            ✅ {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('admin.return_refund_button_settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Enable/Disable Section -->
                        <div class="form-section">
                            <h3>
                                <i class="fa fa-toggle-on"></i>
                                Button Visibility
                            </h3>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_enabled" name="is_enabled" 
                                       {{ $settings->is_enabled ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_enabled">
                                    Show Return/Refund Button
                                </label>
                            </div>
                            <p class="help-text">
                                When enabled, the return/refund button will appear next to the cart icon in the navigation bar.
                            </p>
                        </div>

                        <!-- Button Text Section -->
                        <div class="form-section">
                            <h3>
                                <i class="fa fa-font"></i>
                                Button Text
                            </h3>
                            <div class="form-group">
                                <label for="button_text">Button Text</label>
                                <input type="text" id="button_text" name="button_text" 
                                       value="{{ old('button_text', $settings->button_text) }}" 
                                       placeholder="e.g., Return/Refund" required>
                                <p class="help-text">The text displayed on the button.</p>
                            </div>
                        </div>

                        <!-- Button Icon Section -->
                        <div class="form-section">
                            <h3>
                                <i class="fa fa-image"></i>
                                Button Icon
                            </h3>
                            <div class="form-group">
                                <label for="button_icon">Icon (Emoji or Font Awesome class)</label>
                                <input type="text" id="button_icon" name="button_icon" 
                                       value="{{ old('button_icon', $settings->button_icon) }}" 
                                       placeholder="e.g., 🔄 or fa-undo">
                                <p class="help-text">You can use an emoji (🔄) or leave empty. For Font Awesome icons, use format: fa-undo</p>
                            </div>
                        </div>

                        <!-- Button Link Section -->
                        <div class="form-section">
                            <h3>
                                <i class="fa fa-link"></i>
                                Button Link
                            </h3>
                            <div class="form-group">
                                <label for="button_link">Link URL</label>
                                <input type="text" id="button_link" name="button_link" 
                                       value="{{ old('button_link', $settings->button_link) }}" 
                                       placeholder="e.g., /return-refunds" required>
                                <p class="help-text">The URL where users will be directed when clicking the button.</p>
                            </div>
                        </div>

                        <!-- Description Section -->
                        <div class="form-section">
                            <h3>
                                <i class="fa fa-info-circle"></i>
                                Description
                            </h3>
                            <div class="form-group">
                                <label for="description">Tooltip Description</label>
                                <textarea id="description" name="description" 
                                          placeholder="e.g., Return or refund your orders">{{ old('description', $settings->description) }}</textarea>
                                <p class="help-text">This text will appear as a tooltip when users hover over the button.</p>
                            </div>
                        </div>

                        <!-- Preview Section -->
                        <div class="preview-section">
                            <h4>Preview</h4>
                            <p>How the button will appear:</p>
                            <div class="button-preview" id="preview-button">
                                <span id="preview-icon">{{ $settings->button_icon ?? '🔄' }}</span>
                                <span id="preview-text">{{ $settings->button_text }}</span>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-submit">
                            <i class="fa fa-save"></i> Save Settings
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('admin.js')
    <script>
        // Live preview update
        document.addEventListener('DOMContentLoaded', function() {
            const buttonText = document.getElementById('button_text');
            const buttonIcon = document.getElementById('button_icon');
            const previewText = document.getElementById('preview-text');
            const previewIcon = document.getElementById('preview-icon');

            function updatePreview() {
                previewText.textContent = buttonText.value || 'Return/Refund';
                previewIcon.textContent = buttonIcon.value || '🔄';
            }

            buttonText.addEventListener('input', updatePreview);
            buttonIcon.addEventListener('input', updatePreview);

            // Auto-hide success alert after 5 seconds
            const successAlert = document.querySelector('.alert-success');
            if (successAlert) {
                setTimeout(() => {
                    successAlert.style.transition = 'opacity 0.5s';
                    successAlert.style.opacity = '0';
                    setTimeout(() => successAlert.remove(), 500);
                }, 5000);
            }
        });
    </script>
</body>
</html>
