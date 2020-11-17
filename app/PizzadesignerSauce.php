<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PizzadesignerSauce extends Model
{
    public $table = "pizzadesigner_sauce";
    protected $fillable = [
        'sizeid', 'name', 'price', 'makeprice', 'maketime', 'art'
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