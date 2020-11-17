<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductExtrasDTO extends Model
{
    protected $fillable = [
        'product_id',
        'id', 
        'name', 
        'price',
    ];

    public function product(){
        return $this->belongsTo('App\ProductDTO','product_id','id');
    }
}