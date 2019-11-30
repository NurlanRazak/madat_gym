<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;


class MessageController extends Controller
{


    public function message(Request $request)
    {
        $messages = Message::with('users')->get();
        $mail = [];
        foreach($messages as $message) {
            foreach($message->users as $related_user) {
                if($related_user->id == $request->user()->id) {
                    $mail = $message;
                }
            }
        }

        return view('mail', ['mail' => $mail]);
    }
}
