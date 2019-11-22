<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\GroceryRequest as StoreRequest;
use App\Http\Requests\GroceryRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use App\Services\MenuService\Traits\AccessLevelsTrait;

/**
 * Class GroceryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class GroceryCrudController extends CrudController
{
    use AccessLevelsTrait;
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Grocery');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/grocery');
        $this->crud->setEntityNameStrings(trans_choice('admin.grocery', 1), trans_choice('admin.grocery', 2));
        $this->setAccessLevels();

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->addColumns([
            [
                'name' => 'notify_day',
                'label' => 'День оповещения',
            ],
            [
                'name' => 'description',
                'label' => 'Комментарии',
            ],
            // [
            //     'name' => 'trainings',
            //     'label' => 'Тренировки',
            //     'type' => 'select_multiple',
            //     'entity' => 'trainings',
            //     'attribute' => 'name',
            //     'model' => 'App\Models\Training',
            // ],
            [
                'name' => 'programtraining_id',
                'label' => 'Программы тренировок',
                'type' => 'select',
                'entity' => 'programtraining',
                'attribute' => 'name',
                'model' => 'App\Models\Programtraining',
            ],
            [
                'name' => 'groceries',
                'label' => 'Справочника продуктов – огурцы, помидоры',

            ],
            // [
            //     'name' => 'meals',
            //     'label' => 'Блюдо',
            //     'type' => 'select_multiple',
            //     'entity' => 'meals',
            //     'attribute' => 'name',
            //     'model' => 'App\Models\Meal',
            // ],
            [
                'name' => 'active',
                'label' => 'Опубликован',
                'type' => 'check',
            ],
        ]);

        $this->crud->addFields([
            [
                'name' => 'notify_day',
                'label' => 'День оповещения',
                'type' => 'number',
                'attributes' => ["step" => "any"],
            ],
            [
                'name' => 'description',
                'label' => 'Комментарии',
            ],
            [
                'name' => 'programtraining_id',
                'label' => 'Программы тренировок',
                'type' => 'select2',
                'entity' => 'programtraining',
                'attribute' => 'name',
                'model' => 'App\Models\Programtraining',
            ],
            // [
            //     'name' => 'trainings',
            //     'label' => 'Тренировки',
            //     'type' => 'select2_multiple',
            //     'entity' => 'trainings',
            //     'attribute' => 'name',
            //     'model' => 'App\Models\Training',
            //     'pivot' => true,
            // ],
            [
                'name' => 'groceries',
                'label' => 'Справочника продуктов – огурцы, помидоры',
                'type' => 'textarea',
            ],
            // [
            //     'name' => 'meals',
            //     'label' => 'Блюдо',
            //     'type' => 'select2_multiple',
            //     'entity' => 'meals',
            //     'attribute' => 'name',
            //     'model' => 'App\Models\Meal',
            //     'pivot' => true,
            // ],
            [
                'name' => 'active',
                'label' => 'Опубликован',
                'type' => 'checkbox',
            ],
        ]);
        // add asterisk for fields that are required in GroceryRequest
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
