<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        $restaurantID = Auth::user()->restaurantid;

        $restaurant = DB::table('restaurant')
            ->where('id', '=', $restaurantID)
            ->first();
        if ($restaurant === null) {
            return redirect('/');
        }

        $secretcode = $restaurant->created_at;

        if($secretcode != NULL) {
            $date=date_create($secretcode);
            $secretcode = date_format($date,"y-md");
        } else {
            $secretcode = "000000";
        }

        $id = $restaurant->id;
        while (strlen($id) < 4) {
            $id = "0".$id;

        }

        $secretcode = strtoupper("WH".$secretcode."-".substr($restaurant->lowercasename, 0, 4)."-".$id);

        function randomString($length = 10, $type = 1) {
            if ($type == 1) {
                $characters = 'AWWWBCDEFGHIJKWWWLMNOPQRSWWWTUVWXYZ';
            } else {
                $characters = '0123456789';
            }
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }

        $secretpass = strtoupper(substr(date("M"), 0, 2).randomString(2, 2)."-".randomString(2, 1).date("d")."-".randomString(2, 1).date("H")."-".randomString(2, 1).date("i"));

        $verify = strtoupper(substr(date("M"), 0, 2).date("d").date("H")."WH");

        $url = "https://www.mikrovps.net/hu";
        $s1 = 0;
        $headers = @get_headers($url); 
        if($headers && strpos( $headers[0], '200')) { 
            $s1 = 1; 
        } 
        else { 
            $s1 = 0; 
        }

        $url = "https://cl04.awh.hu:2083/";
        $s2 = 0;
        $headers = @get_headers($url); 
        if($headers && strpos( $headers[0], '200')) { 
            $s2 = 1; 
        } 
        else { 
            $s2 = 0; 
        }

        $url = "https://admin.with.hu/login";
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
            's5' => $s5,
            'secret' => $secretcode,
            'pass' => $secretpass,
            'verify' => $verify
        ]);
    }

    // show video repository page
    public function showVideoRepository(){
        $pageConfigs = [
            'pageHeader' => false
        ];

        return view('/pages/videorepo', [
            'pageConfigs' => $pageConfigs
        ]);
    }

    // show video repository page
    public function showUpdates(){
        $pageConfigs = [
            'pageHeader' => false
        ];

        return view('/pages/updates', [
            'pageConfigs' => $pageConfigs
        ]);
    }

}