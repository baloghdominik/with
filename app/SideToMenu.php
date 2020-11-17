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

    public function menu(){
        return $this->belongsTo('App\Menu','menuid','id');
    }

    public function side(){
        return $this->hasOne('App\Side','id','sideid');
    }
}
