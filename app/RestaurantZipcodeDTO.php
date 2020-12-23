<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RestaurantZipcodeDTO extends Model
{
    protected $fillable = [
        'restaurantid', 'zipcode', 'city',
    ];

    public function restaurant(){
        return $this->belongsTo('App\RestaurantDTO','restaurantid','id');
    }
}