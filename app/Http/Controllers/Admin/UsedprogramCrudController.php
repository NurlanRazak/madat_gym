<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\UserparameterRequest as StoreRequest;
use App\Http\Requests\UserparameterRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use App\Models\Userparameter;
use Carbon\Carbon;

/**
 * Class UserparameterCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class UsedprogramCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Userparameter');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/contentview');
        $this->crud->setEntityNameStrings(trans_choice('admin.userparameter', 1), trans_choice('admin.userparameter', 2));
        $this->crud->denyAccess('create');
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
            'name' => 'waist',
            'label' => 'Талия',
            'type' => 'range',
            'label_from' => 'с',
            'label_to' => 'до'
        ],
        false,
        function ($value) {
            $range = json_decode($value);
            if ($range->from) {
                $this->crud->addClause('where', 'waist', '>=', (float) $range->from);
            }
            if ($range->to) {
                $this->crud->addClause('where', 'waist', '<=', (float) $range->to);
            }
        });
        $this->crud->addFilter([
            'name' => 'leg_volume',
            'label' => 'Объем ноги',
            'type' => 'range',
            'label_from' => 'с',
            'label_to' => 'до'
        ],
        false,
        function ($value) {
            $range = json_decode($value);
            if ($range->from) {
                $this->crud->addClause('where', 'leg_volume', '>=', (float) $range->from);
            }
            if ($range->to) {
                $this->crud->addClause('where', 'leg_volume', '<=', (float) $range->to);
            }
        });
        $this->crud->addFilter([
            'name' => 'arm_volume',
            'label' => 'Объем рук',
            'type' => 'range',
            'label_from' => 'с',
            'label_to' => 'до'
        ],
        false,
        function ($value) {
            $range = json_decode($value);
            if ($range->from) {
                $this->crud->addClause('where', 'arm_volume', '>=', (float) $range->from);
            }
            if ($range->to) {
                $this->crud->addClause('where', 'arm_volume', '<=', (float) $range->to);
            }
        });
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // add asterisk for fields that are required in UserparameterRequest
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
