<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Models\Programtraining;

class DoneExersice extends Model
{
    protected $table = 'exercise_user';

    public $timestamps = false;

    protected $fillable = ['user_id', 'day_number', 'description', 'key', 'programtraining_id', 'reverse'];

    public static function boot()
    {
        parent::boot();

        static::creating(function($item) {
            if ($item->user) {
                $item->programtraining_id = $item->user->current_programtraining->id ?? null;
                if ($item->user->current_programtraining) {
                    if ($item->key == '1') {
                        $item->description = implode(', ', $item->user->current_programtraining->trainings()->active()->where('day_number', $item->day_number)->pluck('name')->toArray());
                    } else if ($item->key == '2') {
                        $current_program = $item->user->current_programtraining;
                        if ($current_program->foodprogram) {
                            $planeats = $current_program->foodprogram->planeats()->active()->where('days', $item->day_number)->pluck('id')->toArray();
                            $meals = \App\Models\Meal::active()->whereHas('planeats', function($query) use($planeats) {
                                $query->whereIn('id', $planeats);
                            })->pluck('name')->toArray();
                            $item->description = implode(', ', $meals);
                        }
                    } else {
                        $current_program = $item->user->current_programtraining;
                        if ($current_program->relaxprogram) {
                            $item->description = implode(', ', $current_program->relaxprogram->relaxtrainings()->active()->pluck('name')->toArray());
                        }
                    }
                }
            }
        });
    }

    public function programtraining()
    {
        return $this->belongsTo(Programtraining::class, 'programtraining_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
