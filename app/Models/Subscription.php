<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use App\User;
use App\Models\Pivots\SubscriptionUser;
use App\Models\Purchase;

class Subscription extends Model
{
    use CrudTrait;

    const KZT = 0;
    const USD = 1;
    const EUR = 2;
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'subscriptions';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'days', 'price', 'expires', 'active', 'currency'];
    // protected $hidden = [];
    protected $dates = ['expires'];

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
    public function users()
    {
        return $this->belongsToMany(User::class, 'subscription_user', 'subscription_id', 'user_id')
                    ->withPivot(['id', 'created_at', 'bought_at'])
                    ->using(SubscriptionUser::class);
    }

    public function rawusers()
    {
        return $this->hasMany(SubscriptionUser::class, 'subscription_id');
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'subscription_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
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

    public static function getCurrencyIcons()
    {
        return [
            static::KZT => '₸',
            static::USD => '$',
            static::EUR => '€',
        ];
    }

    public function getCurrencyIcon()
    {
        return static::getCurrencyIcons()[$this->currency];
    }

    public function getCurrencyKey(int $currency)
    {
        return static::getCurrencyKeys()[$currency];
    }

    public function getNameDateAttribute()
    {
        return "<b>{$this->name}</b>: {$this->pivot->created_at->format('Y-m-d')}";
    }

    public function getUsersTableAttribute()
    {
        return $this->users()->get()->toArray();
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
