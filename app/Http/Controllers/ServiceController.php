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
            'description' => 'Tool đa năng: FRP, bootloader, flash, mật khẩu, Off FMI cloud, quản lý EFS và nhiều tính năng khác',
            'logo' => '/images/services/unlocktool.png',
            'color' => '#f97316',
            'features' => [
                ['dot' => 'orange', 'text' => 'Xóa FRP, Mở khóa Bootloader'],
                ['dot' => 'blue', 'text' => 'Flash Firmware'],
                ['dot' => 'green', 'text' => 'Off FMI cloud, Quản lý EFS', 'hidden' => true],
                ['dot' => 'purple', 'text' => 'Hỗ trợ đa dạng thiết bị', 'hidden' => true],
                ['dot' => 'yellow', 'text' => 'Xóa mật khẩu', 'hidden' => true],
            ],
            'whyChoose' => [
                ['icon' => '🔓', 'title' => 'Bypass FRP Samsung', 'desc' => 'Hỗ trợ bypass FRP Samsung các dòng A, M, S, Note'],
                ['icon' => '📱', 'title' => 'Flash Firmware', 'desc' => 'Flash firmware đa nền tảng, hỗ trợ nhiều hãng'],
                ['icon' => '🛠️', 'title' => 'Quản lý EFS', 'desc' => 'Off FMI cloud và quản lý EFS chuyên nghiệp'],
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
            'name' => 'Vietmap Live (PRO)',
            'slug' => 'thue-vietmap',
            'description' => 'Cảnh báo giao thông, camera, tốc độ, cảnh báo vượt quá tốc độ, cảnh báo camera, đường cấm, cấm dừng/đỗ',
            'logo' => '/images/services/vietmap.png',
            'color' => '#10b981',
            'features' => [
                ['dot' => 'green', 'text' => 'Cảnh báo vượt quá tốc độ'],
                ['dot' => 'blue', 'text' => 'Cảnh báo camera, đường cấm, cấm dừng/đỗ'],
                ['dot' => 'orange', 'text' => 'Cảnh báo cấm vượt', 'hidden' => true],
                ['dot' => 'purple', 'text' => 'Cảnh báo phí qua trạm cao tốc', 'hidden' => true],
                ['dot' => 'yellow', 'text' => 'Cập nhật dữ liệu giao thông', 'hidden' => true],
            ],
            'whyChoose' => [
                ['icon' => '🗺️', 'title' => 'GPS Chính xác', 'desc' => 'Dẫn đường GPS độ chính xác cao'],
                ['icon' => '📍', 'title' => 'Cảnh báo camera', 'desc' => 'Cảnh báo tốc độ và camera phạt nguội'],
                ['icon' => '🚗', 'title' => 'Cho xe hơi', 'desc' => 'Tối ưu cho màn hình Android trên xe'],
                ['icon' => '⚡', 'title' => 'Tự động 24/7', 'desc' => 'Nhận tài khoản ngay sau khi thanh toán'],
            ],
            'faq' => [
                ['q' => 'Vietmap Live PRO là gì?', 'a' => 'Vietmap Live PRO là ứng dụng dẫn đường GPS chuyên nghiệp cho xe hơi với cảnh báo tốc độ và camera.'],
                ['q' => 'Vietmap có cảnh báo camera phạt nguội không?', 'a' => 'Có, Vietmap cảnh báo camera phạt nguội, đường cấm, cấm dừng/đỗ và nhiều cảnh báo khác.'],
            ],
        ],
        'Griffin' => [
            'name' => 'Griffin-Unlocker (Premium Pack)',
            'slug' => 'thue-griffin',
            'description' => 'Gói Premium, hỗ trợ nhiều nền tảng: iPhone, Samsung, OneClick Only, tự động trích xuất GUID/ECID',
            'logo' => '/images/services/griffin.png',
            'color' => '#8b5cf6',
            'features' => [
                ['dot' => 'purple', 'text' => 'Hỗ trợ đầy đủ thiết bị A12+ (iPhone XR trở lên)'],
                ['dot' => 'blue', 'text' => 'A12+ Bypass (iOS 18.6 - 26.1)'],
                ['dot' => 'orange', 'text' => 'Samsung dòng máy đời cao', 'hidden' => true],
                ['dot' => 'green', 'text' => 'Xóa FRP, Mở khóa Bootloader', 'hidden' => true],
                ['dot' => 'yellow', 'text' => 'OneClick Only – thao tác nhanh gọn', 'hidden' => true],
                ['dot' => 'red', 'text' => 'Tự động trích xuất GUID/ECID', 'hidden' => true],
                ['dot' => 'cyan', 'text' => 'Thêm 2 Method bypass mới', 'hidden' => true],
            ],
            'whyChoose' => [
                ['icon' => '☁️', 'title' => 'Bypass iCloud', 'desc' => 'Bypass iCloud không cần phần cứng'],
                ['icon' => '📱', 'title' => 'A12+ Support', 'desc' => 'Hỗ trợ đầy đủ thiết bị A12+ (iPhone XR trở lên)'],
                ['icon' => '🔓', 'title' => 'OneClick Only', 'desc' => 'Thao tác nhanh gọn, một click là xong'],
                ['icon' => '⚡', 'title' => 'Tự động 24/7', 'desc' => 'Nhận tài khoản ngay sau khi thanh toán'],
            ],
            'faq' => [
                ['q' => 'Griffin-Unlocker hỗ trợ thiết bị nào?', 'a' => 'Griffin hỗ trợ iPhone từ A12+ (XR trở lên), Samsung dòng máy đời cao và nhiều thiết bị khác.'],
                ['q' => 'Griffin có bypass được iOS mới nhất không?', 'a' => 'Có, Griffin hỗ trợ bypass A12+ từ iOS 18.6 đến 26.1 với các method mới nhất.'],
            ],
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
            'description' => 'Tool đa năng: FRP, bootloader, mật khẩu, Off FMI cloud, quản lý EFS, hỗ trợ đa dạng thiết bị Samsung',
            'logo' => '/images/services/tsm.png',
            'color' => '#f59e0b',
            'features' => [
                ['dot' => 'yellow', 'text' => 'Xóa FRP & Mở khóa Bootloader'],
                ['dot' => 'blue', 'text' => 'Off FMI cloud & Quản lý EFS'],
                ['dot' => 'orange', 'text' => 'Flash firmware (hỗ trợ nhiều định dạng)', 'hidden' => true],
                ['dot' => 'green', 'text' => 'Gỡ KG / Knox Guard & Remove MDM', 'hidden' => true],
                ['dot' => 'purple', 'text' => 'Xóa mật khẩu / Unlock mật khẩu thiết bị', 'hidden' => true],
                ['dot' => 'red', 'text' => 'Hỗ trợ EDL & ADB (tùy model)', 'hidden' => true],
                ['dot' => 'cyan', 'text' => 'Tương thích chipset Qualcomm, MediaTek, Unisoc, HiSilicon', 'hidden' => true],
                ['dot' => 'pink', 'text' => 'Factory Reset & Reset Security', 'hidden' => true],
            ],
            'whyChoose' => [
                ['icon' => '🔓', 'title' => 'Xóa FRP', 'desc' => 'Xóa FRP và mở khóa bootloader nhanh chóng'],
                ['icon' => '🛡️', 'title' => 'Gỡ Knox Guard', 'desc' => 'Gỡ KG / Knox Guard và Remove MDM'],
                ['icon' => '📱', 'title' => 'Đa chipset', 'desc' => 'Hỗ trợ Qualcomm, MediaTek, Unisoc, HiSilicon'],
                ['icon' => '⚡', 'title' => 'Tự động 24/7', 'desc' => 'Nhận tài khoản ngay sau khi thanh toán'],
            ],
            'faq' => [
                ['q' => 'TSM Tool hỗ trợ những chipset nào?', 'a' => 'TSM Tool hỗ trợ Qualcomm, MediaTek, Unisoc, HiSilicon và nhiều chipset khác.'],
                ['q' => 'TSM có gỡ được Knox Guard không?', 'a' => 'Có, TSM Tool hỗ trợ gỡ KG / Knox Guard và Remove MDM.'],
            ],
        ],
        'DFTPro' => [
            'name' => 'DFT Pro Tool',
            'slug' => 'thue-dft',
            'description' => 'Flash, repair, unlock đa nền tảng: hỗ trợ Qualcomm, MediaTek, HiSilicon, Unisoc; đọc/ghi NVRAM, repair IMEI',
            'logo' => '/images/services/dft-pro.png',
            'color' => '#3b82f6',
            'features' => [
                ['dot' => 'blue', 'text' => 'Read/Write NVRAM, NVDATA, RPMB'],
                ['dot' => 'yellow', 'text' => 'Repair IMEI / baseband (tuân thủ quy định địa phương)'],
                ['dot' => 'green', 'text' => 'Reset FRP, Mi Account, set Slot (A/B)', 'hidden' => true],
                ['dot' => 'orange', 'text' => 'Fix Null baseband, exit Brom/Meta mode', 'hidden' => true],
                ['dot' => 'purple', 'text' => 'Backup/Restore NVRAM & oeminfo nhanh chóng', 'hidden' => true],
            ],
            'whyChoose' => [
                ['icon' => '🔧', 'title' => 'Repair IMEI', 'desc' => 'Repair IMEI / baseband tuân thủ quy định'],
                ['icon' => '📱', 'title' => 'Đa nền tảng', 'desc' => 'Hỗ trợ Qualcomm, MediaTek, HiSilicon, Unisoc'],
                ['icon' => '💾', 'title' => 'NVRAM', 'desc' => 'Read/Write NVRAM, NVDATA, RPMB chuyên nghiệp'],
                ['icon' => '⚡', 'title' => 'Tự động 24/7', 'desc' => 'Nhận tài khoản ngay sau khi thanh toán'],
            ],
            'faq' => [
                ['q' => 'DFT Pro hỗ trợ những nền tảng nào?', 'a' => 'DFT Pro hỗ trợ Qualcomm, MediaTek, HiSilicon, Unisoc và nhiều nền tảng khác.'],
                ['q' => 'DFT có repair được IMEI không?', 'a' => 'Có, DFT Pro hỗ trợ repair IMEI / baseband tuân thủ quy định địa phương.'],
            ],
        ],
        'KGKiller' => [
            'name' => 'KG Killer Tool',
            'slug' => 'thue-kg-killer',
            'description' => 'Xóa KG, Gỡ IT Admin & MDM chuyên nghiệp: Xóa KG Android 13 & 14, gỡ IT Admin & Device Owner, gỡ MDM tất cả hãng Android, bật ADB bằng mã QR',
            'logo' => '/images/services/kg-killer.png',
            'color' => '#ef4444',
            'features' => [
                ['dot' => 'red', 'text' => 'Xóa KG Android 13 & 14 nhanh chóng, an toàn'],
                ['dot' => 'orange', 'text' => 'Gỡ IT Admin & Device Owner (hỗ trợ đến Android 15)'],
                ['dot' => 'blue', 'text' => 'Gỡ MDM cho tất cả các hãng Android', 'hidden' => true],
                ['dot' => 'green', 'text' => 'Bật ADB bằng mã QR (Android 11-14)', 'hidden' => true],
                ['dot' => 'purple', 'text' => 'Công cụ chuyên nghiệp cho kỹ thuật viên: nhanh, ổn định, cập nhật liên tục', 'hidden' => true],
                ['dot' => 'yellow', 'text' => '🔑 Mật khẩu giải nén (Zip Password): V2.2@@', 'hidden' => true],
            ],
            'whyChoose' => [
                ['icon' => '🔓', 'title' => 'Xóa KG Lock', 'desc' => 'Xóa KG Android 13 & 14 nhanh chóng, an toàn'],
                ['icon' => '🛡️', 'title' => 'Gỡ IT Admin', 'desc' => 'Gỡ IT Admin & Device Owner hỗ trợ đến Android 15'],
                ['icon' => '📱', 'title' => 'Gỡ MDM', 'desc' => 'Gỡ MDM cho tất cả các hãng Android'],
                ['icon' => '⚡', 'title' => 'Tự động 24/7', 'desc' => 'Nhận tài khoản ngay sau khi thanh toán'],
            ],
            'faq' => [
                ['q' => 'KG Killer hỗ trợ Android nào?', 'a' => 'KG Killer hỗ trợ xóa KG trên Android 13, 14 và gỡ IT Admin đến Android 15.'],
                ['q' => 'KG Killer có gỡ được MDM không?', 'a' => 'Có, KG Killer hỗ trợ gỡ MDM cho tất cả các hãng Android.'],
            ],
        ],
        'SamsungTool' => [
            'name' => 'Samsung Tool',
            'slug' => 'thue-samsung-tool',
            'description' => 'KG Lock Bypass Solution: Xóa KG Lock, Factory Reset OK, Remove FRP, Remove Lost Mode, PayJoy/Device Control Lock, hỗ trợ Samsung 2025',
            'logo' => '/images/services/samsung-tool.png',
            'color' => '#f97316',
            'features' => [
                ['dot' => 'orange', 'text' => 'Bypass KG Lock ổn định, Factory Reset không bị khóa lại'],
                ['dot' => 'blue', 'text' => 'Remove FRP, Lost Mode, PayJoy Lock, Device Control Lock'],
                ['dot' => 'green', 'text' => 'Hỗ trợ Galaxy A, M, S, Tab Series (Android 10-16)', 'hidden' => true],
                ['dot' => 'purple', 'text' => 'Hỗ trợ Samsung 2025 Qualcomm với 300+ models mới nhất', 'hidden' => true],
                ['dot' => 'yellow', 'text' => 'Bật ADB bằng QR Code, Flash/Erase/Backup nhanh chóng', 'hidden' => true],
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
        return $this->showService('DFTPro');
    }
    
    /**
     * Show KG Killer service page
     */
    public function kgKiller()
    {
        return $this->showService('KGKiller');
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
