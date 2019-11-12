<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\MenuService\AdminMenuGenerator;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('admin_menu_generator', function()
        {
            return new AdminMenuGenerator();
        });
    }

}
