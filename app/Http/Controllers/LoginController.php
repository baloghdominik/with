<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    // Login
    public function index(){
        $pageConfigs = [
            'pageHeader' => false
        ];

        return view('/pages/login', [
            'pageConfigs' => $pageConfigs
        ]);
    }
}

