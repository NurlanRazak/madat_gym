<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\MealRequest as StoreRequest;
use App\Http\Requests\MealRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use App\Services\MenuService\Traits\AccessLevelsTrait;

/**
 * Class MealCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class MealCrudController extends CrudController
{
    use AccessLevelsTrait;
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Meal');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/meal');
        $this->crud->setEntityNameStrings(trans_choice('admin.meal',1), trans_choice('admin.meal', 2));
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
                'label' => 'Название',
            ],
            [
                'name' => 'description',
                'label' => 'Описание',
            ],
            // [
            //     'name' => 'listmeals',
            //     'label' => trans_choice('admin.listmeal', 2),
            //     'type' => 'select_multiple',
            //     'entity' => 'listmeals',
            //     'attribute' => 'name',
            //     'model' => 'App\Models\Listmeal',
            //     'pivot' => true,
            // ],
            [
                'name' => 'calorie',
                'label' => 'Калорийность',
            ],
            [
                'name' => 'weight',
                'label' => 'Вес',
            ],
            [
                'name' => 'price',
                'label' => 'Цена',
            ],
            [
                'name' => 'active',
                'label' => 'Опубликован',
                'type' => 'check',
            ],
        ]);

        $this->crud->addFields([
            [
                'name' => 'name',
                'label' => 'Название',
            ],
            [
                'name' => 'description',
                'label' => 'Описание',
                'type' => 'ckeditor',
            ],
            [
                'name' => 'calorie',
                'label' => 'Калорийность',
                'type' => 'number',
                'attributes' => ["step" => "any"],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4',
                ],
            ],
            [
                'name' => 'weight',
                'label' => 'Вес',
                'type' => 'number',
                'attributes' => ["step" => "any"],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4',
                ],
            ],
            [
                'name' => 'price',
                'label' => 'Цена',
                'type' => 'number',
                'attributes' => ["step" => "any"],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4',
                ],
            ],
            // [
            //     'name' => 'listmeals',
            //     'label' => trans_choice('admin.listmeal', 2),
            //     'type' => 'select2_multiple',
            //     'entity' => 'listmeals',
            //     'attribute' => 'name',
            //     'model' => 'App\Models\Listmeal',
            //     'pivot' => true,
            // ],
            [
                'name' => 'active',
                'label' => 'Опубликован',
                'type' => 'checkbox',
            ],
        ]);

        // add asterisk for fields that are required in MealRequest
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
