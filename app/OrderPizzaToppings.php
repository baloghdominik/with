<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderPizzaToppings extends Model
{
    public $table = "order_pizza_toppings";
    protected $fillable = [
        'order_pizza_id', 
        'pizzadesigner_topping_id',
        'price'
    ];
}