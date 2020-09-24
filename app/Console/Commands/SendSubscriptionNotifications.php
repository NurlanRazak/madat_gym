<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\User;
use App\Notifications\SubscriptionNotify;

use Mail;

class SendSubscriptionNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::whereDoesntHave('roles')
                        ->where('is_auto_renewal', false)
                        ->where('is_notifiable', true)
                        ->get();


        foreach($users as $user) {
            if ($user->subscriptions()
                     ->whereRaw("DATE(DATE_ADD(subscription_user.created_at, INTERVAL subscriptions.days DAY)) = DATE_ADD(CURDATE(), INTERVAL 7 DAY)")
                     ->orWhereRaw("DATE(DATE_ADD(subscription_user.created_at, INTERVAL subscriptions.days DAY)) = DATE_ADD(CURDATE(), INTERVAL 1 DAY)")->count() > 0) {
                $user->notify(new SubscriptionNotify());

            }
        }

    }
}
