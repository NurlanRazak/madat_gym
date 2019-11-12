<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Jobs\SendMessageJob;

class MessageController extends Controller
{

    public function send(Request $request)
    {
        $message = Message::find($request->id);
        $message->update([
            'status' => Message::SENT,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Ok',
        ]);
    }

    public function cancel(Request $request)
    {
        $message = Message::find($request->id);
        $message->update([
            'status' => Message::CANCELED,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Ok',
        ]);
    }

}
