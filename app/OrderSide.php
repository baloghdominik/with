<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderSide extends Model
{
    public $table = "order_side";
    protected $fillable = [
        'order_id', 
        'side_id', 
        'quantity', 
        'price'
    ];
}