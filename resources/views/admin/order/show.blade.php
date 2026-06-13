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
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                            <a href="/admin/order" class="text-decoration-none text-dark mb-2 mb-md-0">
                                <h3 class="fw-bold mb-0">Table Order</h3>
                            </a>
                            <form method="GET" action="{{ route('admin.orders') }}" class="d-flex flex-wrap gap-2 align-items-center">
                                <input type="text" name="search" value="{{ request()->input('search') }}"
                                    class="form-control" style="width: 250px;" placeholder="Tìm theo tên hoặc mã đơn..." />
                                <div class="d-flex align-items-center gap-2">
                                    <label class="mb-0 text-nowrap fw-bold">Từ:</label>
                                    <input type="date" name="from_date" value="{{ request()->input('from_date') }}" class="form-control w-auto" />
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <label class="mb-0 text-nowrap fw-bold">Đến:</label>
                                    <input type="date" name="to_date" value="{{ request()->input('to_date') }}" class="form-control w-auto" />
                                </div>
                                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                            </form>
                        </div>
                        <hr />
                        
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
                        <!-- Bảng hiển thị danh sách đơn hàng -->
                        <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">ID</th>
                                    <th scope="col">Total Price</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                <tr>
                                    <td>{{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}</td>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ number_format($order->total_price, 0, ',', '.') }} đ</td>
                                    <td>{{ $order->receiver_address }}</td>
                                    <td>{{ $order->receiver_name }}</td>
                                    <td>
                                        @if ($order->order_status === 'pending')
                                        <span class="badge"
                                            style="background: linear-gradient(45deg, #FFC107, #FFD54F); color: #000; font-weight: bold; padding: 5px 10px; border-radius: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                                            Pending
                                        </span>
                                        @elseif ($order->order_status === 'confirmed')
                                        <span class="badge"
                                            style="background: linear-gradient(45deg, #9C27B0, #E040FB); color: #fff; font-weight: bold; padding: 5px 10px; border-radius: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                                            Waiting Shipper
                                        </span>
                                        @elseif ($order->order_status === 'complete')
                                        <span class="badge"
                                            style="background: linear-gradient(45deg, #4CAF50, #81C784); color: #fff; font-weight: bold; padding: 5px 10px; border-radius: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                                            Complete
                                        </span>
                                        @elseif ($order->order_status === 'shipping')
                                        <span class="badge"
                                            style="background: linear-gradient(45deg, #2196F3, #64B5F6); color: #fff; font-weight: bold; padding: 5px 10px; border-radius: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                                            Shipping
                                        </span>
                                        @elseif ($order->order_status === 'cancel')
                                        <span class="badge"
                                            style="background: linear-gradient(45deg, #F44336, #E57373); color: #fff; font-weight: bold; padding: 5px 10px; border-radius: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                                            Cancel
                                        </span>
                                        @else
                                        <span class="badge"
                                            style="background: linear-gradient(45deg, #757575, #BDBDBD); color: #fff; font-weight: bold; padding: 5px 10px; border-radius: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                                            Unknown
                                        </span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ url('/admin/order/' . $order->id) }}"
                                            class="btn btn-success">View</a>
                                        <a href="{{ url('/admin/order/update/' . $order->id) }}"
                                            class="btn btn-warning mx-2">Update</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $orders->appends(['search' => request()->input('search'), 'from_date' => request()->input('from_date'), 'to_date' => request()->input('to_date')])->links('pagination::bootstrap-4') }}
                        </div>
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