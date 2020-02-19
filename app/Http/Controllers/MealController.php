<?php

namespace App\Http\Controllers;

use File;
use Image;
use App\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MealController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Add - Meal
    public function addMeal(){
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

        return view('/pages/add-meal', [
            'pageConfigs' => $pageConfigs, 'categories' => $categories
        ]);
    }

    // Edit - Meal
    public function editMeal($id){
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

        $meal = DB::table('meal')
            ->where('restaurantid', '=', $restaurantID)
            ->where('id', '=', $id)
            ->first();
        if ($meal === null) {
            return redirect('/');
        }
        $day = date('w', strtotime(date("Y-m-d")));

        return view('/pages/edit-meal', [
            'pageConfigs' => $pageConfigs, 'id' => $id, 'meal' => $meal, 'categories' => $categories, 'day' => $day
        ]);
    }

    //update meal in db
    public function updateMeal(Request $request, $id)
    {

         $validatedData = request()->validate([
            'image' => ['image'],
            'picid' => ['required', 'string'],
            'name' => ['required', 'string','min:3'],
            'category' => ['required', 'integer','min:0'],
            'price' => ['required', 'integer', 'gte:saleprice', 'gte:makeprice', 'min:0', 'max:100000'],
            'saleprice' => ['required', 'integer', 'lte:price', 'gte:makeprice', 'min:0','max:100000'],
            'sale' => ['boolean'],
            'makeprice' => ['required', 'integer', 'lte:saleprice', 'min:0', 'max:100000'],
            'maketime' => ['required', 'integer', 'min:0','max:120'],
            'monday' => ['boolean'],
            'tuesday' => ['boolean'],
            'wednesday' => ['boolean'],
            'thirsday' => ['boolean'],
            'friday' => ['boolean'],
            'saturday' => ['boolean'],
            'sunday' => ['boolean'],
            'description' => ['required', 'string', 'min:0', 'max:500'],
            'vegan' => ['boolean'],
            'vegetarian' => ['boolean'],
            'glutenfree' => ['boolean'],
            'lactosefree' => ['boolean'],
            'fatfree' => ['boolean'],
            'sugarfree' => ['boolean'],
            'allergenicfree' => ['boolean'],
            'calorie' => ['required', 'string'],
            'available_separately' => ['boolean'],
            'available' => ['boolean'],
        ]);

        $restaurantID = Auth::user()->restaurantid;

        $meal = DB::table('meal')
            ->where('restaurantid', '=', $restaurantID)
            ->where('id', '=', $id)
            ->first();
        if ($meal === null) {
            return redirect('/');
        }

        $meal = Meal::where('id', $id)->where('restaurantid', '=', $restaurantID)->first();
        $meal->name = request('name');
        $meal->category = request('category');
        $meal->picid = request('picid');
        $meal->price = request('price');
        $meal->saleprice = request('saleprice');
        $meal->sale = $request->has('sale');
        $meal->makeprice = request('makeprice');
        $meal->maketime = request('maketime');
        $meal->monday = $request->has('monday');
        $meal->tuesday = $request->has('tuesday');
        $meal->wednesday = $request->has('wednesday');
        $meal->thirsday = $request->has('thirsday');
        $meal->friday = $request->has('friday');
        $meal->saturday = $request->has('saturday');
        $meal->sunday = $request->has('sunday');
        $meal->description = request('description');
        $meal->vegan = $request->has('vegan');
        $meal->vegetarian = $request->has('vegetarian');
        $meal->glutenfree = $request->has('glutenfree');
        $meal->lactosefree = $request->has('lactosefree');
        $meal->fatfree = $request->has('fatfree');
        $meal->sugarfree = $request->has('sugarfree');
        $meal->allergenicfree = $request->has('allergenicfree');
        $meal->calorie = request('calorie');
        $meal->available_separately = $request->has('available_separately');
        $meal->available = $request->has('available');
        $meal->save();

        if ($request->hasFile('image')) {
            $picID = request('picid');
            $this->validate($request, [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            ]);
    
            $image = $request->file('image');
            $input['imagename'] = ''.$picID.'.'.$image->extension();
            $filename = $picID.'.jpg';

            $destinationPath = public_path('images/meals');

            if(File::exists($destinationPath.'/'.$filename)) {
                File::delete($destinationPath.'/'.$filename);  // or unlink($filename);
            }
            $img = Image::make($image->path())->encode('jpg', 80)->save($destinationPath.'/'.$filename);

            $img = Image::make('images/meals/'.$picID.'.jpg')->resize(1080, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$filename);

            $img = Image::make('images/meals/'.$filename)->crop(1080, 720)->save($destinationPath.'/'.$filename);
        }
   
        return redirect()->action('MealController@editMeal', ['id' => $id])
            ->with('success','Az étel sikeresen frissítve lett az étlapon!');
    }

    // List - Meal
    public function listMeal(){
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

        $meal = DB::table('meal')->where('restaurantid', $restaurantID)->get();

        $day = date('w', strtotime(date("Y-m-d")));

        return view('/pages/list-meal', [
            'pageConfigs' => $pageConfigs, 'meal' => $meal, 'categories' => $categories, 'day' => $day
        ]);
    }

    //save new meal to db
    public function insertMeal(Request $request)
    {

         $validatedData = request()->validate([
            'image' => ['required','image'],
            'name' => ['required', 'string','min:3'],
            'category' => ['required', 'integer','min:0'],
            'price' => ['required', 'integer', 'gte:saleprice', 'gte:makeprice', 'min:0', 'max:100000'],
            'saleprice' => ['required', 'integer', 'lte:price', 'gte:makeprice', 'min:0','max:100000'],
            'sale' => ['boolean'],
            'makeprice' => ['required', 'integer', 'lte:saleprice', 'min:0', 'max:100000'],
            'maketime' => ['required', 'integer', 'min:0','max:120'],
            'monday' => ['boolean'],
            'tuesday' => ['boolean'],
            'wednesday' => ['boolean'],
            'thirsday' => ['boolean'],
            'friday' => ['boolean'],
            'saturday' => ['boolean'],
            'sunday' => ['boolean'],
            'description' => ['required', 'string', 'min:0', 'max:500'],
            'vegan' => ['boolean'],
            'vegetarian' => ['boolean'],
            'glutenfree' => ['boolean'],
            'lactosefree' => ['boolean'],
            'fatfree' => ['boolean'],
            'sugarfree' => ['boolean'],
            'allergenicfree' => ['boolean'],
            'calorie' => ['required', 'string'],
            'available_separately' => ['boolean'],
            'available' => ['boolean'],
        ]);

        $restaurantID = Auth::user()->restaurantid;
        
        $count = DB::table('meal')->count();
        if ($count == 0) {
            $mealID = 0;
        } else {
            $mealDB = DB::table('meal')->select('id')->latest('created_at')->first();
            $mealID = $mealDB->id;
        }
        $mealID++;
        $picID = 'with.hu_r'.$restaurantID.'_s'.$mealID;
        $picID = 'with.hu_'.md5($picID);

        $meal = new Meal;
        $meal->name = request('name');
        $meal->category = request('category');
        $meal->picid = $picID;
        $meal->restaurantid = $restaurantID;
        $meal->price = request('price');
        $meal->saleprice = request('saleprice');
        $meal->sale = $request->has('sale');
        $meal->makeprice = request('makeprice');
        $meal->maketime = request('maketime');
        $meal->monday = $request->has('monday');
        $meal->tuesday = $request->has('tuesday');
        $meal->wednesday = $request->has('wednesday');
        $meal->thirsday = $request->has('thirsday');
        $meal->friday = $request->has('friday');
        $meal->saturday = $request->has('saturday');
        $meal->sunday = $request->has('sunday');
        $meal->description = request('description');
        $meal->vegan = $request->has('vegan');
        $meal->vegetarian = $request->has('vegetarian');
        $meal->glutenfree = $request->has('glutenfree');
        $meal->lactosefree = $request->has('lactosefree');
        $meal->fatfree = $request->has('fatfree');
        $meal->sugarfree = $request->has('sugarfree');
        $meal->allergenicfree = $request->has('allergenicfree');
        $meal->calorie = request('calorie');
        $meal->available_separately = $request->has('available_separately');
        $meal->available = $request->has('available');
        $meal->save();

        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);
  
        $image = $request->file('image');
        $input['imagename'] = ''.$picID.'.'.$image->extension();
        $filename = $picID.'.jpg';

        $destinationPath = public_path('images/meals');

        if(File::exists($destinationPath.'/'.$filename)) {
            File::delete($destinationPath.'/'.$filename);  // or unlink($filename);
        }
        $img = Image::make($image->path())->encode('jpg', 80)->save($destinationPath.'/'.$filename);

        $img = Image::make('images/meals/'.$picID.'.jpg')->resize(1080, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$filename);

        $img = Image::make('images/meals/'.$filename)->crop(1080, 720)->save($destinationPath.'/'.$filename);

   
        return back()
            ->with('success','Az étel sikeresen hozzá lett adva az étlaphoz!');
    }

    //delete meal from db
    public function deleteMeal(Request $request)
    {
        $validatedData = request()->validate([
            'id' => ['required', 'integer', 'min:0'],
            'verify' => ['boolean'],
        ]);

        $id = request('id');

        $verify = $request->has('verify');
        if (!$verify) {
            return redirect()->action('MealController@editMeal', ['id' => $id])
            ->with('fail','A termék végleges törléshez kérjük erősítse meg törlési szándékát a négyzet bepipálásával!');
        }

        $restaurantID = Auth::user()->restaurantid;

        $count = DB::table('meal')
            ->where('restaurantid', '=', $restaurantID)
            ->where('id', '=', $id)
            ->count();
        if ($count !== 1) {
            return redirect()->action('MealController@editMeal', ['id' => $id])
            ->with('fail','A keresett étel nem található!');
        }

        DB::table('meal')
            ->where('restaurantid', '=', $restaurantID)
            ->where('id', '=', $id)
            ->delete();

        DB::table('side_to_meal')
            ->where('mealid', '=', $id)
            ->delete();

        DB::table('drink_to_meal')
            ->where('mealid', '=', $id)
            ->delete();
   
        return redirect()->action('MealController@listMeal')
            ->with('success','Az étel sikeresen el lett távolítva az étlapról!');
    }

}