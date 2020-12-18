<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RestaurantDTO extends Model
{
    protected $fillable = [
        'restaurantid',
        'restaurantname',
        'lowercasename',
        'restaurantaddress',
        'mapembed',
        'restaurantphone',
        'restaurantemail',
        'restaurantfacebook',
        'facebookembed',
        'restaurantdescription',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',
        'isdeliveryavailable',
        'ispickupavailable',
        'minimumordervalue',
        'deliveryprice',
        'potentialdeliverytime',
        'iscash',
        'isbankcard'.
        'isonlinepayment',
        'isszepcard',
        'isrestaurantopenfororders',
        'ispizzadesigneravailable',
        'istablereservationavailable',
        'logo',
        'banner',
        'img1',
        'img2',
        'img3',
        'img4',
        'img5',
        'img6'
    ];

    public function zipcodes(){
        return $this->hasMany('App\RestaurantZipcode','restaurantid','id');
    }

    public function categories(){
        return $this->hasMany('App\RestaurantZipcode','restaurantid','id');
    }
}
