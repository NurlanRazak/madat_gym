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
class ItemboughtCrudController extends CrudController
{
    protected $dates = null;
    protected $range = null;
    protected $user_ids = null;

    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Subscription');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/itembought');
        $this->crud->setEntityNameStrings('Покупки(абонементы)', 'Покупки(абонементы)');
        $this->crud->denyAccess(['create', 'update', 'delete']);
        $this->crud->removeAllButtons();

        $this->crud->addFilter([
            'name' => 'users',
            'label' => 'Пользователи',
            'type' => 'select2_multiple',
        ], function() {
            return \App\User::whereDoesntHave('roles')->pluck('email', 'id')->toArray();
        }, function($values) {
            $this->user_ids = json_decode($values);
        });

        $this->crud->addFilter([ // daterange filter
          'type' => 'date_range',
          'name' => 'date_start',
          'label'=> 'Дата'
        ],
        false,
        function($value) { // if the filter is active, apply these constraints
            $this->dates = json_decode($value);
        });
        //
        // $this->crud->addFilter([
        //     'name' => 'cnt',
        //     'label' => 'Количество покупок',
        //     'type' => 'range',
        //     'label_from' => 'с',
        //     'label_to' => 'до'
        // ],
        // false,
        // function ($value) {
        //     $this->range = json_decode($value);
        // });


        $dates = $this->dates;
        $user_ids = $this->user_ids;
        $this->crud->query->withCount(['rawusers as users_count' => function($query) use($dates, $user_ids) {
            if ($user_ids) {
                $query->whereIn('user_id', $user_ids);
            }
            if ($dates) {
                if ($dates->from) {
                    $query->where('created_at', '>=', $dates->from);
                }
                if ($dates->to) {
                    $query->where('created_at', '<=', $dates->to.' 23:59:59');
                }
            }
        }]);

        $this->crud->addColumns([
            [
                'name' => 'row_number',
                'label' => '#',
                'type' => 'row_number',
                'orderable' => true,
            ],
            [
                'name' => 'name',
                'label' => 'Абонемент',
            ],
            [
                'name' => 'users_count',
                'label' => 'Количество покупок',
            ],
        ]);

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
