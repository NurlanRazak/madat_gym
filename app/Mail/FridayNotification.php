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

    protected $user;
    protected $next;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $next)
    {
        $this->user = $user;
        $this->next = ($next != 0);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $groceries = $this->user->getGroceries($this->next);
        $equipments = $this->user->getEquipments($this->next);

        return $this->to($this->user->email)
                    ->view('notifications.friday')
                    ->with([
                        'equipments' => $equipments,
                        'groceries' => $groceries,
                        'next' => $this->next,
                    ]);
    }
}
