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
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

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