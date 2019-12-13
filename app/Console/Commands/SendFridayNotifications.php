<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\User;
use App\Models\Message;
use Date;
use Carbon\Carbon;

class SendFridayNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:friday';

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
                     ->whereHas('programtraining')
                     ->get();

        $today = Date::today()->dayOfWeek;
        if($today == 0) {
            $today = 7;
        }

        foreach($users as $user)
        {
            $passed = (strtotime(Carbon::now()->format('Y-m-d')) - strtotime(Carbon::parse($user->programtraining_start)->format('Y-m-d')))/60/60/24 + 7;

            $groceries = $user->programtraining
                               ->groceries()
                               ->where('notify_day', '>=', $passed - $today + 2)
                               ->where('notify_day', '<=', $passed - $today + 8)
                               ->active()
                               ->get();

            $equipments = $user->programtraining
                              ->equipments()
                              ->where('notify_day', '>=', $passed - $today + 2)
                              ->where('notify_day', '<=', $passed - $today + 8)
                              ->active()
                              ->get();

            if ($groceries->count() > 0 || $equipments->count() > 0) {

                $content = "<h4>Новая неделя требует от Вас больших усилий. <br> Вот, что будет нужно на эту неделю!</h4>";
                if ($groceries->count() > 0) {
                    $content.="<br><h4>Продукты: </h4><ol>";
                    foreach($groceries as $grocery) {
                        foreach($grocery->listmeals as $meal) {
                            $content.="<li>{$meal->name}</li>";
                        }
                    }
                    $content.="</ol>";
                }
                if ($equipments->count() > 0) {
                    $content.="<br><h4>Оборудование: </h4><ol>";
                    foreach($equipments as $equipment) {
                        $content.="<li>{$equipment->name}</li>";
                    }
                    $content.="</ol>";
                }
                $content.="<br><h4>Желаем достижения новых высот!</h4>";
                $message = Message::create([
                    'status' => Message::SENT,
                    'name' => 'Продукты и оборудование',
                    'content' => $content,
                ]);

                $message->users()->attach($user);

            }
        }

    }
}
