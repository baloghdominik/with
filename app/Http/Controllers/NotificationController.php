<?php

namespace App\Http\Controllers;

use App\NotificationDTO;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;

use App\Http\Services\RestaurantService;

class NotificationController extends Controller
{
    public $successStatus = 200;

    //save new reservation to db
    public function update($id, RestaurantService $RestaurantService)
    {
        $restaurantid = $id;

        if(!$RestaurantService->isRestaurant($restaurantid)) {
            return response()->json(['error'=>"Az étterem nem található."], 400); 
        }

        //ORDER
        $notificationdto = new NotificationDTO;
        $notificationdto->reservation = $RestaurantService->getRestaurantReservationNotificationCount($restaurantid);
        $notificationdto->order = $RestaurantService->getRestaurantOrderNotificationCount($restaurantid);
   
        return response()->json($notificationdto, 200); 
    }


}