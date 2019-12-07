<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\UserStoreCrudRequest as StoreRequest;
use App\Http\Requests\UserUpdateCrudRequest as UpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\MenuService\Traits\AccessLevelsTrait;
use Carbon\Carbon;
use App\User;
use App\Models\Programtraining;

class ConsumerCrudController extends CrudController
{
    use AccessLevelsTrait;

    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel(User::class);
        $this->crud->setEntityNameStrings(trans('backpack::permissionmanager.user'), trans('backpack::permissionmanager.users'));
        $this->crud->setRoute(backpack_url('consumer'));
        $this->setAccessLevels();
        $this->crud->addClause('whereDoesntHave', 'roles');
        $this->crud->addFilter([
            'name' => 'weight',
            'label' => 'Вес',
            'type' => 'range',
            'label_from' => 'с',
            'label_to' => 'до'
        ],
        false,
        function ($value) {
            $range = json_decode($value);
            if ($range->from) {
                $this->crud->addClause('where', 'weight', '>=', (float) $range->from);
            }
            if ($range->to) {
                $this->crud->addClause('where', 'weight', '<=', (float) $range->to);
            }
        });
        $this->crud->addFilter([
            'name' => 'height',
            'label' => 'Рост',
            'type' => 'range',
            'label_from' => 'с',
            'label_to' => 'до'
        ],
        false,
        function ($value) {
            $range = json_decode($value);
            if ($range->from) {
                $this->crud->addClause('where', 'height', '>=', (float) $range->from);
            }
            if ($range->to) {
                $this->crud->addClause('where', 'height', '<=', (float) $range->to);
            }
        });

        $this->crud->addFilter([ // date filter
                  'type' => 'date_range',
                  'name' => 'date_register',
                  'label' => 'Дата регистраций',
                ],
                false,
                function($value) { // if the filter is active, apply these constraints
                  // $this->crud->addClause('where', 'date_register', $value);
                  $dates = json_decode($value);
                  $this->crud->addClause('where', 'date_register', '>=', $dates->from);
                  $this->crud->addClause('where', 'date_register', '<=', $dates->to . ' 23:59:59');
                });
        // $this->crud->addClause('whereHas', 'roles');
        // Columns

        $this->crud->addFilter([ // simple filter
          'type' => 'text',
          'name' => 'city',
          'label' => 'Город',
        ],
        false,
        function($value) { // if the filter is active
            $this->crud->addClause('where', 'city', 'LIKE', "%$value%");
        } );

        $this->crud->addFilter([ // simple filter
          'type' => 'text',
          'name' => 'country',
          'label' => 'Страна',
        ],
        false,
        function($value) { // if the filter is active
            $this->crud->addClause('where', 'country', 'LIKE', "%$value%");
        } );


        $this->crud->addFilter([
            'type' => 'select2',
            'name' => 'gender',
            'label' => 'Пол',
        ], function () {
            return [
                1 => 'Мужской пол',
                2 => 'Женский пол',
            ];
        }, function ($value) {
            $this->crud->addClause('where', 'gender', $value);
        });


        $this->crud->addButtonFromView('line', 'psw', 'password.change_password', 'beginning');

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

            // [ // n-n relationship (with pivot table)
            //    'label'     => trans('backpack::permissionmanager.extra_permissions'), // Table column heading
            //    'type'      => 'select_multiple',
            //    'name'      => 'permissions', // the method that defines the relationship in your Model
            //    'entity'    => 'permissions', // the method that defines the relationship in your Model
            //    'attribute' => 'name', // foreign key attribute that is shown to user
            //    'model'     => config('permission.models.permission'), // foreign key model
            // ],
            [
                'name' => 'programtraining_id',
                'label' => 'Программы тренировок',
                'type' => 'select',
                'entity' => 'programtraining',
                'attribute' => 'name',
                'model' => Programtraining::class,
            ],
            [
                'name' => 'country',
                'label' => 'Страна',
            ],
            [
                'name' => 'city',
                'label' => 'Город',
            ],
            [
                'name' => 'date_birth',
                'label' => 'Дата рождения',
                'type' => 'date',
            ],
            [
                'name' => 'gender',
                'label' => 'Пол',
                'type' => 'select_from_array',
                'options' => User::getGenderOptions(),
            ],
            [
                'name' => 'current_weight',
                'label' => 'Вес текущий',
            ],
            [
                'name' => 'height',
                'label' => 'Рост'
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
                'name' => 'social_media',
                'label' => 'Соц сети',
            ],
            [
                'name' => 'comment',
                'label' => 'Особые комментарий',
            ],
            [
                'name' => 'date_register',
                'label' => 'Дата регистраций',
                'type' => 'datetime',
                'format' => 'l',
            ],
        ]);

        // Fields
        $this->crud->addFields([
            [
                'name'  => 'name',
                'label' => trans('backpack::permissionmanager.name'),
                'type'  => 'text',
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [
                'name'  => 'email',
                'label' => trans('backpack::permissionmanager.email'),
                'type'  => 'email',
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [
                'name'  => 'password',
                'label' => trans('backpack::permissionmanager.password'),
                'type'  => 'password',
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [
                'name'  => 'password_confirmation',
                'label' => trans('backpack::permissionmanager.password_confirmation'),
                'type'  => 'password',
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [
                'name' => 'programtraining_id',
                'label' => 'Программы тренировок',
                'type' => 'select2',
                'entity' => 'programtraining',
                'attribute' => 'name',
                'model' => Programtraining::class,
            ],
            [
                'name' => 'country',
                'label' => 'Страна',
            ],
            [
                'name' => 'city',
                'label' => 'Город',
            ],
            [
                'name' => 'date_birth',
                'label' => 'Дата рождения',
                'type' => 'date',
            ],
            [
                'name' => 'gender',
                'label' => 'Пол',
                'type' => 'select_from_array',
                'options' => User::getGenderOptions(),
            ],
            [
                'name' => 'current_weight',
                'label' => 'Вес текущий',
                'type' => 'number',
                'attibutes' => [
                    'step' => 0.01,
                ],
            ],
            [
                'name' => 'height',
                'label' => 'Рост',
                'type' => 'number',
                'attributes' => [
                    'step' => 0.01,

                ],
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
            [
                'name' => 'comment',
                'label' => 'Особые комментарий',
                'type' => 'textarea',
            ],
            [
                'name' => 'date_register',
                'label' => 'Дата регистраций',
                'type' => 'datetime_picker',
                'datetime_picker_options' => [
                    'format' => 'DD/MM/YYYY HH:mm',
                ],
                'allows_null' => false,
                'default' => Carbon::now(),
            ],
        ]);

        if(!request()->password && request()->id) {
            $this->crud->removeField(['password', 'password_confirmation']);
        }
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
