<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 'coupons';
    
    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'max_discount_amount',
        'is_active',
        'expires_at',
    ];
    
    protected $casts = [
        'discount_value' => 'integer',
        'max_discount_amount' => 'integer',
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
    ];
    
    /**
     * Get active coupons
     */
    public static function getActive()
    {
        return self::where('is_active', 1)
            ->where(function($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>=', now());
            })
            ->get();
    }
    
    /**
     * Calculate discount for a given price
     */
    public function calculateDiscount(int $price): int
    {
        if ($this->discount_type === 'percent') {
            $discount = (int) floor($price * $this->discount_value / 100);
            if ($this->max_discount_amount > 0) {
                $discount = min($discount, $this->max_discount_amount);
            }
        } else {
            $discount = $this->discount_value;
        }
        
        return min($discount, $price);
    }
    
    /**
     * Get best coupon saving for a price
     */
    public static function getBestSaving(int $price): int
    {
        $maxSaving = 0;
        
        foreach (self::getActive() as $coupon) {
            $saving = $coupon->calculateDiscount($price);
            if ($saving > $maxSaving) {
                $maxSaving = $saving;
            }
        }
        
        return $maxSaving;
    }
}
