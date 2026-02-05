<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Price;
use App\Models\Account;
use App\Models\Coupon;

class ServiceController extends Controller
{
    /**
     * Service configuration for each type
     */
    protected array $services = [
        'Unlocktool' => [
            'name' => 'UnlockTool',
            'slug' => 'thue-unlocktool',
            'description' => 'Tool mở khóa Samsung, iPhone chuyên nghiệp',
            'logo' => '/images/services/unlocktool.png',
            'color' => '#f97316',
            'features' => [
                ['dot' => 'yellow', 'text' => 'Bypass FRP Samsung đời mới'],
                ['dot' => 'blue', 'text' => 'Unlock mạng iPhone qua RSIM'],
                ['dot' => 'orange', 'text' => 'Fix lỗi bootloop đa nền tảng', 'hidden' => true],
                ['dot' => 'green', 'text' => 'Đọc mã & mở khóa MDM iOS', 'hidden' => true],
            ],
            'whyChoose' => [
                ['icon' => '🔓', 'title' => 'Bypass FRP Samsung', 'desc' => 'Hỗ trợ bypass FRP Samsung các dòng A, M, S, Note'],
                ['icon' => '📱', 'title' => 'Unlock iPhone', 'desc' => 'Mở khóa mạng iPhone qua RSIM, hỗ trợ iOS mới nhất'],
                ['icon' => '🛠️', 'title' => 'Fix Bootloop', 'desc' => 'Sửa lỗi bootloop, flash firmware đa nền tảng'],
                ['icon' => '🔐', 'title' => 'Mở khóa MDM', 'desc' => 'Đọc mã và mở khóa MDM iOS dễ dàng'],
                ['icon' => '⚡', 'title' => 'Tự động 24/7', 'desc' => 'Nhận tài khoản ngay sau khi thanh toán'],
                ['icon' => '💰', 'title' => 'Giá tốt nhất', 'desc' => 'Giá thuê cạnh tranh nhất thị trường'],
            ],
            'faq' => [
                ['q' => 'UnlockTool hỗ trợ những thiết bị nào?', 'a' => 'UnlockTool hỗ trợ Samsung (Galaxy A, M, S, Note, Tab), iPhone (unlock mạng qua RSIM) và nhiều hãng Android khác.'],
                ['q' => 'Làm thế nào để thuê tài khoản UnlockTool?', 'a' => 'Chọn gói thuê, thanh toán qua MoMo/VNPay/Chuyển khoản. Hệ thống tự động gửi tài khoản ngay sau khi thanh toán.'],
                ['q' => 'Tài khoản có thể dùng trên bao nhiêu máy?', 'a' => 'Mỗi tài khoản UnlockTool chỉ có thể đăng nhập trên 1 máy tính tại một thời điểm.'],
            ],
        ],
        'Vietmap' => [
            'name' => 'Vietmap Live PRO',
            'slug' => 'thue-vietmap',
            'description' => 'Dẫn đường chuyên nghiệp cho xe hơi',
            'logo' => '/images/services/vietmap.png',
            'color' => '#10b981',
            'features' => [
                ['dot' => 'blue', 'text' => 'Dẫn đường GPS chính xác'],
                ['dot' => 'yellow', 'text' => 'Cảnh báo tốc độ, camera'],
                ['dot' => 'green', 'text' => 'Cập nhật bản đồ liên tục', 'hidden' => true],
            ],
            'whyChoose' => [
                ['icon' => '🗺️', 'title' => 'GPS Chính xác', 'desc' => 'Dẫn đường GPS độ chính xác cao'],
                ['icon' => '📍', 'title' => 'Cảnh báo camera', 'desc' => 'Cảnh báo tốc độ và camera phạt nguội'],
                ['icon' => '🚗', 'title' => 'Cho xe hơi', 'desc' => 'Tối ưu cho màn hình Android trên xe'],
            ],
            'faq' => [
                ['q' => 'Vietmap Live PRO là gì?', 'a' => 'Vietmap Live PRO là ứng dụng dẫn đường GPS chuyên nghiệp cho xe hơi với cảnh báo tốc độ và camera.'],
            ],
        ],
        'Griffin' => [
            'name' => 'Griffin Premium Pack',
            'slug' => 'thue-griffin',
            'description' => 'Bypass iCloud, Hello Screen chuyên nghiệp',
            'logo' => '/images/services/griffin.png',
            'color' => '#8b5cf6',
            'features' => [
                ['dot' => 'purple', 'text' => 'Bypass iCloud mọi phiên bản'],
                ['dot' => 'blue', 'text' => 'Mở Hello Screen iPhone/iPad'],
                ['dot' => 'yellow', 'text' => 'Hỗ trợ A8-A11 chip', 'hidden' => true],
            ],
            'whyChoose' => [
                ['icon' => '☁️', 'title' => 'Bypass iCloud', 'desc' => 'Bypass iCloud không cần phần cứng'],
                ['icon' => '📱', 'title' => 'Hello Screen', 'desc' => 'Mở khóa Hello Screen iPhone/iPad'],
            ],
            'faq' => [],
        ],
        'AMT' => [
            'name' => 'Android Multitool',
            'slug' => 'thue-amt',
            'description' => 'Tool đa năng cho Android: mở khóa màn hình, Bypass FRP, Flash firmware & Root, Wipe data/cache, khởi động lại linh hoạt, kiểm tra thông tin thiết bị',
            'logo' => '/images/services/amt.svg',
            'color' => '#ec4899',
            'features' => [
                ['dot' => 'orange', 'text' => 'Mở khóa màn hình'],
                ['dot' => 'blue', 'text' => 'Bypass FRP'],
                ['dot' => 'green', 'text' => 'Flash firmware & Root', 'hidden' => true],
                ['dot' => 'purple', 'text' => 'Wipe data / cache', 'hidden' => true],
                ['dot' => 'yellow', 'text' => 'Khởi động lại linh hoạt', 'hidden' => true],
                ['dot' => 'red', 'text' => 'Kiểm tra thông tin thiết bị', 'hidden' => true],
            ],
            'whyChoose' => [
                ['icon' => '🔓', 'title' => 'Mở khóa màn hình', 'desc' => 'Xóa mật khẩu, pattern, PIN trên Android dễ dàng'],
                ['icon' => '🛡️', 'title' => 'Bypass FRP', 'desc' => 'Bypass Google Account (FRP) Samsung, Xiaomi, Oppo'],
                ['icon' => '📱', 'title' => 'Flash Firmware', 'desc' => 'Flash ROM, Root, Recovery đa nền tảng'],
                ['icon' => '⚡', 'title' => 'Tự động 24/7', 'desc' => 'Nhận tài khoản ngay sau khi thanh toán'],
            ],
            'faq' => [
                ['q' => 'Android Multitool hỗ trợ những hãng nào?', 'a' => 'AMT hỗ trợ Samsung, Xiaomi, Oppo, Vivo, Realme và nhiều hãng Android khác.'],
                ['q' => 'Có thể bypass FRP bằng AMT không?', 'a' => 'Có, AMT hỗ trợ bypass FRP (Google Account) trên nhiều dòng máy Android.'],
            ],
        ],
        'TSMTool' => [
            'name' => 'TSM Tool',
            'slug' => 'thue-tsm',
            'description' => 'Tool đa năng: FRP, bootloader, mật khẩu',
            'logo' => '/images/services/tsm.png',
            'color' => '#f59e0b',
            'features' => [
                ['dot' => 'yellow', 'text' => 'Xóa FRP & Mở khóa Bootloader'],
                ['dot' => 'blue', 'text' => 'Off FMI cloud & Quản lý EFS'],
            ],
            'whyChoose' => [],
            'faq' => [],
        ],
        'DFT' => [
            'name' => 'DFT Pro Tool',
            'slug' => 'thue-dft',
            'description' => 'Flash, repair, unlock đa nền tảng',
            'logo' => '/images/services/dft-pro.png',
            'color' => '#3b82f6',
            'features' => [
                ['dot' => 'blue', 'text' => 'Read/Write NVRAM, NVDATA'],
                ['dot' => 'yellow', 'text' => 'Repair IMEI / baseband'],
            ],
            'whyChoose' => [],
            'faq' => [],
        ],
        'KG' => [
            'name' => 'KG Killer',
            'slug' => 'thue-kg-killer',
            'description' => 'Bypass MDM & Knox Samsung mới nhất',
            'logo' => '/images/services/kg-killer.png',
            'color' => '#ef4444',
            'features' => [
                ['dot' => 'red', 'text' => 'Bypass KG Lock Samsung'],
                ['dot' => 'orange', 'text' => 'Skip MDM Samsung'],
            ],
            'whyChoose' => [],
            'faq' => [],
        ],
        'SamsungTool' => [
            'name' => 'Samsung Tool',
            'slug' => 'thue-samsung-tool',
            'description' => 'KG Lock Bypass Solution chuyên nghiệp',
            'logo' => '/images/services/samsung-tool.png',
            'color' => '#f97316',
            'features' => [
                ['dot' => 'orange', 'text' => 'Bypass KG Lock ổn định'],
                ['dot' => 'blue', 'text' => 'Remove FRP, Lost Mode'],
                ['dot' => 'green', 'text' => 'Hỗ trợ Samsung Qualcomm 300+ models', 'hidden' => true],
                ['dot' => 'purple', 'text' => 'Factory Reset OK', 'hidden' => true],
            ],
            'whyChoose' => [
                ['icon' => '🛡️', 'title' => 'Bypass KG Lock', 'desc' => 'Bypass Knox Guard (KG) Lock hiệu quả, ổn định nhất'],
                ['icon' => '🔓', 'title' => 'Remove FRP', 'desc' => 'Xóa FRP, Lost Mode, PayJoy Lock nhanh chóng'],
                ['icon' => '📱', 'title' => '300+ Models', 'desc' => 'Hỗ trợ Samsung Qualcomm 2025 mới nhất'],
                ['icon' => '⚡', 'title' => 'Tự động 24/7', 'desc' => 'Nhận tài khoản ngay sau khi thanh toán'],
                ['icon' => '✅', 'title' => 'Factory Reset OK', 'desc' => 'Đảm bảo reset thành công không bị khóa lại'],
                ['icon' => '💰', 'title' => 'Giá rẻ nhất', 'desc' => 'Giá thuê cạnh tranh nhất thị trường'],
            ],
            'faq' => [
                ['q' => 'Samsung Tool hỗ trợ những dòng máy nào?', 'a' => 'Samsung Tool hỗ trợ hầu hết Samsung Qualcomm: Galaxy A, M, S, Note từ 2020 trở lên (300+ models).'],
                ['q' => 'Bypass KG Lock có ổn định không?', 'a' => 'Rất ổn định. Samsung Tool là giải pháp bypass KG Lock được nhiều thợ tin dùng với tỉ lệ thành công cao.'],
                ['q' => 'Cần cáp test point để dùng Samsung Tool không?', 'a' => 'Có, một số máy cần cáp test point để vào chế độ EDL. Một số máy có thể dùng phương pháp ADB.'],
            ],
        ],
    ];
    
    /**
     * Get service pricing info
     */
    protected function getServiceInfo(string $type, int $pointBalance = 0): array
    {
        $packages = Price::getByType($type);
        $count = $packages->count();
        $stock = Account::countAvailable($type);
        $available = ($stock > 0 && $count > 0);
        
        $pkgMin = $packages->sortBy('price')->first();
        $min = $pkgMin ? $pkgMin->price : 0;
        $old = $pkgMin ? ($pkgMin->original_price ?? $pkgMin->price) : 0;
        
        // Apply best coupon and points
        $couponSaving = Coupon::getBestSaving($min);
        $afterCoupon = max(0, $min - $couponSaving);
        $pointUse = min($pointBalance, $afterCoupon);
        $minNet = max(0, $afterCoupon - $pointUse);
        
        $discMax = Price::getMaxDiscount($type);
        
        return [
            'packages' => $packages,
            'count' => $count,
            'stock' => $stock,
            'available' => $available,
            'pkgMin' => $pkgMin,
            'min' => $min,
            'old' => $old,
            'minNet' => $minNet,
            'discMax' => $discMax,
        ];
    }
    
    /**
     * Show UnlockTool service page
     */
    public function unlocktool()
    {
        return $this->showService('Unlocktool');
    }
    
    /**
     * Show Vietmap service page
     */
    public function vietmap()
    {
        return $this->showService('Vietmap');
    }
    
    /**
     * Show Griffin service page
     */
    public function griffin()
    {
        return $this->showService('Griffin');
    }
    
    /**
     * Show AMT service page
     */
    public function amt()
    {
        return $this->showService('AMT');
    }
    
    /**
     * Show TSM service page
     */
    public function tsm()
    {
        return $this->showService('TSMTool');
    }
    
    /**
     * Show DFT service page
     */
    public function dft()
    {
        return $this->showService('DFT');
    }
    
    /**
     * Show KG Killer service page
     */
    public function kgKiller()
    {
        return $this->showService('KG');
    }
    
    /**
     * Show Samsung Tool service page
     */
    public function samsungTool()
    {
        return $this->showService('SamsungTool');
    }
    
    /**
     * Generic method to show a service page
     */
    protected function showService(string $type)
    {
        $pointBalance = 0; // TODO: Get from authenticated user
        
        $service = $this->services[$type] ?? null;
        if (!$service) {
            abort(404);
        }
        
        $info = $this->getServiceInfo($type, $pointBalance);
        
        return view('services.show', [
            'service' => $service,
            'type' => $type,
            'info' => $info,
            'pointBalance' => $pointBalance,
        ]);
    }
}
