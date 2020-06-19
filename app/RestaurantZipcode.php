<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RestaurantZipcode extends Model
{
    public $table = "restaurant_zipcodes";
    protected $fillable = [
        'restaurantid', 'zipcode'
    ];

    public $timestamps = false;
}
