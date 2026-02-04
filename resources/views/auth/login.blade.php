@extends('layouts.app')

@section('title', 'Đăng nhập - ThueTaiKhoan.net')
@section('meta_description', 'Đăng nhập vào tài khoản ThueTaiKhoan.net để quản lý đơn thuê, xem lịch sử và nhận ưu đãi.')

@push('head')
<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key', '6LegMlIsAAAAALh9UGh23nn8c_J5Gq_MbiVNrtTY') }}"></script>
<style>.grecaptcha-badge { visibility: hidden !important; }</style>
@endpush

@section('styles')
<style>
/* Auth Page Styles */
.auth-wrap {
    min-height: 70vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
}
.auth-card {
    width: 100%;
    max-width: 420px;
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(15,23,42,.1);
    padding: 40px;
    border: 1px solid #e5e7eb;
}
.auth-header {
    text-align: center;
    margin-bottom: 30px;
}
.auth-logo {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    margin-bottom: 16px;
}
.auth-title {
    font-size: 24px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 8px;
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
}
.form-input {
    padding: 14px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    font-size: 15px;
    transition: all 0.2s;
    outline: none;
    background: #f8fafc;
}
.form-input:focus {
    border-color: #6366f1;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(99,102,241,0.1);
}
.form-input::placeholder {
    color: #9ca3af;
}
.form-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
}
.form-checkbox {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #475569;
}
.form-checkbox input {
    width: 16px;
    height: 16px;
    accent-color: #6366f1;
}
.form-link {
    color: #6366f1;
    font-weight: 600;
    text-decoration: none;
}
.form-link:hover {
    text-decoration: underline;
}
.auth-btn {
    padding: 16px;
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
.auth-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(99,102,241,0.3);
}

/* Divider */
.auth-divider {
    display: flex;
    align-items: center;
    gap: 16px;
    color: #9ca3af;
    font-size: 13px;
    margin: 10px 0;
}
.auth-divider::before, .auth-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #e5e7eb;
}

/* Social Login */
.social-btns {
    display: flex;
    gap: 12px;
}
.social-btn {
    flex: 1;
    padding: 12px;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    background: #fff;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    color: #374151;
}
.social-btn:hover {
    border-color: #6366f1;
    background: #f8fafc;
}

/* Footer */
.auth-footer {
    text-align: center;
    margin-top: 24px;
    font-size: 14px;
    color: #64748b;
}

/* Dark Mode */
[data-theme="dark"] .auth-card { background: var(--bg-card); border-color: #334155; }
[data-theme="dark"] .auth-title { color: var(--ink); }
[data-theme="dark"] .auth-sub { color: var(--muted); }
[data-theme="dark"] .form-label { color: #cbd5e1; }
[data-theme="dark"] .form-input { background: #1e293b; border-color: #334155; color: var(--ink); }
[data-theme="dark"] .form-input:focus { border-color: #60a5fa; background: #0f172a; box-shadow: 0 0 0 4px rgba(96,165,250,0.1); }
[data-theme="dark"] .form-checkbox { color: #94a3b8; }
[data-theme="dark"] .form-link { color: #60a5fa; }
[data-theme="dark"] .auth-divider::before, [data-theme="dark"] .auth-divider::after { background: #334155; }
[data-theme="dark"] .social-btn { background: var(--bg-card); border-color: #334155; color: #cbd5e1; }
[data-theme="dark"] .social-btn:hover { border-color: #60a5fa; background: #1e293b; }
[data-theme="dark"] .auth-footer { color: var(--muted); }

@media(max-width: 480px) {
    .auth-card { padding: 30px 24px; }
    .social-btns { flex-direction: column; }
}
</style>
@endsection

@section('content')
<div class="auth-wrap">
    <div class="auth-card">
        <div class="auth-header">
            <img src="/images/services/logo.png" alt="Logo" class="auth-logo" onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 60 60%22><rect fill=%22%231e40af%22 width=%2260%22 height=%2260%22 rx=%2216%22/><text x=%2230%22 y=%2240%22 fill=%22white%22 font-size=%2230%22 text-anchor=%22middle%22>T</text></svg>'">
            <h1 class="auth-title">Đăng nhập</h1>
            <p class="auth-sub">Chào mừng bạn quay trở lại</p>
        </div>

        <form class="auth-form" method="POST" action="/login" id="loginForm">
            @csrf
            <input type="hidden" name="g-recaptcha-response" id="recaptcha-response">
            
            @if ($errors->any())
            <div style="background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 14px 18px; border-radius: 10px; margin-bottom: 16px; font-size: 14px;">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
            @endif
            
            <div class="form-group">
                <label class="form-label">Email hoặc Số điện thoại</label>
                <input type="text" name="email" class="form-input" placeholder="Nhập email hoặc SĐT" required value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label class="form-label">Mật khẩu</label>
                <input type="password" name="password" class="form-input" placeholder="Nhập mật khẩu" required>
            </div>

            <div class="form-row">
                <label class="form-checkbox">
                    <input type="checkbox" name="remember">
                    <span>Ghi nhớ đăng nhập</span>
                </label>
                <a href="/forgot-password" class="form-link">Quên mật khẩu?</a>
            </div>

            <button type="submit" class="auth-btn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                    <polyline points="10 17 15 12 10 7"/>
                    <line x1="15" y1="12" x2="3" y2="12"/>
                </svg>
                Đăng nhập
            </button>
            
            <div style="font-size: 11px; color: #94a3b8; text-align: center; margin-top: 8px;">
                Trang này được bảo vệ bởi reCAPTCHA và tuân theo <a href="https://policies.google.com/privacy" target="_blank" style="color: #6366f1;">Chính sách bảo mật</a> của Google.
            </div>
        </form>

        <div class="auth-divider">hoặc</div>

        <div class="social-btns">
            <button type="button" class="social-btn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="#4285F4"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                Google
            </button>
            <button type="button" class="social-btn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="#1877F2"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                Facebook
            </button>
        </div>

        <div class="auth-footer">
            Chưa có tài khoản? <a href="/register" class="form-link">Đăng ký ngay</a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('loginForm');
    const recaptchaInput = document.getElementById('recaptcha-response');
    const siteKey = '{{ config('services.recaptcha.site_key', '6LegMlIsAAAAALh9UGh23nn8c_J5Gq_MbiVNrtTY') }}';
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (typeof grecaptcha !== 'undefined') {
            grecaptcha.ready(function() {
                grecaptcha.execute(siteKey, {action: 'login'}).then(function(token) {
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
