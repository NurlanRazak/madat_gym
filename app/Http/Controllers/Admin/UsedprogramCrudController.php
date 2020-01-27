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
class UsedprogramCrudController extends CrudController
{

    protected $from = null;
    protected $to = null;

    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Activeprogram');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/usedprogram');
        $this->crud->setEntityNameStrings(trans_choice('admin.programtraining', 1), trans_choice('admin.programtraining', 2));
        $this->crud->denyAccess(['create', 'update', 'delete']);
        $this->crud->removeAllButtons();

        $this->crud->query->where(function($q) {
            $q->whereHas('program', function($query) {
                $query->whereHas('users', function($query) {
                    $query->whereDoesntHave('roles');
                });
            })->orWhereHas('program', function($q) {
                $q->whereHas('programHistories');
            });
        });

        $this->crud->addFilter([
            'name' => 'program_date',
            'label' => 'Дата',
            'type' => 'date_range',
            'label_from' => 'с',
            'label_to' => 'до'
        ],
        false,
        function ($value) {
            $range = json_decode($value);
            $this->from = $range->from;
            $this->to = $range->to;
            // if ($range->from) {
            //     $this->crud->query->where(function($q) {
            //         $q->whereHas('program', fun)
            //     })->addClause('where', 'program_histories.program_date', '>=', $range->from);
            // }
            // if ($range->to) {
            //     $this->crud->addClause('where', 'program_histories.program_date', '<=', $range->to);
            // }
        });

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        $from = $this->from;
        $to = $this->to;

        $this->crud->addColumns([
            [
                'name' => 'row_number',
                'label' => '#',
                'type' => 'row_number',
            ],
            [
                'name' => 'program',
                'label' => 'Программа',
                'type' => 'select',
                'attribute' => 'name',
                'entity' => 'program',
            ],
            [
                'name' => 'all_cnt',
                'label' => 'Количество подписок',
                'type' => 'closure',
                'function' => function($model) use ($from, $to) {
                    $cnt = 0;

                    $cnt += $model->program->users()->whereDoesntHave('roles')->where(function($q) use($from, $to) {
                        if ($from) {
                            $q->where('programtraining_start', '>=', $from);
                        }
                        if ($to) {
                            $q->where('programtraining_start', '<=', $to);
                        }
                    })->count();

                    $cnt += $model->program->programHistories()->where(function($q) use ($from, $to){
                        if ($from) {
                            $q->where('program_date', '>=',  Carbon::parse($from)->format('Y-m-d'));
                        }
                        if ($to) {
                            $q->where('program_date', '<=', Carbon::parse($to)->format('Y-m-d'));
                        }
                    })->count();

                    return $cnt;
                }
            ],
            // [
            //     'name' => 'all_users',
            //     'label' => 'Пользователи',
            //     'type' => 'table',
            // ],
        ]);

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
