<?php

namespace App\Http\Controllers;

use App\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{

    // List - Menu
    public function listCategory(){
        $pageConfigs = [
            'pageHeader' => false
        ];

        $restaurantID = Auth::user()->restaurantid;

        $categories = DB::table('category')
            ->where('restaurantid', '=', $restaurantID)
            ->get();
        if ($categories === null) {
            return redirect('/');
        }

        return view('/pages/category-settings', [
            'pageConfigs' => $pageConfigs, 'categories' => $categories
        ]);
    }

    //delete category from db
    public function deleteCategory(Request $request)
    {

        $validatedData = request()->validate([
            'id' => ['required', 'integer', 'min:0'],
        ]);

        $id = request('id');
        $restaurantID = Auth::user()->restaurantid;

        $count = DB::table('meal')
            ->where('restaurantid', '=', $restaurantID)
            ->where('category', '=', $id)
            ->count();
        if ($count > 0) {
            return redirect()->action('CategoryController@listCategory')
            ->with('fail','Nem sikerült törölni a kategóriát, mert az adott kategória használatban van valamennyi feltöltött ételénél. A törléshez kérjük előbb változtassa meg az ételek kategóriáját.');
        }

        DB::table('category')
            ->where('restaurantid', '=', $restaurantID)
            ->where('id', '=', $id)
            ->delete();
   
        return back()
            ->with('success','A kategória sikeresen el lett távolítva az étterem menüpontjai közül!');
    }

    //save new category to db
    public function addCategory(Request $request)
    {

        $validatedData = request()->validate([
            'category' => ['required', 'string', 'min:3', 'max:20'],
        ]);

        $restaurantID = Auth::user()->restaurantid;

        $count = DB::table('category')
            ->where('restaurantid', '=', $restaurantID)
            ->count();
        if ($count > 15) {
            return redirect()->action('CategoryController@listCategory')
            ->with('fail','Maximum 15 kategóriát lehet létrehozni! Új kategória létrehozásához kérjük töröljön a meglévők közül.');
        }

        $category = new Category;
        $category->category = request('category');
        $category->restaurantid = $restaurantID;
        $category->save();
   
        return back()
            ->with('success','A kategória sikeresen hozzá lett adva az étteremhez egy új menüpontként!');
    }

}