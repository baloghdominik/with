<?php

namespace App\Http\Controllers;

use App\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;

use App\Http\Services\RestaurantService;
use App\Http\Services\ReservationService;

class ReservationAPIController extends Controller
{
    public $successStatus = 200;

    //save new reservation to db
    public function addReservation(Request $request, ReservationService $ReservationService, RestaurantService $RestaurantService)
    {
        $validator = Validator::make($request->all(), [ 
            'restaurantid' => 'required|integer|min:0',
            'person' => 'required|integer|min:0|max:500',
            'date' => 'required|date_format:Y-m-d',
            'time' => 'required|date_format:H:i'
        ]);

        $customer = Auth::user(); 

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        if ($ReservationService->isValidRestaurantID(request('restaurantid'))) {
            return response()->json(['error'=>"Nem található étterem."], 401);   
        }

        if (!$RestaurantService->isRestaurantReservationAvailable(request('restaurantid'))) {
            return response()->json(['error'=>"A választott étterembe nincs lehetőség asztalfoglalásra."], 401); 
        }

        if ($ReservationService->isValidCustomer($customer->id)) {
            return response()->json(['error'=>"A felhasználó nem foglalhat asztalt. Előfordulhat, hogy nincsen megadva a telefonszáma, nincs megerősítve az emailcíme, vagy tiltva van az oldalról."], 401);   
        }

        if ($ReservationService->isValidPerson(request('restaurantid'), request('person'))) {
            return response()->json(['error'=>"Ennyi személyre nem foglalható asztal."], 401);   
        }

        if ($ReservationService->isValidTime(request('restaurantid'), request('date'), request('time'))) {
            return response()->json(['error'=>"A választott időpont túl közeli."], 401);   
        }

        if (!$RestaurantService->isRestaurantReservationTime(request('restaurantid'), request('date'), request('time'))) {
            return response()->json(['error'=>"A választott időpontban az étterem zárva van."], 401); 
        }

        $reservation = new Reservation;
        $reservation->restaurantid = request('restaurantid');
        $reservation->customerid = $customer->id;
        $reservation->person = request('person');
        $reservation->date = request('date');
        $reservation->time = request('time');
        $reservation->comment = request('comment');
        $reservation->save();
   
        return response()->json($this-> successStatus); 
    }
}