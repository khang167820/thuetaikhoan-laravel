<!-- Mobile Menu Overlay -->
<div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>

<!-- Mobile Menu Panel -->
<nav class="mobile-menu" id="mobileMenu">
    <div class="mobile-menu-header">
        <a href="/" class="mobile-menu-logo">
            <img src="/assets/images/logo.png" alt="logo" onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 36 36%22><rect fill=%22%231e40af%22 width=%2236%22 height=%2236%22 rx=%228%22/><text x=%2218%22 y=%2224%22 fill=%22white%22 font-size=%2218%22 text-anchor=%22middle%22>T</text></svg>'">
            <span>thuetaikhoan.net</span>
        </a>
        <button class="mobile-menu-close" id="mobileMenuClose">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
    </div>
    
    <!-- Search Bar -->
    <div class="mobile-menu-search">
        <form action="/order-history-ip" method="GET" class="mobile-search-form">
            <input type="text" name="order_id" placeholder="Nhập mã đơn hàng...">
            <button type="submit">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </button>
        </form>
        <a href="/order-history-ip" class="mobile-search-history-link">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
            </svg>
            <span>Lịch sử thuê 30 ngày</span>
        </a>
    </div>
    
    <div class="mobile-menu-body">
        <!-- Navigation Links -->
        <a href="/" class="mobile-menu-link <?php echo e(request()->is('/') ? 'active' : ''); ?>">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
            </svg>
            <span>Trang chủ</span>
        </a>
        
        <!-- Services Section (Collapsible) -->
        <button type="button" class="mobile-menu-section-toggle collapsed" onclick="toggleServicesMenu()">
            <span>Dịch vụ GSM</span>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="toggle-icon">
                <polyline points="6 9 12 15 18 9"/>
            </svg>
        </button>
        
        <div class="mobile-services-list collapsed" id="mobileServicesList">
            <a href="/thue-unlocktool" class="mobile-menu-link">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                <span>Unlocktool</span>
            </a>
            
            <a href="/thue-vietmap" class="mobile-menu-link">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"/><line x1="8" y1="2" x2="8" y2="18"/><line x1="16" y1="6" x2="16" y2="22"/>
                </svg>
                <span>Vietmap Live</span>
            </a>
            
            <a href="/thue-tsm" class="mobile-menu-link">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/>
                </svg>
                <span>TSM Tool</span>
            </a>
            
            <a href="/thue-griffin" class="mobile-menu-link">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                </svg>
                <span>Griffin-Unlocker</span>
            </a>
            
            <a href="/thue-amt" class="mobile-menu-link">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2a10 10 0 0 1 10 10 10 10 0 0 1-10 10A10 10 0 0 1 2 12 10 10 0 0 1 12 2z"/>
                    <path d="M12 8v8"/><path d="M8 12h8"/>
                </svg>
                <span>Android Multitool</span>
            </a>
            
            <a href="/thue-kg-killer" class="mobile-menu-link">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
                </svg>
                <span>KG Killer Tool</span>
            </a>
            
            <a href="/thue-samsung-tool" class="mobile-menu-link">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
                <span>Samsung Tool</span>
            </a>
        </div>
        
        <!-- Other Section -->
        <div class="mobile-menu-section">Khác</div>
        
        <a href="#huong-dan" class="mobile-menu-link">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="9" y1="9" x2="15" y2="9"/>
                <line x1="9" y1="13" x2="15" y2="13"/><line x1="9" y1="17" x2="13" y2="17"/>
            </svg>
            <span>Hướng dẫn</span>
        </a>
        
        <a href="/blog" class="mobile-menu-link">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
            </svg>
            <span>Blog</span>
        </a>
        
        <a href="/ord-services" class="mobile-menu-link" style="color: #1e40af; font-weight: 600;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
            </svg>
            <span>Thuê Dịch Vụ Khác</span>
        </a>
        
        <a href="/ma-giam-gia" class="mobile-menu-link">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><line x1="12" y1="22" x2="12" y2="7"/><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/>
            </svg>
            <span>Mã giảm giá</span>
        </a>
        
        <!-- Theme Toggle -->
        <button type="button" class="mobile-menu-link" id="mobileThemeToggle" onclick="toggleMobileTheme()">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="theme-icon-sun" style="display:none;">
                <circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/>
                <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                <line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/>
                <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
            </svg>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="theme-icon-moon">
                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
            </svg>
            <span class="theme-text">Chế độ tối</span>
        </button>
    </div>
    
    <!-- Auth Buttons -->
    <div class="mobile-menu-footer">
        <?php if(auth()->guard()->check()): ?>
        <a href="/account" class="mobile-menu-btn mobile-menu-btn-outline">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
            Tài khoản
        </a>
        <form action="/logout" method="POST" style="flex:1;">
            <?php echo csrf_field(); ?>
            <button type="submit" class="mobile-menu-btn mobile-menu-btn-primary" style="width:100%;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/>
                    <line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
                Đăng xuất
            </button>
        </form>
        <?php else: ?>
        <a href="/login" class="mobile-menu-btn mobile-menu-btn-outline">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/>
                <line x1="15" y1="12" x2="3" y2="12"/>
            </svg>
            Đăng nhập
        </a>
        <a href="/register" class="mobile-menu-btn mobile-menu-btn-primary">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/>
            </svg>
            Đăng ký
        </a>
        <?php endif; ?>
    </div>
</nav>
<?php /**PATH D:\Dowload\thuetaikhoan\thuetaikhoan-laravel\resources\views/partials/mobile-menu.blade.php ENDPATH**/ ?>