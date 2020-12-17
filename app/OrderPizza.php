<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderPizza extends Model
{
    public $table = "order_pizza";
    protected $fillable = [
        'order_id', 
        'pizzadesigner_base_id', 
        'pizzadesigner_dough_id', 
        'pizzadesigner_size_id', 
        'name',
        'quantity', 
        'price'
    ];

    public function base(){
        return $this->hasOne('App\PizzadesignerBase','id','pizzadesigner_base_id');
    }

    public function dough(){
        return $this->hasOne('App\PizzadesignerDough','id','pizzadesigner_dough_id');
    }

    public function size(){
        return $this->hasOne('App\PizzadesignerSize','id','pizzadesigner_size_id');
    }

    public function sauces(){
        return $this->hasMany('App\OrderPizzaSauces','order_pizza_id','id');
    }

    public function toppings(){
        return $this->hasMany('App\OrderPizzaToppings','order_pizza_id','id');
    }

    public function order(){
        return $this->belongsTo('App\Order','order_id','id');
    }
}
