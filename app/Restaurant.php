<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    public $table = "restaurant";
    protected $fillable = [
        'name', 'lowercasename', 'address', 'phone', 'email', 'facebook', 'description'
    ];

    public function zipcodes(){
        return $this->hasMany('App\RestaurantZipcode','restaurantid','id');
    }

    public function categories(){
        return $this->hasMany('App\Category','restaurantid','id');
    }
}
