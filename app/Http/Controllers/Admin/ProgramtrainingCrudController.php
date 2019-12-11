<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ProgramtrainingRequest as StoreRequest;
use App\Http\Requests\ProgramtrainingRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use App\Services\MenuService\Traits\AccessLevelsTrait;

/**
 * Class ProgramtrainingCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ProgramtrainingCrudController extends CrudController
{
    use AccessLevelsTrait;
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Programtraining');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/programtraining');
        $this->crud->setEntityNameStrings(trans_choice('admin.programtraining', 1), trans_choice('admin.programtraining', 2));
        $this->setAccessLevels();
        $this->crud->addFilter([
            'name' => 'active',
            'type' => 'select2',
            'label' => 'Опубликованные',
        ], function() {
            return [
                1 => 'Опубликованные',
                0 => 'Не опубликованные',
            ];
        }, function ($value) {
            $this->crud->addClause('where', 'active', $value);
        });
        $this->crud->addFilter([
            'name' => 'programtype_id',
            'type' => 'select2',
            'label' => 'Тип программы'
        ], function() {
            return \App\Models\Programtype::all()->pluck('name', 'id')->toArray();
        }, function ($value) {
            $this->crud->addClause('where', 'programtype_id', $value);
        });
        $this->crud->addFilter([
            'name' => 'foodprogram_id',
            'type' => 'select2',
            'label' => 'Программа питания',
        ], function() {
            return \App\Models\Foodprogram::all()->pluck('name', 'id')->toArray();
        }, function ($value) {
            $this->crud->addClause('where', 'foodprogram_id', $value);
        });
        $this->crud->addFilter([
            'name' => 'relaxprogram_id',
            'type' => 'select2',
            'label' => 'Программа отдыха',
        ], function() {
            return \App\Models\Relaxprogram::all()->pluck('name', 'id')->toArray();
        }, function ($value) {
            $this->crud->addClause('where', 'relaxprogram_id', $value);
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
        $this->crud->addFilter([
            'name' => 'duration',
            'label' => 'Длительность (в днях)',
            'type' => 'range',
            'label_from' => 'с',
            'label_to' => 'до'
        ],
        false,
        function ($value) {
            $range = json_decode($value);
            if ($range->from) {
                $this->crud->addClause('where', 'duration', '>=', (float) $range->from);
            }
            if ($range->to) {
                $this->crud->addClause('where', 'duration', '<=', (float) $range->to);
            }
        });
        $this->crud->addFilter([
            'name' => 'agerestrict',
            'label' => 'Возрастные ограничения',
            'type' => 'range',
            'label_from' => 'с',
            'label_to' => 'до'
        ],
        false,
        function ($value) {
            $range = json_decode($value);
            if ($range->from) {
                $this->crud->addClause('where', 'agerestrict', '>=', (float) $range->from);
            }
            if ($range->to) {
                $this->crud->addClause('where', 'agerestrict', '<=', (float) $range->to);
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
                'name' => 'agerestrict',
                'label' => 'Возрастные ограничения',
            ],
            [
                'name' => 'description',
                'label' => 'Описание',
                'type' => 'textarea',
            ],
            [
                'name' => 'image',
                'label' => 'Изображение',
                'type' => 'image',
                'width' => '150px',
                'height' => '150px',
                'prefix' => 'uploads/',
            ],
            [
                'name' => 'duration',
                'label' => 'Длительность (в днях)',
            ],
            [
                'name' => 'price',
                'label' => 'Цена',
            ],
            [
                'name' => 'programtype_id',
                'label' => 'Тип программы',
                'type' => 'select',
                'entity' => 'programtype',
                'attribute' => 'name',
                'model' => 'App\Models\Programtype',
            ],
            [
                'name' => 'foodprogram_id',
                'label' => 'Программы питания',
                'type' => 'select',
                'entity' => 'foodprogram',
                'attribute' => 'name',
                'model' => 'App\Models\Foodprogram',
            ],
            [
                'name' => 'relaxprogram_id',
                'label' => 'Программы отдыха',
                'type' => 'select',
                'entity' => 'relaxprogram',
                'attribute' => 'name',
                'model' => 'App\Models\Relaxprogram',
            ],
            // [
            //     'name' => 'active',
            //     'label' => 'Опубликован',
            //     'type' => 'check',
            // ],
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
                'name' => 'agerestrict',
                'label' => 'Возрастные ограничения',
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [
                'name' => 'description',
                'label' => 'Описание',
                'type' => 'textarea',
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [
                'name' => 'image',
                'label' => 'Изображение',
                'type' => 'image',
                'disk' => 'uploads',
                'upload' => true,
                'crop' => true,
                'aspect_ratio' => 0,
            ],
            [
                'name' => 'duration',
                'label' => 'Длительность (в днях)',
                'type' => 'number',
                'attributes' => ["step" => "any"],
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [
                'name' => 'price',
                'label' => 'Цена',
                'type' => 'number',
                'attributes' => ["step" => "0.001"],
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [
                'name' => 'programtype_id',
                'label' => 'Тип программы',
                'type' => 'select2',
                'entity' => 'programtype',
                'attribute' => 'name',
                'model' => 'App\Models\Programtype',
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [
                'name' => 'foodprogram_id',
                'label' => 'Программы питания',
                'type' => 'select2',
                'entity' => 'foodprogram',
                'attribute' => 'name',
                'model' => 'App\Models\Foodprogram',
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [
                'name' => 'relaxprogram_id',
                'label' => 'Программы отдыха',
                'type' => 'select2',
                'entity' => 'relaxprogram',
                'attribute' => 'name',
                'model' => 'App\Models\Relaxprogram',
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            // [
            //     'name' => 'active',
            //     'label' => 'Опубликован',
            //     'type' => 'checkbox',
            // ],
        ]);
        // add asterisk for fields that are required in ProgramtrainingRequest
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
