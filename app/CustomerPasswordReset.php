<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerPasswordReset extends Model
{
    public $table = "customer_password_reset";
    protected $fillable = [
        'email', 
        'token',
        'created_at'
    ];

    public $timestamps = false;
}