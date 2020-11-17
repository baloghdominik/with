<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DrinkToMenu extends Model
{
    public $table = "drink_to_menu";
    protected $fillable = [
        'menuid', 
        'drinkid'
    ];

    public function menu(){
        return $this->belongsTo('App\Menu','menuid','id');
    }

    public function drink(){
        return $this->hasOne('App\Drink','id','drinkid');
    }
}
