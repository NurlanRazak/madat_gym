<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Relaxtraining extends Model
{
    use CrudTrait;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'relaxtrainings';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'number_day', 'time', 'hour_start', 'hour_finish', 'active'];
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
        return $this->belongsToMany('App\Models\Relaxexercise', 'relaxtrainings_relaxexercises', 'relaxtraining_id', 'exercise_id');
    }

    public function programs()
    {
        return $this->belongsToMany('App\Models\Relaxprogram', 'relaxtrainings_relaxprograms_pivot', 'relaxtraining_id', 'relaxprogram_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'relaxtrainings_users_pivot', 'relaxtraining_id', 'user_id')->whereDoesntHave('roles');
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
    public static function getConsumerOptions() : array
    {
        return \App\User::whereDoesntHave('roles')->pluck('email', 'id')->toArray();
    }
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
            'type' => 'relaxtraining',
            'hour_start' => $this->hour_start,
            'hour_finish' => $this->hour_finish,
            'items' => $this->exercises->map(function($item) {
                return $item->toCalendar();
            })
        ];
    }
}
