<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\RecaptchaVerifiable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use RecaptchaVerifiable;

    /**
     * Hiển thị form đăng nhập
     */
    public function showLoginForm()
    {
        // Đã đăng nhập -> chuyển về trang chủ
        if (Auth::check()) {
            return redirect('/');
        }
        
        return view('auth.login');
    }

    /**
     * Xử lý đăng nhập
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ], [
            'email.required' => 'Vui lòng nhập email hoặc số điện thoại',
            'password.required' => 'Vui lòng nhập mật khẩu',
        ]);

        // Verify reCAPTCHA v3
        $recaptchaResponse = $request->input('g-recaptcha-response');
        if ($recaptchaResponse) {
            $recaptchaResult = $this->verifyRecaptcha($recaptchaResponse, 'login');
            if (!$recaptchaResult['success']) {
                throw ValidationException::withMessages([
                    'recaptcha' => $recaptchaResult['message'],
                ]);
            }
        }

        $loginField = $request->input('email');
        $password = $request->input('password');

        // Tìm user theo email hoặc phone
        $user = User::where('email', $loginField)
                    ->orWhere('phone', $loginField)
                    ->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => 'Email hoặc mật khẩu không đúng',
            ]);
        }

        // Kiểm tra tài khoản có bị khóa không
        if (!$user->is_active) {
            throw ValidationException::withMessages([
                'email' => 'Tài khoản đã bị khóa. Vui lòng liên hệ hỗ trợ.',
            ]);
        }

        // Kiểm tra mật khẩu
        if (!Hash::check($password, $user->password_hash)) {
            throw ValidationException::withMessages([
                'email' => 'Email hoặc mật khẩu không đúng',
            ]);
        }

        // Đăng nhập thành công
        Auth::login($user, $request->boolean('remember'));

        // Cập nhật last_login
        $user->update(['last_login' => now()]);

        // Regenerate session
        $request->session()->regenerate();

        return redirect()->intended('/');
    }

    /**
     * Hiển thị form đăng ký
     */
    public function showRegisterForm()
    {
        // Đã đăng nhập -> chuyển về trang chủ
        if (Auth::check()) {
            return redirect('/');
        }
        
        return view('auth.register');
    }

    /**
     * Xử lý đăng ký
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'accepted',
        ], [
            'name.required' => 'Vui lòng nhập họ tên',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email này đã được đăng ký',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp',
            'terms.accepted' => 'Bạn phải đồng ý với điều khoản sử dụng',
        ]);

        // Verify reCAPTCHA v3
        $recaptchaResponse = $request->input('g-recaptcha-response');
        if ($recaptchaResponse) {
            $recaptchaResult = $this->verifyRecaptcha($recaptchaResponse, 'register');
            if (!$recaptchaResult['success']) {
                throw ValidationException::withMessages([
                    'recaptcha' => $recaptchaResult['message'],
                ]);
            }
        }

        // Tạo user mới - password sẽ được hash bởi User model mutator
        $user = User::create([
            'name' => $request->name,
            'fullname' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password, // Mutator sẽ hash và ghi vào cả password + password_hash
            'balance' => 0,
            'role' => 'user',
            'is_active' => true,
        ]);

        // Tự động đăng nhập sau khi đăng ký
        Auth::login($user);

        $request->session()->regenerate();

        return redirect('/')->with('success', 'Đăng ký thành công! Chào mừng bạn đến với ThueTaiKhoan.');
    }

    /**
     * Đăng xuất
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
