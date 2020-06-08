<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderPizzaSauces extends Model
{
    public $table = "order_pizza_sauces";
    protected $fillable = [
        'order_pizza_id', 
        'pizzadesigner_sauce_id',
        'price'
    ];
}