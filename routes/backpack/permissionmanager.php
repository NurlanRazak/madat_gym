<?php

/*
|--------------------------------------------------------------------------
| Backpack\PermissionManager Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the Backpack\PermissionManager package.
|
*/

Route::group([
            'namespace'  => 'App\Http\Controllers\Admin',
            'prefix'     => config('backpack.base.route_prefix', 'admin'),
            'middleware' => ['web', backpack_middleware()],
    ], function () {
        CRUD::resource('permission', 'PermissionCrudController');
        CRUD::resource('role', 'RoleCrudController');
        CRUD::resource('user', 'UserCrudController');
        CRUD::resource('consumer', 'ConsumerCrudController');
    });
