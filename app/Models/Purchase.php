<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use App\Models\Typepurchase;
use App\Models\Subscription;
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

    const KZT = 0;
    const USD = 1;
    const EUR = 2;

    protected $table = 'purchases';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['user_id', 'typepurchase_id', 'comment', 'status', 'start_date', 'subscription_id', 'currency'];
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

    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subscription_id');
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
    public static function getCurrencyOptions()
    {
        return [
            static::KZT => 'Тенге',
            static::USD => 'Доллар',
            static::EUR => 'Евро',
        ];
    }

    public static function getCurrencyKeys()
    {
        return [
            static::KZT => 'KZT',
            static::USD => 'USD',
            static::EUR => 'EUR',
        ];
    }

    public function getCurrencyKey(int $currency)
    {
        return static::getCurrencyKeys()[$currency];
    }

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
