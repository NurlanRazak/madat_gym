<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ListmealRequest as StoreRequest;
use App\Http\Requests\ListmealRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class ListmealCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ListmealCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Listmeal');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/listmeal');
        $this->crud->setEntityNameStrings(trans_choice('admin.listmeal', 1), trans_choice('admin.listmeal', 2));

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
        ]);
        $this->crud->addFields([
            [
                'name' => 'name',
                'label' => 'Название',
                'attributes' => [
                    'required' => 'required',
                ],
            ],
        ]);
        // add asterisk for fields that are required in ListmealRequest
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
