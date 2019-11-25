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
        $this->crud->addFilter([
            'name' => 'active',
            'type' => 'select2',
            'label' => 'Опубликованные',
        ], function () {
            return [
                1 => 'Опубликованные',
                0 => 'Не опубликованные',
            ];
        }, function ($value) {
            $this->crud->addClause('where', 'active', $value);
        });
        $this->crud->addFilter([
            'name' => 'calorie',
            'label' => 'Калорийность в день',
            'type' => 'range',
            'label_from' => 'с',
            'label_to' => 'до'
        ],
        false,
        function ($value) {
            $range = json_decode($value);
            if ($range->from) {
                $this->crud->addClause('where', 'calorie', '>=', (float) $range->from);
            }
            if ($range->to) {
                $this->crud->addClause('where', 'calorie', '<=', (float) $range->to);
            }
        });
        $this->crud->addFilter([
            'name' => 'days',
            'label' => 'Количество дней',
            'type' => 'range',
            'label_from' => 'с',
            'label_to' => 'до'
        ],
        false,
        function ($value) {
            $range = json_decode($value);
            if ($range->from) {
                $this->crud->addClause('where', 'days', '>=', (float) $range->from);
            }
            if ($range->to) {
                $this->crud->addClause('where', 'days', '<=', (float) $range->to);
            }
        });
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
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [
                'name' => 'calorie',
                'label' => 'Калорийность в день',
                'type' => 'number',
                'attributes' => ["step" => "any"],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-8',
                ],
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [
                'name' => 'days',
                'label' => 'Количество дней',
                'type' => 'number',
                'attributes' => ["step" => "any"],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4',
                ],
                'attributes' => [
                    'required' => 'required',
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
