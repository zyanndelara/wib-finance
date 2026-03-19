<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NonRemittingLog extends Model
{
    protected $fillable = [
        'rider_id',
        'rider_name',
        'log_date',
    ];

    protected $casts = [
        'log_date' => 'date',
    ];

    public function rider()
    {
        return $this->belongsTo(Rider::class, 'rider_id', 'driver_id');
    }
}
