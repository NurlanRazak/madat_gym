<?php

namespace App\Models\Pivots;

use App\Models\Subscription;
use App\User;

class SubscriptionUser
{

    public $incrementing = true;

    protected $table = 'subscription_user';
    protected $fillable = ['user_id', 'subscription_id', 'created_at'];
    protected $dates = ['created_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subscription_id');
    }


}
