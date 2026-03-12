<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('admin.css')
    <style>
        body {
            background: #ffffff;
            color: #000000;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .pax-container {
            max-width: 900px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 15px;
            padding: 25px 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }
        .pax-header {
            text-align: center;
            margin-bottom: 25px;
        }
        .pax-header h1 {
            font-size: 2rem;
            margin-bottom: 5px;
        }
        .pax-header p {
            color: #666;
            margin: 0;
        }
        .pax-form {
            margin-bottom: 25px;
            padding: 15px 20px;
            border-radius: 10px;
            background: #f8f9fa;
            border: 1px solid #e2e6ea;
        }
        .pax-form .row {
            margin-bottom: 10px;
        }
        /* Light table layout for Pax options (white background, black text) */
        .pax-container .table {
            background-color: #ffffff;
            color: #000000;
        }

        .pax-container .table thead {
            background-color: #f1f1f1;
            color: #000000;
        }

        .pax-container .table th,
        .pax-container .table td {
            border-color: #dddddd;
            color: #000000;
        }

        .pax-container .table input.form-control-sm {
            background-color: #ffffff;
            color: #000000;
            border-color: #cccccc;
        }

        .pax-container .table input.form-control-sm::placeholder {
            color: #777777;
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
    <div class="container-fluid">
        <div class="pax-container">
            <div class="pax-header">
                <h1>👥 Pax Options Management</h1>
                <p>Manage predefined guest counts (pax) used in the event booking form.</p>
            </div>

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

            <!-- Create Pax Option (Pax value + pricing) -->
            <div class="pax-form">
                <form action="{{ route('admin.pax.store') }}" method="POST">
                    @csrf
                    <div class="row align-items-end">
                        <div class="col-md-4 mb-2">
                            <label for="value" class="form-label">Pax *</label>
                            <input type="number" min="1" class="form-control" id="value" name="value" required placeholder="e.g. 50" value="{{ old('value') }}">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="down_payment" class="form-label">Down Payment (₱) *</label>
                            <input type="number" min="0" step="0.01" class="form-control" id="down_payment" name="down_payment" required placeholder="e.g. 2000" value="{{ old('down_payment', 0) }}">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="full_price" class="form-label">Full Payment (₱) *</label>
                            <input type="number" min="0" step="0.01" class="form-control" id="full_price" name="full_price" required placeholder="e.g. 4000" value="{{ old('full_price', 0) }}">
                        </div>
                    </div>
                    <div class="text-end mt-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i> Add Pax Option
                        </button>
                    </div>
                </form>
            </div>

            <!-- Existing Pax Options -->
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                    <tr>
                        <th style="width: 20%;">Pax</th>
                        <th style="width: 25%;">Down Payment (₱)</th>
                        <th style="width: 25%;">Full Payment (₱)</th>
                        <th style="width: 30%;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($paxOptions as $pax)
                        <tr>
                            <td>
                                <input type="number" name="value" form="pax-update-{{ $pax->id }}" class="form-control form-control-sm" value="{{ $pax->value }}" min="1" required>
                            </td>
                            <td>
                                <input type="number" name="down_payment" form="pax-update-{{ $pax->id }}" class="form-control form-control-sm" value="{{ $pax->down_payment }}" min="0" step="0.01" required>
                            </td>
                            <td>
                                <input type="number" name="full_price" form="pax-update-{{ $pax->id }}" class="form-control form-control-sm" value="{{ $pax->full_price }}" min="0" step="0.01" required>
                            </td>
                            <td>
                                <form id="pax-update-{{ $pax->id }}" action="{{ route('admin.pax.update', $pax->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-save"></i> Save
                                    </button>
                                </form>
                                <form action="{{ route('admin.pax.delete', $pax->id) }}" method="POST" class="d-inline ms-2" onsubmit="return confirm('Delete this pax option?');">
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
                            <td colspan="4" class="text-center text-muted">
                                No pax options configured yet. Add your first option above.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

@include('admin.js')
</body>
</html>


