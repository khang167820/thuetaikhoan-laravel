<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class OrderHelper
{
    /**
     * Bank configuration
     */
    const BANK_BIN = 'ACB';
    const BANK_ACCOUNT = '20867091';
    const BANK_OWNER_NAME = 'MAI THI THU QUYEN';
    const BANK_NAME = 'Ngân hàng TMCP Á Châu';

    /**
     * Generate unique tracking code
     * Format: GH + dd/mm/yy + 4 random digits
     * Example: GH3101261234
     */
    public static function generateTrackingCode(): string
    {
        $prefix = 'GH';
        $date = date('dmy'); // ddmmyy
        
        $maxAttempts = 10;
        $attempt = 0;
        
        do {
            $random = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
            $code = $prefix . $date . $random;
            
            // Check if code already exists
            $exists = DB::table('orders')
                ->where('tracking_code', $code)
                ->exists();
            
            $attempt++;
        } while ($exists && $attempt < $maxAttempts);
        
        return $code;
    }

    /**
     * Generate VietQR URL for payment
     */
    public static function generateQRUrl(int $amount, string $trackingCode): string
    {
        $params = [
            'amount' => $amount,
            'addInfo' => $trackingCode,
            'accountName' => self::BANK_OWNER_NAME,
        ];
        
        return 'https://img.vietqr.io/image/' 
            . self::BANK_BIN . '-' . self::BANK_ACCOUNT 
            . '-compact.png?' . http_build_query($params);
    }

    /**
     * Format money in VND
     */
    public static function formatMoney(int $amount): string
    {
        return number_format($amount, 0, ',', '.');
    }

    /**
     * Convert duration string to hours
     * Examples: "2 giờ" -> 2, "1 ngày" -> 24, "1 tháng" -> 720
     */
    public static function durationToHours(string $duration): int
    {
        if (preg_match('/(\d+)\s*giờ/i', $duration, $m)) {
            return (int) $m[1];
        }
        if (preg_match('/(\d+)\s*ngày/i', $duration, $m)) {
            return (int) $m[1] * 24;
        }
        if (preg_match('/(\d+)\s*tháng/i', $duration, $m)) {
            return (int) $m[1] * 30 * 24;
        }
        return 0;
    }

    /**
     * Get bank info array
     */
    public static function getBankInfo(): array
    {
        return [
            'bin' => self::BANK_BIN,
            'account' => self::BANK_ACCOUNT,
            'owner' => self::BANK_OWNER_NAME,
            'name' => self::BANK_NAME,
        ];
    }
}
