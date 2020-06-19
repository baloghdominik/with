<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDrink extends Model
{
    public $table = "order_drink";
    protected $fillable = [
        'order_id', 
        'drink_id', 
        'quantity', 
        'price'
    ];

    public function order(){
        return $this->belongsTo('App\Order','order_id','id');
    }

    public function drink(){
        return $this->hasOne('App\Drink','id','drink_id');
    }
}