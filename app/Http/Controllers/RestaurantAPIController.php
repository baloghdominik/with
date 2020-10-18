<?php

namespace App\Http\Controllers;

use App\Restaurant;
use App\RestaurantListDTO;
use App\RestaurantZipcode;
use App\Http\Services\RestaurantService;
use Illuminate\Support\Facades\DB;

class RestaurantAPIController extends Controller
{

    public function getRestaurantById($id) {
        $restaurant = Restaurant::where('id', $id)->first();

        return response()->json($restaurant, 200);
    }

    public function getRestaurantIdBylowercasename($lowercasename) {
        $restaurant = Restaurant::where('lowercasename', $lowercasename)->select('id')->first();

        return response()->json($restaurant, 200);
    }

    public function getAllRestaurantIds() {
        $restaurant = Restaurant::select('id')->get();

        return response()->json($restaurant, 200);
    }

    public function getAllRestaurants() {
        $restaurant = Restaurant::select('*')->get();

        return response()->json($restaurant, 200); 
    }

    public function getAllRestaurantsNearByZipcode($zipcode, RestaurantService $RestaurantService) {
        $restaurantZipcodes = RestaurantZipcode::with('restaurant')->where('zipcode', $zipcode)->select('*')->get();

        $restaurant = new Restaurant;
        $restaurant = $restaurantZipcodes;

        $restaurantList = array();
       
        foreach ($restaurant as $res) {
            $restaurantListDTO = new RestaurantListDTO;
            $restaurantListDTO->name = $res->restaurant->name;
            $id = $res->restaurant->id;
            $name = $res->restaurant->name;
            $restaurantListDTO->logo = "https://admin.with.hu/images/logos/with.hu_".$id."_".$name."_logo.jpg";
            $restaurantListDTO->banner = "https://admin.with.hu/images/banners/with.hu_".$id."_".$name."_banner.jpg";
            $restaurantListDTO->lowercasename = $res->restaurant->lowercasename;
            $restaurantListDTO->isopen = $RestaurantService->isRestaurantOrderTime($id);
            switch ($res->restaurant->deliverypayingmethod) {
                case 1:
                    $restaurantListDTO->description = "Készpénz";
                    break;
                case 2:
                    $restaurantListDTO->description = "Bankkártya";
                    break;
                case 3:
                    $restaurantListDTO->description = "SimplePay";
                    break;
                case 4:
                    $restaurantListDTO->description = "Készpénz, Bankkártya";
                    break;
                case 5:
                    $restaurantListDTO->description = "Készpénz, SimplePay";
                    break;
                case 6:
                    $restaurantListDTO->description = "SimplePay, Bankkártya";
                    break;
                case 7:
                    $restaurantListDTO->description = "SimplePay, Bankkártya, Készpénz";
                    break;
            }
            if ($res->restaurant->delivery == 1 && $res->restaurant->pickup == 1) {
                $restaurantListDTO->deliveryoptions = "Házhozszállítás, Helyszíni átvétel";
            } else if ($res->restaurant->pickup == 1) {
                $restaurantListDTO->deliveryoptions = "Helyszíni átvétel";
            } else {
                $restaurantListDTO->deliveryoptions = "Házhozszállítás";
            }
            $plustime = $res->restaurant->deliverytime + 10;
            $restaurantListDTO->deliverytime = $res->restaurant->deliverytime ."-". $plustime." perc";
            if ($res->restaurant->deliveryprice == 0) {
                $restaurantListDTO->deliveryprice = "Ingyenes";
            } else {
                $restaurantListDTO->deliveryprice = number_format($res->restaurant->deliveryprice,0,",",".")."Ft";
            }
            $restaurantListDTO->minorddrvalue = number_format($res->restaurant->minimumordervalue,0,",",".")."Ft";

            array_push($restaurantList, $restaurantListDTO);
        }
    
        return response()->json($restaurantList, 200); 
    }

    public function getAllRestaurantsNearByGEO($latitude, $longitude, RestaurantService $RestaurantService) {
        $url = "https://reverse.geocoder.ls.hereapi.com/6.2/reversegeocode.json?prox=".urlencode($latitude).urlencode(", ").urlencode($longitude)."&mode=retrieveAddresses&maxresults=1&additionaldata=IncludeShapeLevel%2CpostalCode&gen=9&apiKey=42UMNM8taZv6Ou2mukwM1svlc7qjJPkJCj16l46O0_M";
        $result_string = @file_get_contents($url);

        if ($result_string !== FALSE) {
            $result = json_decode($result_string, true);
            if (!isset($result["Response"]["View"][0]["Result"][0]['Location']['Address']['PostalCode'])){
                $result = [];
                return response()->json($result, 200);
            }
            $result=$result["Response"]["View"][0]["Result"][0]['Location']['Address']['PostalCode'];

            $zipcode = $result;

            $restaurantZipcodes = RestaurantZipcode::with('restaurant')->where('zipcode', $zipcode)->select('*')->get();

            $restaurant = new Restaurant;
            $restaurant = $restaurantZipcodes;

            $restaurantList = array();
        
            foreach ($restaurant as $res) {
                $restaurantListDTO = new RestaurantListDTO;
                $restaurantListDTO->name = $res->restaurant->name;
                $id = $res->restaurant->id;
                $name = $res->restaurant->name;
                $restaurantListDTO->logo = "https://admin.with.hu/images/logos/with.hu_".$id."_".$name."_logo.jpg";
                $restaurantListDTO->banner = "https://admin.with.hu/images/banners/with.hu_".$id."_".$name."_banner.jpg";
                $restaurantListDTO->lowercasename = $res->restaurant->lowercasename;
                $restaurantListDTO->isopen = $RestaurantService->isRestaurantOrderTime($id);
                switch ($res->restaurant->deliverypayingmethod) {
                    case 1:
                        $restaurantListDTO->description = "Készpénz";
                        break;
                    case 2:
                        $restaurantListDTO->description = "Bankkártya";
                        break;
                    case 3:
                        $restaurantListDTO->description = "SimplePay";
                        break;
                    case 4:
                        $restaurantListDTO->description = "Készpénz, Bankkártya";
                        break;
                    case 5:
                        $restaurantListDTO->description = "Készpénz, SimplePay";
                        break;
                    case 6:
                        $restaurantListDTO->description = "SimplePay, Bankkártya";
                        break;
                    case 7:
                        $restaurantListDTO->description = "SimplePay, Bankkártya, Készpénz";
                        break;
                }
                if ($res->restaurant->delivery == 1 && $res->restaurant->pickup == 1) {
                    $restaurantListDTO->deliveryoptions = "Házhozszállítás, Helyszíni átvétel";
                } else if ($res->restaurant->pickup == 1) {
                    $restaurantListDTO->deliveryoptions = "Helyszíni átvétel";
                } else {
                    $restaurantListDTO->deliveryoptions = "Házhozszállítás";
                }
                $plustime = $res->restaurant->deliverytime + 10;
                $restaurantListDTO->deliverytime = $res->restaurant->deliverytime ."-". $plustime." perc";
                if ($res->restaurant->deliveryprice == 0) {
                    $restaurantListDTO->deliveryprice = "Ingyenes";
                } else {
                    $restaurantListDTO->deliveryprice = number_format($res->restaurant->deliveryprice,0,",",".")."Ft";
                }
                $restaurantListDTO->minorddrvalue = number_format($res->restaurant->minimumordervalue,0,",",".")."Ft";

                array_push($restaurantList, $restaurantListDTO);
            }

            return response()->json($restaurantList, 200); 
        } else {
            $result = [];
            return response()->json($result, 400);
        }
    }

    public function getRestaurantLogoById($id) {
        $restaurant = Restaurant::where('id', $id)->first();

        $pic = getenv('APP_URL')."/public/images/logos/with.hu_".$restaurant->id."_".$restaurant->name."_logo.jpg";

        return response()->json($pic, 200);
    }

}