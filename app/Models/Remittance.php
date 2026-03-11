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
        'mode_of_payment',
        'remit_photo',
        'status',
        'remarks',
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
        'remittance_date' => 'date',
    ];

    public function rider()
    {
        return $this->belongsTo(Rider::class);
    }
}
