<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Composers\NotificationCountComposer;
use App\Composers\AbonimentStatisticsComposer;
use App\Composers\ProgramStatisticsComposer;
use App\Composers\CalendarComposer;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layouts.header-menu', NotificationCountComposer::class);
        View::composer('backpack::dashboard', AbonimentStatisticsComposer::class);
        View::composer('backpack::dashboard', ProgramStatisticsComposer::class);
        View::composer('backpack::dashboard', CalendarComposer::class);

        View::composer('layouts.master', function($view) {
            $view->with(['user' => request()->user()]);
        });
    }
}
