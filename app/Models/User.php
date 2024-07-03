<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasFactory, Notifiable, HasApiTokens, Authenticatable;

    protected $fillable = [
        "name",
        "username",
        "email",
        "password"
    ];

    public function feeds(): HasMany {
        return $this->hasMany(Feed::class);
    }
}
