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
use App\OrderInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Validator;
use DateTime;
use DateTimeZone;

use App\Http\Services\OrderService;
use App\Http\Services\RestaurantService;
use App\Http\Services\CustomerService;

class OrderController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // show - orders
    public function showOrders(){
        if (file_exists(public_path() . '/notifier.txt') && filesize(public_path() . '/notifier.txt') > 0) {
            $myfile = fopen(public_path() . '/notifier.txt', "r") or die();
            $notifier = fread($myfile,filesize(public_path() . '/notifier.txt'));
            fclose($myfile);
        } else {
            $notifier = "";
        }

        $pageConfigs = [
            'pageHeader' => false,
            'notifier' => $notifier
        ];

        $restaurantID = Auth::user()->restaurantid;

        $orders = Order::where('restaurant_id', '=', $restaurantID)
        ->where('order.is_final_order', '=', 1)
        ->where('order.is_accepted', '=', 0)
        ->where('order.is_refund_finished', '=', 0)
        ->where('order.is_finished', '=', 0)
        ->orderBy('order.created_at', 'DESC')
        ->with('invoice')
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
        ->orderBy('order.created_at', 'DESC')
        ->with('invoice')
        ->with('customer.orders')
        ->with('orderside')
        ->with('orderdrink')
        ->with('ordermeal')
        ->with('ordermenu')
        ->with('ordermenu')
        ->with('ordermenu')
        ->with('ordermenu')
        ->with('ordermeal.ordermealextras')->get();

        $dt = new DateTime("now", new DateTimeZone('Europe/Budapest'));
        $dt = $dt->format('Y-m-d H:i:s');

        $DateTime = DateTime::createFromFormat('Y-m-d H:i:s', $dt);
        $DateTime->modify('-24 hours');
        $DateTime->format("Y-m-d H:i:s");
        $last24hour = $DateTime;

        $finishedorders = Order::where('restaurant_id', '=', $restaurantID)
        ->where('order.is_final_order', '=', 1)
        ->where('order.is_finished', '=', 1)
        ->where('order.created_at', '>', $last24hour)
        ->orWhere('order.is_refund_finished', '=', 1)
        ->where('order.is_final_order', '=', 1)
        ->where('order.created_at', '>', $last24hour)
        ->orderBy('order.created_at', 'DESC')
        ->with('invoice')
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

}