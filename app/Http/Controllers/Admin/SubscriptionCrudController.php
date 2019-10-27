<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\SubscriptionRequest as StoreRequest;
use App\Http\Requests\SubscriptionRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class SubscriptionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class SubscriptionCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Subscription');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/subscription');
        $this->crud->setEntityNameStrings('subscription', 'subscriptions');

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
                'label' => 'Название абонемента',
            ],
            [
                'name' => 'days',
                'label' => 'Количество дней',
            ],
            [
                'name' => 'price',
                'label' => 'Цена',
            ],
            [
                'name' => 'expires',
                'label' => 'Дата истечения',
                'type' => 'date',
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
                'label' => 'Название абонемента',
                'attributes' => [
                    'placeholder' => 'Введите название абонемента',
                ],
            ],
            [
                'name' => 'days',
                'label' => 'Количество дней',
                'attributes' => [
                    'placeholder' => 'Введите цифры',
                ],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-8'
                ],
            ],
            [
                'name' => 'expires',
                'label' => 'Дата истечения',
                'type' => 'datetime_picker',
                // optional:
                'datetime_picker_options' => [
                    'format' => 'DD/MM/YYYY HH:mm',
                    'language' => 'fr'
                ],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
            ],
            [
                'name' => 'price',
                'label' => 'Цена',
                'attributes' => [
                    'placeholder' => 'Введите цифры',
                ],
            ],
            [
                'name' => 'active',
                'label' => 'Опубликовать',
                'type' => 'checkbox',
            ],
        ]);

        // add asterisk for fields that are required in SubscriptionRequest
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
