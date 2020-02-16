<?php

namespace App\Http\Controllers;

use File;
use Image;
use App\Drink;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class DrinkController extends Controller
{

    // Add - Drink
    public function addDrink(){
        $pageConfigs = [
            'pageHeader' => false
        ];

        return view('/pages/add-drink', [
            'pageConfigs' => $pageConfigs
        ]);
    }

    // Edit - Drink
    public function editDrink($id){
        $pageConfigs = [
            'pageHeader' => false
        ];

        $restaurantID = Auth::user()->restaurantid;
        $drink = DB::table('drink')
            ->where('restaurantid', '=', $restaurantID)
            ->where('id', '=', $id)
            ->first();
        if ($drink === null) {
            return redirect('/');
        }
        $day = date('w', strtotime(date("Y-m-d")));

        return view('/pages/edit-drink', [
            'pageConfigs' => $pageConfigs, 'id' => $id, 'drink' => $drink, 'day' => $day
        ]);
    }

    //update drink in db
    public function updateDrink(Request $request, $id)
    {

         $validatedData = request()->validate([
            'image' => ['image'],
            'picid' => ['required', 'string'],
            'name' => ['required', 'string','min:3'],
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
            'size' => ['required', 'integer', 'min:0', 'max:5000'],
            'vegan' => ['boolean'],
            'lactosefree' => ['boolean'],
            'sugarfree' => ['boolean'],
            'alcoholfree' => ['boolean'],
            'calorie' => ['required', 'string'],
            'available_separately' => ['boolean'],
            'available' => ['boolean'],
        ]);

        $restaurantID = Auth::user()->restaurantid;
        $drink = DB::table('drink')
            ->where('restaurantid', '=', $restaurantID)
            ->where('id', '=', $id)
            ->first();
        if ($drink === null) {
            return redirect('/');
        }

        $drink = Drink::where('id', $id)->where('restaurantid', '=', $restaurantID)->first();
        $drink->name = request('name');
        $drink->picid = request('picid');
        $drink->price = request('price');
        $drink->saleprice = request('saleprice');
        $drink->sale = $request->has('sale');
        $drink->makeprice = request('makeprice');
        $drink->maketime = request('maketime');
        $drink->monday = $request->has('monday');
        $drink->tuesday = $request->has('tuesday');
        $drink->wednesday = $request->has('wednesday');
        $drink->thirsday = $request->has('thirsday');
        $drink->friday = $request->has('friday');
        $drink->saturday = $request->has('saturday');
        $drink->sunday = $request->has('sunday');
        $drink->size = request('size');
        $drink->vegan = $request->has('vegan');
        $drink->lactosefree = $request->has('lactosefree');
        $drink->alcoholfree = $request->has('alcoholfree');
        $drink->sugarfree = $request->has('sugarfree');
        $drink->calorie = request('calorie');
        $drink->available_separately = $request->has('available_separately');
        $drink->available = $request->has('available');
        $drink->save();

        if ($request->hasFile('image')) {
            $picID = request('picid');
            $this->validate($request, [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            ]);
    
            $image = $request->file('image');
            $input['imagename'] = ''.$picID.'.'.$image->extension();
            $filename = $picID.'.jpg';

            $destinationPath = public_path('images/drinks');

            if(File::exists($destinationPath.'/'.$filename)) {
                File::delete($destinationPath.'/'.$filename);  // or unlink($filename);
            }
            $img = Image::make($image->path())->encode('jpg', 80)->save($destinationPath.'/'.$filename);

            $img = Image::make('images/drinks/'.$picID.'.jpg')->resize(1080, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$filename);

            $img = Image::make('images/drinks/'.$filename)->crop(1080, 720)->save($destinationPath.'/'.$filename);
        }
   
        return redirect()->action('DrinkController@editDrink', ['id' => $id])
            ->with('success','Az ital sikeresen frissítve lett az étlapon!');
    }

    // List - Drink
    public function listDrink(){
        $pageConfigs = [
            'pageHeader' => false
        ];

        $restaurantID = Auth::user()->restaurantid;
        $drink = DB::table('drink')->where('restaurantid', $restaurantID)->get();
        $day = date('w', strtotime(date("Y-m-d")));

        return view('/pages/list-drink', [
            'pageConfigs' => $pageConfigs, 'drink' => $drink, 'day' => $day
        ]);
    }

    //save new drink to db
    public function insertDrink(Request $request)
    {

         $validatedData = request()->validate([
            'image' => ['required','image'],
            'name' => ['required', 'string','min:3'],
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
            'size' => ['required', 'integer', 'min:0', 'max:5000'],
            'vegan' => ['boolean'],
            'alcoholfree' => ['boolean'],
            'lactosefree' => ['boolean'],
            'sugarfree' => ['boolean'],
            'calorie' => ['required', 'string'],
            'available_separately' => ['boolean'],
            'available' => ['boolean'],
        ]);


        $restaurantID = Auth::user()->restaurantid;
        
        
        $count = DB::table('drink')->count();
        if ($count == 0) {
            $drinkID = 0;
        } else {
            $drinkDB = DB::table('drink')->select('id')->latest('created_at')->first();
            $drinkID = $drinkDB->id;
        }
        $drinkID++;
        $picID = 'with.hu_r'.$restaurantID.'_s'.$drinkID;
        $picID = 'with.hu_'.md5($picID);

        $drink = new Drink;
        $drink->name = request('name');
        $drink->picid = $picID;
        $drink->restaurantid = $restaurantID;
        $drink->price = request('price');
        $drink->saleprice = request('saleprice');
        $drink->sale = $request->has('sale');
        $drink->makeprice = request('makeprice');
        $drink->maketime = request('maketime');
        $drink->monday = $request->has('monday');
        $drink->tuesday = $request->has('tuesday');
        $drink->wednesday = $request->has('wednesday');
        $drink->thirsday = $request->has('thirsday');
        $drink->friday = $request->has('friday');
        $drink->saturday = $request->has('saturday');
        $drink->sunday = $request->has('sunday');
        $drink->size = request('size');
        $drink->vegan = $request->has('vegan');
        $drink->alcoholfree = $request->has('alcoholfree');
        $drink->lactosefree = $request->has('lactosefree');
        $drink->sugarfree = $request->has('sugarfree');
        $drink->calorie = request('calorie');
        $drink->available_separately = $request->has('available_separately');
        $drink->available = $request->has('available');
        $drink->save();

        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);
  
        $image = $request->file('image');
        $input['imagename'] = ''.$picID.'.'.$image->extension();
        $filename = $picID.'.jpg';

        $destinationPath = public_path('images/drinks');

        if(File::exists($destinationPath.'/'.$filename)) {
            File::delete($destinationPath.'/'.$filename);  // or unlink($filename);
        }
        $img = Image::make($image->path())->encode('jpg', 80)->save($destinationPath.'/'.$filename);

        $img = Image::make('images/drinks/'.$picID.'.jpg')->resize(1080, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$filename);

        $img = Image::make('images/drinks/'.$filename)->crop(1080, 720)->save($destinationPath.'/'.$filename);

   
        return back()
            ->with('success','Az ital sikeresen hozzá lett adva az étlaphoz!');
    }

}