<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Mail\FridayNotification;
// use Queue;


class MessageController extends Controller
{


    public function message(Request $request)
    {
        $user = $request->user();
        $user_id = $user->id;
        $mails = $user->messages()->latest()->where('status', Message::SENT)->get()->groupBy('author_id');
        $users = User::whereIn('id', $mails->keys()->toArray())->get();
        if (isset($mails[''])) {
            $users->push(new User([
                'id' => 0,
                'name' => 'Система',
            ]));
            $mails['0'] = $mails[''];
            unset($mails['']);
        }

        $user->messages()->where('read_at', null)->update([
            'read_at' => \DB::raw('NOW()'),
        ]);

        return view('mail', ['mails' => $mails, 'users' => $users]);
    }

    public function friday(Request $request)
    {
        $user = $request->user();
        // Queue::dispatch(new FridayNotification($user));
        return redirect()->back();
    }
}
