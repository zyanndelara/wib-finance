<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rider extends Model
{
    use HasFactory;

    protected $connection = 'wheninba_MercifulGod';
    protected $table = 'mt_driver';
    protected $primaryKey = 'driver_id';
    public $incrementing = false;
    protected $keyType = 'int';

    const CREATED_AT = 'date_created';
    const UPDATED_AT = 'date_modified';

    protected $fillable = [
        'driver_id',
        'user_type',
        'user_id',
        'on_duty',
        'first_name',
        'last_name',
        'email',
        'phone',
        'username',
        'password',
        'team_id',
        'transport_type_id',
        'transport_description',
        'licence_plate',
        'color',
        'status',
        'date_created',
        'date_modified',
        'last_login',
        'last_online',
        'location_lat',
        'location_lng',
        'ip_address',
        'forgot_pass_code',
        'token',
        'device_platform',
        'enabled_push',
        'profile_photo',
        'is_signup',
        'app_version',
        'last_onduty',
    ];

    protected $appends = [
        'id',
        'name',
    ];

    public function getIdAttribute()
    {
        return $this->driver_id;
    }

    public function getNameAttribute()
    {
        $fullName = trim((string) ($this->first_name . ' ' . $this->last_name));

        return $fullName !== '' ? $fullName : ('Driver #' . $this->driver_id);
    }

    public function setNameAttribute($value)
    {
        $value = trim((string) $value);
        if ($value === '') {
            $this->attributes['first_name'] = '';
            $this->attributes['last_name'] = '';
            return;
        }

        $parts = preg_split('/\s+/', $value, 2);
        $this->attributes['first_name'] = $parts[0] ?? '';
        $this->attributes['last_name'] = $parts[1] ?? '';
    }

    public function remittances()
    {
        return $this->hasMany(Remittance::class, 'rider_id', 'driver_id');
    }
}
