<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PizzadesignerSauceDTO extends Model
{
    protected $fillable = [
        'id', 
        'illustration',
        'name',
        'price',
    ];
}