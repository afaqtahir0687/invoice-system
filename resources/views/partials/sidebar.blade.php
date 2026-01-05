<aside class="sidebar" id="sidebar">
    <div class="brand">
        <span class="fs-4">InvoiceSystem</span>
    </div>
    
    <nav class="sidebar-nav">
        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
        
        <a href="{{ route('customers.index') }}" class="sidebar-link {{ request()->routeIs('customers.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i>
            <span>Customers</span>
        </a>
        
        <a href="{{ route('products.index') }}" class="sidebar-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
            <i class="fas fa-box"></i>
            <span>Products</span>
        </a>
        
        <a href="{{ route('quotes.index') }}" class="sidebar-link {{ request()->routeIs('quotes.*') ? 'active' : '' }}">
            <i class="fas fa-file-invoice"></i>
            <span>Quotes</span>
        </a>
        
        <a href="{{ route('invoices.index') }}" class="sidebar-link {{ request()->routeIs('invoices.*') ? 'active' : '' }}">
            <i class="fas fa-receipt"></i>
            <span>Invoices</span>
        </a>
        
        <hr class="my-3 text-secondary opacity-25">
        
        <a href="{{ route('settings.index') }}" class="sidebar-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
            <i class="fas fa-cog"></i>
            <span>Settings</span>
        </a>
        
        <div class="mt-auto pt-4 px-3">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger w-100 btn-sm">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </button>
            </form>
        </div>
    </nav>
</aside>
