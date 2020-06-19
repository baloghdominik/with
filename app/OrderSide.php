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

    public function order(){
        return $this->belongsTo('App\Order','order_id','id');
    }

    public function side(){
        return $this->hasOne('App\Side','id','side_id');
    }
}