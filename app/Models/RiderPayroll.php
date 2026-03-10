<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiderPayroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'rider_id',
        'rider_name',
        'base_salary',
        'incentives',
        'salary_schedule',
        'mode_of_payment',
        'net_salary',
    ];
}
