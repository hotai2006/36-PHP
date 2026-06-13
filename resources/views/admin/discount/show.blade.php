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
                        <div class="d-flex justify-content-between">
                            <h3>Table Product</h3>
                        </div>
                        <hr />
                        <!-- Bảng hiển thị danh sách người dùng -->
                        <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td scope="row">
                                        <img loading="lazy"
                                            src="{{ asset('products/' . $product->product_image_url) }}"
                                            class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px; overflow: hidden; display: flex;
                                           justify-content: center; align-items: center; object-fit: cover;" alt=""
                                            disabled>

                                    </td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->product_price }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDiscountModal{{$product->id}}">
                                            Add Discount
                                        </button>
                                    </td>

                                    <!-- Modal Add Discount -->
                                    <div class="modal fade" id="addDiscountModal{{$product->id}}" tabindex="-1" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title">Add Discount for {{ $product->product_name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <form method="post" action="{{ url('/admin/discount/create/' . $product->id) }}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Discount Percent (%)</label>
                                                    <input type="number" name="discount_percent" class="form-control" required min="1" max="100">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Start Date</label>
                                                    <input type="date" name="start_date" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">End Date</label>
                                                    <input type="date" name="end_date" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Status</label>
                                                    <select name="status" class="form-select">
                                                        <option value="1">Active</option>
                                                        <option value="0">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $products->links('pagination::bootstrap-4') }}
                        </div>
                    </div>

                    <div class="col-11 mx-auto mt-4">
                        <div class="d-flex justify-content-between">
                            <h3>Product Discount</h3>
                        </div>
                        <hr />
                        <!-- Bảng hiển thị danh sách người dùng -->
                        <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">% Discount</th>
                                    <th scope="col">Price After</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productsDiscounts as $productDiscount)
                                <tr>
                                    <td>{{ $productDiscount->id }}</td>
                                    <td scope="row">
                                        <img loading="lazy"
                                            src="{{ asset('products/' . $productDiscount->product->product_image_url) }}"
                                            class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px; overflow: hidden; display: flex;
                                           justify-content: center; align-items: center; object-fit: cover;" alt=""
                                            disabled>

                                    </td>
                                    <td>{{ $productDiscount->product->product_name }}</td>
                                    <td>{{ $productDiscount->product->product_price }}</td>
                                    <td>{{ $productDiscount->discount_percent }}%</td>
                                    <td class="text-danger fw-bold">
                                        {{ number_format($productDiscount->product->product_price - ($productDiscount->product->product_price * $productDiscount->discount_percent / 100), 0, ',', '.') }} VNĐ
                                    </td>
                                    <td>
                                        <a href="{{ url('/admin/discount/productdiscount/' . $productDiscount->id) }}"
                                            class="btn btn-success">View</a>
                                        <a href="{{ url('/admin/discount/update/' . $productDiscount->id) }}"
                                            class="btn btn-warning mx-2">Update</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-3">
                            {{ $productsDiscounts->links('pagination::bootstrap-4') }}
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