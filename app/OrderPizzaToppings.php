<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderPizzaToppings extends Model
{
    public $table = "order_pizza_toppings";
    protected $fillable = [
        'order_pizza_id', 
        'pizzadesigner_topping_id',
        'name',
        'price'
    ];

    public function topping(){
        return $this->hasOne('App\PizzadesignerTopping','id','pizzadesigner_topping_id');
    }

    public function orderpizza(){
        return $this->belongsTo('App\OrderPizza','order_pizza_id','id');
    }
}