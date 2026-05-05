<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remittance extends Model
{
    use HasFactory;

    protected $fillable = [
        'rider_id',
        'total_deliveries',
        'total_delivery_fee',
        'total_remit',
        'total_tips',
        'total_collection',
        'grand_total_base',
        'cash_amount',
        'gcash_amount',
        'mode_of_payment',
        'payment_modes_json',
        'payment_breakdown_json',
        'remit_photo',
        'status',
        'remarks',
        'remarks_amount',
        'remittance_date',
        'mangan_merchant_name',
        'mangan_total_deliveries',
        'mangan_total_amount',
        'mangan_df',
        'mangan_gt',
        'mangan_tips',
        'mangan_receipt_non_partners',
    ];

    protected $casts = [
        'total_deliveries' => 'integer',
        'total_delivery_fee' => 'decimal:2',
        'total_remit' => 'decimal:2',
        'total_tips' => 'decimal:2',
        'total_collection' => 'decimal:2',
        'grand_total_base' => 'decimal:2',
        'cash_amount' => 'decimal:2',
        'gcash_amount' => 'decimal:2',
        'remarks_amount' => 'decimal:2',
        'remittance_date' => 'date',
    ];

    public function rider()
    {
        return $this->belongsTo(Rider::class, 'rider_id', 'driver_id');
    }
}
