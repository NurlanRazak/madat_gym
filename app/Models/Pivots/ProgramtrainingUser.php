<?php

namespace App\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\Programtraining;
use App\User;

class ProgramtrainingUser extends Pivot
{

    const NOT_ACTIVE = 0;
    const ACTIVE = 1;
    const WILL_BE_ACTIVE = 2;
    const USED = 4;

    public $incrementing = true;
    public $timestamps = false;

    protected $table = 'programtraining_user';
    protected $fillable = ['user_id', 'programtraining_id', 'bought_at', 'status', 'days_left', 'total_days'];
    protected $dates = ['bought_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function programtraining()
    {
        return $this->belongsTo(Programtraining::class, 'programtraining_id');
    }

}
