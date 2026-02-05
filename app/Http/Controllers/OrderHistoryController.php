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
            // Get paid orders by IP in last 30 days (exclude pending)
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
                ->whereIn('orders.status', ['paid', 'completed'])
                ->orderBy('orders.created_at', 'desc')
                ->limit(100)
                ->get();
        }

        return view('pages.order-history', compact('orders', 'error', 'customerIp'));
    }

    /**
     * Display order detail page
     */
    public function orderDetail(Request $request)
    {
        $code = $request->input('code');
        $customerIp = $request->ip();
        
        if (empty($code)) {
            return redirect()->route('order-history')->with('error', 'Mã đơn hàng không hợp lệ');
        }

        // Get order with related data
        $order = DB::table('orders')
            ->leftJoin('accounts', 'orders.account_id', '=', 'accounts.id')
            ->leftJoin('prices', 'orders.price_id', '=', 'prices.id')
            ->select(
                'orders.*',
                'accounts.type as account_type',
                'accounts.username as account_username',
                'accounts.password as account_password',
                'prices.type as service_type',
                'prices.price as original_price',
                'prices.hours as price_hours'
            )
            ->where('orders.tracking_code', $code)
            ->first();

        if (!$order) {
            return redirect()->route('order-history')->with('error', 'Không tìm thấy đơn hàng');
        }

        // Security: Only allow access if order belongs to this IP or authenticated user
        $canAccess = false;
        if (Auth::check()) {
            // Check if user_id property exists to avoid error if migration not run
            $hasUserId = property_exists($order, 'user_id');
            $canAccess = (($hasUserId && $order->user_id == Auth::id()) || $order->ip_address == $customerIp);
        } else {
            $canAccess = ($order->ip_address == $customerIp);
        }

        if (!$canAccess) {
            return redirect()->route('order-history')->with('error', 'Bạn không có quyền xem đơn hàng này');
        }

        return view('pages.order-detail', compact('order'));
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
                'orders.service_type', // Ensure this column is safe too? It was missing in error? No, error was user_id
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
                // TODO: Uncomment when migration 2026_01_31_180800 is run
                // $q->where('orders.user_id', $user->id) 
                
                // Fallback to IP address only for now to avoid SQL error
                $q->where('orders.ip_address', $request->ip());
            })
            ->orderBy('orders.created_at', 'desc');
        
        // Apply status filter
        if ($filter !== 'all') {
            $query->where('orders.status', $filter);
            
            // For pending orders, only show those created within 24 hours
            if ($filter === 'pending') {
                $query->where('orders.created_at', '>=', now()->subHours(24));
            }
        }
        
        // Paginate results
        $orders = $query->paginate(20)->withQueryString();
        
        // Get counts for each status
        // For pending, only count orders from last 24 hours
        $statusCounts = DB::table('orders')
            ->where(function ($q) use ($user, $request) {
                // TODO: Uncomment check user_id when migration is run
                // $q->where('user_id', $user->id)
                //  ->orWhere('ip_address', $request->ip());
                
                // Fallback to IP only
                $q->where('ip_address', $request->ip());
            })
            ->where(function ($q) {
                // Exclude old pending orders from count
                $q->where('status', '!=', 'pending')
                  ->orWhere(function ($q2) {
                      $q2->where('status', 'pending')
                         ->where('created_at', '>=', now()->subHours(24));
                  });
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
