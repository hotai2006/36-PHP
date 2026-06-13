<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    @include('admin.layout.header')

    <div id="layoutSidenav">
        @include('admin.layout.sidebar')
        <div id="layoutSidenav_content">
            
                    <div class="col-11 mx-auto">

                        <h1 class="mt-4">Order Details</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active"><a href="/admin">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="/admin/order">Order</a></li>
                            <li class="breadcrumb-item active">View</li>
                        </ol>

                        @if(is_null($orders))
                        <div class="alert alert-danger">
                            Không tìm thấy đơn hàng hoặc đã xảy ra lỗi.
                        </div>
                        @else
                        
                        <!-- Order Header Info Card -->
                        <div class="card mb-4" style="border-left: 4px solid var(--admin-red);">
                            <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-3 py-3">
                                <div>
                                    <span class="text-muted small">Mã đơn hàng:</span>
                                    <h4 class="fw-bold mb-0 text-dark">#{{ $orders->id }}</h4>
                                </div>
                                <div class="text-md-end">
                                    <span class="text-muted small">Thời gian đặt hàng:</span>
                                    <div class="fw-semibold text-dark">{{ $orders->created_at->format('d/m/Y H:i') }}</div>
                                </div>
                                <div>
                                    <span class="text-muted small d-block">Trạng thái hiện tại:</span>
                                    @if($orders->order_status == 'pending')
                                        <span class="badge text-warning bg-warning-light" style="background-color: #fef3c7; color: #d97706; font-size: 0.85rem;">CHỜ XÁC NHẬN</span>
                                    @elseif($orders->order_status == 'confirmed')
                                        <span class="badge text-info bg-info-light" style="background-color: #f3e8ff; color: #7e22ce; font-size: 0.85rem;">CHỜ SHIPPER LẤY</span>
                                    @elseif($orders->order_status == 'shipping')
                                        <span class="badge text-primary bg-primary-light" style="background-color: #dbeafe; color: #2563eb; font-size: 0.85rem;">ĐANG GIAO HÀNG</span>
                                    @elseif($orders->order_status == 'complete')
                                        <span class="badge text-success bg-success-light" style="background-color: #d1fae5; color: #059669; font-size: 0.85rem;">ĐÃ HOÀN THÀNH</span>
                                    @elseif($orders->order_status == 'cancel')
                                        <span class="badge text-danger bg-danger-light" style="background-color: #fee2e2; color: #dc2626; font-size: 0.85rem;">ĐÃ HỦY</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Left Column: Timeline & Items -->
                            <div class="col-lg-8 col-12">
                                
                                <!-- Timeline Progress Tracker -->
                                <div class="card mb-4">
                                    <div class="card-header bg-white py-3">
                                        <h5 class="mb-0 text-dark fw-bold"><i class="fas fa-route text-primary me-2"></i>Theo Dõi Đơn Hàng</h5>
                                    </div>
                                    <div class="card-body">
                                        @if($orders->order_status == 'cancel')
                                            <div class="alert alert-danger mb-0 d-flex align-items-center gap-2">
                                                <i class="fas fa-times-circle fs-4"></i>
                                                <div>
                                                    <strong>Đơn hàng đã bị hủy.</strong>
                                                    <div class="small text-muted">Cập nhật lúc: {{ $orders->updated_at->format('d/m/Y H:i') }}</div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="row text-center justify-content-between position-relative my-4 px-3 order-tracker-steps">
                                                <!-- Line background -->
                                                <div class="position-absolute start-0" style="height: 4px; width: 100%; z-index: 1; top: 22.5px; background-color: #e9ecef;"></div>
                                                <!-- Line active progress -->
                                                <div class="position-absolute start-0" style="height: 4px; width: {{ $orders->order_status == 'pending' ? '12.5%' : ($orders->order_status == 'confirmed' ? '37.5%' : ($orders->order_status == 'shipping' ? '62.5%' : '100%')) }}; z-index: 1; transition: width 0.5s ease; top: 22.5px; background-color: #dc3545;"></div>
                                                
                                                <!-- Step 1: Pending -->
                                                <div class="col-3 position-relative" style="z-index: 2;">
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 {{ in_array($orders->order_status, ['pending', 'confirmed', 'shipping', 'complete']) ? 'bg-danger text-white' : 'bg-light text-muted' }}" style="width: 45px; height: 45px; border: 3px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                                                        <i class="fas fa-clock"></i>
                                                    </div>
                                                    <div class="fw-bold small text-dark">Chờ Xác Nhận</div>
                                                    <div class="text-muted" style="font-size: 11px;">{{ $orders->created_at->format('d/m/Y H:i') }}</div>
                                                </div>
                                                
                                                <!-- Step 2: Confirmed -->
                                                <div class="col-3 position-relative" style="z-index: 2;">
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 {{ in_array($orders->order_status, ['confirmed', 'shipping', 'complete']) ? 'bg-danger text-white' : 'bg-light text-muted' }}" style="width: 45px; height: 45px; border: 3px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                                                        <i class="fas fa-box"></i>
                                                    </div>
                                                    <div class="fw-bold small text-dark">Chờ Lấy Hàng</div>
                                                    @if(in_array($orders->order_status, ['confirmed', 'shipping', 'complete']))
                                                        <div class="text-muted" style="font-size: 11px;">{{ $orders->updated_at->format('d/m/Y H:i') }}</div>
                                                    @endif
                                                </div>
                                                
                                                <!-- Step 3: Shipping -->
                                                <div class="col-3 position-relative" style="z-index: 2;">
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 {{ in_array($orders->order_status, ['shipping', 'complete']) ? 'bg-danger text-white' : 'bg-light text-muted' }}" style="width: 45px; height: 45px; border: 3px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                                                        <i class="fas fa-shipping-fast"></i>
                                                    </div>
                                                    <div class="fw-bold small text-dark">Đang Giao Hàng</div>
                                                    @if(in_array($orders->order_status, ['shipping', 'complete']))
                                                        <div class="text-muted" style="font-size: 11px;">{{ $orders->updated_at->format('d/m/Y H:i') }}</div>
                                                    @endif
                                                </div>
                                                
                                                <!-- Step 4: Complete -->
                                                <div class="col-3 position-relative" style="z-index: 2;">
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 {{ $orders->order_status == 'complete' ? 'bg-success text-white' : 'bg-light text-muted' }}" style="width: 45px; height: 45px; border: 3px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                                                        <i class="fas fa-check-circle"></i>
                                                    </div>
                                                    <div class="fw-bold small text-dark">Đã Giao Thành Công</div>
                                                    @if($orders->order_status == 'complete')
                                                        <div class="text-muted" style="font-size: 11px;">{{ $orders->updated_at->format('d/m/Y H:i') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Items Table Card -->
                                <div class="card mb-4">
                                    <div class="card-header bg-white py-3">
                                        <h5 class="mb-0 text-dark fw-bold"><i class="fas fa-boxes text-primary me-2"></i>Danh Sách Sản Phẩm</h5>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-borderless align-middle mb-0">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th class="px-4 py-3 text-muted">Sản phẩm</th>
                                                        <th class="py-3 text-muted">Đơn giá</th>
                                                        <th class="py-3 text-muted text-center">Số lượng</th>
                                                        <th class="px-4 py-3 text-muted text-end">Thành tiền</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($orders->orderDetails as $orderDetail)
                                                    <tr>
                                                        <td class="px-4 py-3">
                                                            <div class="d-flex align-items-center gap-3">
                                                                <img src="{{ asset('products/' . $orderDetail->product->product_image_url) }}"
                                                                     class="rounded" style="width: 60px; height: 60px; object-fit: cover; border: 1px solid #eee;" alt="">
                                                                <div>
                                                                    <span class="fw-bold text-dark d-block" style="font-size: 0.95rem;">
                                                                        {{ $orderDetail->product->product_name }}
                                                                    </span>
                                                                    <small class="text-muted">Mã SP: #{{ $orderDetail->product->id }}</small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="py-3 fw-semibold text-dark">
                                                            {{ number_format($orderDetail->price, 0, ',', '.') }} đ
                                                        </td>
                                                        <td class="py-3 text-center fw-bold text-muted">
                                                            x{{ $orderDetail->quantity }}
                                                        </td>
                                                        <td class="px-4 py-3 text-end fw-bold text-danger">
                                                            {{ number_format($orderDetail->price * $orderDetail->quantity, 0, ',', '.') }} đ
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Shipping & Summary Cards -->
                            <div class="col-lg-4 col-12">
                                
                                <!-- Payment Summary Card -->
                                <div class="card mb-4" style="border-top: 4px solid var(--admin-red);">
                                    <div class="card-body">
                                        <h5 class="fw-bold text-dark mb-4"><i class="fas fa-receipt text-primary me-2"></i>Chi Tiết Thanh Toán</h5>
                                        <div class="d-flex justify-content-between mb-3">
                                            <span class="text-muted">Tổng tiền hàng (gốc):</span>
                                            <span class="fw-semibold text-dark">
                                                {{ number_format($orders->total_price + $orders->discount_amount, 0, ',', '.') }} đ
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <span class="text-muted">Số tiền giảm:</span>
                                            <span class="text-danger fw-semibold">
                                                -{{ number_format($orders->discount_amount, 0, ',', '.') }} đ
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <span class="text-muted">Phí giao hàng:</span>
                                            <span class="text-success fw-semibold">Miễn phí</span>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="fw-bold text-dark">Tổng cộng:</span>
                                            <span class="fs-4 fw-bold text-danger">
                                                {{ number_format($orders->total_price, 0, ',', '.') }} đ
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Customer & Delivery Info Card -->
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h5 class="fw-bold text-dark mb-4"><i class="fas fa-shipping-fast text-primary me-2"></i>Thông Tin Giao Hàng</h5>
                                        
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Người nhận:</small>
                                            <span class="fw-bold text-dark">{{ $orders->receiver_name }}</span>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Số điện thoại:</small>
                                            <span class="fw-semibold text-dark">{{ $orders->receiver_phone }}</span>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Địa chỉ nhận hàng:</small>
                                            <span class="text-dark d-block" style="font-size: 0.9rem; line-height: 1.4;">{{ $orders->receiver_address }}</span>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Phương thức thanh toán:</small>
                                            <span class="badge bg-light text-dark fw-bold" style="font-size: 0.8rem; border: 1px solid #ddd; padding: 5px 10px;">
                                                {{ $orders->payment_method }}
                                            </span>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block mb-1">Trạng thái thanh toán:</small>
                                            @if($orders->pay == 1)
                                                <span class="badge bg-success-light text-success fw-bold" style="background-color: #d1fae5; color: #065f46; padding: 5px 10px;">
                                                    Đã thanh toán
                                                </span>
                                            @else
                                                <span class="badge bg-warning-light text-warning fw-bold" style="background-color: #fef3c7; color: #92400e; padding: 5px 10px;">
                                                    Chưa thanh toán
                                                </span>
                                            @endif
                                        </div>
                                        @if($orders->delivery_image)
                                        <div class="mt-3 pt-3 border-top">
                                            <small class="text-muted d-block mb-1">Ảnh bằng chứng giao hàng:</small>
                                            <a href="{{ asset('deliveries/' . $orders->delivery_image) }}" target="_blank">
                                                <img src="{{ asset('deliveries/' . $orders->delivery_image) }}" alt="Ảnh giao hàng" class="img-thumbnail w-100" style="max-height: 200px; object-fit: cover;">
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <a href="/admin/order" class="btn btn-primary btn-lg"><i class="fas fa-arrow-left me-2"></i>Quay lại danh sách</a>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                @include('admin.layout.footer')
        </div>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/chart-area-demo.js') }}"></script>
    <script src="{{ asset('js/chart-bar-demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
</body>

</html>