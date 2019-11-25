<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\MessageRequest as StoreRequest;
use App\Http\Requests\MessageRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use App\Models\Message;
use App\User;
use App\Services\MenuService\Traits\AccessLevelsTrait;

/**
 * Class MessageCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class MessageCrudController extends CrudController
{
    use AccessLevelsTrait;
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Message');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/message');
        $this->crud->setEntityNameStrings('сообщение', 'Сообщения');
        $this->setAccessLevels();

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        $this->crud->addClause('orderBy', 'status', 'asc');

        $this->setFilters();
        $this->setColumns();
        $this->setFields();
        $this->setButtons();

        // add asterisk for fields that are required in MessageRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    private function setFilters()
    {
        $this->crud->addFilter([
            'name' => 'status',
            'type' => 'select2',
            'label' => 'Статус',
        ], function () {
            return [
                1 => 'Отправленные',
                0 => 'Черновик',
            ];
        }, function ($value) {
            $this->crud->addClause('where', 'status', $value);
        });
    }

    private function setButtons()
    {
        $this->crud->addButtonFromView('line', 'send', 'message.send', 'beginning');

    }

    private function setColumns()
    {
        $this->crud->addColumns([
            [
                'name' => 'row_number',
                'type' => 'row_number',
                'label' => '#',
                'orderable' => false,
            ],
            [
                'name' => 'name',
                'label' => 'Заголовок',
                'limit' => 200,
            ],
            [
                'name' => 'status',
                'label' => 'Статус',
                'type' => 'select_from_array',
                'options' => Message::getStatusOptions(),
            ],
            // [
            //     'name' => 'send_date',
            //     'label' => 'Время отправки',
            //     'type' => 'datetime',
            // ],
            [
                'name' => 'users',
                'label' => 'Получатели',
                'type' => 'select_multiple',
                // 'options' => Message::getConsumerOptions(),
                'entity' => 'users',
                'attribute' => 'email',
                'model' => 'App\User',
            ],
            [
                'name' => 'content',
                'label' => 'Текст',
                'limit' => 2000,
            ],
        ]);

    }

    private function setFields()
    {
        $this->crud->addFields([
            // [
            //     'name' => 'send_date',
            //     'label' => 'Время отправки',
            //     'type' => 'datetime_picker',
            //     'datetime_picker_options' => [
            //         'language' => 'ru',
            //     ],
            //     'wrapperAttributes' => [
            //         'class' => 'form-group col-sm-7',
            //     ],
            // ],
            [
                'name' => 'status',
                'label' => 'Статус',
                'type' => 'select2_from_array',
                'options' => Message::getStatusOptions(),
                'default' => Message::DRAFT,
                'wrapperAttributes' => [
                    'class' => 'form-group col-sm-12',
                ],
            ],
            [
                'name' => 'users',
                'label' => 'Пользователи',
                'type' => 'select2_multiple',
                'entity' => 'users',
                'model' => 'App\User',
                'attribute' => 'email',
                'pivot' => true,
                'options'   => (function ($query) {
                    return $query->whereDoesntHave('roles')->get();
                }),
                'attributes' => [
                        'required' => 'required',
                    ],
            ],

            // [
            //     'name' => 'users',
            //     'label' => 'Получатели',
            //     'type' => 'select2_from_array',
            //     'options' => Message::getConsumerOptions(),
            //     'wrapperAttributes' => [
            //         'class' => 'form-group col-sm-12 required',
            //     ],
            //     // 'entity' => 'users',
            //     // 'attribute' => 'email',
            // ],



            // [
            //     'name' => 'users',
            //     'label' => 'Получатели',
            //     'type' => 'select2_multiple',
            //     'entity' => 'users',
            //     'model' => User::class,
            //     'attribute' => 'email',
            //     'pivot' => true,
            //     'attributes' => [
            //         'required' => 'required',
            //     ],
            //     'wrapperAttributes' => [
            //         'class' => 'form-group col-sm-12 required',
            //     ],
            // ],
            [
                'name' => 'seperator',
                'type' => 'custom_html',
                'value' => '<hr/>',
            ],
            [
                'name' => 'name',
                'label' => 'Заголовок',
                'attributes' => [
                    'required' => 'required',
                ],
                'wrapperAttributes' => [
                    'class' => 'form-group col-sm-12 required',
                ],
            ],
            [
                'name' => 'content',
                'label' => 'Текст',
                'type' => 'ckeditor',
                'attributes' => [
                    'required' => 'required',
                ],
                'wrapperAttributes' => [
                    'class' => 'form-group col-sm-12 required',
                ],
            ],
        ]);
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
