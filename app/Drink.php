<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drink extends Model
{
    public $table = "drink";
    protected $fillable = [
        'name', 'price', 'saleprice', 'makeprice'
    ];
}