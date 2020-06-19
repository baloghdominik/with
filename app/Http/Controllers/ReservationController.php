<?php

namespace App\Http\Controllers;

use App\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;

use App\Http\Services\RestaurantService;
use App\Http\Services\ReservationService;

class ReservationController extends Controller
{
    public $successStatus = 200;

    // show - reservations
    public function showReservations(){
        $pageConfigs = [
            'pageHeader' => false
        ];

        $restaurantID = Auth::user()->restaurantid;

        $reservations = DB::table('reservation')
            ->join('customer', 'reservation.customerid', '=', 'customer.id')
            ->select('reservation.*', 'customer.firstname', 'customer.lastname', 'customer.email', 'customer.phone')
            ->where('reservation.restaurantid', '=', $restaurantID)
            ->where('reservation.confirmed', '=', 0)
            ->where('reservation.date', '>=', date("Y-m-d"))
            ->orderBy('reservation.date', 'ASC')
            ->orderBy('reservation.time', 'ASC')
            ->get();
        if ($reservations === null) {
            return redirect('/');
        }

        $confirmedreservations = DB::table('reservation')
            ->join('customer', 'reservation.customerid', '=', 'customer.id')
            ->select('reservation.*', 'customer.firstname', 'customer.lastname', 'customer.email', 'customer.phone')
            ->where('reservation.restaurantid', '=', $restaurantID)
            ->where('reservation.confirmed', '=', 1)
            ->where('reservation.date', '>=', date("Y-m-d"))
            ->orderBy('reservation.date', 'ASC')
            ->orderBy('reservation.time', 'ASC')
            ->get();
        if ($reservations === null) {
            return redirect('/');
        }

        return view('/pages/reservations', [
            'pageConfigs' => $pageConfigs, 'reservations' => $reservations, 'confirmedreservations' => $confirmedreservations
        ]);
    }

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


    //update reservation in db
    public function updateReservation(Request $request)
    {

        $validatedData = request()->validate([
            'id' => ['integer', 'min:0', 'required']
        ]);

        if ($request->has('delete')) {

            $id = request('id');
            if ($request->has('comment') && request('comment') != NULL) {
                $validatedData = request()->validate([
                    'comment' => ['string', 'min:0', 'max:500']
                ]);

                $comment = request('comment');
            } else {
                $comment = '';
            }

            $restaurantID = Auth::user()->restaurantid;

            $reservation = DB::table('reservation')
                ->where('restaurantid', '=', $restaurantID)
                ->where('id', '=', $id)
                ->first();
            if ($reservation === null) {
                return back()
                ->with('error','Sikertelen művelet!');
            }

            DB::table('reservation')
            ->where('restaurantid', '=', $restaurantID)
            ->where('id', '=', $id)
            ->delete();
    
            return back()
                ->with('success','Az asztalfoglalás sikeresen el lett utasítva!');
        } elseif ($request->has('confirm')) {

            $id = request('id');
            if ($request->has('comment') && request('comment') != NULL) {
                $validatedData = request()->validate([
                    'comment' => ['string', 'min:0', 'max:500']
                ]);

                $comment = request('comment');
            } else {
                $comment = '';
            }

            $restaurantID = Auth::user()->restaurantid;

            $reservation = DB::table('reservation')
                ->where('restaurantid', '=', $restaurantID)
                ->where('id', '=', $id)
                ->first();
            if ($reservation === null) {
                return back()
                ->with('error','Sikertelen művelet!');
            }

            $reservation = Reservation::where('id', $id)->where('restaurantid', '=', $restaurantID)->first();
            $reservation->confirmed = 1;
            $reservation->save();
    
            return back()
                ->with('success','Az asztalfoglalás sikeresen el lett fogadva!');
        }

        return back()
                ->with('success','Sikertelen művelet!');
    }


    //delete reservation from db
    public function deleteReservation(Request $request)
    {

        $validatedData = request()->validate([
            'id' => ['integer', 'min:0', 'required']
        ]);

        $id = request('id');

        $restaurantID = Auth::user()->restaurantid;

        $reservation = DB::table('reservation')
            ->where('restaurantid', '=', $restaurantID)
            ->where('id', '=', $id)
            ->first();
        if ($reservation === null) {
            return back()
                ->with('success','Sikertelen művelet!');
        }

        DB::table('reservation')
        ->where('restaurantid', '=', $restaurantID)
        ->where('id', '=', $id)
        ->delete();

        return back()
            ->with('success','Az asztalfoglalás sikeresen törölve lett!');
    }


}