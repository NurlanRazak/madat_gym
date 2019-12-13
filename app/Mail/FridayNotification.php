<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;

class FridayNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $today = Date::today()->dayOfWeek;
        if($today == 0) {
            $today = 7;
        }

        $passed = (strtotime(Carbon::now()->format('Y-m-d')) - strtotime(Carbon::parse($this->user->programtraining_start)->format('Y-m-d')))/60/60/24 + 7;

        $groceries = $this->user->programtraining
                           ->groceries()
                           ->where('notify_day', '>=', $passed - $today + 2)
                           ->where('notify_day', '<=', $passed - $today + 8)
                           ->active()
                           ->get();

        $equipments = $this->user->programtraining
                          ->equipments()
                          ->where('notify_day', '>=', $passed - $today + 2)
                          ->where('notify_day', '<=', $passed - $today + 8)
                          ->active()
                          ->get();


        return $this->view('notifications.friday')
                    ->with([
                        'equipments' => $equipments,
                        'groceries' => $groceries,
                    ]);
    }
}
