<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>T-Sports</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="_csrf_header" content="X-CSRF-TOKEN">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap"
        rel="stylesheet">

    <!--Sử dụng thư viện jQuery Toast:-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

    /* Xóa vòng tròn xanh khi focus vào nút +/- */
    .btn-plus:focus,
    .btn-minus:focus,
    .btn-plus:focus-visible,
    .btn-minus:focus-visible {
        outline: none !important;
        box-shadow: none !important;
    }

    /* Xóa viền xanh khi focus vào ô số lượng */
    .cart-qty-input:focus,
    .cart-qty-input:focus-visible {
        outline: none !important;
        box-shadow: none !important;
        border-color: transparent !important;
    }
    .cart-qty-input {
        background: transparent !important;
    }


    /* Khung sản phẩm cuộn được */
    .cart-product-scroll {
        max-height: 460px;
        overflow-y: auto;
        overflow-x: auto;
    }

    /* Thanh cuộn đẹp hơn */
    .cart-product-scroll::-webkit-scrollbar {
        width: 5px;
        height: 5px;
    }
    .cart-product-scroll::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 10px;
    }
    .cart-product-scroll::-webkit-scrollbar-thumb:hover {
        background: #e74c3c;
    }

    /* Header bảng dính khi cuộn trong div overflow */
    .cart-product-scroll thead th {
        position: sticky;
        top: 0;
        background-color: #d94140 !important;
        color: #ffffff !important;
        z-index: 5;
        box-shadow: 0 2px 0 #d94140;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 700;
        border: none !important;
        padding: 12px 14px !important;
    }
    .breadcrumb-item a {
        color: #d94140 !important;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s ease;
    }
    .breadcrumb-item a:hover {
        color: #b83534 !important;
        text-decoration: underline;
    }
    .breadcrumb-item.active {
        color: #6c757d !important;
    }
    </style>

    <script>
    $(document).ready(function() {
        // Sự kiện thay đổi của checkbox bên ngoài
        $('.external-checkbox').on('change', function() {
            // Lấy chỉ số từ thuộc tính data
            var index = $(this).data('cart-detail-index');
            // Tìm checkbox bên trong form theo chỉ số và cập nhật trạng thái
            $('#cartDetails' + index + '-checkbox').prop('checked', $(this).prop('checked'));
        });
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






    <div class="container-fluid pt-3 pb-4 client-content-container">
        <div class="container py-3">

            <div>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Chi tiết giỏ hàng</li>
                </ol>
            </div>

            @if (empty($cartDetails) || count($cartDetails) === 0)
            <div class="text-center py-5">
                <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
                <h3 class="mb-3">Giỏ hàng của bạn đang trống!</h3>
                <p class="text-muted mb-4">Hãy thêm các sản phẩm thể thao yêu thích vào giỏ hàng.</p>
                <a href="/product" class="btn btn-primary rounded-pill px-4 py-2 text-white">Quay lại mua sắm</a>
            </div>
            @else
            <div class="row g-4">
                <!-- Cột trái: Danh sách sản phẩm -->
                <div class="col-lg-8">
                    <div class="bg-white p-4 rounded shadow-sm border">
                        <!-- Header bảng cố định + nút Xóa tất cả -->
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <input class="form-check-input select-all-cart" type="checkbox" id="selectAllCart" style="cursor: pointer;">
                                <span class="fw-bold ms-1">Chọn tất cả</span>
                            </div>
                            <button id="btnDeleteAllCart" class="btn btn-sm btn-outline-danger rounded-pill px-3" type="button">
                                <i class="fa fa-trash me-1"></i>Xóa tất cả
                            </button>
                        </div>
                        <!-- Vùng cuộn sản phẩm -->
                        <div class="cart-product-scroll">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th scope="col" class="fw-bold">Sản phẩm</th>
                                    <th scope="col" class="fw-bold">Tên</th>
                                    <th scope="col" class="fw-bold">Giá</th>
                                    <th scope="col" class="fw-bold">Số lượng</th>
                                    <th scope="col" class="fw-bold">Thành tiền</th>
                                    <th scope="col" class="fw-bold" style="width: 70px;">Xử lý</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartDetails as $cartDetail)
                                <tr id="cartItem{{$cartDetail->id }}">
                                    <th class="orderCart" scope="row">
                                        <div class="d-flex align-items-center gap-2">
                                            <input class="form-check-input external-checkbox" type="checkbox"
                                                data-cart-detail-index="{{ $loop->index }}"
                                                data-cart-detail-id="{{ $cartDetail->id }}"
                                                style="cursor: pointer;"
                                                {{ $cartDetail->cartDetails_checkbox ? 'checked' : '' }}>
                                            <img loading="lazy"
                                                src="{{ asset('products/' . $cartDetail->product->product_image_url) }}"
                                                class="img-fluid rounded-circle" style="width: 55px; height: 55px; object-fit: cover;" alt="">
                                        </div>
                                    </th>
                                    <td>
                                        <p class="mb-0 fw-bold">
                                            <a href="/product/{{ $cartDetail->product->id }}" class="text-decoration-none text-dark hover-danger">
                                                {{ $cartDetail->product->product_name }}
                                            </a>
                                        </p>
                                        <small class="text-muted">{{ $cartDetail->product->product_factory }}</small>
                                    </td>
                                    <td>
                                        <p class="mb-0 fw-bold text-dark">
                                            {{ number_format($cartDetail->product->product_price, 0, ',', '.') }} đ
                                        </p>
                                    </td>
                                    <td>
                                        <div id="cart" data-url="{{ route('cart.updateQuantityAjax') }}"></div>
                                        <div class="input-group quantity" style="width: 100px;">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-minus rounded-circle bg-light border"
                                                    data-id="{{ $cartDetail->id }}">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input type="text" class="form-control form-control-sm text-center border-0 cart-qty-input"
                                                value="{{ $cartDetail->cartDetails_quantity }}"
                                                data-cart-detail-id="{{ $cartDetail->id }}"
                                                data-cart-detail-price="{{ $cartDetail->product->product_price }}"
                                                data-cart-detail-index="{{ $loop->index }}"
                                                readonly>
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-plus rounded-circle bg-light border"
                                                    data-id="{{ $cartDetail->id }}">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0 fw-bold text-danger total-price" data-cart-detail-id="{{ $cartDetail->id }}">
                                            {{ number_format($cartDetail->product->product_price * $cartDetail->cartDetails_quantity, 0, ',', '.') }} đ
                                        </p>
                                    </td>
                                    <td>
                                        <form method="POST" id="deleteCartForm{{ $cartDetail->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-deleteCartDetail btn-sm rounded-circle bg-light border hover-danger-bg" id="{{ $cartDetail->id }}">
                                                <i class="fa fa-times text-danger"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div><!-- end cart-product-scroll -->
                    </div>

                    <!-- Hidden Form for Checkout Redirect -->
                    <form id="checkoutForm" style="display: none;" action="{{ route('confirmCheckout') }}" method="POST">
                        @csrf
                        <input type="hidden" name="coupon_code" id="hiddenCouponCode">
                        <div>
                            @foreach ($cartDetails as $index => $cartDetail)
                            <input type="hidden" name="cartDetails[{{ $loop->index }}][id]" value="{{ $cartDetail->id }}">
                            <input type="hidden" name="cartDetails[{{ $loop->index }}][quantity]" value="{{ $cartDetail->cartDetails_quantity }}">
                            <input id="cartDetails{{ $loop->index }}-checkbox" value="1"
                                class="form-check-input internal-checkbox cart-checkbox" type="checkbox"
                                name="cartDetails[{{ $loop->index }}][checkbox]" 
                                {{ $cartDetail->cartDetails_checkbox ? 'checked' : '' }} style="display: none;">
                            @endforeach
                        </div>
                    </form>
                </div>

                <!-- Cột phải: Summary & Checkout (Shopee Style) -->
                <div class="col-lg-4">
                    <div class="bg-white p-4 rounded shadow-sm border sticky-top" style="top: 110px; z-index: 10;">
                        <h4 class="mb-4 fw-bold pb-2 border-bottom text-dark">Thông tin thanh toán</h4>

                        <!-- Khung mã giảm giá -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small text-uppercase">Mã giảm giá</label>
                            <div class="input-group shadow-sm rounded-3 overflow-hidden">
                                <input type="text" id="couponCodeInput" class="form-control border-secondary" placeholder="Nhập mã (ví dụ: TSPORTS10)">
                                <button type="button" id="btnApplyCoupon" class="btn btn-danger text-white px-3 fw-bold">Áp dụng</button>
                            </div>
                            <div id="couponMessage" class="mt-2 small fw-bold" style="display: none;"></div>
                        </div>

                        <hr class="text-muted">

                        <!-- Danh sách sản phẩm đã chọn -->
                        <div id="sidebarSelectedProducts" class="mb-3" style="display:none;">
                            <h6 class="fw-bold text-muted small text-uppercase mb-2">Sản phẩm đã chọn</h6>
                            <ul id="sidebarProductList" class="list-unstyled mb-0" style="max-height:160px; overflow-y:auto;">
                            </ul>
                        </div>

                        <!-- Chi tiết thanh toán -->
                        <div class="d-flex justify-content-between mb-2 text-dark">
                            <span>Tạm tính (<span id="checkedCount" class="fw-bold text-danger">0</span> sản phẩm):</span>
                            <span id="summarySubtotal" class="fw-bold text-end">0 đ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 text-dark" id="shippingFeeWrapper">
                            <span>Phí vận chuyển:</span>
                            <span id="summaryShipping" class="fw-bold text-end">0 đ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 text-success" id="couponDiscountWrapper" style="display: none !important;">
                            <span>Giảm giá:</span>
                            <span id="summaryDiscount" class="fw-bold text-end">-0 đ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4 pt-2 border-top">
                            <span class="fs-5 fw-bold text-dark">Tổng thanh toán:</span>
                            <span id="summaryTotal" class="fs-5 fw-bold text-danger text-end">0 đ</span>
                        </div>

                        <!-- Các nút hành động -->
                        <button id="btnShowOrderInfo" class="btn btn-danger w-100 rounded-pill py-3 text-white fw-bold text-uppercase mb-2 shadow-sm hover-scale" type="button">
                            <i class="fas fa-shopping-bag me-2"></i>Mua hàng
                        </button>
                        <small class="text-muted text-center d-block" id="buyHint">Chọn sản phẩm bằng cách tick vào ô checkbox</small>
                        <div id="buyError" class="text-danger fw-bold text-center mt-2" style="display: none;"></div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>


        </div>
    </div>



    @extends('client.layout.footer')




    <!-- Back to Top -->
    <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i
            class="fa fa-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('lib/lightbox/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
    // Xóa tất cả sản phẩm trong giỏ hàng
    $(document).ready(function () {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
        $('#btnDeleteAllCart').on('click', function () {
            if (!confirm('Bạn có chắc muốn xóa tất cả sản phẩm trong giỏ hàng không?')) return;
            $.ajax({
                url: '/cart/clear-all',
                method: 'DELETE',
                success: function (res) {
                    if (res.status === 'success') {
                        // Xóa toàn bộ hàng trong bảng
                        $('tbody tr').remove();
                        // Cập nhật badge
                        if (typeof updateCartBadge === 'function') updateCartBadge(0);
                        $.toast({
                            heading: 'Giỏ hàng',
                            text: 'Đã xóa tất cả sản phẩm!',
                            position: { top: 110, right: 20 },
                            icon: 'success'
                        });
                        // Reload sau 1 giây để hiện trạng thái giỏ trống
                        setTimeout(function() { location.reload(); }, 1200);
                    }
                },
                error: function () {
                    $.toast({
                        heading: 'Lỗi',
                        text: 'Có lỗi xảy ra, vui lòng thử lại!',
                        position: { top: 110, right: 20 },
                        icon: 'error'
                    });
                }
            });
        });
    });
    </script>
</body>

</html>