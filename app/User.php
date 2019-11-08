<?php

namespace App;

use App\Enums\Role;
use App\Enums\TicketStatus;
use App\Traits\Userstamps;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles, Notifiable, SoftDeletes, Userstamps;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'password',
        'company_name',
        'company_phone',
        'company_contact_name',
        'employee_code',
        'stripe_id',
        'card_brand',
        'card_last_four',
        'last_login'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login' => 'datetime',
    ];

    /**
     * Get the user's display name.
     *
     * @return string
     */
    public function getDisplayNameAttribute()
    {
        $first_name = explode(' ', $this->first_name);
        $last_name = explode(' ', $this->last_name);

        return "{$first_name[0]} {$last_name[0]}";
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the user's avatar url.
     *
     * @return string
     */
    public function getAvatarAttribute()
    {
        //TODO: Implement Avatar user when managing Profile
        return asset('img/app/avatar.png');
    }

    /**
     * Get the user's is active flag.
     *
     * @return string
     */
    public function getIsActiveAttribute()
    {
        return !$this->trashed();
    }

    /**
     * Get the subscriptions for the user.
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, $this->getForeignKey())->orderBy('created_at', 'desc');
    }

    /**
     * Get the addresses for the user.
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Get the Fancy number for the user
     */
    public function fancy_number()
    {
        return $this->hasOne(FancyNumber::class);
    }

    /**
     * Get the user's ticket.
     */
    public function tickets()
    {
        return $this->hasManyThrough(Ticket::class, FancyNumber::class);
    }

    /**
     * Get the user's ticket.
     */
    public function fancy_setting()
    {
        return $this->hasOneThrough(FancySetting::class, FancyNumber::class);
    }

    /**
     * Generate random encrypted password.
     *
     * @return string
     */
    public static function generatePassword()
    {
        return bcrypt(Str::random(35));
    }

    /**
     * Get count grouped by roles, except Admins
     *
     * @return mixed
     */
    public static function countByRole()
    {
        return static::selectRaw('roles.name as role, count(users.id) as count')
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->whereNull('users.deleted_at')
            ->where('model_has_roles.model_type', 'App\\User')
            ->where('roles.guard_name', 'web')
            ->where('roles.name', '<>', Role::ADMIN)
            ->groupBy('roles.id')
            ->get();
    }

    /**
     * @param int $addonId
     * @return bool
     */
    public function hasBoughtAddon(int $addonId)
    {
        if (is_null($addonId)) {
            return false;
        }

        return Invoice::where('user_id', $this->id)->where('addon_id', $addonId)->count('id') > 0;
    }

    public function hasTicketInProgress()
    {
        return $this->tickets->isNotEmpty() && $this->tickets->where('status', TicketStatus::IN_PROGRESS)->count() > 0;
    }
}
