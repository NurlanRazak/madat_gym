<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\RelaxexerciseRequest as StoreRequest;
use App\Http\Requests\RelaxexerciseRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use App\Services\MenuService\Traits\AccessLevelsTrait;

/**
 * Class RelaxexerciseCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class RelaxexerciseCrudController extends CrudController
{
    use AccessLevelsTrait;
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Relaxexercise');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/relaxexercise');
        $this->crud->setEntityNameStrings(trans_choice('admin.relaxexercise', 1), trans_choice('admin.relaxexercise', 2));
        $this->setAccessLevels();

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
                'name' => 'audio',
                'label' => 'Аудио',
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
                'label' => 'Название упражнения'
            ],
            [
                'name' => 'short_desc',
                'label' => 'Короткое описание',
                'type' => 'textarea',
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
                'disk' => 'uploads',
            ],
            [
                'name' => 'audio',
                'label' => 'Аудио',
                'type' => 'upload',
                'upload' => true,
                'disk' => 'uploads',
            ],
            [
                'name' => 'active',
                'label' => 'Опубликован',
                'type' => 'checkbox',
            ],
        ]);

        // add asterisk for fields that are required in RelaxexerciseRequest
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
