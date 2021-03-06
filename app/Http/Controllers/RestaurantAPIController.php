<?php

namespace App\Http\Controllers;

use App\Restaurant;
use App\RestaurantListDTO;
use App\RestaurantZipcode;
use App\RestaurantDTO;
use App\CategoryDTO;
use App\RestaurantZipcodeDTO;
use App\ProductDTO;
use App\ProductExtrasDTO;
use App\ProductSidesDTO;
use App\ProductDrinksDTO;
use App\Meal;
use App\Side;
use App\Drink;
use App\Menu;
use App\DrinkToMenu;
use App\SideToMenu;
use App\Extra;
use App\Category;
use App\PizzadesignerBase;
use App\PizzadesignerDough;
use App\PizzadesignerSauce;
use App\PizzadesignerSize;
use App\PizzadesignerTopping;
use App\PizzadesignerDTO;
use App\PizzadesignerSizeDTO;
use App\PizzadesignerBaseDTO;
use App\PizzadesignerDoughDTO;
use App\PizzadesignerSauceDTO;
use App\PizzadesignerToppingsDTO;
use App\PizzadesignerToppingDTO;
use App\Zipcode;
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
            $name = $res->restaurant->lowercasename;
            if (file_exists(public_path()."/images/logos/with.hu_".$id."_".$name."_logo.jpg")) {
                $restaurantListDTO->logo = getenv('APP_URL')."/images/logos/with.hu_".$id."_".$name."_logo.jpg";
            } else {
                $restaurantListDTO->logo = getenv('APP_URL')."/images/notfound/logo_default.jpg";;
            }
    
            if (file_exists(public_path()."/images/banners/big/with.hu_".$id."_".$name."_banner.jpg")) {
                $restaurantListDTO->banner = getenv('APP_URL')."/images/banners/big/with.hu_".$id."_".$name."_banner.jpg";
            } else {
                $restaurantListDTO->banner = getenv('APP_URL')."/images/notfound/cover_default.jpg";
            }
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
                $name = $res->restaurant->lowercasename;
                if (file_exists(public_path()."/images/logos/with.hu_".$id."_".$name."_logo.jpg")) {
                    $restaurantListDTO->logo = getenv('APP_URL')."/images/logos/with.hu_".$id."_".$name."_logo.jpg";
                } else {
                    $restaurantListDTO->logo = getenv('APP_URL')."/images/notfound/logo_default.jpg";;
                }

                if (file_exists(public_path()."/images/banners/big/with.hu_".$id."_".$name."_banner.jpg")) {
                    $restaurantListDTO->banner = getenv('APP_URL')."/images/banners/big/with.hu_".$id."_".$name."_banner.jpg";
                } else {
                    $restaurantListDTO->banner = getenv('APP_URL')."/images/notfound/cover_default.jpg";
                }
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
            return response()->json($result, 404);
        }
    }

    public function getLocationByGEO($latitude, $longitude) {
        $url = "https://reverse.geocoder.ls.hereapi.com/6.2/reversegeocode.json?prox=".urlencode($latitude).urlencode(", ").urlencode($longitude)."&mode=retrieveAddresses&maxresults=1&additionaldata=IncludeShapeLevel%2CpostalCode&gen=9&apiKey=42UMNM8taZv6Ou2mukwM1svlc7qjJPkJCj16l46O0_M";
        $result_string = @file_get_contents($url);

        if ($result_string !== FALSE) {
            $result = json_decode($result_string, true);
            if (!isset($result["Response"]["View"][0]["Result"][0]['Location']['Address']['PostalCode'])){
                return response()->json("Not found", 404);
            }
            $result=$result["Response"]["View"][0]["Result"][0]['Location']['Address']['PostalCode'];

            $postalcode = $result;

            $Zipcode = Zipcode::where('zipcode', $postalcode)->select('city', 'zipcode')->get();

            if ($Zipcode === null) {
                return response()->json("Not found", 404);
            }
            
            return response()->json($Zipcode, 200); 
        } else {
            return response()->json("Not found", 404);
        }
    }

    public function getLocationByZip($zipcode) {
        if ($zipcode === null) {
            return response()->json("Not found", 404);
        }

        $postalcode = $zipcode;

        $Zipcode = Zipcode::where('zipcode', $postalcode)->select('city', 'zipcode')->get();

        if ($Zipcode === null) {
            return response()->json("Not found", 404);
        }
        
        return response()->json($Zipcode, 200); 
    }

    public function getRestaurantLogoById($id) {
        $restaurant = Restaurant::where('id', $id)->first();

        if ($restaurant === null) {
            return response()->json("Not found", 404);
        }

        if (file_exists(public_path()."/images/logos/with.hu_".$restaurant->id."_".$restaurant->lowercasename."_logo.jpg")) {
            $pic = getenv('APP_URL')."/images/logos/with.hu_".$restaurant->id."_".$restaurant->lowercasename."_logo.jpg";
        } else {
            $pic = getenv('APP_URL')."/images/notfound/logo_default.jpg";;
        }

        return response()->json($pic, 200);
    }

    public function getRestaurantAlldataById($type, $id, RestaurantService $RestaurantService) {

        if ($type == "id") {
            $restaurant = Restaurant::with('zipcodes')->with('categories')->where('id', $id)->first();
        } else if ($type = "lowercasename") {
            $restaurant = Restaurant::with('zipcodes')->with('categories')->where('lowercasename', $id)->first();
            $id = $restaurant->id;
        } else {
            return response()->json("Invalid ID", 404);
        }

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

        switch ($restaurant->deliverypayingmethod) {
            case 1:
                $restaurantDTO->iscash = true;
                $restaurantDTO->isbankcard = false;
                $restaurantDTO->isonlinepayment = false;
                break;
            case 2:
                $restaurantDTO->iscash = false;
                $restaurantDTO->isbankcard = true;
                $restaurantDTO->isonlinepayment = false;
                break;
            case 3:
                $restaurantDTO->iscash = false;
                $restaurantDTO->isbankcard = false;
                $restaurantDTO->isonlinepayment = true;
                break;
            case 4:
                $restaurantDTO->iscash = true;
                $restaurantDTO->isbankcard = true;
                $restaurantDTO->isonlinepayment = false;
                break;
            case 5:
                $restaurantDTO->iscash = true;
                $restaurantDTO->isbankcard = false;
                $restaurantDTO->isonlinepayment = true;
                break;
            case 6:
                $restaurantDTO->iscash = false;
                $restaurantDTO->isbankcard = true;
                $restaurantDTO->isonlinepayment = true;
                break;
            case 7:
                $restaurantDTO->iscash = true;
                $restaurantDTO->isbankcard = true;
                $restaurantDTO->isonlinepayment = true;
                break;
        }

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

        if (file_exists(public_path()."/images/logos/with.hu_".$restaurant->id."_".$restaurant->lowercasename."_logo.jpg")) {
            $restaurantDTO->logo = getenv('APP_URL')."/images/logos/with.hu_".$restaurant->id."_".$restaurant->lowercasename."_logo.jpg";
        } else {
            $restaurantDTO->logo = getenv('APP_URL')."/images/notfound/logo_default.jpg";;
        }

        if (file_exists(public_path()."/images/banners/with.hu_".$restaurant->id."_".$restaurant->lowercasename."_banner.jpg")) {
            $restaurantDTO->banner = getenv('APP_URL')."/images/banners/with.hu_".$restaurant->id."_".$restaurant->lowercasename."_banner.jpg";
        } else {
            $restaurantDTO->banner = getenv('APP_URL')."/images/notfound/banner_default.jpg";
        }

        if (file_exists(public_path()."/images/galleries/with.hu_".$restaurant->id."_".$restaurant->lowercasename."_pic1.jpg")) {
            $restaurantDTO->img1 = getenv('APP_URL')."/images/galleries/with.hu_".$restaurant->id."_".$restaurant->lowercasename."_pic1.jpg";
        } else {
            $restaurantDTO->img1 = getenv('APP_URL')."/images/notfound/gallery_default.jpg";
        }

        if (file_exists(public_path()."/images/galleries/with.hu_".$restaurant->id."_".$restaurant->lowercasename."_pic2.jpg")) {
            $restaurantDTO->img2 = getenv('APP_URL')."/images/galleries/with.hu_".$restaurant->id."_".$restaurant->lowercasename."_pic2.jpg";
        } else {
            $restaurantDTO->img2 = getenv('APP_URL')."/images/notfound/gallery_default.jpg";
        }

        if (file_exists(public_path()."/images/galleries/with.hu_".$restaurant->id."_".$restaurant->lowercasename."_pic3.jpg")) {
            $restaurantDTO->img3 = getenv('APP_URL')."/images/galleries/with.hu_".$restaurant->id."_".$restaurant->lowercasename."_pic3.jpg";
        } else {
            $restaurantDTO->img3 = getenv('APP_URL')."/images/notfound/gallery_default.jpg";
        }
        if (file_exists(public_path()."/images/galleries/with.hu_".$restaurant->id."_".$restaurant->lowercasename."_pic4.jpg")) {
            $restaurantDTO->img4 = getenv('APP_URL')."/images/galleries/with.hu_".$restaurant->id."_".$restaurant->lowercasename."_pic4.jpg";
        } else {
            $restaurantDTO->img4 = getenv('APP_URL')."/images/notfound/gallery_default.jpg";
        }

        if (file_exists(public_path()."/images/galleries/with.hu_".$restaurant->id."_".$restaurant->lowercasename."_pic5.jpg")) {
            $restaurantDTO->img5 = getenv('APP_URL')."/images/galleries/with.hu_".$restaurant->id."_".$restaurant->lowercasename."_pic5.jpg";
        } else {
            $restaurantDTO->img5 = getenv('APP_URL')."/images/notfound/gallery_default.jpg";
        }

        if (file_exists(public_path()."/images/galleries/with.hu_".$restaurant->id."_".$restaurant->lowercasename."_pic6.jpg")) {
            $restaurantDTO->img6 = getenv('APP_URL')."/images/galleries/with.hu_".$restaurant->id."_".$restaurant->lowercasename."_pic6.jpg";
        } else {
            $restaurantDTO->img6 = getenv('APP_URL')."/images/notfound/gallery_default.jpg";
        }

        foreach ($restaurant->zipcodes as $zip) {
            $restaurantZipcodeDTO = new restaurantZipcodeDTO;
            $restaurantZipcodeDTO->zipcode = $zip->zipcode;
            $restaurantZipcodeDTO->city = $zip->zip->city;
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

    public function getRestaurantProductsByCategory($id, $categoryid) {
        $category = Category::with('restaurant')->where('id', $categoryid)->where('restaurantid', $id)->select('*')->first();

        if ($category === null) {
            return response()->json("Not found", 404);
        }

        $restaurant = $category->restaurant;

        $today = date('w', strtotime(date("Y-m-d")));

        $products = array();

        //meals
        $meals = Meal::with('extras')->where('restaurantid', $restaurant->id)->where('category', $category->id)->where('available', 1)->where('available_separately', 1)->select('*')->get();        

        foreach ($meals as $item) {
            if ($today == 0 && $item->sunday == 1 || 
                $today == 1 && $item->monday == 1 || 
                $today == 2 && $item->tuesday == 1 || 
                $today == 3 && $item->wednesday == 1 || 
                $today == 4 && $item->thirsday == 1 || 
                $today == 5 && $item->friday == 1 || 
                $today == 6 && $item->saturday == 1) {
                
                $productDTO = new ProductDTO;
                $productDTO->type = "meal";
                $productDTO->id = $item->id;
                $productDTO->name = $item->name;

                if (file_exists(public_path()."/images/meals/".$item->picid.".jpg")) {
                    $productDTO->image = getenv('APP_URL')."/images/meals/".$item->picid.".jpg";
                } else {
                    $productDTO->image = getenv('APP_URL')."/images/notfound/product_default.jpg";
                }

                if ($item->sale) {
                    $productDTO->is_sale = true;
                    $productDTO->price = $item->saleprice;
                    $productDTO->old_price = $item->price;
                } else {
                    $productDTO->is_sale = false;
                    $productDTO->price = $item->price;
                    $productDTO->old_price = NULL;
                }

                $productDTO->category_id = $item->category;
                $productDTO->category_name = $category->category;

                if ($restaurant->showdescription && strlen($item->description) > 3) {
                    if ($item->description !== NULL && $item->description !== "NULL") {
                        $productDTO->description = $item->description;    
                    } else {
                        $productDTO->description = NULL;
                    }
                } else {
                    $productDTO->description = NULL;
                }

                if ($restaurant->showcalories && strlen($item->calorie) > 3) {
                    if ($item->calorie !== NULL && $item->calorie !== "NULL") {
                        $productDTO->calories = $item->calorie." kalória";    
                    } else {
                        $productDTO->calorie = NULL;
                    }
                } else {
                    $productDTO->calorie = NULL;
                }

                if ($restaurant->showspecifications) {
                    if ($item->vegan) {
                        $productDTO->is_vegan = true;
                    } else {
                        $productDTO->is_vegan = false;
                    }

                    if ($item->vegetarian) {
                        $productDTO->is_vegetarian = true;
                    } else {
                        $productDTO->is_vegetarian = false;
                    }

                    if ($item->glutenfree) {
                        $productDTO->is_glutenfree = true;
                    } else {
                        $productDTO->is_glutenfree = false;
                    }

                    if ($item->lactosefree) {
                        $productDTO->is_lactosefree = true;
                    } else {
                        $productDTO->is_lactosefree = false;
                    }

                    if ($item->fatfree) {
                        $productDTO->is_fatfree = true;
                    } else {
                        $productDTO->is_fatfree = false;
                    }

                    if ($item->sugarfree) {
                        $productDTO->is_sugarfree= true;
                    } else {
                        $productDTO->sugarfree = false;
                    }

                    if ($item->allergenicfree) {
                        $productDTO->is_allergenicfree = true;
                    } else {
                        $productDTO->is_allergenicfree = false;
                    }

                    if ($item->alcoholfree) {
                        $productDTO->is_alcoholfree = true;
                    } else {
                        $productDTO->is_alcoholfree = false;
                    }
                } else {
                    $productDTO->is_vegan = false;
                    $productDTO->is_vegetarian = false;
                    $productDTO->is_glutenfree = false;
                    $productDTO->is_lactosefree = false;
                    $productDTO->is_fatfree = false;
                    $productDTO->sugarfree = false;
                    $productDTO->is_allergenicfree = false;
                    $productDTO->is_alcoholfree = false;
                }

                if ($item->size > 0) {
                    $productDTO->size = $item->size;
                } else {
                    $productDTO->size = NULL;
                }

                if ($item->extralimit > 0 && $item->extralimit < 25) {
                    $productDTO->extralimit = $item->extralimit;
                } else {
                    $productDTO->extralimit = 0;
                }

                //extras
                $extras = array();

                if ($productDTO->extralimit > 0) {
                    foreach ($item->extras as $extra) {
                        $productExtrasDTO = new ProductExtrasDTO;
                        $productExtrasDTO->product_id = $item->id;
                        $productExtrasDTO->id = $extra->id;
                        $productExtrasDTO->name = $extra->name;
                        $productExtrasDTO->price = $extra->price;

                        array_push($extras, $productExtrasDTO);
                    }
                }

                $productDTO->extras = $extras;

                //sides
                $sides = array();

                $productDTO->sides = $sides;

                //drinks
                $drinks = array();

                $productDTO->drinks = $drinks;

                array_push($products, $productDTO);
            }
        }

        //sides
        $sides = Side::where('restaurantid', $restaurant->id)->where('category', $category->id)->where('available', 1)->where('available_separately', 1)->select('*')->get();        

        foreach ($sides as $item) {
            if ($today == 0 && $item->sunday == 1 || 
                $today == 1 && $item->monday == 1 || 
                $today == 2 && $item->tuesday == 1 || 
                $today == 3 && $item->wednesday == 1 || 
                $today == 4 && $item->thirsday == 1 || 
                $today == 5 && $item->friday == 1 || 
                $today == 6 && $item->saturday == 1) {
                
                $productDTO = new ProductDTO;
                $productDTO->type = "side";
                $productDTO->id = $item->id;
                $productDTO->name = $item->name;

                if (file_exists(public_path()."/images/sides/".$item->picid.".jpg")) {
                    $productDTO->image = getenv('APP_URL')."/images/sides/".$item->picid.".jpg";
                } else {
                    $productDTO->image = getenv('APP_URL')."/images/notfound/product_default.jpg";
                }

                if ($item->sale) {
                    $productDTO->is_sale = true;
                    $productDTO->price = $item->saleprice;
                    $productDTO->old_price = $item->price;
                } else {
                    $productDTO->is_sale = false;
                    $productDTO->price = $item->price;
                    $productDTO->old_price = NULL;
                }

                $productDTO->category_id = $item->category;
                $productDTO->category_name = $category->category;

                if ($restaurant->showdescription && strlen($item->description) > 3) {
                    if ($item->description !== NULL && $item->description !== "NULL") {
                        $productDTO->description = $item->description;    
                    } else {
                        $productDTO->description = NULL;
                    }
                } else {
                    $productDTO->description = NULL;
                }

                if ($restaurant->showcalories && strlen($item->calorie) > 3) {
                    if ($item->calorie !== NULL && $item->calorie !== "NULL") {
                        $productDTO->calories = $item->calorie." kalória";    
                    } else {
                        $productDTO->calorie = NULL;
                    }
                } else {
                    $productDTO->calorie = NULL;
                }

                if ($restaurant->showspecifications) {
                    if ($item->vegan) {
                        $productDTO->is_vegan = true;
                    } else {
                        $productDTO->is_vegan = false;
                    }

                    if ($item->vegetarian) {
                        $productDTO->is_vegetarian = true;
                    } else {
                        $productDTO->is_vegetarian = false;
                    }

                    if ($item->glutenfree) {
                        $productDTO->is_glutenfree = true;
                    } else {
                        $productDTO->is_glutenfree = false;
                    }

                    if ($item->lactosefree) {
                        $productDTO->is_lactosefree = true;
                    } else {
                        $productDTO->is_lactosefree = false;
                    }

                    if ($item->fatfree) {
                        $productDTO->is_fatfree = true;
                    } else {
                        $productDTO->is_fatfree = false;
                    }

                    if ($item->sugarfree) {
                        $productDTO->is_sugarfree= true;
                    } else {
                        $productDTO->sugarfree = false;
                    }

                    if ($item->allergenicfree) {
                        $productDTO->is_allergenicfree = true;
                    } else {
                        $productDTO->is_allergenicfree = false;
                    }

                    if ($item->alcoholfree) {
                        $productDTO->is_alcoholfree = true;
                    } else {
                        $productDTO->is_alcoholfree = false;
                    }
                } else {
                    $productDTO->is_vegan = false;
                    $productDTO->is_vegetarian = false;
                    $productDTO->is_glutenfree = false;
                    $productDTO->is_lactosefree = false;
                    $productDTO->is_fatfree = false;
                    $productDTO->sugarfree = false;
                    $productDTO->is_allergenicfree = false;
                    $productDTO->is_alcoholfree = false;
                }

                if ($item->size > 0) {
                    $productDTO->size = $item->size;
                } else {
                    $productDTO->size = NULL;
                }

                if ($item->extralimit > 0 && $item->extralimit < 25) {
                    $productDTO->extralimit = $item->extralimit;
                } else {
                    $productDTO->extralimit = 0;
                }

                //extras
                $extras = array();

                $productDTO->extras = $extras;

                //sides
                $sides = array();

                $productDTO->sides = $sides;

                //drinks
                $drinks = array();

                $productDTO->drinks = $drinks;

                array_push($products, $productDTO);
            }
        }

        //drinks
        $drinks = Drink::where('restaurantid', $restaurant->id)->where('category', $category->id)->where('available', 1)->where('available_separately', 1)->select('*')->get();        

        foreach ($drinks as $item) {
            if ($today == 0 && $item->sunday == 1 || 
                $today == 1 && $item->monday == 1 || 
                $today == 2 && $item->tuesday == 1 || 
                $today == 3 && $item->wednesday == 1 || 
                $today == 4 && $item->thirsday == 1 || 
                $today == 5 && $item->friday == 1 || 
                $today == 6 && $item->saturday == 1) {
                
                $productDTO = new ProductDTO;
                $productDTO->type = "drink";
                $productDTO->id = $item->id;
                $productDTO->name = $item->name;

                if (file_exists(public_path()."/images/drinks/".$item->picid.".jpg")) {
                    $productDTO->image = getenv('APP_URL')."/images/drinks/".$item->picid.".jpg";
                } else {
                    $productDTO->image = getenv('APP_URL')."/images/notfound/product_default.jpg";
                }

                if ($item->sale) {
                    $productDTO->is_sale = true;
                    $productDTO->price = $item->saleprice;
                    $productDTO->old_price = $item->price;
                } else {
                    $productDTO->is_sale = false;
                    $productDTO->price = $item->price;
                    $productDTO->old_price = NULL;
                }

                $productDTO->category_id = $item->category;
                $productDTO->category_name = $category->category;

                if ($restaurant->showdescription && strlen($item->description) > 3) {
                    if ($item->description !== NULL && $item->description !== "NULL") {
                        $productDTO->description = $item->description;    
                    } else {
                        $productDTO->description = NULL;
                    }
                } else {
                    $productDTO->description = NULL;
                }

                if ($restaurant->showcalories && strlen($item->calorie) > 3) {
                    if ($item->calorie !== NULL && $item->calorie !== "NULL") {
                        $productDTO->calories = $item->calorie." kalória";    
                    } else {
                        $productDTO->calorie = NULL;
                    }
                } else {
                    $productDTO->calorie = NULL;
                }

                if ($restaurant->showspecifications) {
                    if ($item->vegan) {
                        $productDTO->is_vegan = true;
                    } else {
                        $productDTO->is_vegan = false;
                    }

                    if ($item->vegetarian) {
                        $productDTO->is_vegetarian = true;
                    } else {
                        $productDTO->is_vegetarian = false;
                    }

                    if ($item->glutenfree) {
                        $productDTO->is_glutenfree = true;
                    } else {
                        $productDTO->is_glutenfree = false;
                    }

                    if ($item->lactosefree) {
                        $productDTO->is_lactosefree = true;
                    } else {
                        $productDTO->is_lactosefree = false;
                    }

                    if ($item->fatfree) {
                        $productDTO->is_fatfree = true;
                    } else {
                        $productDTO->is_fatfree = false;
                    }

                    if ($item->sugarfree) {
                        $productDTO->is_sugarfree= true;
                    } else {
                        $productDTO->sugarfree = false;
                    }

                    if ($item->allergenicfree) {
                        $productDTO->is_allergenicfree = true;
                    } else {
                        $productDTO->is_allergenicfree = false;
                    }

                    if ($item->alcoholfree) {
                        $productDTO->is_alcoholfree = true;
                    } else {
                        $productDTO->is_alcoholfree = false;
                    }
                } else {
                    $productDTO->is_vegan = false;
                    $productDTO->is_vegetarian = false;
                    $productDTO->is_glutenfree = false;
                    $productDTO->is_lactosefree = false;
                    $productDTO->is_fatfree = false;
                    $productDTO->sugarfree = false;
                    $productDTO->is_allergenicfree = false;
                    $productDTO->is_alcoholfree = false;
                }

                if ($item->size > 0) {
                    $productDTO->size = $item->size;
                } else {
                    $productDTO->size = NULL;
                }

                if ($item->extralimit > 0 && $item->extralimit < 25) {
                    $productDTO->extralimit = $item->extralimit;
                } else {
                    $productDTO->extralimit = 0;
                }

                //extras
                $extras = array();

                $productDTO->extras = $extras;

                //sides
                $sides = array();

                $productDTO->sides = $sides;

                //drinks
                $drinks = array();

                $productDTO->drinks = $drinks;

                array_push($products, $productDTO);
            }
        }

        //menus
        $menus = Menu::with('meal')->with('sides')->with('drinks')->where('restaurantid', $restaurant->id)->where('category', $category->id)->where('enable', 1)->select('*')->get();        

        foreach ($menus as $item) {

            if ($today == 0 && $item->meal->sunday == 1 || 
                    $today == 1 && $item->meal->monday == 1 || 
                    $today == 2 && $item->meal->tuesday == 1 || 
                    $today == 3 && $item->meal->wednesday == 1 || 
                    $today == 4 && $item->meal->thirsday == 1 || 
                    $today == 5 && $item->meal->friday == 1 || 
                    $today == 6 && $item->meal->saturday == 1) {
                if ($item->meal->available == 1) {

                    $productDTO = new ProductDTO;
                    $productDTO->type = "menu";
                    $productDTO->id = $item->id;
                    $productDTO->name = $item->name;

                    if (file_exists(public_path()."/images/menus/".$item->picid.".jpg")) {
                        $productDTO->image = getenv('APP_URL')."/images/menus/".$item->picid.".jpg";
                    } else {
                        $productDTO->image = getenv('APP_URL')."/images/notfound/product_default.jpg";
                    }

                    if ($item->meal->sale) {
                        $productDTO->is_sale = true;
                        $productDTO->old_price = $item->meal->price;

                        if ($item->menusalepercent > 0 && $item->menusalepercent < 91 && $item->meal->saleprice > 0) {
                            $price = $item->meal->saleprice;
                            $price = ($price / 100) * (100 - $item->menusalepercent);
                            $price = round($price);
                        } else {
                            $price = $item->meal->saleprice;
                        }

                        $productDTO->price = $price;
                    } else {
                        if ($item->menusalepercent > 0 && $item->menusalepercent < 91 && $item->meal->price > 0) {
                            $price = $item->meal->price;
                            $price = ($price / 100) * (100 - $item->menusalepercent);
                            $productDTO->is_sale = true;
                            $productDTO->old_price = $item->meal->price;
                            $price = round($price);
                        } else {
                            $price = $item->meal->price;
                            $productDTO->is_sale = false;
                            $productDTO->old_price = NULL;
                        }
                    }

                    $productDTO->category_id = $item->category;
                    $productDTO->category_name = $category->category;

                    if ($restaurant->showdescription && strlen($item->meal->description) > 3) {
                        if ($item->meal->description !== NULL && $item->meal->description !== "NULL") {
                            $productDTO->description = $item->meal->description;    
                        } else {
                            $productDTO->description = NULL;
                        }
                    } else {
                        $productDTO->description = NULL;
                    }

                    if ($restaurant->showcalories && strlen($item->meal->calorie) > 3) {
                        if ($item->meal->calorie !== NULL && $item->meal->calorie !== "NULL") {
                            $productDTO->calories = $item->meal->calorie." kalória";    
                        } else {
                            $productDTO->calorie = NULL;
                        }
                    } else {
                        $productDTO->calorie = NULL;
                    }

                    if ($restaurant->showspecifications) {
                        if ($item->meal->vegan) {
                            $productDTO->is_vegan = true;
                        } else {
                            $productDTO->is_vegan = false;
                        }

                        if ($item->meal->vegetarian) {
                            $productDTO->is_vegetarian = true;
                        } else {
                            $productDTO->is_vegetarian = false;
                        }

                        if ($item->meal->glutenfree) {
                            $productDTO->is_glutenfree = true;
                        } else {
                            $productDTO->is_glutenfree = false;
                        }

                        if ($item->meal->lactosefree) {
                            $productDTO->is_lactosefree = true;
                        } else {
                            $productDTO->is_lactosefree = false;
                        }

                        if ($item->meal->fatfree) {
                            $productDTO->is_fatfree = true;
                        } else {
                            $productDTO->is_fatfree = false;
                        }

                        if ($item->meal->sugarfree) {
                            $productDTO->is_sugarfree= true;
                        } else {
                            $productDTO->sugarfree = false;
                        }

                        if ($item->meal->allergenicfree) {
                            $productDTO->is_allergenicfree = true;
                        } else {
                            $productDTO->is_allergenicfree = false;
                        }

                        if ($item->meal->alcoholfree) {
                            $productDTO->is_alcoholfree = true;
                        } else {
                            $productDTO->is_alcoholfree = false;
                        }
                    } else {
                        $productDTO->is_vegan = false;
                        $productDTO->is_vegetarian = false;
                        $productDTO->is_glutenfree = false;
                        $productDTO->is_lactosefree = false;
                        $productDTO->is_fatfree = false;
                        $productDTO->sugarfree = false;
                        $productDTO->is_allergenicfree = false;
                        $productDTO->is_alcoholfree = false;
                    }

                    if ($item->meal->size > 0) {
                        $productDTO->size = $item->meal->size;
                    } else {
                        $productDTO->size = NULL;
                    }

                    if ($item->meal->extralimit > 0 && $item->meal->extralimit < 25) {
                        $productDTO->extralimit = $item->meal->extralimit;
                    } else {
                        $productDTO->extralimit = 0;
                    }

                    //extras
                    $extras = array();

                    if ($productDTO->extralimit > 0) {
                        foreach ($item->meal->extras as $extra) {
                            $productExtrasDTO = new ProductExtrasDTO;
                            $productExtrasDTO->product_id = $item->id;
                            $productExtrasDTO->id = $extra->id;
                            $productExtrasDTO->name = $extra->name;
                            $productExtrasDTO->price = $extra->price;

                            array_push($extras, $productExtrasDTO);
                        }
                    }

                    $productDTO->extras = $extras;

                    //sides
                    $sides = array();

                    foreach ($item->sides as $side) {
                        if ($today == 0 && $side->side->sunday == 1 || 
                            $today == 1 && $side->side->monday == 1 || 
                            $today == 2 && $side->side->tuesday == 1 || 
                            $today == 3 && $side->side->wednesday == 1 || 
                            $today == 4 && $side->side->thirsday == 1 || 
                            $today == 5 && $side->side->friday == 1 || 
                            $today == 6 && $side->side->saturday == 1) {
                        if ($side->side->available == 1) {
                                $productSidesDTO = new ProductSidesDTO;
                                $productSidesDTO->product_id = $item->id;
                                $productSidesDTO->id = $side->side->id;

                                if (file_exists(public_path()."/images/sides/".$side->side->picid.".jpg")) {
                                    $productSidesDTO->image = getenv('APP_URL')."/images/sides/".$side->side->picid.".jpg";
                                } else {
                                    $productSidesDTO->image = getenv('APP_URL')."/images/notfound/product_default.jpg";
                                }

                                $productSidesDTO->name = $side->side->name;

                                if ($side->side->sale) {
                                    $side_price = $side->side->saleprice;
                                } else {
                                    $side_price = $side->side->price;
                                }

                                $productSidesDTO->price = $side_price;

                                array_push($sides, $productSidesDTO);
                            }
                        }
                    }

                    $productDTO->sides = $sides;

                    //drinks
                    $drinks = array();

                    foreach ($item->drinks as $drink) {
                        if ($today == 0 && $drink->drink->sunday == 1 || 
                            $today == 1 && $drink->drink->monday == 1 || 
                            $today == 2 && $drink->drink->tuesday == 1 || 
                            $today == 3 && $drink->drink->wednesday == 1 || 
                            $today == 4 && $drink->drink->thirsday == 1 || 
                            $today == 5 && $drink->drink->friday == 1 || 
                            $today == 6 && $drink->drink->saturday == 1) {
                        if ($drink->drink->available == 1) {
                                $productDrinksDTO = new ProductDrinksDTO;
                                $productDrinksDTO->product_id = $item->id;
                                $productDrinksDTO->id = $drink->drink->id;

                                if (file_exists(public_path()."/images/drinks/".$drink->drink->picid.".jpg")) {
                                    $productDrinksDTO->image = getenv('APP_URL')."/images/drinks/".$drink->drink->picid.".jpg";
                                } else {
                                    $productDrinksDTO->image = getenv('APP_URL')."/images/notfound/product_default.jpg";
                                }

                                $productDrinksDTO->name = $drink->drink->name;

                                if ($drink->drink->sale) {
                                    $drink_price = $drink->drink->saleprice;
                                } else {
                                    $drink_price = $drink->drink->price;
                                }

                                $productDrinksDTO->price = $drink_price;

                                array_push($drinks, $productDrinksDTO);
                            }
                        }
                    }
                    
                    $productDTO->drinks = $drinks;

                    if (count($productDTO->drinks) > 0 && count($productDTO->sides) > 0) {
                        array_push($products, $productDTO);
                    }
                }
            }

            //sorting products into abc order
            usort($products, function($a, $b) {return strcmp($a->name, $b->name);});

        }

        return response()->json($products, 200);
    }

    public function getRestaurantPizzaDesigner($id) {
        $restaurant = Restaurant::where('id', $id)->select('*')->first();

        if ($restaurant === null) {
            return response()->json("Not found", 404);
        }

        if ($restaurant->pizzadesigner == 0) {
            $pizzadesignerDTO = new PizzadesignerDTO;
            $pizzadesignerDTO->available = false;
            $pizzadesignerDTO->sizes = array();
        } else {
            $pizzadesignerDTO = new PizzadesignerDTO;
            $pizzadesignerDTO->available = true;
            $isempty = false;

            $pizzadesignerSize = PizzadesignerSize::where('restaurantid', $restaurant->id)->select('*')->get();

            $sizes = array();

            foreach ($pizzadesignerSize as $size) {
                $pizzadesignerSizeDTO = new PizzadesignerSizeDTO;
                $pizzadesignerSizeDTO->id = $size->id;
                $pizzadesignerSizeDTO->size = $size->size;
                $pizzadesignerSizeDTO->price = $size->price;
                $pizzadesignerSizeDTO->maxtoppings = $size->toppingslimit;
                $pizzadesignerSizeDTO->illustration = getenv('APP_URL')."/images/pizzadesigner/pizza_base.png";

                // bases
                $pizzadesignerBase = PizzadesignerBase::where('restaurantid', $restaurant->id)->where('sizeid', $size->id)->select('*')->get();
                $bases = array();
                foreach ($pizzadesignerBase as $base) {
                    $pizzadesignerBaseDTO = new PizzadesignerBaseDTO;
                    $pizzadesignerBaseDTO->id = $base->id;
                    $pizzadesignerBaseDTO->name = $base->name;
                    $pizzadesignerBaseDTO->price = $base->price;
                    if ($base->art !== NULL && file_exists(public_path()."/images/pizzadesigner/".$base->art.".png")) {
                        $pizzadesignerBaseDTO->illustration = getenv('APP_URL')."/images/pizzadesigner/".$base->art.".png";
                    } else {
                        $pizzadesignerBaseDTO->illustration = getenv('APP_URL')."/images/pizzadesigner/transparent.png";
                    }

                    array_push($bases, $pizzadesignerBaseDTO);
                }
                if (count($bases) > 0) {
                    //sorting products into abc order
                    usort($bases, function($a, $b) {return strcmp($a->name, $b->name);});

                    $pizzadesignerSizeDTO->bases = $bases;
                } else {
                    $isempty = true;
                }

                // toppings
                $meats = array();
                $cheeses = array();
                $vegetables = array();
                $fruits = array();
                $others = array();
                $pizzadesignerTopping = PizzadesignerTopping::where('restaurantid', $restaurant->id)->where('sizeid', $size->id)->select('*')->get();
                foreach ($pizzadesignerTopping as $topping) {
                    $pizzadesignerToppingDTO = new PizzadesignerToppingDTO;
                    $pizzadesignerToppingDTO->id = $topping->id;
                    $pizzadesignerToppingDTO->name = $topping->name;
                    $pizzadesignerToppingDTO->price = $topping->price;
                    if ($topping->art !== NULL && file_exists(public_path()."/images/pizzadesigner/".$topping->art.".png")) {
                        $pizzadesignerToppingDTO->illustration = getenv('APP_URL')."/images/pizzadesigner/".$topping->art.".png";
                    } else {
                        $pizzadesignerToppingDTO->illustration = getenv('APP_URL')."/images/pizzadesigner/transparent.png";
                    }

                    if ($topping->category == 1) {
                        array_push($meats, $pizzadesignerToppingDTO);
                    } else if ($topping->category == 2) {
                        array_push($cheeses, $pizzadesignerToppingDTO);
                    } else if ($topping->category == 3) {
                        array_push($vegetables, $pizzadesignerToppingDTO);
                    } else if ($topping->category == 4) {
                        array_push($fruits, $pizzadesignerToppingDTO);
                    } else if ($topping->category == 5) {
                        array_push($others, $pizzadesignerToppingDTO);
                    }
                }

                $pizzadesignerToppingsDTO = new PizzadesignerToppingsDTO;

                //sorting products into abc order
                usort($meats, function($a, $b) {return strcmp($a->name, $b->name);});

                $pizzadesignerToppingsDTO->meats = $meats;

                //sorting products into abc order
                usort($cheeses, function($a, $b) {return strcmp($a->name, $b->name);});

                $pizzadesignerToppingsDTO->cheeses = $cheeses;

                //sorting products into abc order
                usort($vegetables, function($a, $b) {return strcmp($a->name, $b->name);});

                $pizzadesignerToppingsDTO->vegetables = $vegetables;

                //sorting products into abc order
                usort($bases, function($a, $b) {return strcmp($a->fruits, $b->name);});

                $pizzadesignerToppingsDTO->fruits = $fruits;

                //sorting products into abc order
                usort($others, function($a, $b) {return strcmp($a->name, $b->name);});

                $pizzadesignerToppingsDTO->others = $others;

                if ((count($meats) + count($cheeses) + count($vegetables) + count($fruits) + count($others)) > 0) {
                    $pizzadesignerSizeDTO->toppings = $pizzadesignerToppingsDTO;
                } else {
                    $isempty = true;
                }

                // sauces
                $pizzadesignerSauce = PizzadesignerSauce::where('restaurantid', $restaurant->id)->where('sizeid', $size->id)->select('*')->get();
                $sauces = array();
                foreach ($pizzadesignerSauce as $sauce) {
                    $pizzadesignerSauceDTO = new PizzadesignerSauceDTO;
                    $pizzadesignerSauceDTO->id = $sauce->id;
                    $pizzadesignerSauceDTO->name = $sauce->name;
                    $pizzadesignerSauceDTO->price = $sauce->price;
                    if ($sauce->art !== NULL && file_exists(public_path()."/images/pizzadesigner/".$sauce->art.".png")) {
                        $pizzadesignerSauceDTO->illustration = getenv('APP_URL')."/images/pizzadesigner/".$sauce->art.".png";
                    } else {
                        $pizzadesignerSauceDTO->illustration = getenv('APP_URL')."/images/pizzadesigner/transparent.png";
                    }

                    array_push($sauces, $pizzadesignerSauceDTO);
                }

                //sorting products into abc order
                usort($sauces, function($a, $b) {return strcmp($a->name, $b->name);});

                $pizzadesignerSizeDTO->sauces = $sauces;

                // doughs
                $pizzadesignerDough = PizzadesignerDough::where('restaurantid', $restaurant->id)->where('sizeid', $size->id)->select('*')->get();
                $doughs = array();
                foreach ($pizzadesignerDough as $dough) {
                    $pizzadesignerDoughDTO = new PizzadesignerDoughDTO;
                    $pizzadesignerDoughDTO->id = $dough->id;
                    $pizzadesignerDoughDTO->name = $dough->name;
                    $pizzadesignerDoughDTO->price = $dough->price;

                    array_push($doughs, $pizzadesignerDoughDTO);
                }
                if (count($doughs) > 0) {

                    //sorting products into abc order
                    usort($doughs, function($a, $b) {return strcmp($a->name, $b->name);});

                    $pizzadesignerSizeDTO->doughs = $doughs;
                } else {
                    $isempty = true;
                }

                if ((count($meats) + count($cheeses) + count($vegetables) + count($fruits) + count($others)) > 0 && count($doughs) > 0 && count($bases) > 0) {
                    array_push($sizes, $pizzadesignerSizeDTO);
                }
            }

            //sorting products into abc order
            usort($sizes, function($a, $b) {return strcmp($a->size, $b->size);});

            $pizzadesignerDTO->sizes = $sizes;
        }

        if (count($pizzadesignerDTO->sizes) <= 0) {
            $pizzadesignerDTO = new PizzadesignerDTO;
            $pizzadesignerDTO->available = false;
            $pizzadesignerDTO->sizes = array();
        }

        return response()->json($pizzadesignerDTO, 200);
    }
}