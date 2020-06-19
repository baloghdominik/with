<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PizzadesignerSize extends Model
{
    public $table = "pizzadesigner_size";
    protected $fillable = [
        'size', 'price', 'makeprice', 'maketime', 'toppingslimit'
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