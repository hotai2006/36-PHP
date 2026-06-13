<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>T-Sports</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">


    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const infoCard  = document.getElementById("infoCard");
        const editCard  = document.getElementById("editCard");
        const openBtns  = document.querySelectorAll("#openbuttonUpdatedform");
        const closeBtns = document.querySelectorAll("#closebuttonUpdatedform, #closebuttonUpdatedform2");

        function showEdit() {
            infoCard.style.display = "none";
            editCard.style.display = "block";
            editCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        function showInfo() {
            editCard.style.display = "none";
            infoCard.style.display = "block";
        }

        openBtns.forEach(btn => btn.addEventListener("click", showEdit));
        closeBtns.forEach(btn => btn.addEventListener("click", showInfo));

        // Avatar preview khi chọn ảnh mới
        const avatarFile        = document.getElementById("avatarFile");
        const avatarPreview     = document.getElementById("avatarPreview");
        const avatarPreviewWrap = document.getElementById("avatarPreviewWrap");

        if (avatarFile) {
            avatarFile.addEventListener("change", function(e) {
                if (e.target.files && e.target.files[0]) {
                    const imgURL = URL.createObjectURL(e.target.files[0]);
                    avatarPreview.src = imgURL;
                    avatarPreviewWrap.style.display = "block";
                }
            });
        }
    });
    </script>


</head>

<body>

    <!-- Spinner Start -->
    <div id="spinner"
        class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->


    @extends('client.layout.header')





    <!-- Profile Page -->
    <div style="background: #f4f6f9; min-height: calc(100vh - 102px);" class="py-5 client-content-container">
        <div class="container">

            {{-- Alerts --}}
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert"
                style="border-radius: 12px; background: #d1fae5; color: #065f46; font-weight: 500;">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert"
                style="border-radius: 12px; background: #fee2e2; color: #991b1b; font-weight: 500;">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            {{-- Breadcrumb --}}
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb" style="font-size: 13px;">
                    <li class="breadcrumb-item"><a href="/" class="text-decoration-none text-primary">Home</a></li>
                    <li class="breadcrumb-item active text-muted">Quản lý tài khoản</li>
                </ol>
            </nav>

            <div class="row g-4">

                {{-- LEFT COLUMN: Avatar Card --}}
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm text-center" style="border-radius: 20px; overflow: hidden;">
                        {{-- Header strip --}}
                        <div style="height: 80px; background: linear-gradient(135deg, #cb463f, #cb463f);"></div>
                        <div class="card-body pt-0 pb-4 px-4">
                            {{-- Avatar --}}
                            <div style="margin-top: -50px;" class="mb-3">
                                <img loading="lazy"
                                    src="{{ asset('storage/avatars/' . $user->user_avatar) }}"
                                    alt="avatar"
                                    class="rounded-circle border border-4 border-white shadow"
                                    style="width: 100px; height: 100px; object-fit: cover;">
                            </div>
                            <div style="margin-top: 30px;">
                                 <h5 class="fw-bold mb-0" style="font-size: 18px;">{{ $user->user_name ?? 'Chưa cập nhật' }}</h5>
                                 <p class="text-muted small mb-3">{{ $user->user_email ?? '' }}</p>
                            </div>
                            {{-- Info badges --}}
                            <div class="d-flex flex-column gap-2 text-start px-2">
                                <div class="d-flex align-items-center gap-2 py-2 px-3 rounded-3" style="background: #f8f9fa;">
                                    <i class="fas fa-phone text-primary" style="width: 18px;"></i>
                                    <span class="small text-muted">{{ $user->user_phone ?? 'Chưa cập nhật' }}</span>
                                </div>
                                <div class="d-flex align-items-center gap-2 py-2 px-3 rounded-3" style="background: #f8f9fa;">
                                    <i class="fas fa-map-marker-alt text-primary" style="width: 18px;"></i>
                                    <span class="small text-muted">{{ $user->user_address ?? 'Chưa cập nhật' }}</span>
                                </div>
                            </div>

                            {{-- Quick links --}}
                            <div class="mt-4 pt-3 border-top">
                                <a href="/order-history" class="btn btn-sm btn-outline-secondary rounded-pill px-3 me-1">
                                    <i class="fas fa-shopping-bag me-1"></i> Đơn mua
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN: Info + Edit Form --}}
                <div class="col-lg-8">

                    {{-- Info Card --}}
                    <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;" id="infoCard">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h6 class="fw-bold mb-0" style="font-size: 16px; color: #222;">
                                    <i class="fas fa-user-circle me-2 text-primary"></i> Thông tin cá nhân
                                </h6>
                                <button class="btn btn-primary btn-sm rounded-pill px-3" id="openbuttonUpdatedform">
                                    <i class="fas fa-edit me-1"></i> Chỉnh sửa
                                </button>
                            </div>

                            {{-- Info rows --}}
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="p-3 rounded-3" style="background: #f8f9fa;">
                                        <div class="row align-items-center">
                                            <div class="col-4">
                                                <span class="small fw-semibold text-muted text-uppercase" style="letter-spacing: .5px; font-size: 11px;">Họ và tên</span>
                                            </div>
                                            <div class="col-8">
                                                <span class="fw-semibold" style="color: #222;">{{ $user->user_name ?? 'Chưa cập nhật' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="p-3 rounded-3" style="background: #f8f9fa;">
                                        <div class="row align-items-center">
                                            <div class="col-4">
                                                <span class="small fw-semibold text-muted text-uppercase" style="letter-spacing: .5px; font-size: 11px;">Email</span>
                                            </div>
                                            <div class="col-8">
                                                <span class="fw-semibold" style="color: #222;">{{ $user->user_email ?? 'Chưa cập nhật' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="p-3 rounded-3" style="background: #f8f9fa;">
                                        <div class="row align-items-center">
                                            <div class="col-4">
                                                <span class="small fw-semibold text-muted text-uppercase" style="letter-spacing: .5px; font-size: 11px;">Số điện thoại</span>
                                            </div>
                                            <div class="col-8">
                                                <span class="fw-semibold" style="color: #222;">{{ $user->user_phone ?? 'Chưa cập nhật' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="p-3 rounded-3" style="background: #f8f9fa;">
                                        <div class="row align-items-center">
                                            <div class="col-4">
                                                <span class="small fw-semibold text-muted text-uppercase" style="letter-spacing: .5px; font-size: 11px;">Địa chỉ</span>
                                            </div>
                                            <div class="col-8">
                                                <span class="fw-semibold" style="color: #222;">{{ $user->user_address ?? 'Chưa cập nhật' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Edit Form Card --}}
                    <div class="card border-0 shadow-sm" style="border-radius: 20px; display: none;" id="editCard">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h6 class="fw-bold mb-0" style="font-size: 16px; color: #222;">
                                    <i class="fas fa-pen me-2 text-primary"></i> Chỉnh sửa thông tin
                                </h6>
                                <button class="btn btn-outline-secondary btn-sm rounded-pill px-3" id="closebuttonUpdatedform" type="button">
                                    <i class="fas fa-times me-1"></i> Huỷ
                                </button>
                            </div>

                            <form method="post" action="/update-user-in-profile" id="formupdateuser" enctype="multipart/form-data">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold text-muted text-uppercase" style="letter-spacing: .5px; font-size: 11px;">Họ và tên <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control rounded-3 @error('user_name') is-invalid @enderror"
                                            name="user_name" placeholder="Nhập họ và tên"
                                            value="{{ old('user_name', $user->user_name) }}"
                                            style="border: 1.5px solid #e0e0e0; padding: 10px 14px;">
                                        @error('user_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold text-muted text-uppercase" style="letter-spacing: .5px; font-size: 11px;">Email</label>
                                        <input type="email" class="form-control rounded-3 @error('user_email') is-invalid @enderror"
                                            name="user_email" placeholder="Nhập email"
                                            value="{{ old('user_email', $user->user_email) }}"
                                            style="border: 1.5px solid #e0e0e0; padding: 10px 14px;">
                                        @error('user_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold text-muted text-uppercase" style="letter-spacing: .5px; font-size: 11px;">Số điện thoại</label>
                                        <input type="text" class="form-control rounded-3"
                                            name="user_phone" placeholder="Nhập số điện thoại"
                                            value="{{ old('user_phone', $user->user_phone) }}"
                                            style="border: 1.5px solid #e0e0e0; padding: 10px 14px;">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold text-muted text-uppercase" style="letter-spacing: .5px; font-size: 11px;">Địa chỉ</label>
                                        <input type="text" class="form-control rounded-3"
                                            name="user_address" placeholder="Nhập địa chỉ"
                                            value="{{ old('user_address', $user->user_address) }}"
                                            style="border: 1.5px solid #e0e0e0; padding: 10px 14px;">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small fw-semibold text-muted text-uppercase" style="letter-spacing: .5px; font-size: 11px;">Ảnh đại diện</label>
                                        <input class="form-control rounded-3" type="file" id="avatarFile" name="user_avatar"
                                            accept=".png, .jpg, .jpeg"
                                            style="border: 1.5px solid #e0e0e0; padding: 10px 14px;">
                                    </div>
                                    <div class="col-12 text-center" id="avatarPreviewWrap" style="{{ $user->user_avatar ? '' : 'display:none;' }}">
                                        <img id="avatarPreview"
                                            src="{{ $user->user_avatar ? asset('storage/avatars/' . $user->user_avatar) : '' }}"
                                            alt="Avatar Preview"
                                            class="rounded-circle shadow"
                                            style="width: 80px; height: 80px; object-fit: cover; margin-top: 8px;">
                                    </div>
                                </div>

                                <div class="d-flex gap-2 mt-4 justify-content-end">
                                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" id="closebuttonUpdatedform2">Huỷ</button>
                                    <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 shadow-sm fw-semibold">
                                        <i class="fas fa-save me-2"></i> Lưu thay đổi
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Profile Page End -->


    @extends('client.layout.footer')



    <!-- Back to Top -->
    <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i
            class="fa fa-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('lib/lightbox/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
    // Profile page JS handled in <head> DOMContentLoaded
    </script>
</body>

</html>