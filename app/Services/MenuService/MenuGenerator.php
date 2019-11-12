<?php

namespace App\Services\MenuService;

use Illuminate\Support\Facades\Facade;

class MenuGenerator extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'admin_menu_generator';
    }

}
