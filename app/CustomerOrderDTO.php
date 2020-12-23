<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerOrderDTO extends Model
{
    protected $fillable = [
        'restaurant_name', 
        'restaurant_id',
        'identifier', 
        'ordered_at', 
        'finished_at', 
        'status', 
        'coupon',
        'coupon_sale',
        'total_price',
        'payment_type',
        'delivery_type',
        'delivery_time',
        'delivery_address',
        'customer_phone',
        'customer_name',
        'comment',
        'invoice',
        'products'
    ];
}
