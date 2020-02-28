<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SideToMenu extends Model
{
    public $table = "side_to_menu";
    protected $fillable = [
        'menuid', 
        'sideid'
    ];
}
