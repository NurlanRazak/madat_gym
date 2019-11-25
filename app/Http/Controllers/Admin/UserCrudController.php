<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\UserStoreCrudRequest as StoreRequest;
use App\Http\Requests\UserUpdateCrudRequest as UpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\MenuService\Traits\AccessLevelsTrait;
use Carbon\Carbon;

class UserCrudController extends CrudController
{
    use AccessLevelsTrait;
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel(config('backpack.permissionmanager.models.user'));
        $this->crud->setEntityNameStrings('Сотрудник', 'Сотрудники');
        $this->crud->setRoute(backpack_url('user'));
        $this->setAccessLevels();

        $this->crud->addFilter([
            'type' => 'select2',
            'name' => 'type_employee',
            'label' => 'Тип сотрудника',
        ], function () {
            return [
                1 => 'Сотрудник',
                2 => 'Тренер',
            ];
        }, function ($value) {
            $this->crud->addClause('where', 'type_employee', $value);
        });


        $this->crud->addClause('whereHas', 'roles');
        // Columns
        $this->crud->setColumns([
            [
                'name'  => 'name',
                'label' => trans('backpack::permissionmanager.name'),
                'type'  => 'text',
            ],
            [
                'name'  => 'email',
                'label' => trans('backpack::permissionmanager.email'),
                'type'  => 'email',
            ],
            [ // n-n relationship (with pivot table)
               'label'     => trans('backpack::permissionmanager.roles'), // Table column heading
               'type'      => 'select_multiple',
               'name'      => 'roles', // the method that defines the relationship in your Model
               'entity'    => 'roles', // the method that defines the relationship in your Model
               'attribute' => 'name', // foreign key attribute that is shown to user
               'model'     => config('permission.models.role'), // foreign key model
            ],
            [ // n-n relationship (with pivot table)
               'label'     => trans('backpack::permissionmanager.extra_permissions'), // Table column heading
               'type'      => 'select_multiple',
               'name'      => 'permissions', // the method that defines the relationship in your Model
               'entity'    => 'permissions', // the method that defines the relationship in your Model
               'attribute' => 'name', // foreign key attribute that is shown to user
               'model'     => config('permission.models.permission'), // foreign key model
            ],
            [
                'name' => 'type_employee',
                'label' => 'Тип сотрудника',
                'type' => 'select_from_array',
                'options' => \App\User::getEmployeetypeOptions(),
            ],
            [
                'name' => 'iin',
                'label' => 'ИИН',
            ],
            [
                'name' => 'phone_number',
                'label' => 'Телефон номера',
            ],
            [
                'name' => 'image',
                'label' => 'Изображение',
                'type' => 'image',
                'prefix' => 'uploads/',
                'width' => '150px',
                'height' => '150px',
            ],
            [
                'name' => 'date_hired',
                'label' => 'Дата принятия на работу',
                'type' => 'datetime',
                'format' => 'l',
            ],
            [
                'name' => 'position',
                'label' => 'Должность',
            ],
            [
                'name' => 'date_fired',
                'label' => 'Дата увольнения',
                'type' => 'datetime',
                'format' => 'l',
            ],
            [
                'name' => 'address',
                'label' => 'Адрес',
            ],
            [
                'name' => 'social_media',
                'label' => 'Соц сети',
            ],
        ]);

        // Fields
        $this->crud->addFields([
            [
                'name'  => 'name',
                'label' => trans('backpack::permissionmanager.name'),
                'type'  => 'text',
            ],
            [
                'name'  => 'email',
                'label' => trans('backpack::permissionmanager.email'),
                'type'  => 'email',
            ],
            [
                'name'  => 'password',
                'label' => trans('backpack::permissionmanager.password'),
                'type'  => 'password',
            ],
            [
                'name'  => 'password_confirmation',
                'label' => trans('backpack::permissionmanager.password_confirmation'),
                'type'  => 'password',
            ],
            [
            // two interconnected entities
            'label'             => trans('backpack::permissionmanager.user_role_permission'),
            'field_unique_name' => 'user_role_permission',
            'type'              => 'select2_multiple',
            // 'label'            => trans('backpack::permissionmanager.roles'),
            'name'             => 'roles', // the method that defines the relationship in your Model
            'entity'           => 'roles', // the method that defines the relationship in your Model
            // 'entity_secondary' => 'permissions', // the method that defines the relationship in your Model
            'attribute'        => 'name', // foreign key attribute that is shown to user
            'model'            => config('permission.models.role'), // foreign key model
            'pivot'            => true, // on create&update, do you need to add/delete pivot table entries?]
            // 'number_columns'   => 3,


            //
            // 'name'              => 'roles_and_permissions', // the methods that defines the relationship in your Model
            // 'subfields'         => [
            //         'primary' => [
            //             'label'            => trans('backpack::permissionmanager.roles'),
            //             'name'             => 'roles', // the method that defines the relationship in your Model
            //             'entity'           => 'roles', // the method that defines the relationship in your Model
            //             // 'entity_secondary' => 'permissions', // the method that defines the relationship in your Model
            //             'attribute'        => 'name', // foreign key attribute that is shown to user
            //             'model'            => config('permission.models.role'), // foreign key model
            //             'pivot'            => true, // on create&update, do you need to add/delete pivot table entries?]
            //             'number_columns'   => 3, //can be 1,2,3,4,6
            //         ],
            //         // 'secondary' => [
            //         //     'label'          => ucfirst(trans('backpack::permissionmanager.permission_singular')),
            //         //     'name'           => 'permissions', // the method that defines the relationship in your Model
            //         //     'entity'         => 'permissions', // the method that defines the relationship in your Model
            //         //     'entity_primary' => 'roles', // the method that defines the relationship in your Model
            //         //     'attribute'      => 'name', // foreign key attribute that is shown to user
            //         //     'model'          => config('permission.models.permission'), // foreign key model
            //         //     'pivot'          => true, // on create&update, do you need to add/delete pivot table entries?]
            //         //     'number_columns' => 3, //can be 1,2,3,4,6
            //         // ],
            //     ],
            ],
            [
                'name' => 'image',
                'label' => 'Изображение',
                'type' => 'image',
                'upload' => true,
                'disk' => 'uploads',
            ],
            [
                'name' => 'type_employee',
                'label' => 'Тип сотрудника',
                'type' => 'select_from_array',
                'options' => \App\User::getEmployeetypeOptions(),
            ],
            [
                'name' => 'date_hired',
                'label' => 'Дата принятия на работу',
                'type' => 'datetime_picker',
                'datetime_picker_options' => [
                    'format' => 'DD/MM/YYYY HH:mm',
                ],
                'allows_null' => false,
                'default' => Carbon::now(),
            ],
            [
                'name' => 'position',
                'label' => 'Должность',
            ],
            [
                'name' => 'date_fired',
                'label' => 'Дата увольнения',
                'type' => 'datetime_picker',
                'datetime_picker_options' => [
                    'format' => 'DD/MM/YYYY HH:mm',
                ],
                'allows_null' => false,
                'default' => Carbon::now(),
            ],
            [
                'name' => 'address',
                'label' => 'Адрес',
            ],
            [
                'name' => 'iin',
                'label' => 'ИИН',
                // 'type' => 'text',
                // 'attributes' => [
                //     'step' => 1,
                //     'min' => 0,
                //     'pattern' => "^\d+$",
                //     // 'oninput' => "$(this).val(parseInt(this.value));",
                // ],
            ],
            [
                'name' => 'phone_number',
                'label' => 'Номер телефона',
                'type' => 'text',
                'attributes' => [
                    'step' => 1,
                    'min' => 11,
                    'pattern' => '^\+?[7, 8]{1}[0-9]{10}$',
                    'title' => '',
                ],
            ],
            [
                'name' => 'social_media',
                'label' => 'Соц сети',
            ],
        ]);
    }

    /**
     * Store a newly created resource in the database.
     *
     * @param StoreRequest $request - type injection used for validation using Requests
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        $this->handlePasswordInput($request);

        $request->request->remove('roles_show');
        $request->request->remove('permissions_show');

        return parent::storeCrud($request);
    }

    /**
     * Update the specified resource in the database.
     *
     * @param UpdateRequest $request - type injection used for validation using Requests
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request)
    {
        $this->handlePasswordInput($request);

        $request->request->remove('roles_show');
        $request->request->remove('permissions_show');

        return parent::updateCrud($request);
    }

    /**
     * Handle password input fields.
     *
     * @param Request $request
     */
    protected function handlePasswordInput(Request $request)
    {
        // Remove fields not present on the user.
        $request->request->remove('password_confirmation');

        // Encrypt password if specified.
        if ($request->input('password')) {
            $request->request->set('password', Hash::make($request->input('password')));
        } else {
            $request->request->remove('password');
        }
    }
}
