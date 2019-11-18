<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use App\Models\Typepurchase;
use App\User;

class Purchase extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    //TODO consts to status
    const PAID = 1;
    const NOTPAID = 0;

    protected $table = 'purchases';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['user_id', 'typepurchase_id', 'comment', 'status', 'start_date'];
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
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function typepurchase()
    {
        return $this->belongsTo(Typepurchase::class, 'typepurchase_id');
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    public static function getConsumerOptions() : array
    {
        return \App\User::whereDoesntHave('roles')->pluck('email', 'id')->toArray();
    }

    public static function getStatusOptions() : array
    {
        return [
            static::PAID => 'Оплачено',
            static::NOTPAID => 'Не оплачено'
        ];
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
