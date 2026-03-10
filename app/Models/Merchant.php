<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'category',
        'address',
        'commission_rate',
        'commission_type',
        'commission_food_amount',
        'commission_drinks_amount',
        'commission_small_amount',
        'commission_big_amount',
        'commission_mixed_percentage',
        'commission_mixed_amount',
        'commission_items',
        'status',
        'total_orders',
        'total_sales',
        'total_commission',
    ];

    protected $casts = [
        'commission_rate'  => 'float',
        'commission_items' => 'array',
    ];
}
