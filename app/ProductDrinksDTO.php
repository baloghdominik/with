<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductDrinksDTO extends Model
{
    protected $fillable = [
        'product_id',
        'id', 
        'image', 
        'name', 
        'price',
    ];

    public function product(){
        return $this->belongsTo('App\ProductDTO','product_id','id');
    }
}