<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SideToMeal extends Model
{
    public $table = "side_to_meal";
    protected $fillable = [
        'mealid', 
        'sideid'
    ];
}
