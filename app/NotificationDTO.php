<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationDTO extends Model
{
    protected $fillable = [
        'reservation', 
        'order'
    ];
}