<?php

namespace App\Http\Controllers;

use App\Restaurant;
use App\RestaurantListDTO;
use App\RestaurantZipcode;
use App\RestaurantDTO;
use App\CategoryDTO;
use App\RestaurantZipcodeDTO;
use App\Http\Services\RestaurantService;
use Illuminate\Support\Facades\DB;

class RestaurantAPIController extends Controller
{

    public function getRestaurantById($id) {
        $restaurant = Restaurant::where('id', $id)->first();

        if ($restaurant === null) {
            return response()->json("Not found", 404);
        }

        return response()->json($restaurant, 200);
    }

    public function getRestaurantIdBylowercasename($lowercasename) {
        $restaurant = Restaurant::where('lowercasename', $lowercasename)->select('id')->first();

        if ($restaurant === null) {
            return response()->json("Not found", 404);
        }

        $id = $restaurant->id;

        return response()->json($id, 200);
    }

    public function getAllRestaurantIds() {
        $restaurant = Restaurant::select('id')->get();

        if ($restaurant === null) {
            return response()->json("Not found", 404);
        }

        return response()->json($restaurant, 200);
    }

    public function getAllRestaurants() {
        $restaurant = Restaurant::select('*')->get();

        if ($restaurant === null) {
            return response()->json("Not found", 404);
        }

        return response()->json($restaurant, 200); 
    }

    public function getAllRestaurantsNearByZipcode($zipcode, RestaurantService $RestaurantService) {
        $restaurantZipcodes = RestaurantZipcode::with('restaurant')->where('zipcode', $zipcode)->select('*')->get();

        if ($restaurantZipcodes === null) {
            return response()->json("Not found", 404);
        }

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

            if ($restaurantZipcodes === null) {
                return response()->json("Not found", 404);
            }

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

        if ($restaurant === null) {
            return response()->json("Not found", 404);
        }

        $pic = getenv('APP_URL')."/public/images/logos/with.hu_".$restaurant->id."_".$restaurant->name."_logo.jpg";

        return response()->json($pic, 200);
    }

    public function getRestaurantAlldataById($id, RestaurantService $RestaurantService) {
        $restaurant = Restaurant::with('zipcodes')->with('categories')->where('id', $id)->first();

        if ($restaurant === null) {
            return response()->json("Not found", 404);
        }

        $restaurantDTO = new RestaurantDTO;
        $restaurantDTO->restaurantid = $restaurant->id;
        $restaurantDTO->restaurantname = $restaurant->name;
        $restaurantDTO->lowercasename = $restaurant->lowercasename;
        $restaurantDTO->restaurantname = $restaurant->name;
        $restaurantDTO->restaurantaddress = $restaurant->address;
        if ($restaurant->address != NULL && strlen($restaurant->address) > 10) {
            $restaurantDTO->mapembed = "https://maps.google.com/maps?q=". rawurlencode($restaurant->address) ."&t=&z=13&ie=UTF8&iwloc=&output=embed";
        } else {
            $restaurantDTO->mapembed = NULL;
        }
        $restaurantDTO->restaurantphone = $restaurant->phone;
        $restaurantDTO->restaurantemail = $restaurant->email;
        $restaurantDTO->restaurantfacebook = $restaurant->facebook;
        if ($restaurant->facebook != NULL && strlen($restaurant->facebook) > 20) {
            $restaurantDTO->facebookembed = $restaurant->facebook;
        } else {
            $restaurantDTO->facebookembed = NULL;
        }
        $restaurantDTO->restaurantdescription = $restaurant->description;
        if ($restaurant->monday) {
            $restaurantDTO->monday = date('H:i', strtotime($restaurant->mondayopen))." - ".date('H:i', strtotime($restaurant->mondayclose));
        } else {
            $restaurantDTO->monday = "Zárva";
        }
        if ($restaurant->tuesday) {
            $restaurantDTO->tuesday = date('H:i', strtotime($restaurant->tuesdayopen))." - ".date('H:i', strtotime($restaurant->tuesdayclose));
        } else {
            $restaurantDTO->tuesday = "Zárva";
        }
        if ($restaurant->wednesday) {
            $restaurantDTO->wednesday = date('H:i', strtotime($restaurant->wednesdayopen))." - ".date('H:i', strtotime($restaurant->wednesdayclose));
        } else {
            $restaurantDTO->wednesday = "Zárva";
        }
        if ($restaurant->thursday) {
            $restaurantDTO->thursday = date('H:i', strtotime($restaurant->thursdayopen))." - ".date('H:i', strtotime($restaurant->thursdayclose));
        } else {
            $restaurantDTO->thursday = "Zárva";
        }
        if ($restaurant->friday) {
            $restaurantDTO->friday = date('H:i', strtotime($restaurant->fridayopen))." - ".date('H:i', strtotime($restaurant->fridayclose));
        } else {
            $restaurantDTO->friday = "Zárva";
        }
        if ($restaurant->saturday) {
            $restaurantDTO->saturday = date('H:i', strtotime($restaurant->saturdayopen))." - ".date('H:i', strtotime($restaurant->saturdayclose));
        } else {
            $restaurantDTO->saturday = "Zárva";
        }
        if ($restaurant->sunday) {
            $restaurantDTO->sunday = date('H:i', strtotime($restaurant->sundayopen))." - ".date('H:i', strtotime($restaurant->sundayclose));
        } else {
            $restaurantDTO->sunday = "Zárva";
        }

        if ($restaurant->delivery == 1) {
            $restaurantDTO->isdeliveryavailable = true;
        } else {
            $restaurantDTO->isdeliveryavailable = false;
        }

        if ($restaurant->pickup == 1) {
            $restaurantDTO->ispickupavailable = true;
        } else {
            $restaurantDTO->ispickupavailable = false;
        }

        $restaurantDTO->minimumordervalue = $restaurant->minimumordervalue;
        $restaurantDTO->deliveryprice = $restaurant->deliveryprice;

        $restaurantDTO->potentialdeliverytime = ($restaurant->deliverytime - 10). "-" .($restaurant->deliverytime + 10). " perc";

        if ($restaurant->szepcard == 1) {
            $restaurantDTO->isszepcard = true;
        } else {
            $restaurantDTO->isszepcard = false;
        }

        $restaurantDTO->isrestaurantopenfororders = $RestaurantService->isRestaurantOrderTime($id);

        if ($restaurant->pizzadesigner == 1) {
            $restaurantDTO->ispizzadesigneravailable = true;
        } else {
            $restaurantDTO->ispizzadesigneravailable = false;
        }

        if ($restaurant->isreservation == 1) {
            $restaurantDTO->istablereservationavailable = true;
        } else {
            $restaurantDTO->istablereservationavailable = false;
        }

        $restaurantDTO->logo = getenv('APP_URL')."/images/logos/with.hu_".$restaurant->id."_".$restaurant->lowercasename."_logo.jpg";

        $restaurantDTO->banner = getenv('APP_URL')."/images/banners/with.hu_".$restaurant->id."_".$restaurant->lowercasename."_banner.jpg";

        $restaurantDTO->img1 = getenv('APP_URL')."/images/galleries/with.hu_".$restaurant->id."_".$restaurant->lowercasename."_pic1.jpg";
        $restaurantDTO->img2 = getenv('APP_URL')."/images/galleries/with.hu_".$restaurant->id."_".$restaurant->lowercasename."_pic2.jpg";
        $restaurantDTO->img3 = getenv('APP_URL')."/images/galleries/with.hu_".$restaurant->id."_".$restaurant->lowercasename."_pic3.jpg";
        $restaurantDTO->img4 = getenv('APP_URL')."/images/galleries/with.hu_".$restaurant->id."_".$restaurant->lowercasename."_pic4.jpg";
        $restaurantDTO->img5 = getenv('APP_URL')."/images/galleries/with.hu_".$restaurant->id."_".$restaurant->lowercasename."_pic5.jpg";

        $restaurantDTO->img6 = getenv('APP_URL')."/images/galleries/with.hu_".$restaurant->id."_".$restaurant->lowercasename."_pic6.jpg";
        if (!file_exists($restaurantDTO->img6)) {
            $restaurantDTO->img6 = getenv('APP_URL')."/images/notfound/gallery_default.jpg";
        }

        foreach ($restaurant->zipcodes as $zip) {
            $restaurantZipcodeDTO = new restaurantZipcodeDTO;
            $restaurantZipcodeDTO->zipcode = $zip->zipcode;
            $restaurantDTO->zipcodes[] = $restaurantZipcodeDTO;
        }

        foreach ($restaurant->categories as $cat) {
            $categoryDTO = new CategoryDTO;
            $categoryDTO->id = $cat->id;
            $categoryDTO->category = $cat->category;
            $restaurantDTO->categories[] = $categoryDTO;
        }

        return response()->json($restaurantDTO, 200);
    }

}