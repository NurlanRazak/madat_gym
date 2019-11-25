<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ActiveprogramRequest as StoreRequest;
use App\Http\Requests\ActiveprogramRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use App\Services\MenuService\Traits\AccessLevelsTrait;

/**
 * Class ActiveprogramCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ActiveprogramCrudController extends CrudController
{
    use AccessLevelsTrait;

    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Activeprogram');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/activeprogram');
        $this->crud->setEntityNameStrings(trans_choice('admin.activeprogram', 1), trans_choice('admin.activeprogram', 2));
        $this->setAccessLevels();
        $this->crud->addFilter([
            'name' => 'program_id',
            'label' => 'Программы тренировок',
            'type' => 'select2',
        ], function() {
            return \App\Models\Programtraining::all()->pluck('name', 'id')->toArray();
        }, function($value) {
            $this->crud->addClause('where', 'program_id', $value);
        });

        $this->crud->addFilter([ // daterange filter
          'type' => 'date_range',
          'name' => 'date_start',
          'label'=> 'Дата активации'
        ],
        false,
        function($value) { // if the filter is active, apply these constraints
          $dates = json_decode($value);
          $this->crud->addClause('where', 'date_start', '>=', $dates->from);
          $this->crud->addClause('where', 'date_start', '<=', $dates->to . ' 23:59:59');
        });
        $this->crud->addFilter([ // daterange filter
          'type' => 'date_range',
          'name' => 'date_finish',
          'label'=> 'Дата завершения'
        ],
        false,
        function($value) { // if the filter is active, apply these constraints
          $dates = json_decode($value);
          $this->crud->addClause('where', 'date_finish', '>=', $dates->from);
          $this->crud->addClause('where', 'date_finish', '<=', $dates->to . ' 23:59:59');
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
                'name' => 'program_id',
                'label' => 'Программа',
                'type' => 'select',
                'entity' => 'program',
                'attribute' => 'name',
                'model'     => 'App\Models\Programtraining',
            ],
            [
                'name' => 'date_start',
                'label' => 'Дата активации',
                'type' => "datetime",
                'format' => 'l',
            ],
            [
                'name' => 'date_finish',
                'label' => 'Дата завершения',
                'type' => "datetime",
                'format' => 'l',
            ],
        ]);
        $this->crud->addFields([
            [
                'name' => 'program_id',
                'label' => 'Программа',
                'type' => 'select2',
                'entity' => 'program',
                'attribute' => 'name',
                'model'     => 'App\Models\Programtraining',
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [
                'name' => 'date_start',
                'label' => 'Дата активации',
                'type' => 'datetime_picker',
                // optional:
                'datetime_picker_options' => [
                    'format' => 'DD/MM/YYYY HH:mm',
                    'language' => 'fr'
                ],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [
                'name' => 'date_finish',
                'label' => 'Дата завершения',
                'type' => 'datetime_picker',
                // optional:
                'datetime_picker_options' => [
                    'format' => 'DD/MM/YYYY HH:mm',
                    'language' => 'fr'
                ],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 '
                ],
                'attributes' => [
                    'required' => 'required',
                ],
            ],
        ]);

        // add asterisk for fields that are required in ActiveprogramRequest
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
