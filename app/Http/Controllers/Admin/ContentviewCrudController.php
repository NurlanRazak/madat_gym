<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\UserparameterRequest as StoreRequest;
use App\Http\Requests\UserparameterRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use App\Models\Userparameter;
use Carbon\Carbon;

/**
 * Class UserparameterCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ContentviewCrudController extends CrudController
{

    protected $dates = null;

    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\View');
        $models = [
            '\App\Models\Exercise' => ['video'],
            '\App\Models\Relaxexercise' => ['video', 'audio'],
        ];
        $this->crud->query = null;
        foreach($models as $model => $types) {
            $model_path = str_replace('\\', '\/', $model);
            foreach($types as $type) {
                if (!$this->crud->query) {
                    $this->crud->query = $model::whereNotNull($type)->select(['id', 'name', \DB::raw("{$type} as 'source'")])->addSelect(\DB::raw("'{$type}' as type"))->addSelect(\DB::raw("'{$model_path}' as model"));
                } else {
                    $this->crud->query->unionAll($model::whereNotNull($type)->select(['id', 'name', \DB::raw("{$type} as 'source'")])->addSelect(\DB::raw("'{$type}' as type"))->addSelect(\DB::raw("'{$model_path}' as model")));
                }
            }
        }

        $this->crud->setRoute(config('backpack.base.route_prefix') . '/contentview');
        $this->crud->setEntityNameStrings('Просмотр контента', 'Просмотр контента');
        $this->crud->denyAccess(['create', 'update', 'delete']);
        $this->crud->removeAllButtons();

        $this->crud->addFilter([ // daterange filter
          'type' => 'date_range',
          'name' => 'date_start',
          'label'=> 'Дата просмотра'
        ],
        false,
        function($value) { // if the filter is active, apply these constraints
            $this->dates = json_decode($value);
        });
        
        $this->crud->addColumns([
            [
                'name' => 'row_number',
                'label' => '#',
                'type' => 'row_number',
            ],
            [
                'name' => 'name',
                'label' => 'Упражнение',
                'type' => 'closure',
                'function' => function($item) {
                    $url = strtolower("/admin/".class_basename($item->model))."/{$item->id}";
                    return "<a href='{$url}'>{$item->name}</a>";
                }
            ],
            [
                'name' => 'type',
                'label' => 'Контент',
                'type' => 'closure',
                'function' => function($item) {
                    if ($item->type == 'video') {
                        return "<video src=\"".asset('uploads/'.$item->source)."\" controls width='300' preload='none'></video>";
                    } else if ($item->type == 'audio') {
                        return "<audio src=\"".asset('uploads/'.$item->source)."\" controls width='300' preload='none'></audio>";
                    }
                },
                'limit' => 10000,
            ],
            [
                'name' => 'cnt',
                'label' => 'Просмотров',
                'type' => 'closure',
                'function' => function($item) {

                    $query= \App\View::where('model', str_replace('/', '\\', $item->model))
                                     ->where('model_id', $item->id)
                                     ->where('type', $item->type)
                                     ->where('url', asset('uploads/'.$item->source));

                    if($this->dates) {
                        if ($this->dates->from) {
                            $query->where('created_at', '>=', $this->dates->from);
                        }
                        if ($this->dates->to) {
                            $query->where('created_at', '<=', $this->dates->to . ' 23:59:59');
                        }
                    }
                    return $query->count();
                }
            ],
        ]);
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // add asterisk for fields that are required in UserparameterRequest
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
