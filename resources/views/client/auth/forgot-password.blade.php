<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Quên mật khẩu - T-Sports</title>
    <link rel="icon" href="img/mdb-favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap-login-form.min.css') }}" />
</head>

<body>
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
        .h-custom { height: 100%; }
    }

    /* OTP row */
    .otp-row {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .otp-row .form-outline {
        flex: 1;
        margin-bottom: 0 !important;
    }
    .btn-send-otp {
        white-space: nowrap;
        height: 46px;
        padding: 0 20px;
        border-radius: 8px;
        background: linear-gradient(135deg, #d94140 0%, #c0392b 100%);
        color: #fff;
        border: none;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.3s;
        cursor: pointer;
    }
    .btn-send-otp:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }
    .btn-send-otp:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    /* OTP input boxes */
    .otp-input-group {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin: 10px 0;
    }
    .otp-input {
        width: 44px;
        height: 52px;
        text-align: center;
        font-size: 22px;
        font-weight: bold;
        border: 2px solid #ddd;
        border-radius: 8px;
        outline: none;
        transition: border-color 0.3s;
    }
    .otp-input:focus {
        border-color: #d94140;
        box-shadow: 0 0 0 3px rgba(217, 65, 64, 0.2);
    }
    .otp-input::-webkit-inner-spin-button,
    .otp-input::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }

    .otp-section {
        display: none;
    }
    .otp-section.show {
        display: block;
    }

    .countdown {
        color: #dc3545;
        font-weight: 500;
        font-size: 13px;
    }

    .toast-message {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        padding: 16px 24px;
        border-radius: 8px;
        color: #fff;
        font-weight: 500;
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        transform: translateX(120%);
        transition: transform 0.4s ease;
        max-width: 400px;
    }
    .toast-message.show {
        transform: translateX(0);
    }
    .toast-message.success {
        background: linear-gradient(135deg, #28a745, #20c997);
    }
    .toast-message.error {
        background: linear-gradient(135deg, #dc3545, #e74c3c);
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

    .spinner {
        display: inline-block;
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 0.6s linear infinite;
        vertical-align: middle;
        margin-right: 6px;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

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

                    <div class="text-center mb-4">
                        <h3>Đặt lại mật khẩu</h3>
                        <p class="text-muted">Nhập email để nhận mã OTP khôi phục tài khoản</p>
                    </div>

                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form method="post" action="{{ route('forgot-password.reset') }}" id="resetForm">
                        @csrf

                        <!-- Ô 1: Email + nút gửi OTP -->
                        <div class="otp-row mb-4">
                            <div class="form-outline">
                                <input type="email" id="user_email" class="form-control form-control-lg"
                                    placeholder="Nhập email" name="user_email" value="{{ old('user_email') }}" required />
                                <label class="form-label" for="user_email">Email</label>
                            </div>
                            <button type="button" class="btn-send-otp" id="btnSendOtp">
                                <i class="fas fa-paper-plane me-1"></i> Gửi OTP
                            </button>
                        </div>

                        <!-- Ô 2: Mã OTP (Chỉ hiện sau khi gửi OTP) -->
                        <div class="otp-section mb-4" id="otpSection">
                            <label class="form-label d-block text-center fw-bold">Nhập mã xác thực OTP (6 chữ số)</label>
                            <div class="otp-input-group" id="otpInputs">
                                <input type="text" class="otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                                <input type="text" class="otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                                <input type="text" class="otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                                <input type="text" class="otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                                <input type="text" class="otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                                <input type="text" class="otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]">
                            </div>
                            <input type="hidden" name="otp" id="otpHidden">
                            <div class="text-center mb-3">
                                <span class="countdown" id="countdown"></span>
                            </div>
                        </div>

                        <!-- Ô 3: Mật khẩu mới -->
                        <div class="form-outline mb-4">
                            <input type="password" id="user_password" class="form-control form-control-lg"
                                placeholder="Nhập mật khẩu mới (tối thiểu 6 ký tự)" name="user_password" minlength="6" />
                            <label class="form-label" for="user_password">Mật khẩu mới</label>
                            <span class="password-toggle" onclick="togglePassword('user_password', this)">
                                <i class="far fa-eye"></i>
                            </span>
                        </div>

                        <!-- Ô 4: Xác nhận mật khẩu mới -->
                        <div class="form-outline mb-4">
                            <input type="password" id="user_password_confirmation" class="form-control form-control-lg"
                                placeholder="Nhập lại mật khẩu mới" name="user_password_confirmation" minlength="6" />
                            <label class="form-label" for="user_password_confirmation">Xác nhận mật khẩu</label>
                            <span class="password-toggle" onclick="togglePassword('user_password_confirmation', this)">
                                <i class="far fa-eye"></i>
                            </span>
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" class="btn btn-primary btn-lg w-100"
                                style="background: linear-gradient(135deg, #d94140 0%, #c0392b 100%); border: none; padding: 12px;">
                                <i class="fas fa-key me-2"></i>Đặt lại mật khẩu
                            </button>
                        </div>
                    </form>

                    <p class="small fw-bold mt-4 pt-1 mb-0 text-center">
                        Nhớ mật khẩu? <a href="{{ route('login') }}" class="link-danger">Đăng nhập</a>
                    </p>
                </div>
            </div>
        </div>
        <div
            class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
            <div class="text-white mb-3 mb-md-0">Copyright © 2020. All rights reserved.</div>
            <div>
                <a href="#!" class="text-white me-4"><i class="fab fa-facebook-f"></i></a>
                <a href="#!" class="text-white me-4"><i class="fab fa-twitter"></i></a>
                <a href="#!" class="text-white me-4"><i class="fab fa-google"></i></a>
                <a href="#!" class="text-white"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </section>

    <!-- Toast message -->
    <div class="toast-message" id="toastMessage"></div>

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
    <script type="text/javascript" src="{{ asset('js/mdb.min.js') }}"></script>
    <script type="text/javascript">
        // === Toast notification ===
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toastMessage');
            toast.textContent = message;
            toast.className = 'toast-message ' + type;
            setTimeout(() => toast.classList.add('show'), 10);
            setTimeout(() => toast.classList.remove('show'), 4000);
        }

        // === OTP Input auto-focus ===
        const otpInputs = document.querySelectorAll('.otp-input');
        const otpHidden = document.getElementById('otpHidden');

        function updateHiddenOtp() {
            let otp = '';
            otpInputs.forEach(input => otp += input.value);
            otpHidden.value = otp;
        }

        otpInputs.forEach((input, index) => {
            input.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value.length === 1 && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
                updateHiddenOtp();
            });
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && this.value === '' && index > 0) {
                    otpInputs[index - 1].focus();
                }
            });
            input.addEventListener('paste', function(e) {
                e.preventDefault();
                const paste = (e.clipboardData || window.clipboardData).getData('text');
                const digits = paste.replace(/\D/g, '').split('').slice(0, 6);
                digits.forEach((digit, i) => {
                    if (otpInputs[i]) otpInputs[i].value = digit;
                });
                const nextIndex = Math.min(digits.length, 5);
                otpInputs[nextIndex].focus();
                updateHiddenOtp();
            });
        });

        // === Countdown timer ===
        let countdownInterval = null;
        let countdownSeconds = 0;

        function startCountdown(seconds) {
            countdownSeconds = seconds;
            const el = document.getElementById('countdown');
            clearInterval(countdownInterval);
            countdownInterval = setInterval(() => {
                if (countdownSeconds <= 0) {
                    clearInterval(countdownInterval);
                    el.textContent = 'Mã OTP đã hết hạn. Vui lòng gửi lại!';
                    return;
                }
                const m = Math.floor(countdownSeconds / 60);
                const s = countdownSeconds % 60;
                el.textContent = 'Mã OTP hết hạn sau: ' + m + ':' + (s < 10 ? '0' : '') + s;
                countdownSeconds--;
            }, 1000);
        }

        // === Cooldown timer cho nút Gửi OTP ===
        let cooldownSeconds = 0;
        let cooldownInterval = null;

        function startOtpCooldown(seconds = 60) {
            cooldownSeconds = seconds;
            btnSendOtp.disabled = true;
            btnSendOtp.innerHTML = '<i class="fas fa-history me-1"></i> Gửi lại sau ' + cooldownSeconds + 's';
            
            clearInterval(cooldownInterval);
            cooldownInterval = setInterval(() => {
                cooldownSeconds--;
                if (cooldownSeconds <= 0) {
                    clearInterval(cooldownInterval);
                    btnSendOtp.disabled = false;
                    btnSendOtp.innerHTML = '<i class="fas fa-paper-plane me-1"></i> Gửi OTP';
                    localStorage.removeItem('forgot_otp_cooldown_expires');
                    localStorage.removeItem('forgot_otp_cooldown_email');
                } else {
                    btnSendOtp.innerHTML = '<i class="fas fa-history me-1"></i> Gửi lại sau ' + cooldownSeconds + 's';
                }
            }, 1000);
        }

        // === Gửi OTP (AJAX) ===
        const btnSendOtp = document.getElementById('btnSendOtp');
        const otpSection = document.getElementById('otpSection');

        // Phục hồi trạng thái Cooldown nếu load lại trang (ví dụ lỗi validate form)
        window.addEventListener('DOMContentLoaded', () => {
            const updateLabels = () => {
                document.querySelectorAll('.form-outline input').forEach(input => {
                    const label = document.querySelector(`label[for="${input.id}"]`);
                    if (label) {
                        if (input.value !== '') {
                            label.classList.add('active');
                        } else {
                            label.classList.remove('active');
                        }
                    }
                });
            };

            // Run check on load and after short timeout to let MDB initialize
            updateLabels();
            setTimeout(updateLabels, 100);

            const expires = localStorage.getItem('forgot_otp_cooldown_expires');
            const email = localStorage.getItem('forgot_otp_cooldown_email');
            
            if (expires && email) {
                const remaining = Math.ceil((parseInt(expires) - Date.now()) / 1000);
                if (remaining > 0) {
                    // Điền lại email và hiển thị ô nhập OTP/Mật khẩu
                    const emailInput = document.getElementById('user_email');
                    emailInput.value = email;
                    emailInput.classList.add('active');
                    otpSection.classList.add('show');
                    
                    // Cập nhật lại nhãn sau khi điền giá trị
                    updateLabels();
                    
                    // Tiếp tục chạy đếm ngược cooldown của nút
                    startOtpCooldown(remaining);
                    
                    // Tiếp tục chạy đếm ngược thời gian hết hạn OTP (5 phút)
                    const elapsed = 60 - remaining;
                    const remainingOtpTime = 300 - elapsed;
                    if (remainingOtpTime > 0) {
                        startCountdown(remainingOtpTime);
                    }
                } else {
                    localStorage.removeItem('forgot_otp_cooldown_expires');
                    localStorage.removeItem('forgot_otp_cooldown_email');
                }
            }

            // Lắng nghe sự kiện để cập nhật nhãn khi người dùng nhập dữ liệu
            document.querySelectorAll('.form-outline input').forEach(input => {
                input.addEventListener('input', updateLabels);
                input.addEventListener('change', updateLabels);
                input.addEventListener('blur', updateLabels);
            });
        });

        btnSendOtp.addEventListener('click', function() {
            const email = document.getElementById('user_email').value.trim();

            if (!email) {
                showToast('Vui lòng nhập email!', 'error');
                return;
            }

            // Disable button + show spinner
            btnSendOtp.disabled = true;
            btnSendOtp.innerHTML = '<span class="spinner"></span> Đang gửi...';

            let successSent = false;

            fetch('{{ route("forgot-password.send-otp") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ user_email: email })
            })
            .then(res => {
                if (res.status === 404) {
                    showToast('Email này không tồn tại trong hệ thống!', 'error');
                    throw new Error('Email not found');
                }
                if (!res.ok) {
                    return res.json().then(data => {
                        showToast(data.message || 'Gửi OTP thất bại!', 'error');
                        throw new Error(data.message || 'API error');
                    });
                }
                return res.json();
            })
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    otpSection.classList.add('show');
                    otpInputs[0].focus();
                    
                    // Lưu trạng thái cooldown vào localStorage
                    const expiresAt = Date.now() + 60 * 1000;
                    localStorage.setItem('forgot_otp_cooldown_expires', expiresAt);
                    localStorage.setItem('forgot_otp_cooldown_email', email);

                    startCountdown(300); // 5 phút
                    successSent = true;
                    startOtpCooldown(60); // Khóa nút 60s
                }
            })
            .catch(err => {
                console.error(err);
            })
            .finally(() => {
                if (!successSent) {
                    btnSendOtp.disabled = false;
                    btnSendOtp.innerHTML = '<i class="fas fa-paper-plane me-1"></i> Gửi OTP';
                }
            });
        });

        // === Submit form ===
        document.getElementById('resetForm').addEventListener('submit', function(e) {
            updateHiddenOtp();
            const otp = otpHidden.value;
            const newPassword = document.getElementById('user_password').value;
            const confirmPassword = document.getElementById('user_password_confirmation').value;

            if (otp.length < 6) {
                e.preventDefault();
                showToast('Vui lòng nhập mã OTP gồm 6 chữ số!', 'error');
                return;
            }

            if (newPassword.length < 6) {
                e.preventDefault();
                showToast('Mật khẩu mới phải có tối thiểu 6 ký tự!', 'error');
                return;
            }

            if (newPassword !== confirmPassword) {
                e.preventDefault();
                showToast('Xác nhận mật khẩu mới không khớp!', 'error');
                return;
            }
        });
    </script>
</body>

</html>
