<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PizzadesignerTopping extends Model
{
    public $table = "pizzadesigner_topping";
    protected $fillable = [
        'sizeid', 'name', 'category', 'price', 'makeprice', 'maketime'
    ];
}