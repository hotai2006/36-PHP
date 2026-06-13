<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Login - laptopshop</title>
    <!-- MDB icon -->
    <link rel="icon" href="img/mdb-favicon.ico" type="image/x-icon" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" />
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" />
    <!-- MDB -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-login-form.min.css') }}" />
</head>

<body>
    <!-- Start your project here-->

    <style>
    .divider:after,
    .divider:before {
        content: "";
        flex: 1;
        height: 1px;
        background: #eee;
    }

    .h-custom {
        height: calc(100% - 73px);
    }

    @media (max-width: 450px) {
        .h-custom {
            height: 100%;
        }
    }

    .form-outline {
        position: relative;
    }
    .form-outline input {
        padding-right: 45px;
    }
    .password-toggle {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #888;
        font-size: 18px;
        z-index: 3;
        transition: color 0.2s;
        line-height: 0;
    }
    .password-toggle:hover {
        color: #d94140;
    }

    /* Red Theme overrides for buttons and forms */
    .bg-primary {
        background-color: #d94140 !important;
    }
    .btn-primary {
        background-color: #d94140 !important;
        border-color: #d94140 !important;
    }
    .btn-primary:hover, .btn-primary:focus, .btn-primary:active {
        background-color: #b83534 !important;
        border-color: #b83534 !important;
        box-shadow: 0 4px 10px rgba(217, 65, 64, 0.3) !important;
    }
    .text-primary {
        color: #d94140 !important;
    }
    .form-outline .form-control:focus ~ .form-label {
        color: #d94140 !important;
    }
    .form-outline .form-control:focus ~ .form-notch .form-notch-leading,
    .form-outline .form-control:focus ~ .form-notch .form-notch-middle,
    .form-outline .form-control:focus ~ .form-notch .form-notch-trailing {
        border-color: #d94140 !important;
    }
    </style>
    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                        class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <div class="text-center text-lg-start mb-4">
                        <h3 class="fw-bold">Đăng nhập tài khoản</h3>
                        <p class="text-muted">Nhập email và mật khẩu của bạn</p>
                    </div>
                    <form method="post" action="/login">
                        @csrf

                        <!-- Hiển thị thông báo lỗi -->
                        @if($errors->has('login'))
                        <!--Thông báo lỗi được lấy từ đối tượng $errors nghĩa là lấy thông báo lỗi đầu tiên có key là "login"-->
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i> {{ $errors->first('login') }}
                        </div>
                        @endif

                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <input type="email" id="form3Example3" class="form-control form-control-lg"
                                placeholder="Nhập email" name="user_email" />
                            <label class="form-label" for="form3Example3">Email</label>
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-3">
                            <input type="password" id="form3Example4" class="form-control form-control-lg"
                                placeholder="Nhập mật khẩu" name="user_password" />
                            <label class="form-label" for="form3Example4">Mật khẩu</label>
                            <span class="password-toggle" onclick="togglePassword('form3Example4', this)">
                                <i class="far fa-eye"></i>
                            </span>
                        </div>

                        <div class="d-flex justify-content-end mb-3">
                            <a href="{{ route('forgot-password') }}" class="text-danger small fw-bold text-decoration-none">Quên mật khẩu?</a>
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" class="btn btn-primary btn-lg"
                                style="padding-left: 2.5rem; padding-right: 2.5rem;">Đăng nhập</button>
                        </div>
                    </form>

                    <p class="small fw-bold mt-2 pt-1 mb-0">Chưa có tài khoản? <a href="/register"
                            class="link-danger">Đăng ký</a></p>
                </div>
            </div>
        </div>
        <div
            class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
            <!-- Copyright -->
            <div class="text-white mb-3 mb-md-0">
                Copyright © 2020. All rights reserved.
            </div>
            <!-- Copyright -->

            <!-- Right -->
            <div>
                <a href="#!" class="text-white me-4">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#!" class="text-white me-4">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#!" class="text-white me-4">
                    <i class="fab fa-google"></i>
                </a>
                <a href="#!" class="text-white">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div>
            <!-- Right -->
        </div>
    </section>
    <!-- End your project here-->

    <!-- MDB -->
    <script type="text/javascript" src="{{ asset('js/mdb.min.js') }}"></script>
    <!-- Custom scripts -->
    <script>
        function togglePassword(inputId, el) {
            const input = document.getElementById(inputId);
            const icon = el.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'far fa-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'far fa-eye';
            }
        }
    </script>
</body>

</html>