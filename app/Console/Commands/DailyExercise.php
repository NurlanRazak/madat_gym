<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DailyExercise extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exercise:daily';

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
        $programs = \App\Models\Programtraining::all();
        foreach($programs as $program) {
            foreach($program->users as $user) {
                $day = $user->getProgramtrainginDaysPassed();

                if ($program->trainings()->where('day_number', $day)->active()->count()) {
                    if (!$user->checkExersice($day, 1)) {
                        $doneExersice = \App\DoneExersice::create([
                            'user_id' => $user->id,
                            'key' => 1,
                            'day_number' => $day,
                            'reverse' => true
                        ]);
                    }
                }

                if ($program->foodprogram->planeats()->where('days', $day)->active()->count()) {
                    if (!$user->checkExersice($day, 2)) {
                        $doneExersice = \App\DoneExersice::create([
                            'user_id' => $user->id,
                            'key' => 2,
                            'day_number' => $day,
                            'reverse' => true
                        ]);
                    }
                }

                if ($program->relaxprogram->relaxtrainings()->where('number_day', $day)->active()->count()) {
                    if (!$user->checkExersice($day, 3)) {
                        $doneExersice = \App\DoneExersice::create([
                            'user_id' => $user->id,
                            'key' => 3,
                            'day_number' => $day,
                            'reverse' => true
                        ]);
                    }
                }
            }

        }
    }
}
