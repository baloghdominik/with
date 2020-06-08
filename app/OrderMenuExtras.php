<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderMenuExtras extends Model
{
    public $table = "order_menu_extras";
    protected $fillable = [
        'order_menu_id', 
        'extra_id', 
        'price'
    ];
}