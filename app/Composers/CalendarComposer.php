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
        $foodprogram_id = null;
        $relaxprogram_id = null;


        if ($program_id) {
            $current_program = Programtraining::findOrFail($program_id);
            $foodprogram_id = $current_program->foodprogram_id;
            $relaxprogram_id = $current_program->relaxprogram_id;

            $trainings = $this->getTrainings($current_program);
            $relaxtrainings = $this->getRelaxtrainings($current_program);
            $eathours = $this->getEathours($current_program);
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

            foreach($eathours as $eathour) {
                foreach($eathour->planeats->groupBy('days') as $day => $planeats) {
                    $this->pushItem($groups, $day, [
                        'type' => 'planeat',
                        'id' => $eathour->id,
                        'name' => $eathour->name,
                        'hour_start' => $eathour->hour_start,
                        'hour_finish' => $eathour->hour_finish,
                        'items' => $planeats->map(function($planeat) {
                            return [
                                'id' => $planeat->id,
                                'name' => $planeat->name,
                                'subitems' => $planeat->meals->map(function($item) {
                                    return [
                                        'id' => $item->id,
                                        'name' => $item->name,
                                    ];
                                })
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
        $groups_data = [];
        foreach($groups as $week => $data) {
            $groups_data[] = [
                'week' => $week,
                'data' => $data,
            ];
        }

        $groups_data = collect($groups_data)->sortBy('week')->values()->all();

        for($i = 0; $i<7;++$i) {
            foreach($groups_data as $index => $group) {
                if (!isset($group['data'][$i])) {
                    $groups_data[$index]['data'][$i] = [];
                }
            }
        }

        $view->with('groups', $groups_data);
        $view->with('programs', $programs);
        $view->with('program_id', $program_id);
        $view->with('foodprogram_id', $foodprogram_id);
        $view->with('relaxprogram_id', $relaxprogram_id);
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

    private function getEathours($current_program)
    {
        return \App\Models\Eathour::whereHas('planeats', function($query) use($current_program) {
            $query->active()
                  ->where('foodprogram_id', $current_program->foodprogram_id);
        })->with([
            'planeats' => function($query) use($current_program) {
                $query->active()
                      ->where('foodprogram_id', $current_program->foodprogram_id)
                      ->with([
                          'meals' => function($query) {
                              $query->active();
                          }
                      ]);
            }
        ])->get();
    }

}
