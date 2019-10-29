<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\PlaneatRequest as StoreRequest;
use App\Http\Requests\PlaneatRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class PlaneatCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class PlaneatCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Planeat');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/planeat');
        $this->crud->setEntityNameStrings(trans_choice('admin.planeat',1), trans_choice('admin.planeat', 2));

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->addColumns([
            [
                'name' => 'row_number',
                'type' => 'row_number',
                'label' => '#',
                'orderable' => false,
            ],
            [
                'name' => 'foodprogram_id',
                'label' => 'Программа питания',
                'type' => 'select',
                'entity' => 'foodprogram',
                'attribute' => 'name',
                'model' => 'App\Models\Foodprogram',
            ],
            [
                'name' => 'meal_id',
                'label' => 'Блюда',
                'type' => 'select',
                'entity' => 'meal',
                'attribute' => 'name',
                'model' => 'App\Models\Meal',
            ],
            [
                'name' => 'days',
                'label' => 'День в программе',
            ],
            [
                'name' => 'eathour_id',
                'label' => 'Час приема',
                'type' => 'select',
                'entity' => 'eathour',
                'attribute' => 'name',
                'model' => 'App\Models\Eathour',
            ],
            [
                'name' => 'active',
                'label' => 'Опубликован',
                'type' => 'check',
            ],
        ]);

        $this->crud->addFields([
            [
                'name' => 'foodprogram_id',
                'label' => 'Программа питания',
                'type' => 'select2',
                'entity' => 'foodprogram',
                'attribute' => 'name',
                'model' => 'App\Models\Foodprogram',
            ],
            [
                'name' => 'meal_id',
                'label' => 'Блюда',
                'type' => 'select2',
                'entity' => 'meal',
                'attribute' => 'name',
                'model' => 'App\Models\Meal',
            ],
            [
                'name' => 'days',
                'label' => 'День в программе',
            ],
            [
                'name' => 'eathour_id',
                'label' => 'Час приема',
                'type' => 'select2',
                'entity' => 'eathour',
                'attribute' => 'name',
                'model' => 'App\Models\Eathour',
            ],
            [
                'name' => 'active',
                'label' => 'Опубликован',
                'type' => 'checkbox',
            ],
        ]);

        // add asterisk for fields that are required in PlaneatRequest
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
