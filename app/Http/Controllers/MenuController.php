<?php

namespace App\Http\Controllers;

use File;
use Image;
use App\Meal;
use App\Menu;
use App\Side;
use App\Drink;
use App\SideToMenu;
use App\DrinkToMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
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

        $menu = DB::table('menu')
            ->where('restaurantid', '=', $restaurantID)
            ->where('mealid', '=', $id)
            ->first();
        if ($menu === null) {
            return redirect('/');
        }

        $menusides = DB::table('side_to_menu')
            ->where('menuid', '=', $menu->id)
            ->get();
        if ($meal === null) {
            return redirect('/');
        }

        $menudrinks = DB::table('drink_to_menu')
            ->where('menuid', '=', $menu->id)
            ->get();
        if ($meal === null) {
            return redirect('/');
        }

        $categories = DB::table('category')
            ->where('restaurantid', '=', $restaurantID)
            ->get();
        if ($categories === null) {
            return redirect('/');
        }
        
        $side = DB::table('side')->where('restaurantid', $restaurantID)->get();

        $drink = DB::table('drink')->where('restaurantid', $restaurantID)->get();

        $day = date('w', strtotime(date("Y-m-d")));

        return view('/pages/edit-menu', [
            'pageConfigs' => $pageConfigs, 
            'id' => $id,
            'meal' => $meal, 
            'menu' => $menu, 
            'side' => $side, 
            'drink' => $drink, 
            'categories' => $categories, 
            'menusides' => $menusides, 
            'menudrinks' => $menudrinks, 
            'day' => $day
        ]);
    }

    //save add side to menu in db
    public function addSideToMenu(Request $request)
    {
        $validatedData = request()->validate([
            'mealid' => ['required', 'integer', 'min:0'],
            'sideid' => ['required', 'integer', 'min:0'],
        ]);

        $restaurantID = Auth::user()->restaurantid;

        $menuID = request('mealid');
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

        $count = DB::table('side_to_menu')
            ->where('menuid', '=', $menuID)
            ->where('sideid', '=', $sideID)
            ->count();
        if ($count !== 0) {
            return redirect()->action('MenuController@editMenu', ['id' => $mealID])
            ->with('fail','Ez a tétel már szerepel a menün! (E-0013)');
        }

        $sideToMenu = new SideToMenu;
        $sideToMenu->menuid = request('menuid');
        $sideToMenu->sideid = request('sideid');
        $sideToMenu->save();

   
        return redirect()->action('MenuController@editMenu', ['id' => $mealID])
            ->with('success','A köret sikeresen hozzá lett adva a menühöz!');
    }

    //save remove side from meal in db
    public function removeSideFromMeal(Request $request)
    {
        $validatedData = request()->validate([
            'mealid' => ['required', 'integer', 'min:0'],
            'menuid' => ['required', 'integer', 'min:0'],
            'sideid' => ['required', 'integer', 'min:0'],
        ]);

        $restaurantID = Auth::user()->restaurantid;

        $mealID = request('mealid');
        $menuID = request('menuid');
        $sideID = request('sideid');

        $menu = DB::table('menu')
                ->where('id', '=', $menuID)
                ->where('restaurantid', '=', $restaurantID)
                ->first();
                
        if ($menu->enable) {
            $count = DB::table('side_to_menu')
            ->where('menuid', '=', $menuID)
            ->count();

            if ($count < 2) {
                return redirect()->action('MenuController@editMenu', ['id' => $mealID])
                ->with('fail','A köret eltávolításához először ki kell kapcsolni a menüt, vagy hozzá kell adni új köretet!');
            }
        }
        
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

        $count = DB::table('side_to_menu')
            ->where('menuid', '=', $menuID)
            ->where('sideid', '=', $sideID)
            ->count();
        if ($count !== 1) {
            return redirect()->action('MenuController@editMenu', ['id' => $mealID])
            ->with('fail','Ez a tétel még nem szerepel a menün! (E-0013)');
        }

        DB::table('side_to_menu')
            ->where('menuid', '=', $menuID)
            ->where('sideid', '=', $sideID)
            ->delete();
   
        return redirect()->action('MenuController@editMenu', ['id' => $mealID])
            ->with('success','A köret sikeresen el lett távolítva a menüről!');
    }


    //save add drink to meal in db
    public function addDrinkToMenu(Request $request)
    {
        $validatedData = request()->validate([
            'mealid' => ['required', 'integer', 'min:0'],
            'menuid' => ['required', 'integer', 'min:0'],
            'drinkid' => ['required', 'integer', 'min:0'],
        ]);

        $restaurantID = Auth::user()->restaurantid;

        $mealID = request('mealid');
        $menuID = request('menuid');
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

        $count = DB::table('drink_to_menu')
            ->where('menuid', '=', $menuID)
            ->where('drinkid', '=', $drinkID)
            ->count();
        if ($count !== 0) {
            return redirect()->action('MenuController@editMenu', ['id' => $mealID])
            ->with('fail','Ez a tétel már szerepel a menün! (E-0013)');
        }

        $drinkToMenu = new DrinkToMenu;
        $drinkToMenu->menuid = request('menuid');
        $drinkToMenu->drinkid = request('drinkid');
        $drinkToMenu->save();

   
        return redirect()->action('MenuController@editMenu', ['id' => $mealID])
            ->with('success','Az ital sikeresen hozzá lett adva a menühöz!');
    }

    //save remove drink from meal in db
    public function removeDrinkFromMenu(Request $request)
    {
        $validatedData = request()->validate([
            'mealid' => ['required', 'integer', 'min:0'],
            'menuid' => ['required', 'integer', 'min:0'],
            'drinkid' => ['required', 'integer', 'min:0'],
        ]);

        $restaurantID = Auth::user()->restaurantid;

        $mealID = request('mealid');
        $menuID = request('menuid');
        $drinkID = request('drinkid');

        $menu = DB::table('menu')
                ->where('id', '=', $menuID)
                ->where('restaurantid', '=', $restaurantID)
                ->first();

        if ($menu->enable) {
            $count = DB::table('drink_to_menu')
            ->where('menuid', '=', $menuID)
            ->count();

            if ($count < 2) {
                return redirect()->action('MenuController@editMenu', ['id' => $mealID])
                ->with('fail','Az ital eltávolításához először ki kell kapcsolni a menüt, vagy hozzá kell adni új italt!');
            }
        }
        
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

        $count = DB::table('drink_to_menu')
            ->where('menuid', '=', $menuID)
            ->where('drinkid', '=', $drinkID)
            ->count();
        if ($count !== 1) {
            return redirect()->action('MenuController@editMenu', ['id' => $mealID])
            ->with('fail','Ez a tétel még nem szerepel a menün! (E-0013)');
        }

        DB::table('drink_to_menu')
            ->where('menuid', '=', $menuID)
            ->where('drinkid', '=', $drinkID)
            ->delete();
   
        return redirect()->action('MenuController@editMenu', ['id' => $mealID])
            ->with('success','Az ital sikeresen el lett távolítva a menüről!');
    }

    //update menu in db
    public function updateMenu(Request $request)
    {

         $validatedData = request()->validate([
            'id' => ['required', 'integer', 'min:0'],
            'image' => ['image'],
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'category' => ['required', 'integer','min:0'],
            'menusalepercent' => ['required', 'integer', 'min:0', 'max:90'],
            'enable' => ['boolean']
        ]);

        $restaurantID = Auth::user()->restaurantid;

        $id = request('id');

        $menu = DB::table('menu')
            ->where('restaurantid', '=', $restaurantID)
            ->where('id', '=', $id)
            ->first();
        if ($menu === null) {
            return redirect('/');
        }

        $menuID = $menu->id;
        $mealID = $menu->mealid;
        $picID = $menu->picid;

        $menu = Menu::where('id', $id)->where('restaurantid', '=', $restaurantID)->first();
        $menu->name = request('name');
        $menu->category = request('category');
        $menu->menusalepercent = request('menusalepercent');

        if ($request->has('enable')) {
            $count = DB::table('side_to_menu')
                ->where('menuid', '=', $menuID)
                ->count();
            if ($count < 1) {
                return redirect()->action('MenuController@editMenu', ['id' => $mealID])
                ->with('fail','A menü bekapcsolásához kérjük előbb adjon hozzá választható köretet a menühöz!');
            } else {
                $count = DB::table('drink_to_menu')
                ->where('menuid', '=', $menuID)
                ->count();
                if ($count < 1) {
                    return redirect()->action('MenuController@editMenu', ['id' => $mealID])
                    ->with('fail','A menü bekapcsolásához kérjük előbb adjon hozzá választható italt a menühöz!');
                } else {
                    $menu->enable = $request->has('enable');
                }
            }
        } else {
            $menu->enable = $request->has('enable');
        }
        $menu->save();

        if ($request->hasFile('image')) {
            $this->validate($request, [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            ]);
    
            $image = $request->file('image');
            $input['imagename'] = ''.$picID.'.'.$image->extension();
            $filename = $picID.'.jpg';

            $destinationPath = 'images/menus';

            if(File::exists($destinationPath.'/'.$filename)) {
                File::delete($destinationPath.'/'.$filename);  // or unlink($filename);
            }
            $img = Image::make($image->path())->encode('jpg', 80)->save($destinationPath.'/'.$filename);

            $img = Image::make('images/menus/'.$picID.'.jpg')->resize(1080, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$filename);

            $img = Image::make('images/menus/'.$filename)->crop(1080, 720)->save($destinationPath.'/'.$filename);
        }
   
        return redirect()->action('MenuController@editMenu', ['id' => $mealID])
            ->with('success','A menü sikeresen frissítve lett az étlapon!');
    }


}