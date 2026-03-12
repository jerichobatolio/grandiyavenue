<!DOCTYPE html>
<html>
<head>
    @include('admin.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            background: #f5f6fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .page-header {
            padding: 20px 0;
        }
        .card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            padding: 20px;
        }
        .card h2 {
            margin-bottom: 15px;
        }
        .form-inline-row {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }
        .form-inline-row .form-control {
            min-width: 220px;
        }
        .table thead {
            background-color: #343a40;
            color: #fff;
        }
        .btn-sm {
            padding: 5px 10px;
            font-size: 0.85rem;
        }
        .input-group {
            display: flex;
            gap: 5px;
        }
        .input-group .form-control {
            flex: 1;
        }
        .input-group .btn {
            white-space: nowrap;
        }
    </style>
</head>
<body>
@include('admin.header')
@include('admin.sidebar')

<div class="page-content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="card">
                <h2>Food Package Management</h2>
                <p class="text-muted mb-3">
                    Manage simple food package items used for events (e.g. <strong>Chicken</strong>, <strong>Vegetable</strong>, <strong>Unlimited plain rice</strong>).
                </p>

                @if(session('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Add new item -->
                <form action="{{ route('admin.food_packages.store') }}" method="POST" class="mb-3">
                    @csrf
                    <div class="form-inline-row">
                        <div class="form-group mb-2">
                            <label for="name" class="sr-only">Food Item</label>
                            <input type="text" name="name" id="name" class="form-control"
                                   placeholder="e.g. Chicken, Vegetable, Unlimited plain rice" required>
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">
                            <i class="fas fa-plus"></i> Add Item
                        </button>
                    </div>
                </form>

                <!-- Existing items -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead>
                        <tr>
                            <th style="width: 60%;">Food Item</th>
                            <th style="width: 40%;">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($items as $item)
                            <tr>
                                <td>
                                    <form action="{{ route('admin.food_packages.update', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <div class="input-group">
                                            <input type="text" name="name" class="form-control form-control-sm"
                                                   value="{{ $item->name }}" required>
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fas fa-save"></i> Save
                                            </button>
                                        </div>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route('admin.food_packages.delete', $item->id) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Delete this food package item?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted">
                                    No food package items yet. Add items like "Chicken", "Vegetable", "Unlimited plain rice".
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <p class="text-muted small mt-2">
                    These items are just labels; no prices or quantities are stored here.
                </p>
            </div>
        </div>
    </div>
</div>

@include('admin.js')
</body>
</html>


