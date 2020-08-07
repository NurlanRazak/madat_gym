<?php

namespace App\Composers;

use Illuminate\View\View;
use App\Models\Programtraining;

class CalendarComposer
{

    public function compose(View $view)
    {
        $programs = Programtraining::whereHas('activeprograms', function($query) {
            $query->where('date_start', '<=', \DB::raw('NOW()'))
                  ->where('date_finish', '>=', \DB::raw('NOW()'));
        })->get();

        $program_id = request()->program_id;
        if (!$program_id && $programs->count()) {
            $program_id = $programs[0]->id;
        }

        $groups = [];

        if ($program_id) {
            $current_program = Programtraining::findOrFail($program_id);

            $trainings = $this->getTrainings($current_program);
            $planeats = $this->getPlaneats($current_program);
            $relaxtrainings = $this->getRelaxtrainings($current_program);

            // dd($trainings, $planeats, $relaxtrainings);

            foreach($trainings as $training) {
                $this->pushItem($groups, $training->day_number, [
                    'type' => 'training',
                    'id' => $training->id,
                    'name' => $training->name,
                    'hour_start' => $training->hour_start,
                    'hour_finish' => $training->hour_finish,
                    'items' => $training->exercises->map(function($item) {
                        return [
                            'id' => $item->id,
                            'name' => $item->name,
                        ];
                    }),
                ]);
            }

            foreach($relaxtrainings as $training) {
                $this->pushItem($groups, $training->number_day, [
                    'type' => 'relaxtraining',
                    'id' => $training->id,
                    'name' => $training->name,
                    'hour_start' => $training->hour_start,
                    'hour_finish' => $training->hour_finish,
                    'items' => $training->exercises->map(function($item) {
                        return [
                            'id' => $item->id,
                            'name' => $item->name,
                        ];
                    }),
                ]);
            }

            foreach($planeats as $training) {
                foreach($training->eathours as $item) {
                    $this->pushItem($groups, $training->days, [
                        'type' => 'planeat',
                        'id' => $item->id,
                        'planeat_id' => $training->id,
                        'name' => $item->name,
                        'hour_start' => $item->hour_start,
                        'hour_finish' => $item->hour_finish,
                        'items' => $training->meals->map(function($item) {
                            return [
                                'id' => $item->id,
                                'name' => $item->name,
                            ];
                        }),
                    ]);
                }
            }

        }
        foreach($groups as $week => $week_days) {
            foreach($week_days as $week_day => $items) {
                $groups[$week][$week_day] = collect($items)->sortBy('hour_start')->values()->all();
            }
        }

        $view->with('groups', $groups);
        $view->with('programs', $programs);
    }

    private function pushItem(&$groups, int $day, $training)
    {
        $week = ceil($day/7);
        $day = $day%7;
        $day = $day ? $day - 1 : 6;
        if (!isset($groups[$week])) {
            $groups[$week] = [];
        }
        if (!isset($groups[$week][$day])) {
            $groups[$week][$day] = [];
        }

        $groups[$week][$day][] = $training;
    }

    private function getTrainings($current_program)
    {
        return $current_program
                ->trainings()
                ->active()
                ->with([
                    'exercises' => function($query) {
                        $query->active();
                    },
                ])
                ->get();
    }

    private function getRelaxtrainings($current_program)
    {
        return $current_program
                ->relaxprogram
                ->relaxtrainings()
                ->active()
                ->with([
                    'exercises' => function($query) {
                        $query->active();
                    }
                ])
                ->get();
    }

    private function getPlaneats($current_program)
    {
        return $current_program->foodprogram
                ->planeats()
                ->active()
                ->with([
                    'eathours' => function($query) {
                        $query->active();
                    },
                    'meals' => function($query) {
                        $query->active();
                    }
                ])
                ->get();
    }

}
