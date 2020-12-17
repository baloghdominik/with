<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderMenu extends Model
{
    public $table = "order_menu";
    protected $fillable = [
        'order_id', 
        'menu_id', 
        'side_id', 
        'drink_id', 
        'name',
        'quantity', 
        'price'
    ];

    public function side(){
        return $this->hasOne('App\Side','id','side_id');
    }

    public function drink(){
        return $this->hasOne('App\Drink','id','drink_id');
    }

    public function meal(){
        return $this->hasOne('App\Meal','id','meal_id');
    }

    public function menu(){
        return $this->hasOne('App\Menu','id','menu_id');
    }

    public function ordermenuextras(){
        return $this->hasMany('App\OrderMenuExtras','order_menu_id','id');
    }

    public function order(){
        return $this->belongsTo('App\Order','order_id','id');
    }
}