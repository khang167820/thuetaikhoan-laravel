<?php

namespace App\Http\Controllers;

use App\Services\AdyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrdCheckoutController extends Controller
{
    protected AdyService $adyService;
    
    // Bank info - same as old site
    const BANK_BIN = 'ACB';
    const BANK_ACCOUNT = '20867091';
    const BANK_OWNER = 'MAI THI THU QUYEN';
    const BANK_NAME = 'ACB - Á Châu';

    public function __construct(AdyService $adyService)
    {
        $this->adyService = $adyService;
    }

    /**
     * Display checkout page
     */
    public function show(Request $request)
    {
        // MAINTENANCE MODE - Uncomment block below to re-enable
        // return view('pages.ord-maintenance');
        // END MAINTENANCE MODE
        
        $uuid = $request->input('uuid');
        
        if (!$uuid) {
            return redirect('/ord-services')->with('error', 'Vui lòng chọn dịch vụ');
        }

        $productsData = $this->adyService->getProducts();
        $products = $productsData['products'] ?? [];
        $product = $products[$uuid] ?? null;

        if (!$product) {
            return redirect('/ord-services')->with('error', 'Dịch vụ không tồn tại');
        }

        $priceVnd = $this->adyService->convertUsdToVnd((float)($product['price'] ?? 0));
        
        $productData = [
            'uuid' => $uuid,
            'name' => $product['name'] ?? 'Unknown',
            'priceUsd' => (float)($product['price'] ?? 0),
            'priceVnd' => $priceVnd,
            'deliveryTime' => $product['delivery_time'] ?? 'N/A',
            'category' => $this->adyService->classifyProduct($product['name'] ?? ''),
            'fields' => $product['fields'] ?? [],
        ];

        $userBalance = 0;
        if (Auth::check()) {
            $userBalance = Auth::user()->balance ?? 0;
        }

        return view('pages.ord-checkout', [
            'product' => $productData,
            'fromCache' => $productsData['from_cache'] ?? false,
            'userBalance' => $userBalance,
            'bankInfo' => [
                'bin' => self::BANK_BIN,
                'account' => self::BANK_ACCOUNT,
                'owner' => self::BANK_OWNER,
                'name' => self::BANK_NAME,
            ],
        ]);
    }

    /**
     * Process order submission - Creates pending order with QR payment
     * Guests can also place orders (no login required)
     */
    public function submit(Request $request)
    {
        try {
            // Manual validation for better JSON error response
            $uuid = $request->input('uuid');
            $email = $request->input('email');
            $imei = $request->input('imei', '');
            $serial = $request->input('serial', '');
            $notes = $request->input('notes', '');
            
            if (empty($uuid)) {
                return response()->json(['success' => false, 'error' => 'Thiếu mã sản phẩm']);
            }
            
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return response()->json(['success' => false, 'error' => 'Email không hợp lệ']);
            }
        
        // Get product to calculate price
        $productsData = $this->adyService->getProducts();
        $products = $productsData['products'] ?? [];
        $product = $products[$uuid] ?? null;
        
        if (!$product) {
            return response()->json([
                'success' => false,
                'error' => 'Sản phẩm không tồn tại'
            ]);
        }
        
        $priceUsd = (float)($product['price'] ?? 0);
        $priceVnd = $this->adyService->convertUsdToVnd($priceUsd);
        $productName = $product['name'] ?? 'Unknown';
        
        if ($priceVnd <= 0) {
            return response()->json([
                'success' => false,
                'error' => 'Lỗi: Giá sản phẩm không hợp lệ'
            ]);
        }
        
        // Build fields
        $fields = [
            'IMEI' => $imei,
            'Serial' => $serial,
            'Email' => $email,
            'Notes' => $notes,
        ];
        $fields = array_filter($fields, fn($v) => $v !== '' && $v !== null);
        
        // Generate tracking code
        $trackingCode = 'ADY' . date('dmy') . rand(1000, 9999);
        
        // Make sure tracking code is unique
        $attempts = 0;
        while (DB::table('ady_orders')->where('tracking_code', $trackingCode)->exists() && $attempts < 10) {
            $trackingCode = 'ADY' . date('dmy') . rand(1000, 9999);
            $attempts++;
        }
        
            // Create pending order
            $orderId = DB::table('ady_orders')->insertGetId([
                'user_id' => Auth::id(), // null for guests
                'tracking_code' => $trackingCode,
                'product_uuid' => $uuid,
                'product_name' => $productName,
                'price_usd' => $priceUsd,
                'price_vnd' => $priceVnd,
                'fields' => json_encode($fields),
                'customer_email' => $email,
                'status' => 'pending',
                'ip_address' => $request->ip(),
                'created_at' => now(),
            ]);
            
            // Generate QR URL
            $qrUrl = 'https://img.vietqr.io/image/' . self::BANK_BIN . '-' . self::BANK_ACCOUNT 
                   . '-compact.png?amount=' . $priceVnd 
                   . '&addInfo=' . urlencode($trackingCode) 
                   . '&accountName=' . urlencode(self::BANK_OWNER);
            
            return response()->json([
                'success' => true,
                'order_id' => $orderId,
                'tracking_code' => $trackingCode,
                'amount' => $priceVnd,
                'qr_url' => $qrUrl,
                'bank_info' => [
                    'name' => self::BANK_NAME,
                    'account' => self::BANK_ACCOUNT,
                    'owner' => self::BANK_OWNER,
                    'content' => $trackingCode,
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('ADY Order Create Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Lỗi tạo đơn hàng: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Pay pending order with user balance
     */
    public function payWithBalance(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'error' => 'Vui lòng đăng nhập']);
        }
        
        $orderId = $request->input('order_id');
        $order = DB::table('ady_orders')->where('id', $orderId)->first();
        
        if (!$order) {
            return response()->json(['success' => false, 'error' => 'Không tìm thấy đơn hàng']);
        }
        
        if ($order->status !== 'pending') {
            return response()->json(['success' => false, 'error' => 'Đơn hàng đã được xử lý']);
        }
        
        $user = Auth::user();
        if ($user->balance < $order->price_vnd) {
            return response()->json([
                'success' => false, 
                'error' => 'Số dư không đủ. Cần ' . number_format($order->price_vnd) . 'đ'
            ]);
        }
        
        DB::beginTransaction();
        try {
            // Deduct balance
            DB::table('users')->where('id', $user->id)->decrement('balance', $order->price_vnd);
            
            // Mark as paid
            DB::table('ady_orders')->where('id', $orderId)->update([
                'status' => 'paid',
                'user_id' => $user->id,
                'paid_at' => now(),
            ]);
            
            // Place ADY order
            $fields = json_decode($order->fields, true) ?? [];
            $feedbackUrl = url('/ady-webhook.php');
            
            $result = $this->adyService->placeOrder(
                $order->product_uuid,
                $fields,
                $order->tracking_code,
                $feedbackUrl
            );
            
            if ($result['success']) {
                DB::table('ady_orders')->where('id', $orderId)->update([
                    'ady_order_uuid' => $result['order_uuid'],
                    'status' => 'processing',
                ]);
                DB::commit();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Thanh toán thành công! Đang xử lý đơn hàng...',
                    'redirect' => '/don-ady?code=' . $order->tracking_code,
                ]);
            } else {
                // ADY order failed - refund
                DB::table('users')->where('id', $user->id)->increment('balance', $order->price_vnd);
                DB::table('ady_orders')->where('id', $orderId)->update([
                    'status' => 'failed',
                    'error' => $result['error'] ?? 'Unknown error',
                ]);
                DB::commit();
                
                return response()->json([
                    'success' => false,
                    'error' => 'Lỗi đặt hàng ADY: ' . ($result['error'] ?? 'Unknown')
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Pay with balance error: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Lỗi hệ thống']);
        }
    }
    
    /**
     * Check payment status for polling
     */
    public function checkPayment(Request $request)
    {
        $code = $request->input('code');
        
        if (!$code) {
            return response()->json(['paid' => false]);
        }
        
        $order = DB::table('ady_orders')->where('tracking_code', $code)->first();
        
        if (!$order) {
            return response()->json(['paid' => false]);
        }
        
        $isPaid = in_array($order->status, ['paid', 'processing', 'completed']);
        
        return response()->json([
            'paid' => $isPaid,
            'status' => $order->status,
            'result' => $order->result,
        ]);
    }
    
    /**
     * Display order result page
     */
    public function orderResult(Request $request)
    {
        $code = $request->input('code');
        
        if (!$code) {
            return redirect('/ord-services');
        }
        
        $order = DB::table('ady_orders')->where('tracking_code', $code)->first();
            
        if (!$order) {
            return redirect('/ord-services')->with('error', 'Không tìm thấy đơn hàng');
        }
        
        // Security: Only allow viewing if guest (by IP) or logged-in owner
        $canView = false;
        if (Auth::check() && $order->user_id == Auth::id()) {
            $canView = true;
        } elseif ($order->ip_address == $request->ip()) {
            $canView = true;
        } elseif (!$order->user_id) {
            // Guest order - allow viewing by tracking code
            $canView = true;
        }
        
        if (!$canView) {
            return redirect('/ord-services')->with('error', 'Không có quyền xem đơn hàng này');
        }
        
        return view('pages.ord-result', compact('order'));
    }
}
