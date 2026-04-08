<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use HasFactory;

    protected $connection = 'wibfinance';
    protected $table = 'mt_merchant';
    protected $primaryKey = 'merchant_id';
    public $incrementing = true;
    protected $keyType = 'int';
    const CREATED_AT = 'date_created';
    const UPDATED_AT = 'date_modified';

    protected $fillable = [
        'merchant_id',
        'restaurant_name',
        'merchant_type',
        'partner_type',
        'street',
        'city',
        'state',
        'commision_type',
        'percent_commision',
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

    public function getIdAttribute()
    {
        return $this->merchant_id;
    }

    public function getNameAttribute()
    {
        return $this->restaurant_name;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['restaurant_name'] = $value;
    }

    public function getTypeAttribute()
    {
        return $this->attributes['partner_type'] ?? null;
    }

    public function setTypeAttribute($value)
    {
        $this->attributes['partner_type'] = $value;
    }

    public function getAddressAttribute()
    {
        $parts = array_filter([$this->street, $this->city, $this->state], fn ($part) => filled($part));

        return empty($parts) ? null : implode(', ', $parts);
    }

    public function setAddressAttribute($value)
    {
        $this->attributes['street'] = $value;
    }

    public function getCommissionTypeAttribute()
    {
        return $this->commision_type;
    }

    public function setCommissionTypeAttribute($value)
    {
        $this->attributes['commision_type'] = $value;
    }

    public function getCommissionRateAttribute()
    {
        return $this->percent_commision;
    }

    public function setCommissionRateAttribute($value)
    {
        $this->attributes['percent_commision'] = $value;
    }

    public function getTotalOrdersAttribute()
    {
        return $this->attributes['total_orders'] ?? 0;
    }

    public function getTotalSalesAttribute()
    {
        return $this->attributes['total_sales'] ?? 0;
    }

    public function getTotalCommissionAttribute()
    {
        return $this->attributes['total_commission'] ?? 0;
    }

    public function getCreatedAtAttribute()
    {
        $value = $this->getAttributeValue(self::CREATED_AT);

        return $value ? $this->asDateTime($value) : null;
    }

    public function getUpdatedAtAttribute()
    {
        $value = $this->getAttributeValue(self::UPDATED_AT);

        return $value ? $this->asDateTime($value) : null;
    }

    public function getTypeColumn(): string
    {
        return 'partner_type';
    }

    public function getNameColumn(): string
    {
        return 'restaurant_name';
    }
}
