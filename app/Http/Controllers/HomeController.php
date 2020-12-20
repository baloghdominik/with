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

use DateTime;
use DateTimeZone;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() 
    {

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

        $orderCount = DB::table('order')
        ->select(DB::raw('DATE(created_at) AS date'), DB::raw('count(*) AS ordercount'))
        ->where('restaurant_id', '=', $restaurantID)
        ->where('order.is_final_order', '=', 1)
        ->where('order.is_accepted', '=', 1)
        ->where('order.is_refund', '=', 0)
        ->where('order.is_finished', '=', 1)
        ->orderBy('created_at', 'ASC')
        ->groupBy('date')->limit(30)->get();

        $userNum = DB::table('order')
        ->where('restaurant_id', '=', $restaurantID)
        ->where('order.is_final_order', '=', 1)
        ->where('order.is_accepted', '=', 1)
        ->where('order.is_refund', '=', 0)
        ->where('order.is_finished', '=', 1)
        ->distinct('customer_id')->count('customer_id');

        $orderNum = DB::table('order')
        ->where('restaurant_id', '=', $restaurantID)
        ->where('order.is_final_order', '=', 1)
        ->where('order.is_accepted', '=', 1)
        ->where('order.is_refund', '=', 0)
        ->where('order.is_finished', '=', 1)
        ->distinct('id')->count('id');

        $modify = "-30 days";

        $currentTime = new DateTime("now", new DateTimeZone('Europe/Budapest'));
        $currentTime = $currentTime->format('Y-m-d H:i:s');
        $DateTime = DateTime::createFromFormat('Y-m-d H:i:s', $currentTime);
        $DateTime->modify("-30 days");
        $DateTime = $DateTime->format("Y-m-d H:i:s");

        $orders = DB::table('order')
        ->select('id', 'total_price', 'margin', 'created_at', 'finished_at')
        ->where('restaurant_id', '=', $restaurantID)
        ->where('order.is_final_order', '=', 1)
        ->where('order.is_accepted', '=', 1)
        ->where('order.is_refund', '=', 0)
        ->where('order.is_finished', '=', 1)
        ->where('order.created_at', '>', $DateTime)
        ->orderBy('created_at')->get();

        return view('/pages/home', [
            'pageConfigs' => $pageConfigs, 'orderCount' => $orderCount, 'userNum' => $userNum, 'orderNum' => $orderNum, 'orders' => $orders
        ]);
    }

    public function mail() 
    {
        return view('/email/order', []);
    }
}
