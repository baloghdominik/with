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
        'price'
    ];
}