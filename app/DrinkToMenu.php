<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DrinkToMenu extends Model
{
    public $table = "drink_to_menu";
    protected $fillable = [
        'menuid', 
        'sideid'
    ];
}
