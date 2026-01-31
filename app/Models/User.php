<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     * Dùng chung bảng với legacy PHP site.
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     * Tương thích với schema legacy.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'password_hash',
        'fullname',
        'phone',
        'balance',
        'role',
        'is_active',
        'last_login',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login' => 'datetime',
            'balance' => 'decimal:0',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the password for authentication.
     * Legacy dùng 'password_hash' thay vì 'password'.
     */
    public function getAuthPassword(): string
    {
        return $this->password_hash;
    }

    /**
     * Set password với hashing.
     */
    public function setPasswordAttribute($value): void
    {
        // Ghi vào cả password (Laravel default) và password_hash (legacy)
        $hashed = bcrypt($value);
        $this->attributes['password'] = $hashed;
        $this->attributes['password_hash'] = $hashed;
    }
}
