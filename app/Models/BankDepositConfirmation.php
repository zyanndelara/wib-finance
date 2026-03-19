<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankDepositConfirmation extends Model
{
    protected $fillable = [
        'rider_id',
        'confirmed_by',
        'deposit_date',
        'bank_amount',
        'denom_1000',
        'denom_500',
        'denom_200',
        'denom_100',
        'denom_50',
        'denom_20',
        'denom_20b',
        'denom_10',
        'denom_5',
        'denom_1',
        'total_amount',
        'discrepancy',
    ];

    protected $casts = [
        'deposit_date' => 'date',
        'bank_amount'  => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function rider(): BelongsTo
    {
        return $this->belongsTo(Rider::class, 'rider_id', 'driver_id');
    }

    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }
}
