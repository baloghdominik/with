<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
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

    // Dashboard - Analytics
    public function dashboardAnalytics(){
        $pageConfigs = [
            'pageHeader' => false
        ];

        return view('/pages/home', [
            'pageConfigs' => $pageConfigs
        ]);
    }

}

