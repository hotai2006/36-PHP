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

                        <h1 class="mt-4">Update Order</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active"><a href="/admin">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="/admin/order">Order</a></li>
                            <li class="breadcrumb-item active">Update</li>
                        </ol>
                        @if(is_null($orders))
                        <div class="alert alert-danger">
                            Không tìm thấy sản phẩm hoặc đã xảy ra lỗi.
                        </div>
                        @else
                        
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-1"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <form method="post" action="/admin/order/update/{{$orders->id}}" enctype="multipart/form-data"
                            class="row g-3 p-3">
                            @csrf
                            <div class="col-md-6">
                                <label for="user_email" class="form-label">name:</label>
                                <input type="email" class="form-control @error('user_email') is-invalid @enderror"
                                    value="{{ $orders->receiver_name }}" disabled>

                            </div>

                            <div class="col-md-6">
                                <label for="user_phone" class="form-label">Phone number:</label>
                                <input type="text" class="form-control" value="{{ $orders->receiver_phone }}" disabled>
                            </div>

                            <div class="col-md-6">
                                <label for="user_name" class="form-label">payment:</label>
                                <input type="text" class="form-control" value="{{ $orders->payment_method }}" disabled>
                            </div>

                            <div class="col-md-12">
                                <label for="user_address" class="form-label">Address:</label>
                                <input type="text" class="form-control" value="{{ $orders->receiver_address }}"
                                    disabled>
                            </div>

                            <div class="col-md-6">
                                <label for="order_status" class="form-label">Trạng thái đơn hàng:</label>
                                <select class="form-select" id="order_status" name="order_status">
                                    <option value="pending" {{ $orders->order_status == 'pending' ? 'selected' : '' }}>
                                        PENDING (Chờ xác nhận)</option>
                                    <option value="confirmed" {{ $orders->order_status == 'confirmed' ? 'selected' : '' }}>
                                        CONFIRMED (Chờ shipper lấy)</option>
                                    <option value="shipping" {{ $orders->order_status == 'shipping' ? 'selected' : '' }}>
                                        SHIPPING (Đang giao hàng)</option>
                                    <option value="complete" {{ $orders->order_status == 'complete' ? 'selected' : '' }}>
                                        COMPLETE (Đã giao thành công)</option>
                                    <option value="cancel" {{ $orders->order_status == 'cancel' ? 'selected' : '' }}>
                                        CANCEL (Đã hủy)</option>
                                </select>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="card bg-light border-0 p-3">
                                    <h6 class="fw-bold text-dark"><i class="fas fa-tasks me-2 text-primary"></i>Xử lý đơn hàng từng bước:</h6>
                                    <div class="d-flex flex-wrap gap-2 mt-2">
                                        @if($orders->order_status == 'pending')
                                            @if(auth()->user()->role_id == 1)
                                            <button type="button" class="btn btn-primary btn-sm px-3 py-2" onclick="setOrderStatus('confirmed')">
                                                <i class="fas fa-check me-1"></i> 1. Xác nhận đơn hàng (Chờ shipper lấy)
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm px-3 py-2" onclick="setOrderStatus('cancel')">
                                                <i class="fas fa-times me-1"></i> Hủy đơn hàng
                                            </button>
                                            @else
                                            <div class="text-muted small"><i class="fas fa-info-circle me-1"></i> Chờ Admin duyệt đơn hàng trước khi shipper có thể lấy hàng.</div>
                                            @endif
                                        @elseif($orders->order_status == 'confirmed')
                                            @if(auth()->user()->role_id == 2)
                                                <button type="button" class="btn btn-warning text-dark btn-sm px-3 py-2" onclick="setOrderStatus('shipping')">
                                                    <i class="fas fa-truck-loading me-1"></i> 2. Shipper đã lấy hàng & Đang giao hàng
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-warning text-dark btn-sm px-3 py-2" disabled title="Chỉ shipper mới có quyền xác nhận bước này">
                                                    <i class="fas fa-lock me-1"></i> 2. Chờ shipper xác nhận lấy hàng & đi giao
                                                </button>
                                                <div class="text-muted small mt-1 w-100"><i class="fas fa-info-circle me-1"></i> Chỉ người dùng có vai trò Shipper (Role 2) mới có quyền bấm xác nhận đã lấy hàng.</div>
                                            @endif
                                            
                                            @if(auth()->user()->role_id == 1)
                                            <button type="button" class="btn btn-danger btn-sm px-3 py-2 ms-2" onclick="setOrderStatus('cancel')">
                                                <i class="fas fa-times me-1"></i> Hủy đơn hàng
                                            </button>
                                            @endif
                                        @elseif($orders->order_status == 'shipping')
                                            @if(auth()->user()->role_id == 2)
                                            <div class="mb-3 w-100">
                                                <label for="delivery_image_file" class="form-label fw-bold text-danger"><i class="fas fa-camera me-1"></i> Tải lên ảnh bằng chứng giao hàng (Bắt buộc):</label>
                                                <input type="file" class="form-control" id="delivery_image_file" name="delivery_image" accept="image/*" required>
                                                <div class="form-text text-muted">Vui lòng chụp ảnh người nhận hoặc gói hàng tại điểm giao để làm đối chứng.</div>
                                            </div>
                                            @endif

                                            <button type="button" class="btn btn-success btn-sm px-3 py-2" onclick="setOrderStatus('complete')">
                                                <i class="fas fa-user-check me-1"></i> 3. Xác nhận đã giao hàng thành công
                                            </button>
                                            
                                            @if(auth()->user()->role_id == 1)
                                            <button type="button" class="btn btn-danger btn-sm px-3 py-2 ms-2" onclick="setOrderStatus('cancel')">
                                                <i class="fas fa-times me-1"></i> Hủy đơn hàng
                                            </button>
                                            @endif
                                        @elseif($orders->order_status == 'complete')
                                            <div class="alert alert-success d-flex align-items-center gap-2 mb-0 py-2 w-100">
                                                <i class="fas fa-check-circle fs-5"></i>
                                                <span>Đơn hàng đã hoàn thành xuất sắc!</span>
                                            </div>
                                        @elseif($orders->order_status == 'cancel')
                                            <div class="alert alert-danger d-flex align-items-center gap-2 mb-0 py-2 w-100">
                                                <i class="fas fa-times-circle fs-5"></i>
                                                <span>Đơn hàng này đã bị hủy.</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if($orders->delivery_image)
                            <div class="col-md-12 mt-3">
                                <label class="form-label fw-bold text-success"><i class="fas fa-image me-1"></i> Ảnh đối chứng giao hàng:</label>
                                <div>
                                    <img src="{{ asset('deliveries/' . $orders->delivery_image) }}" alt="Bằng chứng giao hàng" class="img-thumbnail" style="max-width: 400px; max-height: 400px; object-fit: contain;">
                                </div>
                            </div>
                            @endif

                            <script>
                            function setOrderStatus(status) {
                                if (status === 'complete' && {{ auth()->check() ? auth()->user()->role_id : 0 }} === 2) {
                                    const imgInput = document.getElementById('delivery_image_file');
                                    if (imgInput && !imgInput.value) {
                                        alert('Bắt buộc phải tải lên ảnh giao hàng thành công làm bằng chứng!');
                                        imgInput.focus();
                                        return;
                                    }
                                }
                                document.getElementById('order_status').value = status;
                                document.getElementById('order_status').closest('form').submit();
                            }
                            </script>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-warning">Lưu thay đổi</button>
                            </div>
                        </form>
                        <!-- Bảng hiển thị danh sách người dùng -->
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Sản phẩm</th>
                                    <th scope="col">Tên</th>
                                    <th scope="col">Giá cả</th>
                                    <th scope="col">Số lượng</th>
                                    <th scope="col">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($orders->orderDetails as $orderDetail)
                                <tr>
                                    <th scope="row">

                                        <img loading="lazy"
                                            src="{{ asset('products/' . $orderDetail->product->product_image_url) }}"
                                            class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px; overflow: hidden; display: flex;
                                           justify-content: center; align-items: center; object-fit: cover;" alt=""
                                            disabled>

                                    </th>
                                    <td>
                                        <p class="mb-0 mt-4">
                                            {{ $orderDetail->product->product_name }}
                                            </a>
                                        </p>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4">
                                            {{ number_format($orderDetail->price) }} đ
                                        </p>
                                    </td>
                                    <td>
                                        <div class="input-group quantity mt-4" style="width: 100px;">
                                            <input type="text" class="form-control form-control-sm text-center border-0"
                                                value="{{ $orderDetail->quantity }}" disabled>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4" data-cart-detail-id="{{ $orderDetail->id }}" disabled>
                                            {{ number_format($orderDetail->price * $orderDetail->quantity) }} đ
                                        </p>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
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