<?php

namespace App\Http\Controllers;

use File;
use Image;
use App\PizzadesignerSize;
use App\PizzadesignerBase;
use App\PizzadesignerTopping;
use App\PizzadesignerSauce;
use App\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PizzadesignerController extends Controller
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

    // show - pizzadesigner - size
    public function showSize(){
        $pageConfigs = [
            'pageHeader' => false
        ];

        $restaurantID = Auth::user()->restaurantid;

        $pizzadesigner_sizes = DB::table('pizzadesigner_size')
            ->where('restaurantid', '=', $restaurantID)
            ->orderBy('size', 'asc')
            ->get();
        if ($pizzadesigner_sizes === null) {
            return redirect('/');
        }

        return view('/pages/pizzadesigner-size', [
            'pageConfigs' => $pageConfigs, 
            'pizzadesigner_sizes' => $pizzadesigner_sizes
        ]);
    }

    //save new size to pizzadesigner db
    public function addSize(Request $request)
    {

         $validatedData = request()->validate([
            'size' => ['required', 'integer', 'min:1', 'max:200'],
            'price' => ['required', 'integer', 'min:0', 'max:100000'],
            'makeprice' => ['required', 'integer', 'min:0', 'max:100000'],
            'maketime' => ['required', 'integer', 'min:0','max:120'],
            'toppingslimit' => ['required', 'integer', 'min:2','max:10'],
        ]);

        $restaurantID = Auth::user()->restaurantid;

        $pizzadesignersize = new PizzadesignerSize;
        $pizzadesignersize->restaurantid = $restaurantID;
        $pizzadesignersize->size = request('size');
        $pizzadesignersize->price = request('price');
        $pizzadesignersize->makeprice = request('makeprice');
        $pizzadesignersize->maketime = request('maketime');
        $pizzadesignersize->toppingslimit = request('toppingslimit');
        $pizzadesignersize->save();
   
        return back()
            ->with('success','Az új méret sikeresen hozzá lett adva a pizzatervezőhöz!');
    }

    //delete size from pizzadeisgner db
    public function removeSize(Request $request)
    {
        $validatedData = request()->validate([
            'id' => ['required', 'integer', 'min:0'],
        ]);

        $id = request('id');
        $restaurantID = Auth::user()->restaurantid;

        $count = DB::table('pizzadesigner_size')
            ->where('restaurantid', '=', $restaurantID)
            ->where('id', '=', $id)
            ->count();
        if ($count !== 1) {
            return back()
            ->with('fail','A keresett méret nem található!');
        }

        DB::table('pizzadesigner_size')
            ->where('restaurantid', '=', $restaurantID)
            ->where('id', '=', $id)
            ->delete();
        
        DB::table('pizzadesigner_base')
            ->where('restaurantid', '=', $restaurantID)
            ->where('sizeid', '=', $id)
            ->delete();

        DB::table('pizzadesigner_topping')
            ->where('restaurantid', '=', $restaurantID)
            ->where('sizeid', '=', $id)
            ->delete();

        DB::table('pizzadesigner_sauce')
            ->where('restaurantid', '=', $restaurantID)
            ->where('sizeid', '=', $id)
            ->delete();
   
        return back()
            ->with('success','A méret sikeresen el lett távolítva a pizzatervezőből!');
    }

    // show - pizzadesigner - base
    public function showBase(){
        $pageConfigs = [
            'pageHeader' => false
        ];

        $restaurantID = Auth::user()->restaurantid;

        $pizzadesigner_sizes = DB::table('pizzadesigner_size')
            ->where('restaurantid', '=', $restaurantID)
            ->orderBy('size', 'asc')
            ->get();
        if ($pizzadesigner_sizes === null) {
            return redirect('/');
        }

        $pizzadesigner_bases = DB::table('pizzadesigner_base')
            ->where('restaurantid', '=', $restaurantID)
            ->orderBy('price', 'asc')
            ->get();
        if ($pizzadesigner_bases === null) {
            return redirect('/');
        }

        return view('/pages/pizzadesigner-base', [
            'pageConfigs' => $pageConfigs, 
            'pizzadesigner_sizes' => $pizzadesigner_sizes, 
            'pizzadesigner_bases' => $pizzadesigner_bases
        ]);
    }

    //save new base to pizzadesigner db
    public function addBase(Request $request)
    {

        $validatedData = request()->validate([
            'sizeid' => ['required', 'integer', 'min:0'],
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'price' => ['required', 'integer', 'min:0', 'max:10000'],
            'makeprice' => ['required', 'integer', 'min:0', 'max:10000'],
            'maketime' => ['required', 'integer', 'min:0','max:120'],
        ]);

        $restaurantID = Auth::user()->restaurantid;

        $pizzadesignerbase = new PizzadesignerBase;
        $pizzadesignerbase->sizeid = request('sizeid');
        $pizzadesignerbase->restaurantid = $restaurantID;
        $pizzadesignerbase->name = request('name');
        $pizzadesignerbase->price = request('price');
        $pizzadesignerbase->makeprice = request('makeprice');
        $pizzadesignerbase->maketime = request('maketime');
        $pizzadesignerbase->save();
   
        return back()
            ->with('success','Az új alap sikeresen hozzá lett adva a pizzatervezőhöz!');
    }

    //delete base from pizzadeisgner db
    public function removeBase(Request $request)
    {
        $validatedData = request()->validate([
            'id' => ['required', 'integer', 'min:0'],
        ]);

        $id = request('id');
        $restaurantID = Auth::user()->restaurantid;

        $count = DB::table('pizzadesigner_base')
            ->where('restaurantid', '=', $restaurantID)
            ->where('id', '=', $id)
            ->count();
        if ($count !== 1) {
            return back()
            ->with('fail','A keresett alap nem található!');
        }

        DB::table('pizzadesigner_base')
            ->where('restaurantid', '=', $restaurantID)
            ->where('id', '=', $id)
            ->delete();
   
        return back()
            ->with('success','Az alap sikeresen el lett távolítva a pizzatervezőből!');
    }

    // show - pizzadesigner - topping
    public function showTopping(){
        $pageConfigs = [
            'pageHeader' => false
        ];

        $restaurantID = Auth::user()->restaurantid;

        $pizzadesigner_sizes = DB::table('pizzadesigner_size')
            ->where('restaurantid', '=', $restaurantID)
            ->orderBy('size', 'asc')
            ->get();
        if ($pizzadesigner_sizes === null) {
            return redirect('/');
        }

        $pizzadesigner_toppings = DB::table('pizzadesigner_topping')
            ->where('restaurantid', '=', $restaurantID)
            ->orderBy('price', 'asc')
            ->get();
        if ($pizzadesigner_toppings === null) {
            return redirect('/');
        }

        return view('/pages/pizzadesigner-topping', [
            'pageConfigs' => $pageConfigs, 
            'pizzadesigner_sizes' => $pizzadesigner_sizes, 
            'pizzadesigner_toppings' => $pizzadesigner_toppings
        ]);
    }

    //save new topping to pizzadesigner db
    public function addTopping(Request $request)
    {

        $validatedData = request()->validate([
            'sizeid' => ['required', 'integer', 'min:0'],
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'category' => ['required', 'integer', 'min:1', 'max:10'],
            'price' => ['required', 'integer', 'min:0', 'max:10000'],
            'makeprice' => ['required', 'integer', 'min:0', 'max:10000'],
            'maketime' => ['required', 'integer', 'min:0','max:120'],
        ]);

        $restaurantID = Auth::user()->restaurantid;

        $pizzadesignertopping = new PizzadesignerTopping;
        $pizzadesignertopping->sizeid = request('sizeid');
        $pizzadesignertopping->restaurantid = $restaurantID;
        $pizzadesignertopping->name = request('name');
        $pizzadesignertopping->category = request('category');
        $pizzadesignertopping->price = request('price');
        $pizzadesignertopping->makeprice = request('makeprice');
        $pizzadesignertopping->maketime = request('maketime');
        $pizzadesignertopping->save();
   
        return back()
            ->with('success','Az új feltét sikeresen hozzá lett adva a pizzatervezőhöz!');
    }

    //delete topping from pizzadeisgner db
    public function removeTopping(Request $request)
    {
        $validatedData = request()->validate([
            'id' => ['required', 'integer', 'min:0'],
        ]);

        $id = request('id');
        $restaurantID = Auth::user()->restaurantid;

        $count = DB::table('pizzadesigner_topping')
            ->where('restaurantid', '=', $restaurantID)
            ->where('id', '=', $id)
            ->count();
        if ($count !== 1) {
            return back()
            ->with('fail','A keresett feltét nem található!');
        }

        DB::table('pizzadesigner_topping')
            ->where('restaurantid', '=', $restaurantID)
            ->where('id', '=', $id)
            ->delete();
   
        return back()
            ->with('success','A feltét sikeresen el lett távolítva a pizzatervezőből!');
    }

        // show - pizzadesigner - sauce
        public function showSauce(){
            $pageConfigs = [
                'pageHeader' => false
            ];
    
            $restaurantID = Auth::user()->restaurantid;
    
            $pizzadesigner_sizes = DB::table('pizzadesigner_size')
                ->where('restaurantid', '=', $restaurantID)
                ->orderBy('size', 'asc')
                ->get();
            if ($pizzadesigner_sizes === null) {
                return redirect('/');
            }
    
            $pizzadesigner_sauces = DB::table('pizzadesigner_sauce')
                ->where('restaurantid', '=', $restaurantID)
                ->orderBy('price', 'asc')
                ->get();
            if ($pizzadesigner_sauces === null) {
                return redirect('/');
            }
    
            return view('/pages/pizzadesigner-sauce', [
                'pageConfigs' => $pageConfigs, 
                'pizzadesigner_sizes' => $pizzadesigner_sizes, 
                'pizzadesigner_sauces' => $pizzadesigner_sauces
            ]);
        }
    
        //save new sauce to pizzadesigner db
        public function addSauce(Request $request)
        {
    
            $validatedData = request()->validate([
                'sizeid' => ['required', 'integer', 'min:0'],
                'name' => ['required', 'string', 'min:3', 'max:50'],
                'price' => ['required', 'integer', 'min:0', 'max:10000'],
                'makeprice' => ['required', 'integer', 'min:0', 'max:10000'],
                'maketime' => ['required', 'integer', 'min:0','max:120'],
            ]);
    
            $restaurantID = Auth::user()->restaurantid;
    
            $pizzadesignersauce = new PizzadesignerSauce;
            $pizzadesignersauce->sizeid = request('sizeid');
            $pizzadesignersauce->restaurantid = $restaurantID;
            $pizzadesignersauce->name = request('name');
            $pizzadesignersauce->price = request('price');
            $pizzadesignersauce->makeprice = request('makeprice');
            $pizzadesignersauce->maketime = request('maketime');
            $pizzadesignersauce->save();
       
            return back()
                ->with('success','Az új szósz sikeresen hozzá lett adva a pizzatervezőhöz!');
        }
    
        //delete sauce from pizzadeisgner db
        public function removeSauce(Request $request)
        {
            $validatedData = request()->validate([
                'id' => ['required', 'integer', 'min:0'],
            ]);
    
            $id = request('id');
            $restaurantID = Auth::user()->restaurantid;
    
            $count = DB::table('pizzadesigner_sauce')
                ->where('restaurantid', '=', $restaurantID)
                ->where('id', '=', $id)
                ->count();
            if ($count !== 1) {
                return back()
                ->with('fail','A keresett szósz nem található!');
            }
    
            DB::table('pizzadesigner_sauce')
                ->where('restaurantid', '=', $restaurantID)
                ->where('id', '=', $id)
                ->delete();
       
            return back()
                ->with('success','A szósz sikeresen el lett távolítva a pizzatervezőből!');
        }

    

}