<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\PurchaseRequest as StoreRequest;
use App\Http\Requests\PurchaseRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class PurchaseCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class PurchaseCrudController extends CrudController
{
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
                'attribute' => 'name',
                'model' => 'App\User',
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
            ],
            [
                'name' => 'start_date',
                'label' => 'Дата подписки',
            ],
        ]);

        $this->crud->addFields([
            [
                'name' => 'user_id',
                'label' => 'Пользователь',
                'type' => 'select2',
                'entity' => 'user',
                'attribute' => 'name',
                'model' => 'App\User',
            ],
            [
                'name' => 'typepurchase_id',
                'label' => 'Тип покупки',
                'type' => 'select2',
                'entity' => 'typepurchase',
                'attribute' => 'name',
                'model' => 'App\Models\Typepurchase',
            ],
            [
                'name' => 'comment',
                'label' => 'Комментарий',
                'type' => 'textarea',
            ],
            [
                'name' => 'status',
                'label' => 'Статус',
            ],
            [
                'name' => 'start_date',
                'label' => 'Дата подписки',
                'type' => 'date_picker',
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
