<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'restaurantid',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setRoles($role)
    {
        $this->setAttribute('role', $role);
        return $this;
    }

    public function getRole()
    {
        $role = $this->getAttribute('role');

        return $role;
    }

    public function hasRoles($role)
    {
        $currentRole = $this->getRoles();
            if ($role != $currentRole) {
                return false;
            }
        return true;
    }

    public function getUserRestaurantID()
    {
        $restaurantID = $this->getAttribute('restaurantid');

        return $restaurantID;
    }
}
