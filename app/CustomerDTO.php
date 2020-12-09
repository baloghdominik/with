<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerDTO extends Model
{
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
