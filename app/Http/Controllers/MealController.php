<?php

namespace App\Http\Controllers;

use File;
use Image;
use App\Side;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MealController extends Controller
{

    // Add - Meal
    public function addMeal(){
        $pageConfigs = [
            'pageHeader' => false
        ];

        return view('/pages/add-meal', [
            'pageConfigs' => $pageConfigs
        ]);
    }

}