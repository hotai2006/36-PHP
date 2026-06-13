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
</head>

<body>

    <!-- Spinner Start -->
    <div id="spinner"
        class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->

    @extends('client.layout.header')




    <!-- Cảnh báo quyền truy cập -->
    <style>
        @keyframes pulse {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(217, 65, 64, 0.4);
            }
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 15px rgba(217, 65, 64, 0);
            }
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(217, 65, 64, 0);
            }
        }
        .error-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.5);
            max-width: 500px;
            width: 90%;
            padding: 3rem;
            transition: transform 0.3s ease;
        }
        .error-card:hover {
            transform: translateY(-5px);
        }
        .pulse-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(217, 65, 64, 0.1);
            color: #d94140;
            border-radius: 50%;
            width: 100px;
            height: 100px;
            font-size: 3rem;
            margin-bottom: 1.5rem;
            animation: pulse 2s infinite;
        }
        .btn-premium {
            background-color: #d94140 !important;
            border-color: #d94140 !important;
            color: #fff !important;
            border-radius: 30px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(217, 65, 64, 0.2);
        }
        .btn-premium:hover {
            background-color: #b83534 !important;
            border-color: #b83534 !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(217, 65, 64, 0.4);
        }
        .btn-outline-premium {
            border: 2px solid #ddd;
            color: #555 !important;
            border-radius: 30px;
            padding: 10px 28px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-outline-premium:hover {
            background-color: #f8f9fa;
            border-color: #bbb;
            transform: translateY(-2px);
        }
    </style>

    <div class="d-flex align-items-center justify-content-center" style="min-height: calc(100vh - 150px); padding-top: 120px; padding-bottom: 60px;">
        <div class="error-card text-center">
            <div class="pulse-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h2 class="fw-bold text-dark mb-3" style="font-family: 'Raleway', sans-serif; font-size: 2rem;">Truy Cập Bị Từ Chối</h2>
            <p class="text-muted mb-4" style="font-size: 1.1rem; line-height: 1.6;">
                Rất tiếc! Bạn không có quyền truy cập vào tài nguyên này. Vui lòng kiểm tra lại tài khoản hoặc quay về trang chủ.
            </p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="/" class="btn btn-premium d-inline-flex align-items-center text-decoration-none">
                    <i class="fas fa-home me-2"></i> Quay về trang chủ
                </a>
                <a href="/login" class="btn btn-outline-premium d-inline-flex align-items-center text-decoration-none">
                    <i class="fas fa-sign-in-alt me-2"></i> Đăng nhập
                </a>
            </div>
        </div>
    </div>








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
</body>

</html>