<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ProgramtrainingRequest as StoreRequest;
use App\Http\Requests\ProgramtrainingRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use App\Services\MenuService\Traits\AccessLevelsTrait;

/**
 * Class ProgramtrainingCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ProgramtrainingCrudController extends CrudController
{
    use AccessLevelsTrait;
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Programtraining');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/programtraining');
        $this->crud->setEntityNameStrings(trans_choice('admin.programtraining', 1), trans_choice('admin.programtraining', 2));
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
                'label' => 'Название',
            ],
            [
                'name' => 'agerestrict',
                'label' => 'Возрастные ограничения',
            ],
            [
                'name' => 'description',
                'label' => 'Описание',
                'type' => 'textarea',
            ],
            [
                'name' => 'image',
                'label' => 'Изображение',
                'type' => 'image',
                'width' => '150px',
                'height' => '150px',
                'prefix' => 'uploads/',
            ],
            [
                'name' => 'duration',
                'label' => 'Длительность (в днях)',
            ],
            [
                'name' => 'price',
                'label' => 'Цена',
            ],
            [
                'name' => 'programtype_id',
                'label' => 'Тип программы',
                'type' => 'select',
                'entity' => 'programtype',
                'attribute' => 'name',
                'model' => 'App\Models\Programtype',
            ],
            [
                'name' => 'foodprogram_id',
                'label' => 'Программы питания',
                'type' => 'select',
                'entity' => 'foodprogram',
                'attribute' => 'name',
                'model' => 'App\Models\Foodprogram',
            ],
            [
                'name' => 'relaxprogram_id',
                'label' => 'Программы отдыха',
                'type' => 'select',
                'entity' => 'relaxprogram',
                'attribute' => 'name',
                'model' => 'App\Models\Relaxprogram',
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
                'name' => 'agerestrict',
                'label' => 'Возрастные ограничения',
            ],
            [
                'name' => 'description',
                'label' => 'Описание',
                'type' => 'textarea',
            ],
            [
                'name' => 'image',
                'label' => 'Изображение',
                'type' => 'image',
                'disk' => 'uploads',
                'upload' => true,
                'crop' => true,
                'aspect_ratio' => 0,
            ],
            [
                'name' => 'duration',
                'label' => 'Длительность (в днях)',
                'type' => 'number',
                'attributes' => ["step" => "any"],
            ],
            [
                'name' => 'price',
                'label' => 'Цена',
                'type' => 'number',
                'attributes' => ["step" => "0.001"],
            ],
            [
                'name' => 'programtype_id',
                'label' => 'Тип программы',
                'type' => 'select2',
                'entity' => 'programtype',
                'attribute' => 'name',
                'model' => 'App\Models\Programtype',
            ],
            [
                'name' => 'foodprogram_id',
                'label' => 'Программы питания',
                'type' => 'select2',
                'entity' => 'foodprogram',
                'attribute' => 'name',
                'model' => 'App\Models\Foodprogram',
            ],
            [
                'name' => 'relaxprogram_id',
                'label' => 'Программы отдыха',
                'type' => 'select2',
                'entity' => 'relaxprogram',
                'attribute' => 'name',
                'model' => 'App\Models\Relaxprogram',
            ],
            [
                'name' => 'active',
                'label' => 'Опубликован',
                'type' => 'checkbox',
            ],
        ]);
        // add asterisk for fields that are required in ProgramtrainingRequest
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
