<?php

namespace App\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

use App\Models\Message;
use App\User;

class MessageUser extends Pivot
{

    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'message_user';
    protected $fillable = ['user_id', 'message_id', 'read_at'];
    protected $dates = ['read_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function message()
    {
        return $this->belongsTo(Message::class, 'message_id');
    }


}
