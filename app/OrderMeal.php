<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderMeal extends Model
{
    public $table = "order_meal";
    protected $fillable = [
        'order_id', 
        'meal_id', 
        'quantity', 
        'name',
        'price'
    ];

    public function order(){
        return $this->belongsTo('App\Order','order_id','id');
    }

    public function ordermealextras(){
        return $this->hasMany('App\OrderMealExtras','order_meal_id','id');
    }

    public function meal(){
        return $this->hasOne('App\Meal','id','meal_id');
    }
}