<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'orders';

    /**
     * Indicates if the model should be timestamped.
     * Legacy table uses created_at only.
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'tracking_code',
        'account_id',
        'price_id',
        'coupon_id',
        'service_type',
        'hours',
        'amount',
        'discount_amount',
        'points_used',
        'status',
        'ip_address',
        'customer_email',
        'notes',
        'created_at',
        'paid_at',
        'expires_at',
        'completed_at',
        // ADY columns
        'ady_order_id',
        'ady_product_id',
        'ady_product_uuid',
        'ady_order_uuid',
        'ady_fields',
        'ady_status',
        'ady_result',
        'ady_error',
        'ady_amount_usd',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'amount' => 'integer',
        'hours' => 'integer',
        'created_at' => 'datetime',
        'paid_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Order statuses
     */
    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * Get the price associated with the order.
     */
    public function price(): BelongsTo
    {
        return $this->belongsTo(Price::class);
    }
    
    /**
     * Get the user who placed the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the coupon used for this order.
     */
    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Scope: Pending orders
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope: Paid orders
     */
    public function scopePaid($query)
    {
        return $query->where('status', self::STATUS_PAID);
    }

    /**
     * Scope: By tracking code
     */
    public function scopeByCode($query, string $code)
    {
        return $query->where('tracking_code', $code);
    }

    /**
     * Check if order is pending
     */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if order is paid
     */
    public function isPaid(): bool
    {
        return $this->status === self::STATUS_PAID;
    }

    /**
     * Mark order as paid
     */
    public function markAsPaid(): bool
    {
        $this->status = self::STATUS_PAID;
        $this->paid_at = now();
        return $this->save();
    }

    /**
     * Mark order as cancelled
     */
    public function markAsCancelled(): bool
    {
        $this->status = self::STATUS_CANCELLED;
        return $this->save();
    }

    /**
     * Get formatted amount in VND
     */
    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->amount, 0, ',', '.') . 'đ';
    }
}
