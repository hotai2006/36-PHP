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

    <style>
        /* Premium Table & Card Styles */
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
            border-bottom: 1px solid #eee;
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
        .card {
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08) !important;
        }
        .product-img-tracking {
            width: 50px !important;
            height: 50px !important;
            object-fit: cover;
            border-radius: 6px !important;
            border: 1px solid #eee;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 700;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .status-badge.pending {
            background: #fff3cd;
            color: #856404;
        }
        .status-badge.confirmed {
            background: #f3e8ff;
            color: #7e22ce;
        }
        .status-badge.shipping {
            background: #cce5ff;
            color: #004085;
        }
        .status-badge.complete {
            background: #d4edda;
            color: #155724;
        }
        .status-badge.cancel {
            background: #f8d7da;
            color: #721c24;
        }
        .cancel-btn {
            background: #dc3545;
            color: #fff;
            border: none;
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .cancel-btn:hover {
            background: #c82333;
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(220, 53, 69, 0.2);
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(85, 82, 82, 0.5);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal-content {
            background: #fff;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 20px;
            border-bottom: 1px solid #dee2e6;
        }
        .modal-header h5 {
            margin: 0;
            color: #dc3545;
            font-weight: 700;
        }
        .close-btn {
            background: none;
            border: none;
            font-size: 24px;
            color: #6c757d;
            cursor: pointer;
        }
        .close-btn:hover { color: #dc3545; }
        .modal-body { padding: 16px 20px; }
        .modal-footer {
            padding: 12px 20px;
            border-top: 1px solid #dee2e6;
            display: flex;
            justify-content: flex-end;
            gap: 8px;
        }
        .reason-item {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            padding: 8px 12px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 6px;
        }
        .reason-item:hover {
            background: #f8f9fa;
        }
        .reason-item input[type="checkbox"] {
            margin-top: 3px;
            accent-color: #dc3545;
        }

        /* Toast */
        .toast-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
            padding: 12px 20px;
            border-radius: 6px;
            color: #fff;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .toast-notification.success { background: #28a745; }
        .toast-notification.error { background: #dc3545; }
    </style>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const openBtn = document.getElementById("openbuttonUpdatedform");
        const closeBtn = document.getElementById("closebuttonUpdatedform");
        const form = document.getElementById("formupdateuser");

        openBtn.addEventListener("click", function() {
            form.style.display = "block";
            openBtn.style.display = "none";
            closeBtn.style.display = "inline-block";
        });

        closeBtn.addEventListener("click", function() {
            form.style.display = "none";
            openBtn.style.display = "inline-block";
            closeBtn.style.display = "none";
        });

        const avatarFile = document.getElementById("avatarFile");
        const avatarPreview = document.getElementById("avatarPreview");

        avatarFile.addEventListener("change", function(e) {
            const imgURL = URL.createObjectURL(e.target.files[0]);
            avatarPreview.src = imgURL;
            avatarPreview.style.display = "block";
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




    <!-- Single Product Start -->
    <div style="max-width: 1100px; margin-left: auto; margin-right: auto;" class="container-fluid py-4 client-content-container">
        <div class="container py-2">
            <div class="mb-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Lịch sử mua hàng</li>
                    </ol>
                </nav>
            </div>

            @if ($orders == null || $orders->isEmpty())
                <div class="text-center py-5 text-muted bg-light rounded-3 border">
                    <i class="fas fa-box-open fa-3x d-block mb-3 text-secondary"></i>
                    <h5 class="fw-bold">Không có đơn hàng nào được tạo</h5>
                    <p class="small text-muted mb-3">Hãy tiếp tục mua sắm để tạo đơn hàng mới nhé!</p>
                    <a href="/product" class="btn btn-primary rounded-pill px-4 py-2" style="font-size: 13px; font-weight: 600;">Đến cửa hàng</a>
                </div>
            @else
                @foreach ($orders as $order)
                    <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4" style="border: 1px solid rgba(0, 0, 0, 0.08) !important; background-color: #fff;">
                        <!-- Card Header: Mã đơn hàng & Thao tác chính -->
                        <div class="card-header bg-light d-flex justify-content-between align-items-center py-2 px-3 border-bottom" style="border-bottom: 1px solid rgba(0, 0, 0, 0.08) !important;">
                            <div>
                                <span class="fw-bold text-secondary me-2" style="font-size: 0.9rem;">Đơn hàng #{{ $order->id }}</span>
                                <span class="text-muted small" style="font-size: 0.8rem;">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="status-badge {{ $order->order_status }}">
                                    @switch($order->order_status)
                                        @case('pending') Chờ xử lý @break
                                        @case('confirmed') Chờ lấy hàng @break
                                        @case('shipping') Đang giao @break
                                        @case('complete') Hoàn thành @break
                                        @case('cancel') Đã hủy @break
                                        @default {{ $order->order_status }}
                                    @endswitch
                                </span>
                                @if($order->order_status == 'pending')
                                    <button type="button" class="cancel-btn d-flex align-items-center gap-1" data-order-id="{{ $order->id }}">
                                        <i class="fas fa-times-circle"></i> Hủy đơn
                                    </button>
                                @endif
                            </div>
                        </div>

                        <!-- Table of Order Details -->
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

                        <!-- Card Footer: Tổng tiền & Nút xem chi tiết theo dõi -->
                        <div class="bg-light p-2 px-3 border-top d-flex justify-content-between align-items-center" style="border-top: 1px solid rgba(0, 0, 0, 0.08) !important;">
                            <a href="{{ route('track', ['id' => $order->id]) }}" class="btn btn-outline-primary py-1 px-3 rounded-pill d-flex align-items-center gap-1" style="font-size: 12px; font-weight: 600;">
                                <i class="fas fa-truck" style="font-size: 11px;"></i> Theo dõi đơn hàng
                            </a>
                            <span class="fw-bold text-primary" style="font-size: 0.9rem;">
                                Tổng thanh toán: {{ number_format($order->total_price, 0, ',', '.') }} đ
                            </span>
                        </div>
                    </div>
                @endforeach
            @endif


        </div>
    </div>
    <!-- Single Product End -->


    @extends('client.layout.footer')



    <!-- Cancel Order Modal -->
    <div id="cancelModal" class="modal-overlay" style="display:none;">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Lý do hủy đơn hàng</h5>
                <button type="button" class="close-btn" id="closeModalBtn">&times;</button>
            </div>
            <form id="cancelForm">
                @csrf
                <input type="hidden" name="order_id" id="cancelOrderId" value="">
                <div class="modal-body">
                    <p class="text-muted mb-3">Vui lòng chọn lý do hủy đơn hàng:</p>
                    <div class="cancel-reasons">
                        <label class="reason-item">
                            <input type="checkbox" name="reasons[]" value="Thay đổi địa chỉ giao hàng">
                            <span>Thay đổi địa chỉ giao hàng</span>
                        </label>
                        <label class="reason-item">
                            <input type="checkbox" name="reasons[]" value="Thay đổi số điện thoại nhận hàng">
                            <span>Thay đổi số điện thoại nhận hàng</span>
                        </label>
                        <label class="reason-item">
                            <input type="checkbox" name="reasons[]" value="Muốn thay đổi màu sắc/kích thước/phân loại sản phẩm">
                            <span>Muốn thay đổi màu sắc/kích thước/phân loại sản phẩm</span>
                        </label>
                        <label class="reason-item">
                            <input type="checkbox" name="reasons[]" value="Quên áp mã giảm giá (Mã miễn phí vận chuyển, Voucher của Shop...)">
                            <span>Quên áp mã giảm giá (Mã miễn phí vận chuyển, Voucher của Shop...)</span>
                        </label>
                        <label class="reason-item">
                            <input type="checkbox" name="reasons[]" value="Tìm thấy chỗ khác bán giá rẻ hơn/tốt hơn">
                            <span>Tìm thấy chỗ khác bán giá rẻ hơn/tốt hơn</span>
                        </label>
                        <label class="reason-item">
                            <input type="checkbox" name="reasons[]" value="Không còn nhu cầu mua sản phẩm này nữa">
                            <span>Không còn nhu cầu mua sản phẩm này nữa</span>
                        </label>
                        <label class="reason-item">
                            <input type="checkbox" name="reasons[]" value="Đặt trùng đơn (bấm nhầm thành 2, 3 đơn giống nhau)">
                            <span>Đặt trùng đơn (bấm nhầm thành 2, 3 đơn giống nhau)</span>
                        </label>
                    </div>
                    <div class="mt-3">
                        <label for="otherReason" class="fw-semibold">Lý do khác:</label>
                        <textarea id="otherReason" name="other_reason" class="form-control" rows="2" placeholder="Nhập lý do khác..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cancelModalBtn">Đóng</button>
                    <button type="submit" class="btn btn-danger">Xác nhận hủy đơn</button>
                </div>
            </form>
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
    <script>
    $(document).ready(function() {
        $('form').on('submit', function(e) {
            let rating = $('input[name="radio-sort"]:checked').val();
            $('#rating-hidden').val(rating);
            console.log("Đánh giá được chọn là: " + rating);
        });
    });
    </script>

    <script>
    $(document).ready(function() {
        let currentOrderId = null;

        $('.cancel-btn').on('click', function() {
            currentOrderId = $(this).data('order-id');
            $('#cancelOrderId').val(currentOrderId);
            $('#cancelModal').fadeIn(200);
        });

        function closeModal() {
            $('#cancelModal').fadeOut(200);
        }

        $('#closeModalBtn').on('click', closeModal);
        $('#cancelModalBtn').on('click', closeModal);

        $('#cancelModal').on('click', function(e) {
            if ($(e.target).is('#cancelModal')) {
                closeModal();
            }
        });

        $('#cancelForm').on('submit', function(e) {
            e.preventDefault();

            let reasons = [];
            $('input[name="reasons[]"]:checked').each(function() {
                reasons.push($(this).val());
            });

            let otherReason = $('#otherReason').val().trim();
            if (otherReason) {
                reasons.push(otherReason);
            }

            if (reasons.length === 0) {
                showToast('Vui lòng chọn ít nhất một lý do hủy đơn hàng.', 'error');
                return;
            }

            let submitBtn = $(this).find('button[type="submit"]');
            submitBtn.prop('disabled', true).text('Đang xử lý...');

            $.ajax({
                url: '/cancel-order/' + currentOrderId,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    reason: reasons.join('; ')
                },
                success: function(response) {
                    if (response.success) {
                        showToast(response.message, 'success');
                        closeModal();
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        showToast(response.message, 'error');
                        submitBtn.prop('disabled', false).text('Xác nhận hủy đơn');
                    }
                },
                error: function() {
                    showToast('Đã có lỗi xảy ra. Vui lòng thử lại sau.', 'error');
                    submitBtn.prop('disabled', false).text('Xác nhận hủy đơn');
                }
            });
        });

        function showToast(message, type) {
            $('.toast-notification').remove();
            let toast = $('<div class="toast-notification ' + type + '">' + message + '</div>');
            $('body').append(toast);
            setTimeout(function() {
                toast.fadeOut(400, function() { $(this).remove(); });
            }, 4000);
        }
    });
    </script>
</body>

</html>
