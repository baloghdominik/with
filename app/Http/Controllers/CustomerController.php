<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Customer; 
use App\CustomerPasswordReset; 
use App\CustomerDTO; 
use App\Zipcode; 
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
use App\CustomerOrderDTO;
use App\CustomerOrderProductDTO;
use App\Restaurant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Password;
use Validator;
use DateTime;
use DateTimeZone;
use App\Http\Controllers\MailerController;

class CustomerController extends Controller {

    public $successStatus = 200;
    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(Request $request) { 

        $validator = Validator::make($request->all(), [ 
            'email' => 'required|email|max:50|min:5',
            'password' => 'required|string|min:8|max:25',
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $customer = Auth::user(); 
            $success['token'] =  $customer->createToken('WithAdmin')-> accessToken; 
            return response()->json(['success' => $success], $this-> successStatus); 
        } else { 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }

    public function forgot(Request $request, MailerController $MailerController) {
        $validator = Validator::make($request->all(), [ 
            'email' => 'required|email|max:50|min:5',
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $email = request('email');

        $customer = Customer::where('email', '=', $email)->first();

        if ($customer == NULL) {
            return response()->json(['error'=>"User not found."], 401); 
        }

        $customerPasswordReset = new CustomerPasswordReset;

        $customerPasswordReset->email = $email;

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 50; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        $customerPasswordReset->token = md5($randomString);

        $dt = new DateTime("now", new DateTimeZone('Europe/Budapest'));
        $customerPasswordReset->created_at = $dt->format('Y-m-d H:i:s');

        $customerPasswordReset->save();

        if (!$MailerController->passwordResetMail($customerPasswordReset->email, $customerPasswordReset->token)) {
            return response()->json(['error'=>"Mail not sent."], 401); 
        }

        return response()->json(["success" => 'Reset password link sent to the given email address.'], 200);
    }

    public function reset(Request $request, MailerController $MailerController) {
        $validator = Validator::make($request->all(), [ 
            'token' => 'required|string|max:500|min:1',
            'new_password' => 'required|string|min:8|max:25',
            'new_password_confirm' => 'required|string|min:8|max:25',
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $token = request('token');

        $dt = new DateTime("now", new DateTimeZone('Europe/Budapest'));
        $dt = $dt->format('Y-m-d H:i:s');

        $DateTime = DateTime::createFromFormat('Y-m-d H:i:s', $dt);
        $DateTime->modify('-60 minutes');
        $DateTime->format("Y-m-d H:i:s");
        $last1hour = $DateTime;

        $customerPasswordReset = CustomerPasswordReset::where('token', '=', $token)->where('created_at', '>', $last1hour)->first();

        if ($customerPasswordReset == NULL) {
            return response()->json(['error'=>"Invalid token."], 401); 
        }

        $customer = Customer::where('email', '=', $customerPasswordReset->email)->first();

        if ($customer == NULL) {
            return response()->json(['error'=>"User not found."], 401); 
        }

        $password = request('new_password');
        $password_c = request('new_password_confirm');

        if ($password === $password_c) {
            if (Hash::check($password, $customer->password)) {
                return response()->json(['error'=>"The new password can not be the same as the current."], 401);     
            } else {
                $pattern = "/^(?=.{8,25})(?=[A-ZÍÖÜÓÚŐŰÁÉ]*)(?=.+[a-zíéáűúőóüö])(?=.+[\d])(?=[@#$%^&+=_!?.&#$*:-]*)[A-ZÍÖÜÓÚŐŰÁÉa-zíéáűúőóüö\d@#$%^&+=_!?.&#$*:-]*$/";
                if (preg_match($pattern, $password)) {
                    $customer->password = bcrypt($password);
                    $customer->save();
                } else {
                    return response()->json(['error'=>"Password format is not valid."], 401); 
                }
            }
        } else {
            return response()->json(['error'=>"The new passwords are not matching."], 401); 
        }

        return response()->json(["success" => 'The password has been updated.'], 200);
    }

    /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    {

        $validator = Validator::make($request->all(), [ 
            'firstname' => 'required|string|min:3|max:20', 
            'lastname' => 'required|string|min:3|max:25', 
            'country' => 'required|string|min:5|max:25', 
            'city' => 'required|string|min:3|max:25', 
            'zipcode' => 'required|numeric|min:999|max:9999', 
            'address' => 'required|string|min:5|max:50', 
            'email' => 'required|email|unique:customer,email|max:35|min:5', 
            'phone' => 'required|digits:11', 
            'password' => 'required|string|min:8|max:25', 
            'c_password' => 'required|same:password', 
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $input = $request->all(); 

        $customer = new Customer;

        $password = $input['password'];
        $pattern = "/^(?=.{8,25})(?=[A-ZÍÖÜÓÚŐŰÁÉ]*)(?=.+[a-zíéáűúőóüö])(?=.+[\d])(?=[@#$%^&+=_!?.&#$*:-]*)[A-ZÍÖÜÓÚŐŰÁÉa-zíéáűúőóüö\d@#$%^&+=_!?.&#$*:-]*$/";
        if (preg_match($pattern, $password)) {
            $customer->password = bcrypt($password);
        } else {
            return response()->json(['error'=>"Password is not valid."], 401); 
        }

        $email = $input['email'];
        $lengthcheck = "/.{8,50}/";
        $pattern = "/^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/";
        if (preg_match($lengthcheck, $email) && preg_match($pattern, $email)) {
            $customer->email = $email;
        } else {
            return response()->json(['error'=>"Email is not valid."], 401); 
        }

        $phone = preg_replace('/[^+][\D]/', '', $input['phone']);
        $pattern = "/^(([+]{1}[0-9]{1,3})|([0-9]{1,3}))[0-9]{1,3}[0-9]{6,9}$/";
        if (preg_match($pattern, $phone)) {
            $customer->phone = $phone;
        } else {
            return response()->json(['error'=>"Phone number is not valid."], 401); 
        }

        $firstname = $input['firstname'];
        $pattern = "/^[\w\síÍéÉáÁűŰúÚőŐóÓüÜöÖ-]{3,25}$/";
        if (preg_match($pattern, $firstname)) {
            $customer->firstname = $firstname;
        } else {
            return response()->json(['error'=>"Firstname is not valid."], 401); 
        }
        
        $lastname = $input['lastname'];
        $pattern = "/^[\w\síÍéÉáÁűŰúÚőŐóÓüÜöÖ-]{3,25}$/";
        if (preg_match($pattern, $lastname)) {
            $customer->lastname = $lastname;
        } else {
            return response()->json(['error'=>"Lastname is not valid."], 401); 
        }

        $country = $input['country'];
        $pattern = "/^[\wíÍéÉáÁűŰúÚőŐóÓüÜöÖ-]{5,25}$/";
        if (preg_match($pattern, $country)) {
            $customer->country = $country;
        } else {
            return response()->json(['error'=>"Country is not valid."], 401); 
        }

        $city = $input['city'];
        $pattern = "/^[\w\síÍéÉáÁűŰúÚőŐóÓüÜöÖ-]{3,25}$/";
        if (preg_match($pattern, $city)) {
            $customer->city = $city;
        } else {
            return response()->json(['error'=>"City is not valid."], 401); 
        }

        $address = $input['address'];
        $pattern = "/^[A-Za-zíÍéÉáÁűŰúÚőŐóÓüÜöÖ]{3}[\/A-Za-zíÍéÉáÁűŰúÚőŐóÓüÜöÖ\s\d,.-]{1,47}$/";
        if (preg_match($pattern, $address)) {
            $customer->address = $address;
        } else {
            return response()->json(['error'=>"Address is not valid."], 401); 
        }

        $zipcode = $input['zipcode'];
        $pattern = "/^[\d]{4}$/";
        if (preg_match($pattern, $zipcode)) {
            $zipcodes = Zipcode::where('zipcode', $zipcode)->count();
            if ($zipcodes > 0) {
                $customer->zipcode = $zipcode;
            } else {
                return response()->json(['error'=>"Zipcode is not valid."], 401); 
            }
        } else {
            return response()->json(['error'=>"Zipcode is not valid."], 401); 
        }

        $customer->save();

        $success['token'] =  $customer->createToken('WithAdmin')-> accessToken; 
        $success['name'] =  $customer->lastname.' '.$customer->firstname;

        return response()->json(['success'=>$success], $this-> successStatus); 
    }

    /** 
     * details api  
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function details() 
    { 
        $customer = Auth::user(); 
        return response()->json(['success' => $customer], $this-> successStatus); 
    } 


    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
    
        $response = 'You have been succesfully logged out!';
        return response($response, 200);
    
    }

    public function getCustomerDetails() {
        $customer = Auth::user();

        $customerDTO = new CustomerDTO;
        $customerDTO->firstname = $customer->firstname;
        $customerDTO->lastname = $customer->lastname;
        $customerDTO->email = $customer->email;
        if ($customer->email_verified_at != NULL || $customer->email_verified_at != "NULL") {
            $customerDTO->is_email_verified = true;
        } else {
            $customerDTO->is_email_verified = false;
        }
        $customerDTO->phone = $customer->phone;
        $customerDTO->country = $customer->country;
        $customerDTO->city = $customer->city;
        $customerDTO->zipcode = $customer->zipcode;
        $customerDTO->address = $customer->address;

        return response()->json($customerDTO, 200);
    }

    public function updateCustomerDetails(Request $request) 
    {
        $user = Auth::user();

        $customer = Customer::find($user->id);

        $validator = Validator::make($request->all(), [ 
            'firstname' => 'required|string|min:3|max:25', 
            'lastname' => 'required|string|min:3|max:25', 
            'country' => 'required|string|min:5|max:25', 
            'city' => 'required|string|min:3|max:25', 
            'zipcode' => 'required|numeric|min:999|max:9999', 
            'address' => 'required|string|min:5|max:50', 
            'phone' => 'required',
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $input = $request->all(); 

        $phone = preg_replace('/[^+][\D]/', '', $input['phone']);
        $pattern = "/^(([+]{1}[0-9]{1,3})|([0-9]{1,3}))[0-9]{1,3}[0-9]{6,9}$/";
        if (preg_match($pattern, $phone)) {
            $customer->phone = $phone;
        } else {
            return response()->json(['error'=>"Phone number is not valid."], 401); 
        }

        $firstname = $input['firstname'];
        $pattern = "/^[\w\síÍéÉáÁűŰúÚőŐóÓüÜöÖ-]{3,25}$/";
        if (preg_match($pattern, $firstname)) {
            $customer->firstname = $firstname;
        } else {
            return response()->json(['error'=>"Firstname is not valid."], 401); 
        }
        
        $lastname = $input['lastname'];
        $pattern = "/^[\w\síÍéÉáÁűŰúÚőŐóÓüÜöÖ-]{3,25}$/";
        if (preg_match($pattern, $lastname)) {
            $customer->lastname = $lastname;
        } else {
            return response()->json(['error'=>"Lastname is not valid."], 401); 
        }

        $country = $input['country'];
        $pattern = "/^[\wíÍéÉáÁűŰúÚőŐóÓüÜöÖ-]{5,25}$/";
        if (preg_match($pattern, $country)) {
            $customer->country = $country;
        } else {
            return response()->json(['error'=>"Country is not valid."], 401); 
        }

        $city = $input['city'];
        $pattern = "/^[\w\síÍéÉáÁűŰúÚőŐóÓüÜöÖ-]{3,25}$/";
        if (preg_match($pattern, $city)) {
            $customer->city = $city;
        } else {
            return response()->json(['error'=>"City is not valid."], 401); 
        }

        $address = $input['address'];
        $pattern = "/^[A-Za-zíÍéÉáÁűŰúÚőŐóÓüÜöÖ]{3}[\/A-Za-zíÍéÉáÁűŰúÚőŐóÓüÜöÖ\s\d,.-]{1,47}$/";
        if (preg_match($pattern, $address)) {
            $customer->address = $address;
        } else {
            return response()->json(['error'=>"Address is not valid."], 401); 
        }

        $zipcode = $input['zipcode'];
        $pattern = "/^[\d]{4}$/";
        if (preg_match($pattern, $zipcode)) {
            $zipcodes = Zipcode::where('zipcode', $zipcode)->count();
            if ($zipcodes > 0) {
                $customer->zipcode = $zipcode;
            } else {
                return response()->json(['error'=>"Zipcode is not valid."], 401); 
            }
        } else {
            return response()->json(['error'=>"Zipcode is not valid."], 401); 
        }

        $customer->save();

        return response()->json(['success'=>"Customer details has been updated."], $this-> successStatus); 
    }

    public function updateCustomerPassword(Request $request) 
    {
        $user = Auth::user();

        $customer = Customer::find($user->id);

        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string|min:1|max:50', 
            'new_password' => 'required|string|min:8|max:25', 
            'new_password_confirm' => 'required|same:new_password',
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $input = $request->all(); 

        if (Hash::check($input['old_password'], $customer->password)) {
            if ($input['new_password'] === $input['new_password_confirm']) {
                $password = $input['new_password'];
                if (Hash::check($password, $customer->password)) {
                    return response()->json(['error'=>"The new password can not be the same as the current."], 401);     
                } else {
                    $pattern = "/^(?=.{8,25})(?=[A-ZÍÖÜÓÚŐŰÁÉ]*)(?=.+[a-zíéáűúőóüö])(?=.+[\d])(?=[@#$%^&+=_!?.&#$*:-]*)[A-ZÍÖÜÓÚŐŰÁÉa-zíéáűúőóüö\d@#$%^&+=_!?.&#$*:-]*$/";
                    if (preg_match($pattern, $password)) {
                        $customer->password = bcrypt($password);
                        $customer->save();
                    } else {
                        return response()->json(['error'=>"Password format is not valid."], 401); 
                    }
                }
            } else {
                return response()->json(['error'=>"The new passwords are not matching."], 401); 
            }
        } else {
            return response()->json(['error'=>"Current password is not valid."], 401); 
        }

        return response()->json(['success'=>"Customer password has been updated."], $this-> successStatus); 
    }

    public function getCustomerOrders($status) {
        $customer = Auth::user();

        if ($status == "inprogress") {
            $customerorders = Order::where('customer_id', '=', $customer->id)
            ->where('order.is_final_order', '=', 1)
            ->where('order.is_refund_finished', '=', 0)
            ->where('order.is_finished', '=', 0)
            ->orderBy('order.created_at', 'DESC')
            ->with('orderside.side')
            ->with('orderdrink.drink')
            ->with('ordermeal.meal')
            ->with('ordermenu.meal')
            ->with('ordermenu.side')
            ->with('ordermenu.drink')
            ->with('ordermenu.ordermenuextras')
            ->with('ordermeal.ordermealextras.extra')->get();
        } else {
            $customerorders = Order::where('customer_id', '=', $customer->id)
            ->where('order.is_refund_finished', '=', 1)
            ->orWhere('order.is_finished', '=', 1)
            ->orderBy('order.created_at', 'DESC')
            ->with('orderside.side')
            ->with('orderdrink.drink')
            ->with('ordermeal.meal')
            ->with('ordermenu.meal')
            ->with('ordermenu.side')
            ->with('ordermenu.drink')
            ->with('ordermenu.ordermenuextras')
            ->with('ordermeal.ordermealextras.extra')->get();
        }

        $orders = array();

        foreach ($customerorders as $order) {

            $customerOrderDTO = new CustomerOrderDTO;

            $restaurant = Restaurant::where('id', $order->restaurant_id)->select('name', 'id', 'lowercasename', 'deliverytime', 'address')->first();

            if ($restaurant === null) {
                $customerOrderDTO->restaurant_name = "Nem található!";
                $customerOrderDTO->restaurant_lowercasename = "nemtalalhato";
                $customerOrderDTO->restaurant_id = $order->restaurant_id;
            } else {
                $customerOrderDTO->restaurant_name = $restaurant->name;
                $customerOrderDTO->restaurant_lowercasename = $restaurant->lowercasename;
                $customerOrderDTO->restaurant_id = $restaurant->id;
            }

            $ordered_at = DateTime::createFromFormat('Y-m-d H:i:s', $order->created_at);
            $customerOrderDTO->ordered_at = $ordered_at->format('Y-m-d H:i');;

            $customerOrderDTO->identifier = $order->identifier;

            $customerOrderDTO->comment = $order->comment;

            if ($order->is_refund == 1 && $order->is_refund_finished == 0) {
                $customerOrderDTO->status = "Visszatérítésre vár!";
            } else if ($order->is_refund_finished == 1) {
                $customerOrderDTO->status = "Elutasítva!";
            } else if ($order->is_accepted == 0) {
                $customerOrderDTO->status = "Felvételre vár!";
            } else if ($order->is_done == 0) {
                $customerOrderDTO->status = "Éppen készül!";
            } else if ($order->is_refund == 0) {
                if ($order->is_delivery == 1) {
                    if ($order->is_out_for_delivery == 0) {
                        $customerOrderDTO->status = "Futárra vár!";
                    } else if ($order->is_delivered == 0) {
                        $customerOrderDTO->status = "Szállítás alatt!";
                    } else if ($order->is_finished == 0) {
                        $customerOrderDTO->status = "Kiszállítva!";
                    } else if ($order->is_finished == 1) {
                        $customerOrderDTO->status = "Teljesítve!";

                        $finished_at = DateTime::createFromFormat('Y-m-d H:i:s', $order->finished_at);
                        $customerOrderDTO->finished_at = $finished_at->format('Y-m-d H:i');
                    }
                } else {
                    if ($order->is_finished == 0) {
                        $customerOrderDTO->status = "Átveheti rendelését!";
                    } else if ($order->is_finished == 1) {
                        $customerOrderDTO->status = "Teljesítve!";

                        $finished_at = DateTime::createFromFormat('Y-m-d H:i:s', $order->finished_at);
                        $customerOrderDTO->finished_at = $finished_at->format('Y-m-d H:i');
                    }
                }
            } else {
                $customerOrderDTO->status = "Ismeretlen.";
            }

            if ($order->coupon === NULL) {
                $customerOrderDTO->coupon = NULL; 
                $customerOrderDTO->coupoin_sale = "-0%";   
            } else {
                $customerOrderDTO->coupon = $order->coupon; 
                $customerOrderDTO->coupoin_sale = "-".$order->coupon_sale."%";   
            }

            if ($order->is_online_payment == 1) {
                $customerOrderDTO->payment_type = "Online előre fizetés";
            } else if ($order->is_online_payment == 0) {
                $customerOrderDTO->payment_type = "Utánvét";
            }

            if ($order->is_delivery == 1) {
                $customerOrderDTO->delivery_type = "Házhozszállítás";
            } else {
                $customerOrderDTO->delivery_type = "Helyszíni átvétel";
            }

            $customerOrderDTO->total_price = number_format($order->total_price, 0)."Ft";

            $today = new DateTime("now", new DateTimeZone('Europe/Budapest'));
            $today = $today->format('Y-m-d');
            if ($order->is_delivery == 1) {
                if ($order->is_accepted == 0) {
                    $customerOrderDTO->delivery_time = "Felvételre vár!";
                } else {
                    $delivery_at = DateTime::createFromFormat('Y-m-d H:i:s', $order->created_at);
                    $timemodifier = "+".$restaurant->deliverytime." minutes";
                    $delivery_at->modify($timemodifier);
                    $delivery_at_datetime = $delivery_at->format('Y-m-d H:i');
                    $delivery_at_time = $delivery_at->format('H:i');
                    $delivery_at_date = $delivery_at->format('Y-m-d');

                    if ($today == $delivery_at_date) {
                        $deliverytime = "Ma ".$delivery_at_time;
                    } else {
                        $deliverytime = $delivery_at_datetime;
                    }

                    $customerOrderDTO->delivery_time = $deliverytime;
                }

                $customerOrderDTO->delivery_address = $order->customer_zipcode." ".$order->customer_city." ".$order->customer_address;
            } else {
                if ($order->pickuptime === NULL) {
                    $customerOrderDTO->delivery_time = "Átvételre vár!";
                } else {
                    $pickup_at = DateTime::createFromFormat('Y-m-d H:i:s', $order->pickuptime);
                    $pickup_at_datetime = $pickup_at->format('Y-m-d H:i');
                    $pickup_at_time = $pickup_at->format('H:i');
                    $pickup_at_date = $pickup_at->format('Y-m-d');

                    if ($today == $pickup_at_date) {
                        $deliverytime = "Ma ".$pickup_at_time;
                    } else {
                        $deliverytime = $pickup_at_datetime;
                    }

                    $customerOrderDTO->delivery_time = $deliverytime;
                }
                $customerOrderDTO->delivery_address = $restaurant->address;
            }

            $customerOrderDTO->customer_phone = $order->customer_phone_number;
            $customerOrderDTO->name = $order->customer_lastname." ".$order->customer_firstname;
            $customerOrderDTO->invoice = $order->invoice;

            $products = array();

            foreach ($order->ordermeal as $item) {
                $customerOrderProductDTO = new CustomerOrderProductDTO;
                $customerOrderProductDTO->product_name = $item->name;

                $description = "";
                foreach ($item->ordermealextras as $extra) {
                    if ($description == "") {
                        $description = $description."+".$extra->name;
                    } else {
                        $description = $description.", +".$extra->name;
                    }
                }
                $customerOrderProductDTO->product_description = $description;

                $customerOrderProductDTO->product_quantity = $item->quantity;

                array_push($products, $customerOrderProductDTO);
            }
            
            foreach ($order->orderside as $item) {
                $customerOrderProductDTO = new CustomerOrderProductDTO;
                $customerOrderProductDTO->product_name = $item->name;
                $customerOrderProductDTO->product_description = "";
                $customerOrderProductDTO->product_quantity = $item->quantity;

                array_push($products, $customerOrderProductDTO);
            }

            foreach ($order->orderdrink as $item) {
                $customerOrderProductDTO = new CustomerOrderProductDTO;
                $customerOrderProductDTO->product_name = $item->name;
                $customerOrderProductDTO->product_description = "";
                $customerOrderProductDTO->product_quantity = $item->quantity;

                array_push($products, $customerOrderProductDTO);
            }

            foreach ($order->ordermenu as $item) {
                $customerOrderProductDTO = new CustomerOrderProductDTO;
                $customerOrderProductDTO->product_name = $item->menu_name." +".$item->side_name." +".$item->drink_name;

                $description = "";
                foreach ($item->ordermenuextras as $extra) {
                    if ($description == "") {
                        $description = $description."+".$extra->name;
                    } else {
                        $description = $description.", +".$extra->name;
                    }
                }
                $customerOrderProductDTO->product_description = $description;

                $customerOrderProductDTO->product_quantity = $item->quantity;

                array_push($products, $customerOrderProductDTO);
            }

            foreach ($order->orderpizza as $item) {
                $customerOrderProductDTO = new CustomerOrderProductDTO;
                $customerOrderProductDTO->product_name = $item->size_name."-es Egyéni Pizza";

                $description = "Tészta: ".$item->dough_name." | Alap: ".$item->base_name." | Feltétek: ";

                $toppings = "";
                foreach ($item->toppings as $topping) {
                    if ($toppings == "") {
                        $toppings = $topping->name;
                    } else {
                        $toppings = $toppings.", ".$topping->name;
                    }
                }
                if (strlen($toppings) > 1) {
                    $description = $description.$toppings;
                } else {
                    $description = $description."nincs";
                }

                $sauces = "";
                foreach ($item->sauces as $sauce) {
                    if ($sauces == "") {
                        $sauces = $sauce->name;
                    } else {
                        $sauces = $sauces.", ".$sauce->name;
                    }
                }
                if (strlen($sauces) > 1) {
                    $description = $description." | Szószok: ".$sauces;
                } 

                $customerOrderProductDTO->product_description = $description;

                $customerOrderProductDTO->product_quantity = $item->quantity;

                array_push($products, $customerOrderProductDTO);
            }

            usort($products, function($a, $b) {return strcmp($a->product_name, $b->product_name);});

            $customerOrderDTO->products = $products;

            array_push($orders, $customerOrderDTO);
        }

        return response()->json($orders, 200);
    }
}