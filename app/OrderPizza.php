<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderPizza extends Model
{
    public $table = "order_pizza";
    protected $fillable = [
        'order_id', 
        'pizzadesigner_base_id', 
        'pizzadesigner_dough_id', 
        'pizzadesigner_size_id', 
        'quantity', 
        'price'
    ];
}