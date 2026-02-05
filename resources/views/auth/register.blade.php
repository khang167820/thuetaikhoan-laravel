@extends('layouts.app')

@section('title', 'Đăng ký tài khoản - ThueTaiKhoan.net')
@section('meta_description', 'Đăng ký tài khoản ThueTaiKhoan.net để thuê tool, tích điểm và nhận ưu đãi đặc biệt.')

@push('head')
<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key', '6LegMlIsAAAAALh9UGh23nn8c_J5Gq_MbiVNrtTY') }}"></script>
<style>.grecaptcha-badge { visibility: hidden !important; }</style>
@endpush

@section('styles')
<style>
/* ===============================================
   PREMIUM REGISTER PAGE STYLES
   =============================================== */

/* Background with gradient */
.auth-wrap {
    min-height: calc(100vh - 80px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 25%, #f0fdf4 50%, #ecfdf5 75%, #fdf4ff 100%);
    position: relative;
    overflow: hidden;
}

/* Animated background shapes */
.auth-wrap::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: 
        radial-gradient(circle at 20% 80%, rgba(16, 185, 129, 0.08) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(99, 102, 241, 0.08) 0%, transparent 50%),
        radial-gradient(circle at 40% 40%, rgba(244, 63, 94, 0.05) 0%, transparent 40%);
    animation: floatBg 20s ease-in-out infinite;
    pointer-events: none;
}

@keyframes floatBg {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    25% { transform: translate(2%, 1%) rotate(1deg); }
    50% { transform: translate(0%, 2%) rotate(0deg); }
    75% { transform: translate(-1%, 1%) rotate(-1deg); }
}

/* Main container */
.auth-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    max-width: 1000px;
    width: 100%;
    background: #fff;
    border-radius: 28px;
    box-shadow: 
        0 25px 50px -12px rgba(0, 0, 0, 0.1),
        0 0 0 1px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    position: relative;
    z-index: 1;
}

/* Left side - Illustration / Info */
.auth-sidebar {
    background: linear-gradient(145deg, #10b981 0%, #059669 50%, #047857 100%);
    padding: 48px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.auth-sidebar::before {
    content: '';
    position: absolute;
    top: -100px;
    right: -100px;
    width: 300px;
    height: 300px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}

.auth-sidebar::after {
    content: '';
    position: absolute;
    bottom: -60px;
    left: -60px;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.08);
    border-radius: 50%;
}

.sidebar-content {
    position: relative;
    z-index: 1;
}

.sidebar-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.2);
    color: #fff;
    padding: 8px 16px;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 24px;
    backdrop-filter: blur(10px);
}

.sidebar-title {
    font-size: 32px;
    font-weight: 800;
    color: #fff;
    margin: 0 0 16px;
    line-height: 1.2;
}

.sidebar-desc {
    font-size: 15px;
    color: rgba(255, 255, 255, 0.9);
    margin: 0 0 32px;
    line-height: 1.6;
}

.sidebar-features {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.sidebar-feature {
    display: flex;
    align-items: center;
    gap: 14px;
    background: rgba(255, 255, 255, 0.15);
    padding: 14px 18px;
    border-radius: 14px;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.sidebar-feature:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateX(5px);
}

.feature-icon {
    width: 44px;
    height: 44px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

.feature-text {
    flex: 1;
}

.feature-title {
    font-size: 14px;
    font-weight: 700;
    color: #fff;
    margin-bottom: 2px;
}

.feature-desc {
    font-size: 12px;
    color: rgba(255, 255, 255, 0.8);
}

/* Right side - Form */
.auth-card {
    padding: 48px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.auth-header {
    margin-bottom: 32px;
}

/* Welcome badge */
.auth-welcome-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    border: 1px solid #bbf7d0;
    color: #166534;
    padding: 8px 16px;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 20px;
    animation: fadeInDown 0.5s ease;
}

.welcome-emoji {
    font-size: 18px;
    animation: wave 1.5s ease-in-out infinite;
}

@keyframes wave {
    0%, 100% { transform: rotate(0deg); }
    25% { transform: rotate(20deg); }
    75% { transform: rotate(-10deg); }
}

@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Title with gradient */
.auth-title {
    font-size: 32px;
    font-weight: 800;
    margin: 0 0 12px;
    line-height: 1.2;
    display: flex;
    flex-direction: column;
}

.title-line1 {
    color: #0f172a;
}

.title-line2 {
    background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}


.auth-sub {
    color: #64748b;
    font-size: 14px;
    margin: 0;
}

/* Form */
.auth-form {
    display: flex;
    flex-direction: column;
    gap: 18px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.form-label {
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    display: flex;
    align-items: center;
    gap: 4px;
}

.form-label .label-icon {
    color: #10b981;
}

.form-input {
    padding: 14px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    font-size: 15px;
    transition: all 0.25s ease;
    outline: none;
    background: #f8fafc;
}

.form-input:hover {
    border-color: #cbd5e1;
}

.form-input:focus {
    border-color: #10b981;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
}

.form-input::placeholder {
    color: #9ca3af;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}

/* Password strength */
.password-strength {
    display: flex;
    gap: 4px;
    margin-top: 6px;
}

.strength-bar {
    flex: 1;
    height: 4px;
    background: #e5e7eb;
    border-radius: 2px;
    transition: all 0.3s ease;
}

.strength-bar.active {
    background: #ef4444;
}

.strength-bar.medium {
    background: #f59e0b;
}

.strength-bar.strong {
    background: #10b981;
}

.password-hint {
    font-size: 11px;
    color: #94a3b8;
    margin-top: 4px;
}

/* Checkbox */
.form-checkbox {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    color: #475569;
    font-size: 13px;
    line-height: 1.6;
    padding: 4px 0;
}

.form-checkbox input[type="checkbox"] {
    appearance: none;
    width: 20px;
    height: 20px;
    border: 2px solid #d1d5db;
    border-radius: 6px;
    cursor: pointer;
    flex-shrink: 0;
    margin-top: 1px;
    transition: all 0.2s ease;
    position: relative;
}

.form-checkbox input[type="checkbox"]:checked {
    background: #10b981;
    border-color: #10b981;
}

.form-checkbox input[type="checkbox"]:checked::after {
    content: '✓';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: #fff;
    font-size: 12px;
    font-weight: bold;
}

.form-checkbox input[type="checkbox"]:hover {
    border-color: #10b981;
}

.form-link {
    color: #10b981;
    font-weight: 600;
    text-decoration: none;
    transition: color 0.2s ease;
}

.form-link:hover {
    color: #059669;
    text-decoration: underline;
}

/* Submit button */
.auth-btn {
    padding: 16px 24px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #fff;
    border: none;
    border-radius: 14px;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-top: 8px;
    position: relative;
    overflow: hidden;
}

.auth-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s ease;
}

.auth-btn:hover::before {
    left: 100%;
}

.auth-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(16, 185, 129, 0.35);
}

.auth-btn:active {
    transform: translateY(0);
}

/* Error box */
.error-box {
    background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
    border: 1px solid #fecaca;
    border-left: 4px solid #ef4444;
    color: #dc2626;
    padding: 14px 18px;
    border-radius: 12px;
    font-size: 14px;
}

.error-box ul {
    margin: 0;
    padding-left: 18px;
}

.error-box li {
    margin-bottom: 4px;
}

.error-box li:last-child {
    margin-bottom: 0;
}

/* reCAPTCHA notice */
.recaptcha-notice {
    font-size: 11px;
    color: #94a3b8;
    text-align: center;
    margin-top: 12px;
    line-height: 1.5;
}

.recaptcha-notice a {
    color: #10b981;
    text-decoration: none;
}

.recaptcha-notice a:hover {
    text-decoration: underline;
}

/* Footer */
.auth-footer {
    text-align: center;
    margin-top: 24px;
    padding-top: 20px;
    border-top: 1px solid #f1f5f9;
    font-size: 14px;
    color: #64748b;
}

/* ===============================================
   DARK MODE
   =============================================== */
[data-theme="dark"] .auth-wrap {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
}

[data-theme="dark"] .auth-wrap::before {
    background: 
        radial-gradient(circle at 20% 80%, rgba(16, 185, 129, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(99, 102, 241, 0.1) 0%, transparent 50%);
}

[data-theme="dark"] .auth-container {
    background: #1e293b;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
}

[data-theme="dark"] .auth-sidebar {
    background: linear-gradient(145deg, #059669 0%, #047857 50%, #065f46 100%);
}

[data-theme="dark"] .auth-card {
    background: #1e293b;
}

[data-theme="dark"] .auth-welcome-badge {
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    border-color: #334155;
    color: #4ade80;
}

[data-theme="dark"] .title-line1 {
    color: #f1f5f9;
}

[data-theme="dark"] .auth-sub {
    color: #94a3b8;
}

[data-theme="dark"] .form-label {
    color: #cbd5e1;
}

[data-theme="dark"] .form-input {
    background: #0f172a;
    border-color: #334155;
    color: #f1f5f9;
}

[data-theme="dark"] .form-input:hover {
    border-color: #475569;
}

[data-theme="dark"] .form-input:focus {
    border-color: #10b981;
    background: #0f172a;
    box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
}

[data-theme="dark"] .form-checkbox {
    color: #94a3b8;
}

[data-theme="dark"] .form-checkbox input[type="checkbox"] {
    border-color: #475569;
    background: #1e293b;
}

[data-theme="dark"] .auth-footer {
    color: #94a3b8;
    border-color: #334155;
}

[data-theme="dark"] .error-box {
    background: linear-gradient(135deg, #450a0a 0%, #7f1d1d 100%);
    border-color: #991b1b;
    color: #fca5a5;
}

[data-theme="dark"] .password-hint {
    color: #64748b;
}

[data-theme="dark"] .recaptcha-notice {
    color: #64748b;
}

/* ===============================================
   RESPONSIVE
   =============================================== */
@media (max-width: 900px) {
    .auth-container {
        grid-template-columns: 1fr;
        max-width: 480px;
    }
    
    .auth-sidebar {
        display: none;
    }
    
    .auth-card {
        padding: 40px 32px;
    }
}

@media (max-width: 480px) {
    .auth-wrap {
        padding: 20px 16px;
    }
    
    .auth-card {
        padding: 32px 24px;
    }
    
    .auth-container {
        border-radius: 20px;
    }
    
    .auth-title {
        font-size: 22px;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .auth-btn {
        padding: 14px 20px;
    }
}
</style>
@endsection

@section('content')
<div class="auth-wrap">
    <div class="auth-container">
        <!-- Left Side - Info -->
        <div class="auth-sidebar">
            <div class="sidebar-content">
                <div class="sidebar-badge">
                    <span>🎉</span> Đăng ký miễn phí
                </div>
                <h2 class="sidebar-title">Tham gia cộng đồng<br>GSM Technician</h2>
                <p class="sidebar-desc">Hàng ngàn kỹ thuật viên đang sử dụng ThueTaiKhoan.net để thuê tool chuyên nghiệp với giá tốt nhất.</p>
                
                <div class="sidebar-features">
                    <div class="sidebar-feature">
                        <div class="feature-icon">🎁</div>
                        <div class="feature-text">
                            <div class="feature-title">Tích điểm mỗi đơn</div>
                            <div class="feature-desc">Đổi voucher giảm giá hấp dẫn</div>
                        </div>
                    </div>
                    <div class="sidebar-feature">
                        <div class="feature-icon">📋</div>
                        <div class="feature-text">
                            <div class="feature-title">Quản lý đơn thuê</div>
                            <div class="feature-desc">Xem lịch sử và tài khoản đã nhận</div>
                        </div>
                    </div>
                    <div class="sidebar-feature">
                        <div class="feature-icon">🔔</div>
                        <div class="feature-text">
                            <div class="feature-title">Thông báo ưu đãi</div>
                            <div class="feature-desc">Nhận khuyến mãi độc quyền</div>
                        </div>
                    </div>
                    <div class="sidebar-feature">
                        <div class="feature-icon">⚡</div>
                        <div class="feature-text">
                            <div class="feature-title">Thanh toán nhanh</div>
                            <div class="feature-desc">Lưu thông tin, checkout 1-click</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Side - Form -->
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-welcome-badge">
                    <span class="welcome-emoji">👋</span>
                    <span>Chào mừng bạn!</span>
                </div>
                <h1 class="auth-title">
                    <span class="title-line1">Tạo tài khoản</span>
                    <span class="title-line2">mới ngay</span>
                </h1>
                <p class="auth-sub">Chỉ mất 30 giây để bắt đầu hành trình của bạn</p>
            </div>

            <form class="auth-form" method="POST" action="/register" id="registerForm">
                @csrf
                <input type="hidden" name="g-recaptcha-response" id="recaptcha-response">
                
                @if ($errors->any())
                <div class="error-box">
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
                @endif
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">
                            <span class="label-icon">👤</span> Họ và tên
                        </label>
                        <input type="text" name="name" class="form-input" placeholder="Nguyễn Văn A" required value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">
                            <span class="label-icon">📱</span> Số điện thoại
                        </label>
                        <input type="tel" name="phone" class="form-input" placeholder="0912345678" value="{{ old('phone') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <span class="label-icon">✉️</span> Email
                    </label>
                    <input type="email" name="email" class="form-input" placeholder="email@example.com" required value="{{ old('email') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <span class="label-icon">🔒</span> Mật khẩu
                    </label>
                    <input type="password" name="password" id="password" class="form-input" placeholder="Tối thiểu 8 ký tự" required minlength="8">
                    <div class="password-strength">
                        <div class="strength-bar" id="str1"></div>
                        <div class="strength-bar" id="str2"></div>
                        <div class="strength-bar" id="str3"></div>
                        <div class="strength-bar" id="str4"></div>
                    </div>
                    <div class="password-hint" id="password-hint">Sử dụng chữ hoa, chữ thường, số và ký tự đặc biệt</div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <span class="label-icon">🔐</span> Xác nhận mật khẩu
                    </label>
                    <input type="password" name="password_confirmation" class="form-input" placeholder="Nhập lại mật khẩu" required>
                </div>

                <label class="form-checkbox">
                    <input type="checkbox" name="terms" required>
                    <span>Tôi đồng ý với <a href="/dieu-khoan" class="form-link">Điều khoản sử dụng</a> và <a href="/chinh-sach" class="form-link">Chính sách bảo mật</a></span>
                </label>

                <button type="submit" class="auth-btn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="8.5" cy="7" r="4"/>
                        <line x1="20" y1="8" x2="20" y2="14"/>
                        <line x1="23" y1="11" x2="17" y2="11"/>
                    </svg>
                    Đăng ký tài khoản
                </button>
                
                <div class="recaptcha-notice">
                    Trang này được bảo vệ bởi reCAPTCHA và tuân theo <a href="https://policies.google.com/privacy" target="_blank">Chính sách bảo mật</a> của Google.
                </div>
            </form>

            <div class="auth-footer">
                Đã có tài khoản? <a href="/login" class="form-link">Đăng nhập ngay</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registerForm');
    const recaptchaInput = document.getElementById('recaptcha-response');
    const siteKey = '{{ config('services.recaptcha.site_key', '6LegMlIsAAAAALh9UGh23nn8c_J5Gq_MbiVNrtTY') }}';
    
    // Password strength checker
    const passwordInput = document.getElementById('password');
    const strengthBars = [
        document.getElementById('str1'),
        document.getElementById('str2'),
        document.getElementById('str3'),
        document.getElementById('str4')
    ];
    const hint = document.getElementById('password-hint');
    
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        let strength = 0;
        
        if (password.length >= 8) strength++;
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
        if (/\d/.test(password)) strength++;
        if (/[^a-zA-Z0-9]/.test(password)) strength++;
        
        // Reset all bars
        strengthBars.forEach((bar, i) => {
            bar.className = 'strength-bar';
            if (i < strength) {
                bar.classList.add('active');
                if (strength >= 3) bar.classList.add('strong');
                else if (strength === 2) bar.classList.add('medium');
            }
        });
        
        // Update hint
        if (strength === 0) hint.textContent = 'Sử dụng chữ hoa, chữ thường, số và ký tự đặc biệt';
        else if (strength === 1) hint.textContent = '🔴 Mật khẩu yếu';
        else if (strength === 2) hint.textContent = '🟡 Mật khẩu trung bình';
        else if (strength === 3) hint.textContent = '🟢 Mật khẩu mạnh';
        else hint.textContent = '💪 Mật khẩu rất mạnh!';
    });
    
    // Form submit with reCAPTCHA
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (typeof grecaptcha !== 'undefined') {
            grecaptcha.ready(function() {
                grecaptcha.execute(siteKey, {action: 'register'}).then(function(token) {
                    recaptchaInput.value = token;
                    form.submit();
                });
            });
        } else {
            form.submit();
        }
    });
});
</script>
@endsection
