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
    </style>
</head>
<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <h1>Update Gallery Item</h1>

                <form action="{{ route('gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="div_deg">
                        <label for="">Current Image</label>
                        <img width="150" src="{{ asset('storage/'.$gallery->image_path) }}" alt="">
                    </div>

                    <div class="div_deg">
                        <label for="">Change Image</label>
                        <input type="file" name="image">
                    </div>

                    <div class="div_deg">
                        <input class="btn btn-warning" type="submit" value="Update Gallery Item">
                    </div>

                    <div class="div_deg">
                        <form action="{{ route('gallery.destroy', $gallery->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this gallery item?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                🗑️ Delete Gallery Item
                            </button>
                        </form>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('admin.js')
</body>
</html>