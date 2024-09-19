<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        "username",
        "email",
        "password",
        "mobile_number",
        "is_admin",
    ];

    protected $casts = [
        "is_admin" => "boolean",
    ];


    public function orders() : HasMany {
        return $this->hasMany(Order::class);
    }

    public function transactions() : HasMany {
        return $this->hasMany(Transaction::class);
    }

    public function carts() : HasMany {
        return $this->hasMany(Cart::class);
    }
}
