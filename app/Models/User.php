<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'employee_id',
        'email',
        'phone_number',
        'password',
        'role',
        'status',
        'last_seen_at',
        'two_factor_secret',
        'two_factor_enabled',
        'two_factor_confirmed_at',
        'two_factor_trusted_devices',
        'accessible_pages',
    ];

    public const ACCESSIBLE_PAGES = [
        'dashboard' => 'Dashboard',
        'financial-requests' => 'Financial Requests',
        'remittance' => 'Remittance',
        'bank-deposit' => 'Bank & Deposit',
        'merchants' => 'Merchants',
        'members' => 'Member Management',
        'audit-logs' => 'Audit Logs',
        'profile' => 'Profile',
    ];

    public const DEFAULT_ADMIN_PAGES = [
        'dashboard',
        'financial-requests',
        'remittance',
        'bank-deposit',
        'merchants',
        'members',
        'audit-logs',
        'profile',
    ];

    public const DEFAULT_MEMBER_PAGES = [
        'dashboard',
        'remittance',
        'bank-deposit',
        'merchants',
        'profile',
    ];

    /**
     * Returns true if the user was seen in the last 5 minutes.
     */
    public function isOnline(): bool
    {
        return $this->last_seen_at && $this->last_seen_at->gt(now()->subMinutes(5));
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public static function pageRouteMap(): array
    {
        return [
            'dashboard' => 'dashboard',
            'financial-requests' => 'financial-requests.index',
            'remittance' => 'remittance',
            'bank-deposit' => 'bank-deposit',
            'merchants' => 'merchants',
            'members' => 'members.index',
            'audit-logs' => 'audit-logs',
            'profile' => 'profile',
        ];
    }

    public function resolvedAccessiblePages(): array
    {
        if ($this->isAdmin()) {
            return self::DEFAULT_ADMIN_PAGES;
        }

        $pages = is_array($this->accessible_pages) ? $this->accessible_pages : null;

        if (empty($pages)) {
            return self::DEFAULT_MEMBER_PAGES;
        }

        return array_values(array_intersect($pages, array_keys(self::ACCESSIBLE_PAGES)));
    }

    public function hasPageAccess(string $pageKey): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        return in_array($pageKey, $this->resolvedAccessiblePages(), true);
    }

    public function firstAccessibleRouteName(): string
    {
        $routeMap = self::pageRouteMap();

        foreach ($this->resolvedAccessiblePages() as $pageKey) {
            if (isset($routeMap[$pageKey])) {
                return $routeMap[$pageKey];
            }
        }

        return 'profile';
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at'           => 'datetime',
            'last_seen_at'                => 'datetime',
            'password'                    => 'hashed',
            'two_factor_enabled'          => 'boolean',
            'two_factor_confirmed_at'     => 'datetime',
            'two_factor_trusted_devices'  => 'array',
            'accessible_pages'            => 'array',
        ];
    }
}
