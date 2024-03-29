<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ProgramtypeRequest as StoreRequest;
use App\Http\Requests\ProgramtypeRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use App\Services\MenuService\Traits\AccessLevelsTrait;

/**
 * Class ProgramtypeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ProgramtypeCrudController extends CrudController
{
    use AccessLevelsTrait;
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Programtype');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/programtype');
        $this->crud->setEntityNameStrings(trans_choice('admin.ptype', 1), trans_choice('admin.ptype', 2));
        $this->setAccessLevels();

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
                'label' => 'Название типа',
            ],
            // [
            //     'name' => 'active',
            //     'label' => 'Опубликован',
            //     'type' => 'check',
            // ]
        ]);
        $this->crud->addFields([
            [
                'name' => 'name',
                'label' => 'Название типа',
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            // [
            //     'name' => 'active',
            //     'label' => 'Опубликован',
            //     'type' => 'checkbox',
            // ]
        ]);

        // add asterisk for fields that are required in ProgramtypeRequest
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
