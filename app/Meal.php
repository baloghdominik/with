<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    public $table = "meal";
    protected $fillable = [
        'name', 
        'picid',
        'price', 
        'saleprice', 
        'sale', 
        'makeprice', 
        'maketime', 
        'monday', 
        'tuesday', 
        'wednesday', 
        'thirsday', 
        'friday', 
        'saturday', 
        'sunday',
        'description',
        'vegan', 
        'vegetarian', 
        'glutenfree', 
        'lactosefree', 
        'fatfree', 
        'sugarfree', 
        'allergenicfree', 
        'calorie', 
        'available_separately', 
        'available'
    ];

     /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'makeprice',
    ];

    public function extras(){
        return $this->hasMany('App\Extra','mealid','id');
    }

    public function menu(){
        return $this->belongsTo('App\Menu','menuid','id');
    }
}
