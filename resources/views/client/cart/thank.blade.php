<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>T-Sports</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="_csrf" content="{{ csrf_token() }}">
    <meta name="_csrf_header" content="X-CSRF-TOKEN">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap"
        rel="stylesheet">

    <!--Sử dụng thư viện jQuery Toast:-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>

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
    <style>
    .pagination {
        margin-top: 50px;
        display: inline-flex;
        gap: 5px;
    }

    .pagination .page-item .page-link {
        color: #333;
        border-radius: 20px;
        padding: 8px 16px;
        margin: 2px;
        border: 1px solid #ddd;
        transition: all 0.3s ease;
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }

    .pagination .page-item:hover .page-link {
        background-color: #f0f0f0;
        color: #007bff;
    }
    /* Styles to make tracking page extremely compact and clean */
    .featurs-item {
        padding: 1rem !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        opacity: 0.55;
    }
    .featurs-item.active {
        opacity: 1;
        border: 1px solid #ffb524 !important;
        box-shadow: 0 8px 25px rgba(255, 181, 36, 0.12) !important;
    }
    .featurs-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
    }
    .featurs-item h6 {
        font-size: 14px !important;
        font-weight: 700;
        margin-bottom: 4px !important;
        color: #64748b;
    }
    .featurs-item.active h6 {
        color: #ffb524 !important;
    }
    .featurs-item p {
        font-size: 12px !important;
        color: #777;
    }
    
    /* State colors: active is yellow, non-active is gray */
    .featurs-icon {
        background-color: #cbd5e1 !important; /* cool gray */
        transition: all 0.3s ease;
        position: relative;
    }
    .featurs-icon::after {
        background-color: #cbd5e1 !important;
        transition: all 0.3s ease;
        content: "" !important;
        width: 20px !important;
        height: 20px !important;
        bottom: -5px !important;
        left: 50% !important;
        transform: translateX(-50%) rotate(45deg) !important;
        position: absolute !important;
    }
    .featurs-icon i {
        color: #64748b !important;
    }
    
    .featurs-icon.active {
        background-color: #ffb524 !important; /* brand yellow/orange */
    }
    .featurs-icon.active::after {
        background-color: #ffb524 !important;
    }
    .featurs-icon.active i {
        color: #ffffff !important;
    }
    </style>
</head>

<body>

    <!-- Spinner Start -->
    <div id="spinner"
        class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->

    @extends('client.layout.header')






    <!-- 404 Start -->
    <div class="container-fluid client-content-container">
        <div class="container py-4 text-center">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <i style="font-size: 80px;" class="far fa-smile text-success mb-3"></i>
                    <h2 class="fw-bold text-dark mb-2">Đặt hàng thành công</h2>
                    <h5 class="text-muted mb-2">Cảm ơn bạn đã mua hàng</h5>
                    <p class="text-muted small mb-4">T-Sports - Uy tín - chất lượng</p>
                    <a class="btn border-secondary rounded-pill py-2 px-4" style="font-weight: 500;" href="/">Go Back To Home</a>
                </div>
            </div>
        </div>
    </div>
    <!-- 404 End -->

    <div class="container-fluid featurs pb-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-3 active">
                        <div class="featurs-icon btn-square rounded-circle mb-4 mx-auto active" style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                            <i class="far fa-thumbs-up fa-2x"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h6 class="fw-bold mb-1" style="font-size: 14px;">ĐẶT HÀNG THÀNH CÔNG</h6>
                            <p class="mb-0 text-muted small" style="font-size: 12px;">Đơn hàng sẽ sớm được xác nhận</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-3">
                        <div class="featurs-icon btn-square rounded-circle mb-4 mx-auto" style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-car-side fa-2x"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h6 class="fw-bold mb-1" style="font-size: 14px;">ĐANG ĐƯỢC VẬN CHUYỂN</h6>
                            <p class="mb-0 text-muted small" style="font-size: 12px;">Đơn hàng sắp đến tay bạn</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-3">
                        <div class="featurs-icon btn-square rounded-circle mb-4 mx-auto" style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-people-carry fa-2x" style="font-size: 28px;"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h6 class="fw-bold mb-1" style="font-size: 14px;">HÀNG ĐÃ ĐƯỢC GIAO</h6>
                            <p class="mb-0 text-muted small" style="font-size: 12px;">Đổi trả miễn phí</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-3">
                        <div class="featurs-icon btn-square rounded-circle mb-4 mx-auto" style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-times-circle fa-2x"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h6 class="fw-bold mb-1" style="font-size: 14px;">ĐƠN HÀNG ĐÃ HỦY</h6>
                            <p class="mb-0 text-muted small" style="font-size: 12px;">Liên hệ nếu gặp vấn đề</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



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
</body>

</html>