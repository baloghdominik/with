<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Customer; 
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
        } 
        else{ 
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
            'firstname' => 'required', 
            'lastname' => 'required', 
            'email' => 'required|email', 
            'password' => 'required', 
            'c_password' => 'required|same:password', 
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $customer = Customer::create($input); 
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
}