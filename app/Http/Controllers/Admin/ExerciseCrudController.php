<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ExerciseRequest as StoreRequest;
use App\Http\Requests\ExerciseRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use App\Services\MenuService\Traits\AccessLevelsTrait;

/**
 * Class ExerciseCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ExerciseCrudController extends CrudController
{
    use AccessLevelsTrait;
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Exercise');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/exercise');
        $this->crud->setEntityNameStrings(trans_choice('admin.exercise', 1), trans_choice('admin.exercise', 2));
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
                'label' => 'Название упражнения'
            ],
            [
                'name' => 'short_desc',
                'label' => 'Короткое описание',
                'type' => 'text',
            ],
            [
                'name' => 'long_desc',
                'label' => 'Длинное описание',
                'type' => 'text',
            ],
            [
                'name' => 'image',
                'label' => 'Изображение',
                'type' => 'image',
                'prefix' => 'uploads/',
                'height' => '150px',
                'width' => '150px',
            ],
            [
                'name' => 'video',
                'label' => 'Видео',
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
                'label' => 'Название упражнения',
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [
                'name' => 'short_desc',
                'label' => 'Короткое описание',
                'type' => 'textarea',
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [
                'name' => 'long_desc',
                'label' => 'Длинное описание',
                'type' => 'ckeditor',
            ],
            [
                'name' => 'image',
                'label' => 'Изображение',
                'type' => 'image',
                'upload' => true,
                'crop' => true,
                'aspect_ratio' => 0,
                'disk' => 'uploads',
            ],
            [
                'name' => 'video',
                'label' => 'Видео',
                'type' => 'upload',
                'upload' => true,
                'attributes' => [
                    'accept' => 'video/*',
                ],
                'disk' => 'uploads',
            ],
            [
                'name' => 'active',
                'label' => 'Опубликован',
                'type' => 'checkbox',
            ],
        ]);


        // add asterisk for fields that are required in ExerciseRequest
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

    public function modal()
    {
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->getSaveAction();
        $this->data['fields'] = $this->crud->getCreateFields();
        $this->data['title'] = $this->crud->getTitle() ?? trans('backpack::crud.add').' '.$this->crud->entity_name;

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view('admin.modal', $this->data);
    }

    public function postModal(StoreRequest $request)
    {
        return view('admin.postModal');
    }

}
