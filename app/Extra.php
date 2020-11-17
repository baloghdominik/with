<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
    public $table = "extra";
    protected $fillable = [
        'name', 
        'price', 
        'makeprice', 
        'restaurantid', 
        'mealid'
    ];

     /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'makeprice',
    ];

    public function meal(){
        return $this->belongsTo('App\Extra','mealid','id');
    }
}
