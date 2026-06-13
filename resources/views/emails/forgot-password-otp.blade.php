<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mã OTP Đặt Lại Mật Khẩu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #ec4d4c 0%, #b83534 100%);
            padding: 20px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
            text-align: center;
        }
        .otp-code {
            font-size: 40px;
            font-weight: bold;
            letter-spacing: 8px;
            color: #ec4d4c;
            background-color: #f8f9ff;
            padding: 15px 30px;
            border-radius: 8px;
            display: inline-block;
            margin: 20px 0;
        }
        .notice {
            color: #888;
            font-size: 14px;
            margin-top: 20px;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 15px;
            text-align: center;
            color: #888;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Đặt Lại Mật Khẩu</h1>
        </div>
        <div class="content">
            <p>Chào bạn,</p>
            <p>Vui lòng sử dụng mã OTP dưới đây để hoàn tất việc đặt lại mật khẩu cho tài khoản của bạn:</p>
            <div class="otp-code">{{ $otp }}</div>
            <p>Mã OTP này có hiệu lực trong <strong>5 phút</strong>.</p>
            <p class="notice">Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này hoặc đổi mật khẩu nếu thấy có hoạt động bất thường.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} T-Sports. All rights reserved.
        </div>
    </div>
</body>
</html>
