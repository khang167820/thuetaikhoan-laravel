<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    /**
     * Display the coupons page
     */
    public function index()
    {
        // Get active coupons from database
        $coupons = DB::table('coupons')
            ->where('is_active', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.coupons', compact('coupons'));
    }
    
    /**
     * Get all active coupons (API)
     */
    public function getActiveCoupons(): JsonResponse
    {
        $coupons = Coupon::getActive()
            ->map(function ($coupon) {
                return [
                    'id' => $coupon->id,
                    'code' => $coupon->code,
                    'discount_type' => $coupon->discount_type,
                    'discount_value' => $coupon->discount_value,
                    'max_discount_amount' => $coupon->max_discount_amount,
                    'description' => $this->getDescription($coupon),
                    'limit_text' => $coupon->max_discount_amount > 0 
                        ? 'Tối đa ' . number_format($coupon->max_discount_amount, 0, ',', '.') . 'đ'
                        : 'Không giới hạn',
                ];
            });
        
        return response()->json([
            'success' => true,
            'coupons' => $coupons,
        ]);
    }
    
    /**
     * Validate a coupon code (API)
     */
    public function validateCoupon(Request $request): JsonResponse
    {
        $code = strtoupper(trim($request->input('code', '')));
        $price = (int) $request->input('price', 0);
        
        if (empty($code)) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng nhập mã giảm giá.',
            ], 400);
        }
        
        $coupon = Coupon::where('code', $code)
            ->where('is_active', 1)
            ->where(function($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>=', now());
            })
            ->first();
        
        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn.',
            ], 404);
        }
        
        $discount = $price > 0 ? $coupon->calculateDiscount($price) : 0;
        
        return response()->json([
            'success' => true,
            'coupon' => [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'discount_type' => $coupon->discount_type,
                'discount_value' => $coupon->discount_value,
                'description' => $this->getDescription($coupon),
            ],
            'discount_amount' => $discount,
            'final_price' => max(0, $price - $discount),
            'message' => 'Mã giảm giá hợp lệ!',
        ]);
    }
    
    /**
     * Get coupon description for display
     */
    private function getDescription(Coupon $coupon): string
    {
        if ($coupon->discount_type === 'percent') {
            return 'Giảm ' . $coupon->discount_value . '%';
        } else {
            return 'Giảm ' . number_format($coupon->discount_value, 0, ',', '.') . 'đ';
        }
    }
}

