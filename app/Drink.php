<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drink extends Model
{
    public $table = "drink";
    protected $fillable = [
        'name', 
        'picid',
        'price', 
        'saleprice', 
        'sale', 
        'makeprice', 
        'maketime', 
        'monday', 
        'tuesday', 
        'wednesday', 
        'thirsday', 
        'friday', 
        'saturday', 
        'sunday',
        'size',
        'description',
        'vegan', 
        'lactosefree',
        'sugarfree', 
        'alcoholfree', 
        'allergenicfree', 
        'calorie', 
        'available_separately', 
        'available'
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