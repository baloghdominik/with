<?php

namespace App\Http\Services;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderService
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

    //MEAL
    public function getOrderID($restaurantid, $customerid) {
        $order = DB::table('order')
            ->select('id')
            ->where('restaurant_id', '=', $restaurantid)
            ->where('customer_id', '=', $customerid)
            ->orderBy('id', 'desc')
            ->first();
        
        return $order->id;
    }

    public function isMeal($mealid, $restaurantid) {
        $meal = DB::table('meal')
            ->where('restaurantid', '=', $restaurantid)
            ->where('id', '=', $mealid)
            ->count();
        
        if ($meal === 1) {
            return true;
        } else {
            return false;
        }
    }

    public function isMealAvailable ($mealid, $restaurantid) {
        $meal = DB::table('meal')
            ->select('available', 'available_separately', 'monday', 'tuesday', 'wednesday', 'thirsday', 'friday', 'saturday', 'sunday')
            ->where('restaurantid', '=', $restaurantid)
            ->where('id', '=', $mealid)
            ->first();
        
            $date = date("Y-m-d");
            $dayofweek = date('w', strtotime($date));
    
        if ($meal->available) {
            if ($meal->available_separately) {
                if ($dayofweek == 1) {
                    if ($meal->monday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else if ($dayofweek == 2) {
                    if ($meal->tuesday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else if ($dayofweek == 3) {
                    if ($meal->wednesday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else if ($dayofweek == 4) {
                    if ($meal->thirsday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else if ($dayofweek == 5) {
                    if ($meal->friday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else if ($dayofweek == 6) {
                    if ($meal->saturday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    if ($meal->sunday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getMealPrice($mealid, $restaurantid) {
        $meal = DB::table('meal')
            ->select('price', 'saleprice', 'sale')
            ->where('restaurantid', '=', $restaurantid)
            ->where('id', '=', $mealid)
            ->first();
        
        if ($meal->sale) {
            return $meal->saleprice;
        } else {
            return $meal->price;
        }
    }

    public function getMealMaxExtras($mealid, $restaurantid) {
        $meal = DB::table('meal')
            ->select('extralimit')
            ->where('restaurantid', '=', $restaurantid)
            ->where('id', '=', $mealid)
            ->first();
        
        return $meal->extralimit;
    }

    //MEAL EXTRAS
    public function getOrderMealID($orderid, $mealid) {
        $ordermeal = DB::table('order_meal')
            ->select('id')
            ->where('order_id', '=', $orderid)
            ->where('meal_id', '=', $mealid)
            ->orderBy('id', 'desc')
            ->first();
        
        return $ordermeal->id;
    }

    public function isExtra($extraid, $restaurantid) {
        $extra = DB::table('extra')
            ->where('restaurantid', '=', $restaurantid)
            ->where('id', '=', $extraid)
            ->count();
        
        if ($extra === 1) {
            return true;
        } else {
            return false;
        }
    }

    public function isExtraAvailable($extraid, $mealid, $restaurantid) {
        $extra = DB::table('extra')
            ->where('restaurantid', '=', $restaurantid)
            ->where('id', '=', $extraid)
            ->where('mealid', '=', $mealid)
            ->count();
        
        if ($extra === 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getExtraPrice($extraid, $restaurantid) {
        $extra = DB::table('extra')
            ->select('price')
            ->where('restaurantid', '=', $restaurantid)
            ->where('id', '=', $extraid)
            ->first();
        
        return $extra->price;
    }


    //SIDE
    public function isSide($sideid, $restaurantid) {
        $side = DB::table('side')
            ->where('restaurantid', '=', $restaurantid)
            ->where('id', '=', $sideid)
            ->count();
        
        if ($side === 1) {
            return true;
        } else {
            return false;
        }
    }

    public function isSideAvailable ($sideid, $restaurantid) {
        $side = DB::table('side')
            ->select('available', 'available_separately', 'monday', 'tuesday', 'wednesday', 'thirsday', 'friday', 'saturday', 'sunday')
            ->where('restaurantid', '=', $restaurantid)
            ->where('id', '=', $sideid)
            ->first();
        
            $date = date("Y-m-d");
            $dayofweek = date('w', strtotime($date));
    
        if ($side->available) {
            if ($side->available_separately) {
                if ($dayofweek == 1) {
                    if ($side->monday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else if ($dayofweek == 2) {
                    if ($side->tuesday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else if ($dayofweek == 3) {
                    if ($side->wednesday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else if ($dayofweek == 4) {
                    if ($side->thirsday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else if ($dayofweek == 5) {
                    if ($side->friday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else if ($dayofweek == 6) {
                    if ($side->saturday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    if ($side->sunday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getSidePrice($sideid, $restaurantid) {
        $side = DB::table('side')
            ->select('price', 'saleprice', 'sale')
            ->where('restaurantid', '=', $restaurantid)
            ->where('id', '=', $sideid)
            ->first();
        
        if ($side->sale) {
            return $side->saleprice;
        } else {
            return $side->price;
        }
    }

    //DRINK
    public function isDrink($drinkid, $restaurantid) {
        $drink = DB::table('drink')
            ->where('restaurantid', '=', $restaurantid)
            ->where('id', '=', $drinkid)
            ->count();
        
        if ($drink === 1) {
            return true;
        } else {
            return false;
        }
    }

    public function isDrinkAvailable ($drinkid, $restaurantid) {
        $drink = DB::table('drink')
            ->select('available', 'available_separately', 'monday', 'tuesday', 'wednesday', 'thirsday', 'friday', 'saturday', 'sunday')
            ->where('restaurantid', '=', $restaurantid)
            ->where('id', '=', $drinkid)
            ->first();
        
            $date = date("Y-m-d");
            $dayofweek = date('w', strtotime($date));
    
        if ($drink->available) {
            if ($drink->available_separately) {
                if ($dayofweek == 1) {
                    if ($drink->monday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else if ($dayofweek == 2) {
                    if ($drink->tuesday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else if ($dayofweek == 3) {
                    if ($drink->wednesday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else if ($dayofweek == 4) {
                    if ($drink->thirsday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else if ($dayofweek == 5) {
                    if ($drink->friday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else if ($dayofweek == 6) {
                    if ($drink->saturday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    if ($drink->sunday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getDrinkPrice($drinkid, $restaurantid) {
        $drink = DB::table('drink')
            ->select('price', 'saleprice', 'sale')
            ->where('restaurantid', '=', $restaurantid)
            ->where('id', '=', $drinkid)
            ->first();
        
        if ($drink->sale) {
            return $drink->saleprice;
        } else {
            return $drink->price;
        }
    }

    //MENU

    public function isMenu($menuid, $restaurantid) {
        $menu = DB::table('menu')
            ->where('restaurantid', '=', $restaurantid)
            ->where('id', '=', $menuid)
            ->where('enable', '=', 1)
            ->count();
        
        if ($menu === 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getMealIDFromMenu($menuid, $restaurantid) {
        $menu = DB::table('menu')
            ->select('mealid')
            ->where('restaurantid', '=', $restaurantid)
            ->where('id', '=', $menuid)
            ->first();

        return $menu->mealid;
    }

    public function isMenuSide($menuid, $sideid) {
        $side_to_menu = DB::table('side_to_menu')
            ->where('menuid', '=', $menuid)
            ->where('sideid', '=', $sideid)
            ->count();
        
        if ($side_to_menu === 1) {
            return true;
        } else {
            return false;
        }
    }

    public function isMenuDrink($menuid, $drinkid) {
        $drink_to_menu = DB::table('drink_to_menu')
            ->where('menuid', '=', $menuid)
            ->where('drinkid', '=', $drinkid)
            ->count();
        
        if ($drink_to_menu === 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getMenuSalePercent($menuid, $restaurantid) {
        $menu = DB::table('menu')
            ->select('menusalepercent')
            ->where('restaurantid', '=', $restaurantid)
            ->where('id', '=', $menuid)
            ->first();

        return $menu->menusalepercent;
    }

    public function getOrderMenuID($orderid, $menuid) {
        $ordermenu = DB::table('order_menu')
            ->select('id')
            ->where('order_id', '=', $orderid)
            ->where('menu_id', '=', $menuid)
            ->orderBy('id', 'desc')
            ->first();
        
        return $ordermenu->id;
    }

    public function getMenuID($mealid, $restaurantid) {
        $menu = DB::table('menu')
            ->select('id')
            ->where('restaurantid', '=', $restaurantid)
            ->where('mealid', '=', $mealid)
            ->orderBy('id', 'desc')
            ->first();
        
        return $menu->id;
    }

    public function isMenuDrinkAvailable ($drinkid, $restaurantid) {
        $drink = DB::table('drink')
            ->select('available', 'available_separately', 'monday', 'tuesday', 'wednesday', 'thirsday', 'friday', 'saturday', 'sunday')
            ->where('restaurantid', '=', $restaurantid)
            ->where('id', '=', $drinkid)
            ->first();
        
            $date = date("Y-m-d");
            $dayofweek = date('w', strtotime($date));
    
        if ($drink->available) {
                if ($dayofweek == 1) {
                    if ($drink->monday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else if ($dayofweek == 2) {
                    if ($drink->tuesday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else if ($dayofweek == 3) {
                    if ($drink->wednesday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else if ($dayofweek == 4) {
                    if ($drink->thirsday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else if ($dayofweek == 5) {
                    if ($drink->friday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else if ($dayofweek == 6) {
                    if ($drink->saturday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    if ($drink->sunday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                }
        } else {
            return false;
        }
    }

    public function isMenuSideAvailable ($sideid, $restaurantid) {
        $side = DB::table('side')
            ->select('available', 'available_separately', 'monday', 'tuesday', 'wednesday', 'thirsday', 'friday', 'saturday', 'sunday')
            ->where('restaurantid', '=', $restaurantid)
            ->where('id', '=', $sideid)
            ->first();
        
            $date = date("Y-m-d");
            $dayofweek = date('w', strtotime($date));
    
        if ($side->available) {
                if ($dayofweek == 1) {
                    if ($side->monday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else if ($dayofweek == 2) {
                    if ($side->tuesday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else if ($dayofweek == 3) {
                    if ($side->wednesday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else if ($dayofweek == 4) {
                    if ($side->thirsday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else if ($dayofweek == 5) {
                    if ($side->friday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else if ($dayofweek == 6) {
                    if ($side->saturday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    if ($side->sunday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                }
        } else {
            return false;
        }
    }

    public function isMenuMealAvailable ($mealid, $restaurantid) {
        $meal = DB::table('meal')
            ->select('available', 'available_separately', 'monday', 'tuesday', 'wednesday', 'thirsday', 'friday', 'saturday', 'sunday')
            ->where('restaurantid', '=', $restaurantid)
            ->where('id', '=', $mealid)
            ->first();
        
            $date = date("Y-m-d");
            $dayofweek = date('w', strtotime($date));
    
        if ($meal->available) {
                if ($dayofweek == 1) {
                    if ($meal->monday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else if ($dayofweek == 2) {
                    if ($meal->tuesday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else if ($dayofweek == 3) {
                    if ($meal->wednesday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else if ($dayofweek == 4) {
                    if ($meal->thirsday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else if ($dayofweek == 5) {
                    if ($meal->friday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else if ($dayofweek == 6) {
                    if ($meal->saturday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    if ($meal->sunday == 1) {
                        return true;
                    } else {
                        return false;
                    }
                }
        } else {
            return false;
        }
    }

   //PIZZA

    public function isPizzadesignerAvailable($restaurantid) {
        $restaurant = DB::table('restaurant')
            ->where('id', '=', $restaurantid)
            ->where('pizzadesigner', '=', 1)
            ->count();
        
        if ($restaurant === 1) {
            return true;
        } else {
            return false;
        }
    }

    public function isPizzadesignerSize($pizzadesigner_size_id, $restaurantid) {
        $pizzadesigner_size = DB::table('pizzadesigner_size')
            ->where('restaurantid', '=', $restaurantid)
            ->where('id', '=', $pizzadesigner_size_id)
            ->count();
        
        if ($pizzadesigner_size === 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getPizzadesignerSizePrice($pizzadesigner_size_id, $restaurantid) {
        $pizzadesigner_size = DB::table('pizzadesigner_size')
            ->select('price')
            ->where('restaurantid', '=', $restaurantid)
            ->where('id', '=', $pizzadesigner_size_id)
            ->first();
        
        return $pizzadesigner_size->price;
    }

    public function getPizzadesignerSizeToppingslimit($pizzadesigner_size_id, $restaurantid) {
        $pizzadesigner_size = DB::table('pizzadesigner_size')
            ->select('toppingslimit')
            ->where('restaurantid', '=', $restaurantid)
            ->where('id', '=', $pizzadesigner_size_id)
            ->first();
        
        return $pizzadesigner_size->toppingslimit;
    }

    public function isPizzadesignerBase($pizzadesigner_base_id, $pizzadesigner_size_id, $restaurantid) {
        $pizzadesigner_base = DB::table('pizzadesigner_base')
            ->where('restaurantid', '=', $restaurantid)
            ->where('sizeid', '=', $pizzadesigner_size_id)
            ->where('id', '=', $pizzadesigner_base_id)
            ->count();
        
        if ($pizzadesigner_base === 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getPizzadesignerBasePrice($pizzadesigner_base_id, $restaurantid) {
        $pizzadesigner_base = DB::table('pizzadesigner_base')
            ->select('price')
            ->where('restaurantid', '=', $restaurantid)
            ->where('id', '=', $pizzadesigner_base_id)
            ->first();
        
        return $pizzadesigner_base->price;
    }

    public function isPizzadesignerDough($pizzadesigner_dough_id, $pizzadesigner_size_id, $restaurantid) {
        $pizzadesigner_dough = DB::table('pizzadesigner_dough')
            ->where('restaurantid', '=', $restaurantid)
            ->where('sizeid', '=', $pizzadesigner_size_id)
            ->where('id', '=', $pizzadesigner_dough_id)
            ->count();
        
        if ($pizzadesigner_dough === 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getPizzadesignerDoughPrice($pizzadesigner_dough_id, $restaurantid) {
        $pizzadesigner_dough = DB::table('pizzadesigner_dough')
            ->select('price')
            ->where('restaurantid', '=', $restaurantid)
            ->where('id', '=', $pizzadesigner_dough_id)
            ->first();
        
        return $pizzadesigner_dough->price;
    }

    public function isPizzadesignerTopping($pizzadesigner_topping_id, $pizzadesigner_size_id, $restaurantid) {
        $pizzadesigner_topping = DB::table('pizzadesigner_topping')
            ->where('restaurantid', '=', $restaurantid)
            ->where('sizeid', '=', $pizzadesigner_size_id)
            ->where('id', '=', $pizzadesigner_topping_id)
            ->count();
        
        if ($pizzadesigner_topping === 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getPizzadesignerToppingPrice($pizzadesigner_topping_id, $restaurantid) {
        $pizzadesigner_topping = DB::table('pizzadesigner_topping')
            ->select('price')
            ->where('restaurantid', '=', $restaurantid)
            ->where('id', '=', $pizzadesigner_topping_id)
            ->first();
        
        return $pizzadesigner_topping->price;
    }

    public function isPizzadesignerSauce($pizzadesigner_sauce_id, $pizzadesigner_size_id, $restaurantid) {
        $pizzadesigner_sauce = DB::table('pizzadesigner_sauce')
            ->where('restaurantid', '=', $restaurantid)
            ->where('sizeid', '=', $pizzadesigner_size_id)
            ->where('id', '=', $pizzadesigner_sauce_id)
            ->count();
        
        if ($pizzadesigner_sauce === 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getPizzadesignerSaucePrice($pizzadesigner_sauce_id, $restaurantid) {
        $pizzadesigner_sauce = DB::table('pizzadesigner_sauce')
            ->select('price')
            ->where('restaurantid', '=', $restaurantid)
            ->where('id', '=', $pizzadesigner_sauce_id)
            ->first();
        
        return $pizzadesigner_sauce->price;
    }

    public function getOrderPizzaID($orderid) {
        $orderpizza = DB::table('order_pizza')
            ->select('id')
            ->where('order_id', '=', $orderid)
            ->orderBy('id', 'desc')
            ->first();
        
        return $orderpizza->id;
    }

}