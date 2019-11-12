<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\FoodprogramRequest as StoreRequest;
use App\Http\Requests\FoodprogramRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use App\Services\MenuService\Traits\AccessLevelsTrait;

/**
 * Class FoodprogramCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class FoodprogramCrudController extends CrudController
{
    use AccessLevelsTrait;
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Foodprogram');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/foodprogram');
        $this->crud->setEntityNameStrings(trans_choice('admin.foodprogram', 1), trans_choice('admin.foodprogram', 2));
        $this->setAccessLevels();

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
                'name' => 'name',
                'label' => 'Название программы',
            ],
            [
                'name' => 'calorie',
                'label' => 'Калорийность в день',
            ],
            [
                'name' => 'days',
                'label' => 'Количество дней',
            ],
            [
                'name' => 'active',
                'label' => 'Опубликован',
                'type' => 'check'
            ],
        ]);
        $this->crud->addFields([
            [
                'name' => 'name',
                'label' => 'Название программы',
            ],
            [
                'name' => 'calorie',
                'label' => 'Калорийность в день',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-8',
                ],
            ],
            [
                'name' => 'days',
                'label' => 'Количество дней',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4',
                ],
            ],
            [
                'name' => 'active',
                'label' => 'Опубликован',
                'type' => 'checkbox',
            ],
        ]);

        // add asterisk for fields that are required in FoodprogramRequest
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
