@extends('layouts.app')

@section('title', 'Dịch vụ GSM API - Thuetaikhoan.net')
@section('meta_description', 'Đặt dịch vụ mở khóa, FRP Bypass, iCloud, IMEI Check và các dịch vụ GSM khác với giá tốt nhất')

@section('content')
<div class="ord-services-content">
    <div class="container">
        
        <!-- Mobile Filter Button -->
        <button class="mobile-filter-btn" onclick="toggleSidebar()">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
            </svg>
            Danh mục ({{ count($categories) }})
        </button>
        
        <div class="services-layout">
            <!-- SIDEBAR -->
            <aside class="sidebar" id="sidebar">
                <button class="sidebar-close" onclick="toggleSidebar()">×</button>
                
                <div class="sidebar-header">
                    <div class="sidebar-search">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input type="text" id="searchInput" placeholder="Tìm kiếm dịch vụ..." autocomplete="off" value="{{ $searchQuery }}">
                    </div>
                    <div class="search-dropdown" id="searchDropdown"></div>
                </div>
                
                <nav class="category-list">
                    <!-- Tất cả dịch vụ -->
                    <a href="/ord-services" class="category-item {{ empty($categoryFilter) && empty($searchQuery) ? 'active' : '' }}">
                        <span class="cat-name">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                                <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                            </svg>
                            Tất cả dịch vụ
                        </span>
                        <span class="count">{{ $totalProducts }}</span>
                    </a>
                    
                    @foreach($categories as $cat => $count)
                    <a href="/ord-services?cat={{ urlencode($cat) }}" 
                       class="category-item {{ $categoryFilter === $cat ? 'active' : '' }}">
                        <span class="cat-name">
                            {!! $categoryIcons[$cat] ?? $categoryIcons['Khác'] !!}
                            {{ $cat }}
                        </span>
                        <span class="count">{{ $count }}</span>
                    </a>
                    @endforeach
                </nav>
                
                <div class="sidebar-footer">
                    <div class="total-services">
                        Tổng cộng <strong>{{ $totalProducts }}</strong> dịch vụ
                    </div>
                </div>
            </aside>
            
            <!-- MAIN CONTENT -->
            <main class="main-content">
                <div class="content-header">
                    <div class="breadcrumb">
                        <a href="/">Trang chủ</a>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                        <span>Dịch vụ</span>
                        @if($categoryFilter)
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                        <span>{{ $categoryFilter }}</span>
                        @endif
                    </div>
                    <h1 class="content-title">
                        {{ $categoryFilter ?? 'Tất cả dịch vụ' }}
                        <small>({{ number_format($filteredCount) }} dịch vụ)</small>
                    </h1>
                </div>
                
                @if($apiError)
                <div class="api-warning">
                    <span>⚠️ Đang sử dụng dữ liệu cache do API tạm lỗi: {{ $apiError }}</span>
                </div>
                @endif
                
                @if(count($products) > 0)
                <div class="products-grid" id="productsGrid">
                    @foreach($products as $uuid => $product)
                    <div class="product-card">
                        <div class="product-header">
                            <span class="product-category">{{ $product['category'] }}</span>
                        </div>
                        <h3 class="product-name">{{ $product['name'] }}</h3>
                        <div class="product-body">
                            <div class="product-info">
                                <div class="price-section">
                                    <span class="price-vnd">{{ number_format($product['priceVnd']) }}<small>đ</small></span>
                                </div>
                                <div class="delivery-time">
                                    <span>Thời gian</span>
                                    {{ $product['deliveryTime'] }}
                                </div>
                            </div>
                            <a href="/ord-checkout?uuid={{ $uuid }}" class="btn-order">
                                🛒 Đặt ngay
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Load More -->
                <div class="load-more-container" id="loadMore" style="{{ $filteredCount <= 30 ? 'display:none' : '' }}">
                    <div class="load-more-info">
                        Đã hiển thị <span id="shownCount">{{ min(30, $filteredCount) }}</span> / <span>{{ $filteredCount }}</span> dịch vụ
                    </div>
                    <div class="load-more-spinner" id="loadingSpinner" style="display:none">
                        <div class="spinner"></div>
                        <span>Đang tải thêm...</span>
                    </div>
                </div>
                @else
                <div class="empty-state">
                    <h3>Không tìm thấy dịch vụ</h3>
                    <p>Thử tìm kiếm với từ khóa khác hoặc chọn danh mục.</p>
                    <a href="/ord-services" class="btn-order" style="display:inline-block;margin-top:15px;">Xem tất cả</a>
                </div>
                @endif
            </main>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.ord-services-content {
    background: var(--light, #f8fafc);
    padding: 20px 0 50px;
    min-height: 80vh;
}
.ord-services-content .container {
    max-width: 1600px;
    width: 95%;
}

.services-layout {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 20px;
}

/* SIDEBAR */
.sidebar {
    background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
    border-radius: 20px;
    overflow: hidden;
    position: sticky;
    top: 20px;
    max-height: calc(100vh - 40px);
    display: flex;
    flex-direction: column;
    box-shadow: 0 4px 24px rgba(0,0,0,0.15);
}

.sidebar-header {
    padding: 20px;
    border-bottom: 1px solid #334155;
    position: relative;
}
.sidebar-search {
    display: flex;
    align-items: center;
    background: #334155;
    border-radius: 12px;
    padding: 12px 16px;
    transition: all 0.2s;
}
.sidebar-search:focus-within {
    background: #475569;
    box-shadow: 0 0 0 2px rgba(99,102,241,0.4);
}
.sidebar-search svg { color: #94a3b8; margin-right: 10px; flex-shrink: 0; }
.sidebar-search input {
    background: none;
    border: none;
    color: white;
    font-size: 14px;
    width: 100%;
    outline: none;
}
.sidebar-search input::placeholder { color: #94a3b8; }

.search-dropdown {
    position: absolute;
    top: calc(100% + 8px);
    left: 20px; right: 20px;
    background: white;
    border-radius: 16px;
    max-height: 320px;
    overflow-y: auto;
    display: none;
    z-index: 999;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
}
.search-dropdown.show { display: block; }

.category-list {
    flex: 1;
    overflow-y: auto;
    padding: 8px 0;
}
.category-list::-webkit-scrollbar { width: 5px; }
.category-list::-webkit-scrollbar-thumb { background: #475569; border-radius: 3px; }

.category-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 16px;
    color: #cbd5e1;
    text-decoration: none;
    font-size: 13px;
    transition: all 0.2s;
    border-left: 3px solid transparent;
    margin: 2px 8px;
    border-radius: 8px;
}
.category-item:hover {
    background: rgba(255,255,255,0.08);
    color: white;
}
.category-item.active {
    background: linear-gradient(90deg, rgba(249,115,22,0.2) 0%, transparent 100%);
    border-left-color: #f97316;
    color: #fdba74;
    border-radius: 0 8px 8px 0;
    margin-left: 0;
    padding-left: 16px;
}
.category-item .cat-name {
    display: flex;
    align-items: center;
    gap: 10px;
}
.category-item svg { width: 16px; height: 16px; opacity: 0.7; }
.category-item .count {
    background: rgba(255,255,255,0.1);
    color: #94a3b8;
    padding: 2px 8px;
    border-radius: 10px;
    font-size: 11px;
    font-weight: 600;
}
.category-item.active .count {
    background: #f97316;
    color: white;
}

.sidebar-footer {
    padding: 14px 16px;
    border-top: 1px solid #334155;
    text-align: center;
    background: rgba(0,0,0,0.2);
}
.total-services {
    color: #64748b;
    font-size: 12px;
}
.total-services strong { color: #f97316; }

.sidebar-close {
    display: none;
    position: absolute;
    top: 15px; right: 15px;
    background: #ef4444;
    color: white;
    border: none;
    width: 36px; height: 36px;
    border-radius: 50%;
    font-size: 20px;
    cursor: pointer;
    z-index: 10;
}

/* MAIN CONTENT */
.main-content { min-width: 0; }

.content-header { margin-bottom: 20px; }
.breadcrumb {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: #64748b;
    margin-bottom: 6px;
}
.breadcrumb a { color: #f97316; text-decoration: none; }
.breadcrumb a:hover { text-decoration: underline; }
.breadcrumb svg { width: 12px; height: 12px; opacity: 0.5; }
.content-title {
    font-size: 22px;
    font-weight: 700;
    color: var(--ink, #1e293b);
}
.content-title small {
    font-weight: 400;
    color: #94a3b8;
    font-size: 14px;
}

.api-warning {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #92400e;
    padding: 12px 16px;
    border-radius: 12px;
    margin-bottom: 20px;
    font-size: 13px;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* PRODUCTS GRID */
.products-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}
.product-card {
    background: var(--bg-card, white);
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    transition: all 0.2s ease;
    display: flex;
    flex-direction: column;
    border: 1px solid #e2e8f0;
}
.product-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    border-color: #f97316;
}
.product-header { padding: 16px 16px 0; }
.product-category {
    display: inline-block;
    padding: 5px 12px;
    background: #f1f5f9;
    color: #475569;
    border-radius: 6px;
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.product-name {
    padding: 12px 16px 0;
    font-size: 14px;
    font-weight: 600;
    color: var(--ink, #1e293b);
    line-height: 1.45;
    min-height: 44px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin: 0;
}
.product-body {
    padding: 14px 16px 16px;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.product-info {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 14px;
    flex: 1;
}
.price-vnd {
    font-size: 20px;
    font-weight: 700;
    color: #059669;
}
.price-vnd small { font-size: 13px; font-weight: 600; color: #10b981; }
.delivery-time {
    font-size: 11px;
    color: #64748b;
    text-align: right;
    line-height: 1.3;
}
.delivery-time span {
    display: block;
    font-weight: 600;
    color: #6366f1;
    font-size: 10px;
    margin-bottom: 2px;
}
.btn-order {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    width: 100%;
    padding: 12px;
    background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
    color: white;
    text-decoration: none;
    text-align: center;
    border-radius: 10px;
    font-weight: 600;
    font-size: 13px;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-order:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(249,115,22,0.35);
}

/* LOAD MORE */
.load-more-container {
    text-align: center;
    padding: 30px;
    margin-top: 20px;
}
.load-more-info {
    color: #64748b;
    font-size: 13px;
    margin-bottom: 15px;
}
.load-more-info span { color: #f97316; font-weight: 600; }
.load-more-spinner {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    color: #f97316;
    font-size: 13px;
}
.spinner {
    width: 22px;
    height: 22px;
    border: 3px solid #fed7aa;
    border-top-color: #f97316;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* EMPTY STATE */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: var(--bg-card, white);
    border-radius: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}
.empty-state h3 { color: #64748b; margin-bottom: 8px; }
.empty-state p { color: #94a3b8; }

/* MOBILE */
.mobile-filter-btn {
    display: none;
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, #1e293b, #334155);
    color: white;
    border: none;
    border-radius: 14px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    margin-bottom: 20px;
    align-items: center;
    justify-content: center;
    gap: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

@media (max-width: 1200px) {
    .products-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 900px) {
    .services-layout { grid-template-columns: 1fr; }
    .sidebar {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        z-index: 1000;
        max-height: 100vh;
        border-radius: 0;
    }
    .sidebar.open { display: flex; }
    .sidebar.open .sidebar-close { display: block; }
    .mobile-filter-btn { display: flex; }
    .products-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
}
@media (max-width: 500px) {
    .products-grid { grid-template-columns: 1fr; gap: 14px; }
    .product-name { font-size: 14px; min-height: auto; }
    .price-vnd { font-size: 18px; }
    .btn-order { padding: 12px; font-size: 13px; }
}

/* Dark mode */
[data-theme="dark"] .ord-services-content { background: var(--bg-dark, #0f172a); }
[data-theme="dark"] .api-warning { background: linear-gradient(135deg, #78350f, #92400e); color: #fef3c7; }
[data-theme="dark"] .product-card { border-color: rgba(255,255,255,0.05); }
</style>
@endsection

@section('scripts')
<script>
// All products for infinite scroll
const allProducts = {!! $allProductsJson !!};
let displayedCount = {{ min(30, $filteredCount) }};
const batchSize = 30;
let isLoading = false;

// Infinite scroll
function loadMoreProducts() {
    if (isLoading || displayedCount >= allProducts.length) return;
    
    isLoading = true;
    document.getElementById('loadingSpinner').style.display = 'flex';
    
    setTimeout(() => {
        const grid = document.getElementById('productsGrid');
        const endIndex = Math.min(displayedCount + batchSize, allProducts.length);
        
        for (let i = displayedCount; i < endIndex; i++) {
            const p = allProducts[i];
            const card = document.createElement('div');
            card.className = 'product-card';
            card.innerHTML = `
                <div class="product-header">
                    <span class="product-category">${escapeHtml(p.category)}</span>
                </div>
                <h3 class="product-name">${escapeHtml(p.name)}</h3>
                <div class="product-body">
                    <div class="product-info">
                        <div class="price-section">
                            <span class="price-vnd">${formatNumber(p.priceVnd)}<small>đ</small></span>
                        </div>
                        <div class="delivery-time">
                            <span>Thời gian</span>
                            ${escapeHtml(p.deliveryTime)}
                        </div>
                    </div>
                    <a href="/ord-checkout?uuid=${p.uuid}" class="btn-order">🛒 Đặt ngay</a>
                </div>
            `;
            card.style.animation = 'fadeInUp 0.3s ease';
            grid.appendChild(card);
        }
        
        displayedCount = endIndex;
        document.getElementById('shownCount').textContent = displayedCount;
        
        if (displayedCount >= allProducts.length) {
            document.getElementById('loadMore').style.display = 'none';
        }
        
        isLoading = false;
        document.getElementById('loadingSpinner').style.display = 'none';
    }, 300);
}

// Scroll listener
window.addEventListener('scroll', () => {
    const loadMore = document.getElementById('loadMore');
    if (!loadMore) return;
    
    const rect = loadMore.getBoundingClientRect();
    if (rect.top < window.innerHeight + 200) {
        loadMoreProducts();
    }
});

// Helper functions
function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
function formatNumber(n) {
    return new Intl.NumberFormat('vi-VN').format(n);
}

// Mobile sidebar toggle
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
}

// Search functionality
const searchInput = document.getElementById('searchInput');
const searchDropdown = document.getElementById('searchDropdown');
let searchTimeout;

searchInput.addEventListener('input', function() {
    clearTimeout(searchTimeout);
    const q = this.value.trim();
    
    if (q.length < 2) {
        searchDropdown.classList.remove('show');
        return;
    }
    
    searchTimeout = setTimeout(() => {
        const results = allProducts.filter(p => 
            p.name.toLowerCase().includes(q.toLowerCase())
        ).slice(0, 15);
        
        if (results.length > 0) {
            searchDropdown.innerHTML = results.map(p => `
                <a href="/ord-checkout?uuid=${p.uuid}" class="search-result-item">
                    ${highlightMatch(p.name, q)}
                    <span class="price">${formatNumber(p.priceVnd)}đ</span>
                </a>
            `).join('');
            searchDropdown.classList.add('show');
        } else {
            searchDropdown.innerHTML = '<div class="search-no-result">Không tìm thấy dịch vụ</div>';
            searchDropdown.classList.add('show');
        }
    }, 200);
});

searchInput.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        const q = this.value.trim();
        if (q) window.location.href = '/ord-services?q=' + encodeURIComponent(q);
    }
});

function highlightMatch(text, query) {
    const regex = new RegExp(`(${query})`, 'gi');
    return escapeHtml(text).replace(regex, '<span class="highlight">$1</span>');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('.sidebar-search')) {
        searchDropdown.classList.remove('show');
    }
});

// Animation keyframes
const style = document.createElement('style');
style.textContent = `
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.search-result-item {
    display: block;
    padding: 14px 16px;
    color: #334155;
    text-decoration: none;
    font-size: 14px;
    border-bottom: 1px solid #f1f5f9;
    transition: background 0.2s;
}
.search-result-item:hover { background: #f8fafc; }
.search-result-item .price {
    display: block;
    font-size: 13px;
    color: #10b981;
    margin-top: 4px;
    font-weight: 600;
}
.search-result-item .highlight { 
    background: #6366f1; 
    color: white; 
    padding: 2px 6px; 
    border-radius: 4px; 
}
.search-no-result {
    padding: 24px 20px;
    text-align: center;
    color: #64748b;
    font-size: 14px;
}
`;
document.head.appendChild(style);
</script>
@endsection
