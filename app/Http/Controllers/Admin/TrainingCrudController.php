<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\TrainingRequest as StoreRequest;
use App\Http\Requests\TrainingRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use App\Services\MenuService\Traits\AccessLevelsTrait;

/**
 * Class TrainingCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class TrainingCrudController extends CrudController
{
    use AccessLevelsTrait;
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Training');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/training');
        $this->crud->setEntityNameStrings(trans_choice('admin.training', 1), trans_choice('admin.training', 2));
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
                'model' => 'App\Models\Exercise',
            ],
            [
                'name' => 'programtrainings',
                'label' => 'Программа',
                'type' => 'select_multiple',
                'entity' => 'programtrainings',
                'attribute' => 'name',
                'model' => 'App\Models\Programtraining',
            ],
            [
                'name' => 'user_id',
                'label' => 'Пользователь',
                'type' => 'select',
                'entity' => 'user',
                'attribute' => 'email',
                'model' => 'App\User',
            ],
            [
                'name' => 'day_number',
                'label' => 'Номер дня',
            ],
            [
                'name' => 'approaches_number',
                'label' => 'Количество подходов',
            ],
            [
                'name' => 'repetitions_number',
                'label' => 'Количество повторений',
            ],
            [
                'name' => 'weight',
                'label' => 'Вес',
            ],
            [
                'name' => 'active',
                'label' => 'Опубликован',
                'type' => 'check'
            ],
        ]);

        $this->crud->addFields([
            [
                'name' => 'name',
                'label' => 'Название',
            ],
            [
                'name' => 'exercises',
                'label' => 'Упражнение',
                'type' => 'select2_multiple',
                'entity' => 'exercises',
                'attribute' => 'name',
                'model' => 'App\Models\Exercise',
                'pivot' => true,
            ],
            [
                'name' => 'programtrainings',
                'label' => 'Программа',
                'type' => 'select2_multiple',
                'entity' => 'programtrainings',
                'attribute' => 'name',
                'model' => 'App\Models\Programtraining',
                'pivot' => true,
            ],
            [
                'name' => 'user_id',
                'label' => 'Пользователь',
                'type' => 'select2',
                'entity' => 'user',
                'attribute' => 'email',
                'model' => 'App\User',
            ],
            [
                'name' => 'day_number',
                'label' => 'Номер дня',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
            ],
            [
                'name' => 'approaches_number',
                'label' => 'Количество подходов',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
            ],
            [
                'name' => 'repetitions_number',
                'label' => 'Количество повторений',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
            ],
            [
                'name' => 'weight',
                'label' => 'Вес',
            ],
            [
                'name' => 'active',
                'label' => 'Опубликован',
                'type' => 'checkbox'
            ],
        ]);

        // add asterisk for fields that are required in TrainingRequest
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
