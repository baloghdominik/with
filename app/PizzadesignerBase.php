<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PizzadesignerBase extends Model
{
    public $table = "pizzadesigner_base";
    protected $fillable = [
        'sizeid', 'name', 'price', 'makeprice', 'maketime'
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