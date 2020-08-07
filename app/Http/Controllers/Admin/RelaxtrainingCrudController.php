<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\RelaxtrainingRequest as StoreRequest;
use App\Http\Requests\RelaxtrainingRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use App\Services\MenuService\Traits\AccessLevelsTrait;
use App\Models\Relaxtraining;

/**
 * Class RelaxtrainingCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class RelaxtrainingCrudController extends CrudController
{
    use AccessLevelsTrait;
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Relaxtraining');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/relaxtraining');
        $this->crud->setEntityNameStrings(trans_choice('admin.relaxtraining', 1), trans_choice('admin.relaxtraining', 2));
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
            'name' => 'exercises',
            'label' => 'Упражнения',
            'type' => 'select2_multiple',
        ], function() {
            return \App\Models\Relaxexercise::all()->pluck('name', 'id')->toArray();
        }, function($values) {
            foreach(json_decode($values) as $key=>$value) {
                $this->crud->query = $this->crud->query->whereHas('exercises', function ($query) use ($value) {
                    $query->where('exercise_id', $value);
                });
            }
        });
        $this->crud->addFilter([
            'name' => 'programs',
            'label' => 'Программы отдыха',
            'type' => 'select2_multiple',
        ], function() {
            return \App\Models\Relaxprogram::all()->pluck('name', 'id')->toArray();
        }, function($values) {
            foreach (json_decode($values) as $key=>$value) {
                $this->crud->query = $this->crud->query->whereHas('programs', function($query) use ($value) {
                    $query->where('relaxprogram_id', $value);
                });
            }
        });
        $this->crud->addFilter([
            'name' => 'users',
            'label' => 'Пользователи',
            'type' => 'select2_multiple',
        ], function() {
            return \App\User::whereDoesntHave('roles')->pluck('email', 'id')->toArray();
        }, function($values) {
            foreach (json_decode($values) as $key=>$value) {
                $this->crud->query = $this->crud->query->whereHas('users', function ($query) use ($value) {
                    $query->where('user_id', $value);
                });
            }
        });
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->addColumns([
            [
                'name' => 'name',
                'label' => 'Название',
            ],
            [
                'name' => 'exercises',
                'label' => 'Упражнения',
                'type' => 'select_multiple',
                'entity' => 'exercises',
                'attribute' => 'name',
                'model' => 'App\Models\Relaxexercise'
            ],
            [
                'name' => 'programs',
                'label' => 'Программы отдыха',
                'type' => 'select_multiple',
                'entity' => 'programs',
                'attribute' => 'name',
                'model' => 'App\Models\Relaxprogram'
            ],
            [
                'name' => 'hour_start',
                'label' => 'Время начала',
            ],
            [
                'name' => 'hour_finish',
                'label' => 'Время окончания',
            ],
            [
                'name' => 'users',
                'label' => 'Пользователи',
                'type' => 'select_multiple',
                'entity' => 'users',
                'attribute' => 'email',
                'model' => 'App\User'
            ],
            [
                'name' => 'number_day',
                'label' => 'Номер дня',
            ],
            [
                'name' => 'time',
                'label' => 'Время',
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
                'name' => 'exercises',
                'label' => 'Упражнения',
                'type' => 'select2_multiple',
                'entity' => 'exercises',
                'attribute' => 'name',
                'model' => 'App\Models\Relaxexercise',
                'pivot' => true,
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [
                'name' => 'programs',
                'label' => 'Программы отдыха',
                'type' => 'select2_multiple',
                'entity' => 'programs',
                'attribute' => 'name',
                'model' => 'App\Models\Relaxprogram',
                'pivot' => true,
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [
                'name' => 'users',
                'label' => 'Пользователи',
                'type' => 'select2_multiple',
                'entity' => 'users',
                'model' => 'App\User',
                'attribute' => 'email',
                'pivot' => true,
                'options'   => (function ($query) {
                    return $query->whereDoesntHave('roles')->get();
                })
            ],
            [
                'name' => 'number_day',
                'label' => 'Номер дня',
                'type' => 'number',
                'attributes' => [
                    "step" => "any",
                    'required' => 'required',
                ],
                'wrapperAttributes' => [
                    'class' => 'form-group col-sm-12 required',
                ],

            ],
            [
                'name' => 'hour_start',
                'label' => 'Время начала',
                'type' => 'time',
                'default' => '09:00',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name' => 'hour_finish',
                'label' => 'Время окончания',
                'type' => 'time',
                'default' => '13:00',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            //TODO time fix
            // [
            //     'name' => 'time',
            //     'label' => 'Время',
            //     'type' => 'time',
            //     'attributes' => [
            //         'required' => 'required',
            //     ],
            //     'wrapperAttributes' => [
            //         'class' => 'form-group col-sm-12 required',
            //     ],
            // //     'type' => 'date_range',
            // //     'start_name' => 'start_date', // the db column that holds the start_date
            // //     'end_name' => 'end_date',
            // // // OPTIONALS
            // //     'start_default' => '2019-12-28 01:01', // default value for start_date
            // //     'end_default' => '2019-12-28 02:00', // default value for end_date
            // //     'date_range_options' => [ // options sent to daterangepicker.js
            // //         'timePicker' => true,
            // //         'locale' => ['format' => 'HH:mm']
            // //     ]
            // ],
            [
                'name' => 'active',
                'label' => 'Опубликован',
                'type' => 'checkbox',
            ],
        ]);

        // add asterisk for fields that are required in RelaxtrainingRequest
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
