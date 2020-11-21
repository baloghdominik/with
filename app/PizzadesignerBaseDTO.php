<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PizzadesignerBaseDTO extends Model
{
    protected $fillable = [
        'id', 
        'illustration',
        'name',
        'price',
    ];
}