<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\PlaneatRequest as StoreRequest;
use App\Http\Requests\PlaneatRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use App\Services\MenuService\Traits\AccessLevelsTrait;

/**
 * Class PlaneatCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class PlaneatCrudController extends CrudController
{
    use AccessLevelsTrait;
    protected $jwplayer;

    public function __construct()
    {
        parent::__construct();
        $this->jwPlayer = new \App\Services\Jwplayer();
    }

    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Planeat');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/planeat');
        $this->crud->setEntityNameStrings(trans_choice('admin.planeat',1), trans_choice('admin.planeat', 2));
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
            'name' => 'foodprogram_id',
            'label' => 'Программа питания',
            'type' => 'select2',
        ], function () {
            return \App\Models\Foodprogram::all()->pluck('name', 'id')->toArray();
        }, function ($value) {
            $this->crud->addClause('where', 'foodprogram_id', $value);
        });
        $this->crud->addFilter([
            'name' => 'meals',
            'label' => 'Блюда',
            'type' => 'select2_multiple'
        ], function() {
            return \App\Models\Meal::all()->pluck('name', 'id')->toArray();
        }, function ($values) {
            foreach(json_decode($values) as $key=>$value) {
                $this->crud->query = $this->crud->query->whereHas('meals', function ($query) use ($value) {
                    $query->where('meal_id', $value);
                });
            }
        });
        $this->crud->addFilter([
            'name' => 'eathours',
            'label' => 'Часы приема',
            'type' => 'select2_multiple',
        ], function() {
            return \App\Models\Eathour::all()->pluck('name', 'id')->toArray();
        }, function ($values) {
            foreach(json_decode($values) as $key=>$value) {
                $this->crud->query = $this->crud->query->whereHas('eathours', function ($query) use($value) {
                    $query->where('eathour_id', $value);
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
                'name' => 'row_number',
                'type' => 'row_number',
                'label' => '#',
                'orderable' => false,
            ],
            [
                'name' => 'foodprogram_id',
                'label' => 'Программа питания',
                'type' => 'select',
                'entity' => 'foodprogram',
                'attribute' => 'name',
                'model' => 'App\Models\Foodprogram',
            ],
            [
                'name' => 'meals',
                'label' => 'Блюда',
                'type' => 'select_multiple',
                'entity' => 'meals',
                'attribute' => 'name',
                'model' => 'App\Models\Meal',
            ],
            [
                'name' => 'days',
                'label' => 'День в программе',
            ],
            [
                'name' => 'eathours',
                'label' => 'Час приема',
                'type' => 'select_multiple',
                'entity' => 'eathours',
                'attribute' => 'name',
                'model' => 'App\Models\Eathour',
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
                'type' => 'jwvideo',
            ],
            [
                'name' => 'active',
                'label' => 'Опубликован',
                'type' => 'check',
            ],
        ]);

        $this->crud->addFields([
            [
                'name' => 'foodprogram_id',
                'label' => 'Программа питания',
                'type' => 'select2',
                'entity' => 'foodprogram',
                'attribute' => 'name',
                'model' => 'App\Models\Foodprogram',
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [
                'name' => 'meals',
                'label' => 'Блюда',
                'type' => 'select2_multiple',
                'entity' => 'meals',
                'attribute' => 'name',
                'model' => 'App\Models\Meal',
                'pivot' => true,
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [
                'name' => 'days',
                'label' => 'День в программе',
                'type' => 'number',
                'attributes' => ["step" => "any"],
                'attributes' => [
                    'required' => 'required',
                ],
            ],
            [
                'name' => 'eathours',
                'label' => 'Часы приема',
                'type' => 'select2_multiple',
                'entity' => 'eathours',
                'attribute' => 'name',
                'model' => 'App\Models\Eathour',
                'pivot' => true,
                'attributes' => [
                    'required' => 'required',
                ],
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
                'type' => 'select_video',
                'options' => $this->jwPlayer->getVideoOptions(),
            ],
            [
                'name' => 'active',
                'label' => 'Опубликован',
                'type' => 'checkbox',
            ],
        ]);

        // add asterisk for fields that are required in PlaneatRequest
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
        $this->data['extra'] = request()->input();
        foreach($this->data['extra'] as $key => $value) {
            if (!$value) {
                unset($this->data['extra'][$key]);
                continue;
            }
            $this->crud->removeField($key);
        }
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->getSaveAction();
        $this->data['fields'] = $this->crud->getCreateFields();
        $this->data['title'] = $this->crud->getTitle() ?? trans('backpack::crud.add').' '.$this->crud->entity_name;
        // $this->data['options'] = $this->crud->model->active()->get()->map(function($item) {
        //     return $item->toCalendar();
        // })->toArray();
        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view('admin.modal', $this->data);
    }

    public function postModal()
    {
        $redirect_location = parent::storeCrud(request());
        $this->crud->entry->delete();
        return view('admin.postModal', [
            'type' => 'item',
            'data' => $this->crud->entry->toCalendar()
        ]);
    }
}
