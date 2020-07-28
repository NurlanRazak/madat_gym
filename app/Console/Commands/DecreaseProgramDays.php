<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pivots\ProgramtrainingUser;

class DecreaseProgramDays extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'programs:decrease';

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
        $items = ProgramtrainingUser::where('status', ProgramtrainingUser::ACTIVE)->get();
        foreach($items as $item) {
            $item->days_left = $item->days_left - 1;
            if ($item->days_left < 0) {

                $next = ProgramtrainingUser::where('user_id', $item->user_id)->where('status', ProgramtrainingUser::WILL_BE_ACTIVE)->first();
                $item->delete();

                if (!$next) {
                    $next = ProgramtrainingUser::where('user_id', $item->user_id)->where('status', ProgramtrainingUser::NOT_ACTIVE)->first();
                }

                if ($next) {
                    $next->user->setCurrentUserProgram($next->programtraining);
                }
            } else {
                $item->save();
            }
        }
    }
}
