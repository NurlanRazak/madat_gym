<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\EathourRequest as StoreRequest;
use App\Http\Requests\EathourRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use App\Services\MenuService\Traits\AccessLevelsTrait;

/**
 * Class EathourCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class EathourCrudController extends CrudController
{
    use AccessLevelsTrait;
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Eathour');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/eathour');
        $this->crud->setEntityNameStrings(trans_choice('admin.eathour', 1), trans_choice('admin.eathour', 2));
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
            'name' => 'hour_start',
            'label' => 'Время начала',
            'type' => 'text',
        ],
        false,
        function ($value) {
            $this->crud->addClause('where', 'hour_start', $value);
        });
        $this->crud->addFilter([
            'name' => 'hour_finish',
            'label' => 'Время окончания',
            'type' => 'text',
        ],
        false,
        function ($value) {
            $this->crud->addClause('where', 'hour_finish', $value);
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
                'name' => 'hour_start',
                'label' => 'Время начала',
            ],
            [
                'name' => 'hour_finish',
                'label' => 'Время окончания',
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
                'name' => 'active',
                'label' => 'Опубликован',
                'type' => 'checkbox'
            ],
        ]);
        // add asterisk for fields that are required in EathourRequest
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
                'name' => $this->crud->entry->name,
                'type' => 'planeat',
                'hour_start' => $this->crud->entry->hour_start,
                'hour_finish' => $this->crud->entry->hour_finish
            ]
        ]);
    }

}
