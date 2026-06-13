<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>T-Sports</title>
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

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">


    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>

    <!-- Spinner Start -->
    <div id="spinner"
        class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->


    @extends('client.layout.header')



    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-1">
        <h3 class="text-center text-white display-8">Shop Detail</h3>
        <ol class="breadcrumb justify-content-center mb-0 ">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active text-white">Shop Detail</li>
        </ol>
    </div>
    <!-- Single Page Header End -->


    <!-- Single Product Start -->
    <div class="container-fluid py-2 mt-1">
        <div class="container py-5">
            <div class="row g-4 mb-5">
                <div class="col-lg-8 col-xl-9">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="border rounded">
                                <a href="#">
                                    <img src="{{ asset('products/' . $product->product_image_url) }}"
                                        class="img-fluid rounded" alt="Image">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h4 class="fw-bold mb-3">{{ $product->product_name }}</h4>
                            <p class="mb-3">{{ $product->product_shortDesc }}</p>
                            @php
                                $activeDiscount = \App\Models\ProductDiscount::where('product_id', $product->id)->where('status', 1)->first();
                            @endphp
                            @if($activeDiscount)
                                @php
                                    $originalPrice = $product->product_price;
                                    $discount = $activeDiscount->discount_percent;
                                    $finalPrice = $originalPrice - ($originalPrice * $discount / 100);
                                @endphp
                                <div class="mb-3">
                                    <h5 class="fw-bold text-danger d-inline-block">{{ number_format($finalPrice, 0, ',', '.') }} đ</h5>
                                    <span class="text-muted text-decoration-line-through d-inline-block ms-2">{{ number_format($originalPrice, 0, ',', '.') }} đ</span>
                                </div>
                            @else
                                <h5 class="fw-bold mb-3">{{ number_format($product->product_price, 0, ',', '.') }} đ</h5>
                            @endif
                            <div class="d-flex mb-4">
                                
                                    @for ($i = 1; $i <= 5; $i++) <i
                                        class="fa fa-star {{ $i <= $product->star ? 'text-secondary' : 'text-muted' }}">
                                        </i>
                                        @endfor
                                
                            </div>
                            <p class="mb-4">{{ $product->product_detailDesc }}.</p>

                            
                            <form class="add-to-cart-form" id="addToCartForm">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                {{-- <input type="hidden" name="quantity" value="1"> --}}
                                <div class="input-group quantity mb-5" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-minus rounded-circle bg-light border">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" name="quantity"
                                        class="form-control form-control-sm text-center border-0" value="1"
                                        id="quantityInput">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                @php
                                    $isFavMain = session()->has('user_id') && \App\Models\Favorite::where('user_id', session('user_id'))->where('product_id', $product->id)->exists();
                                @endphp
                                <div class="d-flex gap-2 w-100">
                                    <button type="button"
                                        class="btnAddToCartHomepage btn btn-primary border-0 rounded-pill px-4 py-2 text-white w-75">
                                        <i class="fa fa-shopping-bag me-2"></i> Add to cart
                                    </button>
                                    <button type="button" class="btn btn-favorite btn-outline-danger rounded-pill px-4 py-2 w-25 {{ $isFavMain ? 'btn-danger text-white' : '' }}" data-product-id="{{ $product->id }}">
                                        <i class="{{ $isFavMain ? 'fas fa-heart' : 'far fa-heart' }}"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-12">
                            <nav>
                                <div class="nav nav-tabs mb-3">
                                    <button class="nav-link border-white border-bottom-0" type="button"
                                        role="tab" id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                                        aria-controls="nav-about" aria-selected="false">Description</button>
                                    <button class="nav-link active border-white border-bottom-0" type="button" role="tab"
                                        id="nav-mission-tab" data-bs-toggle="tab" data-bs-target="#nav-mission"
                                        aria-controls="nav-mission" aria-selected="true">Reviews</button>
                                </div>
                            </nav>
                            <div class="tab-content mb-5">
                                <div class="tab-pane" id="nav-about" role="tabpanel"
                                    aria-labelledby="nav-about-tab">
                                    <p class="my-4 text-dark">{{ $product->product_detailDesc }}</p>
                                </div>
                                <div class="tab-pane active show" id="nav-mission" role="tabpanel"
                                    aria-labelledby="nav-mission-tab">
                                    @if(count($reviews) == 0)
                                        <p class="text-muted my-4">Chưa có đánh giá nào cho sản phẩm này.</p>
                                    @else
                                        @foreach ($reviews as $review)
                                            <div class="d-flex mb-4">
                                                <img src="{{ ($review->user && $review->user->user_avatar) ? asset('storage/avatars/' . $review->user->user_avatar) : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($review->user ? $review->user->user_email : 'default@example.com'))) . '?d=mp&s=100' }}"
                                                    class="img-fluid rounded-circle p-3"
                                                    style="width: 100px; height: 100px; object-fit: cover;" alt="">
                                                <div class="ms-3 flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                        <h5 class="mb-0" style="margin-right: 5px;">{{ $review->user ? $review->user->user_name : 'Người dùng ẩn danh' }}</h5>
                                                        <div class="d-flex align-items-center">
                                                            {{-- Hiển thị sao đánh giá --}}
                                                            <div class="me-2">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <i class="fa fa-star {{ $i <= $review->rating ? 'text-secondary' : 'text-muted' }}"></i>
                                                                @endfor
                                                            </div>

                                                            {{-- Chỉ admin (role_id = 1) mới thấy nút xoá --}}
                                                            @if (auth()->check() && auth()->user()->role_id == 1)
                                                                <form action="/review/delete/{{ $review->id }}" method="POST"
                                                                    class="ms-3">
                                                                    @csrf
                                                                    <input style="display: none;" type="hidden" name="productId"
                                                                        value="{{$product->id }}">
                                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                                        onclick="return confirm('Bạn có chắc muốn xóa bình luận này không?')">Xóa</button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <p class="mb-2 text-muted" style="font-size: 13px;">
                                                        <i class="far fa-clock me-1"></i>{{ $review->created_at ? $review->created_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') : '' }}
                                                    </p>
                                                    <p class="text-dark mb-0">{{ $review->comment }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (auth()->check() && $hasPurchased)
                        <form method="post" action="/confirm-comment">
                            @csrf
                            <h4 class="mb-4 fw-bold">Hãy để lại 1 bình luận</h4>
                            <div class="col-lg-12 mb-4">
                                <div class="mb-2"><b>Đánh giá</b></div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="sort-1" value="1" name="radio-sort">
                                    <label class="form-check-label" for="sort-1"><i
                                            class="fa fa-star text-secondary"></i>
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="sort-2" value="2" name="radio-sort">
                                    <label class="form-check-label" for="sort-2">
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                    </label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input type="radio" id="sort-3" value="3" name="radio-sort">
                                    <label class="form-check-label" for="sort-3">
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>

                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="sort-4" value="4" name="radio-sort">
                                    <label class="form-check-label" for="sort-4">
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>

                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="sort-5" checked value="5" name="radio-sort">
                                    <label class="form-check-label" for="sort-5">
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>

                                    </label>
                                </div>

                                <input style="display: none;" type="hidden" name="rating" id="rating-hidden" value="5">
                            </div>
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="border-bottom rounded my-4">
                                        <textarea name="description" class="form-control border-0" cols="30" rows="2"
                                            placeholder="Miêu tả của bạn *" required spellcheck="false"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div style="display: none;">
                                <input class="form-check-input" value="{{ $product->id }}" name="id">
                            </div>
                            <button type="submit" style="width: 200px;"
                                class="btn border border-secondary text-primary rounded-pill px-4 py-3">
                                Đăng bình luận
                            </button>
                        </form>
                        @elseif (!auth()->check())
                        <div class="alert alert-warning my-4">
                            Bạn cần <a href="/login" class="alert-link">đăng nhập</a> để gửi bình luận.
                        </div>
                        @else
                        <div class="alert alert-info my-4">
                            <i class="fas fa-info-circle me-1"></i> Bạn chỉ có thể đánh giá và bình luận sau khi đã mua sản phẩm này!
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4 col-xl-3">
                    <div class="row g-4 fruite">
                        <div class="col-lg-12">
                            <h4 class="mb-2">Sản phẩm giảm giá</h4>
                            <p style="color: red; font-size: 16px;">Sản phẩm chỉ được giảm giá khi mua trực tiếp tại
                                cửa hàng</p>
                            @foreach ($productDiscounts as $productDiscount)
                                <div class="d-flex align-items-center justify-content-start">
                                    <div class="rounded position-relative" style="width: 100px; height: 100px;">
                                        <img src="{{ asset('products/' . $productDiscount->product->product_image_url) }}"
                                            class="img-fluid rounded" alt="Image">
                                        <span style="font-size: 14px;"
                                            class="badge bg-danger position-absolute top-0 start-0 m-1">
                                            -{{ number_format($productDiscount->discount_percent, 0) }}%
                                        </span>
                                    </div>

                                    <div style="margin-left: 10px;">
                                        <h6 class="mb-2">{{ $productDiscount->product->product_name }}</h6>
                                        <div class="d-flex mb-2">
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
                                        <div class="d-flex flex-column mb-2">
                                            <p class="text-danger fs-5 fw-bold mb-0">
                                                {{ number_format($finalPrice, 0, ',', '.') }} đ
                                            </p>
                                            <small class="text-muted text-decoration-line-through">
                                                {{ number_format($originalPrice, 0, ',', '.') }} đ
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="d-flex justify-content-center my-4">
                                <a href="#"
                                    class="btn border border-secondary px-4 py-3 rounded-pill text-primary w-100">Vew
                                    More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h1 class="fw-bold mb-0">Tất cả sản phẩm</h1>
            <div class="vesitable">
                <div class="owl-carousel vegetable-carousel justify-content-center">
                    @foreach ($allproduct as $product)
                        <div class="border border-primary position-relative vesitable-item">
                            @php
                                $isFav = session()->has('user_id') && \App\Models\Favorite::where('user_id', session('user_id'))->where('product_id', $product->id)->exists();
                            @endphp
                            <div class="vesitable-img">
                                <img src="{{ asset('products/' . $product->product_image_url) }}"
                                    class="img-fluid w-100" alt="">
                            </div>
                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute"
                                style="top: 10px; right: 10px;">{{ $product->product_factory }}</div>
                            <div class="p-4 pb-0 rounded-bottom">
                                <h4><a href="/product/{{ $product->id }}" class="text-decoration-none text-dark">
                                        {{ $product->product_name }}
                                    </a></h4>
                                <p>{{  $product->product_shortDesc }}</p>
                                <div class="d-flex flex-column align-items-start gap-2 w-100">
                                    @php
                                        $activeDiscountAll = \App\Models\ProductDiscount::where('product_id', $product->id)->where('status', 1)->first();
                                    @endphp
                                    @if($activeDiscountAll)
                                        @php
                                            $originalPriceAll = $product->product_price;
                                            $discountAll = $activeDiscountAll->discount_percent;
                                            $finalPriceAll = $originalPriceAll - ($originalPriceAll * $discountAll / 100);
                                        @endphp
                                        <div class="d-flex flex-column">
                                            <p class="text-danger fs-5 fw-bold mb-0">
                                                {{ number_format($finalPriceAll, 0, ',', '.') }} đ
                                            </p>
                                            <small class="text-muted text-decoration-line-through">
                                                {{ number_format($originalPriceAll, 0, ',', '.') }} đ
                                            </small>
                                        </div>
                                    @else
                                        <p class="text-dark fs-5 fw-bold mb-0">
                                            {{ number_format($product->product_price, 0, ',', '.') }} đ
                                        </p>
                                    @endif
                                    <div class="d-flex align-items-center justify-content-between w-100 mb-3">
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
    </div>
    <!-- Single Product End -->


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
    <script src="{{ asset('js/product-details.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('form').on('submit', function (e) {
                // Lấy giá trị radio được chọn
                let rating = $('input[name="radio-sort"]:checked').val();

                // Gán vào input hidden
                $('#rating-hidden').val(rating);

                // (Tùy chọn) Debug thử
                console.log("Đánh giá được chọn là: " + rating);
            });
        });
    </script>
</body>

</html>