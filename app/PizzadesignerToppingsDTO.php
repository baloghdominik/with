<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PizzadesignerToppingsDTO extends Model
{
    protected $fillable = [
        'meats', 
        'cheeses', 
        'vegetables', 
        'fruits', 
        'others'
    ];
}