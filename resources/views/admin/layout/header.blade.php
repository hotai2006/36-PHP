    <nav class="sb-topnav navbar navbar-expand">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="{{ auth()->check() && auth()->user()->role_id == 2 ? '/admin/order' : '/admin' }}"><i class="fas fa-store me-2"></i>T-Sports Admin</a>
        <!-- Sidebar Toggle (Nằm bên trái) -->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-auto" id="sidebarToggle" href="#!">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Navbar (Nằm sát bên phải) -->
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <span class="d-flex align-items-center justify-content-center rounded-circle bg-white text-danger" style="width: 32px; height: 32px; font-weight: 700; font-size: 0.85rem;">
                        {{ auth()->check() ? substr(auth()->user()->user_name, 0, 1) : 'A' }}
                    </span>
                    <span class="d-none d-md-inline">{{ auth()->check() ? auth()->user()->user_name : 'Admin' }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="/"><i class="fas fa-home me-2"></i>Về trang chủ</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li>
                        <form method="POST" action="/logout">
                            @csrf
                            <button class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>