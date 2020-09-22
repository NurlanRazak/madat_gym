<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\TrainingRequest as StoreRequest;
use App\Http\Requests\TrainingRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use App\Services\MenuService\Traits\AccessLevelsTrait;
use App\Models\Exercise;
use App\Models\Programtraining;

/**
 * Class TrainingCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class TrainingCrudController extends CrudController
{
    use AccessLevelsTrait;
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Training');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/training');
        $this->crud->setEntityNameStrings(trans_choice('admin.training', 1), trans_choice('admin.training', 2));
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
            'name' => 'user_id',
            'type' => 'select2',
            'label' => 'Пользователь',
        ], function() {
            return \App\User::whereDoesntHave('roles')->pluck('email', 'id')->toArray();
        }, function ($value) {
            $this->crud->addClause('where', 'user_id', $value);
        });
        $this->crud->addFilter([
            'name' => 'exercises',
            'type' => 'select2_multiple',
            'label' => 'Упражнения'
        ], function() {
            return Exercise::all()->pluck('name', 'id')->toArray();
        }, function($values) {
            foreach (json_decode($values) as $key => $value) {
                $this->crud->query = $this->crud->query->whereHas('exercises', function ($query) use ($value) {
                    $query->where('exercise_id', $value);
                });
            }
        });
        $this->crud->addFilter([
            'name' => 'programtrainings',
            'type' => 'select2_multiple',
            'label' => 'Программы тренировок',
        ], function () {
            return Programtraining::all()->pluck('name', 'id')->toArray();
        }, function ($values) {
            foreach (json_decode($values) as $key => $value) {
                $this->crud->query = $this->crud->query->whereHas('programtrainings', function ($query) use ($value) {
                    $query->where('programtraining_id', $value);
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
                'model' => 'App\Models\Exercise',
            ],
            [
                'name' => 'programtrainings',
                'label' => 'Программа',
                'type' => 'select_multiple',
                'entity' => 'programtrainings',
                'attribute' => 'name',
                'model' => 'App\Models\Programtraining',
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
                'name' => 'user_id',
                'label' => 'Пользователь',
                'type' => 'select',
                'entity' => 'user',
                'attribute' => 'email',
                'model' => 'App\User',
            ],
            [
                'name' => 'day_number',
                'label' => 'Номер дня',
            ],
            [
                'name' => 'approaches_number',
                'label' => 'Количество подходов',
            ],
            [
                'name' => 'repetitions_number',
                'label' => 'Количество повторений',
            ],
            [
                'name' => 'weight',
                'label' => 'Вес',
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
                'label' => 'Название',
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [
                'name' => 'exercises',
                'label' => 'Упражнение',
                'type' => 'select2_multiple',
                'entity' => 'exercises',
                'attribute' => 'name',
                'model' => 'App\Models\Exercise',
                'pivot' => true,
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [
                'name' => 'programtrainings',
                'label' => 'Программа',
                'type' => 'select2_multiple',
                'entity' => 'programtrainings',
                'attribute' => 'name',
                'model' => 'App\Models\Programtraining',
                'pivot' => true,
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [
                'name' => 'user_id',
                'label' => 'Пользователь',
                'type' => 'select2',
                'entity' => 'user',
                'attribute' => 'email',
                'model' => 'App\User',

            ],
            [
                'name' => 'hour_start',
                'label' => 'Время начала',
                'type' => 'time',
                'default' => '09:00',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 required',
                ],
            ],
            [
                'name' => 'hour_finish',
                'label' => 'Время окончания',
                'type' => 'time',
                'default' => '13:00',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 required',
                ],
            ],
            [
                'name' => 'day_number',
                'label' => 'Номер дня',
                'type' => 'number',
                'attributes' => [
                    "step" => "any",
                    'required' => 'required',
                ],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
            ],
            [
                'name' => 'approaches_number',
                'label' => 'Количество подходов',
                'type' => 'number',
                'attributes' => ["step" => "any"],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
            ],
            [
                'name' => 'repetitions_number',
                'label' => 'Количество повторений',
                'type' => 'number',
                'attributes' => ["step" => "any"],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
            ],
            [
                'name' => 'weight',
                'label' => 'Вес',
                'type' => 'number',
                'attributes' => [
                    "step" => "any",
                    'required' => 'required',

                ],
            ],
            [
                'name' => 'active',
                'label' => 'Опубликован',
                'type' => 'checkbox'
            ],
        ]);

        // add asterisk for fields that are required in TrainingRequest
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
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->getSaveAction();
        $this->data['fields'] = $this->crud->getCreateFields();
        unset($this->data['fields']['day_number']);
        $this->data['title'] = $this->crud->getTitle() ?? trans('backpack::crud.add').' '.$this->crud->entity_name;
        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view('admin.modal', $this->data);
    }

    public function postModal()
    {
        $redirect_location = parent::storeCrud(request());
        $this->crud->entry->delete();
        return view('admin.postModal', [
            'data' => [
                'id' => $this->crud->entry->id,
                'name' => $this->crud->entry->name
            ]
        ]);
    }
}
