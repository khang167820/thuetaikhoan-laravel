<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Price;
use App\Helpers\OrderHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Display checkout page
     */
    public function show(Request $request)
    {
        // Mapping from frontend service IDs to database type values
        $serviceTypeMapping = [
            'unlocktool' => 'Unlocktool',
            'vietmap' => 'Vietmap',
            'griffin' => 'Griffin',
            'amt' => 'AMT',
            'kg-killer' => 'KGKiller',
            'samsung-tool' => 'SamsungTool',
            'dft' => 'DFTPro',
            'tsm' => 'TSMTool',
        ];
        
        // Get price_id from request OR find by service+hours
        $priceId = $request->input('price_id');
        $serviceType = $request->input('service');
        $hours = $request->input('hours');
        
        // If no price_id but have service+hours, find the price
        if (!$priceId && $serviceType && $hours) {
            // Map frontend service type to database type
            $dbType = $serviceTypeMapping[$serviceType] ?? $serviceType;
            
            $price = Price::where('type', $dbType)
                ->where('hours', (int)$hours)
                ->first();
        } else if ($priceId) {
            $price = Price::find($priceId);
        } else {
            return redirect('/')->with('error', 'Vui lòng chọn gói dịch vụ');
        }
        
        if (!$price) {
            return redirect('/')->with('error', 'Gói dịch vụ không tồn tại');
        }

        // Calculate discounts from URL parameters
        $usePoints = $request->input('use_points') == '1';
        $couponCode = $request->input('coupon');
        
        $originalPrice = $price->price;
        $totalDiscount = 0;
        $discountDetails = [];
        
        // Loyalty points discount (fixed 3000 VND)
        $pointsDiscount = 0;
        if ($usePoints) {
            $pointsDiscount = 3000;
            $totalDiscount += $pointsDiscount;
            $discountDetails[] = ['label' => 'Điểm tích lũy', 'amount' => $pointsDiscount];
        }
        
        // Coupon discount
        $couponDiscount = 0;
        $appliedCoupon = null;
        if ($couponCode) {
            $coupon = \App\Models\Coupon::where('code', $couponCode)
                ->where('is_active', true)
                ->first();
            
            if ($coupon) {
                if ($coupon->discount_type === 'percent') {
                    $couponDiscount = round(($originalPrice * $coupon->discount_value) / 100);
                } else {
                    $couponDiscount = $coupon->discount_value;
                }
                $totalDiscount += $couponDiscount;
                $discountDetails[] = ['label' => 'Mã ' . $couponCode, 'amount' => $couponDiscount];
                $appliedCoupon = $coupon;
            }
        }
        
        // Final price
        $finalPrice = max(0, $originalPrice - $totalDiscount);

        // Check if user is logged in and get balance
        $userBalance = 0;
        if (Auth::check()) {
            $userBalance = Auth::user()->balance ?? 0;
        }

        // Get bank info
        $bankInfo = OrderHelper::getBankInfo();

        return view('checkout', [
            'price' => $price,
            'bankInfo' => $bankInfo,
            'userBalance' => $userBalance,
            'isLoggedIn' => Auth::check(),
            // Discount data
            'originalPrice' => $originalPrice,
            'totalDiscount' => $totalDiscount,
            'finalPrice' => $finalPrice,
            'discountDetails' => $discountDetails,
            'usePoints' => $usePoints,
            'couponCode' => $couponCode,
            'pointsDiscount' => $pointsDiscount,
            'couponDiscount' => $couponDiscount,
        ]);
    }

    /**
     * Create new order
     */
    public function createOrder(Request $request)
    {
        $request->validate([
            'price_id' => 'required|integer|exists:prices,id',
            'customer_email' => 'nullable|email|max:255',
        ]);

        // Verify reCAPTCHA v3
        $recaptchaResponse = $request->input('g-recaptcha-response');
        if ($recaptchaResponse) {
            $recaptchaResult = $this->verifyRecaptcha($recaptchaResponse, 'create_order');
            if (!$recaptchaResult['success']) {
                return back()->withErrors(['recaptcha' => $recaptchaResult['message']]);
            }
        }

        $priceId = $request->input('price_id');
        $customerEmail = $request->input('customer_email');

        // Get price
        $price = Price::find($priceId);
        
        if (!$price) {
            return back()->with('error', 'Gói dịch vụ không tồn tại');
        }

        // Generate tracking code
        $trackingCode = OrderHelper::generateTrackingCode();

        // Calculate hours from duration
        $hours = $price->hours ?? 0;

        // Create order
        $order = Order::create([
            'tracking_code' => $trackingCode,
            'price_id' => $priceId,
            'service_type' => $price->type,
            'hours' => $hours,
            'amount' => $price->price,
            'status' => Order::STATUS_PENDING,
            'ip_address' => $request->ip(),
            'customer_email' => $customerEmail,
            'created_at' => now(),
        ]);

        // Generate QR URL
        $qrUrl = OrderHelper::generateQRUrl($price->price, $trackingCode);
        $bankInfo = OrderHelper::getBankInfo();

        // Check if user is logged in
        $userBalance = 0;
        if (Auth::check()) {
            $userBalance = Auth::user()->balance ?? 0;
        }

        return view('checkout-payment', [
            'order' => $order,
            'price' => $price,
            'qrUrl' => $qrUrl,
            'bankInfo' => $bankInfo,
            'userBalance' => $userBalance,
            'isLoggedIn' => Auth::check(),
        ]);
    }

    /**
     * Check payment status (API endpoint)
     */
    public function checkPayment(Request $request)
    {
        $code = $request->input('code');
        
        if (!$code) {
            return response()->json(['error' => 'Missing code'], 400);
        }

        $order = Order::byCode($code)->first();
        
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        return response()->json([
            'paid' => $order->isPaid() || $order->status === 'completed',
            'status' => $order->status,
            'tracking_code' => $order->tracking_code,
        ]);
    }

    /**
     * Cancel order
     */
    public function cancelOrder(Request $request)
    {
        $code = $request->input('code');
        
        if (!$code) {
            return response()->json(['error' => 'Missing code'], 400);
        }

        $order = Order::byCode($code)->pending()->first();
        
        if (!$order) {
            return response()->json(['error' => 'Order not found or cannot be cancelled'], 404);
        }

        $order->markAsCancelled();

        return response()->json([
            'success' => true,
            'message' => 'Đơn hàng đã được hủy',
        ]);
    }

    /**
     * Pay order with user balance
     */
    public function payWithBalance(Request $request)
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'error' => 'Vui lòng đăng nhập để thanh toán bằng số dư',
            ], 401);
        }

        $request->validate([
            'code' => 'required|string',
        ]);

        $code = $request->input('code');
        $user = Auth::user();

        // Find pending order
        $order = Order::byCode($code)->pending()->first();
        
        if (!$order) {
            return response()->json([
                'success' => false,
                'error' => 'Đơn hàng không tồn tại hoặc đã được thanh toán',
            ], 404);
        }

        // Check balance
        if ($user->balance < $order->amount) {
            return response()->json([
                'success' => false,
                'error' => 'Số dư không đủ. Cần ' . number_format($order->amount, 0, ',', '.') . 'đ, bạn có ' . number_format($user->balance, 0, ',', '.') . 'đ',
                'balance' => $user->balance,
                'required' => $order->amount,
            ], 400);
        }

        // Deduct balance and mark order as paid
        try {
            \DB::beginTransaction();
            
            // Deduct user balance
            $user->balance = $user->balance - $order->amount;
            $user->save();
            
            // Update order
            $order->account_id = $user->id;
            $order->status = Order::STATUS_PAID;
            $order->paid_at = now();
            $order->save();
            
            \DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Thanh toán thành công!',
                'tracking_code' => $order->tracking_code,
                'new_balance' => $user->balance,
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => 'Có lỗi xảy ra, vui lòng thử lại',
            ], 500);
        }
    }

    /**
     * Show order success page
     */
    public function orderSuccess(Request $request)
    {
        $code = $request->input('code');
        
        if (!$code) {
            return redirect('/')->with('error', 'Mã đơn hàng không hợp lệ');
        }

        // Find paid order
        $order = Order::byCode($code)->first();
        
        if (!$order) {
            return redirect('/')->with('error', 'Đơn hàng không tồn tại');
        }

        // Get price info
        $price = $order->price;

        return view('order-success', [
            'order' => $order,
            'price' => $price,
        ]);
    }

    /**
     * Verify Google reCAPTCHA v3 token
     */
    private function verifyRecaptcha(string $response, string $action = null): array
    {
        $secretKey = config('services.recaptcha.secret_key', '');
        $threshold = config('services.recaptcha.score_threshold', 0.5);

        // If secret key not configured, skip verification
        if (empty($secretKey) || strpos($secretKey, 'xxx') !== false) {
            return ['success' => true, 'message' => '', 'score' => 1.0];
        }

        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret' => $secretKey,
            'response' => $response,
            'remoteip' => request()->ip(),
        ];

        try {
            $client = new \GuzzleHttp\Client(['timeout' => 10]);
            $result = $client->post($url, ['form_params' => $data]);
            $json = json_decode($result->getBody(), true);

            $score = (float)($json['score'] ?? 0);

            if (!empty($json['success'])) {
                // Check action if provided
                if ($action !== null && isset($json['action']) && $json['action'] !== $action) {
                    \Log::warning("reCAPTCHA action mismatch. Expected: $action, Got: " . $json['action']);
                    return ['success' => false, 'message' => 'Xác thực bảo mật thất bại.', 'score' => $score];
                }

                // Check score
                if ($score >= $threshold) {
                    return ['success' => true, 'message' => '', 'score' => $score];
                } else {
                    \Log::warning("reCAPTCHA low score: $score for IP: " . request()->ip());
                    return ['success' => false, 'message' => 'Phát hiện hoạt động đáng ngờ. Vui lòng thử lại.', 'score' => $score];
                }
            }

            return ['success' => false, 'message' => 'Xác thực bảo mật thất bại. Vui lòng tải lại trang.', 'score' => 0];
        } catch (\Exception $e) {
            // If verification fails, allow through to not block legitimate users
            \Log::error('reCAPTCHA verification error: ' . $e->getMessage());
            return ['success' => true, 'message' => '', 'score' => 1.0];
        }
    }
}

