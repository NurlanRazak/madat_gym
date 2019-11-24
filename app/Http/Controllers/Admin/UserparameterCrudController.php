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
class UserparameterCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Userparameter');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/userparameter');
        $this->crud->setEntityNameStrings(trans_choice('admin.userparameter', 1), trans_choice('admin.userparameter', 2));

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->addColumns([
            [
                'name' => 'user_id',
                'label' => 'Пользователь',
                'type' => 'select',
                'entity' => 'user',
                'attribute' => 'email',
                'model' => 'App\User',
            ],
            [
                'name' => 'date_measure',
                'label' => 'Дата замера',
                'type' => 'datetime',
                'format' => 'l',
            ],
            [
                'name' => 'weight',
                'label' => 'Вес',
            ],
            [
                'name' => 'waist',
                'label' => 'Талия',
            ],
            [
                'name' => 'leg_volume',
                'label' => 'Объем ноги'
            ],
            [
                'name' => 'arm_volume',
                'label' => 'Объем рук',
            ],
            [
                'name' => 'images',
                'label' => 'Изображения',
            ],
        ]);

        $this->crud->addFields([
            [
                'name' => 'user_id',
                'label' => 'Пользователь',
                'type' => 'select2_from_array',
                'options' => Userparameter::getConsumerOptions(),
                'attributes' => [
                    'required' => 'required',
                ],

            ],
            [
                'name' => 'date_measure',
                'label' => 'Дата замера',
                'type' => 'datetime_picker',
                'datetime_picker_options' => [
                    'format' => 'DD/MM/YYYY HH:mm',
                ],
                'allows_null' => false,
                'default' => Carbon::now(),
            ],
            [
                'name' => 'weight',
                'label' => 'Вес',
                'type' => 'number',
                'attributes' => ["step" => "any"],
            ],
            [
                'name' => 'waist',
                'label' => 'Талия',
                'type' => 'number',
                'attributes' => ["step" => "any"],
            ],
            [
                'name' => 'leg_volume',
                'label' => 'Объем ноги',
                'type' => 'number',
                'attributes' => ["step" => "any"],
            ],
            [
                'name' => 'arm_volume',
                'label' => 'Объем рук',
                'type' => 'number',
                'attributes' => ["step" => "any"],
            ],
            [
                'name' => 'images',
                'label' => 'Изображения',
                'type' => 'upload_multiple',
                'upload' => true,
                'disk' => 'uploads',
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
