<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Admin Dashboard - Statistics overview
     */
    public function dashboard()
    {
        // Revenue stats - 1 query instead of 3
        $revenue = DB::table('orders')
            ->whereIn('status', ['paid', 'completed'])
            ->whereNotNull('paid_at')
            ->select(
                DB::raw("SUM(CASE WHEN DATE(paid_at) = CURDATE() THEN amount ELSE 0 END) as today"),
                DB::raw("SUM(CASE WHEN paid_at >= '" . now()->startOfWeek()->format('Y-m-d H:i:s') . "' THEN amount ELSE 0 END) as week"),
                DB::raw("SUM(CASE WHEN paid_at >= '" . now()->startOfMonth()->format('Y-m-d H:i:s') . "' THEN amount ELSE 0 END) as month")
            )
            ->first();
        
        $todayRevenue = $revenue->today ?? 0;
        $weekRevenue = $revenue->week ?? 0;
        $monthRevenue = $revenue->month ?? 0;
        
        // Order stats - 1 query instead of 5
        $orderStats = DB::table('orders')
            ->select(
                DB::raw("COUNT(*) as total"),
                DB::raw("SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending"),
                DB::raw("SUM(CASE WHEN status = 'paid' THEN 1 ELSE 0 END) as paid"),
                DB::raw("SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed"),
                DB::raw("SUM(CASE WHEN DATE(created_at) = CURDATE() THEN 1 ELSE 0 END) as today")
            )
            ->first();
        
        $totalOrders = $orderStats->total ?? 0;
        $pendingOrders = $orderStats->pending ?? 0;
        $paidOrders = $orderStats->paid ?? 0;
        $completedOrders = $orderStats->completed ?? 0;
        $todayOrders = $orderStats->today ?? 0;
        
        // User stats
        $totalUsers = User::count();
        $todayUsers = User::whereDate('created_at', today())->count();
        $activeUsers = User::where('is_active', 1)->count();
        
        // Coupon stats
        $activeCoupons = Coupon::where('is_active', 1)->count();
        $totalCoupons = Coupon::count();
        
        // Recent orders
        $recentOrders = Order::orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return view('admin.dashboard', compact(
            'todayRevenue', 'weekRevenue', 'monthRevenue',
            'totalOrders', 'pendingOrders', 'paidOrders', 'completedOrders', 'todayOrders',
            'totalUsers', 'todayUsers', 'activeUsers',
            'activeCoupons', 'totalCoupons',
            'recentOrders'
        ));
    }
    
    /**
     * Orders Management
     */
    public function orders(Request $request)
    {
        $query = Order::with(['account', 'user'])->orderBy('created_at', 'desc');
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('search')) {
            $query->where('tracking_code', 'like', '%' . $request->search . '%');
        }
        
        $orders = $query->paginate(20)->withQueryString();
        
        $statusCounts = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');
        
        return view('admin.orders.index', compact('orders', 'statusCounts'));
    }
    
    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $oldStatus = $order->status;
        $newStatus = $request->status;
        $order->status = $newStatus;
        
        if ($newStatus === 'paid') {
            $order->paid_at = now();
        } elseif ($newStatus === 'completed') {
            $order->completed_at = now();
        }
        
        $order->save();
        
        // Auto-allocate account when:
        // 1. Changing from pending to paid, OR
        // 2. Order is paid/completed but has no account allocated yet
        $shouldAllocate = false;
        
        if ($oldStatus === 'pending' && $newStatus === 'paid') {
            $shouldAllocate = true;
        } elseif (in_array($newStatus, ['paid', 'completed']) && empty($order->account_id)) {
            $shouldAllocate = true;
        }
        
        if ($shouldAllocate) {
            // Refresh order to ensure all relationships are loaded
            $order->refresh();
            $order->load('price');
            
            // Log allocation attempt
            \Log::info("Admin allocation attempt for order: {$order->tracking_code}, service_type: {$order->service_type}, price_type: " . ($order->price?->type ?? 'null'));
            
            $allocationResult = \App\Services\AccountAllocationService::allocateAccount($order);
            
            if ($allocationResult['success']) {
                return back()->with('success', 'Đã thanh toán & cấp tài khoản thành công!');
            } else {
                \Log::warning("Admin allocation failed for order: {$order->tracking_code}, error: {$allocationResult['error']}");
                return back()->with('warning', 'Đã thanh toán nhưng không thể cấp tài khoản: ' . $allocationResult['error']);
            }
        }
        
        return back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }
    
    /**
     * Users Management
     */
    public function users(Request $request)
    {
        $query = User::orderBy('created_at', 'desc');
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }
        
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        $users = $query->paginate(20)->withQueryString();
        
        return view('admin.users.index', compact('users'));
    }
    
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        if ($request->has('balance')) {
            $user->balance = $request->balance;
        }
        
        if ($request->has('role')) {
            $user->role = $request->role;
        }
        
        if ($request->has('is_active')) {
            $user->is_active = $request->is_active;
        }
        
        $user->save();
        
        return back()->with('success', 'Cập nhật user thành công!');
    }
    
    /**
     * Coupons Management
     */
    public function coupons(Request $request)
    {
        $query = Coupon::orderBy('created_at', 'desc');
        
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }
        
        $coupons = $query->paginate(20)->withQueryString();
        
        return view('admin.coupons.index', compact('coupons'));
    }
    
    public function saveCoupon(Request $request, $id = null)
    {
        $data = $request->validate([
            'code' => 'required|string|max:50',
            'discount_type' => 'required|in:fixed,percent',
            'discount_value' => 'required|integer|min:1',
            'max_discount_amount' => 'nullable|integer',
            'is_active' => 'boolean',
            'expires_at' => 'nullable|date',
        ]);
        
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        
        if ($id) {
            $coupon = Coupon::findOrFail($id);
            $coupon->update($data);
            $message = 'Cập nhật mã giảm giá thành công!';
        } else {
            Coupon::create($data);
            $message = 'Tạo mã giảm giá thành công!';
        }
        
        return back()->with('success', $message);
    }
    
    public function toggleCoupon($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->is_active = !$coupon->is_active;
        $coupon->save();
        
        return back()->with('success', 'Đã cập nhật trạng thái mã giảm giá!');
    }
    
    // ==================== ACCOUNTS ====================
    
    public function accounts(Request $request)
    {
        $currentType = $request->get('type', 'Unlocktool');
        $allowedTypes = ['Unlocktool', 'Vietmap', 'TSMTool', 'Griffin', 'AMT', 'KGKiller', 'SamsungTool', 'DFTPro'];
        
        if (!in_array($currentType, $allowedTypes)) {
            $currentType = 'Unlocktool';
        }
        
        // Advanced query with sorting logic - Fixed 500 Error using Join
        $latestOrders = DB::table('orders')
            ->select('account_id', DB::raw('MAX(expires_at) as latest_expires_at'))
            ->where('status', 'completed')
            ->groupBy('account_id');

        // 8-tier sorting: Đang thuê (expired/no note → earliest first), Chờ thuê
        $accounts = DB::table('accounts')
            ->leftJoinSub($latestOrders, 'latest_orders', function ($join) {
                $join->on('accounts.id', '=', 'latest_orders.account_id');
            })
            ->select('accounts.*', 'latest_orders.latest_expires_at as sorting_expires_at')
            ->where('accounts.type', $currentType)
            ->orderByRaw("
                CASE 
                    WHEN accounts.is_available = 0 AND latest_orders.latest_expires_at < NOW() AND (accounts.note IS NULL OR accounts.note = '') THEN 1
                    WHEN accounts.is_available = 0 AND latest_orders.latest_expires_at >= NOW() AND (accounts.note IS NULL OR accounts.note = '') THEN 2
                    WHEN accounts.is_available = 0 AND (accounts.note IS NULL OR accounts.note = '') THEN 3
                    WHEN accounts.is_available = 0 AND latest_orders.latest_expires_at < NOW() AND accounts.note IS NOT NULL AND accounts.note != '' THEN 4
                    WHEN accounts.is_available = 0 AND latest_orders.latest_expires_at >= NOW() AND accounts.note IS NOT NULL AND accounts.note != '' THEN 5
                    WHEN accounts.is_available = 0 AND accounts.note IS NOT NULL AND accounts.note != '' THEN 6
                    ELSE 7
                END ASC
            ")
            ->orderByRaw("
                CASE 
                    WHEN accounts.is_available = 0 AND latest_orders.latest_expires_at >= NOW() THEN latest_orders.latest_expires_at
                    ELSE NULL 
                END ASC
            ")
            ->orderByRaw("
                CASE 
                    WHEN accounts.is_available = 1 THEN COALESCE(latest_orders.latest_expires_at, accounts.created_at)
                    ELSE NULL 
                END ASC
            ")
            ->orderBy('accounts.id', 'asc')
            ->paginate(50)
            ->withQueryString();
        
        // Get rental info for rented accounts only (efficient separate query)
        $rentedAccountIds = collect($accounts->items())
            ->where('is_available', 0)
            ->pluck('id')
            ->toArray();
        
        $rentalInfo = [];
        if (!empty($rentedAccountIds)) {
            $rentalInfo = DB::table('orders')
                ->whereIn('account_id', $rentedAccountIds)
                ->where('status', 'completed')
                ->whereNotNull('expires_at')
                ->select('account_id', 'tracking_code', 'expires_at', 'customer_email', 'ip_address')
                ->get()
                ->keyBy('account_id');
        }
        
        // Attach rental info to accounts
        foreach ($accounts as $account) {
            if (isset($rentalInfo[$account->id])) {
                $rental = $rentalInfo[$account->id];
                $account->rental_order_code = $rental->tracking_code;
                $account->rental_expires_at = $rental->expires_at;
                $account->renter_email = $rental->customer_email;
                $account->renter_ip = $rental->ip_address;
            }
        }
        
        // Get stats - 1 query instead of 3
        $statsRaw = DB::table('accounts')
            ->where('type', $currentType)
            ->select(
                DB::raw("COUNT(*) as total"),
                DB::raw("SUM(CASE WHEN is_available = 1 THEN 1 ELSE 0 END) as available"),
                DB::raw("SUM(CASE WHEN is_available = 0 THEN 1 ELSE 0 END) as renting")
            )
            ->first();
        
        $stats = [
            'total' => $statsRaw->total ?? 0,
            'available' => $statsRaw->available ?? 0,
            'renting' => $statsRaw->renting ?? 0,
        ];
        
        return view('admin.accounts.index', compact('accounts', 'currentType', 'allowedTypes', 'stats'));
    }
    
    public function addAccount(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'type' => 'required|string',
            'note' => 'nullable|string',
        ]);
        
        DB::table('accounts')->insert([
            'username' => $data['username'],
            'password' => $data['password'],
            'type' => $data['type'],
            'is_available' => 1,
            'note' => $data['note'] ?? null,
            'password_changed' => 0,
            'created_at' => now(),
        ]);
        
        return back()->with('success', 'Thêm tài khoản thành công!');
    }
    
    public function toggleAccount($id)
    {
        $account = DB::table('accounts')->where('id', $id)->first();
        
        if (!$account) {
            return redirect()->route('admin.accounts')->with('error', 'Tài khoản không tồn tại!');
        }
        
        // Use explicit status from form if provided, otherwise toggle
        $status = request()->input('status');
        if ($status === 'available') {
            $newAvailable = true;
        } elseif ($status === 'renting') {
            $newAvailable = false;
        } else {
            $newAvailable = !$account->is_available;
        }
        
        $updateData = ['is_available' => $newAvailable ? 1 : 0];
        
        // If toggling to available, also clear note and note_date
        if ($newAvailable) {
            $updateData['note'] = null;
            $updateData['note_date'] = null;
            $updateData['password_changed'] = 0;
        }
        
        // Also save password if provided (from edit page)
        $password = request()->input('password');
        if (!empty($password)) {
            $updateData['password'] = $password;
        }
        
        DB::table('accounts')->where('id', $id)->update($updateData);
        
        return redirect()->route('admin.accounts', ['type' => $account->type ?? 'Unlocktool'])->with('success', 'Đã cập nhật trạng thái tài khoản!');
    }
    
    public function updateAccount(Request $request, $id)
    {
        $account = DB::table('accounts')->where('id', $id)->first();
        $type = $account->type ?? 'Unlocktool';
        
        $data = [];
        
        if ($request->has('username')) $data['username'] = $request->username;
        if ($request->has('password')) $data['password'] = $request->password;
        if ($request->has('note')) $data['note'] = $request->note;
        if ($request->has('type')) $data['type'] = $request->type;
        if ($request->has('note_date')) $data['note_date'] = $request->note_date;
        if ($request->has('expires_at')) $data['expires_at'] = $request->expires_at;
        
        // Nếu thêm ghi chú → tự động chuyển Đang thuê
        if ($request->has('note') && !empty($request->note)) {
            $data['is_available'] = 0;
        }
        
        if (!empty($data)) {
            DB::table('accounts')->where('id', $id)->update($data);
        }
        
        return redirect()->route('admin.accounts', ['type' => $type])->with('success', 'Cập nhật tài khoản thành công!');
    }
    
    public function deleteAccount($id)
    {
        DB::table('accounts')->where('id', $id)->delete();
        return redirect()->route('admin.accounts')->with('success', 'Đã xóa tài khoản!');
    }
    
    /**
     * Edit Account - Show edit form
     */
    public function editAccount($id)
    {
        $account = DB::table('accounts')->where('id', $id)->first();
        
        if (!$account) {
            return redirect()->route('admin.accounts')->with('error', 'Tài khoản không tồn tại!');
        }
        
        return view('admin.accounts.edit', compact('account'));
    }
    
    /**
     * Change Account Password
     */
    public function changeAccountPassword(Request $request, $id)
    {
        $account = DB::table('accounts')->where('id', $id)->first();
        
        if (!$account) {
            return redirect()->route('admin.accounts')->with('error', 'Tài khoản không tồn tại!');
        }
        
        DB::table('accounts')->where('id', $id)->update([
            'password' => $request->password,
            'password_changed' => 1,
            'updated_at' => now(),
        ]);
        
        return redirect()->route('admin.accounts', ['type' => $account->type ?? 'Unlocktool'])->with('success', 'Đã đổi mật khẩu thành công!');
    }
    
    /**
     * Reset Account Telegram Session
     */
    public function resetAccountTG($id)
    {
        $account = DB::table('accounts')->where('id', $id)->first();
        
        if (!$account) {
            return redirect()->route('admin.accounts')->with('error', 'Tài khoản không tồn tại!');
        }
        
        // Reset telegram session fields
        DB::table('accounts')->where('id', $id)->update([
            'tg_session' => null,
            'tg_logged' => 0,
            'updated_at' => now(),
        ]);
        
        return redirect()->route('admin.accounts', ['type' => $account->type ?? 'Unlocktool'])->with('success', 'Đã reset Telegram session!');
    }
    
    /**
     * Lock all accounts with notes (set is_available = 0)
     */
    public function lockAccountsWithNotes(Request $request)
    {
        $type = $request->input('type', 'Unlocktool');
        
        $affected = DB::table('accounts')
            ->where('type', $type)
            ->where('is_available', 1)
            ->whereNotNull('note')
            ->where('note', '!=', '')
            ->update(['is_available' => 0]);
        
        return redirect()->route('admin.accounts', ['type' => $type])
            ->with('success', "Đã khóa {$affected} tài khoản có ghi chú!");
    }
    
    // ==================== PRICES ====================
    
    public function prices(Request $request)
    {
        $currentType = $request->get('type', 'Unlocktool');
        $allowedTypes = ['Unlocktool', 'Vietmap', 'TSMTool', 'Griffin', 'AMT', 'KGKiller', 'SamsungTool', 'DFTPro'];
        
        if (!in_array($currentType, $allowedTypes)) {
            $currentType = 'Unlocktool';
        }
        
        $prices = DB::table('prices')
            ->where('type', $currentType)
            ->orderBy('hours', 'asc')
            ->get();
        
        return view('admin.prices.index', compact('prices', 'currentType', 'allowedTypes'));
    }
    
    public function savePrice(Request $request, $id = null)
    {
        $data = $request->validate([
            'hours' => 'required|integer|min:1',
            'price' => 'required|integer|min:1000',
            'type' => 'required|string',
            'original_price' => 'nullable|integer',
            'discount_percent' => 'nullable|integer',
            'promo_label' => 'nullable|string',
            'promo_badge' => 'nullable|string',
            'promo_end' => 'nullable|date',
        ]);
        
        $priceData = [
            'hours' => $data['hours'],
            'price' => $data['price'],
            'type' => $data['type'],
            'original_price' => $data['original_price'] ?? null,
            'discount_percent' => $data['discount_percent'] ?? null,
            'promo_label' => $data['promo_label'] ?? null,
            'promo_badge' => $data['promo_badge'] ?? null,
            'promo_end' => $data['promo_end'] ?? null,
        ];
        
        if ($id) {
            DB::table('prices')->where('id', $id)->update($priceData);
            $message = 'Cập nhật gói thuê thành công!';
        } else {
            DB::table('prices')->insert($priceData);
            $message = 'Thêm gói thuê thành công!';
        }
        
        return back()->with('success', $message);
    }
    
    public function deletePrice($id)
    {
        DB::table('prices')->where('id', $id)->delete();
        return back()->with('success', 'Đã xóa gói thuê!');
    }
    
    // ==================== BLOG ====================
    
    public function blog(Request $request)
    {
        try {
            $query = DB::table('blog_posts')->orderBy('created_at', 'desc');
            
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            
            $posts = $query->paginate(20)->withQueryString();
            
            $stats = [
                'total' => DB::table('blog_posts')->count(),
                'published' => DB::table('blog_posts')->where('status', 'published')->count(),
                'draft' => DB::table('blog_posts')->where('status', 'draft')->count(),
            ];
        } catch (\Exception $e) {
            $posts = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 20);
            $stats = ['total' => 0, 'published' => 0, 'draft' => 0];
        }
        
        return view('admin.blog.index', compact('posts', 'stats'));
    }
    
    public function blogEdit($id = null)
    {
        $post = null;
        $categories = collect();
        
        try {
            if ($id) {
                $post = DB::table('blog_posts')->where('id', $id)->first();
            }
            $categories = DB::table('blog_categories')->get();
        } catch (\Exception $e) {
            // Tables don't exist yet
        }
        
        return view('admin.blog.edit', compact('post', 'categories'));
    }
    
    public function blogSave(Request $request, $id = null)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'image' => 'nullable|string',
            'category_id' => 'nullable|integer',
            'status' => 'required|in:draft,published',
            'featured' => 'boolean',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ]);
        
        $data['featured'] = $request->has('featured') ? 1 : 0;
        $data['updated_at'] = now();
        
        if ($id) {
            DB::table('blog_posts')->where('id', $id)->update($data);
            $message = 'Cập nhật bài viết thành công!';
        } else {
            $data['created_at'] = now();
            $data['views'] = 0;
            DB::table('blog_posts')->insert($data);
            $message = 'Tạo bài viết thành công!';
        }
        
        return redirect()->route('admin.blog')->with('success', $message);
    }
    
    public function blogDelete($id)
    {
        DB::table('blog_posts')->where('id', $id)->delete();
        return back()->with('success', 'Đã xóa bài viết!');
    }
    
    public function blogToggle($id)
    {
        $post = DB::table('blog_posts')->where('id', $id)->first();
        $newStatus = $post->status === 'published' ? 'draft' : 'published';
        
        DB::table('blog_posts')->where('id', $id)->update(['status' => $newStatus]);
        
        return back()->with('success', 'Đã cập nhật trạng thái bài viết!');
    }
    
    // ==================== ADY PRODUCTS ====================
    
    public function adyProducts(Request $request)
    {
        $adyService = new \App\Services\AdyService();
        $category = $request->get('category');
        $search = $request->get('search');
        $page = (int) $request->get('page', 1);
        $perPage = 50;
        
        $result = $adyService->getProductsByCategory($category, $search);
        $allProducts = array_values($result['products'] ?? []);
        $categories = $result['categories'] ?? [];
        $total = count($allProducts);
        
        // Manual pagination
        $offset = ($page - 1) * $perPage;
        $items = array_slice($allProducts, $offset, $perPage);
        
        $products = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
        
        $apiError = $result['api_error'] ?? null;
        $fromCache = $result['from_cache'] ?? false;
        
        return view('admin.ady.products', compact('products', 'categories', 'category', 'search', 'total', 'apiError', 'fromCache'));
    }
    
    // ==================== ADY ORDERS ====================
    
    public function adyOrders(Request $request)
    {
        try {
            $query = DB::table('ady_orders')->orderBy('created_at', 'desc');
            
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            
            $orders = $query->paginate(20)->withQueryString();
        } catch (\Exception $e) {
            $orders = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 20);
        }
        
        return view('admin.ady.orders', compact('orders'));
    }
    
    // ==================== UNDERPAID ORDERS ====================
    
    public function underpaidOrders(Request $request)
    {
        try {
            $orders = DB::table('orders')
                ->where('status', 'pending')
                ->where(function($q) {
                    $q->where('amount', '<', 1000) // Very low amount orders
                      ->orWhereNotNull('notes');   // Orders with notes
                })
                ->orderBy('created_at', 'desc')
                ->paginate(20)
                ->withQueryString();
        } catch (\Exception $e) {
            $orders = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 20);
        }
        
        return view('admin.underpaid.index', compact('orders'));
    }
    
    // ==================== ADY CONFIG ====================
    
    public function adyConfig()
    {
        try {
            $settings = DB::table('settings')->get()->keyBy('key');
        } catch (\Exception $e) {
            // Table doesn't exist - return empty collection
            $settings = collect();
        }
        
        return view('admin.ady.config', compact('settings'));
    }
    
    public function saveAdyConfig(Request $request)
    {
        $keys = ['ady_api_token', 'ady_api_url', 'ady_enabled', 'usd_to_vnd_rate', 'ady_markup_percent'];
        
        try {
            foreach ($keys as $key) {
                $value = $request->input($key);
                // Handle checkbox - if not present means unchecked
                if ($key === 'ady_enabled' && !$request->has($key)) {
                    $value = '0';
                }
                
                DB::table('settings')->updateOrInsert(
                    ['key' => $key],
                    ['value' => $value ?? '']
                );
            }
        
            // Clear ADY products cache so new settings take effect
            \Illuminate\Support\Facades\Cache::forget('ady_products_laravel');
            
            return back()->with('success', 'Đã lưu cấu hình ADY!');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }
    
    // ==================== REVENUE REPORTS ====================
    
    public function revenueReports(Request $request)
    {
        $period = $request->get('period', 'month');
        
        // Determine date range
        switch ($period) {
            case 'today':
                $startDate = today();
                $groupBy = 'HOUR(paid_at)';
                $labelFormat = 'H:00';
                break;
            case 'week':
                $startDate = now()->startOfWeek();
                $groupBy = 'DATE(paid_at)';
                $labelFormat = 'd/m';
                break;
            case 'year':
                $startDate = now()->startOfYear();
                $groupBy = 'MONTH(paid_at)';
                $labelFormat = 'm/Y';
                break;
            default: // month
                $startDate = now()->startOfMonth();
                $groupBy = 'DATE(paid_at)';
                $labelFormat = 'd/m';
        }
        
        // Get stats
        $totalRevenue = Order::whereIn('status', ['paid', 'completed'])
            ->where('paid_at', '>=', $startDate)
            ->sum('amount');
            
        $totalOrders = Order::whereIn('status', ['paid', 'completed'])
            ->where('paid_at', '>=', $startDate)
            ->count();
            
        $newUsers = User::where('created_at', '>=', $startDate)->count();
        
        // Revenue by service
        $revenueByService = Order::selectRaw('COALESCE(service_type, "Khác") as service_type, COUNT(*) as order_count, SUM(amount) as total_revenue')
            ->whereIn('status', ['paid', 'completed'])
            ->where('paid_at', '>=', $startDate)
            ->groupBy('service_type')
            ->orderByDesc('total_revenue')
            ->get();
        
        // Top customers by IP (since we don't have user_id)
        $topUsers = Order::selectRaw('ip_address, customer_email, COUNT(*) as order_count, SUM(amount) as total_spent')
            ->whereIn('status', ['paid', 'completed'])
            ->where('paid_at', '>=', $startDate)
            ->whereNotNull('ip_address')
            ->groupBy('ip_address', 'customer_email')
            ->orderByDesc('total_spent')
            ->limit(10)
            ->get()
            ->map(function($item) {
                $item->name = $item->customer_email ?: 'Guest';
                $item->email = $item->customer_email ?: $item->ip_address;
                return $item;
            });
        
        // Chart data
        $chartData = $this->getRevenueChartData($startDate, $period);
        
        return view('admin.reports.revenue', compact(
            'totalRevenue', 'totalOrders', 'newUsers',
            'revenueByService', 'topUsers', 'chartData'
        ));
    }
    
    private function getRevenueChartData($startDate, $period)
    {
        $data = Order::selectRaw('DATE(paid_at) as date, SUM(amount) as total')
            ->whereIn('status', ['paid', 'completed'])
            ->where('paid_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        return [
            'labels' => $data->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d/m'))->toArray(),
            'data' => $data->pluck('total')->toArray()
        ];
    }
    
    // ==================== SYSTEM SETTINGS ====================
    
    public function settings()
    {
        try {
            $settings = DB::table('settings')->get()->keyBy('key');
        } catch (\Exception $e) {
            $settings = collect();
        }
        
        return view('admin.settings.index', compact('settings'));
    }
    
    public function saveSettings(Request $request)
    {
        $keys = [
            'site_name', 'site_slogan', 'contact_email', 'contact_phone', 'contact_address',
            'social_facebook', 'social_zalo', 'social_telegram', 'social_youtube',
            'seo_title', 'seo_description', 'seo_keywords', 'google_analytics_id',
            'bank_account', 'bank_name', 'bank_holder', 'momo_phone',
            'maintenance_mode', 'registration_enabled', 'guest_checkout'
        ];
        
        try {
            foreach ($keys as $key) {
                $value = $request->input($key);
                if ($request->has($key) || in_array($key, ['maintenance_mode', 'registration_enabled', 'guest_checkout'])) {
                    // For checkboxes, default to 0 if not present
                    if (in_array($key, ['maintenance_mode', 'registration_enabled', 'guest_checkout'])) {
                        $value = $request->has($key) ? '1' : '0';
                    }
                    
                    DB::table('settings')->updateOrInsert(
                        ['key' => $key],
                        ['value' => $value, 'updated_at' => now()]
                    );
                }
            }
            
            return back()->with('success', 'Đã lưu cài đặt thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }
    
    // ==================== ACTIVITY LOGS ====================
    
    public function activityLogs(Request $request)
    {
        $days = (int) $request->get('days', 7);
        
        try {
            $query = DB::table('admin_logs')
                ->where('created_at', '>=', now()->subDays($days))
                ->orderBy('created_at', 'desc');
            
            if ($request->filled('action')) {
                $query->where('action', 'like', $request->action . '%');
            }
            
            $logs = $query->paginate(50);
            
            // Stats
            $stats = [
                'logins' => DB::table('admin_logs')->where('action', 'login')->where('created_at', '>=', now()->subDays($days))->count(),
                'order_updates' => DB::table('admin_logs')->where('action', 'like', 'order%')->where('created_at', '>=', now()->subDays($days))->count(),
                'account_changes' => DB::table('admin_logs')->where('action', 'like', 'account%')->where('created_at', '>=', now()->subDays($days))->count(),
                'settings_changes' => DB::table('admin_logs')->where('action', 'like', 'settings%')->where('created_at', '>=', now()->subDays($days))->count(),
            ];
        } catch (\Exception $e) {
            $logs = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 50);
            $stats = ['logins' => 0, 'order_updates' => 0, 'account_changes' => 0, 'settings_changes' => 0];
        }
        
        return view('admin.logs.index', compact('logs', 'stats'));
    }
    
    // ==================== SYSTEM INFO ====================
    
    public function systemInfo()
    {
        // Database stats
        $dbStats = [];
        $tables = ['orders', 'users', 'accounts', 'prices', 'coupons', 'blog_posts'];
        foreach ($tables as $table) {
            try {
                $dbStats[$table] = DB::table($table)->count();
            } catch (\Exception $e) {
                $dbStats[$table] = 0;
            }
        }
        
        // Disk info
        $diskTotal = disk_total_space(base_path());
        $diskFree = disk_free_space(base_path());
        $diskUsed = $diskTotal - $diskFree;
        
        $diskInfo = [
            'total' => $this->formatBytes($diskTotal),
            'used' => $this->formatBytes($diskUsed),
            'free' => $this->formatBytes($diskFree),
            'used_percent' => round(($diskUsed / $diskTotal) * 100, 1)
        ];
        
        // Extensions
        $extensions = get_loaded_extensions();
        sort($extensions);
        
        return view('admin.system.info', compact('dbStats', 'diskInfo', 'extensions'));
    }
    
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
    
    public function clearCache()
    {
        \Artisan::call('cache:clear');
        return back()->with('success', 'Đã xóa cache thành công!');
    }
    
    public function clearViews()
    {
        \Artisan::call('view:clear');
        return back()->with('success', 'Đã xóa compiled views!');
    }
    
    public function phpInfo()
    {
        phpinfo();
        exit;
    }
    
    // ==================== EXPORT ====================
    
    public function exportPage()
    {
        return view('admin.export.index');
    }
    
    public function exportOrders(Request $request)
    {
        $query = Order::query();
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('period') && $request->period !== 'all') {
            $startDate = match($request->period) {
                'today' => today(),
                'week' => now()->subDays(7),
                'month' => now()->subDays(30),
                'year' => now()->startOfYear(),
                default => null
            };
            if ($startDate) {
                $query->where('created_at', '>=', $startDate);
            }
        }
        
        $orders = $query->orderBy('created_at', 'desc')->get();
        
        $filename = 'orders_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];
        
        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Tracking Code', 'Service', 'Hours', 'Amount', 'Status', 'Created At', 'Paid At']);
            
            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->id,
                    $order->tracking_code,
                    $order->service_type,
                    $order->hours,
                    $order->amount,
                    $order->status,
                    $order->created_at,
                    $order->paid_at
                ]);
            }
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    public function exportUsers(Request $request)
    {
        $query = User::query();
        
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }
        
        $users = $query->orderBy('created_at', 'desc')->get();
        
        $filename = 'users_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];
        
        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'Email', 'Phone', 'Balance', 'Role', 'Status', 'Created At']);
            
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->phone,
                    $user->balance,
                    $user->role,
                    $user->is_active ? 'Active' : 'Inactive',
                    $user->created_at
                ]);
            }
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    public function exportAccounts(Request $request)
    {
        $query = DB::table('accounts');
        
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        if ($request->filled('status')) {
            $query->where('is_available', $request->status);
        }
        
        $accounts = $query->orderBy('id', 'desc')->get();
        
        $filename = 'accounts_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];
        
        $callback = function() use ($accounts) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Type', 'Username', 'Password', 'Note', 'Available', 'Expires At']);
            
            foreach ($accounts as $account) {
                fputcsv($file, [
                    $account->id,
                    $account->type,
                    $account->username,
                    $account->password,
                    $account->note ?? '',
                    $account->is_available ? 'Yes' : 'No',
                    $account->expires_at ?? ''
                ]);
            }
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    public function importAccounts(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:csv,txt']);
        
        $file = $request->file('file');
        $handle = fopen($file->getPathname(), 'r');
        
        // Skip header
        fgetcsv($handle);
        
        $imported = 0;
        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) >= 3) {
                DB::table('accounts')->insert([
                    'type' => $row[0] ?? 'Unlocktool',
                    'username' => $row[1],
                    'password' => $row[2],
                    'note' => $row[3] ?? null,
                    'is_available' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                $imported++;
            }
        }
        
        fclose($handle);
        
        return back()->with('success', "Đã import $imported tài khoản thành công!");
    }
    
    // ==================== BACKUP ====================
    
    public function backupPage()
    {
        $backupPath = storage_path('app/backups');
        if (!file_exists($backupPath)) {
            mkdir($backupPath, 0755, true);
        }
        
        $files = glob($backupPath . '/*.sql');
        $backups = [];
        
        foreach ($files as $file) {
            $backups[] = [
                'name' => basename($file),
                'size' => $this->formatBytes(filesize($file)),
                'date' => date('d/m/Y H:i:s', filemtime($file))
            ];
        }
        
        usort($backups, fn($a, $b) => strtotime($b['date']) - strtotime($a['date']));
        
        return view('admin.backup.index', compact('backups'));
    }
    
    public function createBackup()
    {
        $backupPath = storage_path('app/backups');
        if (!file_exists($backupPath)) {
            mkdir($backupPath, 0755, true);
        }
        
        $filename = 'backup_' . date('Y-m-d_His') . '.sql';
        $filepath = $backupPath . '/' . $filename;
        
        // Get all tables
        $tables = DB::select('SHOW TABLES');
        $dbName = config('database.connections.mysql.database');
        $key = "Tables_in_$dbName";
        
        $sql = "-- Backup created at " . date('Y-m-d H:i:s') . "\n\n";
        
        foreach ($tables as $table) {
            $tableName = $table->$key;
            
            // Get create table statement
            $createTable = DB::select("SHOW CREATE TABLE `$tableName`");
            $sql .= "DROP TABLE IF EXISTS `$tableName`;\n";
            $sql .= $createTable[0]->{'Create Table'} . ";\n\n";
            
            // Get data
            $rows = DB::table($tableName)->get();
            if ($rows->count() > 0) {
                $columns = array_keys((array)$rows[0]);
                $sql .= "INSERT INTO `$tableName` (`" . implode('`, `', $columns) . "`) VALUES\n";
                
                $values = [];
                foreach ($rows as $row) {
                    $rowValues = array_map(function($v) {
                        if ($v === null) return 'NULL';
                        return "'" . addslashes($v) . "'";
                    }, (array)$row);
                    $values[] = '(' . implode(', ', $rowValues) . ')';
                }
                
                $sql .= implode(",\n", $values) . ";\n\n";
            }
        }
        
        file_put_contents($filepath, $sql);
        
        return back()->with('success', "Đã tạo backup: $filename");
    }
    
    public function downloadBackup($filename)
    {
        $filepath = storage_path('app/backups/' . $filename);
        
        if (!file_exists($filepath)) {
            return back()->with('error', 'File không tồn tại!');
        }
        
        return response()->download($filepath);
    }
    
    public function deleteBackup($filename)
    {
        $filepath = storage_path('app/backups/' . $filename);
        
        if (file_exists($filepath)) {
            unlink($filepath);
            return back()->with('success', 'Đã xóa backup!');
        }
        
        return back()->with('error', 'File không tồn tại!');
    }
    
    public function optimizeTables()
    {
        $tables = DB::select('SHOW TABLES');
        $dbName = config('database.connections.mysql.database');
        $key = "Tables_in_$dbName";
        
        foreach ($tables as $table) {
            DB::statement("OPTIMIZE TABLE `{$table->$key}`");
        }
        
        return back()->with('success', 'Đã optimize tất cả tables!');
    }
    
    public function clearAllCache()
    {
        \Artisan::call('cache:clear');
        \Artisan::call('config:clear');
        \Artisan::call('route:clear');
        \Artisan::call('view:clear');
        
        return back()->with('success', 'Đã xóa tất cả cache!');
    }
    
    // ==================== GLOBAL SEARCH ====================
    
    public function globalSearch(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Vui lòng nhập ít nhất 2 ký tự để tìm kiếm');
        }
        
        $results = collect();
        
        // Search orders
        $results['orders'] = Order::where('tracking_code', 'LIKE', "%$query%")
            ->orWhere('service_type', 'LIKE', "%$query%")
            ->orWhere('notes', 'LIKE', "%$query%")
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Search users
        $results['users'] = User::where('name', 'LIKE', "%$query%")
            ->orWhere('email', 'LIKE', "%$query%")
            ->orWhere('phone', 'LIKE', "%$query%")
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Search accounts
        try {
            $results['accounts'] = DB::table('accounts')
                ->where('username', 'LIKE', "%$query%")
                ->orWhere('note', 'LIKE', "%$query%")
                ->orWhere('type', 'LIKE', "%$query%")
                ->orderBy('id', 'desc')
                ->limit(10)
                ->get();
        } catch (\Exception $e) {
            $results['accounts'] = collect();
        }
        
        // Search coupons
        try {
            $results['coupons'] = DB::table('coupons')
                ->where('code', 'LIKE', "%$query%")
                ->orderBy('id', 'desc')
                ->limit(10)
                ->get();
        } catch (\Exception $e) {
            $results['coupons'] = collect();
        }
        
        return view('admin.search.index', compact('query', 'results'));
    }
}

