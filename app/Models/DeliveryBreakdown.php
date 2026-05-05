<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryBreakdown extends Model
{
    protected $connection = 'wheninba_MercifulGod';
    
    protected $table = 'fm_delivery_breakdowns';

    protected $guarded = [];

    // Allow mass assignment for common sheet columns
    protected $fillable = [
        'remittance_id',
        'task_no',
        'task_number',
        'rider',
        'rider_id',
        'mop',
        'ref_no',
        'ref',
        'merchant',
        'merchant_id',
        'merchant_name',
        'total_amount',
        'df',
        'gt',
        'gt_grumpy_receipt',
        'tip',
        'receipt_non_partners',
        'total_remit',
        'cf',
        'estimate_sal',
        'estimate_sales_admin_fee',
        'cf_amount',
        'delivery_date',
        'remarks',
    ];
}
