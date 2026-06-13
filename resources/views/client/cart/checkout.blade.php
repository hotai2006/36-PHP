<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>T-Sports - Thanh Toán</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="_csrf" content="{{ csrf_token() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="_csrf_header" content="X-CSRF-TOKEN">

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
    body {
        font-family: 'Open Sans', 'Raleway', sans-serif;
        background-color: #f8f9fa;
    }
    .checkout-title {
        font-size: 2rem;
        font-weight: 800;
        color: #2b303a;
    }
    .breadcrumb-item a {
        color: #cbd5e1;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s ease;
    }
    .breadcrumb-item a:hover {
        color: #d94140;
    }
    .breadcrumb-item.active {
        color: #cbd5e1 !important;
    }
    .checkout-card {
        background: #ffffff;
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        padding: 2rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }
    .checkout-card:hover {
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06);
    }
    .card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #2b303a;
        margin-bottom: 1.5rem;
        border-left: 4px solid #d94140;
        padding-left: 12px;
    }
    .form-group label {
        font-weight: 600;
        color: #4a5568;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
    }
    .form-control-custom {
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.2s ease;
    }
    .form-control-custom:focus {
        border-color: #d94140;
        box-shadow: 0 0 0 3px rgba(217, 65, 64, 0.15);
        outline: none;
    }
    .payment-option-card {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        cursor: pointer;
        transition: all 0.2s ease;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        width: 100%;
        background-color: #fff;
    }
    .payment-option-card:hover {
        border-color: #d94140;
        background-color: #fff8f8;
    }
    .payment-option-card input[type="radio"] {
        display: none;
    }
    .payment-option-card .payment-radio-custom {
        width: 18px;
        height: 18px;
        border: 2px solid #cbd5e1;
        border-radius: 50%;
        margin-right: 12px;
        position: relative;
        flex-shrink: 0;
        background-color: #fff;
    }
    .payment-option-card input[type="radio"]:checked + .payment-radio-custom {
        border-color: #d94140;
    }
    .payment-option-card input[type="radio"]:checked + .payment-radio-custom::after {
        content: '';
        width: 8px;
        height: 8px;
        background: #d94140;
        border-radius: 50%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .payment-option-card.active {
        border-color: #d94140;
        background-color: #fff8f8;
    }
    .product-summary-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .product-summary-item:last-child {
        border-bottom: none;
    }
    .product-summary-item img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }
    .pricing-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        color: #4a5568;
        font-size: 0.95rem;
    }
    .pricing-row.total {
        margin-top: 1.25rem;
        padding-top: 1.25rem;
        border-top: 2px dashed #cbd5e1;
        font-size: 1.25rem;
        color: #2b303a;
    }
    .btn-checkout-submit {
        background-color: #d94140;
        color: #ffffff;
        border: none;
        border-radius: 12px;
        padding: 1rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        width: 100%;
        transition: all 0.3s ease;
        box-shadow: 0 4px 14px rgba(217, 65, 64, 0.4);
    }
    .btn-checkout-submit:hover {
        background-color: #b83534;
        box-shadow: 0 6px 20px rgba(217, 65, 64, 0.6);
        transform: translateY(-2px);
    }
    .back-btn-header {
        border: 2px solid #e2e8f0;
        color: #4a5568;
        background-color: #fff;
        border-radius: 30px;
        padding: 0.6rem 1.25rem;
        font-weight: 700;
        font-size: 0.9rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }
    .back-btn-header:hover {
        border-color: #d94140;
        color: #d94140;
        box-shadow: 0 4px 12px rgba(217, 65, 64, 0.08);
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

    <div class="container pt-3 pb-5 client-content-container">
        
        <!-- Header Thanh Toán với nút Quay lại bên phải -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <h1 class="checkout-title mb-0">Thanh Toán Đơn Hàng</h1>
                <nav aria-label="breadcrumb" class="mt-2">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="/cart">Giỏ hàng</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Thanh toán</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="/cart" class="back-btn-header">
                    <i class="fas fa-arrow-left"></i> Quay lại giỏ hàng
                </a>
            </div>
        </div>

        @if (empty($cartDetails) || count($cartDetails) == 0)
            <div class="checkout-card text-center py-5">
                <i class="fas fa-shopping-basket fa-4x text-muted mb-3"></i>
                <h3 class="fw-bold">Giỏ hàng thanh toán trống!</h3>
                <p class="text-muted">Bạn không có sản phẩm nào được chọn để thực hiện thanh toán.</p>
                <a href="/product" class="btn btn-primary rounded-pill px-4 py-2 mt-3 text-white">Quay lại mua sắm</a>
            </div>
        @else
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="/place-order" method="POST">
                @csrf
                <input type="hidden" name="coupon_code" id="hiddenCouponCode" value="{{ $couponCode ?? '' }}">
                <div class="row g-4">
                    <!-- Cột trái: Chỉ chứa Thông tin nhận hàng -->
                    <div class="col-lg-7">
                        <div class="checkout-card">
                            <h3 class="card-title">Thông tin nhận hàng</h3>
                            
                            <div class="form-group mb-3">
                                <label for="receiverName">
                                    <i class="fas fa-user me-2 text-muted" style="width: 16px;"></i>Tên người nhận
                                </label>
                                <input id="receiverName" class="form-control form-control-custom" name="receiverName" value="{{ $user->user_name ?? '' }}" placeholder="Nhập họ và tên người nhận" required />
                            </div>

                            <div class="form-group mb-3">
                                <label for="receiverPhone">
                                    <i class="fas fa-phone-alt me-2 text-muted" style="width: 16px;"></i>Số điện thoại
                                </label>
                                <input id="receiverPhone" class="form-control form-control-custom" name="receiverPhone" value="{{ $user->user_phone ?? '' }}" placeholder="Nhập số điện thoại nhận hàng" required />
                            </div>

                            <div class="form-group mb-3">
                                <label for="receiverAddress">
                                    <i class="fas fa-map-marker-alt me-2 text-muted" style="width: 16px;"></i>Địa chỉ nhận hàng
                                </label>
                                <input id="receiverAddress" class="form-control form-control-custom" name="receiverAddress" value="{{ $user->addresses->where('is_default', 1)->first()->address ?? $user->user_address ?? '' }}" placeholder="Nhập địa chỉ chi tiết giao hàng" required />
                            </div>
                        </div>
                    </div>

                    <!-- Cột phải: Đơn hàng của bạn (chứa cả Danh sách sản phẩm, Phương thức thanh toán & Tổng tiền) -->
                    <div class="col-lg-5">
                        <div class="checkout-card sticky-top" style="top: 110px; z-index: 5;">
                            <h3 class="card-title">Đơn hàng của bạn</h3>

                            <!-- Danh sách sản phẩm thu nhỏ -->
                            <div class="mb-4 custom-scrollbar" style="max-height: 240px; overflow-y: auto;">
                                @foreach ($cartDetails as $cartDetail)
                                    <div class="product-summary-item">
                                        <img src="{{ asset('products/' . $cartDetail->product->product_image_url) }}" alt="{{ $cartDetail->product->product_name }}">
                                        <div class="ms-3 flex-grow-1" style="min-width: 0;">
                                            <h6 class="mb-0 fw-bold text-dark text-truncate">{{ $cartDetail->product->product_name }}</h6>
                                            <small class="text-muted d-block mb-1">{{ $cartDetail->product->product_factory }}</small>
                                            <small class="text-dark">{{ number_format($cartDetail->product->product_price, 0, ',', '.') }} đ <span class="text-muted">x {{ $cartDetail->cartDetails_quantity }}</span></small>
                                        </div>
                                        <div class="text-end fw-bold text-dark ms-2" style="white-space: nowrap;">
                                            {{ number_format($cartDetail->product->product_price * $cartDetail->cartDetails_quantity, 0, ',', '.') }} đ
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Phương thức thanh toán đặt bên trong Đơn hàng của bạn -->
                            <div class="my-4 pt-3 border-top">
                                <h5 class="fw-bold mb-3 text-dark" style="font-size: 1rem;"><i class="fas fa-credit-card me-2 text-muted"></i>Phương thức thanh toán</h5>
                                
                                <label class="payment-option-card active" for="pay-cod">
                                    <input type="radio" id="pay-cod" name="paymentMethod" value="COD" checked>
                                    <div class="payment-radio-custom"></div>
                                    <div class="ms-2">
                                        <div class="fw-bold text-dark" style="font-size: 0.9rem;"><i class="fas fa-money-bill-wave me-2 text-success"></i>Thanh toán khi nhận hàng (COD)</div>
                                    </div>
                                </label>

                                <label class="payment-option-card" for="pay-momo">
                                    <input type="radio" id="pay-momo" name="paymentMethod" value="MOMO">
                                    <div class="payment-radio-custom"></div>
                                    <div class="ms-2">
                                        <div class="fw-bold text-dark" style="font-size: 0.9rem;"><i class="fas fa-wallet me-2 text-danger"></i>Thanh toán ví MoMo</div>
                                    </div>
                                </label>
                            </div>



                            <!-- Tính toán tiền đơn hàng -->
                            <div class="pt-3 border-top">
                                <div class="pricing-row">
                                    <span>Subtotal</span>
                                    <span class="fw-bold text-dark">{{ number_format($totalPrice, 0, ',', '.') }} ₫</span>
                                </div>
                                <div class="pricing-row">
                                    <span>Shipping Fee</span>
                                    @if($shippingFee == 0)
                                        <span class="text-success fw-bold">Free</span>
                                    @else
                                        <span class="text-dark fw-bold">{{ number_format($shippingFee, 0, ',', '.') }} ₫</span>
                                    @endif
                                </div>

                                <div class="pricing-row text-success" id="discountRow" style="{{ $discount > 0 ? 'display: flex;' : 'display: none;' }}">
                                    <span id="discountLabel">Discount (Coupon):</span>
                                    <span class="fw-bold" id="discountDisplay">-{{ number_format($discount, 0, ',', '.') }} ₫</span>
                                </div>

                                <div class="pricing-row total">
                                    <span class="fw-bold">Total Payment</span>
                                    <span class="fw-bold text-danger fs-3" id="finalTotalDisplay">{{ number_format($finalPrice, 0, ',', '.') }} ₫</span>
                                </div>
                            </div>

                            <!-- Nút xác nhận thanh toán -->
                            <button type="submit" class="btn btn-checkout-submit w-100 mt-4 py-3">
                                <i class="fas fa-shopping-bag me-2"></i>Xác nhận thanh toán
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        @endif
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
        document.addEventListener('DOMContentLoaded', function() {
            // Hiệu ứng tương tác chọn thẻ phương thức thanh toán
            const paymentCards = document.querySelectorAll('.payment-option-card');
            paymentCards.forEach(card => {
                const radio = card.querySelector('input[type="radio"]');
                card.addEventListener('click', function() {
                    paymentCards.forEach(c => c.classList.remove('active'));
                    radio.checked = true;
                    card.classList.add('active');
                });
            });
        });

        $(document).ready(function() {
            let originalTotal = {{ $totalPrice ?? 0 }};
            let appliedDiscount = {{ $discount ?? 0 }};
            let shippingFee = {{ $shippingFee ?? 0 }};

            // Restore UI if coupon already applied on page load
            if (appliedDiscount > 0) {
                $('#discountRow').css('display', 'flex');
                $('#discountDisplay').text('-' + new Intl.NumberFormat('vi-VN').format(appliedDiscount) + ' ₫');
                let finalOnLoad = Math.max(0, originalTotal - appliedDiscount + shippingFee);
                $('#finalTotalDisplay').text(new Intl.NumberFormat('vi-VN').format(finalOnLoad) + ' ₫');
            }
        });
    </script>
</body>

</html>