<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\RelaxtrainingRequest as StoreRequest;
use App\Http\Requests\RelaxtrainingRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use App\Services\MenuService\Traits\AccessLevelsTrait;

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
                'name' => 'users',
                'label' => 'Пользователи',
                'type' => 'select_multiple',
                'entity' => 'users',
                'attribute' => 'name',
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
            ],
            [
                'name' => 'exercises',
                'label' => 'Упражнения',
                'type' => 'select2_multiple',
                'entity' => 'exercises',
                'attribute' => 'name',
                'model' => 'App\Models\Relaxexercise',
                'pivot' => true,
            ],
            [
                'name' => 'programs',
                'label' => 'Программы отдыха',
                'type' => 'select2_multiple',
                'entity' => 'programs',
                'attribute' => 'name',
                'model' => 'App\Models\Relaxprogram',
                'pivot' => true,
            ],
            [
                'name' => 'users',
                'label' => 'Пользователи',
                'type' => 'select2_multiple',
                'entity' => 'users',
                'attribute' => 'name',
                'model' => 'App\User',
                'pivot' => true,
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
