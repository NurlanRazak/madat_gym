<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\User;
use App\Models\Message;

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

        foreach($users as $user)
        {
            $groceries = $user->getGroceries(true);
            $equipments = $user->getEquipments(true);

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
