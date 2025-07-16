<nav id="sidebar" class="bg-dark">
    <div class="p-4">
        <h1><a href="/" class="logo">Inventori</a></h1>
        <ul class="list-unstyled components mb-5">
            <li class="{{ request()->is('/') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
            </li>
            <li class="{{ request()->is('products*') ? 'active' : '' }}">
                <a href="{{ route('products.index') }}"><i class="fas fa-box me-2"></i> Produk</a>
            </li>
            <li class="{{ request()->is('categories*') ? 'active' : '' }}">
                <a href="{{ route('categories.index') }}"><i class="fas fa-tags me-2"></i> Kategori</a>
            </li>
            <li class="{{ request()->is('orders*') ? 'active' : '' }}">
                <a href="{{ route('orders.index') }}"><i class="fas fa-shopping-cart me-2"></i> Pesanan</a>
            </li>
            <li class="{{ request()->is('reports*') ? 'active' : '' }}">
                <a href="#reportsSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fas fa-chart-bar me-2"></i> Laporan
                </a>
                <ul class="collapse list-unstyled {{ request()->is('reports*') ? 'show' : '' }}" id="reportsSubmenu">
                    <li>
                        <a href="{{ route('reports.sales') }}">Penjualan</a>
                    </li>
                    <li>
                        <a href="{{ route('reports.inventory') }}">Inventori</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</nav>
