@extends('layouts.app')

@section('title', 'Đăng ký tài khoản - ThueTaiKhoan.net')
@section('meta_description', 'Đăng ký tài khoản ThueTaiKhoan.net để thuê tool, tích điểm và nhận ưu đãi đặc biệt.')

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
    max-width: 440px;
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
    gap: 16px;
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
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}
.form-checkbox {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    color: #475569;
    font-size: 13px;
    line-height: 1.5;
}
.form-checkbox input {
    width: 18px;
    height: 18px;
    accent-color: #6366f1;
    margin-top: 2px;
    flex-shrink: 0;
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
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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
    margin-top: 8px;
}
.auth-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(16,185,129,0.3);
}

/* Benefits */
.register-benefits {
    background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
    border: 1px solid #bbf7d0;
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 20px;
}
.benefits-title {
    font-size: 13px;
    font-weight: 700;
    color: #166534;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.benefits-list {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.benefit-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    color: #15803d;
}
.benefit-icon {
    color: #10b981;
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
[data-theme="dark"] .form-input:focus { border-color: #10b981; background: #0f172a; box-shadow: 0 0 0 4px rgba(16,185,129,0.1); }
[data-theme="dark"] .form-checkbox { color: #94a3b8; }
[data-theme="dark"] .form-link { color: #10b981; }
[data-theme="dark"] .register-benefits { background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border-color: #334155; }
[data-theme="dark"] .benefits-title { color: #4ade80; }
[data-theme="dark"] .benefit-item { color: #86efac; }
[data-theme="dark"] .auth-footer { color: var(--muted); }

@media(max-width: 480px) {
    .auth-card { padding: 30px 24px; }
    .form-row { grid-template-columns: 1fr; }
}
</style>
@endsection

@section('content')
<div class="auth-wrap">
    <div class="auth-card">
        <div class="auth-header">
            <img src="/images/services/logo.png" alt="Logo" class="auth-logo" onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 60 60%22><rect fill=%22%231e40af%22 width=%2260%22 height=%2260%22 rx=%2216%22/><text x=%2230%22 y=%2240%22 fill=%22white%22 font-size=%2230%22 text-anchor=%22middle%22>T</text></svg>'">
            <h1 class="auth-title">Tạo tài khoản mới</h1>
            <p class="auth-sub">Đăng ký để thuê tool và nhận ưu đãi</p>
        </div>

        <div class="register-benefits">
            <div class="benefits-title">
                <span>🎁</span> Quyền lợi khi đăng ký
            </div>
            <div class="benefits-list">
                <div class="benefit-item">
                    <span class="benefit-icon">✓</span>
                    <span>Tích điểm mỗi lần thuê, đổi voucher giảm giá</span>
                </div>
                <div class="benefit-item">
                    <span class="benefit-icon">✓</span>
                    <span>Xem lịch sử đơn thuê và tài khoản đã nhận</span>
                </div>
                <div class="benefit-item">
                    <span class="benefit-icon">✓</span>
                    <span>Nhận thông báo khuyến mãi đặc biệt</span>
                </div>
            </div>
        </div>

        <form class="auth-form" method="POST" action="/register">
            @csrf
            
            @if ($errors->any())
            <div style="background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 14px 18px; border-radius: 10px; margin-bottom: 16px; font-size: 14px;">
                <ul style="margin: 0; padding-left: 18px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
            @endif
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Họ và tên</label>
                    <input type="text" name="name" class="form-input" placeholder="Nguyễn Văn A" required value="{{ old('name') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Số điện thoại</label>
                    <input type="tel" name="phone" class="form-input" placeholder="0912345678" value="{{ old('phone') }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input" placeholder="email@example.com" required value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label class="form-label">Mật khẩu</label>
                <input type="password" name="password" class="form-input" placeholder="Tối thiểu 8 ký tự" required minlength="8">
            </div>

            <div class="form-group">
                <label class="form-label">Xác nhận mật khẩu</label>
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
        </form>

        <div class="auth-footer">
            Đã có tài khoản? <a href="/login" class="form-link">Đăng nhập</a>
        </div>
    </div>
</div>
@endsection
