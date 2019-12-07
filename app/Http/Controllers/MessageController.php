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
        $user = $request->user();
        $user_id = $user->id;
        $mails = $user->messages()->latest()->where('status', Message::SENT)->get()->groupBy('author_id');
        $users = User::whereIn('id', $mails->keys()->toArray())->get();

        $user->messages()->where('read_at', null)->update([
            'read_at' => \DB::raw('NOW()'),
        ]);

        return view('mail', ['mails' => $mails, 'users' => $users]);
    }
}
