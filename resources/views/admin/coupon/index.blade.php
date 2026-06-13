<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Quản lý Mã giảm giá</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body class="sb-nav-fixed">
    @include('admin.layout.header')

    <div id="layoutSidenav">
        @include('admin.layout.sidebar')
        <div id="layoutSidenav_content">
            
            <div class="col-11 mx-auto mt-4">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="fw-bold">Danh sách mã giảm giá</h3>
                    <a href="{{ url('/admin/coupon/create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Thêm mã mới</a>
                </div>
                <hr />
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Mã</th>
                                <th scope="col">Loại giảm</th>
                                <th scope="col">Giá trị</th>
                                <th scope="col">Đơn tối thiểu</th>
                                <th scope="col">Lượt dùng</th>
                                <th scope="col">Hạn sử dụng</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coupons as $coupon)
                                <tr>
                                    <td>{{ $coupon->id }}</td>
                                    <td><strong>{{ $coupon->code }}</strong></td>
                                    <td>{{ $coupon->type == 'percent' ? 'Giảm theo %' : 'Giảm tiền cố định' }}</td>
                                    <td>
                                        @if($coupon->type == 'percent')
                                            {{ $coupon->value }}%
                                        @else
                                            {{ number_format($coupon->value, 0, ',', '.') }} VNĐ
                                        @endif
                                    </td>
                                    <td>{{ number_format($coupon->min_order_amount, 0, ',', '.') }} VNĐ</td>
                                    <td>{{ $coupon->used_count }} / {{ $coupon->usage_limit ?? '∞' }}</td>
                                    <td>
                                        @if($coupon->end_date)
                                            {{ \Carbon\Carbon::parse($coupon->end_date)->format('d/m/Y H:i') }}
                                        @else
                                            Vĩnh viễn
                                        @endif
                                    </td>
                                    <td>
                                        @if($coupon->status)
                                            <span class="badge bg-success">Đang kích hoạt</span>
                                        @else
                                            <span class="badge bg-danger">Đã khóa</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ url('/admin/coupon/edit/' . $coupon->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                                        <form method="POST" action="{{ url('/admin/coupon/delete/' . $coupon->id) }}" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa mã này?');">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    {{ $coupons->links('pagination::bootstrap-4') }}
                </div>
            </div>

            @include('admin.layout.footer')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
</body>

</html>
