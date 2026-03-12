<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.css')
    @stack('styles')
</head>
<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>

    @include('admin.js')
    @stack('scripts')
</body>
</html>
