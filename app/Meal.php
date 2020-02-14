<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    public $table = "meal";
    protected $fillable = [
        'name', 'price', 'saleprice', 'makeprice'
    ];
}
