<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "description",
        "price",
        "popular",
        "category_id",
        "oz"
    ];

    protected $casts = [
        "oz" => "array",
        "popular" => "boolean",
        "price" => "float",
        
    ];

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }

    public function orderItems() : HasMany {
        return $this->hasMany(OrderItem::class);
    }

    public function carts() : HasMany {
        return $this->hasMany(Cart::class);
    }
}
