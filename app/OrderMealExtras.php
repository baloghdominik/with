<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderMealExtras extends Model
{
    public $table = "order_meal_extras";
    protected $fillable = [
        'order_meal_id', 
        'extra_id', 
        'name',
        'price'
    ];

    public function ordermeal(){
        return $this->belongsTo('App\OrderMeal','order_meal_id','id');
    }

    public function extra(){
        return $this->hasOne('App\Extra','id','extra_id');
    }
}