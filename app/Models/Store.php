<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "address",
        "phone",
        "email",
        "website",
        "description",
        "image",
        "status",
        "lat",
        "lng",
        "opening_hours",
        "closing_hours",
        "open_24_hours",
    ];

    protected $casts = [
        "open_24_hours" => "boolean",
    ];
}
