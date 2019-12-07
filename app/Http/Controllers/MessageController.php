<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\User;
use Illuminate\Support\Facades\Auth;


class MessageController extends Controller
{


    public function message(Request $request)
    {
        $user_id = $request->user()->id;
        $mails = $request->user()->messages()->latest()->where('status', Message::SENT)->get()->groupBy('author_id');
        $users = User::whereIn('id', $mails->keys()->toArray())->get();

        return view('mail', ['mails' => $mails, 'users' => $users]);
    }
}
