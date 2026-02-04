@extends('layouts.app')

@section('title', 'Dịch vụ GSM API - Thuetaikhoan.net')
@section('meta_description', 'Đặt dịch vụ mở khóa, FRP Bypass, iCloud, IMEI Check và các dịch vụ GSM khác với API tự động 24/7')

@section('content')
<section class="ord-services-section">
    <div class="container">
        <div class="ord-services-header">
            <h1>🌐 Dịch vụ GSM API</h1>
            <p>Đặt hàng 5,000+ dịch vụ mở khóa, bypass, kiểm tra IMEI tự động 24/7</p>
        </div>
        
        <div class="ord-services-layout">
            <!-- Sidebar Categories -->
            <aside class="ord-sidebar">
                <h3>📁 Danh mục</h3>
                <ul class="ord-categories">
                    <li><a href="/ord-services" class="{{ empty($category) ? 'active' : '' }}">Tất cả dịch vụ</a></li>
                    @foreach($categories as $key => $label)
                        <li><a href="/ord-services?cat={{ urlencode($key) }}" class="{{ $category === $key ? 'active' : '' }}">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </aside>
            
            <!-- Main Content -->
            <main class="ord-main">
                <div class="ord-notice">
                    <div class="notice-icon">🚧</div>
                    <div class="notice-content">
                        <h3>Tính năng đang phát triển</h3>
                        <p>Hệ thống đặt dịch vụ API GSM đang được hoàn thiện. Vui lòng liên hệ Zalo để được hỗ trợ trực tiếp.</p>
                        <div class="notice-actions">
                            <a href="https://zalo.me/0777333763" target="_blank" class="btn-primary">
                                💬 Zalo Mai Quyên
                            </a>
                            <a href="tel:0777333763" class="btn-secondary">
                                📞 0777 333 763
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="ord-services-info">
                    <h2>Các dịch vụ hỗ trợ</h2>
                    <div class="services-grid">
                        <div class="service-card">
                            <span class="service-icon">📱</span>
                            <h4>Unlock iPhone</h4>
                            <p>Mở khóa nhà mạng, Factory Unlock</p>
                        </div>
                        <div class="service-card">
                            <span class="service-icon">🔓</span>
                            <h4>iCloud & FMI</h4>
                            <p>Bypass, xóa iCloud, FMI OFF</p>
                        </div>
                        <div class="service-card">
                            <span class="service-icon">🔍</span>
                            <h4>IMEI Check</h4>
                            <p>Kiểm tra thông tin IMEI chi tiết</p>
                        </div>
                        <div class="service-card">
                            <span class="service-icon">🤖</span>
                            <h4>FRP Bypass</h4>
                            <p>Xóa tài khoản Google Samsung, Xiaomi</p>
                        </div>
                        <div class="service-card">
                            <span class="service-icon">📊</span>
                            <h4>Data Services</h4>
                            <p>Tra cứu dữ liệu thiết bị</p>
                        </div>
                        <div class="service-card">
                            <span class="service-icon">🛠️</span>
                            <h4>Công cụ GSM</h4>
                            <p>Các tool chuyên dụng</p>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
.ord-services-section {
    padding: 40px 0;
    min-height: 70vh;
    background: var(--light);
}

.ord-services-header {
    text-align: center;
    margin-bottom: 40px;
}

.ord-services-header h1 {
    font-size: 2rem;
    font-weight: 800;
    color: var(--ink);
    margin-bottom: 10px;
}

.ord-services-header p {
    color: var(--muted);
    font-size: 1.1rem;
}

.ord-services-layout {
    display: grid;
    grid-template-columns: 250px 1fr;
    gap: 30px;
}

/* Sidebar */
.ord-sidebar {
    background: var(--bg-card);
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    height: fit-content;
    position: sticky;
    top: 100px;
}

.ord-sidebar h3 {
    font-size: 1rem;
    font-weight: 700;
    margin-bottom: 16px;
    color: var(--ink);
}

.ord-categories {
    list-style: none;
    padding: 0;
    margin: 0;
}

.ord-categories li {
    margin-bottom: 8px;
}

.ord-categories a {
    display: block;
    padding: 10px 14px;
    border-radius: 8px;
    color: var(--muted);
    font-weight: 500;
    transition: all 0.2s;
}

.ord-categories a:hover,
.ord-categories a.active {
    background: var(--primary);
    color: #fff;
}

/* Main content */
.ord-main {
    min-height: 400px;
}

.ord-notice {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    border-radius: 16px;
    padding: 30px;
    display: flex;
    gap: 20px;
    margin-bottom: 30px;
}

.notice-icon {
    font-size: 48px;
}

.notice-content h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #92400e;
    margin-bottom: 10px;
}

.notice-content p {
    color: #a16207;
    margin-bottom: 16px;
}

.notice-actions {
    display: flex;
    gap: 12px;
}

.btn-primary {
    padding: 10px 20px;
    background: #1e40af;
    color: #fff;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.2s;
}

.btn-primary:hover {
    background: #1e3a8a;
    transform: translateY(-2px);
}

.btn-secondary {
    padding: 10px 20px;
    background: #fff;
    color: #1e40af;
    border-radius: 8px;
    font-weight: 600;
    border: 2px solid #1e40af;
    transition: all 0.2s;
}

.btn-secondary:hover {
    background: #1e40af;
    color: #fff;
}

/* Services Info */
.ord-services-info {
    background: var(--bg-card);
    border-radius: 16px;
    padding: 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.ord-services-info h2 {
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 20px;
    color: var(--ink);
}

.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 16px;
}

.service-card {
    padding: 20px;
    background: var(--light);
    border-radius: 12px;
    text-align: center;
    transition: all 0.2s;
}

.service-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.service-icon {
    font-size: 32px;
    display: block;
    margin-bottom: 10px;
}

.service-card h4 {
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--ink);
    margin-bottom: 6px;
}

.service-card p {
    font-size: 0.8rem;
    color: var(--muted);
}

/* Responsive */
@media (max-width: 768px) {
    .ord-services-layout {
        grid-template-columns: 1fr;
    }
    
    .ord-sidebar {
        position: static;
    }
    
    .ord-notice {
        flex-direction: column;
        text-align: center;
    }
    
    .notice-actions {
        justify-content: center;
        flex-wrap: wrap;
    }
}

/* Dark mode */
[data-theme="dark"] .ord-notice {
    background: linear-gradient(135deg, #78350f, #92400e);
}

[data-theme="dark"] .notice-content h3,
[data-theme="dark"] .notice-content p {
    color: #fef3c7;
}
</style>
@endsection
