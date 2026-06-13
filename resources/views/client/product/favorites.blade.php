    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Sản phẩm yêu thích - T-Sports</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
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
        background-color: #d94140;
        color: white;
        border-color: #d94140;
    }

    .pagination .page-item:hover .page-link {
        background-color: #f0f0f0;
        color: #d94140;
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

    <!-- Favorites List Start -->
    <div class="container-fluid pt-3 pb-4 client-content-container">
        <div class="container py-3">
            <h1 class="mb-4 text-center">Sản phẩm yêu thích của bạn</h1>
            <div class="row g-4 justify-content-start">
                @if ($products->isEmpty())
                <div class="col-12 text-center py-5">
                    <div class="mb-4">
                        <i class="far fa-heart fa-4x text-muted"></i>
                    </div>
                    <h3>Danh sách yêu thích của bạn đang trống!</h3>
                    <p class="text-muted">Hãy thêm sản phẩm bạn yêu thích từ cửa hàng.</p>
                    <a href="/product" class="btn btn-primary rounded-pill px-4 py-2 mt-2 text-white">Quay lại mua sắm</a>
                </div>
                @else
                @foreach ($products as $product)
                <div class="col-md-6 col-lg-4 col-xl-3 d-flex">
                    <div class="position-relative fruite-item border border-primary rounded w-100 d-flex flex-column">
                        @php
                            $isFav = session()->has('user_id') && \App\Models\Favorite::where('user_id', session('user_id'))->where('product_id', $product->id)->exists();
                        @endphp
                        <div class="fruite-img">
                            <img src="{{ asset('products/' . $product->product_image_url) }}"
                                class="img-fluid w-100" alt=""
                                style="height: 200px; object-fit: cover;">
                        </div>
                        <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                            style="top: 10px; left: 10px;">{{ $product->product_factory }}</div>
                        <div class="p-4 border border-secondary border-top-0 rounded-bottom flex-grow-1 d-flex flex-column justify-content-between">
                            <div>
                                <h4 style="font-size: 15px;"><a href="/product/{{ $product->id }}"
                                        class="text-decoration-none text-dark">
                                        {{ $product->product_name }}
                                    </a></h4>
                                <p style="font-size: 13px;">{{ $product->product_shortDesc }}</p>
                            </div>
                            <div class="d-flex flex-column align-items-start gap-2 w-100">
                                @php
                                    $activeDiscount = \App\Models\ProductDiscount::where('product_id', $product->id)->where('status', 1)->first();
                                @endphp
                                @if($activeDiscount)
                                    @php
                                        $originalPrice = $product->product_price;
                                        $discount = $activeDiscount->discount_percent;
                                        $finalPrice = $originalPrice - ($originalPrice * $discount / 100);
                                    @endphp
                                    <div class="d-flex flex-column">
                                        <p class="text-danger fs-5 fw-bold mb-0">
                                            {{ number_format($finalPrice, 0, ',', '.') }} đ
                                        </p>
                                        <small class="text-muted text-decoration-line-through">
                                            {{ number_format($originalPrice, 0, ',', '.') }} đ
                                        </small>
                                    </div>
                                @else
                                    <p class="text-dark fs-5 fw-bold mb-0">
                                        {{ number_format($product->product_price, 0, ',', '.') }} đ
                                    </p>
                                @endif
                                <div class="d-flex align-items-center justify-content-between w-100">
                                    <div class="flex-grow-1 me-2">
                                        <x-add-to-cart-button :product-id="$product->id" />
                                    </div>
                                    <button class="btn btn-favorite p-0 border-0 bg-transparent" data-product-id="{{ $product->id }}">
                                        <i class="{{ $isFav ? 'fas fa-heart text-danger' : 'far fa-heart text-muted' }}" style="font-size: 20px;"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
            
            @if (!$products->isEmpty())
            <div class="d-flex justify-content-center">
                {{ $products->links('pagination::bootstrap-4') }}
            </div>
            @endif
        </div>
    </div>
    <!-- Favorites List End -->

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
</body>

</html>
