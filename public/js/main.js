(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner(0);


    // Fixed Navbar
    // $(window).scroll(function () {
    //     if ($(window).width() < 992) {
    //         if ($(this).scrollTop() > 55) {
    //             $('.fixed-top').addClass('shadow');
    //         } else {
    //             $('.fixed-top').removeClass('shadow');
    //         }
    //     } else {
    //         if ($(this).scrollTop() > 55) {
    //             $('.fixed-top').addClass('shadow').css('top', -55);
    //         } else {
    //             $('.fixed-top').removeClass('shadow').css('top', 0);
    //         }
    //     }
    // });


    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 1500, 'easeInOutExpo');
        return false;
    });


    // Testimonial carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 2000,
        center: false,
        dots: true,
        loop: true,
        margin: 25,
        nav: true,
        navText: [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1
            },
            576: {
                items: 1
            },
            768: {
                items: 1
            },
            992: {
                items: 2
            },
            1200: {
                items: 2
            }
        }
    });


    // vegetable carousel
    $(".vegetable-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        center: false,
        dots: true,
        loop: true,
        margin: 25,
        nav: true,
        navText: [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1
            },
            576: {
                items: 1
            },
            768: {
                items: 2
            },
            992: {
                items: 3
            },
            1200: {
                items: 4
            }
        }
    });

    // Cho phép lướt qua lại bằng trackpad (bàn di chuột laptop) hoặc chuột cuộn ngang
    $('.owl-carousel').on('wheel', '.owl-stage', function (e) {
        var carousel = $(this).closest('.owl-carousel');
        var deltaX = e.originalEvent.deltaX;
        var deltaY = e.originalEvent.deltaY;

        // Chỉ cuộn khi hướng vuốt chủ yếu là chiều ngang (tránh xung đột với cuộn trang dọc)
        if (Math.abs(deltaX) > Math.abs(deltaY)) {
            if (deltaX > 15) {
                carousel.trigger('next.owl.carousel');
                e.preventDefault();
            } else if (deltaX < -15) {
                carousel.trigger('prev.owl.carousel');
                e.preventDefault();
            }
        }
    });


    // Modal Video
    $(document).ready(function () {
        var $videoSrc;
        $('.btn-play').click(function () {
            $videoSrc = $(this).data("src");
        });
        console.log($videoSrc);

        $('#videoModal').on('shown.bs.modal', function (e) {
            $("#video").attr('src', $videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0");
        })

        $('#videoModal').on('hide.bs.modal', function (e) {
            $("#video").attr('src', $videoSrc);
        })
    });



    function formatCurrency(number) {
        return new Intl.NumberFormat('vi-VN').format(number);
    }

    // Hàm cập nhật số lượng badge giỏ hàng trên header
    function updateCartBadge(cartSum) {
        var badge = $('#cart-badge');
        if (badge.length === 0) return;
        if (cartSum > 0) {
            badge.text(cartSum).show();
        } else {
            badge.hide();
        }
    }



    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Lấy URL từ data-url
        var updateUrl = $('#cart').data('url');
        $('.btn-plus, .btn-minus').click(function (e) {
            e.preventDefault();
            let id = $(this).data('id');
            let type = $(this).hasClass('btn-plus') ? 'increase' : 'decrease';
            let input = $('.cart-qty-input[data-cart-detail-id="' + id + '"]');


            $.ajax({
                url: updateUrl,
                method: 'POST',
                data: {
                    id: id,
                    type: type,
                },
                success: function (res) {
                    if (res.status === 'success') {
                        console.log(res);
                        input.val(res.quantity);
                        // Cập nhật lại tổng tiền cho sản phẩm
                        let totalPriceElement = $('.total-price[data-cart-detail-id="' + id + '"]');
                        totalPriceElement.text(res.total + ' đ');
                        
                        // Cập nhật lại input số lượng ẩn trong form checkout
                        let detailIndex = input.attr('data-cart-detail-index');
                        if (detailIndex !== undefined) {
                            $('input[name="cartDetails[' + detailIndex + '][quantity]"]').val(res.quantity);
                        }
                        
                        // Gọi updateCartSummary để tính lại tạm tính và tổng thanh toán theo các checkbox đã chọn
                        updateCartSummary();

                        // Cập nhật badge giỏ hàng real-time
                        if (res.cart_sum !== undefined) {
                            updateCartBadge(res.cart_sum);
                        }
                    }
                }
            });

        });

    });


    // // Edit quantity of products added to cart
    // document.getElementById('addToCartForm').addEventListener('submit', function(event) {
    //     var quantity = document.getElementById('quantityInput').value;
    //     // Cập nhật lại giá trị trong input ẩn của form với giá trị quantity
    //     var quantityInputHidden = document.createElement('input');
    //     quantityInputHidden.type = 'hidden';
    //     quantityInputHidden.name = 'quantity';
    //     quantityInputHidden.value = quantity;

    //     // Thêm input ẩn vào form
    //     this.appendChild(quantityInputHidden);
    // });

    // Attach the click event handler to the checkboxes within the OrderCart
    // $('.orderCart input').on('click', function () {
    //     $(".orderCart .form-check-input:not(:checked)").each(function () {
    //         const index = $(this).attr("data-cart-detail-index")
    //         const el = document.getElementById(`cartDetails${index}.checkbox`);
    //         $(el).val(0);
    //     });
    //     $(".orderCart .form-check-input:checked").each(function () {
    //         const index = $(this).attr("data-cart-detail-index")
    //         const el = document.getElementById(`cartDetails${index}.checkbox`);
    //         $(el).val(1);
    //     });
    // });

    // Attach the click event handler to the checkboxes within the OrderCart
    $('.orderCart input').on('click', function () {
        const index = $(this).attr("data-cart-detail-index");
        const isChecked = $(this).is(':checked');
        const el = document.getElementById(`cartDetails${index}-checkbox`);
        if (el) {
            $(el).prop('checked', isChecked).val(isChecked ? 1 : 0);
        }
    });



    function formatCurrency(value) {
        // Use the 'vi-VN' locale to format the number according to Vietnamese currency format
        // and 'VND' as the currency type for Vietnamese đồng
        const formatter = new Intl.NumberFormat('vi-VN', {
            style: 'decimal',
            minimumFractionDigits: 0, // No decimal part for whole numbers
        });

        let formatted = formatter.format(value);
        return formatted;
    }

    //handle filter products
    $('#btnFilter').click(function (event) {
        event.preventDefault();

        let factoryArr = [];
        let typeArr = [];
        let priceArr = [];
        //factory filter
        $("#factoryFilter .form-check-input:checked").each(function () {
            factoryArr.push($(this).val());
        });

        //type filter
        $("#typeFilter .form-check-input:checked").each(function () {
            typeArr.push($(this).val());
        });

        //price filter
        $("#priceFilter .form-check-input:checked").each(function () {
            priceArr.push($(this).val());
        });

        //sort order
        let sortValue = $('input[name="radio-sort"]:checked').val();
        let ValueStar = $('input[name="radio-star"]:checked').val();

        const currentUrl = new URL(window.location.href);
        const searchParams = currentUrl.searchParams;

        // Add or update query parameters
        searchParams.set('page', '1');
        searchParams.set('sort', sortValue);

        if (ValueStar != null) {
            searchParams.set('valueStar', ValueStar);
        }

        // Xóa searchValue khi lọc để không xung đột
        searchParams.delete('searchValue');

        searchParams.delete('factory')
        searchParams.delete('type')
        searchParams.delete('price')

        if (factoryArr.length > 0) {
            searchParams.set('factory', factoryArr.join(','));
        }
        if (typeArr.length > 0) {
            searchParams.set('type', typeArr.join(','));
        }
        if (priceArr.length > 0) {
            searchParams.set('price', priceArr.join(','));
        }

        // Update the URL and reload the page
        window.location.href = currentUrl.toString();
    });



    // Xử lý tìm kiếm khi bấm nút Xác nhận
    $('#searchButton').click(function (event) {
        doSearch();
    });

    // Xử lý tìm kiếm khi nhấn Enter
    $('input[name="SearchProduct"]').keypress(function (e) {
        if (e.which === 13) {
            e.preventDefault();
            doSearch();
        }
    });

    // Hàm tìm kiếm dùng chung (global để inline JS trong view có thể gọi)
    window.doSearch = function () {
        let searchValue = $('input[name="SearchProduct"]').val();
        const currentUrl = new URL(window.location.href);
        const searchParams = currentUrl.searchParams;
        // Xóa bỏ các filter cũ để không xung đột với tìm kiếm mới
        searchParams.delete('factory');
        searchParams.delete('type');
        searchParams.delete('price');
        searchParams.delete('valueStar');
        searchParams.delete('sort');
        searchParams.set('page', '1');
        searchParams.set('searchValue', searchValue);
        window.location.href = currentUrl.toString();
    }

    // Khôi phục giá trị ô tìm kiếm từ URL khi tải trang
    $(document).ready(function () {
        const params = new URLSearchParams(window.location.search);
        if (params.has('searchValue')) {
            $('input[name="SearchProduct"]').val(params.get('searchValue'));
        }
    });



    //handle auto checkbox after page loading
    // Parse the URL parameters
    const params = new URLSearchParams(window.location.search);

    // Set checkboxes for 'factory'
    if (params.has('factory')) {
        const factories = params.get('factory').split(',');
        factories.forEach(factory => {
            $(`#factoryFilter .form-check-input[value="${factory}"]`).prop('checked', true);
        });
    }

    // Set checkboxes for 'type'
    if (params.has('type')) {
        const types = params.get('type').split(',');
        types.forEach(type => {
            $(`#typeFilter .form-check-input[value="${type}"]`).prop('checked', true);
        });
    }

    // Set checkboxes for 'price'
    if (params.has('price')) {
        const prices = params.get('price').split(',');
        prices.forEach(price => {
            $(`#priceFilter .form-check-input[value="${price}"]`).prop('checked', true);
        });
    }

    // Set radio buttons for 'sort'
    if (params.has('sort')) {
        const sort = params.get('sort');
        $(`input[type="radio"][name="radio-sort"][value="${sort}"]`).prop('checked', true);
    }

    if (params.has('valueStar')) {
        const valueStar = params.get('valueStar');
        $(`input[type="radio"][name="radio-star"][value="${valueStar}"]`).prop('checked', true);
    }

    //////////////////////////
    // Thêm sản phẩm vào giỏ hàng từ trang chủ
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.btnAddToCartHomepage').click(function (e) {
            console.log("click")

            if (!isLogin()) {
                window.location.href = '/login';
                return;
            }

            // Lấy form chứa nút được nhấn
            var form = $(this).closest('form');

            // Lấy giá trị từ các input trong form
            const productId = form.find('input[name="product_id"]').val();
            const quantity = form.find('input[name="quantity"]').val();
            //kiểm tra xem thông tin sản phẩm có hợp lệ không
            console.log("productId: ", productId)
            console.log("quantity: ", quantity)
            const token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: `/add-product-to-cart/${productId}`,
                type: "POST",
                data: {
                    product_id: productId,
                    quantity: quantity,
                    _token: token
                },
                success: function (response) {
                    // Kiểm tra nếu server trả về 'status' là 'success'
                    if (response.status === 'success') {
                        $.toast({
                            heading: 'Giỏ hàng',
                            text: response.message,  // Lấy thông báo từ response.message
                            position: { top: 100, right: 20 },
                            icon: 'success'
                        });
                        // Cập nhật badge giỏ hàng real-time
                        if (response.cart_sum !== undefined) {
                            updateCartBadge(response.cart_sum);
                        }
                    }
                },
                error: function (xhr, status, error) {
                    // Xử lý lỗi nếu cần thiết
                    console.error("Error adding product to cart:", error);
                }

            });
        });
    });

    $('.btnAddToCartDetail').click(function (event) {
        event.preventDefault();
        if (!isLogin()) {
            window.location.href = '/login';
            return;
        }

        const productId = $(this).attr('data-product-id');
        const token = $("meta[name='_csrf']").attr("content");
        const header = $("meta[name='_csrf_header']").attr("content");
        const quantity = $("#cartDetails0\\.quantity").val();
        $.ajax({
            url: `${window.location.origin}/api/add-product-to-cart`,
            beforeSend: function (xhr) {
                xhr.setRequestHeader(header, token);
            },
            type: "POST",
            data: JSON.stringify({ quantity: quantity, productId: productId }),
            contentType: "application/json",

            success: function (response) {
                const sum = +response;
                //update cart
                $("#sumCart").text(sum)
                //show message
                $.toast({
                    heading: 'Giỏ hàng',
                    text: 'Thêm sản phẩm vào giỏ hàng thành công',
                    position: { top: 110, right: 20 },

                })

            },
            error: function (response) {
                alert("có lỗi xảy ra, check code đi ba :v")
                console.log("error: ", response);
            }

        });
    });

    //Xóa sản phẩm trong giỏ hàng
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Khi nhấn nút xóa sản phẩm trong giỏ hàng
        $('.btn-deleteCartDetail').click(function (e) {
            var cartDetailId = $(this).attr('id');
            console.log(cartDetailId)


            $.ajax({
                url: `/delete-cart-product/${cartDetailId}`,
                type: 'DELETE', // Sử dụng phương thức DELETE để xóa sản phẩm
                id: cartDetailId,
                success: function (response) {
                    // Xử lý khi xóa thành công
                    if (response.status === 'success') {
                        $.toast({
                            heading: 'Giỏ hàng',
                            text: 'Xóa sản phẩm thành công!',
                            position: { top: 110, right: 20 },
                            icon: 'success'
                        });
                        $('#cartItem' + cartDetailId).remove();
                        // Cập nhật badge giỏ hàng real-time
                        if (response.cart_sum !== undefined) {
                            updateCartBadge(response.cart_sum);
                        }

                    }
                },
                error: function (xhr) {
                    $.toast({
                        heading: 'Lỗi',
                        text: 'Có lỗi xảy ra khi xóa sản phẩm!',
                        position: { top: 110, right: 20 },
                        icon: 'error'
                    });
                    console.log("Error response:", xhr.responseText);
                }
            });
        });
    });

    // Nút "Mua hàng" - chuyển hướng sang trang thanh toán
    $(document).ready(function () {
        $('#btnShowOrderInfo').on('click', function () {
            var checkedBoxes = $('.external-checkbox:checked');
            var errorEl = $('#buyError');
            var hintEl = $('#buyHint');

            if (checkedBoxes.length === 0) {
                // Hiển thị thông báo lỗi
                errorEl.text('Vui lòng chọn ít nhất một sản phẩm để mua hàng').show();
                return;
            }

            // Ẩn lỗi nếu có
            errorEl.hide();
            hintEl.hide();

            // Submit form để chuyển hướng sang /checkout
            $('#checkoutForm').submit();
        });
    });

    // Biến lưu thông tin mã giảm giá đang áp dụng
    let couponInfo = null;

    // Hàm cập nhật chi tiết thanh toán giỏ hàng (Shopee Style)
    function updateCartSummary() {
        let subtotal = 0;
        let checkedCount = 0;
        let sidebarListHtml = '';

        $('.external-checkbox:checked').each(function () {
            let id = $(this).data('cart-detail-id');
            let row = $(this).closest('tr');
            let productName = row.find('td:eq(0) a').text().trim();
            let quantity = parseInt(row.find('.cart-qty-input').val()) || 1;
            let priceText = $('.total-price[data-cart-detail-id="' + id + '"]').text().replace(/[^\d]/g, '');
            let price = parseInt(priceText) || 0;
            subtotal += price;
            checkedCount++;

            sidebarListHtml +=
                '<li class="d-flex justify-content-between align-items-center py-1 border-bottom" style="font-size:13px;">' +
                '  <span class="text-dark text-truncate me-2" style="max-width:65%;">' + productName + '</span>' +
                '  <span class="text-muted">x<strong class="text-danger">' + quantity + '</strong></span>' +
                '</li>';
        });

        // Cập nhật danh sách sản phẩm đã chọn bên sidebar
        if (checkedCount > 0) {
            $('#sidebarProductList').html(sidebarListHtml);
            $('#sidebarSelectedProducts').show();
        } else {
            $('#sidebarProductList').empty();
            $('#sidebarSelectedProducts').hide();
        }

        $('#checkedCount').text(checkedCount);
        $('#summarySubtotal').text(formatCurrency(subtotal) + ' đ');

        // Tính toán phí vận chuyển (Miễn phí nếu >= 1 triệu, ngược lại 30k)
        let shippingFee = 0;
        if (checkedCount > 0) {
            shippingFee = (subtotal >= 1000000) ? 0 : 30000;
        }

        if (shippingFee === 0) {
            $('#summaryShipping').text(checkedCount > 0 ? 'Miễn phí' : '0 đ');
        } else {
            $('#summaryShipping').text(formatCurrency(shippingFee) + ' đ');
        }

        // Tính toán giảm giá
        let discount = 0;
        if (couponInfo) {
            if (subtotal < couponInfo.min_order_amount) {
                $('#couponMessage').text('Đơn hàng không đủ giá trị tối thiểu để áp dụng mã này (' + formatCurrency(couponInfo.min_order_amount) + ' đ).').removeClass('text-success').addClass('text-danger').show();
                couponInfo = null;
                $('#hiddenCouponCode').val('');
            } else {
                if (couponInfo.type === 'percent') {
                    discount = Math.round(subtotal * (couponInfo.value / 100));
                } else {
                    discount = Math.min(couponInfo.value, subtotal);
                }
            }
        }

        if (discount > 0) {
            $('#summaryDiscount').text('-' + formatCurrency(discount) + ' đ');
            $('#couponDiscountWrapper').attr('style', 'display: flex !important;');
            $('#checkoutDiscountText').text('-' + formatCurrency(discount) + ' đ');
            $('#checkoutDiscountRow').show();
        } else {
            $('#couponDiscountWrapper').attr('style', 'display: none !important;');
            $('#checkoutDiscountRow').hide();
        }

        let finalTotal = Math.max(0, subtotal - discount + shippingFee);
        $('#summaryTotal').text(formatCurrency(finalTotal) + ' đ');

        // Cập nhật tất cả các phần tử hiển thị totalPrice (kể cả form đơn hàng)
        $('.totalPrice').each(function () {
            $(this).text(formatCurrency(finalTotal) + ' đ');
            $(this).attr('data-cart-total-price', finalTotal);
        });
    }


    // Khi checkbox thay đổi, cập nhật trạng thái và tính toán lại tổng tiền
    $(document).ready(function () {
        // Đồng bộ checkbox bên ngoài với input ẩn trong form
        $(document).on('change', '.external-checkbox', function () {
            var index = $(this).data('cart-detail-index');
            $('#cartDetails' + index + '-checkbox').prop('checked', $(this).prop('checked'));

            var checkedCount = $('.external-checkbox:checked').length;
            if (checkedCount > 0) {
                $('#buyHint').text('Đã chọn ' + checkedCount + ' sản phẩm. Nhấn "Mua hàng" để tiếp tục').removeClass('text-muted').addClass('text-success');
            } else {
                $('#buyHint').text('Chọn sản phẩm bằng cách tick vào ô checkbox').removeClass('text-success').addClass('text-muted');
            }
            // Ẩn lỗi khi người dùng bắt đầu chọn sản phẩm
            $('#buyError').hide();

            updateCartSummary();
        });

        // Xử lý nút Chọn tất cả (Select All)
        $(document).on('change', '#selectAllCart', function () {
            $('.external-checkbox').prop('checked', $(this).prop('checked')).trigger('change');
        });

        // Áp dụng mã giảm giá
        $(document).on('click', '#btnApplyCoupon', function () {
            let code = $('#couponCodeInput').val().trim().toUpperCase();
            let msgEl = $('#couponMessage');

            if (!code) {
                msgEl.text('Vui lòng nhập mã giảm giá!').removeClass('text-success').addClass('text-danger').show();
                return;
            }

            // Kiểm tra xem đã chọn sản phẩm chưa
            let checkedCount = $('.external-checkbox:checked').length;
            if (checkedCount === 0) {
                msgEl.text('Vui lòng chọn ít nhất một sản phẩm để áp dụng mã!').removeClass('text-success').addClass('text-danger').show();
                return;
            }

            // Tính tạm tính hiện tại
            let subtotal = 0;
            $('.external-checkbox:checked').each(function () {
                let id = $(this).data('cart-detail-id');
                let priceText = $('.total-price[data-cart-detail-id="' + id + '"]').text().replace(/[^\d]/g, '');
                subtotal += parseInt(priceText) || 0;
            });

            // Gửi yêu cầu AJAX kiểm tra coupon
            $('#btnApplyCoupon').html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);

            $.ajax({
                url: '/apply-coupon',
                type: 'POST',
                data: {
                    code: code,
                    order_total: subtotal
                },
                success: function (res) {
                    $('#btnApplyCoupon').html('Áp dụng').prop('disabled', false);
                    if (res.success) {
                        couponInfo = {
                            code: res.coupon_code,
                            type: res.type,
                            value: parseFloat(res.value),
                            min_order_amount: parseFloat(res.min_order_amount || 0)
                        };
                        $('#hiddenCouponCode').val(res.coupon_code);
                        msgEl.text(res.message).removeClass('text-danger').addClass('text-success').show();
                    } else {
                        couponInfo = null;
                        $('#hiddenCouponCode').val('');
                        msgEl.text(res.message).removeClass('text-success').addClass('text-danger').show();
                    }
                    updateCartSummary();
                },
                error: function () {
                    $('#btnApplyCoupon').html('Áp dụng').prop('disabled', false);
                    couponInfo = null;
                    $('#hiddenCouponCode').val('');
                    msgEl.text('Có lỗi xảy ra, vui lòng thử lại sau.').removeClass('text-success').addClass('text-danger').show();
                    updateCartSummary();
                }
            });
        });

        // Chạy kiểm tra ban đầu khi load trang
        if ($('.external-checkbox').length > 0) {
            let allChecked = $('.external-checkbox:checked').length === $('.external-checkbox').length;
            $('#selectAllCart').prop('checked', allChecked);
            updateCartSummary();
        }
    });



    function isLogin() {
        const childLogin = $('a.a-login');
        if (childLogin.length > 0) {
            return false;
        }
        return true;
    }



    // Xử lý click yêu thích (Favorite/Wishlist)
    $(document).on('click', '.btn-favorite', function (e) {
        e.preventDefault();
        e.stopPropagation(); // Ngăn sự kiện click lan ra thẻ cha (ví dụ như đi vào trang chi tiết)

        const btn = $(this);
        const productId = btn.attr('data-product-id');

        if (!isLogin()) {
            window.location.href = '/login';
            return;
        }

        $.ajax({
            url: '/favorite/toggle',
            method: 'POST',
            data: {
                product_id: productId,
                _token: $('meta[name="csrf-token"]').attr('content') || $('meta[name="_csrf"]').attr('content')
            },
            success: function (res) {
                if (res.status === 'not_logged_in') {
                    window.location.href = '/login';
                } else if (res.status === 'added') {
                    $.toast({
                        heading: 'Yêu thích',
                        text: 'Đã thêm sản phẩm vào danh sách yêu thích!',
                        position: { top: 110, right: 20 },
                        icon: 'success'
                    });
                    // Toggle icon
                    btn.find('i').removeClass('far fa-heart text-muted').addClass('fas fa-heart text-danger');
                    // Nếu là nút dạng viền trên trang chi tiết:
                    if (btn.hasClass('btn-outline-danger')) {
                        btn.removeClass('btn-outline-danger').addClass('btn-danger text-white');
                        btn.find('i').removeClass('text-danger');
                    }
                } else if (res.status === 'removed') {
                    $.toast({
                        heading: 'Yêu thích',
                        text: 'Đã xóa sản phẩm khỏi danh sách yêu thích!',
                        position: { top: 110, right: 20 },
                        icon: 'error'
                    });
                    // Toggle icon
                    btn.find('i').removeClass('fas fa-heart text-danger').addClass('far fa-heart text-muted');
                    // Nếu là nút dạng viền trên trang chi tiết:
                    if (btn.hasClass('btn-danger')) {
                        btn.removeClass('btn-danger text-white').addClass('btn-outline-danger');
                        btn.find('i').addClass('text-danger');
                    }

                    // Nếu đang ở trang danh sách yêu thích, reload trang
                    if (window.location.pathname === '/favorites') {
                        location.reload();
                    }
                }
            },
            error: function (err) {
                console.error("Favorite toggle error:", err);
            }
        });
    });

})(jQuery);

