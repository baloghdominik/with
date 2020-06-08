<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDrink extends Model
{
    public $table = "order_drink";
    protected $fillable = [
        'order_id', 
        'drink_id', 
        'quantity', 
        'price'
    ];
}