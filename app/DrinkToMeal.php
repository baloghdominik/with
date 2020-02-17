<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DrinkToMeal extends Model
{
    public $table = "drink_to_meal";
    protected $fillable = [
        'mealid', 
        'drinkid'
    ];
}
