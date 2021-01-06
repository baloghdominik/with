<?php
namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Customer extends Authenticatable
{
  use HasApiTokens, Notifiable;
/**
* The attributes that are mass assignable.
*
* @var array
*/
public $table = "customer";
protected $fillable = [
    'firstname', 'lastname', 'country', 'city', 'zipcode', 'address', 'email', 'password',
];
/**
* The attributes that should be hidden for arrays.
*
* @var array
*/
protected $hidden = [
    'password', 'remember_token',
];

public function setPassword($password) {
    $this->setAttribute('password', $password);
    return $this;
}

public function AauthAcessToken(){
    return $this->hasMany('\App\OauthAccessToken');
}

public function orders(){
    return $this->hasMany('App\Order','customer_id','id');
}
}