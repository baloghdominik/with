<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public $table = "menu";
    protected $fillable = [
        'mealid', 
        'restaurantid', 
        'picid', 
        'name',
        'menusalepercent', 
        'category', 
        'enable'
    ];
}
