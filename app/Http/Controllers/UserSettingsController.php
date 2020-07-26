<?php

namespace App\Http\Controllers;

use File;
use Image;
use App\Restaurant;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserSettingsController extends Controller
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

    //update settings in db
    public function changePassword(Request $request)
    {
        $validatedData = request()->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'max:25'],
            'new_password_conf' => ['required', 'string', 'min:8', 'max:25']
        ]);

        $user_id = Auth::User()->id;                       
        $user = User::find($user_id);
        if (!Hash::check(request('current_password'), $user->password)) {
            return back()
            ->with('fail','A jelenlegi jelszó hibás!');
        }
        if (request('new_password') != request('new_password_conf')) {
            return back()
            ->with('fail','Az új jelszavak nem egyeznek!');
        }
        $user->password = Hash::make(request('new_password'));
        $user->save(); 

        return back()
            ->with('success','A jelszó sikeresen frissítve lett!');
    }

}