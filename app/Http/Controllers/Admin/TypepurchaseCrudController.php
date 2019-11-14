<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\TypepurchaseRequest as StoreRequest;
use App\Http\Requests\TypepurchaseRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use App\Models\Typepurchase;
use App\Services\MenuService\Traits\AccessLevelsTrait;

/**
 * Class TypepurchaseCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class TypepurchaseCrudController extends CrudController
{
    use AccessLevelsTrait;
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Typepurchase');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/typepurchase');
        $this->crud->setEntityNameStrings(trans_choice('admin.typepurchase', 1), trans_choice('admin.typepurchase', 2));
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
                'name' => 'type',
                'label' => 'Тип',
                'type' => 'select_from_array',
                'options' => Typepurchase::getTypeOptions(),
            ],
            [
                'name' => 'days',
                'label' => 'Срок',
            ],
            [
                'name' => 'price',
                'label' => 'Цена',
            ],
            [
                'name' => 'active',
                'label' => 'Опубликован',
                'type' => 'check',
            ]
        ]);

        $this->crud->addFields([
            [
                'name' => 'name',
                'label' => 'Название',
            ],
            [
                'name' => 'type',
                'label' => 'Тип',
                'type' => 'select_from_array',
                'options' => Typepurchase::getTypeOptions(),
                'default' => 'one',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4',
                ],
            ],
            [
                'name' => 'days',
                'label' => 'Срок',
                // 'prefix' => '',
                'suffix' => 'дней',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4',
                ],
            ],
            [
                'name' => 'price',
                'label' => 'Цена',
                'suffix' => 'тг','wrapperAttributes' => [
                    'class' => 'form-group col-md-4',
                ],
            ],
            [
                'name' => 'active',
                'label' => 'Опубликован',
                'type' => 'checkbox',
            ]
        ]);

        // add asterisk for fields that are required in TypepurchaseRequest
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