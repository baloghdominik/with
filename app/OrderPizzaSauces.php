<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderPizzaSauces extends Model
{
    public $table = "order_pizza_sauces";
    protected $fillable = [
        'order_pizza_id', 
        'pizzadesigner_sauce_id',
        'price'
    ];

    public function sauce(){
        return $this->hasOne('App\PizzadesignerSauce','id','pizzadesigner_sauce_id');
    }

    public function orderpizza(){
        return $this->belongsTo('App\OrderPizza','order_pizza_id','id');
    }
}