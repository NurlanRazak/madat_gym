<?php

namespace App\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\Subscription;
use App\User;

class SubscriptionUser extends Pivot
{

    public $incrementing = true;
    public $timestamps = false;

    protected $table = 'subscription_user';
    protected $fillable = ['user_id', 'subscription_id', 'created_at'];
    protected $dates = ['bought_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subscription_id');
    }


}
