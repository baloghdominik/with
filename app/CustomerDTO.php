<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerDTO extends Model
{
    public $table = "meal";
    protected $fillable = [
        'firstname', 
        'lastname',
        'email',
        'is_email_verified',  
        'phone', 
        'country', 
        'city', 
        'zipcode', 
        'address'
    ];
}
