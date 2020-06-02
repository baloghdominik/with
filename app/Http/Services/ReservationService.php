<?php

namespace App\Http\Services;

use App\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationService
{
    public function isValidRestaurantID($restaurantid)
    {
        $restaurant = DB::table('restaurant')
            ->where('id', '=', $restaurantid)
            ->where('isactive', '=', 1)
            ->count();
        if ($restaurant === 1) {
            return false;  
        } else {
            return true;
        }
    }

    public function isValidPerson($restaurantid, $person)
    {
        $restaurant = DB::table('restaurant')
            ->select('maxreservationperson')
            ->where('id', '=', $restaurantid)
            ->first();
        
        if ($person > $restaurant->maxreservationperson) {
            return true;
        } else {
            return false;
        }
    }

    public function isValidTime($restaurantid, $date, $time)
    {
        $restaurant = DB::table('restaurant')
            ->select('reservationtime')
            ->where('id', '=', $restaurantid)
            ->first();
        
        $GTM = 2;
        $hours = $restaurant->reservationtime + $GTM;
        $min_date = date("Y-m-d H:i", strtotime("+{$hours} hours"));

        $reservation = $date." ".$time;

        if ($reservation >= $min_date) {
            return false;
        } else {
            return true;
        }
    }

    public function isValidCustomer($customerid)
    {
        $customer = DB::table('customer')
            ->where('id', '=', $customerid)
            ->where('email_verified_at', '!=', NULL)
            ->where('phone', '!=', NULL)
            ->where('isbanned', '=', 0)
            ->count();
        
        if ($customer === 1) {
            return false;
        } else {
            return true;
        }
    }

    public function isOpen($restaurantid, $date, $time)
    {
        $restaurant = DB::table('restaurant')
            ->select('*')
            ->where('id', '=', $restaurantid)
            ->first();
        
        $dayofweek = date('w', strtotime($date));

        $time = date('H:i', strtotime($time));

        if ($dayofweek == 1) {
            if ($restaurant->monday == 1) {
                $opentime = date('H:i', strtotime($restaurant->mondayopen));
                $closetime = date('H:i', strtotime($restaurant->mondayclose) - 3600);
                if ($time >= $opentime && $time <= $closetime) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else if ($dayofweek == 2) {
            if ($restaurant->tuesday == 1) {
                $opentime = date('H:i', strtotime($restaurant->tuesdayopen));
                $closetime = date('H:i', strtotime($restaurant->tuesdayclose) - 3600);
                if ($time >= $opentime && $time <= $closetime) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else if ($dayofweek == 3) {
            if ($restaurant->wednesday == 1) {
                $opentime = date('H:i', strtotime($restaurant->wednesdayopen));
                $closetime = date('H:i', strtotime($restaurant->wednesdayclose) - 3600);
                if ($time >= $opentime && $time <= $closetime) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else if ($dayofweek == 4) {
            if ($restaurant->thursday == 1) {
                $opentime = date('H:i', strtotime($restaurant->thursdayopen));
                $closetime = date('H:i', strtotime($restaurant->thursdayclose) - 3600);
                if ($time >= $opentime && $time <= $closetime) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else if ($dayofweek == 5) {
            if ($restaurant->friday == 1) {
                $opentime = date('H:i', strtotime($restaurant->fridayopen));
                $closetime = date('H:i', strtotime($restaurant->fridayclose) - 3600);
                if ($time >= $opentime && $time <= $closetime) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else if ($dayofweek == 6) {
            if ($restaurant->saturday == 1) {
                $opentime = date('H:i', strtotime($restaurant->saturdayopen));
                $closetime = date('H:i', strtotime($restaurant->saturdayclose) - 3600);
                if ($time >= $opentime && $time <= $closetime) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            if ($restaurant->sunday == 1) {
                $opentime = date('H:i', strtotime($restaurant->sundayopen));
                $closetime = date('H:i', strtotime($restaurant->sundayclose) - 3600);
                if ($time >= $opentime && $time <= $closetime) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }
}