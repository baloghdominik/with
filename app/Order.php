<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $table = "order";
    protected $fillable = [
        'customer_id', 
        'restaurant_id', 
        'is_delivery', 
        'delivery_price', 
        'coupon', 
        'coupon_sale', 
        'is_online_payment',
        'total_price',
        'is_paid'
    ];
}