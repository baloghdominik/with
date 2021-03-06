<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $table = "category";
    protected $fillable = [
        'category', 'restaurantid'
    ];

    public function restaurant(){
        return $this->belongsTo('App\Restaurant','restaurantid','id');
    }
}