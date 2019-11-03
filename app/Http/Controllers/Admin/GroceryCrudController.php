<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\GroceryRequest as StoreRequest;
use App\Http\Requests\GroceryRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class GroceryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class GroceryCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Grocery');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/grocery');
        $this->crud->setEntityNameStrings(trans_choice('admin.grocery', 1), trans_choice('admin.grocery', 2));

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        
        $this->crud->addColumns([
            [
                'name' => 'notify_day',
                'label' => 'День оповещения', 
            ],
            [
                'name' => 'description',
                'label' => 'Комментарии',
            ],
            [
                'name' => 'training_id',
                'label' => 'Тренировки',
                'type' => 'select',
                'entity' => 'trainings',
                'attribute' => 'name',
                'model' => 'App\Models\Training',
            ],
            [
                'name' => 'meal_id',
                'label' => 'Блюдо',
                'type' => 'select',
                'entity' => 'meals',
                'attribute' => 'name',
                'model' => 'App\Models\Meal',
            ],
            [
                'name' => 'active',
                'label' => 'Опубликован',
                'type' => 'check',
            ],
        ]);

        $this->crud->addFields([
            [
                'name' => 'notify_day',
                'label' => 'День оповещения', 
            ],
            [
                'name' => 'description',
                'label' => 'Комментарии',
            ],
            [
                'name' => 'training_id',
                'label' => 'Тренировки',
                'type' => 'select2',
                'entity' => 'trainings',
                'attribute' => 'name',
                'model' => 'App\Models\Training',
            ],
            [
                'name' => 'meal_id',
                'label' => 'Блюдо',
                'type' => 'select2',
                'entity' => 'meals',
                'attribute' => 'name',
                'model' => 'App\Models\Meal',
            ],
            [
                'name' => 'active',
                'label' => 'Опубликован',
                'type' => 'checkbox',
            ],
        ]);
        // add asterisk for fields that are required in GroceryRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
