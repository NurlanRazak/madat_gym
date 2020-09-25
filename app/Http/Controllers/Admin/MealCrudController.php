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
        $this->crud->addFilter([
            'name' => 'calorie',
            'label' => 'Калорийность',
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
            'name' => 'weight',
            'label' => 'Вес',
            'type' => 'range',
            'label_from' => 'с',
            'label_to' => 'до'
        ],
        false,
        function ($value) {
            $range = json_decode($value);
            if ($range->from) {
                $this->crud->addClause('where', 'weight', '>=', (float) $range->from);
            }
            if ($range->to) {
                $this->crud->addClause('where', 'weight', '<=', (float) $range->to);
            }
        });
        $this->crud->addFilter([
            'name' => 'price',
            'label' => 'Цена',
            'type' => 'range',
            'label_from' => 'с',
            'label_to' => 'до'
        ],
        false,
        function ($value) {
            $range = json_decode($value);
            if ($range->from) {
                $this->crud->addClause('where', 'price', '>=', (float) $range->from);
            }
            if ($range->to) {
                $this->crud->addClause('where', 'price', '<=', (float) $range->to);
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
                'attributes' => [
                    'required' => 'required',
                ],
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
                'attributes' => [
                    'required' => 'required',
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
                'attributes' => [
                    'required' => 'required',
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
                'attributes' => [
                    'required' => 'required',
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


    public function modal()
    {
        $this->data['extra'] = request()->input();
        foreach($this->data['extra'] as $key => $value) {
            if (!$value) {
                unset($this->data['extra'][$key]);
                continue;
            }
            $this->crud->removeField($key);
        }

        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->getSaveAction();
        $this->data['fields'] = $this->crud->getCreateFields();
        $this->data['title'] = $this->crud->getTitle() ?? trans('backpack::crud.add').' '.$this->crud->entity_name;
        $this->data['type'] = 'subitem';
        $this->data['options'] = $this->crud->model->active()->get()->map(function($item) {
            return $item->toCalendar();
        })->toArray();
        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view('admin.modal', $this->data);
    }

    public function postModal()
    {
        $redirect_location = parent::storeCrud(request());
        $this->crud->entry->delete();
        return view('admin.postModal', [
            'type' => 'subitem',
            'data' => [
                'id' => $this->crud->entry->id,
                'name' => $this->crud->entry->name,
            ]
        ]);
    }

}
