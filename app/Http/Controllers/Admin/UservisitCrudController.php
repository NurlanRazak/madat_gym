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
class UservisitCrudController extends CrudController
{

    protected $dates = null;

    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\User');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/uservisit');
        $this->crud->setEntityNameStrings('Посещений пользователей', 'Посещений пользователей');
        $this->crud->denyAccess(['create', 'update', 'delete']);
        $this->crud->removeAllButtons();
        $this->crud->addClause('whereDoesntHave', 'roles');

        $this->crud->query->withCount('sessions');

        $this->crud->addFilter([ // daterange filter
          'type' => 'date_range',
          'name' => 'date_start',
          'label'=> 'Дата'
        ],
        false,
        function($value) { // if the filter is active, apply these constraints
            $this->dates = json_decode($value);
        });

        $this->crud->addFilter([
            'name' => 'cnt',
            'label' => 'Количество посещений',
            'type' => 'range',
            'label_from' => 'с',
            'label_to' => 'до'
        ],
        false,
        function ($value) {
            $range = json_decode($value);
            if ($range->from) {
                $this->crud->addClause('has', 'sessions', '>=', $range->from);
            }
            if ($range->to) {
                $this->crud->addClause('has', 'sessions', '<=', $range->to);
            }
        });

        $this->crud->addFilter([
            'name' => 'users',
            'label' => 'Пользователи',
            'type' => 'select2_multiple',
        ], function() {
            return \App\User::whereDoesntHave('roles')->pluck('email', 'id')->toArray();
        }, function($values) {
            $values = json_decode($values);
            $this->crud->addClause('whereIn', 'id', $values);
        });


        $this->crud->addColumns([
            [
                'name' => 'row_number',
                'label' => '#',
                'type' => 'row_number',
            ],
            [
                'name' => 'email',
                'label' => 'Пользователь',
                'type' => 'closure',
                'function' => function($user) {
                    return "<a href=\"/admin/consumer/{$user->id}\">{$user->name}</a>";
                }
            ],
            [
                'name' => 'sessions_count',
                'label' => 'Количество посещений',
            ],
        ]);
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
