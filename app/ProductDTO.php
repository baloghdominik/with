<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductDTO extends Model
{
    protected $fillable = [
        'type', 
        'id', 
        'name', 
        'image', 
        'is_sale', 
        'price', 
        'old_price', 
        'category_id',
        'category_name',

        'description', 
        'calories', 
        'is_vegan', 
        'is_vegetarian', 
        'is_glutenfree', 
        'is_lactosefree', 
        'is_fatfree', 
        'is_sugarfree', 
        'is_allergenicfree', 
        'is_alcoholfree',
        'size',
        'extralimit',
    ];

    public function extras(){
        return $this->hasMany('App\ProductExtrasDTO','productid','id');
    }

    public function sides(){
        return $this->hasMany('App\ProductSidesDTO','productid','id');
    }

    public function drinks(){
        return $this->hasMany('App\ProductDrinksDTO','productid','id');
    }
}