<?php

namespace App\Http\Controllers;

use Mail;
use App\Mail\Mailer;

class MailerController extends Controller
{

    public function newMail()
    {

        $details = [
            'to' => "balogh0dominik@gmail.com",
            'from' => "noreply@with.hu",
            'subject' => "Test - With",
            'title' => "Test title",
            "body"  => "Test body"
        ];

        \Mail::to("balogh0dominik@gmail.com")->send(new \App\Mail\Mailer($details));

        if (Mail::failures()) {
            return response()->json([
                'status'  => false,
                'data'    => $details,
                'message' => 'Not sending mail.. retry again...'
            ]);
        }
        return response()->json([
            'status'  => true,
            'data'    => $details,
            'message' => 'Your details mailed successfully'
        ]);
    }

}