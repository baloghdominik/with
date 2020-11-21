<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PizzadesignerDoughDTO extends Model
{
    protected $fillable = [
        'id', 
        'name',
        'price',
    ];
}