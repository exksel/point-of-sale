<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading"></div>
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="bi bi-house"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Master</div>
                <a class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}" href="{{ route('products.index') }}">
                    <div class="sb-nav-link-icon"><i class="bi bi-box"></i></div>
                    Products
                </a>
                <div class="sb-sidenav-menu-heading">Transaction</div>
                <a class="nav-link {{ request()->routeIs('transactions.cashier') ? 'active' : '' }}" href="{{ route('transactions.cashier') }}">
                    <div class="sb-nav-link-icon"><i class="bi bi-bag"></i></div>
                    Cashier
                </a>
                <a class="nav-link {{ request()->routeIs('transactions.history') ? 'active' : '' }}" href="{{ route('transactions.history') }}">
                    <div class="sb-nav-link-icon"><i class="bi bi-clock-history"></i></div>
                    History
                </a>
                <div class="sb-sidenav-menu-heading">Outcomes</div>
                <a class="nav-link {{ request()->routeIs('outcomes.list') ? 'active' : '' }}" href="{{ route('outcomes.list') }}">
                    <div class="sb-nav-link-icon"><i class="bi bi-cart-dash"></i></div>
                    Expense
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as :</div>
            <strong>{{ Auth::user()->username ?? 'Guest' }}</strong>
        </div>        
    </nav>
</div>