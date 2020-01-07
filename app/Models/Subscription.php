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

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'subscriptions';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'days', 'price', 'expires', 'active'];
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
                    ->withPivot(['id', 'created_at'])
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
