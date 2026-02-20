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
    ];

    protected $casts = [
        'total_deliveries' => 'integer',
        'total_delivery_fee' => 'decimal:2',
        'total_remit' => 'decimal:2',
        'total_tips' => 'decimal:2',
        'total_collection' => 'decimal:2',
    ];

    public function rider()
    {
        return $this->belongsTo(Rider::class);
    }
}
