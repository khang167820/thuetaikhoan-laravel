<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderHistoryController extends Controller
{
    /**
     * Display the order history page (by IP - 30 days)
     */
    public function index(Request $request)
    {
        $customerIp = $request->ip();
        $error = null;
        $orders = collect();

        if (empty($customerIp)) {
            $error = 'Không thể xác định địa chỉ IP';
        } else {
            // Get orders by IP in last 30 days
            $orders = DB::table('orders')
                ->leftJoin('accounts', 'orders.account_id', '=', 'accounts.id')
                ->leftJoin('prices', 'orders.price_id', '=', 'prices.id')
                ->select(
                    'orders.id',
                    'orders.tracking_code',
                    'orders.hours',
                    'orders.amount',
                    'orders.status',
                    'orders.created_at',
                    'orders.paid_at',
                    'orders.expires_at',
                    'orders.ady_product_uuid',
                    'orders.ady_order_uuid',
                    'accounts.type as account_type',
                    'prices.type as service_type'
                )
                ->where('orders.ip_address', $customerIp)
                ->where('orders.created_at', '>=', now()->subDays(30))
                ->orderBy('orders.created_at', 'desc')
                ->limit(100)
                ->get();
        }

        return view('pages.order-history', compact('orders', 'error', 'customerIp'));
    }

    /**
     * Get service name from order
     */
    public static function getServiceName($order)
    {
        // Priority: account_type
        if (!empty($order->account_type)) {
            $type = trim($order->account_type);
            if (strtolower($type) === 'tsmtool') return 'TSM Tool';
            return $type;
        }

        // Priority: service_type from prices
        if (!empty($order->service_type)) {
            $type = trim($order->service_type);
            if (stripos($type, 'kgkiller') !== false) return 'KGKiller';
            if (stripos($type, 'griffin') !== false) return 'Griffin';
            if (stripos($type, 'unlocktool') !== false) return 'Unlocktool';
            if (stripos($type, 'vietmap') !== false) return 'Vietmap';
            if (stripos($type, 'tsm') !== false) return 'TSM Tool';
            if (stripos($type, 'amt') !== false) return 'AMT';
            return $type;
        }

        // Fallback: classify from tracking_code
        $code = strtolower((string)($order->tracking_code ?? ''));
        if (strpos($code, 'vietmap') !== false) return 'Vietmap';
        if (strpos($code, 'tsm') !== false) return 'TSM Tool';
        if (strpos($code, 'griffin') !== false) return 'Griffin';
        if (strpos($code, 'amt') !== false) return 'AMT';
        if (strpos($code, 'unlock') !== false || strpos($code, 'rent') !== false) return 'Unlocktool';
        if (strpos($code, 'kg') !== false) return 'KGKiller';

        return 'Dịch vụ khác';
    }

    /**
     * Get status text
     */
    public static function getStatusText($status)
    {
        $map = [
            'pending' => 'Chờ thanh toán',
            'paid' => 'Đã thanh toán',
            'confirmed' => 'Hoàn thành',
            'cancelled' => 'Đã hủy',
            'expired' => 'Hết hạn',
            'completed' => 'Hoàn thành',
        ];
        return $map[$status] ?? $status;
    }

    /**
     * Get status badge class
     */
    public static function getStatusBadgeClass($status)
    {
        $map = [
            'pending' => 'status-pending',
            'paid' => 'status-paid',
            'confirmed' => 'status-completed',
            'cancelled' => 'status-failed',
            'expired' => 'status-failed',
            'completed' => 'status-completed',
        ];
        return $map[$status] ?? '';
    }
}
