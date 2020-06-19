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

    public function ordermenu(){
        return $this->belongsTo('App\OrderMenu','order_menu_id','id');
    }

    public function extra(){
        return $this->hasOne('App\Extra','id','extra_id');
    }
}