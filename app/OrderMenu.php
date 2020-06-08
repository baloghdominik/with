<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderMenu extends Model
{
    public $table = "order_menu";
    protected $fillable = [
        'order_id', 
        'menu_id', 
        'side_id', 
        'drink_id', 
        'quantity', 
        'price'
    ];
}