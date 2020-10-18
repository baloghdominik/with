<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RestaurantListDTO extends Model
{
    protected $fillable = [
        'name', 'logo', 'banner', 'lowercasename', 'isopen', 'description', 'deliveryoptions', 'deliverytime', 'deliveryprice', 'minordervalue'
    ];
}
