<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
    public $table = "extra";
    protected $fillable = [
        'name', 
        'price', 
        'makeprice', 
        'restaurantid', 
        'mealid'
    ];
}
