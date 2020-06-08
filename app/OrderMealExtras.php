<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderMealExtras extends Model
{
    public $table = "order_meal_extras";
    protected $fillable = [
        'order_meal_id', 
        'extra_id', 
        'price'
    ];
}