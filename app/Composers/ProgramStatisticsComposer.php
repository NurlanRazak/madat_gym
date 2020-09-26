<?php

namespace App\Composers;

use Illuminate\View\View;

class ProgramStatisticsComposer
{

    public function compose(View $view)
    {
        $labels = [];
        for($i=0; $i < 12 ; ++$i) {
            $date_first = \Date::parse(strtotime("first day of -{$i} months"));
            $date_last = \Date::parse(strtotime("last day of -{$i} months"));
            $labels[] = mb_ucfirst($date_first->format('F'));
        }

        $programs = \App\Models\Programtraining::all();
        $data = [];

        foreach($programs as $index => $program) {
            $data[$index]['label'] = $program->name;
            $data[$index]['backgroundColor'] = "rgba(".rand(100, 255).",".rand(100, 255).",".rand(100, 200).", 0.6)";
            $data[$index]['data'] = [];
            for($i=0; $i < 12 ; ++$i) {
                $date_first = \Date::parse(strtotime("first day of -{$i} months"));
                $date_last = \Date::parse(strtotime("last day of -{$i} months"));

                $cnt = \App\User::where('programtraining_id', $program->id)
                                ->where('programtraining_start', '>=', $date_first->format('Y-m-d'))
                                ->where('programtraining_start', '<=', $date_last->format('Y-m-d'))
                                ->count();
                $data[$index]['data'][] = $cnt;
            }
        }

        $view->with('program_statistics_data', $data);
        $view->with('program_statistics_labels', $labels);
    }

}
