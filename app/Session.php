<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Session extends Model
{
    use \Backpack\CRUD\CrudTrait;
    protected $fillable = ['user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
