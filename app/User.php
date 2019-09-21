<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
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
     * Generate random encrypted password. 
     *
     * @return void
     */
    public static function generatePassword()
    {
        return bcrypt(str_random(35));
    }
}
