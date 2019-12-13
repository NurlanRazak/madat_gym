<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class DoneExersice extends Model
{
    protected $table = 'exercise_user';

    public $timestamps = false;

    protected $fillable = ['user_id', 'day_number', 'key'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
