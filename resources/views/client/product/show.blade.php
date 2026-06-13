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


    <!-- Modal Search Start -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center">
                    <div class="input-group w-75 mx-auto d-flex">
                        <input type="search" class="form-control p-3" placeholder="keywords"
                            aria-describedby="search-icon-1">
                        <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Search End -->



    <!-- Sports Shop Start-->
    <div style="margin-top: -30px;" class="container-fluid fruite py-5">
        <div class="container py-5">
            <div class="row g-4 mt-5">
                <div class="col-lg-12">

                    <div class="row g-4">
                        <div class="col-lg-3">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="row g-4">

                                        <!-- Toàn bộ bộ lọc trong 1 khung cuộn -->
                                        <div class="col-12 p-3 bg-white rounded border" style="max-height: 520px; overflow-y: auto; overflow-x: hidden;">

                                            <!-- Hãng sản xuất -->
                                            <div class="mb-3" id="factoryFilter">
                                                <div class="mb-2"><b>Hãng sản xuất</b></div>
                                                <div class="form-check"><input class="form-check-input" type="checkbox" id="factory-1" value="Nike"><label class="form-check-label" for="factory-1">Nike</label></div>
                                                <div class="form-check"><input class="form-check-input" type="checkbox" id="factory-2" value="Adidas"><label class="form-check-label" for="factory-2">Adidas</label></div>
                                                <div class="form-check"><input class="form-check-input" type="checkbox" id="factory-3" value="Puma"><label class="form-check-label" for="factory-3">Puma</label></div>
                                                <div class="form-check"><input class="form-check-input" type="checkbox" id="factory-4" value="Under Armour"><label class="form-check-label" for="factory-4">Under Armour</label></div>
                                                <div class="form-check"><input class="form-check-input" type="checkbox" id="factory-5" value="Asics"><label class="form-check-label" for="factory-5">Asics</label></div>
                                                <div class="form-check"><input class="form-check-input" type="checkbox" id="factory-6" value="New Balance"><label class="form-check-label" for="factory-6">New Balance</label></div>
                                                <div class="form-check"><input class="form-check-input" type="checkbox" id="factory-7" value="Reebok"><label class="form-check-label" for="factory-7">Reebok</label></div>
                                                <div class="form-check"><input class="form-check-input" type="checkbox" id="factory-8" value="Mizuno"><label class="form-check-label" for="factory-8">Mizuno</label></div>
                                                <div class="form-check"><input class="form-check-input" type="checkbox" id="factory-9" value="Yonex"><label class="form-check-label" for="factory-9">Yonex</label></div>
                                                <div class="form-check"><input class="form-check-input" type="checkbox" id="factory-10" value="Decathlon"><label class="form-check-label" for="factory-10">Decathlon</label></div>
                                                <div class="form-check"><input class="form-check-input" type="checkbox" id="factory-11" value="Lining"><label class="form-check-label" for="factory-11">Lining</label></div>
                                            </div>

                                            <hr class="my-2">

                                            <!-- Loại sản phẩm -->
                                            <div class="mb-3" id="typeFilter">
                                                <div class="mb-2"><b>Loại sản phẩm</b></div>
                                                <div class="form-check"><input class="form-check-input" type="checkbox" id="type-1" value="Giày thể thao"><label class="form-check-label" for="type-1">Giày thể thao</label></div>
                                                <div class="form-check"><input class="form-check-input" type="checkbox" id="type-2" value="Áo thể thao"><label class="form-check-label" for="type-2">Áo thể thao</label></div>
                                                <div class="form-check"><input class="form-check-input" type="checkbox" id="type-3" value="Quần thể thao"><label class="form-check-label" for="type-3">Quần thể thao</label></div>
                                                <div class="form-check"><input class="form-check-input" type="checkbox" id="type-4" value="Phụ kiện thể thao"><label class="form-check-label" for="type-4">Phụ kiện thể thao</label></div>
                                                <div class="form-check"><input class="form-check-input" type="checkbox" id="type-5" value="Dụng cụ thể thao"><label class="form-check-label" for="type-5">Dụng cụ thể thao</label></div>
                                                <div class="form-check"><input class="form-check-input" type="checkbox" id="type-6" value="Bóng thể thao"><label class="form-check-label" for="type-6">Bóng thể thao</label></div>
                                            </div>

                                            <hr class="my-2">

                                            <!-- Mức giá -->
                                            <div class="mb-3" id="priceFilter">
                                                <div class="mb-2"><b>Mức giá</b></div>
                                                <div class="form-check"><input class="form-check-input" type="checkbox" id="price-2" value="duoi-100-nghin"><label class="form-check-label" for="price-2">Dưới 100 nghìn</label></div>
                                                <div class="form-check"><input class="form-check-input" type="checkbox" id="price-3" value="100-500-nghin"><label class="form-check-label" for="price-3">Từ 100 - 500 nghìn</label></div>
                                                <div class="form-check"><input class="form-check-input" type="checkbox" id="price-4" value="500-2000-nghin"><label class="form-check-label" for="price-4">Từ 500 nghìn - 2 triệu</label></div>
                                                <div class="form-check"><input class="form-check-input" type="checkbox" id="price-5" value="tren-2-trieu"><label class="form-check-label" for="price-5">Trên 2 triệu</label></div>
                                            </div>

                                            <hr class="my-2">

                                            <!-- Đánh giá -->
                                            <div class="mb-3">
                                                <div class="mb-2"><b>Đánh giá</b></div>
                                                <div class="d-flex flex-wrap gap-2">
                                                    <div class="form-check form-check-inline"><input class="form-check-input" type="radio" id="star-1" value="1" name="radio-star"><label class="form-check-label" for="star-1"><i class="fa fa-star text-secondary"></i></label></div>
                                                    <div class="form-check form-check-inline"><input class="form-check-input" type="radio" id="star-2" value="2" name="radio-star"><label class="form-check-label" for="star-2"><i class="fa fa-star text-secondary"></i><i class="fa fa-star text-secondary"></i></label></div>
                                                    <div class="form-check form-check-inline"><input class="form-check-input" type="radio" id="star-3" value="3" name="radio-star"><label class="form-check-label" for="star-3"><i class="fa fa-star text-secondary"></i><i class="fa fa-star text-secondary"></i><i class="fa fa-star text-secondary"></i></label></div>
                                                    <div class="form-check form-check-inline"><input class="form-check-input" type="radio" id="star-4" value="4" name="radio-star"><label class="form-check-label" for="star-4"><i class="fa fa-star text-secondary"></i><i class="fa fa-star text-secondary"></i><i class="fa fa-star text-secondary"></i><i class="fa fa-star text-secondary"></i></label></div>
                                                    <div class="form-check form-check-inline"><input class="form-check-input" type="radio" id="star-5" value="5" name="radio-star"><label class="form-check-label" for="star-5"><i class="fa fa-star text-secondary"></i><i class="fa fa-star text-secondary"></i><i class="fa fa-star text-secondary"></i><i class="fa fa-star text-secondary"></i><i class="fa fa-star text-secondary"></i></label></div>
                                                </div>
                                            </div>

                                            <hr class="my-2">

                                            <!-- Sắp xếp -->
                                            <div class="mb-3">
                                                <div class="mb-2"><b>Sắp xếp</b></div>
                                                <div class="form-check"><input class="form-check-input" type="radio" id="sort-asc" value="gia-tang-dan" name="radio-sort"><label class="form-check-label" for="sort-asc">Giá tăng dần</label></div>
                                                <div class="form-check"><input class="form-check-input" type="radio" id="sort-desc" value="gia-giam-dan" name="radio-sort"><label class="form-check-label" for="sort-desc">Giá giảm dần</label></div>
                                                <div class="form-check"><input class="form-check-input" type="radio" id="sort-none" checked value="gia-nothing" name="radio-sort"><label class="form-check-label" for="sort-none">Không sắp xếp</label></div>
                                            </div>

                                        </div><!-- end scroll box -->

                                        <div class="col-12">
                                            <button class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4" id="btnFilter">
                                                Lọc Sản Phẩm
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <input type="hidden" name="${_csrf.parameterName}" value="${_csrf.token}" />
                            <div class="position-relative mx-auto mb-5" style="z-index: 1000;">
                                <input name="SearchProduct" id="SearchProduct" autocomplete="off"
                                    class="form-control border-2 border-secondary w-75 py-3 px-4 rounded-pill"
                                    type="text" placeholder="Tìm kiếm sản phẩm...">
                                <button type="button" id="searchButton"
                                    class="btn btn-primary border-2 border-secondary py-3 px-4 position-absolute rounded-pill text-white h-100"
                                    style="top: 0; right: 25%;">Xác nhận</button>
                                <!-- Dropdown gợi ý -->
                                <div id="searchSuggestions"
                                    class="position-absolute bg-white w-75 shadow rounded-3 overflow-hidden"
                                    style="display: none; top: 100%; left: 0;">
                                </div>
                            </div>
                            <div class="row g-4 justify-content-start">
                                @if ($products->isEmpty())
                                <h3>Không có sản phẩm nào phù hợp với tiêu chí tìm kiếm.</h3>
                                @else
                                @foreach ($products as $product)
                                <div class="col-md-6 col-lg-6 col-xl-4">
                                    <div class="position-relative fruite-item">
                                        @php
                                            $isFav = session()->has('user_id') && \App\Models\Favorite::where('user_id', session('user_id'))->where('product_id', $product->id)->exists();
                                        @endphp
                                        <a href="/product/{{ $product->id }}">
                                            <div class="fruite-img">
                                                <img src="{{ asset('products/' . $product->product_image_url) }}"
                                                    class="img-fluid w-100" alt="">
                                            </div>
                                        </a>
                                        <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                            style="top: 10px; left: 10px;">{{ $product->product_factory }}</div>
                                        <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                            <h4><a href="/product/{{ $product->id }}"
                                                    class="text-decoration-none text-dark">
                                                    {{ $product->product_name }}
                                                </a></h4>
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
                                </div>
                                @endforeach
                                @endif
                            </div>
                            <div class="d-flex justify-content-center">
                                {{ $products->links('pagination::bootstrap-4') }}
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Sports Shop End-->


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
    
    <script>
    $(document).ready(function() {
        let searchTimeout;
        const $searchInput = $('#SearchProduct');
        const $suggestions = $('#searchSuggestions');
        const minChars = 1;

        // Gợi ý khi gõ
        $searchInput.on('input', function() {
            clearTimeout(searchTimeout);
            const value = $(this).val().trim();
            
            if (value.length < minChars) {
                $suggestions.hide().empty();
                return;
            }

            searchTimeout = setTimeout(function() {
                $.ajax({
                    url: '/api/products/suggestions',
                    method: 'GET',
                    data: { q: value },
                    success: function(products) {
                        if (products.length === 0) {
                            $suggestions.hide().empty();
                            return;
                        }
                        
                        let html = '';
                        products.forEach(function(p) {
                            let price = new Intl.NumberFormat('vi-VN').format(p.product_price) + ' ₫';
                            html += '<a href="#" class="suggestion-item d-flex align-items-center gap-3 px-3 py-2 text-decoration-none text-dark border-bottom" data-id="' + p.id + '" data-name="' + $('<span>').text(p.product_name).html() + '">';
                            if (p.image_url) {
                                html += '<img src="' + p.image_url + '" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">';
                            }
                            html += '<div class="flex-grow-1">';
                            html += '<div class="fw-semibold small">' + $('<span>').text(p.product_name).html() + '</div>';
                            html += '<div class="text-primary small">' + price + '</div>';
                            html += '</div>';
                            html += '</a>';
                        });
                        
                        $suggestions.html(html).show();
                    },
                    error: function() {
                        $suggestions.hide().empty();
                    }
                });
            }, 300);
        });

        // Click vào gợi ý -> Chuyển hướng thẳng đến trang chi tiết sản phẩm
        $(document).on('click', '.suggestion-item', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            window.location.href = '/product/' + id;
        });

        // Ẩn dropdown khi click ra ngoài
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#SearchProduct, #searchSuggestions').length) {
                $suggestions.hide().empty();
            }
        });

        // Điều hướng bàn phím trong dropdown
        $searchInput.on('keydown', function(e) {
            const $items = $suggestions.find('.suggestion-item');
            if ($items.length === 0 || !$suggestions.is(':visible')) return;

            const $active = $suggestions.find('.suggestion-item.active');
            
            if (e.which === 40) { // Mũi tên xuống
                e.preventDefault();
                if ($active.length) {
                    $active.removeClass('active bg-light');
                    $active.next('.suggestion-item').addClass('active bg-light');
                } else {
                    $items.first().addClass('active bg-light');
                }
            } else if (e.which === 38) { // Mũi tên lên
                e.preventDefault();
                if ($active.length) {
                    $active.removeClass('active bg-light');
                    $active.prev('.suggestion-item').addClass('active bg-light');
                } else {
                    $items.last().addClass('active bg-light');
                }
            } else if (e.which === 13 && $active.length) { // Enter
                e.preventDefault();
                $active.click();
            }
        });
    });
    </script>
    
</body>


</html>