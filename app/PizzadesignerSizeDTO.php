<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PizzadesignerSizeDTO extends Model
{
    protected $fillable = [
        'id',
        'size', 
        'price',
        'maxtoppings',
        'illustration',
        'bases', 
        'toppings', 
        'sauces', 
        'doughs'
    ];
}