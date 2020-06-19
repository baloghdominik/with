<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PizzadesignerTopping extends Model
{
    public $table = "pizzadesigner_topping";
    protected $fillable = [
        'sizeid', 'name', 'category', 'price', 'makeprice', 'maketime'
    ];

     /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'makeprice',
    ];
}