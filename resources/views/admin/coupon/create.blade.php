<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Thêm Mã giảm giá</title>
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
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="fw-bold">Thêm mã giảm giá mới</h3>
                    <a href="{{ url('/admin/coupon') }}" class="btn btn-secondary">Quay lại</a>
                </div>
                <hr />
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ url('/admin/coupon/create') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mã giảm giá <span class="text-danger">*</span></label>
                            <input type="text" name="code" class="form-control" required value="{{ old('code') }}" style="text-transform:uppercase">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Loại giảm giá <span class="text-danger">*</span></label>
                            <select name="type" class="form-select" required>
                                <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Giảm tiền mặt (VNĐ)</option>
                                <option value="percent" {{ old('type') == 'percent' ? 'selected' : '' }}>Giảm theo phần trăm (%)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Giá trị giảm <span class="text-danger">*</span></label>
                            <input type="number" name="value" class="form-control" required min="1" value="{{ old('value') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Đơn hàng tối thiểu (VNĐ)</label>
                            <input type="number" name="min_order_amount" class="form-control" min="0" value="{{ old('min_order_amount', 0) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Số lượt sử dụng tối đa</label>
                            <input type="number" name="usage_limit" class="form-control" min="1" value="{{ old('usage_limit') }}" placeholder="Để trống nếu không giới hạn">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Trạng thái</label>
                            <select name="status" class="form-select">
                                <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Kích hoạt</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Khóa</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ngày bắt đầu</label>
                            <input type="datetime-local" name="start_date" class="form-control" value="{{ old('start_date') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ngày kết thúc</label>
                            <input type="datetime-local" name="end_date" class="form-control" value="{{ old('end_date') }}">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary mt-3">Thêm mã giảm giá</button>
                </form>
            </div>

            @include('admin.layout.footer')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
</body>

</html>
