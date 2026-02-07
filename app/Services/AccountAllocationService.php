<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AccountAllocationService
{
    /**
     * Allocate an available account to an order
     * 
     * @param Order $order The order to allocate account for
     * @return array ['success' => bool, 'account' => Account|null, 'error' => string|null]
     */
    public static function allocateAccount(Order $order): array
    {
        try {
            DB::beginTransaction();

            // Get service type from order
            $serviceType = $order->service_type;
            
            if (empty($serviceType)) {
                // Try to get from price
                $price = $order->price;
                $serviceType = $price?->type;
            }

            if (empty($serviceType)) {
                DB::rollBack();
                return [
                    'success' => false,
                    'account' => null,
                    'error' => 'Không xác định được loại dịch vụ'
                ];
            }

            // Find available account with row lock
            // Ưu tiên: chờ lâu nhất (available_since ASC) + không có ghi chú
            $account = Account::where('type', $serviceType)
                ->where('is_available', 1)
                ->where(function ($q) {
                    $q->whereNull('note')->orWhere('note', '');
                })
                ->orderBy('available_since', 'asc')
                ->lockForUpdate()
                ->first();

            if (!$account) {
                DB::rollBack();
                Log::warning("No available account for type: {$serviceType}, order: {$order->tracking_code}");
                return [
                    'success' => false,
                    'account' => null,
                    'error' => 'Không còn tài khoản trống. Vui lòng liên hệ admin.'
                ];
            }

            // Mark account as rented
            $account->is_available = 0;
            $account->available_since = null;
            $account->save();

            // Update order with account info
            $order->account_id = $account->id;
            $order->assigned_password = $account->password; // Save password at allocation time
            $order->status = Order::STATUS_COMPLETED;
            
            // Calculate expiry time
            $hours = $order->hours ?? 0;
            if ($hours > 0) {
                $order->expires_at = now()->addHours($hours);
            }
            
            $order->completed_at = now();
            $order->save();

            DB::commit();

            Log::info("Account allocated: {$account->id} ({$account->type}) -> Order: {$order->tracking_code}");

            return [
                'success' => true,
                'account' => $account,
                'error' => null
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Account allocation failed: " . $e->getMessage());
            return [
                'success' => false,
                'account' => null,
                'error' => 'Lỗi hệ thống khi cấp tài khoản: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Reclaim expired accounts
     * Call this from a scheduled command
     * 
     * @return int Number of accounts reclaimed
     */
    public static function reclaimExpiredAccounts(): int
    {
        $count = 0;

        try {
            // Find completed orders that have expired
            $expiredOrders = Order::where('status', Order::STATUS_COMPLETED)
                ->whereNotNull('account_id')
                ->whereNotNull('expires_at')
                ->where('expires_at', '<', now())
                ->get();

            foreach ($expiredOrders as $order) {
                try {
                    DB::beginTransaction();

                    // Lock the account row
                    $account = Account::where('id', $order->account_id)
                        ->lockForUpdate()
                        ->first();

                    if ($account && !$account->is_available) {
                        // Update order status to expired
                        $order->status = 'expired';
                        $order->save();

                        // Chỉ chuyển Chờ thuê nếu KHÔNG có ghi chú
                        // Có ghi chú → giữ is_available = 0 (admin click thủ công)
                        if (empty($account->note)) {
                            $account->is_available = 1;
                            $account->available_since = now();
                            $account->save();
                        }

                        $count++;
                        Log::info("Reclaimed account: {$account->id} from order: {$order->tracking_code}" . (!empty($account->note) ? " (kept locked due to note)" : ""));
                    }

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error("Failed to reclaim account for order {$order->tracking_code}: " . $e->getMessage());
                }
            }

        } catch (\Exception $e) {
            Log::error("Reclaim expired accounts error: " . $e->getMessage());
        }

        return $count;
    }

    /**
     * Get account statistics by type
     */
    public static function getStats(string $type): array
    {
        return [
            'total' => Account::where('type', $type)->count(),
            'available' => Account::where('type', $type)->where('is_available', 1)->count(),
            'renting' => Account::where('type', $type)->where('is_available', 0)->count(),
        ];
    }
}
