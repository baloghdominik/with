<?php

namespace App\Http\Controllers;

use App\Restaurant;
use App\RestaurantZipcode;
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

    public function getAllRestaurantsNearByZipcode($zipcode) {
        $restaurantZipcodes = RestaurantZipcode::with('restaurant')->where('zipcode', $zipcode)->select('*')->get();

        $restaurant = new Restaurant;
        $restaurant = $restaurantZipcodes;

        return response()->json($restaurant, 200); 
    }

    public function getAllRestaurantsNearByGEO($latitude, $longitude) {
        function getLnt($latitude, $longitude) {
            $url = "https://reverse.geocoder.ls.hereapi.com/6.2/reversegeocode.json?prox=".urlencode($latitude).urlencode(", ").urlencode($longitude)."&mode=retrieveAddresses&maxresults=1&additionaldata=IncludeShapeLevel%2CpostalCode&gen=9&apiKey=yY2DiJu_PkZHyO03MAi6GjJ6ORWRQ1J8HerJfp4IroA";
            $result_string = file_get_contents($url);
            $result = json_decode($result_string, true);

            $result[]=$result["Response"]["View"][0]["Result"][0]['Location']['Address']['PostalCode'];

            return $result[0];
        }

        $zipcode = getLnt($latitude, $longitude);

        $restaurantZipcodes = RestaurantZipcode::with('restaurant')->where('zipcode', $zipcode)->select('*')->get();

        $restaurant = new Restaurant;
        $restaurant = $restaurantZipcodes;

        return response()->json($restaurant, 200); 
    }

    public function getRestaurantLogoById($id) {
        $restaurant = Restaurant::where('id', $id)->first();

        $pic = getenv('APP_URL')."/public/images/logos/with.hu_".$restaurant->id."_".$restaurant->name."_logo.jpg";

        return response()->json($pic, 200);
    }

}