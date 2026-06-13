<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\OtpVerification;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;
use App\Mail\ForgotPasswordOtpMail;
use Carbon\Carbon;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showLoginForm()
    {
        return view('client.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('user_email', 'user_password');

        if ($this->authService->login($credentials)) {
            $user = User::where('user_email', $credentials['user_email'])->first();
            if ($user) {
                $request->session()->put('email', $user->user_email);
                $request->session()->put('user_id', $user->id);
                $request->session()->put('role_id', $user->role_id);
                return redirect()->route('home');
            }
        }

        return redirect()->back()->withErrors(['login' => 'Đăng nhập thất bại!']);
    }

    public function logout()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('home');
    }

    /**
     * Hiển thị form đăng ký (1 trang - 4 ô: Email, OTP, Tên, Mật khẩu)
     */
    public function showRegisterForm()
    {
        return view('client.auth.register');
    }

    /**
     * AJAX: Gửi OTP đến email
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'user_email' => 'required|string|email|max:255',
        ]);

        $email = $request->user_email;

        // Kiểm tra email đã tồn tại
        $existingUser = User::where('user_email', $email)->first();
        if ($existingUser) {
            return response()->json([
                'success' => false,
                'message' => 'Email này đã được đăng ký!'
            ], 422);
        }

        // Kiểm tra OTP gửi gần nhất (cooldown 60s)
        $latestOtp = OtpVerification::where('email', $email)
            ->where('is_verified', false)
            ->where('created_at', '>', Carbon::now()->subSeconds(60))
            ->first();

        if ($latestOtp) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đợi 60 giây trước khi yêu cầu gửi mã mới!'
            ], 429);
        }

        // Xóa OTP cũ
        OtpVerification::where('email', $email)->where('is_verified', false)->delete();

        // Tạo OTP 6 số
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Lưu email vào session
        session()->put('register_email', $email);
        // Gửi email
        try {
            Mail::to($email)->send(new SendOtpMail($otp));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Mail OTP send failed: ' . $e->getMessage());
            session()->forget('register_email');
            return response()->json([
                'success' => false,
                'message' => 'Không thể gửi email OTP. Vui lòng thử lại sau!'
            ], 500);
        }

        // Lưu OTP sau khi gửi thành công
        OtpVerification::create([
            'email' => $email,
            'otp' => $otp,
            'expires_at' => Carbon::now()->addMinutes(5),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Mã OTP đã được gửi đến email ' . $email . '!'
        ]);
    }

    /**
     * Đăng ký tài khoản (xác thực OTP + tạo tài khoản cùng lúc)
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'user_email' => 'required|string|email|max:255',
            'otp' => 'required|string|size:6',
            'user_name' => 'required|string|max:255',
            'user_password' => 'required|string|min:6',
        ]);

        $email = $validated['user_email'];

        // Kiểm tra email đã tồn tại
        $existingUser = User::where('user_email', $email)->first();
        if ($existingUser) {
            return redirect()->back()->withErrors(['user_email' => 'Email này đã được đăng ký!'])->withInput();
        }

        // Xác thực OTP
        $otpRecord = OtpVerification::where('email', $email)
            ->where('otp', $validated['otp'])
            ->where('is_verified', false)
            ->where('expires_at', '>', Carbon::now())
            ->latest()
            ->first();

        if (!$otpRecord) {
            return redirect()->back()->withErrors(['otp' => 'Mã OTP không hợp lệ hoặc đã hết hạn!'])->withInput();
        }

        // Đánh dấu OTP đã xác thực
        $otpRecord->update(['is_verified' => true]);

        // Tạo tài khoản
        $this->authService->register([
            'user_name' => $validated['user_name'],
            'user_email' => $email,
            'user_password' => $validated['user_password'],
        ]);

        // Xóa session đăng ký
        session()->forget(['register_email', 'email_verified']);

        return redirect()->route('login')->with('success', 'Đăng ký tài khoản thành công! Vui lòng đăng nhập.');
    }

    /**
     * Hiển thị form quên mật khẩu
     */
    public function showForgotPasswordForm()
    {
        return view('client.auth.forgot-password');
    }

    /**
     * AJAX: Gửi mã OTP quên mật khẩu
     */
    public function sendForgotPasswordOtp(Request $request)
    {
        $request->validate([
            'user_email' => 'required|string|email|max:255',
        ]);

        $email = $request->user_email;

        // Kiểm tra email tồn tại trong DB
        $user = User::where('user_email', $email)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Email này không tồn tại trong hệ thống!'
            ], 404);
        }

        // Kiểm tra OTP gửi gần nhất (cooldown 60s)
        $latestOtp = OtpVerification::where('email', $email)
            ->where('is_verified', false)
            ->where('created_at', '>', Carbon::now()->subSeconds(60))
            ->first();

        if ($latestOtp) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đợi 60 giây trước khi yêu cầu gửi mã mới!'
            ], 429);
        }

        // Xóa OTP cũ
        OtpVerification::where('email', $email)->where('is_verified', false)->delete();

        // Tạo OTP 6 số
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Gửi email
        try {
            Mail::to($email)->send(new ForgotPasswordOtpMail($otp));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Mail Reset Password OTP send failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Không thể gửi email OTP. Vui lòng thử lại sau!'
            ], 500);
        }

        // Lưu OTP
        OtpVerification::create([
            'email' => $email,
            'otp' => $otp,
            'expires_at' => Carbon::now()->addMinutes(5),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Mã OTP đặt lại mật khẩu đã được gửi đến email ' . $email . '!'
        ]);
    }

    /**
     * Đặt lại mật khẩu (xác thực OTP + cập nhật mật khẩu mới)
     */
    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'user_email' => 'required|string|email|max:255',
            'otp' => 'required|string|size:6',
            'user_password' => 'required|string|min:6|confirmed',
        ]);

        $email = $validated['user_email'];

        // Kiểm tra email tồn tại
        $user = User::where('user_email', $email)->first();
        if (!$user) {
            return redirect()->back()->withErrors(['user_email' => 'Email này không tồn tại trên hệ thống!'])->withInput();
        }

        // Xác thực OTP
        $otpRecord = OtpVerification::where('email', $email)
            ->where('otp', $validated['otp'])
            ->where('is_verified', false)
            ->where('expires_at', '>', Carbon::now())
            ->latest()
            ->first();

        if (!$otpRecord) {
            return redirect()->back()->withErrors(['otp' => 'Mã OTP không hợp lệ hoặc đã hết hạn!'])->withInput();
        }

        // Đánh dấu OTP đã xác thực
        $otpRecord->update(['is_verified' => true]);

        // Cập nhật mật khẩu mới (Plain text để đồng bộ với login/register của hệ thống)
        $user->update([
            'user_password' => $validated['user_password']
        ]);

        return redirect()->route('login')->with('success', 'Đặt lại mật khẩu thành công! Vui lòng đăng nhập bằng mật khẩu mới.');
    }
}
