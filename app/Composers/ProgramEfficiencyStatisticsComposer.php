<?php

namespace App\Composers;

use Illuminate\View\View;

class ProgramEfficiencyStatisticsComposer
{

    public function compose(View $view)
    {
        $labels = ['qwe'];
        $data = [];

        $programs = \App\Models\Programtraining::all();

        foreach($programs as $program) {

            $all = $program->doneExersices()->count();
            $done = $program->doneExersices()->where('reverse', 0)->count();

            $val = $all > 0 ? ceil(100 * $done / $all) : 0;

            $data[] = [
                'label' => $program->name,
                'data' => [$val],
                'backgroundColor' => "rgba(".rand(100, 250).", ".rand(150, 250).", ".rand(50, 250).", 0.6)",
            ];
        }


        $view->with('program_efficiency_statistics_data', $data);
        $view->with('program_efficiency_statistics_labels', $labels);
    }

}
