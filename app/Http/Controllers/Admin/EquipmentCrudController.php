<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\EquipmentRequest as StoreRequest;
use App\Http\Requests\EquipmentRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use App\Services\MenuService\Traits\AccessLevelsTrait;

/**
 * Class EquipmentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class EquipmentCrudController extends CrudController
{
    use AccessLevelsTrait;
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Equipment');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/equipment');
        $this->crud->setEntityNameStrings(trans_choice('admin.equipment', 1), trans_choice('admin.equipment', 2));
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
                'name' => 'description',
                'label' => 'Свойства',
            ],
            // [
            //     'name' => 'image',
            //     'label' => 'Изображение',
            //     'type' => 'image',
            //     'width' => '150px',
            //     'height' => '150px',
            //     'prefix' => 'uploads/',
            // ],
            [
                'name' => 'notify_day',
                'label' => 'День оповещения',
            ],
            [
                'name' => 'lists',
                'label' => 'Список оборудования',
                'type' => 'select_multiple',
                'entity' => 'lists',
                'attribute' => 'name',
                'model' => 'App\Models\Listequip',
            ],
            [
                'name' => 'trainings',
                'label' => 'Тренировки',
                'type' => 'select_multiple',
                'entity' => 'trainings',
                'attribute' => 'name',
                'model' => 'App\Models\Trainings',
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
                'name' => 'description',
                'label' => 'Свойства',
            ],
            // [
            //     'name' => 'image',
            //     'label' => 'Изображение',
            //     'type' => 'image',
            //     'upload' => true,
            //     'crop' => true,
            //     'aspect_ratio' => 0,
            //     'disk' => 'uploads',
            // ],
            [
                'name' => 'notify_day',
                'label' => 'День оповещения',
                'type' => 'number',
                'attributes' => ["step" => "any"],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            [
                'name' => 'lists',
                'label' => 'Список оборудования',
                'type' => 'select2_multiple',
                'entity' => 'lists',
                'attribute' => 'name',
                'model' => 'App\Models\Listequip',
                'pivot' => true,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            [
                'name' => 'trainings',
                'label' => 'Тренировки',
                'type' => 'select2_multiple',
                'entity' => 'trainings',
                'attribute' => 'name',
                'model' => 'App\Models\Training',
                'pivot' => true,
                'default' => 1,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            [
                'name' => 'active',
                'label' => 'Опубликован',
                'type' => 'checkbox',
            ],
        ]);
        // add asterisk for fields that are required in EquipmentRequest
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
