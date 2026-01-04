<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ config('app.name', 'InvoiceSystem') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Inter', sans-serif; }
        .sidebar { min-height: 100vh; background: #212529; color: white; width: 250px; position: fixed; }
        .sidebar a { color: #adb5bd; text-decoration: none; padding: 12px 20px; display: block; transition: 0.3s; }
        .sidebar a:hover, .sidebar a.active { background: #343a40; color: white; border-left: 4px solid #0d6efd; }
        .main-content { margin-left: 250px; padding: 20px; }
        .card { border: none; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); }
        .navbar { margin-left: 250px; background: white; border-bottom: 1px solid #dee2e6; }
    </style>
    @yield('styles')
</head>
<body>
    <div class="sidebar py-3">
        <h4 class="text-center mb-4">Invoice System</h4>
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
        </a>
        <a href="{{ route('customers.index') }}" class="{{ request()->routeIs('customers.*') ? 'active' : '' }}">
            <i class="fas fa-users me-2"></i> Customers
        </a>
        <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
            <i class="fas fa-box me-2"></i> Products
        </a>
        <a href="{{ route('quotes.index') }}" class="{{ request()->routeIs('quotes.*') ? 'active' : '' }}">
            <i class="fas fa-file-invoice me-2"></i> Quotes
        </a>
        <a href="{{ route('invoices.index') }}" class="{{ request()->routeIs('invoices.*') ? 'active' : '' }}">
            <i class="fas fa-receipt me-2"></i> Invoices
        </a>
        <a href="{{ route('settings.index') }}" class="{{ request()->routeIs('settings.*') ? 'active' : '' }}">
            <i class="fas fa-cog me-2"></i> Settings
        </a>
        <hr>
        <form action="{{ route('logout') }}" method="POST" class="px-3">
            @csrf
            <button type="submit" class="btn btn-outline-light w-100">Logout</button>
        </form>
    </div>

    <nav class="navbar navbar-expand-lg py-3">
        <div class="container-fluid">
            <span class="navbar-text">
                Welcome, <strong>{{ Auth::user()->name ?? 'Admin' }}</strong>
            </span>
        </div>
    </nav>

    <div class="main-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
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

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
