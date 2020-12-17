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
        'is_paid',
        'is_done',
        'done_at',
        'is_delivered',
        'delivered_at',
        'is_out_for_delivery',
        'out_for_delivery_at',
        'is_finished',
        'finished_at',
        'is_cancelled',
        'is_refund',
        'is_refiund_finished',
        'pickuptime'.
        'identifier',
        'customer_firstname',
        'customer_lastname',
        'customer_phone_number',
        'customer_email',
        'customer_country',
        'customer_city',
        'customer_zipcode',
        'customer_address',
        'customer_ip_address',
        'paying_method'
    ];

     /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'margin'
    ];

    public function ordermeal(){
        return $this->hasMany('App\OrderMeal','order_id','id');
    }

    public function orderdrink(){
        return $this->hasMany('App\OrderDrink','order_id','id');
    }

    public function orderside(){
        return $this->hasMany('App\OrderSide','order_id','id');
    }

    public function ordermenu(){
        return $this->hasMany('App\OrderMenu','order_id','id');
    }

    public function orderpizza(){
        return $this->hasMany('App\OrderPizza','order_id','id');
    }

    public function customer(){
        return $this->hasOne('App\Customer','id','customer_id');
    }

    public function invoice(){
        return $this->hasOne('App\OrderInvoice','order_id','id');
    }
}