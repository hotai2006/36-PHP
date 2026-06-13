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
            
                    <main>
                        <div class="container-fluid px-4">
                            <div class="d-flex justify-content-between align-items-center flex-wrap mt-4 mb-2">
                                <h1 class="mb-0">Dashboard</h1>
                                <div class="btn-group" role="group" aria-label="Date Range Filter" style="box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                                    <a href="?range=1" class="btn btn-outline-primary btn-sm px-3 fw-semibold {{ $range == 1 ? 'active' : '' }}">1 Ngày</a>
                                    <a href="?range=7" class="btn btn-outline-primary btn-sm px-3 fw-semibold {{ $range == 7 ? 'active' : '' }}">7 Ngày</a>
                                    <a href="?range=30" class="btn btn-outline-primary btn-sm px-3 fw-semibold {{ $range == 30 ? 'active' : '' }}">30 Ngày</a>
                                </div>
                            </div>
                            <ol class="breadcrumb mb-4">
                                <li class="breadcrumb-item active">Thống kê dữ liệu của {{ $range }} ngày gần nhất</li>
                            </ol>
                            <div class="row">
                                <div class="col-xl-4 col-md-6">
                                    <div class="card bg-primary text-white mb-4">
                                        <div class="card-body">Số lượng User mới @auth
                                            {{ $userCount }} @endauth </div> 
                                        <div class="card-footer d-flex align-items-center justify-content-between">
                                            <a class="small text-white stretched-link" href="/admin/user">View
                                                Details</a>
                                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="card bg-danger text-white mb-4">
                                        <div class="card-body">Tổng số lượng Product @auth
                                            {{ $productCount }} @endauth </div>
                                        <div class="card-footer d-flex align-items-center justify-content-between">
                                            <a class="small text-white stretched-link" href="/admin/product">View
                                                Details</a>
                                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="card bg-success text-white mb-4">
                                        <div class="card-body">Số lượng Order mới @auth
                                            {{ $orderCount }} @endauth </div>
                                        <div class="card-footer d-flex align-items-center justify-content-between">
                                            <a class="small text-white stretched-link" href="/admin/order">View
                                                Details</a>
                                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <i class="fas fa-chart-area me-1"></i>
                                                Tông quan doanh thu {{ $chartTitleSuffix }}
                                            </div>
                                            <div class="card-body"><canvas id="myAreaChart" width="100%" height="60"></canvas></div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <i class="fas fa-chart-bar me-1"></i>
                                                Tông quan đơn hàng {{ $chartTitleSuffix }}
                                            </div>
                                            <div class="card-body"><canvas id="myBarChart" width="100%" height="60"></canvas></div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>


                        </div>
                    </main>
                @include('admin.layout.footer')
        </div>


    </div>
    <script>
        const orderMonthlyData = @json($orderCountByYear);
        const monthlyRevenue = @json($revenueByYear);
        
        const chartLabels = @json($chartLabels);
        const chartOrderCompleted = @json($chartOrderCompleted);
        const chartOrderIncomplete = @json($chartOrderIncomplete);
        const chartOrderCancelled = @json($chartOrderCancelled);
        const chartRevenueCompleted = @json($chartRevenueCompleted);
        const chartRevenueIncomplete = @json($chartRevenueIncomplete);
        const chartRevenueCancelled = @json($chartRevenueCancelled);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/chart-area-demo.js') }}"></script>
    <script src="{{ asset('js/chart-bar.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
</body>

</html>