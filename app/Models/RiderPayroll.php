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
        'renumeration_26_days',
        'adda_df',
        'adda_df_date',
        'adda_df_entries',
        'salary_schedule',
        'mode_of_payment',
        'net_salary',
    ];
}
