<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\PurchaseRequest as StoreRequest;
use App\Http\Requests\PurchaseRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use App\Services\MenuService\Traits\AccessLevelsTrait;
use App\Models\Purchase;
/**
 * Class PurchaseCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class PurchaseCrudController extends CrudController
{
    use AccessLevelsTrait;
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Purchase');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/purchase');
        $this->crud->setEntityNameStrings(trans_choice('admin.purchase', 1), trans_choice('admin.purchase', 2));
        $this->setAccessLevels();
        $this->crud->addFilter([
            'name' => 'user_id',
            'label' => 'Пользователь',
            'type' => 'select2',
        ], function (){
            return \App\User::whereDoesntHave('roles')->pluck('email', 'id')->toArray();
        }, function ($value) {
            $this->crud->addClause('where', 'user_id', $value);
        });
        $this->crud->addFilter([
            'name' => 'typepurchase_id',
            'label' => 'Тип покупки',
            'type' => 'select2',
        ], function () {
            return \App\Models\Typepurchase::all()->pluck('name', 'id')->toArray();
        }, function ($value) {
            $this->crud->addClause('where', 'typepurchase_id', $value);
        });
        $this->crud->addFilter([
            'name' => 'status',
            'label' => 'Статус',
            'type' => 'select2',
        ], function () {
            return [
                1 => 'Оплачено',
                0 => 'Не оплачено',
            ];
        }, function($value) {
            $this->crud->addClause('where', 'status', $value);
        });
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
                'name' => 'subscription',
                'label' => 'Абонемент',
                'type' => 'select',
                'entity' => 'subscription',
                'attribute' => 'name',
                'model' => 'App\Models\Subscription',
            ],
            [
                'name' => 'typepurchase_id',
                'label' => 'Тип покупки',
                'type' => 'select',
                'entity' => 'typepurchase',
                'attribute' => 'name',
                'model' => 'App\Models\Typepurchase',
            ],
            [
                'name' => 'comment',
                'label' => 'Комментарий',
            ],
            [
                'name' => 'status',
                'label' => 'Статус',
                'type' => 'select_from_array',
                'options' => Purchase::getStatusOptions(),
            ],
            [
                'name' => 'start_date',
                'label' => 'Дата покупки',
                'type' => "datetime",
                'format' => 'l',
            ],
        ]);

        $this->crud->addFields([
            [
                'name' => 'user_id',
                'label' => 'Пользователь',
                'type' => 'select2_from_array',
                'options' => Purchase::getConsumerOptions(),
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [
                'name' => 'typepurchase_id',
                'label' => 'Тип покупки',
                'type' => 'select2',
                'entity' => 'typepurchase',
                'attribute' => 'name',
                'model' => 'App\Models\Typepurchase',
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [
                'name' => 'comment',
                'label' => 'Комментарий',
                'type' => 'textarea',
            ],
            [
                'name' => 'status',
                'label' => 'Статус',
                'type' => 'select2_from_array',
                'options' => Purchase::getStatusOptions(),
            ],
            [
                'name' => 'start_date',
                'label' => 'Дата покупки',
                'type' => 'datetime_picker',
                'allows_null' => false,
                'attributes' => [
                    'required' => 'required',
                ],
            ],
        ]);

        // add asterisk for fields that are required in PurchaseRequest
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
