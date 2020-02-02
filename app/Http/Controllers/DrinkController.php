<?php

namespace App\Http\Controllers;

use File;
use Image;
use App\Side;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DrinkController extends Controller
{

    // Add - Meal
    public function addDrink(){
        $pageConfigs = [
            'pageHeader' => false
        ];

        return view('/pages/add-drink', [
            'pageConfigs' => $pageConfigs
        ]);
    }

}