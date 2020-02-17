<?php

namespace App\Http\Controllers;

use Image;
use App\Meal;
use App\Side;
use App\Drink;
use App\SideToMeal;
use App\DrinkToMeal;
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

        $menusides = DB::table('side_to_meal')
            ->where('mealid', '=', $id)
            ->get();
        if ($meal === null) {
            return redirect('/');
        }

        $menudrinks = DB::table('drink_to_meal')
            ->where('mealid', '=', $id)
            ->get();
        if ($meal === null) {
            return redirect('/');
        }
        
        $side = DB::table('side')->where('restaurantid', $restaurantID)->get();

        $drink = DB::table('drink')->where('restaurantid', $restaurantID)->get();

        $day = date('w', strtotime(date("Y-m-d")));

        return view('/pages/edit-menu', [
            'pageConfigs' => $pageConfigs, 
            'id' => $id, 'meal' => $meal, 
            'side' => $side, 
            'drink' => $drink, 
            'menusides' => $menusides, 
            'menudrinks' => $menudrinks, 
            'day' => $day
        ]);
    }

    //save add side to meal in db
    public function addSideToMeal(Request $request)
    {
        $validatedData = request()->validate([
            'mealid' => ['required', 'integer', 'min:0'],
            'sideid' => ['required', 'integer', 'min:0'],
        ]);

        $restaurantID = Auth::user()->restaurantid;

        $mealID = request('mealid');
        $sideID = request('sideid');
        
        $count = DB::table('meal')
            ->where('restaurantid', '=', $restaurantID)
            ->where('id', '=', $mealID)
            ->count();
        if ($count !== 1) {
            return redirect()->action('MenuController@editMenu', ['id' => $mealID])
            ->with('fail','Érvénytelen kérés! (E-0011)');
        }

        $count = DB::table('side')
            ->where('restaurantid', '=', $restaurantID)
            ->where('id', '=', $sideID)
            ->count();
        if ($count !== 1) {
            return redirect()->action('MenuController@editMenu', ['id' => $mealID])
            ->with('fail','Érvénytelen kérés! (E-0012)');
        }

        $count = DB::table('side_to_meal')
            ->where('mealid', '=', $mealID)
            ->where('sideid', '=', $sideID)
            ->count();
        if ($count !== 0) {
            return redirect()->action('MenuController@editMenu', ['id' => $mealID])
            ->with('fail','Ez a tétel már szerepel a menün! (E-0013)');
        }

        $sideToMeal = new SideToMeal;
        $sideToMeal->mealid = request('mealid');
        $sideToMeal->sideid = request('sideid');
        $sideToMeal->save();

   
        return redirect()->action('MenuController@editMenu', ['id' => $mealID])
            ->with('success','A köret sikeresen hozzá lett adva a menühöz!');
    }

    //save remove side from meal in db
    public function removeSideFromMeal(Request $request)
    {
        $validatedData = request()->validate([
            'mealid' => ['required', 'integer', 'min:0'],
            'sideid' => ['required', 'integer', 'min:0'],
        ]);

        $restaurantID = Auth::user()->restaurantid;

        $mealID = request('mealid');
        $sideID = request('sideid');
        
        $count = DB::table('meal')
            ->where('restaurantid', '=', $restaurantID)
            ->where('id', '=', $mealID)
            ->count();
        if ($count !== 1) {
            return redirect()->action('MenuController@editMenu', ['id' => $mealID])
            ->with('fail','Érvénytelen kérés! (E-0011)');
        }

        $count = DB::table('side')
            ->where('restaurantid', '=', $restaurantID)
            ->where('id', '=', $sideID)
            ->count();
        if ($count !== 1) {
            return redirect()->action('MenuController@editMenu', ['id' => $mealID])
            ->with('fail','Érvénytelen kérés! (E-0012)');
        }

        $count = DB::table('side_to_meal')
            ->where('mealid', '=', $mealID)
            ->where('sideid', '=', $sideID)
            ->count();
        if ($count !== 1) {
            return redirect()->action('MenuController@editMenu', ['id' => $mealID])
            ->with('fail','Ez a tétel még nem szerepel a menün! (E-0013)');
        }

        DB::table('side_to_meal')
            ->where('mealid', '=', $mealID)
            ->where('sideid', '=', $sideID)
            ->delete();
   
        return redirect()->action('MenuController@editMenu', ['id' => $mealID])
            ->with('success','A köret sikeresen el lett távolítva a menüről!');
    }


    //save add drink to meal in db
    public function addDrinkToMeal(Request $request)
    {
        $validatedData = request()->validate([
            'mealid' => ['required', 'integer', 'min:0'],
            'drinkid' => ['required', 'integer', 'min:0'],
        ]);

        $restaurantID = Auth::user()->restaurantid;

        $mealID = request('mealid');
        $drinkID = request('drinkid');
        
        $count = DB::table('meal')
            ->where('restaurantid', '=', $restaurantID)
            ->where('id', '=', $mealID)
            ->count();
        if ($count !== 1) {
            return redirect()->action('MenuController@editMenu', ['id' => $mealID])
            ->with('fail','Érvénytelen kérés! (E-0011)');
        }

        $count = DB::table('drink')
            ->where('restaurantid', '=', $restaurantID)
            ->where('id', '=', $drinkID)
            ->count();
        if ($count !== 1) {
            return redirect()->action('MenuController@editMenu', ['id' => $mealID])
            ->with('fail','Érvénytelen kérés! (E-0012)');
        }

        $count = DB::table('drink_to_meal')
            ->where('mealid', '=', $mealID)
            ->where('drinkid', '=', $drinkID)
            ->count();
        if ($count !== 0) {
            return redirect()->action('MenuController@editMenu', ['id' => $mealID])
            ->with('fail','Ez a tétel már szerepel a menün! (E-0013)');
        }

        $drinkToMeal = new DrinkToMeal;
        $drinkToMeal->mealid = request('mealid');
        $drinkToMeal->drinkid = request('drinkid');
        $drinkToMeal->save();

   
        return redirect()->action('MenuController@editMenu', ['id' => $mealID])
            ->with('success','Az ital sikeresen hozzá lett adva a menühöz!');
    }

    //save remove drink from meal in db
    public function removeDrinkFromMeal(Request $request)
    {
        $validatedData = request()->validate([
            'mealid' => ['required', 'integer', 'min:0'],
            'drinkid' => ['required', 'integer', 'min:0'],
        ]);

        $restaurantID = Auth::user()->restaurantid;

        $mealID = request('mealid');
        $drinkID = request('drinkid');
        
        $count = DB::table('meal')
            ->where('restaurantid', '=', $restaurantID)
            ->where('id', '=', $mealID)
            ->count();
        if ($count !== 1) {
            return redirect()->action('MenuController@editMenu', ['id' => $mealID])
            ->with('fail','Érvénytelen kérés! (E-0011)');
        }

        $count = DB::table('drink')
            ->where('restaurantid', '=', $restaurantID)
            ->where('id', '=', $drinkID)
            ->count();
        if ($count !== 1) {
            return redirect()->action('MenuController@editMenu', ['id' => $mealID])
            ->with('fail','Érvénytelen kérés! (E-0012)');
        }

        $count = DB::table('drink_to_meal')
            ->where('mealid', '=', $mealID)
            ->where('drinkid', '=', $drinkID)
            ->count();
        if ($count !== 1) {
            return redirect()->action('MenuController@editMenu', ['id' => $mealID])
            ->with('fail','Ez a tétel még nem szerepel a menün! (E-0013)');
        }

        DB::table('drink_to_meal')
            ->where('mealid', '=', $mealID)
            ->where('drinkid', '=', $drinkID)
            ->delete();
   
        return redirect()->action('MenuController@editMenu', ['id' => $mealID])
            ->with('success','Az ital sikeresen el lett távolítva a menüről!');
    }

}