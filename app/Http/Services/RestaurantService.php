<?php

namespace App\Http\Services;

use App\Restaurant;
use App\RestaurantZipcode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use DateTime;
use DateTimeZone;

class RestaurantService
{
    public function isRestaurant($restaurantid) {
        $restaurant = DB::table('restaurant')
            ->where('id', '=', $restaurantid)
            ->where('isactive', '=', 1)
            ->count();
        
        if ($restaurant === 1) {
            return true;
        } else {
            return false;
        }
    }

    public function isRestaurantDelivery($restaurantid) {
        $restaurant = Restaurant::where('id', '=', $restaurantid)->first();

        if ($restaurant->delivery == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function isRestaurantDeliveryPayingMethod($restaurantid, $method) {
        $restaurant = Restaurant::where('id', '=', $restaurantid)->first();

        if ($method == 1) {
            if ($restaurant->deliverypayingmethod == 3 || $restaurant->deliverypayingmethod == 5 || $restaurant->deliverypayingmethod == 7) {
                return true;
            } else {
                return false;
            }
        } else {
            if ($restaurant->deliverypayingmethod == 1 || $restaurant->deliverypayingmethod == 2 || $restaurant->deliverypayingmethod == 4 || $restaurant->deliverypayingmethod == 5 || $restaurant->deliverypayingmethod == 6 || $restaurant->deliverypayingmethod == 7) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function isRestaurantPickupPayingMethod($restaurantid, $method) {
        $restaurant = Restaurant::where('id', '=', $restaurantid)->first();

        if ($method == 1) {
            if ($restaurant->pickuppayingmethod == 3 || $restaurant->pickuppayingmethod == 5 || $restaurant->pickuppayingmethod == 7) {
                return true;
            } else {
                return false;
            }
        } else {
            if ($restaurant->pickuppayingmethod == 1 || $restaurant->pickuppayingmethod == 2 || $restaurant->pickuppayingmethod == 4 || $restaurant->pickuppayingmethod == 5 || $restaurant->pickuppayingmethod == 6 || $restaurant->pickuppayingmethod == 7) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function isRestaurantPickup($restaurantid) {
        $restaurant = Restaurant::where('id', '=', $restaurantid)->first();

        if ($restaurant->pickup == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getRestaurantMinimumOrderValue($restaurantid) {
        $restaurant = Restaurant::where('id', '=', $restaurantid)->first();

        return $restaurant->minimumordervalue;
    }

    public function isRestaurantZipcode($restaurantid, $zipcode) {
        $restaurantzipcodes = RestaurantZipcode::where('restaurantid', '=', $restaurantid)->where('zipcode', '=', $zipcode)->count();

        if ($restaurantzipcodes >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getRestaurantDeliveryPrice($restaurantid) {
        $restaurant = Restaurant::where('id', '=', $restaurantid)->first();

        return $restaurant->deliveryprice;
    }

    public function isRestaurantOrderTime($restaurantid) {
        $restaurant = DB::table('restaurant')
            ->select('*')
            ->where('id', '=', $restaurantid)
            ->first();

        $dt = new DateTime("now", new DateTimeZone('Europe/Budapest'));
        $date = $dt->format('Y-m-d');

        $dt = new DateTime("now", new DateTimeZone('Europe/Budapest'));
        $time = $dt->format('H:i:s');

        $dayofweek = date('w', strtotime($date));

        $firstorder = $restaurant->firstorder;

        $lastorder = $restaurant->lastorder;
    
        if ($restaurant->isactive) {
            if ($dayofweek == 1) {
                if ($restaurant->monday == 1) {
                    if ($restaurant->sunday == 1) {
                        $lastclose = $restaurant->sundayclose;
                    } else {
                        $lastclose = null;
                    }

                    $todayopen = $restaurant->mondayopen;
                    $todayclose = $restaurant->mondayclose;

                    if ($restaurant->tuesday == 1) {
                        $nextopen = $restaurant->tuesdayopen;
                    } else {
                        $nextopen = null;
                    }
                } else {
                    return false;
                }
            } else if ($dayofweek == 2) {
                if ($restaurant->tuesday == 1) {
                    if ($restaurant->monday == 1) {
                        $lastclose = $restaurant->mondayclose;
                    } else {
                        $lastclose = null;
                    }

                    $todayopen = $restaurant->tuesdayopen;
                    $todayclose = $restaurant->tuesdayclose;

                    if ($restaurant->wednesday == 1) {
                        $nextopen = $restaurant->wednesdayopen;
                    } else {
                        $nextopen = null;
                    }
                } else {
                    return false;
                }
            } else if ($dayofweek == 3) {
                if ($restaurant->wednesday == 1) {
                    if ($restaurant->tuesday == 1) {
                        $lastclose = $restaurant->tuesdayclose;
                    } else {
                        $lastclose = null;
                    }

                    $todayopen = $restaurant->wednesdayopen;
                    $todayclose = $restaurant->wednesdayclose;

                    if ($restaurant->thursday == 1) {
                        $nextopen = $restaurant->thursdayopen;
                    } else {
                        $nextopen = null;
                    }
                } else {
                    return false;
                }
            } else if ($dayofweek == 4) {
                if ($restaurant->thursday == 1) {
                    if ($restaurant->wednesday == 1) {
                        $lastclose = $restaurant->wednesdayclose;
                    } else {
                        $lastclose = null;
                    }

                    $todayopen = $restaurant->thursdayopen;
                    $todayclose = $restaurant->thursdayclose;

                    if ($restaurant->friday == 1) {
                        $nextopen = $restaurant->fridayopen;
                    } else {
                        $nextopen = null;
                    }
                } else {
                    return false;
                }
            } else if ($dayofweek == 5) {
                if ($restaurant->friday == 1) {
                    if ($restaurant->wednesday == 1) {
                        $lastclose = $restaurant->wednesdayclose;
                    } else {
                        $lastclose = null;
                    }

                    $todayopen = $restaurant->fridayopen;
                    $todayclose = $restaurant->fridayclose;

                    if ($restaurant->saturday == 1) {
                        $nextopen = $restaurant->saturdayopen;
                    } else {
                        $nextopen = null;
                    }
                } else {
                    return false;
                }
            } else if ($dayofweek == 6) {
                if ($restaurant->saturday == 1) {
                    if ($restaurant->friday == 1) {
                        $lastclose = $restaurant->fridayclose;
                    } else {
                        $lastclose = null;
                    }

                    $todayopen = $restaurant->saturdayopen;
                    $todayclose = $restaurant->saturdayclose;

                    if ($restaurant->sunday == 1) {
                        $nextopen = $restaurant->sundayopen;
                    } else {
                        $nextopen = null;
                    }
                } else {
                    return false;
                }
            } else if ($dayofweek == 0) {
                if ($restaurant->sunday == 1) {
                    if ($restaurant->saturday == 1) {
                        $lastclose = $restaurant->saturdayclose;
                    } else {
                        $lastclose = null;
                    }

                    $todayopen = $restaurant->sundayopen;
                    $todayclose = $restaurant->sundayclose;

                    if ($restaurant->monday == 1) {
                        $nextopen = $restaurant->mondayopen;
                    } else {
                        $nextopen = null;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }

        $continueopen = false;

        if ($todayopen == "00:00:00" && $lastclose == "00:00:00") {
            $continueopen = true;
        } else {
            if ($firstorder == 5) {
                $DateTime = DateTime::createFromFormat('H:i:s', $todayopen);
                $DateTime->modify('+5 minutes');
                $todayopen = $DateTime->format("H:i:s");
            } else if ($firstorder == 10) {
                $DateTime = DateTime::createFromFormat('H:i:s', $todayopen);
                $DateTime->modify('+10 minutes');
                $todayopen = $DateTime->format("H:i:s");
            } else if ($firstorder == 15) {
                $DateTime = DateTime::createFromFormat('H:i:s', $todayopen);
                $DateTime->modify('+15 minutes');
                $todayopen = $DateTime->format("H:i:s");
            } else if ($firstorder == 20) {
                $DateTime = DateTime::createFromFormat('H:i:s', $todayopen);
                $DateTime->modify('+20 minutes');
                $todayopen = $DateTime->format("H:i:s");
            } else if ($firstorder == 25) {
                $DateTime = DateTime::createFromFormat('H:i:s', $todayopen);
                $DateTime->modify('+25 minutes');
                $todayopen = $DateTime->format("H:i:s");
            } else if ($firstorder == 30) {
                $DateTime = DateTime::createFromFormat('H:i:s', $todayopen);
                $DateTime->modify('+30 minutes');
                $todayopen = $DateTime->format("H:i:s");
            } else if ($firstorder == 35) {
                $DateTime = DateTime::createFromFormat('H:i:s', $todayopen);
                $DateTime->modify('+35 minutes');
                $todayopen = $DateTime->format("H:i:s");
            } else if ($firstorder == 40) {
                $DateTime = DateTime::createFromFormat('H:i:s', $todayopen);
                $DateTime->modify('+40 minutes');
                $todayopen = $DateTime->format("H:i:s");
            } else if ($firstorder == 45) {
                $DateTime = DateTime::createFromFormat('H:i:s', $todayopen);
                $DateTime->modify('+45 minutes');
                $todayopen = $DateTime->format("H:i:s");
            } else if ($firstorder == 50) {
                $DateTime = DateTime::createFromFormat('H:i:s', $todayopen);
                $DateTime->modify('+50 minutes');
                $todayopen = $DateTime->format("H:i:s");
            } else if ($firstorder == 55) {
                $DateTime = DateTime::createFromFormat('H:i:s', $todayopen);
                $DateTime->modify('+55 minutes');
                $todayopen = $DateTime->format("H:i:s");
            } else if ($firstorder == 60) {
                $DateTime = DateTime::createFromFormat('H:i:s', $todayopen);
                $DateTime->modify('+60 minutes');
                $todayopen = $DateTime->format("H:i:s");
            } else {
                $DateTime = DateTime::createFromFormat('H:i:s', $todayopen);
                $todayopen = $DateTime->format("H:i:s");
            }
        }


        $continueclose = false;
        if ($todayclose == "00:00:00" && $nextopen == "00:00:00") {
            $continueclose == true;
        } else {
                if ($lastorder == 0) {
                    $DateTime = DateTime::createFromFormat('H:i:s', $todayclose);
                    $todayclose = $DateTime->format("H:i:s");
                } else if ($lastorder == "-5") {
                    $DateTime = DateTime::createFromFormat('H:i:s', $todayclose);
                    $DateTime->modify('-5 minutes');
                    $todayclose = $DateTime->format("H:i:s");
                } else if ($lastorder == "-10") {
                    $DateTime = DateTime::createFromFormat('H:i:s', $todayclose);
                    $DateTime->modify('-10 minutes');
                    $todayclose = $DateTime->format("H:i:s");
                } else if ($lastorder == "-15") {
                    $DateTime = DateTime::createFromFormat('H:i:s', $todayclose);
                    $DateTime->modify('-15 minutes');
                    $todayclose = $DateTime->format("H:i:s");
                } else if ($lastorder == "-20") {
                    $DateTime = DateTime::createFromFormat('H:i:s', $todayclose);
                    $DateTime->modify('-20 minutes');
                    $todayclose = $DateTime->format("H:i:s");
                } else if ($lastorder == "-25") {
                    $DateTime = DateTime::createFromFormat('H:i:s', $todayclose);
                    $DateTime->modify('-25 minutes');
                    $todayclose = $DateTime->format("H:i:s");
                } else if ($lastorder == "-30") {
                    $DateTime = DateTime::createFromFormat('H:i:s', $todayclose);
                    $DateTime->modify('-30 minutes');
                    $todayclose = $DateTime->format("H:i:s");
                } else if ($lastorder == "-35") {
                    $DateTime = DateTime::createFromFormat('H:i:s', $todayclose);
                    $DateTime->modify('-35 minutes');
                    $todayclose = $DateTime->format("H:i:s");
                } else if ($lastorder == "-40") {
                    $DateTime = DateTime::createFromFormat('H:i:s', $todayclose);
                    $DateTime->modify('-40 minutes');
                    $todayclose = $DateTime->format("H:i:s");
                } else if ($lastorder == "-45") {
                    $DateTime = DateTime::createFromFormat('H:i:s', $todayclose);
                    $DateTime->modify('-45 minutes');
                    $todayclose = $DateTime->format("H:i:s");
                } else if ($lastorder == "-50") {
                    $DateTime = DateTime::createFromFormat('H:i:s', $todayclose);
                    $DateTime->modify('-50 minutes');
                    $todayclose = $DateTime->format("H:i:s");
                } else if ($lastorder == "-55") {
                    $DateTime = DateTime::createFromFormat('H:i:s', $todayclose);
                    $DateTime->modify('-55 minutes');
                    $todayclose = $DateTime->format("H:i:s");
                } else if ($lastorder == "-60") {
                    $DateTime = DateTime::createFromFormat('H:i:s', $todayclose);
                    $DateTime->modify('-60 minutes');
                    $todayclose = $DateTime->format("H:i:s");
                } else {
                    $DateTime = DateTime::createFromFormat('H:i:s', $todayclose);
                    $todayclose = $DateTime->format("H:i:s");
                }
        }


        if ($todayclose == "00:00:00") {
            $DateTime = DateTime::createFromFormat('H:i:s', "23:59:59");
            $todayclose = $DateTime->format("H:i:s");
        }


        if ($continueclose && $continueopen) {
            return true;
        } else if ($continueopen && !$continueclose) {
            if ($time <= $todayclose) {
                return true;
            } else {
                return false;
            }
        } else if (!$continueopen && $continueclose) {
            if ($time >= $todayopen) {
                return true;
            } else {
                return false;
            }
        } else {
            if ($time >= $todayopen && $time <= $todayclose) {
                return true;
            } else {
                return false;
            }
        }

    }

    public function isRestaurantReservationTime($restaurantid, $date, $time) {
        $restaurant = DB::table('restaurant')
            ->select('*')
            ->where('id', '=', $restaurantid)
            ->first();

        $d = DateTime::createFromFormat('Y-m-d', $date);
        $date = $d->format('Y-m-d');

        $t = DateTime::createFromFormat('H:i', $time);
        $time = $t->format('H:i:s');

        $dayofweek = date('w', strtotime($date));

        $firstorder = $restaurant->firstorder;

        $lastorder = $restaurant->lastorder;
    
        if ($restaurant->isactive) {
            if ($dayofweek == 1) {
                if ($restaurant->monday == 1) {
                    if ($restaurant->sunday == 1) {
                        $lastclose = $restaurant->sundayclose;
                    } else {
                        $lastclose = null;
                    }

                    $todayopen = $restaurant->mondayopen;
                    $todayclose = $restaurant->mondayclose;

                    if ($restaurant->tuesday == 1) {
                        $nextopen = $restaurant->tuesdayopen;
                    } else {
                        $nextopen = null;
                    }
                } else {
                    return false;
                }
            } else if ($dayofweek == 2) {
                if ($restaurant->tuesday == 1) {
                    if ($restaurant->monday == 1) {
                        $lastclose = $restaurant->mondayclose;
                    } else {
                        $lastclose = null;
                    }

                    $todayopen = $restaurant->tuesdayopen;
                    $todayclose = $restaurant->tuesdayclose;

                    if ($restaurant->wednesday == 1) {
                        $nextopen = $restaurant->wednesdayopen;
                    } else {
                        $nextopen = null;
                    }
                } else {
                    return false;
                }
            } else if ($dayofweek == 3) {
                if ($restaurant->wednesday == 1) {
                    if ($restaurant->tuesday == 1) {
                        $lastclose = $restaurant->tuesdayclose;
                    } else {
                        $lastclose = null;
                    }

                    $todayopen = $restaurant->wednesdayopen;
                    $todayclose = $restaurant->wednesdayclose;

                    if ($restaurant->thursday == 1) {
                        $nextopen = $restaurant->thursdayopen;
                    } else {
                        $nextopen = null;
                    }
                } else {
                    return false;
                }
            } else if ($dayofweek == 4) {
                if ($restaurant->thursday == 1) {
                    if ($restaurant->wednesday == 1) {
                        $lastclose = $restaurant->wednesdayclose;
                    } else {
                        $lastclose = null;
                    }

                    $todayopen = $restaurant->thursdayopen;
                    $todayclose = $restaurant->thursdayclose;

                    if ($restaurant->friday == 1) {
                        $nextopen = $restaurant->fridayopen;
                    } else {
                        $nextopen = null;
                    }
                } else {
                    return false;
                }
            } else if ($dayofweek == 5) {
                if ($restaurant->friday == 1) {
                    if ($restaurant->wednesday == 1) {
                        $lastclose = $restaurant->wednesdayclose;
                    } else {
                        $lastclose = null;
                    }

                    $todayopen = $restaurant->fridayopen;
                    $todayclose = $restaurant->fridayclose;

                    if ($restaurant->saturday == 1) {
                        $nextopen = $restaurant->saturdayopen;
                    } else {
                        $nextopen = null;
                    }
                } else {
                    return false;
                }
            } else if ($dayofweek == 6) {
                if ($restaurant->saturday == 1) {
                    if ($restaurant->friday == 1) {
                        $lastclose = $restaurant->fridayclose;
                    } else {
                        $lastclose = null;
                    }

                    $todayopen = $restaurant->saturdayopen;
                    $todayclose = $restaurant->saturdayclose;

                    if ($restaurant->sunday == 1) {
                        $nextopen = $restaurant->sundayopen;
                    } else {
                        $nextopen = null;
                    }
                } else {
                    return false;
                }
            } else if ($dayofweek == 0) {
                if ($restaurant->sunday == 1) {
                    if ($restaurant->saturday == 1) {
                        $lastclose = $restaurant->saturdayclose;
                    } else {
                        $lastclose = null;
                    }

                    $todayopen = $restaurant->sundayopen;
                    $todayclose = $restaurant->sundayclose;

                    if ($restaurant->monday == 1) {
                        $nextopen = $restaurant->mondayopen;
                    } else {
                        $nextopen = null;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }

        if ($nextopen == "00:00:00" && $todayclose == "00:00:00") {
            $DateTime = DateTime::createFromFormat('H:i:s', $todayclose);
            $todayclose = $DateTime->format("H:i:s");
        } else {
            if ($todayclose == "00:00:00" || $todayclose > "23:00:00" || $todayclose < "01:00:00") {
                $DateTime = DateTime::createFromFormat('H:i:s', $todayclose);
                $todayclose = $DateTime->format("H:i:s");
            } else {
                $DateTime = DateTime::createFromFormat('H:i:s', $todayclose);
                $DateTime->modify('-1 hour');
                $todayclose = $DateTime->format("H:i:s");
            }
        }

        if ($time >= $todayopen && $time <= $todayclose) {
            return true;
        } else {
            return false;
        }

    }

    public function isRestaurantReservationAvailable($restaurantid) {
        $restaurant = DB::table('restaurant')
            ->select('isreservation')
            ->where('id', '=', $restaurantid)
            ->first();

        if ($restaurant->isreservation) {
            return true;
        } else {
            return false;
        }
    }

    public function isValidCustomer($customerid)
    {
        $customer = DB::table('customer')
            ->where('id', '=', $customerid)
            ->where('email_verified_at', '!=', NULL)
            ->where('phone', '!=', NULL)
            ->where('isbanned', '=', 0)
            ->where('city', '!=', NULL)
            ->where('country', '!=', NULL)
            ->where('zipcode', '!=', NULL)
            ->where('address', '!=', NULL)
            ->count();
        
        if ($customer === 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getRestaurantReservationNotificationCount($restaurantid) {
        $dt = new DateTime("now", new DateTimeZone('Europe/Budapest'));
        $date = $dt->format('Y-m-d');

        $dt = new DateTime("now", new DateTimeZone('Europe/Budapest'));
        $time = $dt->format('H:i:s');

        $restauranttoday = DB::table('reservation')
            ->where('restaurantid', '=', $restaurantid)
            ->where('confirmed', '=', 0)
            ->where('date', '=', $date)
            ->where('time', '>=', $time)
            ->count();

        $restaurant = DB::table('reservation')
            ->where('restaurantid', '=', $restaurantid)
            ->where('confirmed', '=', 0)
            ->where('date', '>', $date)
            ->count();

            return $restaurant + $restauranttoday;
    }

    public function getRestaurantOrderNotificationCount($restaurantid) {
        $restaurant = DB::table('order')
            ->where('restaurant_id', '=', $restaurantid)
            ->where('is_accepted', '=', 0)
            ->where('is_final_order', '=', 1)
            ->count();

            return $restaurant;
    }

}