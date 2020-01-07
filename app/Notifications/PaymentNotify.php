<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class PaymentNotify extends Notification
{
    use Queueable;
    public $message;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject(Lang::getFromJson('Спасибо за покупку'))
                    ->greeting(Lang::getFromJson('Добрый день!'))
                    ->line(Lang::getFromJson('Вы получили данное письмо так как оплатили абонемент:'))
                    ->line(Lang::getFromJson($this->message[0]))
                    ->line(Lang::getFromJson('на срок с '.$this->message[1]->format('d.m.Y'). ' по '.$this->message[2]->format('d.m.Y')))
                    ->line(Lang::getFromJson('Желаем вам успехов в тренировках!'))
                    ->action(Lang::getFromJson('Перейти на сайт'), url(config('app.url')));

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
