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
            // Get paid rental orders by IP in last 30 days
            $rentalOrders = DB::table('orders')
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
                    'accounts.type as account_type',
                    'prices.type as service_type',
                    DB::raw("'rental' as order_type")
                )
                ->where('orders.ip_address', $customerIp)
                ->where('orders.created_at', '>=', now()->subDays(30))
                ->whereIn('orders.status', ['paid', 'completed'])
                ->orderBy('orders.created_at', 'desc')
                ->limit(100)
                ->get();
            
            // Get ADY orders by IP in last 30 days
            $adyOrders = DB::table('ady_orders')
                ->select(
                    'id',
                    'tracking_code',
                    DB::raw('NULL as hours'),
                    'price_vnd as amount',
                    'status',
                    'created_at',
                    DB::raw('paid_at as paid_at'),
                    DB::raw('NULL as expires_at'),
                    DB::raw("NULL as account_type"),
                    'product_name as service_type',
                    DB::raw("'ady' as order_type")
                )
                ->where('ip_address', $customerIp)
                ->where('created_at', '>=', now()->subDays(30))
                ->orderBy('created_at', 'desc')
                ->limit(100)
                ->get();
            
            // Merge and sort
            $orders = $rentalOrders->concat($adyOrders)
                ->sortByDesc('created_at')
                ->values();
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
                'accounts.password as current_password', // Password hiện tại trong accounts
                'orders.assigned_password', // Password lúc cấp (lưu trong orders)
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
     * Shows orders by user_id or IP address (including ADY orders)
     */
    public function userOrders(Request $request)
    {
        $user = Auth::user();
        $filter = $request->input('status', 'all');
        $ip = $request->ip();
        
        // Get regular orders
        $regularOrders = DB::table('orders')
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
                'prices.type as price_type',
                DB::raw("'rental' as order_type")
            )
            ->where('orders.ip_address', $ip)
            ->when($filter !== 'all', function ($q) use ($filter) {
                if ($filter === 'completed') {
                    $q->whereIn('orders.status', ['paid', 'completed', 'confirmed']);
                } elseif ($filter === 'pending') {
                    $q->where('orders.status', 'pending')
                      ->where('orders.created_at', '>=', now()->subHours(24));
                } else {
                    $q->where('orders.status', $filter);
                }
            })
            ->orderBy('orders.created_at', 'desc')
            ->get();
        
        // Get ADY orders
        $adyOrders = DB::table('ady_orders')
            ->select(
                'id',
                'tracking_code',
                DB::raw('NULL as hours'),
                'price_vnd as amount',
                'status',
                DB::raw("'ADY' as service_type"),
                'created_at',
                DB::raw('paid_at as paid_at'),
                DB::raw('NULL as expires_at'),
                DB::raw("NULL as account_type"),
                'product_name as account_username',
                'result as account_password',
                DB::raw("NULL as price_type"),
                DB::raw("'ady' as order_type")
            )
            ->where(function ($q) use ($user, $ip) {
                if ($user) {
                    $q->where('user_id', $user->id);
                }
                $q->orWhere('ip_address', $ip);
            })
            ->when($filter !== 'all', function ($q) use ($filter) {
                if ($filter === 'completed') {
                    $q->whereIn('status', ['completed', 'paid']);
                } elseif ($filter === 'pending') {
                    $q->where('status', 'pending')
                      ->where('created_at', '>=', now()->subHours(24));
                } else {
                    $q->where('status', $filter);
                }
            })
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Merge and sort by created_at desc
        $allOrders = $regularOrders->concat($adyOrders)
            ->sortByDesc('created_at')
            ->values();
        
        // Simple pagination (convert to paginator if needed)
        $page = $request->input('page', 1);
        $perPage = 20;
        $orders = new \Illuminate\Pagination\LengthAwarePaginator(
            $allOrders->forPage($page, $perPage),
            $allOrders->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
        
        // Get counts for each status (including ADY orders)
        $regularCounts = DB::table('orders')
            ->where('ip_address', $ip)
            ->where(function ($q) {
                $q->where('status', '!=', 'pending')
                  ->orWhere(function ($q2) {
                      $q2->where('status', 'pending')
                         ->where('created_at', '>=', now()->subHours(24));
                  });
            })
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
            
        $adyCounts = DB::table('ady_orders')
            ->where(function ($q) use ($user, $ip) {
                if ($user) {
                    $q->where('user_id', $user->id);
                }
                $q->orWhere('ip_address', $ip);
            })
            ->where(function ($q) {
                $q->where('status', '!=', 'pending')
                  ->orWhere(function ($q2) {
                      $q2->where('status', 'pending')
                         ->where('created_at', '>=', now()->subHours(24));
                  });
            })
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
        
        // Merge counts
        $statusCounts = collect($regularCounts);
        foreach ($adyCounts as $status => $count) {
            $statusCounts[$status] = ($statusCounts[$status] ?? 0) + $count;
        }
        
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
            'processing' => 'Đang xử lý',
            'failed' => 'Thất bại',
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
            'processing' => 'status-processing',
            'failed' => 'status-failed',
        ];
        return $map[$status] ?? '';
    }
}
