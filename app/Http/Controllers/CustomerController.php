<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Customer; 
use App\CustomerDTO; 
use App\Zipcode; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 
use Validator;
class CustomerController extends Controller {

    public $successStatus = 200;
    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $customer = Auth::user(); 
            $success['token'] =  $customer->createToken('WithAdmin')-> accessToken; 
            return response()->json(['success' => $success], $this-> successStatus); 
        } else { 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
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
}