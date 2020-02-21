<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    public $table = "restaurant";
    protected $fillable = [
        'name', 'lowercasename', 'address', 'phone', 'email', 'facebook', 'description'
    ];
}
