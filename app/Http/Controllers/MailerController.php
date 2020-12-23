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

    public function passwordResetMail($email, $token)
    {

        $details = [
            'to' => $email,
            'from' => "noreply@with.hu",
            'subject' => "With - Jelszó helyreállítás",
            "template" => "email.passwordreset",
            "token" => $token
        ];

        \Mail::to($email)->send(new \App\Mail\Mailer($details));

        if (Mail::failures()) {
            return false;
        }
        return true;
    }

}