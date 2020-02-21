<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HelpController extends Controller
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

    // show help page
    public function showHelp(){
        $pageConfigs = [
            'pageHeader' => false
        ];

        $url = "https://www.mikrovps.net/hu";
        $s1 = 0;
        $headers = @get_headers($url); 
        if($headers && strpos( $headers[0], '200')) { 
            $s1 = 1; 
        } 
        else { 
            $s1 = 0; 
        }

        $url = "https://codelabs.hu";
        $s2 = 0;
        $headers = @get_headers($url); 
        if($headers && strpos( $headers[0], '200')) { 
            $s2 = 1; 
        } 
        else { 
            $s2 = 0; 
        }

        $url = "https://codelabs.hu";
        $s3 = 0;
        $headers = @get_headers($url); 
        if($headers && strpos( $headers[0], '200')) { 
            $s3 = 1; 
        } 
        else { 
            $s3 = 0; 
        }

        $url = "https://with.hu";
        $s4 = 0;
        $headers = @get_headers($url); 
        if($headers && strpos( $headers[0], '200')) { 
            $s4 = 1; 
        } 
        else { 
            $s4 = 0; 
        }

        $url = "https://with.hu";
        $s5 = 0;
        $headers = @get_headers($url); 
        if($headers && strpos( $headers[0], '200')) { 
            $s5 = 1; 
        } 
        else { 
            $s5 = 0; 
        }

        return view('/pages/help', [
            'pageConfigs' => $pageConfigs, 
            's1' => $s1, 
            's2' => $s2, 
            's3' => $s3, 
            's4' => $s4, 
            's5' => $s5
        ]);
    }

}