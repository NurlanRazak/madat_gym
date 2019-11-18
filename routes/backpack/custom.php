<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    CRUD::resource('subscription', 'SubscriptionCrudController');
    CRUD::resource('programtype', 'ProgramtypeCrudController');
    CRUD::resource('foodprogram', 'FoodprogramCrudController');
    CRUD::resource('relaxprogram', 'RelaxprogramCrudController');
    CRUD::resource('programtraining', 'ProgramtrainingCrudController');
    CRUD::resource('activeprogram', 'ActiveprogramCrudController');
    CRUD::resource('exercise', 'ExerciseCrudController');
    CRUD::resource('meal', 'MealCrudController');
    CRUD::resource('eathour', 'EathourCrudController');
    CRUD::resource('planeat', 'PlaneatCrudController');
    CRUD::resource('training', 'TrainingCrudController');
    CRUD::resource('equipment', 'EquipmentCrudController');
    CRUD::resource('grocery', 'GroceryCrudController');
    CRUD::resource('relaxexercise', 'RelaxexerciseCrudController');
    CRUD::resource('relaxtraining', 'RelaxtrainingCrudController');
    CRUD::resource('message', 'MessageCrudController');

    Route::group([
        'prefix' => 'api',
        'namespace' => '\App\Http\Controllers\Api',
    ], function() {
        Route::post('message/send', 'MessageController@send')->name('admin-message-send');
        Route::post('message/cancel', 'MessageController@cancel')->name('admin-message-cancel');
    });
    CRUD::resource('typepurchase', 'TypepurchaseCrudController');
    CRUD::resource('purchase', 'PurchaseCrudController');
    CRUD::resource('userparameter', 'UserparameterCrudController');
}); // this should be the absolute last line of this file