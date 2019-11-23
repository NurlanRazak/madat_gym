<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\GroceryRequest as StoreRequest;
use App\Http\Requests\GroceryRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use App\Services\MenuService\Traits\AccessLevelsTrait;
use App\Models\Listmeal;

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
        $this->crud->addFilter([
            'name' => 'active',
            'type' => 'select2',
            'label' => 'Опубликованные',
        ], function () {
            return [
                1 => 'Опубликованные',
                0 => 'Не опубликованные',
            ];
        }, function ($value) {
            $this->crud->addClause('where', 'active', $value);
        });
        $this->crud->addFilter([
            'name' => 'programtraining_id',
            'label' => 'Программы тренировок',
            'type' => 'select2',
        ], function () {
            return \App\Models\Programtraining::all()->pluck('name', 'id')->toArray();
        }, function ($value) {
            $this->crud->addClause('where', 'programtraining_id', $value);
        });
        $this->crud->addFilter([
            'name' => 'listmeals',
            'type' => 'select2_multiple',
            'label' => trans_choice('admin.listmeal', 2),
        ], function() {
            return Listmeal::all()->pluck('name', 'id')->toArray();
        }, function($values) {
            foreach (json_decode($values) as $key=>$value) {
                $this->crud->query = $this->crud->query->whereHas('listmeals', function ($query) use ($value) {
                    $query->where('listmeal_id', $value);
                });
            }
        });
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
            // [
            //     'name' => 'groceries',
            //     'label' => 'Справочника продуктов – огурцы, помидоры',
            //
            // ],
            [
                'name' => 'listmeals',
                'label' => trans_choice('admin.listmeal', 2),
                'type' => 'select_multiple',
                'entity' => 'listmeals',
                'attribute' => 'name',
                'model' => 'App\Models\Listmeal',
                'pivot' => true,
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
            // [
            //     'name' => 'groceries',
            //     'label' => 'Справочника продуктов – огурцы, помидоры',
            //     'type' => 'textarea',
            // ],
            [
                'name' => 'listmeals',
                'label' => trans_choice('admin.listmeal', 2),
                'type' => 'select2_multiple',
                'entity' => 'listmeals',
                'attribute' => 'name',
                'model' => 'App\Models\Listmeal',
                'pivot' => true,
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
