<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Training extends Model
{
    use CrudTrait;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'trainings';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'day_number', 'approaches_number', 'repetitions_number', 'weight', 'exercise_id', 'programtraining_id', 'user_id', 'hour_start', 'hour_finish', 'active'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function exercises()
    {
        return $this->belongsToMany('App\Models\Exercise', 'training_exercise_pivot', 'training_id', 'exercise_id');
    }

    public function programtrainings()
    {
        return $this->belongsToMany('App\Models\Programtraining', 'training_programtraining', 'training_id', 'programtraining_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeActive($query)
    {
        $query->where('active', 1);
    }
    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function toCalendar()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => 'training',
            'hour_start' => $this->hour_start,
            'hour_finish' => $this->hour_finish,
            'items' => $this->exercises->map(function($item) {
                return $item->toCalendar();
            })
        ];
    }
}
