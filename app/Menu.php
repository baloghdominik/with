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

    public function meal(){
        return $this->hasOne('App\Meal','id','mealid');
    }

    public function sides(){
        return $this->hasMany('App\SideToMenu','menuid','id');
    }

    public function drinks(){
        return $this->hasMany('App\DrinkToMenu','menuid','id');
    }
}
