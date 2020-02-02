<?php

namespace App\Http\Controllers;

use File;
use Image;
use App\Side;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SideController extends Controller
{

    // Add - Side
    public function addSide(){
        $pageConfigs = [
            'pageHeader' => false
        ];

        return view('/pages/add-side', [
            'pageConfigs' => $pageConfigs
        ]);
    }

    //save new side to db
    public function insertSide(Request $request)
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
            'description' => ['required', 'string', 'min:0', 'max:500'],
            'vegan' => ['boolean'],
            'vegetarian' => ['boolean'],
            'glutenfree' => ['boolean'],
            'lactosefree' => ['boolean'],
            'fatfree' => ['boolean'],
            'sugarfree' => ['boolean'],
            'allergenicfree' => ['boolean'],
            'calorie' => ['required', 'string']
        ]);

        $restaurantID = 0;
        
        $count = DB::table('side')->count();
        if ($count == 0) {
            $sideID = 0;
        } else {
            $sideDB = DB::table('side')->select('id')->latest('created_at')->first();
            $sideID = $sideDB->id;
        }
        $sideID++;
        $picID = 'with.hu_r'.$restaurantID.'_s'.$sideID;
        $picID = 'with.hu_'.md5($picID);

        $side = new Side;
        $side->name = request('name');
        $side->picid = $picID;
        $side->restaurantid = $restaurantID;
        $side->price = request('price');
        $side->saleprice = request('saleprice');
        $side->sale = $request->has('sale');
        $side->makeprice = request('makeprice');
        $side->maketime = request('maketime');
        $side->monday = $request->has('monday');
        $side->tuesday = $request->has('tuesday');
        $side->wednesday = $request->has('wednesday');
        $side->thirsday = $request->has('thirsday');
        $side->friday = $request->has('friday');
        $side->saturday = $request->has('saturday');
        $side->sunday = $request->has('sunday');
        $side->description = request('description');
        $side->vegan = $request->has('vegan');
        $side->vegetarian = $request->has('vegetarian');
        $side->glutenfree = $request->has('glutenfree');
        $side->lactosefree = $request->has('lactosefree');
        $side->fatfree = $request->has('fatfree');
        $side->sugarfree = $request->has('sugarfree');
        $side->allergenicfree = $request->has('allergenicfree');
        $side->calorie = request('calorie');
        $side->save();

        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);
  
        $image = $request->file('image');
        $input['imagename'] = ''.$picID.'.'.$image->extension();
        $filename = $picID.'.jpg';

        $destinationPath = public_path('images/sides');

        if(File::exists($destinationPath.'/'.$filename)) {
            File::delete($destinationPath.'/'.$filename);  // or unlink($filename);
        }
        $img = Image::make($image->path())->encode('jpg', 80)->save($destinationPath.'/'.$filename);

        $img = Image::make('images/sides/'.$picID.'.jpg')->resize(1080, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$filename);

        $img = Image::make('images/sides/'.$filename)->crop(1080, 720)->save($destinationPath.'/'.$filename);

   
        return back()
            ->with('success','A köret sikeresen hozzá lett adva az étlaphoz!');
    }

}