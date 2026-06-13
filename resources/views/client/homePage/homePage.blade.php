<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>T-Sports</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="sports, apparel, clothing, athletic" name="keywords">
    <meta content="T-Sports - Quần áo thể thao cao cấp" name="description">
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
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .pagination .page-item:hover .page-link {
            background-color: #f0f0f0;
            color: #007bff;
        }

        .product-discount-card {
            transition: transform 0.3s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.3s cubic-bezier(0.165, 0.84, 0.44, 1), background-color 0.3s ease;
            cursor: pointer;
            border: 1px solid transparent;
        }

        .product-discount-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
            background-color: #ffffff !important;
            border-color: #eaeaea;
        }

        .product-discount-card:hover .product-title {
            color: #d94140 !important;
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





    <!-- Hero Start -->
    <div class="container-fluid py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-md-12 col-lg-7">
                    <h4 class="mb-3 text-secondary">Bứt phá cùng T-Sports</h4>
                    <h1 class="mb-5 display-3 text-primary">Đánh thức bản lĩnh nhà vô địch <i class="fas fa-trophy"></i></h1>
                    <div class="position-relative mx-auto">
                    </div>
                </div>
                <div class="col-md-12 col-lg-5">
                    <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active rounded">
                                <img src="https://images.unsplash.com/photo-1461896836934-ffe607ba8211" class="img-fluid w-100 h-100 bg-secondary rounded"
                                    alt="Red Sports">
                                <a href="#" class="btn px-4 py-2 text-white rounded">Apparel</a>
                            </div>
                            <div class="carousel-item rounded">
                                <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff" class="img-fluid w-100 h-100 rounded"
                                    alt="Red Shoes">
                                <a href="#" class="btn px-4 py-2 text-white rounded">Shoes</a>
                            </div>
                            
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselId"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselId"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->



    <!-- Sports Shop Start-->
    <div class="container-fluid fruite">
        <div class="container py-5">
            <div class="tab-class text-center">
                <div class="row g-4">
                    <div class="col-lg-4 text-start">
                        <h1 style="font-size: 1.5rem; min-width: 0;">Tất cả sản phẩm thể thao</h1>
                    </div>
                    <div class="col-lg-8 text-end">
                        <ul class="nav nav-pills d-inline-flex text-center mb-5">
                            <li class="nav-item">
                                <a class="d-flex m-2 py-2 bg-light rounded-pill active" data-bs-toggle="pill"
                                    href="#tab-1">
                                    <span class="text-dark" style="width: 130px;">All Sports Products</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">
                                    @foreach ($products as $product)
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="position-relative fruite-item">
                                                @php
                                                    $isFav = session()->has('user_id') && \App\Models\Favorite::where('user_id', session('user_id'))->where('product_id', $product->id)->exists();
                                                @endphp
                                                <a href="/product/{{ $product->id }}">
                                                    <div class="fruite-img">
                                                        <img loading="lazy"
                                                            src="{{ asset('products/' . $product->product_image_url) }}"
                                                            class="img-fluid w-100" alt="">
                                                    </div>
                                                </a>
                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                    style="top: 10px; left: 10px;">{{ $product->product_factory }}</div>
                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <h4 style="font-size: 15px;">
                                                        <a href="/product/{{ $product->id }}"
                                                            class="text-decoration-none text-dark">
                                                            {{ $product->product_name }}
                                                        </a>
                                                    </h4>
                                                    <p style="font-size: 13px;">{{ $product->product_shortDesc }}</p>
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
                                                                <x-add-to-cart-button :product-id="$product->id"/>
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
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
            <div class="d-flex justify-content-center">
                {{ $products->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
    <!-- Sports Shop End-->



    <!-- Vesitable Shop Start-->
    <div class="container-fluid vesitable">
        <div class="container py-5">
            <h1 class="mb-0">Tất cả sản phẩm</h1>
            <div class="owl-carousel vegetable-carousel justify-content-center">
                @foreach ($allproduct as $product)
                    <div class="border border-primary position-relative vesitable-item">
                        @php
                            $isFav = session()->has('user_id') && \App\Models\Favorite::where('user_id', session('user_id'))->where('product_id', $product->id)->exists();
                        @endphp
                        <a href="/product/{{ $product->id }}">
                            <div class="vesitable-img">
                                <img src="{{ asset('products/' . $product->product_image_url) }}"
                                    class="img-fluid w-100" alt="">
                            </div>
                        </a>
                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute"
                                style="top: 10px; right: 10px;">{{ $product->product_factory }}</div>
                        <div class="p-4 rounded-bottom">
                            <h4>
                                <a href="/product/{{ $product->id }}" class="text-decoration-none text-dark">
                                    {{ $product->product_name }}
                                </a>
                            </h4>
                            <p>{{ $product->product_shortDesc }}</p>
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
                @endforeach
            </div>
        </div>
    </div>
    <!-- Vesitable Shop End -->



    <!-- Bestsaler Product Start -->
    <div class="container-fluid">
        <div class="container py-5">
            <div class="text-center mx-auto mb-5" style="max-width: 700px;">
                <h1 class="display-4">Sảm phẩm giảm giá</h1>
                <p style="color: red; font-size: 20px;">Sản phẩm chỉ được giảm giá khi mua trực tiếp tại
                    cửa hàng</p>
            </div>
            <div class="row g-4">
                @foreach ($productDiscounts as $productDiscount)
                    <div class="col-lg-6 col-xl-4">
                        <div class="p-4 rounded bg-light position-relative h-100 product-discount-card">
                            @php
                                $isFav = session()->has('user_id') && \App\Models\Favorite::where('user_id', session('user_id'))->where('product_id', $productDiscount->product->id)->exists();
                            @endphp
                            <div class="row align-items-center h-100">
                                <div class="col-6 position-relative">
                                    <a href="/product/{{ $productDiscount->product->id }}" class="position-relative d-inline-block" style="z-index: 2;">
                                        <img src="{{ asset('products/' . $productDiscount->product->product_image_url) }}"
                                            style="object-fit: cover; height: 140px; width: 140px;"
                                            class="img-fluid rounded-circle" alt="" />
                                    </a>
                                    <span style="font-size: 20px; z-index: 2;"
                                        class="rounded-sm badge bg-danger position-absolute top-0 start-0 translate-middle-y">
                                        -{{ number_format($productDiscount->discount_percent, 0) }}%
                                    </span>
                                </div>
                                <div class="col-6">
                                    <a href="/product/{{ $productDiscount->product->id }}" class="text-decoration-none text-dark h5 stretched-link product-title">{{ $productDiscount->product->product_name }}</a>
                                    <div class="d-flex my-3">
                                        @for ($i = 1; $i <= 5; $i++) <i
                                                class="fa fa-star {{ $i <= $productDiscount->product->star ? 'text-secondary' : 'text-muted' }}">
                                            </i>
                                        @endfor
                                    </div>
                                    @php
                                        $originalPrice = $productDiscount->product->product_price;
                                        $discount = $productDiscount->discount_percent;
                                        $finalPrice = $originalPrice - ($originalPrice * $discount / 100);
                                    @endphp

                                    <div class="d-flex justify-content-between align-items-end w-100 mt-2">
                                        <div class="d-flex flex-column">
                                            <p class="text-danger fs-5 fw-bold mb-0">
                                                {{ number_format($finalPrice, 0, ',', '.') }} đ
                                            </p>
                                            <small class="text-muted text-decoration-line-through">
                                                {{ number_format($originalPrice, 0, ',', '.') }} đ
                                            </small>
                                        </div>
                                        <button class="btn btn-favorite p-0 border-0 bg-transparent mb-1 position-relative" style="z-index: 2;" data-product-id="{{ $productDiscount->product->id }}">
                                            <i class="{{ $isFav ? 'fas fa-heart text-danger' : 'far fa-heart text-muted' }}" style="font-size: 20px;"></i>
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>
            <div class="d-flex justify-content-center">
                {{ $productDiscounts->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
    <!-- Bestsaler Product End -->



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