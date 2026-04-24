<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiderDeduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'rider_id',
        'rider_name',
        'payroll_id',
        'amount',
        'date',
        'remarks',
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];
}
