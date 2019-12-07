<?php

namespace App\Composers;

use Illuminate\View\View;

class NotificationCountComposer
{

    public function compose(View $view)
    {
        $user = request()->user();
        if (!$user) {
            $count = 0;
        } else {
            $count = $user->messages()->wherePivot('read_at', null)->count();
        }
        $view->with('notification_count', $count);
    }

}
