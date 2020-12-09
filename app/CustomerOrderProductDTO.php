<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerOrderProductDTO extends Model
{
    protected $fillable = [
        'product_name', 
        'product_description',
        'product_quantity'
    ];
}
