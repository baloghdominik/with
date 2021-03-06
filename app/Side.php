<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Side extends Model
{
    public $table = "side";
    protected $fillable = [
        'name', 'price', 'saleprice', 'makeprice'
    ];

     /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'makeprice',
    ];
}
