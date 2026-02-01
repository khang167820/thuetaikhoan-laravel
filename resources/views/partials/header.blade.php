<!-- SHARED HEADER -->
<header class="site-header">
    <div class="header-main">
        <div class="container header-inner">
            <!-- Left: Logo + Navigation -->
            <div class="header-left">
                <!-- Logo -->
                <a class="header-brand" href="/">
                    <img class="header-logo" src="/assets/images/logo.png" alt="logo" onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 36 36%22><rect fill=%22%231e40af%22 width=%2236%22 height=%2236%22 rx=%228%22/><text x=%2218%22 y=%2224%22 fill=%22white%22 font-size=%2218%22 text-anchor=%22middle%22>T</text></svg>'">
                    <div class="header-brand-text">
                        <span class="brand-name">thuetaikhoan.net</span>
                        <span class="brand-tagline">Thuê tài khoản tự động 24/7</span>
                    </div>
                </a>
                
                <!-- Navigation -->
                <nav class="header-nav">
                    <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                        <span class="nav-icon-box">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                <polyline points="9 22 9 12 15 12 15 22"/>
                            </svg>
                        </span>
                        Trang chủ
                    </a>
                    <div class="nav-dropdown">
                        <a href="#fast-order" class="nav-link">
                            <span class="nav-icon-box">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="3" width="7" height="7"/>
                                    <rect x="14" y="3" width="7" height="7"/>
                                    <rect x="14" y="14" width="7" height="7"/>
                                    <rect x="3" y="14" width="7" height="7"/>
                                </svg>
                            </span>
                            Dịch vụ
                            <svg class="nav-arrow-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="6 9 12 15 18 9"/>
                            </svg>
                        </a>
                        <div class="nav-dropdown-menu">
                            <a href="/thue-unlocktool"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 9.9-1"/></svg> Unlocktool</a>
                            <a href="/thue-vietmap"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="10" r="3"/><path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 1 0-16 0c0 3 2.7 7 8 11.7z"/></svg> Vietmap Live</a>
                            <a href="/thue-tsm"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg> TSM Tool</a>
                            <a href="/thue-griffin"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg> Griffin-Unlocker</a>
                            <a href="/thue-amt"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg> Android Multitool</a>
                            <a href="/thue-kg-killer"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M15 9l-6 6M9 9l6 6"/></svg> KG Killer Tool</a>
                            <a href="/thue-samsung-tool"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg> Samsung Tool</a>
                            <div style="border-top: 1px solid #e5e7eb; margin: 8px 0;"></div>
                            <a href="/ord-services" class="dropdown-cta">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                </svg>
                                Thuê Dịch Vụ Khác
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <a href="#huong-dan" class="nav-link">
                        <span class="nav-icon-box">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                            </svg>
                        </span>
                        Hướng dẫn
                    </a>
                    <a href="/blog" class="nav-link {{ request()->is('blog*') ? 'active' : '' }}">
                        <span class="nav-icon-box">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                            </svg>
                        </span>
                        Blog
                    </a>
                </nav>
            </div>

            <!-- Right: Auth -->
            <div class="header-right">
                <!-- Lịch sử thuê dropdown -->
                <div class="header-history-dropdown">
                    <div class="nav-dropdown">
                        <a href="#" class="nav-link" id="historyNavLink">
                            <span class="nav-icon-box">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                    <line x1="16" y1="13" x2="8" y2="13"/>
                                    <line x1="16" y1="17" x2="8" y2="17"/>
                                </svg>
                            </span>
                            Lịch sử thuê
                            <svg class="nav-arrow-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="6 9 12 15 18 9"/>
                            </svg>
                        </a>
                        <div class="nav-dropdown-menu history-menu">
                            <a href="/order-history-ip">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                    <line x1="16" y1="13" x2="8" y2="13"/>
                                    <line x1="16" y1="17" x2="8" y2="17"/>
                                </svg>
                                Lịch sử thuê 30 ngày
                            </a>
                            <div class="history-search-in-dropdown">
                                <form class="history-search-form-dropdown" action="/order-detail">
                                    <input type="text" name="code" placeholder="Tìm mã đơn hàng..." class="history-search-input-dropdown">
                                    <button type="submit" class="history-search-btn-dropdown">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="11" cy="11" r="8"/>
                                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Auth buttons -->
                <div class="header-auth">
                    @auth
                    {{-- Đã đăng nhập --}}
                    <div class="user-balance">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                        </svg>
                        <span>{{ number_format(Auth::user()->balance ?? 0, 0, ',', '.') }}đ</span>
                    </div>
                    <div class="nav-dropdown user-dropdown">
                        <a href="#" class="user-btn">
                            <span class="user-avatar">{{ substr(Auth::user()->name ?? Auth::user()->fullname ?? 'U', 0, 1) }}</span>
                            <span class="user-name">{{ Auth::user()->name ?? Auth::user()->fullname ?? 'User' }}</span>
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="6 9 12 15 18 9"/>
                            </svg>
                        </a>
                        <div class="nav-dropdown-menu">
                            <a href="/account">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                                Tài khoản
                            </a>
                            <a href="/order-history">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                </svg>
                                Lịch sử đơn hàng
                            </a>
                            <a href="/deposit">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                                    <line x1="1" y1="10" x2="23" y2="10"/>
                                </svg>
                                Nạp tiền
                            </a>
                            <div style="border-top: 1px solid #e5e7eb; margin: 8px 0;"></div>
                            <form action="/logout" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" class="logout-btn">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                        <polyline points="16 17 21 12 16 7"/>
                                        <line x1="21" y1="12" x2="9" y2="12"/>
                                    </svg>
                                    Đăng xuất
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    {{-- Chưa đăng nhập --}}
                    <a href="/login" class="auth-login-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                            <polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/>
                        </svg>
                        Đăng nhập
                    </a>
                    <a href="/register" class="auth-register-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="8.5" cy="7" r="4"/>
                            <line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/>
                        </svg>
                        Đăng ký
                    </a>
                    @endauth
                    <button class="theme-toggle" id="theme-toggle" title="Chuyển đổi ban ngày/đêm">
                        <span id="theme-icon">🌙</span>
                    </button>
                </div>
            </div>

            <!-- Mobile menu button -->
            <button class="btn-mobile-menu" id="mobileMenuBtn" aria-label="Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>
</header>

<!-- Mobile Menu Overlay -->
<div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>

<!-- Mobile Menu Panel -->
<nav class="mobile-menu" id="mobileMenu">
    <div class="mobile-menu-header">
        <a href="/" class="mobile-menu-logo">
            <img src="/assets/images/logo.png" alt="logo" onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 36 36%22><rect fill=%22%231e40af%22 width=%2236%22 height=%2236%22 rx=%228%22/><text x=%2218%22 y=%2224%22 fill=%22white%22 font-size=%2218%22 text-anchor=%22middle%22>T</text></svg>'">
            <span>thuetaikhoan.net</span>
        </a>
        <button class="mobile-menu-close" id="mobileMenuClose">&times;</button>
    </div>
    
    <div class="mobile-menu-body">
        <a href="/" class="mobile-menu-link {{ request()->is('/') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Trang chủ
        </a>
        
        <div class="mobile-menu-section">Dịch vụ</div>
        <a href="/thue-unlocktool" class="mobile-menu-link">🔓 Unlocktool</a>
        <a href="/thue-vietmap" class="mobile-menu-link">🗺️ Vietmap Live</a>
        <a href="/thue-tsm" class="mobile-menu-link">📱 TSM Tool</a>
        <a href="/thue-griffin" class="mobile-menu-link">🦅 Griffin-Unlocker</a>
        <a href="/thue-amt" class="mobile-menu-link">🤖 Android Multitool</a>
        <a href="/thue-kg-killer" class="mobile-menu-link">⚡ KG Killer Tool</a>
        <a href="/thue-samsung-tool" class="mobile-menu-link">🛡️ Samsung Tool</a>
        <a href="/ord-services" class="mobile-menu-link" style="color: var(--primary); font-weight: 600;">📦 Thuê Dịch Vụ Khác</a>
        
        <div class="mobile-menu-section">Khác</div>
        <a href="#huong-dan" class="mobile-menu-link">📖 Hướng dẫn</a>
        <a href="/blog" class="mobile-menu-link">📝 Blog</a>
        <a href="/order-history-ip" class="mobile-menu-link">📋 Lịch sử thuê</a>
        <a href="/ma-giam-gia" class="mobile-menu-link">🎁 Mã giảm giá</a>
        
        <div class="mobile-menu-section">Tài khoản</div>
        @auth
        <a href="/account" class="mobile-menu-link">👤 Tài khoản</a>
        <a href="/deposit" class="mobile-menu-link">💳 Nạp tiền</a>
        <form action="/logout" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" class="mobile-menu-link" style="width: 100%; text-align: left; background: none; border: none; font: inherit; cursor: pointer;">🚪 Đăng xuất</button>
        </form>
        @else
        <a href="/login" class="mobile-menu-link">🔐 Đăng nhập</a>
        <a href="/register" class="mobile-menu-link">📝 Đăng ký</a>
        @endauth
    </div>
</nav>

<style>
/* Mobile Menu Styles */
.mobile-menu-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    z-index: 9998;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s;
}
.mobile-menu-overlay.active {
    opacity: 1;
    visibility: visible;
}

.mobile-menu {
    position: fixed;
    top: 0;
    right: -300px;
    width: 280px;
    height: 100%;
    background: #fff;
    z-index: 9999;
    transition: right 0.3s ease;
    overflow-y: auto;
    box-shadow: -4px 0 20px rgba(0,0,0,0.1);
}
.mobile-menu.active {
    right: 0;
}

.mobile-menu-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px;
    border-bottom: 1px solid #e5e7eb;
}
.mobile-menu-logo {
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    color: #1e293b;
    font-weight: 700;
}
.mobile-menu-logo img {
    width: 36px;
    height: 36px;
    border-radius: 8px;
}
.mobile-menu-close {
    width: 36px;
    height: 36px;
    border: none;
    background: #f1f5f9;
    border-radius: 8px;
    font-size: 24px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.mobile-menu-body {
    padding: 16px;
}
.mobile-menu-section {
    font-size: 11px;
    font-weight: 700;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin: 20px 0 10px;
    padding-left: 12px;
}
.mobile-menu-section:first-child {
    margin-top: 0;
}
.mobile-menu-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    color: #334155;
    text-decoration: none;
    border-radius: 10px;
    font-size: 14px;
    transition: all 0.2s;
}
.mobile-menu-link:hover, .mobile-menu-link.active {
    background: #f1f5f9;
    color: var(--primary, #1e40af);
}
.mobile-menu-link svg {
    flex-shrink: 0;
}

/* Dark mode */
[data-theme="dark"] .mobile-menu {
    background: #1e293b;
}
[data-theme="dark"] .mobile-menu-header {
    border-color: #334155;
}
[data-theme="dark"] .mobile-menu-logo {
    color: #f1f5f9;
}
[data-theme="dark"] .mobile-menu-close {
    background: #334155;
    color: #f1f5f9;
}
[data-theme="dark"] .mobile-menu-link {
    color: #cbd5e1;
}
[data-theme="dark"] .mobile-menu-link:hover {
    background: #334155;
}
</style>

<script>
// Mobile Menu Toggle
document.addEventListener('DOMContentLoaded', function() {
    const menuBtn = document.getElementById('mobileMenuBtn');
    const menuClose = document.getElementById('mobileMenuClose');
    const menu = document.getElementById('mobileMenu');
    const overlay = document.getElementById('mobileMenuOverlay');
    
    function openMenu() {
        menu.classList.add('active');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    
    function closeMenu() {
        menu.classList.remove('active');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }
    
    if (menuBtn) menuBtn.addEventListener('click', openMenu);
    if (menuClose) menuClose.addEventListener('click', closeMenu);
    if (overlay) overlay.addEventListener('click', closeMenu);
    
    // Close on ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeMenu();
    });
    
    // Close menu when clicking links
    document.querySelectorAll('.mobile-menu-link').forEach(function(link) {
        link.addEventListener('click', function() {
            if (!this.getAttribute('href')?.startsWith('#')) {
                closeMenu();
            }
        });
    });
});
</script>
