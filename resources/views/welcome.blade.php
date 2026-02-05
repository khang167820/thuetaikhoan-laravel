<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thuê GSM Tool & Unlock Services – Unlocktool, TSM Tool, Vietmap Live, Griffin, AMT | ThueTaiKhoan.net</title>
    <meta name="description" content="ThueTaiKhoan.net cung cấp dịch vụ thuê tài khoản UnlockTool, Vietmap Live, TSM Tool, Griffin-Unlocker và nhiều phần mềm kỹ thuật số khác. Hệ thống tự động, giá cạnh tranh, hỗ trợ nhanh chóng 24/7.">
    
    <!-- Organization Schema -->
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "Organization",
        "name": "Thuetaikhoan.net",
        "url": "https://thuetaikhoan.net",
        "logo": "https://thuetaikhoan.net/images/logo.png",
        "description": "Hệ thống cho thuê tài khoản UnlockTool, Vietmap Live, Griffin, TSM Tool tự động 24/7",
        "contactPoint": {
            "@@type": "ContactPoint",
            "contactType": "customer service",
            "availableLanguage": "Vietnamese"
        }
    }
    </script>
    
    <!-- WebSite Schema with SearchAction -->
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "WebSite",
        "name": "Thuetaikhoan.net",
        "url": "https://thuetaikhoan.net",
        "potentialAction": {
            "@@type": "SearchAction",
            "target": {
                "@@type": "EntryPoint",
                "urlTemplate": "https://thuetaikhoan.net/tim-kiem?q={search_term_string}"
            },
            "query-input": "required name=search_term_string"
        }
    }
    </script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Modern UI Enhancement -->
    <link rel="stylesheet" href="/css/modern-ui.css?v=6">
    
    <!-- Mobile Menu Styles -->
    <link rel="stylesheet" href="/css/mobile-menu.css?v=1">
    
    <style>
        /* ============================================
           CSS VARIABLES - Giống trang cũ
           ============================================ */
        :root {
            --primary: #1e40af;
            --primary-dark: #1e3a8a;
            --accent: #f97316;
            --accent-dark: #ea580c;
            --ink: #1f2937;
            --muted: #6b7280;
            --light: #f8fafc;
            --line: #e5e7eb;
            --success: #10b981;
            --warning: #f59e0b;
            --error: #ef4444;
            --bg: #ffffff;
            --bg-card: #ffffff;
            
            --font-main: 'Be Vietnam Pro', system-ui, -apple-system, sans-serif;
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.08);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.1);
            --shadow-lg: 0 8px 30px rgba(0,0,0,0.12);
        }
        
        /* Dark Theme */
        [data-theme="dark"] {
            --primary: #60a5fa;
            --primary-dark: #3b82f6;
            --ink: #f1f5f9;
            --muted: #94a3b8;
            --light: #1e293b;
            --line: #334155;
            --bg: #0f172a;
            --bg-card: #1e293b;
        }
        [data-theme="dark"] .site-header { background: var(--bg); }
        [data-theme="dark"] .fo-card { background: var(--bg-card); border-color: #475569; }
        [data-theme="dark"] .fo-title { color: var(--ink); }
        [data-theme="dark"] .tool-search-bar { background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); }
        [data-theme="dark"] .tool-search-form { background: #334155; border-color: #475569; }
        [data-theme="dark"] .tool-search-input { color: #fff; }
        [data-theme="dark"] .mega-services-banner { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); }
        [data-theme="dark"] .guide-column, [data-theme="dark"] .payment-column { background: var(--bg-card); border-color: #334155; }
        [data-theme="dark"] .feature-highlight-card { background: var(--bg-card); border-color: #334155; }
        [data-theme="dark"] .site-footer { background: var(--bg); }
        [data-theme="dark"] .guide-payment-section { background: #0f172a; }
        [data-theme="dark"] .fast-order-wrap { background: var(--bg); }

        /* HERO SECTION - Modern */
        .hero-modern {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 50%, #020617 100%);
            padding: 60px 20px;
            text-align: center;
            color: #fff;
        }
        .hero-content {
            max-width: 800px;
            margin: 0 auto;
        }
        .hero-title {
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 16px;
            line-height: 1.2;
        }
        .hero-title-accent {
            color: #fbbf24;
        }
        .hero-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 24px;
            line-height: 1.6;
        }
        .search-modern {
            display: flex;
            max-width: 600px;
            margin: 0 auto 24px;
            background: #fff;
            border-radius: 50px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0,0,0,0.2);
        }
        .search-modern input {
            flex: 1;
            padding: 16px 24px;
            border: none;
            font-size: 15px;
            outline: none;
            color: #333;
        }
        .search-modern input::placeholder {
            color: #9ca3af;
            opacity: 1;
        }
        .search-modern button {
            padding: 16px 28px;
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: #fff;
            border: none;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
        }
        .hero-stats {
            display: flex;
            justify-content: center;
            gap: 40px;
            flex-wrap: wrap;
        }
        .hero-stat {
            text-align: center;
        }
        .hero-stat-number {
            display: block;
            font-size: 1.8rem;
            font-weight: 800;
            color: #fbbf24;
        }
        .hero-stat-label {
            font-size: 13px;
            opacity: 0.8;
        }
        @media (max-width: 768px) {
            .hero-title { font-size: 1.6rem; }
            .hero-modern { padding: 40px 16px; }
            .hero-stats { gap: 24px; }
            .hero-stat-number { font-size: 1.4rem; }
        }

        /* RESET & BASE */
        *, *::before, *::after { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: var(--font-main);
            font-size: 15px;
            line-height: 1.6;
            color: var(--ink);
            background: var(--bg);
            -webkit-font-smoothing: antialiased;
            transition: background 0.3s, color 0.3s;
        }
        a { color: inherit; text-decoration: none; }
        img { max-width: 100%; height: auto; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }

        /* ============================================
           HEADER - Giống trang cũ
           ============================================ */
        .site-header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: #fff;
            box-shadow: var(--shadow-sm);
        }
        .header-main {
            padding: 12px 0;
            border-bottom: 1px solid var(--line);
        }
        .header-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            max-width: 100%;
            padding: 0 20px;
        }
        .header-left {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .header-right {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-left: auto;
        }

        /* Brand */
        .header-brand {
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            margin-right: 8px;
        }
        .header-logo {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-sm);
        }
        .header-brand-text {
            display: flex;
            flex-direction: column;
        }
        .brand-name {
            font-size: 16px;
            font-weight: 800;
            color: var(--primary);
            line-height: 1.2;
        }
        .brand-tagline {
            font-size: 10px;
            color: var(--muted);
            font-weight: 500;
            white-space: nowrap;
        }

        /* Navigation */
        .header-nav {
            display: flex;
            align-items: center;
            gap: 0;
        }
        .nav-link {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 8px 10px;
            font-size: 13px;
            font-weight: 600;
            color: var(--ink);
            border-radius: var(--radius-sm);
            transition: all 0.2s ease;
            white-space: nowrap;
        }
        .nav-link:hover {
            background: var(--light);
            color: var(--primary);
        }
        .nav-link.active {
            color: var(--primary);
            background: #eff6ff;
        }
        .nav-icon-box {
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f3f4f6;
            border-radius: 6px;
            color: #6b7280;
            transition: all 0.2s ease;
        }
        .nav-link:hover .nav-icon-box {
            background: #dbeafe;
            color: var(--primary);
        }
        .nav-arrow-icon {
            margin-left: 2px;
            opacity: 0.5;
        }

        /* Dropdown */
        .nav-dropdown { position: relative; }
        .nav-dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 200px;
            background: #fff;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-lg);
            padding: 8px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.2s ease;
            z-index: 100;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        .nav-dropdown:hover .nav-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .nav-dropdown-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            color: #374151;
            font-size: 14px;
            font-weight: 500;
            border-radius: 6px;
            transition: all 0.15s ease;
        }
        .nav-dropdown-menu a:hover {
            background: #f0f7ff;
            color: #2563eb;
        }
        .nav-dropdown-menu a svg {
            width: 16px;
            height: 16px;
            color: #9ca3af;
        }
        .nav-dropdown-menu a:hover svg {
            color: #2563eb;
        }
        
        /* Dropdown CTA Button - Premium Style */
        .nav-dropdown-menu .dropdown-cta {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: #fff !important;
            font-weight: 600;
            border-radius: 8px;
            margin-top: 4px;
            padding: 10px 14px;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(249, 115, 22, 0.25);
            transition: all 0.2s ease;
            white-space: nowrap;
        }
        .nav-dropdown-menu .dropdown-cta:hover {
            background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.35);
        }
        .nav-dropdown-menu .dropdown-cta svg { color: #fff !important; }

        /* History Dropdown */
        .header-history-dropdown { position: relative; display: flex; align-items: center; flex-shrink: 0; margin-right: 12px; }
        .header-history-dropdown .nav-dropdown { position: relative; }
        .header-history-dropdown .nav-link {
            display: flex; align-items: center; gap: 8px; padding: 8px 16px;
            background: #fff; border: 1px solid #e5e7eb; border-radius: 12px;
            font-size: 13px; font-weight: 600; color: var(--ink); transition: all 0.2s;
        }
        .header-history-dropdown .nav-link:hover { background: #f9fafb; border-color: var(--primary); color: var(--primary); }
        .header-history-dropdown .nav-icon-box {
            width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;
            background: #f3f4f6; border-radius: 6px; color: #6b7280; transition: all 0.2s;
        }
        .header-history-dropdown .nav-link:hover .nav-icon-box { background: #dbeafe; color: var(--primary); }
        .header-history-dropdown .nav-arrow-icon { margin-left: 2px; opacity: 0.5; }
        .header-history-dropdown .nav-dropdown-menu { right: 0; left: auto; min-width: 260px; }
        .header-history-dropdown .history-menu { padding: 0; }
        .history-search-in-dropdown { padding: 12px; border-top: 1px solid #f1f5f9; }
        .history-search-form-dropdown {
            display: flex; align-items: center;
            background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden;
        }
        .history-search-form-dropdown:focus-within { border-color: var(--primary); background: #fff; box-shadow: 0 0 0 3px rgba(30,64,175,0.1); }
        .history-search-input-dropdown {
            flex: 1; padding: 10px 12px; border: none; background: transparent;
            font-size: 13px; outline: none; color: var(--ink);
        }
        .history-search-input-dropdown::placeholder { color: #9ca3af; }
        .history-search-btn-dropdown {
            padding: 10px 12px; background: var(--primary); border: none; cursor: pointer;
            color: #fff; display: flex; align-items: center; justify-content: center; transition: all 0.2s;
        }
        .history-search-btn-dropdown:hover { background: var(--primary-dark); }
        
        /* Dark mode for history dropdown */
        [data-theme="dark"] .header-history-dropdown .nav-link { background: var(--bg-card); border-color: #334155; }
        [data-theme="dark"] .header-history-dropdown .nav-link:hover { border-color: #60a5fa; }
        [data-theme="dark"] .header-history-dropdown .nav-icon-box { background: #1e293b; color: #94a3b8; }
        [data-theme="dark"] .history-search-in-dropdown { border-color: #334155; }
        [data-theme="dark"] .history-search-form-dropdown { background: #1e293b; border-color: #334155; }
        [data-theme="dark"] .history-search-input-dropdown { color: #f1f5f9; }
        
        /* Theme Toggle Button */
        .theme-toggle-btn {
            display: flex; align-items: center; justify-content: center;
            width: 40px; height: 40px;
            background: #f1f5f9; border: none; border-radius: 10px;
            cursor: pointer; transition: all 0.2s;
        }
        .theme-toggle-btn:hover { background: #e2e8f0; }
        .theme-toggle-btn svg { color: #64748b; }
        [data-theme="dark"] .theme-toggle-btn { background: #334155; }
        [data-theme="dark"] .theme-toggle-btn:hover { background: #475569; }
        [data-theme="dark"] .theme-toggle-btn svg { color: #fbbf24; }

        /* Auth buttons */
        .header-auth {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .auth-login-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 8px 14px;
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            background: var(--primary);
            border-radius: 8px;
            border: 2px solid var(--primary);
            transition: all 0.2s ease;
        }
        .auth-login-btn:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }
        .auth-register-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 8px 14px;
            font-size: 13px;
            font-weight: 600;
            color: var(--ink);
            background: transparent;
            border-radius: 8px;
            border: 2px solid #e5e7eb;
            transition: all 0.2s ease;
        }
        .auth-register-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        /* User Balance */
        .user-balance {
            display: flex; align-items: center; gap: 6px;
            padding: 6px 12px; font-size: 13px; font-weight: 600;
            background: #ecfdf5; color: #059669; border-radius: 8px;
        }
        .user-balance svg { color: #10b981; }
        
        /* User Dropdown */
        .user-dropdown { position: relative; }
        .user-btn {
            display: flex; align-items: center; gap: 8px;
            padding: 6px 12px; font-size: 13px; font-weight: 600;
            color: var(--ink); border-radius: 10px; cursor: pointer;
            border: 1px solid #e5e7eb; transition: all 0.2s;
        }
        .user-btn:hover { border-color: var(--primary); color: var(--primary); }
        .user-avatar {
            width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: #fff; border-radius: 8px; font-size: 13px; font-weight: 700;
        }
        .user-name { max-width: 100px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .logout-btn {
            display: flex; align-items: center; gap: 10px; width: 100%; padding: 10px 14px;
            background: none; border: none; cursor: pointer;
            color: #dc2626; font-size: 14px; font-weight: 500; border-radius: 6px; transition: all 0.15s;
        }
        .logout-btn:hover { background: #fef2f2; }
        .logout-btn svg { color: #dc2626; }
        
        /* Dark mode for user elements */
        [data-theme="dark"] .user-balance { background: #064e3b; color: #a7f3d0; }
        [data-theme="dark"] .user-btn { border-color: #475569; }
        [data-theme="dark"] .user-btn:hover { border-color: #60a5fa; }

        /* Mobile menu button */
        .btn-mobile-menu {
            display: none;
            flex-direction: column;
            gap: 4px;
            padding: 8px;
            background: none;
            border: none;
            cursor: pointer;
        }
        .btn-mobile-menu span {
            display: block;
            width: 20px;
            height: 2px;
            background: var(--ink);
            transition: all 0.2s;
        }

        /* ===== SEARCH BAR ===== */
        .tool-search-bar {
            padding: 12px 20px;
            background: linear-gradient(135deg, #f0f4ff 0%, #fdf4ff 100%);
            border-bottom: 1px solid #e5e7eb;
        }
        .tool-search-inner {
            max-width: 900px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }
        .tool-search-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            flex-shrink: 0;
        }
        .tool-search-content { flex-shrink: 0; }
        .tool-search-title {
            display: block;
            font-size: 14px;
            font-weight: 700;
            color: #1f2937;
        }
        .tool-search-desc {
            font-size: 12px;
            color: #6b7280;
        }
        .tool-search-form {
            flex: 1;
            display: flex;
            min-width: 280px;
            background: #fff;
            border-radius: 25px;
            border: 2px solid #e5e7eb;
            overflow: hidden;
            transition: all 0.2s;
        }
        .tool-search-form:focus-within {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
        }
        .tool-search-input {
            flex: 1;
            padding: 10px 18px;
            border: none;
            font-size: 14px;
            outline: none;
            background: transparent;
        }
        .tool-search-btn {
            padding: 10px 20px;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: #fff;
            border: none;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        /* ===== FAST ORDER BLOCK ===== */
        .fast-order-wrap {
            background: #fff;
            padding: 24px 16px 20px;
        }
        .fast-order {
            max-width: 1280px;
            margin: 0 auto;
        }
        .fast-order-title {
            text-align: center;
            margin-bottom: 8px;
            font-size: 22px;
            font-weight: 800;
        }
        .fast-order-sub {
            text-align: center;
            color: #6b7280;
            margin-bottom: 24px;
            font-size: 13px;
        }
        .fast-order-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            align-items: stretch;
        }

        /* ===== CARD DỊCH VỤ - Giống trang cũ ===== */
        .fo-card {
            position: relative;
            background: #ffffff;
            border-radius: 24px;
            border: 3px solid #f97316;
            padding: 20px 18px 16px;
            display: flex;
            flex-direction: column;
            overflow: visible;
            box-shadow: 0 8px 20px rgba(249, 115, 22, 0.15), 0 4px 8px rgba(0,0,0,.1);
            transition: transform .18s ease-out, box-shadow .18s ease-out, border-color .18s ease-out;
            height: 100%;
        }
        .fo-card:hover {
            transform: translateY(-6px) scale(1.02);
            border-color: #ea580c;
            box-shadow: 0 14px 32px rgba(249, 115, 22, 0.25), 0 6px 12px rgba(0,0,0,.15);
        }
        .fo-ribbon {
            position: absolute;
            top: -13px;
            left: 18px;
            padding: 3px 12px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
            background: #ff4b4b;
            color: #fff;
            box-shadow: 0 4px 10px rgba(0,0,0,.12);
        }
        .fo-coupon-pill {
            position: absolute;
            top: -13px;
            right: 18px;
            padding: 3px 12px;
            border-radius: 999px;
            background: #2563eb;
            border: 1px solid #1d4ed8;
            color: #fff;
            font-size: 11px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0,0,0,.12);
        }
        .fo-coupon-pill:hover {
            background: #1d4ed8;
        }
        .fo-logo-wrap {
            margin: 8px 0 10px;
            display: flex;
            justify-content: center;
        }
        .fo-logo-circle {
            width: 90px;
            height: 90px;
            border-radius: 999px;
            background: #ffffff;
            border: 2px solid #fed7aa;
            box-shadow: 0 4px 10px rgba(0,0,0,.10);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .fo-logo-circle img {
            width: 70px;
            height: 70px;
            object-fit: contain;
            border-radius: 50%;
            background: #fff;
        }
        .fo-title {
            text-align: center;
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 2px;
        }
        .fo-subline {
            text-align: center;
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 6px;
        }
        .fo-features {
            list-style: none;
            padding: 0;
            margin: 0 0 4px;
            font-size: 13px;
            max-height: 52px;
            overflow: hidden;
            position: relative;
        }
        .fo-features.expanded {
            max-height: none;
        }
        .fo-features li {
            margin-bottom: 4px;
            display: flex;
            gap: 6px;
            align-items: flex-start;
        }
        .fo-dot {
            width: 7px;
            height: 7px;
            border-radius: 999px;
            margin-top: 6px;
            flex-shrink: 0;
        }
        .fo-dot.yellow { background: #facc15; }
        .fo-dot.blue { background: #2563eb; }
        .fo-dot.orange { background: #fb923c; }
        .fo-dot.green { background: #16a34a; }
        .fo-dot.red { background: #ef4444; }
        .fo-dot.purple { background: #a855f7; }
        .fo-feature-text { flex: 1; }
        .fo-feature-hidden { display: none; }
        .fo-features.expanded .fo-feature-hidden { display: flex; }
        .fo-more {
            align-self: flex-start;
            margin: 0 0 6px;
            padding: 0;
            border: none;
            background: none;
            font-size: 12px;
            font-weight: 500;
            color: #2563eb;
            cursor: pointer;
        }
        .fo-bottom-btn {
            margin-top: auto;
            width: 100%;
            border: none;
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            background: #dc2626;
            box-shadow: 0 6px 20px rgba(249, 115, 22, 0.4);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all .3s;
            text-transform: uppercase;
            text-decoration: none;
        }
        .fo-bottom-btn:hover {
            background: #b91c1c;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(220, 38, 38, 0.5);
        }
        .fo-btn-price {
            font-weight: 800;
            font-size: 18px;
        }
        .fo-btn-price-old {
            font-size: 13px;
            text-decoration: line-through;
            opacity: 0.75;
        }

        /* ===== MEGA SERVICES BANNER - REDESIGNED ===== */
        .mega-services-banner {
            position: relative;
            background: linear-gradient(145deg, #0c1222 0%, #1a1f3a 40%, #0f172a 100%);
            padding: 70px 24px;
            overflow: hidden;
        }
        .mega-services-banner::before {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 60%;
            height: 100%;
            background: radial-gradient(ellipse at 100% 50%, rgba(99, 102, 241, 0.12) 0%, transparent 60%);
            pointer-events: none;
        }
        .mega-services-banner::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0;
            width: 50%;
            height: 100%;
            background: radial-gradient(ellipse at 0% 100%, rgba(249, 115, 22, 0.08) 0%, transparent 50%);
            pointer-events: none;
        }
        .mega-services-bg {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: 
                url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.02'%3E%3Ccircle cx='30' cy='30' r='1'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }
        .mega-services-container {
            position: relative;
            z-index: 1;
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 60px;
            align-items: center;
        }
        .mega-services-content { color: #fff; }
        .mega-services-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #f97316 0%, #ef4444 100%);
            color: #fff;
            padding: 8px 16px;
            border-radius: 24px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 24px;
            animation: badgePulse 2s ease-in-out infinite;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        @keyframes badgePulse {
            0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(249, 115, 22, 0.5); }
            50% { transform: scale(1.02); box-shadow: 0 0 20px 5px rgba(249, 115, 22, 0.3); }
        }
        .mega-services-title {
            font-size: 2.8rem;
            font-weight: 900;
            line-height: 1.15;
            margin-bottom: 18px;
            letter-spacing: -0.5px;
        }
        .mega-highlight {
            background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 50%, #f472b6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .mega-services-desc {
            font-size: 1.1rem;
            color: #a1a1aa;
            line-height: 1.7;
            margin-bottom: 32px;
        }
        .mega-stats {
            display: flex;
            gap: 40px;
            margin-bottom: 36px;
        }
        .mega-stat { 
            text-align: center;
            position: relative;
        }
        .mega-stat:not(:last-child)::after {
            content: '';
            position: absolute;
            right: -20px;
            top: 50%;
            transform: translateY(-50%);
            width: 1px;
            height: 40px;
            background: linear-gradient(180deg, transparent, rgba(255,255,255,0.2), transparent);
        }
        .mega-stat-number {
            display: block;
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 4px;
        }
        .mega-stat-label {
            font-size: 13px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .mega-services-btn {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: linear-gradient(135deg, #3b82f6 0%, #6366f1 50%, #8b5cf6 100%);
            color: #fff;
            padding: 16px 32px;
            border-radius: 16px;
            font-size: 16px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 8px 30px rgba(99, 102, 241, 0.35);
            border: 1px solid rgba(255,255,255,0.1);
        }
        .mega-services-btn:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 16px 40px rgba(99, 102, 241, 0.5);
        }
        .mega-categories {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
        }
        .mega-cat {
            display: flex;
            align-items: center;
            gap: 14px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px;
            padding: 16px 18px;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            backdrop-filter: blur(8px);
        }
        .mega-cat:hover {
            background: rgba(255,255,255,0.08);
            border-color: rgba(255,255,255,0.2);
            transform: translateY(-3px) translateX(5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .mega-cat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
            transition: transform 0.3s ease;
        }
        .mega-cat:hover .mega-cat-icon {
            transform: scale(1.1) rotate(5deg);
        }
        .mega-cat-info {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }
        .mega-cat-name {
            font-size: 15px;
            font-weight: 600;
            color: #f1f5f9;
        }
        .mega-cat-count {
            font-size: 12px;
            color: #6b7280;
        }
        /* Mobile responsiveness */
        @media (max-width: 900px) {
            .mega-services-container { grid-template-columns: 1fr; gap: 40px; text-align: center; }
            .mega-services-title { font-size: 2rem; }
            .mega-stats { justify-content: center; }
            .mega-services-badge { margin: 0 auto 24px; }
            .mega-services-btn { margin: 0 auto; }
        }
        @media (max-width: 600px) {
            .mega-services-banner { padding: 50px 16px; }
            .mega-services-title { font-size: 1.6rem; }
            .mega-categories { grid-template-columns: 1fr; gap: 10px; }
            .mega-stats { gap: 24px; flex-wrap: wrap; }
            .mega-stat:not(:last-child)::after { display: none; }
        }


        /* ===== MUA SƠ ĐỒ & BYPASS A12+ ===== */
        .ady-extra-section {
            background: #fff;
            padding: 48px 20px 56px;
            border-bottom: 1px solid #e5e7eb;
        }
        .ady-extra-container {
            max-width: 1000px;
            margin: 0 auto;
        }
        .ady-extra-header {
            text-align: center;
            margin-bottom: 36px;
        }
        .ady-extra-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: #1e293b;
            margin: 0 0 8px;
        }
        .ady-extra-sub {
            font-size: 0.9375rem;
            color: #64748b;
            margin: 0;
        }
        .ady-extra-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }
        .ady-extra-card {
            display: block;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 24px;
            text-decoration: none;
            transition: all 0.25s ease;
        }
        .ady-extra-card:hover {
            border-color: #3b82f6;
            box-shadow: 0 8px 24px rgba(59, 130, 246, 0.15);
            transform: translateY(-2px);
        }
        .ady-extra-card-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            margin-bottom: 16px;
        }
        .ady-extra-card-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 8px;
        }
        .ady-extra-card-desc {
            font-size: 0.875rem;
            color: #64748b;
            line-height: 1.5;
            margin: 0 0 14px;
        }
        .ady-extra-card-link {
            font-size: 0.875rem;
            font-weight: 600;
            color: #3b82f6;
        }
        .ady-extra-card:hover .ady-extra-card-link {
            text-decoration: underline;
        }

        /* ===== FEATURE HIGHLIGHTS ===== */
        .feature-highlights-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-bottom: 48px;
        }
        .feature-highlight-card {
            text-align: center;
            padding: 24px;
            background: #f8fafc;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
        }
        .feature-highlight-icon {
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            margin: 0 auto 16px;
        }
        .feature-highlight-title {
            font-size: 16px;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 8px;
        }
        .feature-highlight-text {
            font-size: 14px;
            color: #64748b;
            margin: 0;
            line-height: 1.5;
        }

        /* ===== GUIDE & PAYMENT SECTION ===== */
        .guide-payment-section {
            background: #f1f5f9;
            padding: 60px 20px;
        }
        .guide-payment-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }
        .guide-column, .payment-column {
            background: #fff;
            border-radius: 20px;
            padding: 32px;
            border: 1px solid #e5e7eb;
        }
        .guide-column-title, .payment-column-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 8px;
        }
        .guide-column-sub, .payment-column-sub {
            font-size: 14px;
            color: #64748b;
            margin: 0 0 20px;
        }
        .guide-tip {
            background: #fef3c7;
            border: 1px solid #fcd34d;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 13px;
            color: #92400e;
            margin-bottom: 20px;
        }
        .guide-tip-link {
            color: #d97706;
            font-weight: 600;
        }
        .guide-step-item {
            display: flex;
            gap: 14px;
            margin-bottom: 16px;
        }
        .guide-step-icon-green {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            flex-shrink: 0;
        }
        .guide-step-content { flex: 1; }
        .guide-step-title {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 4px;
        }
        .guide-step-text {
            font-size: 13px;
            color: #64748b;
            line-height: 1.5;
        }

        /* Payment Tabs */
        .payment-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .payment-tab {
            padding: 10px 16px;
            background: #f1f5f9;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #64748b;
            cursor: pointer;
            transition: all 0.2s;
        }
        .payment-tab.active {
            background: #1e40af;
            border-color: #1e40af;
            color: #fff;
        }
        .payment-details { margin-bottom: 16px; }
        .payment-detail {
            display: none;
            text-align: center;
            padding: 24px;
            background: #f8fafc;
            border-radius: 12px;
        }
        .payment-detail.active { display: block; }
        .payment-detail-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 800;
            margin: 0 auto 12px;
        }
        .momo-icon { background: linear-gradient(135deg, #ae2070 0%, #ec4899 100%); color: #fff; }
        .vnpay-icon { background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); color: #fff; }
        .bank-icon { background: #f1f5f9; color: #475569; }
        .crypto-icon { background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%); color: #fff; }
        .payment-detail-name {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
        }
        .payment-detail-type {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 16px;
        }
        .payment-info-list {
            text-align: left;
            background: #fff;
            border-radius: 8px;
            padding: 12px;
        }
        .payment-info-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 13px;
        }
        .payment-info-item:last-child { border-bottom: none; }
        .payment-info-label { color: #64748b; }
        .payment-info-value { color: #1e293b; font-weight: 500; }
        .payment-note-box {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 13px;
            color: #1e40af;
        }

        /* ===== FOOTER - Giống trang cũ ===== */
        .site-footer {
            background: #ffffff;
            padding: 40px 0 20px;
            border-top: 1px solid #e5e7eb;
            margin-top: 60px;
        }
        .footer-copyright {
            text-align: center;
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 20px;
        }
        .footer-links {
            display: flex;
            justify-content: center;
            gap: 18px;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }
        .footer-link {
            padding: 6px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 13px;
            color: #374151;
            text-decoration: none;
            transition: all 0.2s;
        }
        .footer-link:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1100px) {
            .header-nav { display: none !important; }
            .btn-mobile-menu { display: flex !important; }
        }
        @media (max-width: 900px) {
            .brand-tagline { display: none !important; }
            .mega-services-container { grid-template-columns: 1fr; gap: 40px; }
            .mega-services-title { font-size: 1.8rem; }
        }
        @media (max-width: 768px) {
            .header-right { display: none !important; }
            .btn-mobile-menu { margin-left: auto; }
            .fast-order-grid { grid-template-columns: 1fr; }
            .fo-card { padding: 16px 14px; }
            .mega-categories { grid-template-columns: 1fr; }
            .ady-extra-grid { grid-template-columns: 1fr; }
            .feature-highlights-grid { grid-template-columns: 1fr; }
            .guide-payment-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 600px) {
            .tool-search-icon { display: none; }
            .tool-search-content { text-align: center; width: 100%; }
            .tool-search-form { min-width: 100%; }
            .footer-links { flex-direction: column; align-items: center; }
        }
    </style>
</head>
<body>


<!-- SHARED HEADER -->
@include('partials.header')

@include('partials.mobile-menu')

<!-- HERO SECTION - MODERN -->
<section class="hero-modern">
    <div class="hero-content">
        <h1 class="hero-title">
            Thuê Tài Khoản <span class="hero-title-accent">GSM Tool</span> Tự Động 24/7
        </h1>
        <p class="hero-subtitle">
            Hệ thống cho thuê tài khoản UnlockTool, Vietmap, Griffin, Samsung Tool và hơn 20+ công cụ GSM khác. Nhận tài khoản ngay sau khi thanh toán!
        </p>
        <form class="search-modern" action="/search" method="GET">
            <input type="text" name="q" placeholder="Tìm kiếm: Mua sơ đồ, Unlocktool, Tool FRP, Credits, Bypass A12+...">
            <button type="submit">Tìm kiếm</button>
        </form>
        <div class="hero-stats">
            <div class="hero-stat">
                <span class="hero-stat-number" data-count="500000">+500.000</span>
                <span class="hero-stat-label">Đơn hàng</span>
            </div>
            <div class="hero-stat">
                <span class="hero-stat-number" data-count="99">99</span>
                <span class="hero-stat-label">% Hài lòng</span>
            </div>
            <div class="hero-stat">
                <span class="hero-stat-number" data-count="6000">+6.000</span>
                <span class="hero-stat-label">Dịch vụ</span>
            </div>
        </div>
    </div>
</section>

<!-- FAST ORDER BLOCK -->
<div class="fast-order-wrap" id="fast-order">
    <div class="fast-order">
        <div class="fast-order-grid">
            <!-- CARD: UnlockTool -->
            <article class="fo-card-compact">
                <span class="fo-badge-compact">Flash Sale</span>
                <a class="fo-coupon-compact" href="/ma-giam-gia">Mã giảm giá</a>
                <div class="fo-logo-compact">
                    <img src="/images/services/unlocktool.png" alt="UnlockTool">
                </div>
                <h3 class="fo-title-compact">Unlocktool</h3>
                <p class="fo-desc-compact">Tool đa năng: FRP, bootloader, flash, mật khẩu, Off FMI cloud, quản lý EFS và nhiều tính năng khác</p>
                <ul class="fo-features-compact collapsed" id="features-unlocktool">
                    <li><span class="dot orange"></span>Xóa FRP, Mở khóa Bootloader</li>
                    <li><span class="dot blue"></span>Flash Firmware</li>
                    <li class="fo-feature-extra"><span class="dot green"></span>Off FMI cloud, Quản lý EFS</li>
                    <li class="fo-feature-extra"><span class="dot purple"></span>Hỗ trợ đa dạng thiết bị</li>
                    <li class="fo-feature-extra"><span class="dot yellow"></span>Xóa mật khẩu</li>
                </ul>
                <button class="fo-more-compact" onclick="toggleFeatures('unlocktool')">
                    <span class="collapse-text" style="display:none">Thu gọn</span>
                    <span class="expand-text">Xem thêm</span>
                </button>
                <button type="button" onclick="openPriceModal('unlocktool')" class="fo-cta-compact">
                    <span class="fo-price-compact">10.000 VND</span>
                    <span class="fo-price-old-compact">25.000₫</span>
                </button>
            </article>

            <!-- CARD: Vietmap Live PRO -->
            <article class="fo-card-compact">
                <span class="fo-badge-compact green">Hot</span>
                <a class="fo-coupon-compact" href="/ma-giam-gia">Mã giảm giá</a>
                <div class="fo-logo-compact">
                    <img src="/images/services/vietmap.png" alt="Vietmap Live">
                </div>
                <h3 class="fo-title-compact">Vietmap Live (PRO)</h3>
                <p class="fo-desc-compact">Cảnh báo giao thông, camera, tốc độ, cảnh báo vượt quá tốc độ, cảnh báo camera, đường cấm, cấm dừng/đỗ</p>
                <ul class="fo-features-compact collapsed" id="features-vietmap">
                    <li><span class="dot green"></span>Cảnh báo vượt quá tốc độ</li>
                    <li><span class="dot blue"></span>Cảnh báo camera, đường cấm, cấm dừng/đỗ</li>
                    <li class="fo-feature-extra"><span class="dot orange"></span>Cảnh báo cấm vượt</li>
                    <li class="fo-feature-extra"><span class="dot purple"></span>Cảnh báo phí qua trạm cao tốc</li>
                    <li class="fo-feature-extra"><span class="dot yellow"></span>Cập nhật dữ liệu giao thông</li>
                </ul>
                <button class="fo-more-compact" onclick="toggleFeatures('vietmap')">
                    <span class="collapse-text" style="display:none">Thu gọn</span>
                    <span class="expand-text">Xem thêm</span>
                </button>
                <button type="button" onclick="openPriceModal('vietmap')" class="fo-cta-compact green">
                    <span class="fo-price-compact">8.000 VND</span>
                    <span class="fo-price-old-compact">19.000₫</span>
                </button>
            </article>

            <!-- CARD: Griffin Premium -->
            <article class="fo-card-compact">
                <span class="fo-badge-compact purple">Premium</span>
                <a class="fo-coupon-compact" href="/ma-giam-gia">Mã giảm giá</a>
                <div class="fo-logo-compact">
                    <img src="/images/services/griffin.png" alt="Griffin-Unlocker">
                </div>
                <h3 class="fo-title-compact">Griffin-Unlocker (Premium Pack)</h3>
                <p class="fo-desc-compact">Gói Premium, hỗ trợ nhiều nền tảng: iPhone, Samsung, OneClick Only, tự động trích xuất GUID/ECID</p>
                <ul class="fo-features-compact collapsed" id="features-griffin">
                    <li><span class="dot purple"></span>Hỗ trợ đầy đủ thiết bị A12+ (iPhone XR trở lên)</li>
                    <li><span class="dot blue"></span>A12+ Bypass (iOS 18.6 - 26.1)</li>
                    <li class="fo-feature-extra"><span class="dot orange"></span>Samsung dòng máy đời cao</li>
                    <li class="fo-feature-extra"><span class="dot green"></span>Xóa FRP, Mở khóa Bootloader</li>
                    <li class="fo-feature-extra"><span class="dot yellow"></span>OneClick Only – thao tác nhanh gọn</li>
                    <li class="fo-feature-extra"><span class="dot red"></span>Tự động trích xuất GUID/ECID</li>
                    <li class="fo-feature-extra"><span class="dot cyan"></span>Thêm 2 Method bypass mới</li>
                </ul>
                <button class="fo-more-compact" onclick="toggleFeatures('griffin')">
                    <span class="collapse-text" style="display:none">Thu gọn</span>
                    <span class="expand-text">Xem thêm</span>
                </button>
                <button type="button" onclick="openPriceModal('griffin')" class="fo-cta-compact blue">
                    <span class="fo-price-compact">42.000 VND</span>
                    <span class="fo-price-old-compact">100.000₫</span>
                </button>
            </article>

            <!-- CARD: Android Multitool -->
            <article class="fo-card-compact">
                <span class="fo-badge-compact orange">Flash Sale</span>
                <a class="fo-coupon-compact" href="/ma-giam-gia">Mã giảm giá</a>
                <div class="fo-logo-compact">
                    <img src="/images/services/amt.svg" alt="Android Multitool">
                </div>
                <h3 class="fo-title-compact">Android Multitool</h3>
                <p class="fo-desc-compact">Tool đa năng cho Android: mở khóa màn hình, Bypass FRP, Flash firmware & Root, Wipe data/cache, khởi động lại linh hoạt, kiểm tra thông tin thiết bị</p>
                <ul class="fo-features-compact collapsed" id="features-amt">
                    <li><span class="dot orange"></span>Mở khóa màn hình</li>
                    <li><span class="dot blue"></span>Bypass FRP</li>
                    <li class="fo-feature-extra"><span class="dot green"></span>Flash firmware & Root</li>
                    <li class="fo-feature-extra"><span class="dot purple"></span>Wipe data / cache</li>
                    <li class="fo-feature-extra"><span class="dot yellow"></span>Khởi động lại linh hoạt</li>
                    <li class="fo-feature-extra"><span class="dot red"></span>Kiểm tra thông tin thiết bị</li>
                </ul>
                <button class="fo-more-compact" onclick="toggleFeatures('amt')">
                    <span class="collapse-text" style="display:none">Thu gọn</span>
                    <span class="expand-text">Xem thêm</span>
                </button>
                <button type="button" onclick="openPriceModal('amt')" class="fo-cta-compact orange">
                    <span class="fo-price-compact">9.000 VND</span>
                    <span class="fo-price-old-compact">30.000₫</span>
                </button>
            </article>

            <!-- CARD: KG Killer Tool -->
            <article class="fo-card-compact">
                <span class="fo-badge-compact">Flash Sale</span>
                <a class="fo-coupon-compact" href="/ma-giam-gia">Mã giảm giá</a>
                <div class="fo-logo-compact">
                    <img src="/images/services/kg-killer.png" alt="KG Killer Tool">
                </div>
                <h3 class="fo-title-compact">KG Killer Tool</h3>
                <p class="fo-desc-compact">Xóa KG, Gỡ IT Admin & MDM chuyên nghiệp: Xóa KG Android 13 & 14, gỡ IT Admin & Device Owner, gỡ MDM tất cả hãng Android, bật ADB bằng mã QR</p>
                <ul class="fo-features-compact collapsed" id="features-kg">
                    <li><span class="dot red"></span>Xóa KG Android 13 & 14 nhanh chóng, an toàn</li>
                    <li><span class="dot orange"></span>Gỡ IT Admin & Device Owner (hỗ trợ đến Android 15)</li>
                    <li class="fo-feature-extra"><span class="dot blue"></span>Gỡ MDM cho tất cả các hãng Android</li>
                    <li class="fo-feature-extra"><span class="dot green"></span>Bật ADB bằng mã QR (Android 11-14)</li>
                    <li class="fo-feature-extra"><span class="dot purple"></span>Công cụ chuyên nghiệp cho kỹ thuật viên: nhanh, ổn định, cập nhật liên tục</li>
                    <li class="fo-feature-extra"><span class="dot yellow"></span>🔑 Mật khẩu giải nén (Zip Password): V2.2@@</li>
                </ul>
                <button class="fo-more-compact" onclick="toggleFeatures('kg')">
                    <span class="collapse-text" style="display:none">Thu gọn</span>
                    <span class="expand-text">Xem thêm</span>
                </button>
                <button type="button" onclick="openPriceModal('kg-killer')" class="fo-cta-compact">
                    <span class="fo-price-compact">8.000 VND</span>
                    <span class="fo-price-old-compact">35.000₫</span>
                </button>
            </article>

            <!-- CARD: Samsung Tool -->
            <article class="fo-card-compact">
                <span class="fo-badge-compact orange">Hot</span>
                <a class="fo-coupon-compact" href="/ma-giam-gia">Mã giảm giá</a>
                <div class="fo-logo-compact">
                    <img src="/images/services/samsung-tool.png" alt="Samsung Tool">
                </div>
                <h3 class="fo-title-compact">Samsung Tool</h3>
                <p class="fo-desc-compact">KG Lock Bypass Solution: Xóa KG Lock, Factory Reset OK, Remove FRP, Remove Lost Mode, PayJoy/Device Control Lock, hỗ trợ Samsung 2025</p>
                <ul class="fo-features-compact collapsed" id="features-samsung">
                    <li><span class="dot orange"></span>Bypass KG Lock ổn định, Factory Reset không bị khóa lại</li>
                    <li><span class="dot blue"></span>Remove FRP, Lost Mode, PayJoy Lock, Device Control Lock</li>
                    <li class="fo-feature-extra"><span class="dot green"></span>Hỗ trợ Galaxy A, M, S, Tab Series (Android 10-16)</li>
                    <li class="fo-feature-extra"><span class="dot purple"></span>Hỗ trợ Samsung 2025 Qualcomm với 300+ models mới nhất</li>
                    <li class="fo-feature-extra"><span class="dot yellow"></span>Bật ADB bằng QR Code, Flash/Erase/Backup nhanh chóng</li>
                </ul>
                <button class="fo-more-compact" onclick="toggleFeatures('samsung')">
                    <span class="collapse-text" style="display:none">Thu gọn</span>
                    <span class="expand-text">Xem thêm</span>
                </button>
                <button type="button" onclick="openPriceModal('samsung-tool')" class="fo-cta-compact orange">
                    <span class="fo-price-compact">162.000 VND</span>
                    <span class="fo-price-old-compact">250.000₫</span>
                </button>
            </article>

            <!-- CARD: DFT Pro Tool -->
            <article class="fo-card-compact">
                <span class="fo-badge-compact blue">New</span>
                <a class="fo-coupon-compact" href="/ma-giam-gia">Mã giảm giá</a>
                <div class="fo-logo-compact">
                    <img src="/images/services/dft-pro.png" alt="DFT Pro Tool">
                </div>
                <h3 class="fo-title-compact">DFT Pro Tool</h3>
                <p class="fo-desc-compact">Flash, repair, unlock đa nền tảng: hỗ trợ Qualcomm, MediaTek, HiSilicon, Unisoc; đọc/ghi NVRAM, repair IMEI</p>
                <ul class="fo-features-compact collapsed" id="features-dft">
                    <li><span class="dot blue"></span>Read/Write NVRAM, NVDATA, RPMB</li>
                    <li><span class="dot yellow"></span>Repair IMEI / baseband (tuân thủ quy định địa phương)</li>
                    <li class="fo-feature-extra"><span class="dot green"></span>Reset FRP, Mi Account, set Slot (A/B)</li>
                    <li class="fo-feature-extra"><span class="dot orange"></span>Fix Null baseband, exit Brom/Meta mode</li>
                    <li class="fo-feature-extra"><span class="dot purple"></span>Backup/Restore NVRAM & oeminfo nhanh chóng</li>
                </ul>
                <button class="fo-more-compact" onclick="toggleFeatures('dft')">
                    <span class="collapse-text" style="display:none">Thu gọn</span>
                    <span class="expand-text">Xem thêm</span>
                </button>
                <button type="button" onclick="openPriceModal('dft')" class="fo-cta-compact blue">
                    <span class="fo-price-compact">105.000 VND</span>
                    <span class="fo-price-old-compact">130.000₫</span>
                </button>
            </article>

            <!-- CARD: TSM Tool -->
            <article class="fo-card-compact">
                <span class="fo-badge-compact">Flash Sale</span>
                <a class="fo-coupon-compact" href="/ma-giam-gia">Mã giảm giá</a>
                <div class="fo-logo-compact">
                    <img src="/images/services/tsm.png" alt="TSM Tool">
                </div>
                <h3 class="fo-title-compact">TSM Tool</h3>
                <p class="fo-desc-compact">Tool đa năng: FRP, bootloader, mật khẩu, Off FMI cloud, quản lý EFS, hỗ trợ đa dạng thiết bị Samsung</p>
                <ul class="fo-features-compact collapsed" id="features-tsm">
                    <li><span class="dot yellow"></span>Xóa FRP & Mở khóa Bootloader</li>
                    <li><span class="dot blue"></span>Off FMI cloud & Quản lý EFS</li>
                    <li class="fo-feature-extra"><span class="dot orange"></span>Flash firmware (hỗ trợ nhiều định dạng)</li>
                    <li class="fo-feature-extra"><span class="dot green"></span>Gỡ KG / Knox Guard & Remove MDM</li>
                    <li class="fo-feature-extra"><span class="dot purple"></span>Xóa mật khẩu / Unlock mật khẩu thiết bị</li>
                    <li class="fo-feature-extra"><span class="dot red"></span>Hỗ trợ EDL & ADB (tùy model)</li>
                    <li class="fo-feature-extra"><span class="dot cyan"></span>Tương thích chipset Qualcomm, MediaTek, Unisoc, HiSilicon</li>
                    <li class="fo-feature-extra"><span class="dot pink"></span>Factory Reset & Reset Security</li>
                </ul>
                <button class="fo-more-compact" onclick="toggleFeatures('tsm')">
                    <span class="collapse-text" style="display:none">Thu gọn</span>
                    <span class="expand-text">Xem thêm</span>
                </button>
                <button type="button" onclick="openPriceModal('tsm')" class="fo-cta-compact">
                    <span class="fo-price-compact">6.000 VND</span>
                    <span class="fo-price-old-compact">25.000₫</span>
                </button>
            </article>
        </div>
    </div>
</div>

<!-- SECTION: MEGA SERVICES BANNER (5000+ dịch vụ) -->
<section class="mega-services-banner">
    <div class="mega-services-bg"></div>
    <div class="mega-services-container">
        <div class="mega-services-content">
            <div class="mega-services-badge">🔥 HOT SERVICE</div>
            <h2 class="mega-services-title">
                Đặt hàng <span class="mega-highlight">5,000+</span> Dịch vụ GSM
            </h2>
            <p class="mega-services-desc">
                Unlock iCloud, Check IMEI, FRP Bypass, Carrier Unlock, Server Credits và hàng nghìn dịch vụ khác với giá tốt nhất thị trường!
            </p>
            <div class="mega-stats">
                <div class="mega-stat">
                    <span class="mega-stat-number">5,000+</span>
                    <span class="mega-stat-label">Dịch vụ</span>
                </div>
                <div class="mega-stat">
                    <span class="mega-stat-number">24/7</span>
                    <span class="mega-stat-label">Tự động</span>
                </div>
                <div class="mega-stat">
                    <span class="mega-stat-number">VND</span>
                    <span class="mega-stat-label">Thanh toán</span>
                </div>
            </div>
            <a href="/ord-services" class="mega-services-btn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7"/>
                    <rect x="14" y="3" width="7" height="7"/>
                    <rect x="14" y="14" width="7" height="7"/>
                    <rect x="3" y="14" width="7" height="7"/>
                </svg>
                Xem tất cả dịch vụ
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="5" y1="12" x2="19" y2="12"/>
                    <polyline points="12 5 19 12 12 19"/>
                </svg>
            </a>
        </div>
        <div class="mega-categories">
            <a href="/ord-services?cat=Data+Services" class="mega-cat">
                <div class="mega-cat-icon" style="background: #6366f120; color: #6366f1;">📊</div>
                <div class="mega-cat-info">
                    <span class="mega-cat-name">Data Services</span>
                    <span class="mega-cat-count">1,179 dịch vụ</span>
                </div>
            </a>
            <a href="/ord-services?cat=Software+%26+Tools" class="mega-cat">
                <div class="mega-cat-icon" style="background: #10b98120; color: #10b981;">🔧</div>
                <div class="mega-cat-info">
                    <span class="mega-cat-name">Software & Tools</span>
                    <span class="mega-cat-count">327 dịch vụ</span>
                </div>
            </a>
            <a href="/ord-services?cat=Apple+%2F+iPhone" class="mega-cat">
                <div class="mega-cat-icon" style="background: #f59e0b20; color: #f59e0b;">🍎</div>
                <div class="mega-cat-info">
                    <span class="mega-cat-name">Apple / iPhone</span>
                    <span class="mega-cat-count">250 dịch vụ</span>
                </div>
            </a>
            <a href="/ord-services?cat=Xiaomi" class="mega-cat">
                <div class="mega-cat-icon" style="background: #ec489920; color: #ec4899;">📱</div>
                <div class="mega-cat-info">
                    <span class="mega-cat-name">Xiaomi</span>
                    <span class="mega-cat-count">203 dịch vụ</span>
                </div>
            </a>
            <a href="/ord-services?cat=IMEI+Check" class="mega-cat">
                <div class="mega-cat-icon" style="background: #8b5cf620; color: #8b5cf6;">🔍</div>
                <div class="mega-cat-info">
                    <span class="mega-cat-name">IMEI Check</span>
                    <span class="mega-cat-count">161 dịch vụ</span>
                </div>
            </a>
            <a href="/ord-services?cat=iCloud+%26+FMI" class="mega-cat">
                <div class="mega-cat-icon" style="background: #3b82f620; color: #3b82f6;">☁️</div>
                <div class="mega-cat-info">
                    <span class="mega-cat-name">iCloud & FMI</span>
                    <span class="mega-cat-count">123 dịch vụ</span>
                </div>
            </a>
            <a href="/ord-services?cat=Samsung" class="mega-cat">
                <div class="mega-cat-icon" style="background: #1e40af20; color: #1e40af;">📲</div>
                <div class="mega-cat-info">
                    <span class="mega-cat-name">Samsung</span>
                    <span class="mega-cat-count">70 dịch vụ</span>
                </div>
            </a>
            <a href="/ord-services?cat=FRP+Bypass" class="mega-cat">
                <div class="mega-cat-icon" style="background: #dc262620; color: #dc2626;">🔓</div>
                <div class="mega-cat-info">
                    <span class="mega-cat-name">FRP Bypass</span>
                    <span class="mega-cat-count">57 dịch vụ</span>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- SECTION: MUA SƠ ĐỒ & ORDER BYPASS A12+ -->
<section class="ady-extra-section" id="mua-so-do-bypass-a12">
    <div class="ady-extra-container">
        <div class="ady-extra-header">
            <h2 class="ady-extra-title">Mua sơ đồ & Order Bypass A12+</h2>
            <p class="ady-extra-sub">Sơ đồ điện thoại, boardview và dịch vụ Bypass A12+ – đặt hàng nhanh, thanh toán VND</p>
        </div>
        <div class="ady-extra-grid">
            <a href="/ord-services?cat=Mua%20so%20do" class="ady-extra-card">
                <div class="ady-extra-card-icon" style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                        <path d="M3 9h18M9 21V9"/>
                    </svg>
                </div>
                <h3 class="ady-extra-card-title">Mua sơ đồ</h3>
                <p class="ady-extra-card-desc">Sơ đồ điện thoại, boardview, schematic (ZXW, Borneo, JC, Wuxinji...) giá tốt</p>
                <span class="ady-extra-card-link">Xem dịch vụ sơ đồ →</span>
            </a>
            <a href="/ord-services?cat=Bypass%20A12%2B" class="ady-extra-card">
                <div class="ady-extra-card-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%);">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        <path d="M9 12l2 2 4-4"/>
                    </svg>
                </div>
                <h3 class="ady-extra-card-title">Order Bypass A12+</h3>
                <p class="ady-extra-card-desc">Bypass Hello Screen, FRP A12+, kích hoạt iPhone/iPad qua server</p>
                <span class="ady-extra-card-link">Xem dịch vụ Bypass A12+ →</span>
            </a>
            <a href="/ord-services?cat=Phan%20mem%20mo%20khoa" class="ady-extra-card">
                <div class="ady-extra-card-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2"/>
                        <path d="M7 11V7a5 5 0 0 1 9.9-1"/>
                    </svg>
                </div>
                <h3 class="ady-extra-card-title">Phần mềm mở khóa</h3>
                <p class="ady-extra-card-desc">UnlockTool, Griffin, DFT, TSM, Samsung Tool và các phần mềm unlock điện thoại</p>
                <span class="ady-extra-card-link">Xem phần mềm mở khóa →</span>
            </a>
        </div>
    </div>
</section>

<!-- BLOCK HƯỚNG DẪN + THANH TOÁN -->
<section class="guide-payment-section" id="huong-dan">
    <div class="container">
        <!-- 3 Feature Highlights -->
        <div class="feature-highlights-grid">
            <div class="feature-highlight-card">
                <div class="feature-highlight-icon" style="background:linear-gradient(135deg,#ecfdf5,#d1fae5);color:#10b981;">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        <polyline points="9 12 11 14 15 10"/>
                    </svg>
                </div>
                <h3 class="feature-highlight-title">Bảo mật tuyệt đối</h3>
                <p class="feature-highlight-text">Hệ thống bảo mật cao, thông tin khách hàng được mã hóa an toàn</p>
            </div>
            <div class="feature-highlight-card">
                <div class="feature-highlight-icon" style="background:linear-gradient(135deg,#eff6ff,#dbeafe);color:#3b82f6;">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <h3 class="feature-highlight-title">Tự động 24/7</h3>
                <p class="feature-highlight-text">Hệ thống hoạt động liên tục, thuê tài khoản bất kỳ lúc nào</p>
            </div>
            <div class="feature-highlight-card">
                <div class="feature-highlight-icon" style="background:linear-gradient(135deg,#f5f3ff,#ede9fe);color:#8b5cf6;">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="1" y="4" width="22" height="16" rx="2"/>
                        <line x1="1" y1="10" x2="23" y2="10"/>
                    </svg>
                </div>
                <h3 class="feature-highlight-title">Thanh toán dễ dàng</h3>
                <p class="feature-highlight-text">Hỗ trợ nhiều phương thức, nhận tài khoản ngay sau khi thanh toán</p>
            </div>
        </div>

        <div class="guide-payment-grid">
            <!-- CỘT TRÁI: HƯỚNG DẪN -->
            <div class="guide-column">
            <h2 class="guide-column-title">Hướng dẫn thuê tài khoản</h2>
                <p class="guide-column-sub">Quy trình thuê tài khoản hoàn toàn tự động 24/7</p>
                <div class="guide-tip">
                    Mẹo: Săn mã ưu đãi ngay <a href="/ma-giam-gia" class="guide-tip-link">Tại đây</a>.
                </div>
                <div class="guide-step-item">
                    <div class="guide-step-icon-green">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <div class="guide-step-content">
                        <div class="guide-step-title">Bước 1: Chọn loại tài khoản (Unlocktool/Vietmap Live...)</div>
                        <div class="guide-step-text">Chọn Thuê nhanh theo tài khoản. Ví dụ: Thuê nhanh Unlocktool hoặc Thuê nhanh Vietmap Live, Griffin, Samsung Tool, DFT Pro, TSM Tool, KG Killer, Android Multitool.</div>
                    </div>
                </div>
                <div class="guide-step-item">
                    <div class="guide-step-icon-green">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                        </svg>
                    </div>
                    <div class="guide-step-content">
                        <div class="guide-step-title">Bước 2: Chọn gói thuê</div>
                        <div class="guide-step-text">Chọn gói thuê phù hợp với nhu cầu của bạn, có thể là theo giờ, ngày. Tùy chọn voucher (nếu có).</div>
                    </div>
                </div>
                <div class="guide-step-item">
                    <div class="guide-step-icon-green">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                    </div>
                    <div class="guide-step-content">
                        <div class="guide-step-title">Bước 3: Xác nhận đơn thuê</div>
                        <div class="guide-step-text">Xác nhận thuê và kiểm tra thông tin thanh toán.</div>
                    </div>
                </div>
                <div class="guide-step-item">
                    <div class="guide-step-icon-green">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                            <line x1="1" y1="10" x2="23" y2="10"/>
                        </svg>
                    </div>
                    <div class="guide-step-content">
                        <div class="guide-step-title">Bước 4: Thanh toán</div>
                        <div class="guide-step-text">Sau khi xác nhận, nhấn "Tiến hành thanh toán" để đến trang thanh toán. Quét mã QR hoặc chuyển khoản theo thông tin trên trang. Chờ tại trang thanh toán, hệ thống sẽ tự động nhận diện giao dịch và cập nhật trạng thái đơn hàng.</div>
                    </div>
                </div>
                <div class="guide-step-item">
                    <div class="guide-step-icon-green">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                        </svg>
                    </div>
                    <div class="guide-step-content">
                        <div class="guide-step-title">Bước 5: Nhận tài khoản</div>
                        <div class="guide-step-text">Tại trang thanh toán, hệ thống sẽ tự động chuyển tới trang hiển thị thông tin tài khoản. Đăng ký tài khoản để kiểm tra được thông tin đơn cũng như nhận nhiều đặc quyền khuyến mãi của Thuetaikhoan.net.</div>
                    </div>
                </div>
            </div>

            <!-- CỘT PHẢI: THANH TOÁN -->
            <div class="payment-column">
                <h2 class="payment-column-title">Phương thức thanh toán được hỗ trợ</h2>
                <p class="payment-column-sub">Chúng tôi hỗ trợ các phương thức thanh toán sau</p>
                <div class="payment-tabs">
                    <button class="payment-tab active" data-payment="momo">MoMo</button>
                    <button class="payment-tab" data-payment="vnpay">VNPay</button>
                    <button class="payment-tab" data-payment="bank">Ngân hàng</button>
                    <button class="payment-tab" data-payment="crypto">Crypto</button>
                </div>
                <div class="payment-details">
                    <div class="payment-detail active" id="payment-momo">
                        <div class="payment-detail-icon momo-icon"><span>M</span></div>
                        <div class="payment-detail-name">MoMo</div>
                        <div class="payment-detail-type">Ví điện tử</div>
                        <div class="payment-info-list">
                            <div class="payment-info-item"><span class="payment-info-label">Loại:</span><span class="payment-info-value">Ví điện tử MoMo</span></div>
                            <div class="payment-info-item"><span class="payment-info-label">Phương thức:</span><span class="payment-info-value">Quét mã QR</span></div>
                            <div class="payment-info-item"><span class="payment-info-label">Thời gian xử lý:</span><span class="payment-info-value">Tức thì</span></div>
                        </div>
                    </div>
                    <div class="payment-detail" id="payment-vnpay">
                        <div class="payment-detail-icon vnpay-icon"><span>V</span></div>
                        <div class="payment-detail-name">VNPay</div>
                        <div class="payment-detail-type">Ví điện tử</div>
                        <div class="payment-info-list">
                            <div class="payment-info-item"><span class="payment-info-label">Loại:</span><span class="payment-info-value">Ví điện tử VNPay</span></div>
                            <div class="payment-info-item"><span class="payment-info-label">Phương thức:</span><span class="payment-info-value">Quét mã QR / Chuyển khoản</span></div>
                            <div class="payment-info-item"><span class="payment-info-label">Thời gian xử lý:</span><span class="payment-info-value">Tức thì</span></div>
                        </div>
                    </div>
                    <div class="payment-detail" id="payment-bank">
                        <div class="payment-detail-icon bank-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 21h18"/><path d="M3 10h18"/><path d="M5 6l7-3 7 3"/>
                                <path d="M4 10v11"/><path d="M20 10v11"/>
                                <path d="M8 14v3"/><path d="M12 14v3"/><path d="M16 14v3"/>
                            </svg>
                        </div>
                        <div class="payment-detail-name">Ngân hàng</div>
                        <div class="payment-detail-type">Chuyển khoản</div>
                        <div class="payment-info-list">
                            <div class="payment-info-item"><span class="payment-info-label">Loại:</span><span class="payment-info-value">Chuyển khoản ngân hàng</span></div>
                            <div class="payment-info-item"><span class="payment-info-label">Phương thức:</span><span class="payment-info-value">Chuyển khoản trực tiếp</span></div>
                            <div class="payment-info-item"><span class="payment-info-label">Thời gian xử lý:</span><span class="payment-info-value">1-3 phút</span></div>
                        </div>
                    </div>
                    <div class="payment-detail" id="payment-crypto">
                        <div class="payment-detail-icon crypto-icon"><span>₿</span></div>
                        <div class="payment-detail-name">Crypto</div>
                        <div class="payment-detail-type">Tiền điện tử</div>
                        <div class="payment-info-list">
                            <div class="payment-info-item"><span class="payment-info-label">Loại:</span><span class="payment-info-value">Tiền điện tử (USDT, BTC)</span></div>
                            <div class="payment-info-item"><span class="payment-info-label">Phương thức:</span><span class="payment-info-value">Ví điện tử Crypto</span></div>
                            <div class="payment-info-item"><span class="payment-info-label">Thời gian xử lý:</span><span class="payment-info-value">5-15 phút</span></div>
                        </div>
                    </div>
                </div>
                <div class="payment-note-box">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="16" x2="12" y2="12"/>
                        <line x1="12" y1="8" x2="12.01" y2="8"/>
                    </svg>
                    <span>Thông tin thanh toán chi tiết sẽ được cung cấp trong quá trình đặt hàng</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER - Giống trang cũ -->
@include('partials.footer')

<script>
    function toggleFeatures(id) {
        const features = document.getElementById('features-' + id);
        const btn = features.parentElement.querySelector('.fo-more');
        if (features.classList.contains('expanded')) {
            features.classList.remove('expanded');
            btn.textContent = 'Xem thêm';
        } else {
            features.classList.add('expanded');
            btn.textContent = 'Thu gọn';
        }
    }

    // Payment tabs switching
    document.querySelectorAll('.payment-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            const paymentType = this.getAttribute('data-payment');
            document.querySelectorAll('.payment-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.payment-detail').forEach(d => d.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('payment-' + paymentType).classList.add('active');
        });
    });
    
    // Dark Mode Toggle
    (function() {
        const toggle = document.getElementById('theme-toggle');
        const icon = document.getElementById('theme-icon');
        const html = document.documentElement;
        
        // Exit early if elements don't exist
        if (!toggle || !icon) return;
        
        const savedTheme = localStorage.getItem('theme');
        const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        
        if (savedTheme === 'dark' || (!savedTheme && systemDark)) {
            html.setAttribute('data-theme', 'dark');
            icon.textContent = '☀️';
        } else {
            icon.textContent = '🌙';
        }
        
        toggle.addEventListener('click', function() {
            const isDark = html.getAttribute('data-theme') === 'dark';
            if (isDark) {
                html.removeAttribute('data-theme');
                icon.textContent = '🌙';
                localStorage.setItem('theme', 'light');
            } else {
                html.setAttribute('data-theme', 'dark');
                icon.textContent = '☀️';
                localStorage.setItem('theme', 'dark');
            }
        });
    })();
</script>

<!-- Modern UI Animations -->
<script src="/js/modern-ui.js"></script>

<!-- CONTACT FLOAT WIDGET -->
<style>
.contact-float {
    position: fixed;
    bottom: 24px;
    right: 24px;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 12px;
    pointer-events: none; /* Don't block clicks when closed */
}
.contact-float.open {
    pointer-events: auto;
}
.contact-float-toggle {
    pointer-events: auto !important; /* Toggle button always clickable */
}
.contact-float-items {
    display: flex;
    flex-direction: column;
    gap: 10px;
    opacity: 0;
    pointer-events: none;
    transform: translateY(20px) scale(0.9);
    transition: all 0.3s ease;
}
.contact-float.open .contact-float-items {
    opacity: 1;
    pointer-events: auto;
    transform: translateY(0) scale(1);
}
.contact-float-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 14px;
    border-radius: 50px;
    background: #fff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    text-decoration: none;
    transition: all 0.3s ease;
}
.contact-float-item:hover {
    transform: translateX(-5px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.2);
}
.contact-float-item.zalo { border-left: 3px solid #0066ff; }
.contact-float-item.phone { border-left: 3px solid #10b981; }
.contact-float-item.group { border-left: 3px solid #f97316; }
.contact-float-label {
    display: flex;
    flex-direction: column;
    font-size: 13px;
    font-weight: 600;
    color: #1e293b;
}
.contact-float-desc {
    font-size: 11px;
    font-weight: 400;
    color: #64748b;
}
.contact-float-icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
}
.contact-float-item.zalo .contact-float-icon { background: #0066ff; }
.contact-float-item.phone .contact-float-icon { background: #10b981; }
.contact-float-item.group .contact-float-icon { background: #f97316; }
.contact-float-toggle {
    width: 56px;
    height: 56px;
    border: none;
    border-radius: 50%;
    background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
    color: #fff;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(249, 115, 22, 0.4);
    transition: all 0.3s ease;
    animation: floatPulse 2s ease-in-out infinite;
}
@keyframes floatPulse {
    0%, 100% { box-shadow: 0 4px 15px rgba(249, 115, 22, 0.4); }
    50% { box-shadow: 0 4px 25px rgba(249, 115, 22, 0.6); }
}
.contact-float-toggle:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(249, 115, 22, 0.5);
    animation: none;
}
.contact-float.open .contact-float-toggle {
    animation: bounceRotate 0.5s ease;
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    box-shadow: 0 4px 15px rgba(220, 38, 38, 0.4);
}
@keyframes bounceRotate {
    0% { transform: scale(1) rotate(0deg); }
    30% { transform: scale(1.2) rotate(90deg); }
    50% { transform: scale(0.9) rotate(180deg); }
    70% { transform: scale(1.1) rotate(180deg); }
    100% { transform: scale(1) rotate(180deg); }
}
.toggle-icon-close { display: none; }
.contact-float.open .toggle-icon-open { display: none; }
.contact-float.open .toggle-icon-close { display: block; }
.contact-float.open .contact-float-item:nth-child(1) { transition-delay: 0.05s; }
.contact-float.open .contact-float-item:nth-child(2) { transition-delay: 0.1s; }
.contact-float.open .contact-float-item:nth-child(3) { transition-delay: 0.15s; }
.contact-float.open .contact-float-item:nth-child(4) { transition-delay: 0.2s; }
.contact-float.open .contact-float-item:nth-child(5) { transition-delay: 0.25s; }
</style>

<div class="contact-float" id="contact-float">
    <div class="contact-float-items">
        <a href="https://zalo.me/0777333763" target="_blank" class="contact-float-item zalo">
            <span class="contact-float-label">
                Zalo Mai Quyên
                <span class="contact-float-desc">Cấp tài khoản</span>
            </span>
            <span class="contact-float-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </span>
        </a>
        <a href="https://zalo.me/0934660219" target="_blank" class="contact-float-item zalo">
            <span class="contact-float-label">
                Zalo Thanhtaj
                <span class="contact-float-desc">Hỗ trợ mở khóa</span>
            </span>
            <span class="contact-float-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </span>
        </a>
        <a href="tel:0799161640" class="contact-float-item phone">
            <span class="contact-float-label">
                Gọi Mai Quyên
                <span class="contact-float-desc">0799 161 640</span>
            </span>
            <span class="contact-float-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            </span>
        </a>
        <a href="tel:0777333763" class="contact-float-item phone">
            <span class="contact-float-label">
                Gọi Khang
                <span class="contact-float-desc">0777 333 763</span>
            </span>
            <span class="contact-float-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            </span>
        </a>
        <a href="https://zalo.me/g/qncjky686" target="_blank" class="contact-float-item group">
            <span class="contact-float-label">
                Group Hỗ Trợ
                <span class="contact-float-desc">Tham gia ngay</span>
            </span>
            <span class="contact-float-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </span>
        </a>
    </div>
    <button type="button" class="contact-float-toggle" id="contact-toggle" onclick="toggleContactFloat()">
        <span class="toggle-icon-open">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        </span>
        <span class="toggle-icon-close">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </span>
    </button>
</div>
<script>
function toggleContactFloat() {
    const el = document.getElementById('contact-float');
    if (el) el.classList.toggle('open');
}

function toggleFeatures(cardId) {
    const features = document.getElementById('features-' + cardId);
    if (!features) return;
    const card = features.closest('.fo-card-compact');
    const button = features.nextElementSibling;
    features.classList.toggle('collapsed');
    if (card) card.classList.toggle('expanded');
    
    // Update button text visibility
    const expandText = button.querySelector('.expand-text');
    const collapseText = button.querySelector('.collapse-text');
    if (features.classList.contains('collapsed')) {
        expandText.style.display = 'inline';
        collapseText.style.display = 'none';
    } else {
        expandText.style.display = 'none';
        collapseText.style.display = 'inline';
    }
}
</script>

<!-- ========== PRICE POPUP MODAL (FULL VERSION) ========== -->
<div id="price-modal" class="price-modal">
    <div class="price-modal-backdrop" onclick="closePriceModal()"></div>
    <div class="price-modal-content">
        <button class="price-modal-close" onclick="closePriceModal()">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
        
        <!-- Modal Header -->
        <div class="pm-header">
            <h2 class="pm-title">Chọn gói thuê</h2>
            <p class="pm-subtitle">Chọn gói thuê cho tài khoản: <strong id="pm-service-name">UNLOCKTOOL</strong></p>
            <p style="font-size: 12px; color: #92400e; margin: 6px 0 0 0; padding: 8px 10px; background: linear-gradient(135deg, #fef3c7, #fef9c3); border-radius: 8px;">💡 Tích lũy điểm, khuyến mại và mã giảm giá sẽ được áp dụng ở bước thanh toán.</p>
        </div>
        
        <!-- User Points -->
        <div class="pm-points" id="pm-points-section" style="display:none;">
            <span class="pm-points-label">Điểm hiện có:</span>
            <span class="pm-points-value" id="pm-user-points">0 điểm</span>
            <span class="pm-points-vnd">(≈ <span id="pm-points-vnd">0</span> VND)</span>
        </div>
        
        <!-- Price Options List (includes discount section at bottom) -->
        <div class="pm-options-scroll">
            <div class="pm-options" id="pm-options">
                <!-- Dynamic options will be inserted here -->
            </div>
            
            <!-- Discount Section (moved inside scroll area) -->
            <div class="pm-discount-section" style="margin-top: 16px; padding-top: 16px; border-top: 1px solid #e2e8f0;">
            <!-- Use Points Checkbox -->
            <label class="pm-checkbox" id="pm-use-points-wrapper">
                <input type="checkbox" id="pm-use-points">
                <span class="pm-checkbox-mark"></span>
                <span class="pm-checkbox-label">Sử dụng điểm tích lũy (3.000 VND)</span>
            </label>
            
            <!-- Use Coupon Checkbox -->
            <label class="pm-checkbox">
                <input type="checkbox" id="pm-use-coupon" onchange="toggleCouponSection()">
                <span class="pm-checkbox-mark"></span>
                <span class="pm-checkbox-label">Sử dụng mã giảm giá</span>
            </label>
            
            <!-- Coupon Selection -->
            <div class="pm-coupon-section" id="pm-coupon-section" style="display:none;">
                <div class="pm-coupon-title">
                    <span>🎫</span> Chọn mã giảm giá:
                </div>
                <div class="pm-coupon-list" id="pm-coupon-list">
                    <div class="pm-coupon-item" data-code="THUE2000" onclick="selectCoupon('THUE2000', 2000, 'fixed')">
                        <div class="pm-coupon-code">THUE2000</div>
                        <div class="pm-coupon-info">
                            <div class="pm-coupon-value">Giảm 2,000đ</div>
                            <div class="pm-coupon-limit">Không giới hạn</div>
                        </div>
                        <span class="pm-coupon-use">Dùng</span>
                    </div>
                    <div class="pm-coupon-item" data-code="GIAM10" onclick="selectCoupon('GIAM10', 10, 'percent')">
                        <div class="pm-coupon-code">GIAM10</div>
                        <div class="pm-coupon-info">
                            <div class="pm-coupon-value">Giảm 10%</div>
                            <div class="pm-coupon-limit">Không giới hạn</div>
                        </div>
                        <span class="pm-coupon-use">Dùng</span>
                    </div>
                </div>
                <!-- Hidden input to store coupon code -->
                <input type="hidden" id="pm-coupon-code" value="">
                
                <!-- Old coupon result removed - now using only the consolidated price summary below -->
                
                <!-- Error Message -->
                <div id="pm-coupon-error" style="display: none; margin-top: 8px; padding: 8px 12px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; color: #dc2626; font-size: 12px;"></div>
            </div>
            
            <!-- Real-time Price Summary -->
            <div id="pm-price-summary" class="pm-price-summary" style="margin-top: 16px; padding: 16px; background: linear-gradient(135deg, #f0fdf4, #dcfce7); border: 2px solid #22c55e; border-radius: 12px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <span style="font-size: 13px; color: #374151; font-weight: 600;">Giá gốc:</span>
                    <span id="pm-summary-original" style="font-size: 13px; color: #6b7280; text-decoration: line-through;">0 VND</span>
                </div>
                <div id="pm-summary-discount-row" style="display: none; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <span style="font-size: 13px; color: #16a34a; font-weight: 600;">Giảm giá:</span>
                    <span id="pm-summary-discount" style="font-size: 13px; color: #16a34a; font-weight: 700;">-0 VND</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 10px; border-top: 2px dashed #86efac;">
                    <span style="font-size: 15px; color: #0f172a; font-weight: 800;">💰 Thành tiền:</span>
                    <span id="pm-summary-total" style="font-size: 18px; color: #dc2626; font-weight: 900;">0 VND</span>
                </div>
            </div>
            </div>
        </div>
        
        <!-- Modal Footer -->
        <div class="pm-footer">
            <button type="button" class="pm-btn-cancel" onclick="closePriceModal()">Hủy</button>
            <button type="button" class="pm-btn-confirm" id="pm-btn-confirm" onclick="confirmRental()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                    <line x1="1" y1="10" x2="23" y2="10"/>
                </svg>
                Xác nhận thuê
            </button>
        </div>
    </div>
</div>

<style>
/* ========== ENHANCED PRICE MODAL STYLES ========== */
.price-modal {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}
.price-modal.open {
    opacity: 1;
    visibility: visible;
}
.price-modal-backdrop {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(6px);
}
.price-modal-content {
    position: relative;
    background: #fff;
    border-radius: 24px !important;
    max-width: 560px;
    width: 92%;
    max-height: 92vh;
    margin-bottom: 4vh;
    display: flex;
    flex-direction: column;
    box-shadow: 0 25px 80px rgba(0, 0, 0, 0.25);
    transform: scale(0.95) translateY(20px);
    transition: transform 0.3s ease;
    overflow: hidden !important;
    -webkit-mask-image: -webkit-radial-gradient(white, black);
}
.price-modal.open .price-modal-content {
    transform: scale(1) translateY(0);
}
.price-modal-close {
    position: absolute;
    top: 12px; right: 12px;
    width: 32px; height: 32px;
    border: none;
    background: #f3f4f6;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6b7280;
    transition: all 0.2s;
    z-index: 10;
}
.price-modal-close:hover {
    background: #e5e7eb;
    color: #1f2937;
}

/* Modal Header */
.pm-header {
    padding: 20px 24px 16px;
    border-bottom: 1px solid #f1f5f9;
}
.pm-title {
    font-size: 18px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 4px;
}
.pm-subtitle {
    font-size: 13px;
    color: #6b7280;
}
.pm-subtitle strong {
    color: #1e40af;
    font-weight: 600;
}

/* User Points */
.pm-points {
    padding: 10px 24px;
    background: #ecfdf5;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
}
.pm-points-label { color: #059669; }
.pm-points-value { font-weight: 700; color: #047857; }
.pm-points-vnd { color: #10b981; }

/* Promo Notice */
.pm-promo-notice {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 12px 24px;
    background: #fefce8;
    border-bottom: 1px solid #fef08a;
    font-size: 12px;
    color: #854d0e;
    line-height: 1.5;
}
.pm-promo-notice svg {
    flex-shrink: 0;
    margin-top: 1px;
    color: #ca8a04;
}

/* Options Scroll */
.pm-options-scroll {
    overflow-y: auto;
    height: 500px;
    padding: 6px 16px;
}
.pm-options {
    display: flex;
    flex-direction: column;
    gap: 3px;
}

/* Single Price Option */
.pm-option {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 6px 10px;
    background: #fff;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
}
.pm-option:hover {
    border-color: #3b82f6;
    background: #eff6ff;
}
.pm-option.selected {
    border-color: #2563eb;
    background: #dbeafe;
}
.pm-option-radio {
    width: 18px; height: 18px;
    border: 2px solid #d1d5db;
    border-radius: 50%;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}
.pm-option.selected .pm-option-radio {
    border-color: #2563eb;
}
.pm-option.selected .pm-option-radio::after {
    content: '';
    width: 10px; height: 10px;
    background: #2563eb;
    border-radius: 50%;
}

/* Tags */
.pm-option-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
    margin-bottom: 4px;
}
.pm-tag {
    display: inline-block;
    padding: 2px 8px;
    font-size: 10px;
    font-weight: 600;
    border-radius: 4px;
    text-transform: uppercase;
}
.pm-tag.flash-sale { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
.pm-tag.hot { background: #fff7ed; color: #ea580c; border: 1px solid #fed7aa; }
.pm-tag.promo { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
.pm-tag.special { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
.pm-tag.duration { background: #f3f4f6; color: #4b5563; border: 1px solid #e5e7eb; }

.pm-option-info { flex: 1; min-width: 0; }
.pm-option-name {
    font-size: 13px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 1px;
}
.pm-option-duration {
    font-size: 12px;
    font-weight: 500;
    color: #475569;
}
.pm-option-price {
    text-align: right;
    flex-shrink: 0;
}
.pm-option-current {
    font-size: 15px;
    font-weight: 800;
    color: #0f172a;
}
.pm-option-old {
    font-size: 12px;
    color: #64748b;
    text-decoration: line-through;
}
.pm-option-discount {
    display: inline-block;
    padding: 2px 6px;
    background: #dcfce7;
    color: #16a34a;
    font-size: 10px;
    font-weight: 600;
    border-radius: 4px;
    margin-top: 2px;
}

/* Discount Section */
.pm-discount-section {
    padding: 16px 24px;
    background: #f9fafb;
    border-top: 1px solid #e5e7eb;
}
.pm-checkbox {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    margin-bottom: 10px;
    font-size: 13px;
    color: #374151;
}
.pm-checkbox input { display: none; }
.pm-checkbox-mark {
    width: 18px; height: 18px;
    border: 2px solid #d1d5db;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
    flex-shrink: 0;
}
.pm-checkbox input:checked + .pm-checkbox-mark {
    background: #2563eb;
    border-color: #2563eb;
}
.pm-checkbox input:checked + .pm-checkbox-mark::after {
    content: '✓';
    color: #fff;
    font-size: 12px;
    font-weight: 700;
}

/* Coupon Section */
.pm-coupon-section {
    margin-top: 12px;
    padding-top: 12px;
    border-top: 1px dashed #e5e7eb;
}
.pm-coupon-title {
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 10px;
}
.pm-coupon-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 12px;
}
.pm-coupon-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 14px;
    background: #fff;
    border: 1px solid #fed7aa;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s;
}
.pm-coupon-item:hover {
    border-color: #f97316;
    background: #fff7ed;
}
.pm-coupon-item.selected {
    border-color: #f97316;
    background: #ffedd5;
}
.pm-coupon-code {
    padding: 6px 12px;
    background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    border-radius: 6px;
}
.pm-coupon-info { flex: 1; }
.pm-coupon-value {
    font-size: 14px;
    font-weight: 600;
    color: #c2410c;
}
.pm-coupon-limit {
    font-size: 11px;
    color: #9ca3af;
}
.pm-coupon-use {
    color: #f97316;
    font-size: 13px;
    font-weight: 600;
}
.pm-coupon-input {
    display: flex;
    gap: 8px;
}
.pm-coupon-input input {
    flex: 1;
    padding: 10px 14px;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    font-size: 13px;
    outline: none;
    transition: border-color 0.2s;
}
.pm-coupon-input input:focus {
    border-color: #3b82f6;
}
.pm-coupon-input button {
    padding: 10px 18px;
    background: #1e40af;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
}
.pm-coupon-input button:hover {
    background: #1e3a8a;
}

/* Footer */
.pm-footer {
    display: flex;
    gap: 12px;
    padding: 16px 24px 20px;
    border-top: 1px solid #e5e7eb;
    background: #fff;
    border-radius: 0 0 20px 20px;
}
.pm-btn-cancel {
    flex: 1;
    padding: 12px 20px;
    background: #fff;
    color: #374151;
    border: 1px solid #d1d5db;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}
.pm-btn-cancel:hover {
    background: #f3f4f6;
}
.pm-btn-confirm {
    flex: 2;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 24px;
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}
.pm-btn-confirm:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
}

/* Dark Mode */
[data-theme="dark"] .price-modal-content {
    background: #1e293b;
}
[data-theme="dark"] .pm-header,
[data-theme="dark"] .pm-footer {
    border-color: #334155;
}
[data-theme="dark"] .pm-title,
[data-theme="dark"] .pm-option-name,
[data-theme="dark"] .pm-option-current {
    color: #f1f5f9;
}
[data-theme="dark"] .pm-subtitle,
[data-theme="dark"] .pm-option-duration {
    color: #94a3b8;
}
[data-theme="dark"] .pm-option {
    background: #0f172a;
    border-color: #334155;
}
[data-theme="dark"] .pm-option:hover {
    background: #1e293b;
    border-color: #3b82f6;
}
[data-theme="dark"] .pm-option.selected {
    background: #1e3a8a;
    border-color: #3b82f6;
}
[data-theme="dark"] .pm-discount-section {
    background: #0f172a;
    border-color: #334155;
}
[data-theme="dark"] .pm-checkbox-label {
    color: #e2e8f0;
}
[data-theme="dark"] .pm-promo-notice {
    background: #422006;
    border-color: #854d0e;
    color: #fef08a;
}
[data-theme="dark"] .pm-btn-cancel {
    background: #334155;
    color: #e2e8f0;
    border-color: #475569;
}

/* Mobile */
@media (max-width: 480px) {
    .price-modal-content {
        width: 100%;
        max-height: 95vh;
        border-radius: 16px 16px 0 0;
        margin-top: auto;
    }
    .pm-options-scroll {
        max-height: 450px;
    }
    .pm-option {
        padding: 10px 12px;
    }
    .pm-footer {
        flex-direction: column;
    }
    .pm-btn-cancel, .pm-btn-confirm {
        flex: none;
    }
}
</style>

<script>
// ========== ENHANCED PRICE DATA ==========
// Dynamic prices from database
const servicePricesV2 = {
    @php
    $typeMapping = [
        'Unlocktool' => 'unlocktool',
        'Vietmap' => 'vietmap',
        'Griffin' => 'griffin',
        'AMT' => 'amt',
        'TSMTool' => 'tsm',
        'KGKiller' => 'kg-killer',
        'SamsungTool' => 'samsung-tool',
        'DFTPro' => 'dft'
    ];
    $displayNames = [
        'Unlocktool' => 'UNLOCKTOOL',
        'Vietmap' => 'VIETMAP LIVE PRO',
        'Griffin' => 'GRIFFIN-UNLOCKER',
        'AMT' => 'ANDROID MULTITOOL',
        'TSMTool' => 'TSM TOOL',
        'KGKiller' => 'KG KILLER TOOL',
        'SamsungTool' => 'SAMSUNG TOOL',
        'DFTPro' => 'DFT PRO TOOL'
    ];
    @endphp
    @foreach($allPrices ?? [] as $type => $prices)
        @php $jsKey = $typeMapping[$type] ?? strtolower($type); @endphp
        '{{ $jsKey }}': {
            name: '{{ $displayNames[$type] ?? strtoupper($type) }}',
            packages: [
                @foreach($prices as $price)
                {
                    id: {{ $price->id }},
                    hours: {{ $price->hours }},
                    name: '{{ $displayNames[$type] ?? $type }} {{ $price->hours >= 24 ? floor($price->hours / 24) . ' ngày' : $price->hours . ' giờ' }}',
                    price: {{ $price->price }},
                    oldPrice: {{ $price->original_price ?? $price->price }},
                    tags: [
                        @if($price->promo_badge) '{{ strtolower(str_replace(' ', '-', $price->promo_badge)) }}', @endif
                        @if($price->promo_label) 'promo', @endif
                    ],
                    @if($price->promo_label) specialTag: '{{ $price->promo_label }}', @endif
                    @if($price->discount_percent) discount: {{ $price->discount_percent }}, @endif
                },
                @endforeach
            ]
        },
    @endforeach
};

let currentServiceId = null;
let selectedPackageIndex = 0;
let selectedCoupon = null;

function openPriceModal(serviceId) {
    const service = servicePricesV2[serviceId];
    if (!service) return;
    
    currentServiceId = serviceId;
    selectedPackageIndex = 0;
    selectedCoupon = null;
    
    // Set service name
    const serviceNameEl = document.getElementById('pm-service-name');
    if (serviceNameEl) serviceNameEl.textContent = service.name;
    
    // Check if user is logged in and has points
    const userPoints = {{ Auth::check() ? (Auth::user()->balance ?? 0) : 0 }};
    const pointsSection = document.getElementById('pm-points-section');
    const userPointsEl = document.getElementById('pm-user-points');
    const pointsVndEl = document.getElementById('pm-points-vnd');
    const usePointsWrapper = document.getElementById('pm-use-points-wrapper');
    
    if (userPoints > 0) {
        if (pointsSection) pointsSection.style.display = 'flex';
        if (userPointsEl) userPointsEl.textContent = userPoints.toLocaleString('vi-VN') + ' điểm';
        if (pointsVndEl) pointsVndEl.textContent = userPoints.toLocaleString('vi-VN');
    } else {
        if (pointsSection) pointsSection.style.display = 'none';
    }
    
    // Always show points deduction checkbox with fixed 3000 VND
    if (usePointsWrapper) usePointsWrapper.style.display = 'flex';
    
    // Build package options
    const optionsContainer = document.getElementById('pm-options');
    optionsContainer.innerHTML = service.packages.map((pkg, index) => {
        const tagsHtml = pkg.tags.map(tag => {
            const labels = {
                'flash-sale': 'Flash Sale',
                'hot': 'HOT',
                'promo': 'Khuyến mãi',
                'special': pkg.specialTag || 'Đặc biệt'
            };
            return `<span class="pm-tag ${tag}">${labels[tag]}</span>`;
        }).join('');
        
        const durationText = pkg.hours < 24 ? `${pkg.hours} giờ` : 
                             pkg.hours === 24 ? '24 giờ' :
                             `${pkg.hours} giờ`;
        
        const discountBadge = pkg.discount ? `<span class="pm-option-discount">Giảm ${pkg.discount}%</span>` : '';
        
        return `
            <div class="pm-option ${index === 0 ? 'selected' : ''}" onclick="selectPackage(${index})">
                <div class="pm-option-radio"></div>
                <div class="pm-option-info">
                    <div class="pm-option-tags">
                        ${tagsHtml}
                        <span class="pm-tag duration">${pkg.hours < 24 ? pkg.hours + ' giờ' : (pkg.hours / 24) + ' ngày'}</span>
                    </div>
                    <div class="pm-option-name">${pkg.name}</div>
                    <div class="pm-option-duration">Thời hạn: ${durationText}</div>
                </div>
                <div class="pm-option-price">
                    <div class="pm-option-current">${pkg.price.toLocaleString('vi-VN')} VND</div>
                    <div class="pm-option-old">${pkg.oldPrice.toLocaleString('vi-VN')} VND</div>
                    ${discountBadge}
                </div>
            </div>
        `;
    }).join('');
    
    // Reset coupon section
    const useCouponCheckbox = document.getElementById('pm-use-coupon');
    const couponSection = document.getElementById('pm-coupon-section');
    const couponCodeInput = document.getElementById('pm-coupon-code');
    
    if (useCouponCheckbox) useCouponCheckbox.checked = false;
    if (couponSection) couponSection.style.display = 'none';
    if (couponCodeInput) couponCodeInput.value = '';
    document.querySelectorAll('.pm-coupon-item').forEach(item => item.classList.remove('selected'));
    
    // Show modal
    document.getElementById('price-modal').classList.add('open');
    document.body.style.overflow = 'hidden';
    
    // Initialize price summary
    setTimeout(() => updatePriceDisplay(), 50);
}

function selectPackage(index) {
    selectedPackageIndex = index;
    document.querySelectorAll('.pm-option').forEach((opt, i) => {
        opt.classList.toggle('selected', i === index);
    });
    // Update price summary when package changes
    updatePriceDisplay();
}

function toggleCouponSection() {
    const checkbox = document.getElementById('pm-use-coupon');
    const section = document.getElementById('pm-coupon-section');
    if (checkbox && section) {
        section.style.display = checkbox.checked ? 'block' : 'none';
    }
}

function selectCoupon(code, value, type) {
    selectedCoupon = { code, value, type };
    document.querySelectorAll('.pm-coupon-item').forEach(item => {
        item.classList.toggle('selected', item.dataset.code === code);
    });
    const couponCodeInput = document.getElementById('pm-coupon-code');
    if (couponCodeInput) couponCodeInput.value = code;
    
    // Automatically apply and calculate
    calculateCouponDiscount(code);
}

function applyCouponCode() {
    const codeInput = document.getElementById('pm-coupon-code');
    const code = codeInput ? codeInput.value.trim() : '';
    if (!code) {
        showCouponError('Vui lòng nhập mã giảm giá.');
        return;
    }
    calculateCouponDiscount(code);
}

function calculateCouponDiscount(code) {
    const btn = document.getElementById('pm-apply-coupon-btn');
    const errorBox = document.getElementById('pm-coupon-error');
    
    // Hide previous error
    if (errorBox) errorBox.style.display = 'none';
    
    // Get current package price
    const service = servicePricesV2[currentServiceId];
    if (!service) {
        showCouponError('Vui lòng chọn dịch vụ trước.');
        return;
    }
    const pkg = service.packages[selectedPackageIndex];
    const price = pkg.price;
    
    // Show loading
    if (btn) {
        btn.textContent = 'Đang kiểm tra...';
        btn.disabled = true;
    }
    
    // Call API
    fetch('/api/coupons/validate?code=' + encodeURIComponent(code) + '&price=' + price)
        .then(res => res.json())
        .then(data => {
            if (btn) {
                btn.textContent = 'ÁP DỤNG';
                btn.disabled = false;
            }
            
            if (data.success) {
                selectedCoupon = { code: data.coupon.code, value: data.discount_amount, type: data.coupon.discount_type };
                
                // Update price summary with coupon
                updatePriceDisplay();
            } else {
                selectedCoupon = null;
                updatePriceDisplay();
                showCouponError(data.message || 'Mã giảm giá không hợp lệ.');
            }
        })
        .catch(err => {
            if (btn) {
                btn.textContent = 'ÁP DỤNG';
                btn.disabled = false;
            }
            showCouponError('Có lỗi xảy ra. Vui lòng thử lại.');
        });
}

function showCouponError(message) {
    const errorBox = document.getElementById('pm-coupon-error');
    if (errorBox) {
        errorBox.textContent = message;
        errorBox.style.display = 'block';
    }
}

function removeCouponWelcome() {
    const couponCode = document.getElementById('pm-coupon-code');
    const couponError = document.getElementById('pm-coupon-error');
    
    if (couponCode) couponCode.value = '';
    if (couponError) couponError.style.display = 'none';
    document.querySelectorAll('.pm-coupon-item').forEach(item => item.classList.remove('selected'));
    selectedCoupon = null;
    updatePriceDisplay();
}

function formatVNDWelcome(amount) {
    return new Intl.NumberFormat('vi-VN').format(amount) + ' VND';
}

// Fixed loyalty points value
const LOYALTY_POINTS_VALUE = 3000;

// Update price display when points checkbox changes
function updatePriceDisplay() {
    const usePoints = document.getElementById('pm-use-points')?.checked || false;
    
    // Get current package price
    const service = servicePricesV2[currentServiceId];
    if (!service) return;
    const pkg = service.packages[selectedPackageIndex];
    const originalPrice = pkg.price;
    
    let totalDiscount = 0;
    let discountDetails = [];
    
    // Add loyalty points discount
    if (usePoints) {
        totalDiscount += LOYALTY_POINTS_VALUE;
        discountDetails.push('Điểm: -' + formatVNDWelcome(LOYALTY_POINTS_VALUE));
    }
    
    // Add coupon discount
    if (selectedCoupon && selectedCoupon.value > 0) {
        totalDiscount += selectedCoupon.value;
        discountDetails.push('Mã ' + selectedCoupon.code + ': -' + formatVNDWelcome(selectedCoupon.value));
    }
    
    const finalPrice = Math.max(0, originalPrice - totalDiscount);
    
    // Update ALWAYS VISIBLE price summary section
    const summaryOriginal = document.getElementById('pm-summary-original');
    const summaryDiscountRow = document.getElementById('pm-summary-discount-row');
    const summaryDiscount = document.getElementById('pm-summary-discount');
    const summaryTotal = document.getElementById('pm-summary-total');
    
    if (summaryOriginal) summaryOriginal.textContent = formatVNDWelcome(originalPrice);
    if (summaryTotal) summaryTotal.textContent = formatVNDWelcome(finalPrice);
    
    if (totalDiscount > 0) {
        if (summaryDiscountRow) summaryDiscountRow.style.display = 'flex';
        if (summaryDiscount) summaryDiscount.textContent = '-' + formatVNDWelcome(totalDiscount);
    } else {
        if (summaryDiscountRow) summaryDiscountRow.style.display = 'none';
    }
}

// Add event listener for points checkbox
document.getElementById('pm-use-points')?.addEventListener('change', updatePriceDisplay);

function confirmRental() {
    const service = servicePricesV2[currentServiceId];
    if (!service) return;
    
    const pkg = service.packages[selectedPackageIndex];
    
    const usePoints = document.getElementById('pm-use-points')?.checked || false;
    const useCouponEl = document.getElementById('pm-use-coupon');
    const useCoupon = useCouponEl ? useCouponEl.checked : false;
    
    let url = `/thanh-toan?service=${currentServiceId}&hours=${pkg.hours}`;
    if (usePoints) url += '&use_points=1';
    if (useCoupon && selectedCoupon) url += `&coupon=${selectedCoupon.code}`;
    
    window.location.href = url;
}

function closePriceModal() {
    document.getElementById('price-modal').classList.remove('open');
    document.body.style.overflow = '';
}

// Close on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closePriceModal();
});
</script>

<!-- Theme Toggle Script -->
<script>
// Desktop Theme Toggle Function
function toggleDesktopTheme() {
    const html = document.documentElement;
    const isDark = html.getAttribute('data-theme') === 'dark';
    
    if (isDark) {
        html.removeAttribute('data-theme');
        localStorage.setItem('theme', 'light');
    } else {
        html.setAttribute('data-theme', 'dark');
        localStorage.setItem('theme', 'dark');
    }
    updateThemeIcons(!isDark);
}

function updateThemeIcons(isDark) {
    // Desktop theme toggle
    const desktopBtn = document.getElementById('desktopThemeToggle');
    if (desktopBtn) {
        const sunIcon = desktopBtn.querySelector('.theme-icon-sun');
        const moonIcon = desktopBtn.querySelector('.theme-icon-moon');
        if (sunIcon && moonIcon) {
            sunIcon.style.display = isDark ? 'block' : 'none';
            moonIcon.style.display = isDark ? 'none' : 'block';
        }
    }
    // Mobile theme toggle (if exists)
    const mobileBtn = document.getElementById('mobileThemeToggle');
    if (mobileBtn) {
        const sunIcon = mobileBtn.querySelector('.theme-icon-sun');
        const moonIcon = mobileBtn.querySelector('.theme-icon-moon');
        const textEl = mobileBtn.querySelector('.theme-text');
        if (sunIcon && moonIcon) {
            sunIcon.style.display = isDark ? 'block' : 'none';
            moonIcon.style.display = isDark ? 'none' : 'block';
        }
        if (textEl) {
            textEl.textContent = isDark ? 'Chế độ sáng' : 'Chế độ tối';
        }
    }
}

// Initialize theme on load
(function() {
    const html = document.documentElement;
    const savedTheme = localStorage.getItem('theme');
    const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    
    if (savedTheme === 'dark' || (!savedTheme && systemDark)) {
        html.setAttribute('data-theme', 'dark');
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() { updateThemeIcons(true); });
        } else {
            updateThemeIcons(true);
        }
    }
})();

// Mobile Menu Toggle
(function() {
    function initMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        const menuBtn = document.getElementById('mobileMenuBtn');
        const menuClose = document.getElementById('mobileMenuClose');
        const overlay = document.getElementById('mobileMenuOverlay');
        
        if (!menu || !menuBtn) return;
        
        function openMenu() {
            menu.classList.add('active');
            if (overlay) overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        
        function closeMenu() {
            menu.classList.remove('active');
            if (overlay) overlay.classList.remove('active');
            document.body.style.overflow = '';
        }
        
        menuBtn.addEventListener('click', openMenu);
        if (menuClose) menuClose.addEventListener('click', closeMenu);
        if (overlay) overlay.addEventListener('click', closeMenu);
        
        // Close on ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeMenu();
        });
        
        // Close menu when clicking links
        document.querySelectorAll('.mobile-menu-link').forEach(function(link) {
            link.addEventListener('click', closeMenu);
        });
    }
    
    // Run when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMobileMenu);
    } else {
        initMobileMenu();
    }
})();

// Toggle Services Menu in mobile menu
function toggleServicesMenu() {
    const btn = document.querySelector('.mobile-menu-section-toggle');
    const list = document.getElementById('mobileServicesList');
    
    if (btn && list) {
        btn.classList.toggle('collapsed');
        list.classList.toggle('collapsed');
    }
}

// Mobile Theme Toggle
function toggleMobileTheme() {
    const html = document.documentElement;
    const isDark = html.getAttribute('data-theme') === 'dark';
    
    if (isDark) {
        html.removeAttribute('data-theme');
        localStorage.setItem('theme', 'light');
        updateThemeIcons(false);
    } else {
        html.setAttribute('data-theme', 'dark');
        localStorage.setItem('theme', 'dark');
        updateThemeIcons(true);
    }
}
</script>


</body>
</html>








