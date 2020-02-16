<?php

namespace App\Http\Controllers;

use Image;
use App\Meal;
use App\Side;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{

    // List - Menu
    public function listMenu(){
        $pageConfigs = [
            'pageHeader' => false
        ];

        return view('/pages/menu-settings', [
            'pageConfigs' => $pageConfigs
        ]);
    }

    // Edit - Category
    public function editCategory(){
        $pageConfigs = [
            'pageHeader' => false
        ];

        return view('/pages/list-menu', [
            'pageConfigs' => $pageConfigs
        ]);
    }

    // Edit - Menu
    public function editMenu($id){
        $pageConfigs = [
            'pageHeader' => false
        ];

        $restaurantID = Auth::user()->restaurantid;
        $meal = DB::table('meal')
            ->where('restaurantid', '=', $restaurantID)
            ->where('id', '=', $id)
            ->first();
        if ($meal === null) {
            return redirect('/');
        }
        
        $side = DB::table('side')->where('restaurantid', $restaurantID)->get();

        $day = date('w', strtotime(date("Y-m-d")));

        return view('/pages/edit-menu', [
            'pageConfigs' => $pageConfigs, 'id' => $id, 'meal' => $meal, 'side' => $side, 'day' => $day
        ]);
    }

}