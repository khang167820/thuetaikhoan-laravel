<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'accounts';
    
    // Disable timestamps since accounts table doesn't have created_at/updated_at columns
    public $timestamps = false;
    
    protected $fillable = [
        'type',
        'username',
        'password',
        'is_available',
        'expires_at',
    ];
    
    protected $casts = [
        'is_available' => 'boolean',
        'expires_at' => 'datetime',
    ];
    
    /**
     * Get available accounts count by type (excludes accounts with notes)
     */
    public static function countAvailable(string $type): int
    {
        return self::where('type', $type)
            ->where('is_available', 1)
            ->where(function ($q) {
                $q->whereNull('note')->orWhere('note', '');
            })
            ->count();
    }
    
    /**
     * Get available accounts by type (excludes accounts with notes)
     */
    public static function getAvailable(string $type)
    {
        return self::where('type', $type)
            ->where('is_available', 1)
            ->where(function ($q) {
                $q->whereNull('note')->orWhere('note', '');
            })
            ->orderBy('available_since', 'asc')
            ->get();
    }
    
    /**
     * Check if any account is available for a type (excludes accounts with notes)
     */
    public static function hasAvailable(string $type): bool
    {
        return self::countAvailable($type) > 0;
    }
}
