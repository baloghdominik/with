<?php

namespace App\Http\Controllers;

use File;
use Image;
use App\Side;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SideController extends Controller
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

    // Add - Side
    public function addSide(){
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

        return view('/pages/add-side', [
            'pageConfigs' => $pageConfigs, 'categories' => $categories
        ]);
    }

    // Edit - Side
    public function editSide($id){
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

        $side = DB::table('side')
            ->where('restaurantid', '=', $restaurantID)
            ->where('id', '=', $id)
            ->first();
        if ($side === null) {
            return redirect('/');
        }

        $day = date('w', strtotime(date("Y-m-d")));

        return view('/pages/edit-side', [
            'pageConfigs' => $pageConfigs, 'id' => $id, 'side' => $side, 'categories' => $categories, 'day' => $day
        ]);
    }

    //update side in db
    public function updateSide(Request $request, $id)
    {

         $validatedData = request()->validate([
            'image' => ['image'],
            'picid' => ['required', 'string'],
            'name' => ['required', 'string','min:3'],
            'category' => ['required', 'integer', 'min:0'],
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
            'description' => ['max:500'],
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

        $side = DB::table('side')
            ->where('restaurantid', '=', $restaurantID)
            ->where('id', '=', $id)
            ->first();
        if ($side === null) {
            return redirect('/');
        }

        $side = Side::where('id', $id)->where('restaurantid', '=', $restaurantID)->first();
        $side->name = request('name');
        $side->category = request('category');
        $side->picid = request('picid');
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
        if (request('description') == NULL) {
            $side->description = " ";
        } else {
            $side->description = request('description');
        }
        $side->vegan = $request->has('vegan');
        $side->vegetarian = $request->has('vegetarian');
        $side->glutenfree = $request->has('glutenfree');
        $side->lactosefree = $request->has('lactosefree');
        $side->fatfree = $request->has('fatfree');
        $side->sugarfree = $request->has('sugarfree');
        $side->allergenicfree = $request->has('allergenicfree');
        if (request('calorie') == "NULL") {
            $side->calorie = NULL;
        } else {
            $side->calorie = request('calorie');
        }
        $side->available_separately = $request->has('available_separately');
        $side->available = $request->has('available');
        $side->save();

        if ($request->hasFile('image')) {
            $picID = request('picid');
            $this->validate($request, [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            ]);
    
            $image = $request->file('image');
            $input['imagename'] = ''.$picID.'.'.$image->extension();
            $filename = $picID.'.jpg';

            $destinationPath = 'images/sides';

            if(File::exists($destinationPath.'/'.$filename)) {
                File::delete($destinationPath.'/'.$filename);  // or unlink($filename);
            }
            $img = Image::make($image->path())->encode('jpg', 80)->save($destinationPath.'/'.$filename);

            $img = Image::make('images/sides/'.$picID.'.jpg')->resize(1080, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$filename);

            $img = Image::make('images/sides/'.$filename)->crop(1080, 720)->save($destinationPath.'/'.$filename);
        }
   
        return redirect()->action('SideController@editSide', ['id' => $id])
            ->with('success','A köret sikeresen frissítve lett az étlapon!');
    }

    // List - Side
    public function listSide(){
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

        $side = DB::table('side')->where('restaurantid', $restaurantID)->get();

        $day = date('w', strtotime(date("Y-m-d")));

        return view('/pages/list-side', [
            'pageConfigs' => $pageConfigs, 'side' => $side, 'categories' => $categories, 'day' => $day
        ]);
    }

    //save new side to db
    public function insertSide(Request $request)
    {

         $validatedData = request()->validate([
            'image' => ['required','image'],
            'name' => ['required', 'string','min:3'],
            'category' => ['required', 'integer', 'min:0'],
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
            'description' => ['max:500'],
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
        $side->category = request('category');
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
        if (request('description') == NULL) {
            $side->description = " ";
        } else {
            $side->description = request('description');
        }
        $side->vegan = $request->has('vegan');
        $side->vegetarian = $request->has('vegetarian');
        $side->glutenfree = $request->has('glutenfree');
        $side->lactosefree = $request->has('lactosefree');
        $side->fatfree = $request->has('fatfree');
        $side->sugarfree = $request->has('sugarfree');
        $side->allergenicfree = $request->has('allergenicfree');
        if (request('calorie') == "NULL") {
            $side->calorie = NULL;
        } else {
            $side->calorie = request('calorie');
        }
        $side->available_separately = $request->has('available_separately');
        $side->available = $request->has('available');
        $side->save();

        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);
  
        $image = $request->file('image');
        $input['imagename'] = ''.$picID.'.'.$image->extension();
        $filename = $picID.'.jpg';

        $destinationPath = 'images/sides';

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

    //delete side from db
    public function deleteSide(Request $request)
    {
        $validatedData = request()->validate([
            'id' => ['required', 'integer', 'min:0'],
            'verify' => ['boolean'],
        ]);

        $id = request('id');

        $verify = $request->has('verify');
        if (!$verify) {
            return redirect()->action('SideController@editSide', ['id' => $id])
            ->with('fail','A termék végleges törléshez kérjük erősítse meg törlési szándékát a négyzet bepipálásával!');
        }

        $restaurantID = Auth::user()->restaurantid;

        $menus = DB::table('menu')->where('restaurantid', $restaurantID)->where('enable', 1)->get();
        foreach($menus as $menu) {
            $count = DB::table('side_to_menu')
            ->where('menuid', '=', $menu->id)
            ->count();
            if ($count == 1) {
                $m = DB::table('side_to_menu')->where('menuid', $menu->id)->first();
                if ($m->sideid == $id) {
                    return redirect()->action('SideController@editSide', ['id' => $id])
                    ->with('fail','Ez a köret jelenleg használatban van egyetlen választható köretként egy menüben ("'.$menu->name.'")! A köret eltávolításához kérjük vegyen fel más köretet is az adott menübe, vagy kapcsolja ki a menüt. ');
                }
            }
        }
        
        $count = DB::table('side')
            ->where('restaurantid', '=', $restaurantID)
            ->where('id', '=', $id)
            ->count();
        if ($count !== 1) {
            return redirect()->action('SideController@editSide', ['id' => $id])
            ->with('fail','A keresett köret nem található! ('.$id.')');
        }

        DB::table('side')
            ->where('restaurantid', '=', $restaurantID)
            ->where('id', '=', $id)
            ->delete();

        DB::table('side_to_menu')
            ->where('sideid', '=', $id)
            ->delete();
   
        return redirect()->action('SideController@listSide')
            ->with('success','A köret sikeresen el lett távolítva az étlapról!');
    }

}