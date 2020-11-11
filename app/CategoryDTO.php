<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryDTO extends Model
{
    protected $fillable = [
        'category', 'restaurantid'
    ];

    public function restaurant(){
        return $this->belongsTo('App\RestaurantDTO','restaurantid','id');
    }
}