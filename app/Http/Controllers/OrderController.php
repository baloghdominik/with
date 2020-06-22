<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderMeal;
use App\OrderMealExtras;
use App\OrderSide;
use App\OrderDrink;
use App\OrderMenu;
use App\OrderMenuExtras;
use App\OrderPizza;
use App\OrderPizzaSauces;
use App\OrderPizzaToppings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Validator;
use DateTime;
use DateTimeZone;

use App\Http\Services\OrderService;
use App\Http\Services\RestaurantService;
use App\Http\Services\CustomerService;

class OrderController extends Controller
{
    public $successStatus = 200;

    // show - orders
    public function showOrders(){
        $pageConfigs = [
            'pageHeader' => false
        ];

        $restaurantID = Auth::user()->restaurantid;

        $orders = Order::where('restaurant_id', '=', $restaurantID)
        ->where('order.is_final_order', '=', 1)
        ->where('order.is_accepted', '=', 0)
        ->where('order.is_refund_finished', '=', 0)
        ->where('order.is_finished', '=', 0)
        ->orderBy('order.id', 'DESC')
        ->with('customer.orders')
        ->with('orderside.side')
        ->with('orderdrink.drink')
        ->with('ordermeal.meal')
        ->with('ordermenu.meal')
        ->with('ordermenu.side')
        ->with('ordermenu.drink')
        ->with('ordermenu.ordermenuextras')
        ->with('ordermeal.ordermealextras.extra')->get();

        $acceptedorders = Order::where('restaurant_id', '=', $restaurantID)
        ->where('order.is_final_order', '=', 1)
        ->where('order.is_accepted', '=', 1)
        ->where('order.is_refund_finished', '=', 0)
        ->where('order.is_finished', '=', 0)
        ->orderBy('order.id', 'DESC')
        ->with('customer.orders')
        ->with('orderside.side')
        ->with('orderdrink.drink')
        ->with('ordermeal.meal')
        ->with('ordermenu.meal')
        ->with('ordermenu.side')
        ->with('ordermenu.drink')
        ->with('ordermenu.ordermenuextras')
        ->with('ordermeal.ordermealextras.extra')->get();

        $finishedorders = Order::where('restaurant_id', '=', $restaurantID)
        ->where('order.is_final_order', '=', 1)
        ->where('order.is_finished', '=', 1)
        ->orWhere('order.is_refund_finished', '=', 1)
        ->where('order.is_final_order', '=', 1)
        ->orderBy('order.id', 'DESC')
        ->with('customer.orders')
        ->with('orderside.side')
        ->with('orderdrink.drink')
        ->with('ordermeal.meal')
        ->with('ordermenu.meal')
        ->with('ordermenu.side')
        ->with('ordermenu.drink')
        ->with('ordermenu.ordermenuextras')
        ->with('ordermeal.ordermealextras.extra')->get();


        return view('/pages/orders', [
            'pageConfigs' => $pageConfigs, 'orders' => $orders, 'acceptedorders' => $acceptedorders, 'finishedorders' => $finishedorders
        ]);
    }

    public function acceptOrder($id, Request $request) {
        $restaurantid = Auth::user()->restaurantid;

        $order = Order::where('id', '=', $id)->where('restaurant_id', '=', $restaurantid)->first();
        $order->is_accepted = 1;
        $order->save();

        return back()
                ->with('success','Sikeres rendelés felvétel!');
    }

    public function acceptPickupOrder(Request $request) {
        $restaurantid = Auth::user()->restaurantid;

        $validatedData = request()->validate([
            'order_id' => ['required', 'integer', 'min:0'],
            'pickuptime' => ['required', 'integer','min:5','max:200']
        ]);

        $modify = "+".request('pickuptime')." minutes";

        $currentTime = new DateTime("now", new DateTimeZone('Europe/Budapest'));
        $currentTime = $currentTime->format('Y-m-d H:i:s');

        $DateTime = DateTime::createFromFormat('Y-m-d H:i:s', $currentTime);
        $DateTime->modify($modify);
        $pickupTime = $DateTime->format("Y-m-d H:i");

        $order = Order::where('id', '=', request('order_id'))->where('restaurant_id', '=', $restaurantid)->first();
        $order->is_accepted = 1;
        $order->pickuptime = $pickupTime;
        $order->save();

        return back()
                ->with('success','Sikeres rendelés felvétel! Várható átvétel: '.$pickupTime);
    }

    public function doneOrder($id, Request $request) {
        $restaurantid = Auth::user()->restaurantid;

        $dt = new DateTime("now", new DateTimeZone('Europe/Budapest'));
        $datetime = $dt->format('Y-m-d H:i:s');

        $order = Order::where('id', '=', $id)->where('restaurant_id', '=', $restaurantid)->first();
        $order->is_done = 1;
        $order->done_at = $datetime;
        $order->save();

        return back()
                ->with('success','Sikeres állapot frissítés!');
    }

    public function outForDeliveryOrder($id, Request $request) {
        $restaurantid = Auth::user()->restaurantid;

        $dt = new DateTime("now", new DateTimeZone('Europe/Budapest'));
        $datetime = $dt->format('Y-m-d H:i:s');

        $order = Order::where('id', '=', $id)->where('restaurant_id', '=', $restaurantid)->first();
        $order->is_out_for_delivery = 1;
        $order->out_for_delivery_at = $datetime;
        $order->save();

        return back()
                ->with('success','Sikeres állapot frissítés!');
    }

    public function deliveredOrder($id, Request $request) {
        $restaurantid = Auth::user()->restaurantid;

        $dt = new DateTime("now", new DateTimeZone('Europe/Budapest'));
        $datetime = $dt->format('Y-m-d H:i:s');

        $order = Order::where('id', '=', $id)->where('restaurant_id', '=', $restaurantid)->first();
        $order->is_delivered = 1;
        $order->delivered_at = $datetime;
        $order->is_finished = 1;
        $order->finished_at = $datetime;
        $order->save();

        return back()
                ->with('success','Sikeres állapot frissítés!');
    }

    public function finishedOrder($id, Request $request) {
        $restaurantid = Auth::user()->restaurantid;

        $dt = new DateTime("now", new DateTimeZone('Europe/Budapest'));
        $datetime = $dt->format('Y-m-d H:i:s');

        $order = Order::where('id', '=', $id)->where('restaurant_id', '=', $restaurantid)->first();
        $order->is_finished = 1;
        $order->finished_at = $datetime;
        $order->save();

        return back()
                ->with('success','A rendelés sikeresen teljesítve lett!');
    }

    public function startRefundOrder($id, Request $request) {
        $restaurantid = Auth::user()->restaurantid;

        $order = Order::where('id', '=', $id)->where('restaurant_id', '=', $restaurantid)->first();
        $order->is_refund = 1;
        $order->save();

        return back()
                ->with('success','A rendelés vissza lett utasítva!');
    }

    public function finishRefundOrder($id, Request $request) {
        $restaurantid = Auth::user()->restaurantid;

        $order = Order::where('id', '=', $id)->where('restaurant_id', '=', $restaurantid)->first();
        $order->is_refund_finished = 1;
        $order->save();

        return back()
                ->with('success','A rendelés állapota frissült!');
    }

    public function cancelOrder($id, Request $request) {
        $restaurantid = Auth::user()->restaurantid;

        $order = Order::where('id', '=', $id)->where('restaurant_id', '=', $restaurantid)->first();
        $order->is_refund_finished = 1;
        $order->is_refund = 1;
        $order->save();

        return back()
                ->with('success','A rendelés vissza lett utasítva!');
    }

    //save new reservation to db
    public function addOrder(Request $request, OrderService $OrderService, RestaurantService $RestaurantService, CustomerService $CustomerService)
    {
        $validator = Validator::make($request->all(), [ 
            'restaurant_id' => 'integer|min:0',
            'is_delivery' => 'integer|min:0|max:1|required',
            'coupon' => 'string',
            'is_online_payment' => 'integer|min:0|max:1|required',
            'meal.*.meal_id' => 'integer|min:0',
            'meal.*.quantity' => 'integer|min:1',
            'meal.*.extras.*.extra_id' => 'integer',
            'side.*.side_id' => 'integer|min:0',
            'side.*.quantity' => 'integer|min:1',
            'drink.*.drink_id' => 'integer|min:0',
            'drink.*.quantity' => 'integer|min:1',
            'menu.*.meal_id' => 'integer|min:0',
            'menu.*.side_id' => 'integer|min:0',
            'menu.*.drink_id' => 'integer|min:0',
            'menu.*.quantity' => 'integer|min:1',
            'menu.*.extras.*.extra_id' => 'integer',
            'pizza.*.pizzadesigner_base_id' => 'integer|min:0',
            'pizza.*.pizzadesigner_dough_id' => 'integer|min:0',
            'pizza.*.pizzadesigner_size_id' => 'integer|min:0',
            'pizza.*.quantity' => 'integer|min:1',
            'pizza.*.toppings.*.pizzadesigner_topping_id' => 'integer',
            'pizza.*.sauces.*.pizzadesigner_sauce_id' => 'integer'
        ]);

        $customer = Auth::user(); 

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 400);            
        }

        //ORDER
        $order = new Order;
        $order->restaurant_id = request('restaurant_id');
        $restaurantID = request('restaurant_id');
        $order->customer_id = $customer->id;

        if (!$RestaurantService->isValidCustomer($customer->id)) {
            return response()->json(['error'=>"Hibás felhasználó."], 400); 
        }

        $order->is_delivery = request('is_delivery');
        $order->is_online_payment = request('is_online_payment');
        
        if ($order->is_delivery == 1) {
            if(!$RestaurantService->isRestaurantDelivery($restaurantID)) {
                return response()->json(['error'=>"A kiszállítás nem lehetséges ebből az étteremből."], 400); 
            }

            if(!$RestaurantService->isRestaurantDeliveryPayingMethod($restaurantID, $order->is_online_payment)) {
                return response()->json(['error'=>"Ez a fizetési opció nem lehetséges."], 400); 
            }
        } else {
            if(!$RestaurantService->isRestaurantPickup($restaurantID)) {
                return response()->json(['error'=>"A helyszíni átvétel nem lehetséges ebben az étteremben."], 400); 
            }

            if(!$RestaurantService->isRestaurantPickupPayingMethod($restaurantID, $order->is_online_payment)) {
                return response()->json(['error'=>"Ez a fizetési opció nem lehetséges."], 400); 
            }
        }

        $order->coupon = request('coupon');
        $order->is_paid = 0;
        $order->coupon_sale = 0;
        $order->total_price = 0;
        $order->save();

        $margin = 0;


        if(!$RestaurantService->isRestaurant($order->restaurant_id)) {
            return response()->json(['error'=>"Az étterem nem található."], 400); 
        }

        if(!$RestaurantService->isRestaurantOrderTime($order->restaurant_id)) {
            return response()->json(['error'=>"Az étterem zárva van."], 400); 
        }

        $OrderID = $OrderService->getOrderID($order->restaurant_id, $order->customer_id);
        $total_price = 0;

        //MEAL
        for ($i = 0; $i < count($request->get('meal')); $i++) {
            $ordermeal = new OrderMeal;
            $ordermeal->order_id = $OrderID;
            $ordermeal->meal_id = $request->get('meal')[$i]['meal_id'];
            $ordermeal->quantity = $request->get('meal')[$i]['quantity'];

            if(!$OrderService->isMeal($ordermeal->meal_id, $order->restaurant_id)) {
                return response()->json(['error'=>"Nem található termék."], 400); 
            }

            if(!$OrderService->isMealAvailable($ordermeal->meal_id, $order->restaurant_id)) {
                return response()->json(['error'=>"Nem elérhető termék."], 400); 
            }

            if($OrderService->getMealMaxExtras($ordermeal->meal_id, $order->restaurant_id) < count($request->get('meal')[$i]['extras'])) {
                return response()->json(['error'=>"Túl sok extra."], 400); 
            }

            $ordermeal->price = $OrderService->getMealPrice($ordermeal->meal_id, $order->restaurant_id);

            $margin = $margin + $OrderService->getMealMargin($ordermeal->meal_id, $order->restaurant_id) * $ordermeal->quantity;

            $MealPrice = $ordermeal->price;

            $ordermeal->save();

            for ($x = 0; $x < count($request->get('meal')[$i]['extras']); $x++) {
                $ordermealextras = new OrderMealExtras;
                $ordermealextras->extra_id = $request->get('meal')[$i]['extras'][$x]['extra_id'];

                if (!$OrderService->isExtra($ordermealextras->extra_id, $order->restaurant_id)) {
                    return response()->json(['error'=>"Nem található extra."], 400); 
                }

                if (!$OrderService->isExtraAvailable($ordermealextras->extra_id, $ordermeal->meal_id, $order->restaurant_id)) {
                    return response()->json(['error'=>"Nem elérhető extra."], 400); 
                }

                $ordermealextras->price = $OrderService->getExtraPrice($ordermealextras->extra_id, $order->restaurant_id);

                $margin = $margin + $OrderService->getExtraMargin($ordermealextras->extra_id, $order->restaurant_id) * $ordermeal->quantity;

                $ordermealextras->order_meal_id = $OrderService->getOrderMealID($ordermeal->order_id, $ordermeal->meal_id);

                $ordermealextras->save();

                $MealPrice = $MealPrice + $ordermealextras->price;
            }

            $MealPrice = $MealPrice * $ordermeal->quantity;

            $total_price = $total_price + $MealPrice;
        }

        //SIDE
        for ($i = 0; $i < count($request->get('side')); $i++) {
            $orderside = new OrderSide;
            $orderside->order_id = $OrderID;
            $orderside->side_id = $request->get('side')[$i]['side_id'];
            $orderside->quantity = $request->get('side')[$i]['quantity'];

            if(!$OrderService->isSide($orderside->side_id, $order->restaurant_id)) {
                return response()->json(['error'=>"Nem található termék."], 400); 
            }

            if(!$OrderService->isSideAvailable($orderside->side_id, $order->restaurant_id)) {
                return response()->json(['error'=>"Nem elérhető termék."], 400); 
            }

            $orderside->price = $OrderService->getSidePrice($orderside->side_id, $order->restaurant_id);

            $margin = $margin + $OrderService->getSideMargin($orderside->side_id, $order->restaurant_id) * $orderside->quantity;

            $SidePrice = $orderside->price * $orderside->quantity;

            $orderside->save();

            $total_price = $total_price + $SidePrice;
        }

        //DRINK
        for ($i = 0; $i < count($request->get('drink')); $i++) {
            $orderdrink = new OrderDrink;
            $orderdrink->order_id = $OrderID;
            $orderdrink->drink_id = $request->get('drink')[$i]['drink_id'];
            $orderdrink->quantity = $request->get('drink')[$i]['quantity'];

            if(!$OrderService->isDrink($orderdrink->drink_id, $order->restaurant_id)) {
                return response()->json(['error'=>"Nem található termék."], 400); 
            }

            if(!$OrderService->isDrinkAvailable($orderdrink->drink_id, $order->restaurant_id)) {
                return response()->json(['error'=>"Nem elérhető termék."], 400); 
            }

            $orderdrink->price = $OrderService->getDrinkPrice($orderdrink->drink_id, $order->restaurant_id);

            $margin = $margin + $OrderService->getDrinkMargin($orderdrink->drink_id, $order->restaurant_id) * $orderdrink->quantity;

            $DrinkPrice = $orderdrink->price * $orderdrink->quantity;

            $orderdrink->save();

            $total_price = $total_price + $DrinkPrice;
        }

        //MENU
        for ($i = 0; $i < count($request->get('menu')); $i++) {
            $ordermenu = new OrderMenu;
            $ordermenu->order_id = $OrderID;

            $ordermenu->quantity = $request->get('menu')[$i]['quantity'];

            $MealID = $request->get('menu')[$i]['meal_id'];

            if(!$OrderService->isMeal($MealID, $order->restaurant_id)) {
                return response()->json(['error'=>"Nem található termék."], 400); 
            }

            if(!$OrderService->isMenuMealAvailable($MealID, $order->restaurant_id)) {
                return response()->json(['error'=>"Nem elérhető termék."], 400); 
            }

            $ordermenu->menu_id = $OrderService->getMenuID($MealID, $order->restaurant_id);

            if (!$OrderService->isMenu($ordermenu->menu_id, $order->restaurant_id)) {
                return response()->json(['error'=>"Nem elérhető termék."], 400); 
            }

            $MealPrice = $OrderService->getMealPrice($MealID, $order->restaurant_id);

            $margin = $margin + $OrderService->getMealMargin($MealID, $order->restaurant_id) * $ordermenu->quantity;
            
            $ordermenu->side_id = $request->get('menu')[$i]['side_id'];

            if(!$OrderService->isSide($ordermenu->side_id, $order->restaurant_id)) {
                return response()->json(['error'=>"Nem található termék."], 400); 
            }

            if(!$OrderService->isMenuSideAvailable($ordermenu->side_id, $order->restaurant_id)) {
                return response()->json(['error'=>"Nem elérhető termék."], 400); 
            }

            if(!$OrderService->isMenuSide($ordermenu->menu_id, $ordermenu->side_id)) {
                return response()->json(['error'=>"Nem kapcsolható termék."], 400); 
            }

            $SidePrice = $OrderService->getSidePrice($ordermenu->side_id, $order->restaurant_id);

            $margin = $margin + $OrderService->getSideMargin($ordermenu->side_id, $order->restaurant_id) * $ordermenu->quantity;

            $ordermenu->drink_id = $request->get('menu')[$i]['drink_id'];

            if(!$OrderService->isDrink($ordermenu->drink_id, $order->restaurant_id)) {
                return response()->json(['error'=>"Nem található termék."], 400); 
            }

            if(!$OrderService->isMenuDrinkAvailable($ordermenu->drink_id, $order->restaurant_id)) {
                return response()->json(['error'=>"Nem elérhető termék."], 400); 
            }

            if(!$OrderService->isMenuDrink($ordermenu->menu_id, $ordermenu->drink_id)) {
                return response()->json(['error'=>"Nem kapcsolható termék."], 400); 
            }

            $DrinkPrice = $OrderService->getDrinkPrice($ordermenu->drink_id, $order->restaurant_id);

            $margin = $margin + $OrderService->getDrinkMargin($ordermenu->drink_id, $order->restaurant_id) * $ordermenu->quantity;

            if($OrderService->getMealMaxExtras($MealID, $order->restaurant_id) < count($request->get('menu')[$i]['extras'])) {
                return response()->json(['error'=>"Túl sok extra."], 400); 
            }

            $MenuSale = $OrderService->getMenuSalePercent($ordermenu->menu_id, $order->restaurant_id);
            $MenuPrice = $MealPrice + $SidePrice + $DrinkPrice;
            if ($MenuPrice > 0 && $MenuSale > 0) {
                $MenuPrice = $MenuPrice / 100;
                $MenuSale = 100 - $MenuSale;
                $MenuPrice = $MenuSale * $MenuPrice;
                $MenuPrice = round($MenuPrice);
            }

            $ordermenu->price = $MenuPrice;

            $ordermenu->save();

            for ($x = 0; $x < count($request->get('menu')[$i]['extras']); $x++) {
                $ordermenuextras = new OrderMenuExtras;
                $ordermenuextras->extra_id = $request->get('menu')[$i]['extras'][$x]['extra_id'];

                if (!$OrderService->isExtra($ordermenuextras->extra_id, $order->restaurant_id)) {
                    return response()->json(['error'=>"Nem található extra."], 400); 
                }

                if (!$OrderService->isExtraAvailable($ordermenuextras->extra_id, $MealID, $order->restaurant_id)) {
                    return response()->json(['error'=>"Nem elérhető extra."], 400); 
                }

                $ordermenuextras->price = $OrderService->getExtraPrice($ordermenuextras->extra_id, $order->restaurant_id);

                $margin = $margin + $OrderService->getExtraMargin($ordermenuextras->extra_id, $order->restaurant_id) * $ordermenu->quantity;

                $ordermenuextras->order_menu_id = $OrderService->getOrderMenuID($ordermenu->order_id, $ordermenu->menu_id);

                $ordermenuextras->save();

                $MenuPrice = $MenuPrice + $ordermenuextras->price;
            }

            $MenuPrice = $MenuPrice * $ordermenu->quantity;

            $total_price = $total_price + $MenuPrice;
        }

        //PIZZA
        for ($i = 0; $i < count($request->get('pizza')); $i++) {

            if(!$OrderService->isPizzadesignerAvailable($order->restaurant_id)) {
                return response()->json(['error'=>"A pizzatervező nem elérhető."], 400); 
            }

            $orderpizza = new OrderPizza;
            $orderpizza->order_id = $OrderID;

            $orderpizza->pizzadesigner_size_id = $request->get('pizza')[$i]['pizzadesigner_size_id'];

            if(!$OrderService->isPizzadesignerSize($orderpizza->pizzadesigner_size_id, $order->restaurant_id)) {
                return response()->json(['error'=>"Hibás pizza méret."], 400); 
            }

            $PizzaPrice = $OrderService->getPizzadesignerSizePrice($orderpizza->pizzadesigner_size_id, $order->restaurant_id);

            $orderpizza->pizzadesigner_base_id = $request->get('pizza')[$i]['pizzadesigner_base_id'];

            if(!$OrderService->isPizzadesignerBase($orderpizza->pizzadesigner_base_id, $orderpizza->pizzadesigner_size_id, $order->restaurant_id)) {
                return response()->json(['error'=>"Hibás pizza alap."], 400); 
            }

            $PizzaPrice = $PizzaPrice + $OrderService->getPizzadesignerBasePrice($orderpizza->pizzadesigner_base_id, $order->restaurant_id);

            $orderpizza->pizzadesigner_dough_id = $request->get('pizza')[$i]['pizzadesigner_dough_id'];

            if(!$OrderService->isPizzadesignerDough($orderpizza->pizzadesigner_dough_id, $orderpizza->pizzadesigner_size_id, $order->restaurant_id)) {
                return response()->json(['error'=>"Hibás pizza tészta."], 400); 
            }

            $PizzaPrice = $PizzaPrice + $OrderService->getPizzadesignerDoughPrice($orderpizza->pizzadesigner_dough_id, $order->restaurant_id);

            $orderpizza->price = round($PizzaPrice);

            $orderpizza->quantity = $request->get('pizza')[$i]['quantity'];

            $margin = $margin + $OrderService->getPizzadesignerBaseMargin($orderpizza->pizzadesigner_base_id, $order->restaurant_id) * $orderpizza->quantity;
            $margin = $margin + $OrderService->getPizzadesignerDoughMargin($orderpizza->pizzadesigner_dough_id, $order->restaurant_id) * $orderpizza->quantity;
            $margin = $margin + $OrderService->getPizzadesignerSizeMargin($orderpizza->pizzadesigner_size_id, $order->restaurant_id) * $orderpizza->quantity;

            if($OrderService->getPizzadesignerSizeToppingslimit($orderpizza->pizzadesigner_size_id, $order->restaurant_id) < count($request->get('pizza')[$i]['toppings'])) {
                return response()->json(['error'=>"Túl sok pizza feltét."], 400); 
            }

            if(count($request->get('pizza')[$i]['sauces']) > 3) {
                return response()->json(['error'=>"Túl sok pizza szósz."], 400); 
            }

            $orderpizza->save();

            $OrderPizzaID = $OrderService->getOrderPizzaID($OrderID);

            for ($x = 0; $x < count($request->get('pizza')[$i]['toppings']); $x++) {
                $orderpizzatoppings = new OrderPizzaToppings;
                $orderpizzatoppings->order_pizza_id = $OrderPizzaID;
                $orderpizzatoppings->pizzadesigner_topping_id = $request->get('pizza')[$i]['toppings'][$x]['pizzadesigner_topping_id'];

                if (!$OrderService->isPizzadesignerTopping($orderpizzatoppings->pizzadesigner_topping_id, $orderpizza->pizzadesigner_size_id, $order->restaurant_id)) {
                    return response()->json(['error'=>"Nem található feltét."], 400); 
                }

                $orderpizzatoppings->price = $OrderService->getPizzadesignerToppingPrice($orderpizzatoppings->pizzadesigner_topping_id, $order->restaurant_id);

                $margin = $margin + $OrderService->getPizzadesignerToppingMargin($orderpizzatoppings->pizzadesigner_topping_id, $order->restaurant_id) * $orderpizza->quantity;

                $orderpizzatoppings->save();

                $PizzaPrice = $PizzaPrice + $orderpizzatoppings->price;
            }

            for ($x = 0; $x < count($request->get('pizza')[$i]['sauces']); $x++) {
                $orderpizzasauces = new OrderPizzaSauces;
                $orderpizzasauces->order_pizza_id = $OrderPizzaID;
                $orderpizzasauces->pizzadesigner_sauce_id = $request->get('pizza')[$i]['sauces'][$x]['pizzadesigner_sauce_id'];

                if (!$OrderService->isPizzadesignerSauce($orderpizzasauces->pizzadesigner_sauce_id, $orderpizza->pizzadesigner_size_id, $order->restaurant_id)) {
                    return response()->json(['error'=>"Nem található szósz."], 400); 
                }

                $orderpizzasauces->price = $OrderService->getPizzadesignerSaucePrice($orderpizzasauces->pizzadesigner_sauce_id, $order->restaurant_id);

                $margin = $margin + $OrderService->getPizzadesignerSauceMargin($orderpizzasauces->pizzadesigner_sauce_id, $order->restaurant_id) * $orderpizza->quantity;

                $orderpizzasauces->save();

                $PizzaPrice = $PizzaPrice + $orderpizzasauces->price;
            }

            $PizzaPrice = $PizzaPrice * $orderpizza->quantity;

            $total_price = $total_price + $PizzaPrice;
        }

        if ($order->is_delivery == 1) {

            if ($total_price < $RestaurantService->getRestaurantMinimumOrderValue($restaurantID)) {
                return response()->json(['error'=>"A végösszeg alacsonyabb a minimum kosárértéknél.."], 400); 
            }

            if (!$RestaurantService->isRestaurantZipcode($restaurantID, $CustomerService->getCustomerZip($customer->id)) ) {
                return response()->json(['error'=>"Az ön címére ebből az étteremből a házhozszállítás nem megoldható."], 400);
            }

            $total_price = $total_price + $RestaurantService->getRestaurantDeliveryPrice($restaurantID);
        }

        $order2 = Order::where('id', '=', $OrderID)->where('restaurant_id', '=', $restaurantID)->where('customer_id', '=', $customer->id)->first();
        $order2->total_price = $total_price;
        $order2->margin = $margin;
        $order2->is_final_order = 1;
        if ($order->is_online_payment) {
            $order2->is_paid = 1;
        }
        $order2->save();

        $order3 = Order::where('id', '=', $OrderID)
            ->where('restaurant_id', '=', $restaurantID)
            ->where('customer_id', '=', $customer->id)
            ->where('is_final_order', '=', 1)
            ->with('customer')
            ->with('orderside')
            ->with('orderdrink')
            ->with('ordermeal')
            ->with('ordermeal.ordermealextras')
            ->with('ordermenu')
            ->with('ordermenu.ordermenuextras')
            ->with('orderpizza')->first();
   
        return response()->json($order3);
    }


}