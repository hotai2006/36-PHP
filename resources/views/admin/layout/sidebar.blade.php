    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Tổng quan</div>
                    @if(auth()->check() && auth()->user()->role_id == 1)
                    <a class="nav-link {{ request()->is('admin') ? 'active' : '' }}" href="/admin">
                        <div class="sb-nav-link-icon"><i class="fas fa-chart-pie"></i></div>
                        Dashboard
                    </a>
                    @else
                    <a class="nav-link {{ request()->is('admin/order*') ? 'active' : '' }}" href="/admin/order">
                        <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                        Trang quản lý đơn hàng
                    </a>
                    @endif

                    <div class="sb-sidenav-menu-heading">Quản lý</div>

                    @if(auth()->check() && auth()->user()->role_id == 1)
                    <a class="nav-link {{ request()->is('admin/user*') || request()->is('admin/users*') ? 'active' : '' }}" href="/admin/user">
                        <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                        Người dùng
                    </a>
                    <a class="nav-link {{ request()->is('admin/product*') || request()->is('admin/products*') ? 'active' : '' }}" href="/admin/product">
                        <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                        Sản phẩm
                    </a>
                    @endif

                    <a class="nav-link {{ request()->is('admin/order*') ? 'active' : '' }}" href="/admin/order">
                        <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                        Đơn hàng
                    </a>
                    
                    @if(auth()->check() && auth()->user()->role_id == 1)
                    <a class="nav-link {{ request()->is('admin/discount*') ? 'active' : '' }}" href="{{ url('/admin/discount') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tags"></i></div>
                        Giảm giá
                    </a>
                    <a class="nav-link {{ request()->is('admin/coupon*') ? 'active' : '' }}" href="{{ url('/admin/coupon') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-ticket-alt"></i></div>
                        Mã giảm giá
                    </a>
                    @endif
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small text-muted">Đang đăng nhập:</div>
                <div class="d-flex align-items-center mt-1">
                    <span class="fw-bold">{{ auth()->check() ? auth()->user()->user_name : 'Admin' }}</span>
                </div>
            </div>
        </nav>
    </div>