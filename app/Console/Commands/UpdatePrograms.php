<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pivots\ProgramtrainingUser;
class UpdatePrograms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'programs:next';

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
        $items = ProgramtrainingUser::where('status', ProgramtrainingUser::WILL_BE_ACTIVE)->get();
        foreach($items as $item) {
            $item->user->setCurrentUserProgram($item->programtraining);
        }

    }
}
