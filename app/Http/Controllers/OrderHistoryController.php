<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
     * Display order history for authenticated user
     * Shows orders by user_id or IP address
     */
    public function userOrders(Request $request)
    {
        $user = Auth::user();
        $filter = $request->input('status', 'all');
        
        // Build query for authenticated user's orders
        $query = DB::table('orders')
            ->leftJoin('accounts', 'orders.account_id', '=', 'accounts.id')
            ->leftJoin('prices', 'orders.price_id', '=', 'prices.id')
            ->select(
                'orders.id',
                'orders.tracking_code',
                'orders.hours',
                'orders.amount',
                'orders.status',
                'orders.service_type',
                'orders.created_at',
                'orders.paid_at',
                'orders.expires_at',
                'accounts.type as account_type',
                'accounts.username as account_username',
                'accounts.password as account_password',
                'prices.type as price_type'
            )
            ->where(function ($q) use ($user, $request) {
                // Match by user_id if exists in orders table
                $q->where('orders.user_id', $user->id)
                  // Or by IP for backward compatibility
                  ->orWhere('orders.ip_address', $request->ip());
            })
            ->orderBy('orders.created_at', 'desc');
        
        // Apply status filter
        if ($filter !== 'all') {
            $query->where('orders.status', $filter);
        }
        
        // Paginate results
        $orders = $query->paginate(20)->withQueryString();
        
        // Get counts for each status
        $statusCounts = DB::table('orders')
            ->where(function ($q) use ($user, $request) {
                $q->where('user_id', $user->id)
                  ->orWhere('ip_address', $request->ip());
            })
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');
        
        return view('order-history', compact('orders', 'filter', 'statusCounts', 'user'));
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
