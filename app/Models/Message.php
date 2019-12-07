<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use App\User;

class Message extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    const DRAFT = 0;
    const SENT = 1;

    protected $table = 'messages';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'content', 'status', 'send_date', 'author_id'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public static function boot()
    {
        parent::boot();

        static::creating(function($message) {
            if(!$message->author_id) {
                $message->author_id = backpack_user()->id;
            }
        });
    }

    public function isSent() : bool
    {
        return $this->status == static::SENT;
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function users()
    {
        return $this->belongsToMany(User::class, 'message_user', 'message_id', 'user_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeReady($query)
    {
        $query->where('status', static::READY);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    public static function getStatusOptions() : array
    {
        return [
            static::SENT => 'Отправлено',
            static::DRAFT => 'Черновик',
        ];
    }

    public static function getConsumerOptions() : array
    {
        return \App\User::whereDoesntHave('roles')->pluck('email', 'id')->toArray();
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
