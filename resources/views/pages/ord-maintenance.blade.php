@extends('layouts.app')

@section('title', 'Đang bảo trì - Dịch vụ ADY')

@section('content')
<style>
.maintenance-page {
    min-height: 70vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
}
.maintenance-card {
    max-width: 500px;
    background: white;
    border-radius: 24px;
    padding: 48px 40px;
    text-align: center;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    border: 1px solid #e2e8f0;
}
.maintenance-icon {
    font-size: 64px;
    margin-bottom: 24px;
}
.maintenance-title {
    font-size: 28px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 16px;
}
.maintenance-desc {
    font-size: 16px;
    color: #64748b;
    line-height: 1.6;
    margin-bottom: 32px;
}
.maintenance-btn {
    display: inline-block;
    padding: 14px 32px;
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    color: white;
    text-decoration: none;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.2s;
}
.maintenance-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(99,102,241,0.3);
}
</style>

<section class="maintenance-page">
    <div class="maintenance-card">
        <div class="maintenance-icon">🔧</div>
        <h1 class="maintenance-title">Đang bảo trì</h1>
        <p class="maintenance-desc">
            Dịch vụ đặt hàng ADY đang được nâng cấp.<br>
            Vui lòng quay lại sau ít phút.<br><br>
            Xin lỗi vì sự bất tiện này!
        </p>
        <a href="/" class="maintenance-btn">← Về trang chủ</a>
    </div>
</section>
@endsection
