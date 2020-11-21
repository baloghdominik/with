<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PizzadesignerToppingDTO extends Model
{
    protected $fillable = [
        'id', 
        'illustration',
        'name',
        'price',
    ];
}