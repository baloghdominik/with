<?php

namespace App\Http\Controllers;

use File;
use Image;
use App\Restaurant;
use App\Zipcode;
use App\RestaurantZipcode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
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

    // show - settings
    public function showSettings(){
        $pageConfigs = [
            'pageHeader' => false
        ];

        $restaurantID = Auth::user()->restaurantid;

        $restaurant = DB::table('restaurant')
            ->where('id', '=', $restaurantID)
            ->first();
        if ($restaurant === null) {
            return redirect('/');
        }

        $iframe = rawurlencode($restaurant->address);

        $zipcodes = Zipcode::orderBy('zipcode', 'ASC')->get();

        $restaurantzipcodes = RestaurantZipcode::where('restaurantid' , $restaurantID)->get();

        return view('/pages/settings', [
            'pageConfigs' => $pageConfigs, 'restaurant' => $restaurant, 'zipcodes' => $zipcodes, 'restaurantzipcodes' => $restaurantzipcodes, 'iframe' => $iframe
        ]);
    }

    // show - settings
    public function showUserSettings(){
        $pageConfigs = [
            'pageHeader' => false
        ];

        $restaurantID = Auth::user()->restaurantid;

        $userID = Auth::user()->id;

        $restaurant = DB::table('restaurant')
            ->where('id', '=', $restaurantID)
            ->first();
        if ($restaurant === null) {
            return redirect('/');
        }

        $user = DB::table('users')
            ->where('id', '=', $userID)
            ->first();
        if ($user === null) {
            return redirect('/');
        }

        return view('/pages/user-settings', [
            'pageConfigs' => $pageConfigs, 'restaurant' => $restaurant, 'user' => $user
        ]);
    }

    //update settings in db
    public function updateSettings(Request $request)
    {

         $validatedData = request()->validate([
            'address' => ['required', 'string','min:10'],
            'phone' => ['required', 'string', 'min:8', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:60'],
            'description' => ['string', 'min:0', 'max:500'],
            'monday' => ['boolean'],
            'mondayopen' => ['required'],
            'mondayclose' => ['required'],
            'tuesday' => ['boolean'],
            'tuesdayopen' => ['required'],
            'tuesdayclose' => ['required'],
            'wednesday' => ['boolean'],
            'wednesdayopen' => ['required'],
            'wednesdayclose' => ['required'],
            'thursday' => ['boolean'],
            'thursdayopen' => ['required'],
            'thursdayclose' => ['required'],
            'friday' => ['boolean'],
            'fridayopen' => ['required'],
            'fridayclose' => ['required'],
            'saturday' => ['boolean'],
            'saturdayopen' => ['required'],
            'saturdayclose' => ['required'],
            'sunday' => ['boolean'],
            'sundayopen' => ['required'],
            'sundayclose' => ['required'],
            'firstorder' => ['required', 'integer', 'min:-35', 'max:65'],
            'lastorder' => ['required', 'integer', 'min:-65', 'max:35'],
            'delivery' => ['boolean'],
            'pickup' => ['boolean'],
            'minimumordervalue' => ['required', 'integer', 'min:0', 'max:3000'],
            'deliveryprice' => ['required', 'integer', 'min:0', 'max:500'],
            'deliverytime' => ['required', 'integer', 'min:10', 'max:120'],
            'deliverytimecalculation' => ['required', 'integer', 'min:0', 'max:10'],
            'pickuptimecalculation' => ['required', 'integer', 'min:0', 'max:10'],
            'deliverypayingmethod' => ['required', 'integer', 'min:0', 'max:10'],
            'pickuppayingmethod' => ['required', 'integer', 'min:0', 'max:10'],
            'szepcard' => ['boolean'],
            'erzsebetcard' => ['boolean'],
            'menusalepercent' => ['required', 'integer', 'min:0', 'max:20'],
            'showspecifications' => ['boolean'],
            'showcalories' => ['boolean'],
            'showdescription' => ['boolean'],
            'pizzadesigner' => ['boolean'],
            'isreservation' => ['boolean'],
            'maxreservationperson' => ['required', 'integer', 'min:9', 'max:501'],
            'reservationtime' => ['required', 'integer', 'min:1', 'max:100'],
            'zipcodes.*' => ['integer', 'min:1', 'max:10000']
        ]);

        $restaurantID = Auth::user()->restaurantid;

        $restaurant = DB::table('restaurant')
            ->where('id', '=', $restaurantID)
            ->first();
        if ($restaurant === null) {
            return redirect('/');
        }

        $restaurant = Restaurant::where('id', '=', $restaurantID)->first();
        $restaurant->address = request('address');
        $restaurant->phone = request('phone');
        $restaurant->email = request('email');
        $restaurant->facebook = request('facebook');
        $restaurant->description = request('description');
        $restaurant->description = request('description');
        $restaurant->monday = $request->has('monday');
        $restaurant->mondayopen = request('mondayopen');
        $restaurant->mondayclose = request('mondayclose');
        $restaurant->tuesday = $request->has('tuesday');
        $restaurant->tuesdayopen = request('tuesdayopen');
        $restaurant->tuesdayclose = request('tuesdayclose');
        $restaurant->wednesday = $request->has('wednesday');
        $restaurant->wednesdayopen = request('wednesdayopen');
        $restaurant->wednesdayclose = request('wednesdayclose');
        $restaurant->thursday = $request->has('thursday');
        $restaurant->thursdayopen = request('thursdayopen');
        $restaurant->thursdayclose = request('thursdayclose');
        $restaurant->friday = $request->has('friday');
        $restaurant->fridayopen = request('fridayopen');
        $restaurant->fridayclose = request('fridayclose');
        $restaurant->saturday = $request->has('saturday');
        $restaurant->saturdayopen = request('saturdayopen');
        $restaurant->saturdayclose = request('saturdayclose');
        $restaurant->sunday = $request->has('sunday');
        $restaurant->sundayopen = request('sundayopen');
        $restaurant->sundayclose = request('sundayclose');
        $restaurant->firstorder = request('firstorder');
        $restaurant->lastorder = request('lastorder');
        $restaurant->delivery = $request->has('delivery');
        $restaurant->pickup = $request->has('pickup');
        $restaurant->minimumordervalue = request('minimumordervalue');
        $restaurant->deliveryprice = request('deliveryprice');
        $restaurant->deliverytime = request('deliverytime');
        $restaurant->deliverytimecalculation = request('deliverytimecalculation');
        $restaurant->pickuptimecalculation = request('pickuptimecalculation');
        $restaurant->deliverypayingmethod = request('deliverypayingmethod');
        $restaurant->pickuppayingmethod = request('pickuppayingmethod');
        $restaurant->szepcard = $request->has('szepcard');
        $restaurant->erzsebetcard = $request->has('erzsebetcard');
        $restaurant->menusalepercent = request('menusalepercent');
        $restaurant->showspecifications = $request->has('showspecifications');
        $restaurant->showcalories = $request->has('showcalories');
        $restaurant->showdescription = $request->has('showdescription');
        $restaurant->pizzadesigner = $request->has('pizzadesigner');
        $restaurant->isreservation = $request->has('isreservation');
        $restaurant->maxreservationperson = request('maxreservationperson');
        $restaurant->reservationtime = request('reservationtime');
        $restaurant->save();

        if (count(request('zipcodes')) > 0) {
            $rzc = RestaurantZipcode::where('restaurantid' , $restaurantID)->delete();

            for ($i = 0; $i < count(request('zipcodes')); $i++) {
                $zipcode = new RestaurantZipcode;
                $zipcode->restaurantid = $restaurantID;
                $zipcode->zipcode = request('zipcodes')[$i];
                $zipcode->save();
            }

        }

        return back()
            ->with('success','Az étterem beállításai sikeresen frissültek!');
    }

    public function uploadImages(Request $request) {

        $restaurantID = Auth::user()->restaurantid;

        $restaurant = DB::table('restaurant')
            ->where('id', '=', $restaurantID)
            ->first();
        if ($restaurant === null) {
            return redirect('/');
        }

        $name = $restaurant->lowercasename;

        if ($request->hasFile('logo')) {
            $picID = "with.hu_".$restaurantID."_".$name."_logo";
            $this->validate($request, [
                'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            ]);
    
            $image = $request->file('logo');
            $input['imagename'] = ''.$picID.'.'.$image->extension();
            $filename = $picID.'.jpg';

            $destinationPath = 'images/logos';

            if(File::exists($destinationPath.'/'.$filename)) {
                File::delete($destinationPath.'/'.$filename);  // or unlink($filename);
            }
            $img = Image::make($image->path())->encode('jpg', 80)->save($destinationPath.'/'.$filename);

            $img = Image::make('images/logos/'.$picID.'.jpg')->resize(480, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$filename);

            $img = Image::make('images/logos/'.$filename)->crop(480, 480)->save($destinationPath.'/'.$filename);
        }

        if ($request->hasFile('banner')) {
            $picID = "with.hu_".$restaurantID."_".$name."_banner";
            $this->validate($request, [
                'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:8164',
            ]);
    
            $image = $request->file('banner');
            $input['imagename'] = ''.$picID.'.'.$image->extension();
            $filename = $picID.'.jpg';

            $destinationPath = 'images/banners';

            if(File::exists($destinationPath.'/'.$filename)) {
                File::delete($destinationPath.'/'.$filename);  // or unlink($filename);
            }
            $img = Image::make($image->path())->encode('jpg', 90)->save($destinationPath.'/'.$filename);

            $img = Image::make('images/banners/'.$picID.'.jpg')->resize(1920, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$filename);

            $img = Image::make('images/banners/'.$filename)->crop(1920, 540)->save($destinationPath.'/'.$filename);
        }

        for ($i = 1; $i <= 6; $i++) {
            if ($request->hasFile('pic'.$i)) {
                $picID = "with.hu_".$restaurantID."_".$name."_pic".$i;
                $this->validate($request, [
                    'pic'.$i => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
                ]);
        
                $image = $request->file('pic'.$i);
                $input['imagename'] = ''.$picID.'.'.$image->extension();
                $filename = $picID.'.jpg';

                $destinationPath = 'images/galleries';

                if(File::exists($destinationPath.'/'.$filename)) {
                    File::delete($destinationPath.'/'.$filename);  // or unlink($filename);
                }
                $img = Image::make($image->path())->encode('jpg', 90)->save($destinationPath.'/'.$filename);

                $img = Image::make('images/galleries/'.$picID.'.jpg')->resize(1920, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.$filename);

                $img = Image::make('images/galleries/'.$filename)->crop(1920, 1080)->save($destinationPath.'/'.$filename);
            }
        }
   
        return back()
            ->with('success','A képek sikeresen frissültek!');
    }

}