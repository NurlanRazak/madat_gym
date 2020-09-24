<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Programtraining;

class CalendarController extends Controller
{

    public function update(Request $request, Programtraining $program)
    {
        $data = $request->toArray();
        foreach($data as $weekIndex => $week) {
            foreach($week['data'] as $weekDay => $groups) {
                foreach($groups as $groupIndex => $group) {
                    $this->handleGroup($group, $weekIndex * 7 + 1 + $weekDay, $program);
                }
            }
        }
    }

    private function handleGroup($group, $day, $program) // training, relaxtraining, eathour
    {
        $elem = $this->getGroup($group);
        if ($group['deleted'] ?? false) {
            if ($elem->trashed()) {
                $elem->forceDelete();
            } else if($group['type'] == 'training') {
                $elem->programtrainings()->detach($program->id);
            } else if ($group['type'] == 'relaxtraining') {
                $elem->programs()->detach($program->relaxprogram_id);
            }
        } else {
            if ($elem->trashed()) {
                $elem->restore();
            }
            if ($group['copy'] ?? false) {
                //
            }

            if ($group['type'] != 'planeat') {
                if ($group['type'] == 'training') {
                    $elem->programtrainings()->syncWithoutDetaching($program->id);
                }

                $elem->update([
                    $this->getDayField($group) => $day,
                ]);
            }
        }

        foreach($group['items'] as $itemIndex => $item) {
            $item['deleted'] = ($item['deleted'] ?? false) || ($group['deleted'] ?? false);
            $this->handleItem($item, $group, $day, $elem, $program);
        }
    }

    private function handleItem($item, $group, $day, $parent, $program) // exercise, relaxexercise, planeat
    {
        $elem = $this->getItem($item, $group);
        if ($item['deleted'] ?? false) {
            if ($elem->trashed()) {
                $elem->forceDelete();
            } else {
                if ($group['type'] == 'planeat') {
                    $elem->eathours()->detach($parent->id);
                } else if ($group['type'] == 'relaxexercise') {
                    $parent->exercises()->detach($elem->id);
                } else {
                    $parent->exercises()->detach($elem->id);
                }
            }
        } else {
            if ($elem->trashed()) {
                $elem->restore();
            }

            if ($group['type'] == 'planeat') {
                $elem->update([
                    'days' => $day,
                ]);
            }

            if ($item['copy'] ?? false) {
                //
            }
            $this->attachItem($elem, $group);
        }


        if ($group['type'] == 'planeat') {
            foreach($item['subitems'] ?? [] as $subitemIndex => $subitem) {
                $subitem['deleted'] = ($subitem['deleted'] ?? false) || ($item['deleted'] ?? false);
                $this->handleSubitem($subitem, $item, $elem);
            }
        }
    }

    private function handleSubitem($subitem, $item, $parent) // Meal
    {
        $elem = \App\Models\Meal::withTrashed()->find($subitem['id']);
        if ($subitem['deleted'] ?? false) {
            if ($elem->trashed()) {
                $elem->forceDelete();
            } else {
                $parent->meals()->detach($elem->id);
            }
        } else {
            if ($elem->trashed()) {
                $elem->restore();
            }
            $parent->meals()->syncWithoutDetaching($subitem['id']);
        }
    }

    private function attachItem($elem, $group)
    {
        if ($group['type'] == 'planeat') {
            $elem->eathours()->syncWithoutDetaching($group['id']);
        } else if ($group['type'] == 'training') {
            $elem->trainings()->syncWithoutDetaching($group['id']);
        } else {
            $elem->relaxtrainings()->syncWithoutDetaching($group['id']);
        }
    }


    private function getGroup($group)
    {
        if ($group['type'] == 'planeat') {
            return \App\Models\Eathour::withTrashed()->find($group['id']);
        }
        if ($group['type'] == 'training') {
            return \App\Models\Training::withTrashed()->find($group['id']);
        }
        return \App\Models\Relaxtraining::withTrashed()->find($group['id']);
    }

    private function getItem($item, $group)
    {
        if ($group['type'] == 'planeat') {
            return \App\Models\Planeat::withTrashed()->find($item['id']);
        }
        if ($group['type'] == 'training') {
            return \App\Models\Exercise::withTrashed()->find($item['id']);
        }
        return \App\Models\Relaxexercise::withTrashed()->find($item['id']);
    }

    private function getDayField($group) : string
    {
        if ($group['type'] == 'planeat') {
            return 'days';
        }
        if ($group['type'] == 'training') {
            return 'day_number';
        }
        return 'number_day';
    }

}
