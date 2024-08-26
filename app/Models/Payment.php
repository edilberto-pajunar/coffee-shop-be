<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        "order_id",
        "user_id",
        "amount",
        "currency",
        "payment_method",
        "status",
        "transaction_id",
        "payment_date",
    ];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function order() : BelongsTo {
        return $this->belongsTo(Order::class);
    }
}
