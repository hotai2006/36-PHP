<body>
    <!-- Navbar start -->
    <div class="container-fluid fixed-top px-0" style="z-index: 1050; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04); border-bottom: 1px solid rgba(0, 0, 0, 0.06); background: #fff;">
        <div class="w-100 topbar bg-primary d-none d-lg-block" style="padding: 4px 0; font-size: 12px;">
            <div class="container">
                <div class="d-flex justify-content-between">
                    <div class="top-info ps-2">
                        <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-white"></i> <a href="#"
                                class="text-white text-decoration-none">280 Đ. An Dương Vương</a></small>
                    </div>
                    <div class="top-link pe-2">
                        <a href="#" class="text-white text-decoration-none"><small class="text-white mx-2">Chính sách bảo mật</small></a>/
                        <a href="#" class="text-white text-decoration-none"><small class="text-white mx-2">Điều khoản sử dụng</small></a>/
                        <a href="#" class="text-white text-decoration-none"><small class="text-white ms-2">Bán hàng và hoàn tiền</small></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <nav class="navbar navbar-light bg-white navbar-expand-xl d-flex align-items-center justify-content-between"
                style="padding: 0.1rem 0.5rem; min-height: 42px;">

                <a href="/" class="navbar-brand">
                    <h1 class="text-primary display-6">T-Sports</h1>
                </a>

                <!-- Action controls (always visible on top right) -->
                <div class="d-flex align-items-center ms-auto me-2 me-xl-0 order-2 order-xl-3">
                    @if(auth()->check())
                    <!-- Cart Dropdown -->
                    <div class="dropdown my-auto dropdown-hover me-3 me-md-4">
                        <a href="/cart" class="position-relative" role="button" id="cartDropdown"
                            aria-expanded="false">
                            <i class="fas fa-shopping-cart fa-2x"></i>
                            @if(session('cart_sum', 0) > 0)
                            <span id="cart-badge"
                                class="position-absolute bg-danger rounded-circle d-flex align-items-center justify-content-center text-white px-1"
                                style="top: 13px; right: -13px; height: 20px; min-width: 20px; font-size: 12px;">
                                {{ session('cart_sum') }}
                            </span>
                            @else
                            <span id="cart-badge"
                                class="position-absolute bg-danger rounded-circle d-flex align-items-center justify-content-center text-white px-1"
                                style="display: none; top: 13px; right: -13px; height: 20px; min-width: 20px; font-size: 12px;">0</span>
                            @endif
                        </a>
                    </div>

                    <!-- User Settings Dropdown -->
                    <div class="dropdown my-auto dropdown-hover">
                        <a href="#" class="position-relative me-2 me-md-4 my-auto" role="button" id="dropdownMenuLink"
                            aria-expanded="false" data-bs-toggle="dropdown">
                            <i class="fas fa-user fa-2x"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end p-4" aria-labelledby="dropdownMenuLink" style="z-index: 1060;">
                            <li class="d-flex align-items-center flex-column" style="min-width: 260px; max-width: 300px;">
                                <img loading="lazy" style="width: 120px; height: 120px; border-radius: 50%; overflow: hidden; display: flex;
            justify-content: center; align-items: center; object-fit: cover;"
                                    src="{{ asset('storage/avatars/' . auth()->user()->user_avatar) }}" />
                                <div class="text-center my-3 fw-bold">
                                    {{ auth()->user()->user_name }}
                                </div>
                            </li>
                            <li><a class="dropdown-item" href="/user-profile"><i class="fas fa-user-cog me-2"></i>Quản lý tài khoản</a></li>
                            <li><a class="dropdown-item" href="/order-history"><i class="fas fa-history me-2"></i>Lịch sử mua hàng</a></li>
                            <li><a class="dropdown-item" href="/favorites"><i class="fas fa-heart me-2"></i>Sản phẩm yêu thích</a></li>
                            @if(auth()->check() && auth()->user()->role_id == 1)
                            <li><a class="dropdown-item" href="/admin"><i class="fas fa-user-shield me-2"></i>Trang admin</a></li>
                            @endif
                            @if(auth()->check() && auth()->user()->role_id == 2)
                            <li><a class="dropdown-item" href="/admin/order"><i class="fas fa-shipping-fast me-2"></i>Khu vực Shipper</a></li>
                            @endif
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="/logout">
                                    @csrf
                                    <button class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    @else
                    <!-- Login Button -->
                    <a href="/login" class="btn btn-primary rounded-pill text-white my-auto d-inline-flex align-items-center justify-content-center gap-2 a-login" style="background: linear-gradient(135deg, #ec4d4c 0%, #b83534 100%); border: none; font-weight: 600; font-size: 13px; transition: all 0.3s; box-shadow: 0 4px 12px rgba(217, 65, 64, 0.25); padding: 6px 14px; height: 34px; line-height: 1;">
                        <i class="fas fa-sign-in-alt" style="font-size: 13px; line-height: 1;"></i>
                        <span style="line-height: 1;">Đăng nhập</span>
                    </a>
                    @endif
                </div>

                <!-- Collapse menu toggler -->
                <button class="navbar-toggler py-2 px-3 order-3 ms-2 ms-md-0 d-xl-none" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="fa fa-bars text-primary"></span>
                </button>

                <!-- Navigation menu collapse links -->
                <div class="collapse navbar-collapse bg-white order-4 order-xl-2" id="navbarCollapse">
                    <div class="navbar-nav mx-auto text-center py-2 py-xl-0">
                        <a href="/" class="nav-item nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a>
                        <a href="/product" class="nav-item nav-link {{ request()->is('product*') ? 'active' : '' }}">Shop</a>
                    </div>
                </div>

            </nav>
        </div>
    </div>
    <!-- Navbar End -->
</body>