<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    public $table = "reservation";
    protected $fillable = [
        'restaurantid', 
        'customerid', 
        'person', 
        'date', 
        'time', 
        'comment', 
        'confirmed'
    ];
}