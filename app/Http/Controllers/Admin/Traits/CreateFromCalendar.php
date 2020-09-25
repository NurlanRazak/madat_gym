<?php

namespace App\Http\Controllers\Admin\Traits;

trait CreateFromCalendar
{

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

        $this->data['type'] = 'item';
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->getSaveAction();
        $this->data['fields'] = $this->crud->getCreateFields();
        $this->data['title'] = $this->crud->getTitle() ?? trans('backpack::crud.add').' '.$this->crud->entity_name;
        $this->data['options'] = $this->crud->model->active()->get()->map(function($item) {
            return $item->toCalendar();
        })->toArray();
        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view('admin.modal', $this->data);
    }

    public function postModal()
    {
        $redirect_location = parent::storeCrud(request());
        $this->crud->entry->delete();
        return view('admin.postModal', [
            'type' => 'item',
            'data' => [
                'id' => $this->crud->entry->id,
                'name' => $this->crud->entry->name,
            ]
        ]);
    }

}
