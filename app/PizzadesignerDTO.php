<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PizzadesignerDTO extends Model
{
    protected $fillable = [
        'available', 
        'sizes', 
    ];
}