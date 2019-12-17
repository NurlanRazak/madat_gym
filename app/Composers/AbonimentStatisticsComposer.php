<?php

namespace App\Composers;

use Illuminate\View\View;

class AbonimentStatisticsComposer
{

    public function compose(View $view)
    {
        $labels = [];
        for($i=0; $i < 12 ; ++$i) {
            $date_first = \Date::parse(strtotime("first day of -{$i} months"));
            $date_last = \Date::parse(strtotime("last day of -{$i} months"));
            $labels[] = mb_ucfirst($date_first->format('F'));
        }

        $subscriptions = \App\Models\Subscription::get();
        $data = [];

        foreach($subscriptions as $index => $subscription) {
            $data[$index]['label'] = $subscription->name;
            $data[$index]['backgroundColor'] = "rgba(".rand(100, 255).",".rand(100, 255).",".rand(100, 200).", 0.6)";
            $data[$index]['data'] = [];
            for($i=0; $i < 12 ; ++$i) {
                $date_first = \Date::parse(strtotime("first day of -{$i} months"));
                $date_last = \Date::parse(strtotime("last day of -{$i} months"));

                $cnt = \App\Models\Pivots\SubscriptionUser::where('subscription_id', $subscription->id)
                                                          ->where('created_at', '>=', $date_first->format('Y-m-d'))
                                                          ->where('created_at', '<=', $date_last->format('Y-m-d'))
                                                          ->count();
                $data[$index]['data'][] = $cnt;

            }
        }

        $view->with('aboniment_statistics_data', $data);
        $view->with('aboniment_statistics_labels', $labels);
    }

}
