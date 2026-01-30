<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $table = 'prices';
    
    protected $fillable = [
        'type',
        'hours',
        'price',
        'original_price',
        'discount_percent',
        'promo_label',
        'promo_badge',
    ];
    
    protected $casts = [
        'hours' => 'integer',
        'price' => 'integer',
        'original_price' => 'integer',
        'discount_percent' => 'integer',
    ];
    
    /**
     * Get packages by service type
     */
    public static function getByType(string $type)
    {
        return self::where('type', $type)
            ->orderBy('hours', 'asc')
            ->get();
    }
    
    /**
     * Get minimum price package for a service type
     */
    public static function getMinPackage(string $type)
    {
        return self::where('type', $type)
            ->orderBy('price', 'asc')
            ->first();
    }
    
    /**
     * Get maximum discount percent for a service type
     */
    public static function getMaxDiscount(string $type): int
    {
        return (int) self::where('type', $type)
            ->max('discount_percent') ?? 0;
    }
    
    /**
     * Convert hours to human readable label
     */
    public function getHoursLabelAttribute(): string
    {
        $h = $this->hours;
        if ($h < 24) return $h . ' giờ';
        if ($h % 24 === 0) {
            return ($h / 24) . ' ngày';
        }
        return $h . ' giờ';
    }
    
    /**
     * Check if package has discount
     */
    public function getHasDiscountAttribute(): bool
    {
        return $this->original_price > $this->price;
    }
}
