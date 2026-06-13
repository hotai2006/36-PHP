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
            font-size: 13px !important;
            font-weight: 700;
            margin-bottom: 4px !important;
            letter-spacing: 0.5px;
            color: #64748b;
        }
        .featurs-item.active h6 {
            color: #ffb524 !important;
        }
        .featurs-item p {
            font-size: 11px !important;
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
        .table-responsive {
            border: none;
            box-shadow: none;
            margin-bottom: 0;
        }
        .table th, .table td {
            padding: 10px 14px !important;
            vertical-align: middle !important;
        }
        .table thead th {
            background-color: #d94140 !important;
            color: #ffffff !important;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 700;
            border: none !important;
        }
        .table tbody td, .table tbody th {
            font-size: 0.85rem;
        }
        .product-img-tracking {
            width: 50px !important;
            height: 50px !important;
            object-fit: cover;
            border-radius: 6px !important;
            border: 1px solid #eee;
        }
        .back-history-btn {
            border: 1px solid rgba(0, 0, 0, 0.15) !important;
            color: #555 !important;
            background-color: transparent;
            transition: all 0.2s ease;
        }
        .back-history-btn:hover {
            background-color: #d94140 !important;
            border-color: #d94140 !important;
            color: #fff !important;
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


    <div style="max-width: 1100px; margin-left: auto; margin-right: auto;" class="container-fluid featurs pb-5 client-content-container">
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between mb-4 gap-3 position-relative">
            <a href="/order-history" class="btn back-history-btn rounded-pill px-3 py-1 d-inline-flex align-items-center gap-1" style="font-size: 13px; font-weight: 600;">
                <i class="fas fa-arrow-left"></i> Quay lại lịch sử
            </a>
            <h3 class="mb-0 fw-bold text-center flex-grow-1">Thông tin theo dõi đơn hàng</h3>
            <div style="width: 140px;" class="d-none d-md-block"></div> <!-- Spacer to balance centering on desktop -->
        </div>
        @if (isset($order))
            <!-- Khung thông tin đơn hàng gộp nhất -->
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4" style="border: 1px solid rgba(0, 0, 0, 0.08) !important; background-color: #fff;">
                <!-- Phần danh sách sản phẩm -->
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 10%;">Sản phẩm</th>
                                <th scope="col" style="width: 45%;">Tên</th>
                                <th scope="col" class="text-end" style="width: 15%;">Giá cả</th>
                                <th scope="col" class="text-center" style="width: 15%;">Số lượng</th>
                                <th scope="col" class="text-end" style="width: 15%;">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="table-light">
                                <td colspan="2" class="fw-bold text-uppercase text-secondary py-2" style="font-size: 0.85rem;">
                                    Đơn hàng #{{ $order->id }}
                                </td>
                                <td colspan="3" class="text-end fw-bold text-primary py-2" style="font-size: 0.9rem;">
                                    Tổng thanh toán: {{ number_format($order->total_price, 0, ',', '.') }} đ
                                </td>
                            </tr>
                            @foreach ($order->orderDetails as $orderDetail)
                                <tr>
                                    <th scope="row">
                                        <img loading="lazy"
                                            src="{{ asset('products/' . $orderDetail->product->product_image_url) }}"
                                            class="img-fluid product-img-tracking" alt="">
                                    </th>
                                    <td>
                                        <a href="/product/{{ $orderDetail->product->id }}" class="text-dark fw-bold text-decoration-none" style="font-size: 0.9rem;">
                                            {{ $orderDetail->product->product_name }}
                                        </a>
                                    </td>
                                    <td class="text-end">
                                        <span class="text-muted" style="font-size: 0.85rem;">{{ number_format($orderDetail->price, 0, ',', '.') }} đ</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="fw-bold" style="font-size: 0.85rem;">{{ $orderDetail->quantity }}</span>
                                    </td>
                                    <td class="text-end">
                                        <span class="fw-bold text-primary" style="font-size: 0.85rem;">{{ number_format($orderDetail->price * $orderDetail->quantity, 0, ',', '.') }} đ</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Phần chi tiết người nhận và đơn hàng (Gộp chung ở đáy khung) -->
                <div class="bg-light p-3 border-top" style="border-top: 1px solid rgba(0, 0, 0, 0.08) !important;">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <h6 class="fw-bold text-muted mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Thông tin nhận hàng</h6>
                            <p class="mb-1 fw-bold text-dark" style="font-size: 0.85rem;">{{ $order->receiver_name }}</p>
                            <p class="mb-1 text-muted" style="font-size: 0.8rem;"><i class="fas fa-phone-alt me-1 text-primary"></i> {{ $order->receiver_phone }}</p>
                            <p class="mb-0 text-muted" style="font-size: 0.8rem;"><i class="fas fa-map-marker-alt me-1 text-primary"></i> {{ $order->receiver_address }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="fw-bold text-muted mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Thanh toán</h6>
                            <p class="mb-1 text-muted" style="font-size: 0.85rem;">Phương thức: <span class="fw-bold text-dark">{{ $order->payment_method }}</span></p>
                            <p class="mb-0 text-muted" style="font-size: 0.85rem;">Trạng thái: 
                                @if($order->pay == 1)
                                    <span class="badge bg-success" style="font-size: 0.7rem;">Đã thanh toán</span>
                                @else
                                    <span class="badge bg-warning text-dark" style="font-size: 0.7rem;">Chưa thanh toán</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="fw-bold text-muted mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Chi tiết đơn hàng</h6>
                            <p class="mb-1 text-muted" style="font-size: 0.85rem;">Mã đơn hàng: <span class="fw-bold text-dark">#{{ $order->id }}</span></p>
                            <p class="mb-0 text-muted" style="font-size: 0.85rem;">Ngày đặt: <span class="fw-bold text-dark">{{ $order->created_at->format('d/m/Y H:i') }}</span></p>
                    </div>
                </div>
            </div>

            <div class="container px-0 mt-3">
                <div class="row g-3">
                    <!-- Đặt hàng thành công -->
                    <div class="col-md-4 col-lg">
                        <div class="featurs-item text-center rounded bg-light p-3 {{ $order->order_status == 'pending' ? 'active' : '' }}">
                            <div class="featurs-icon btn-square rounded-circle mb-4 mx-auto {{ $order->order_status == 'pending' ? 'active' : '' }}" style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                                <i class="far fa-thumbs-up fa-2x"></i>
                            </div>
                            <div class="featurs-content text-center">
                                <h6 class="fw-bold mb-1">ĐẶT HÀNG THÀNH CÔNG</h6>
                                <p class="mb-0 text-muted small">Đơn hàng sẽ sớm được xác nhận</p>
                            </div>
                        </div>
                    </div>
                    <!-- Chờ lấy hàng -->
                    <div class="col-md-4 col-lg">
                        <div class="featurs-item text-center rounded bg-light p-3 {{ $order->order_status == 'confirmed' ? 'active' : '' }}">
                            <div class="featurs-icon btn-square rounded-circle mb-4 mx-auto {{ $order->order_status == 'confirmed' ? 'active' : '' }}" style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-box fa-2x"></i>
                            </div>
                            <div class="featurs-content text-center">
                                <h6 class="fw-bold mb-1">CHỜ LẤY HÀNG</h6>
                                <p class="mb-0 text-muted small">Đã xác nhận, chờ shipper qua lấy</p>
                            </div>
                        </div>
                    </div>
                    <!-- Đơn hàng đang được vận chuyển -->
                    <div class="col-md-4 col-lg">
                        <div class="featurs-item text-center rounded bg-light p-3 {{ $order->order_status == 'shipping' ? 'active' : '' }}">
                            <div class="featurs-icon btn-square rounded-circle mb-4 mx-auto {{ $order->order_status == 'shipping' ? 'active' : '' }}" style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-car-side fa-2x"></i>
                            </div>
                            <div class="featurs-content text-center">
                                <h6 class="fw-bold mb-1">ĐANG ĐƯỢC VẬN CHUYỂN</h6>
                                <p class="mb-0 text-muted small">Đơn hàng sắp đến tay bạn</p>
                            </div>
                        </div>
                    </div>
                    <!-- Đơn hàng đã được giao -->
                    <div class="col-md-4 col-lg">
                        <div class="featurs-item text-center rounded bg-light p-3 {{ $order->order_status == 'complete' ? 'active' : '' }}">
                            <div class="featurs-icon btn-square rounded-circle mb-4 mx-auto {{ $order->order_status == 'complete' ? 'active' : '' }}" style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-people-carry fa-2x" style="font-size: 28px;"></i>
                            </div>
                            <div class="featurs-content text-center">
                                <h6 class="fw-bold mb-1">HÀNG ĐÃ ĐƯỢC GIAO</h6>
                                <p class="mb-0 text-muted small">Đổi trả miễn phí</p>
                            </div>
                        </div>
                    </div>
                    <!-- Đơn hàng đã bị hủy -->
                    <div class="col-md-4 col-lg">
                        <div class="featurs-item text-center rounded bg-light p-3 {{ $order->order_status == 'cancel' ? 'active' : '' }}">
                            <div class="featurs-icon btn-square rounded-circle mb-4 mx-auto {{ $order->order_status == 'cancel' ? 'active' : '' }}" style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-times-circle fa-2x"></i>
                            </div>
                            <div class="featurs-content text-center">
                                <h6 class="fw-bold mb-1">ĐƠN HÀNG ĐÃ HỦY</h6>
                                <p class="mb-0 text-muted small">Liên hệ nếu gặp vấn đề</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="container text-center py-5">
                <h3>Đơn hàng không tồn tại</h3>
                <p class="text-muted">Vui lòng kiểm tra lại mã đơn hàng hoặc liên hệ với chúng tôi để biết thêm thông tin.</p>
            </div>
        @endif
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