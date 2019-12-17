<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use \Backpack\CRUD\CrudTrait;

    protected $fillable = ['model', 'model_id', 'user_id', 'type', 'url'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeVideo($query)
    {
        $query->where('type', 'video');
    }

    public function scopeAudio($query)
    {
        $query->where('type', 'audio');
    }
}
