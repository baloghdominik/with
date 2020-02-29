<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PizzadesignerDough extends Model
{
    public $table = "pizzadesigner_dough";
    protected $fillable = [
        'sizeid', 'name', 'price'
    ];
}