<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zipcode extends Model
{
    public $table = "zipcodes";
    protected $fillable = [
        'city', 'zipcode'
    ];

    public $timestamps = false;
}
