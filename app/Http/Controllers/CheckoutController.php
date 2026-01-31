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
        // Get price_id from request
        $priceId = $request->input('price_id');
        
        if (!$priceId) {
            return redirect('/')->with('error', 'Vui lòng chọn gói dịch vụ');
        }

        // Get price from database
        $price = Price::find($priceId);
        
        if (!$price) {
            return redirect('/')->with('error', 'Gói dịch vụ không tồn tại');
        }

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
}

