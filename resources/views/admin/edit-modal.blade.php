@extends('admin.layout')
@section('content')

<div class="row m-t-20">
	<div class="{{ $crud->getCreateContentClass() }}">
		<!-- Default box -->

		@include('crud::inc.grouped_errors')

		@if(isset($options))
			@php
				$options = collect($options)->unique('name');
			@endphp
			<div class="" style="margin-bottom: 30px;">
				@foreach($options as $index => $option)
					<button class="btn btn-primary" style="margin-bottom: 5px;" onclick='sendToParent(@json($option))'>{{ $option['name'] ?? '' }}</button>
				@endforeach
			</div>
		@endif
		<form method="post"
			  @if ($crud->hasUploadFields('update', $entry->getKey()))
			  enctype="multipart/form-data"
			  @endif
			  >
		{!! csrf_field() !!}
		{!! method_field('PUT') !!}
		<div class="col-md-12">
		  @if ($crud->model->translationEnabled())
		  <div class="row m-b-10">
			  <!-- Single button -->
			  <div class="btn-group pull-right">
				<button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				  {{trans('backpack::crud.language')}}: {{ $crud->model->getAvailableLocales()[$crud->request->input('locale')?$crud->request->input('locale'):App::getLocale()] }} &nbsp; <span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
				  @foreach ($crud->model->getAvailableLocales() as $key => $locale)
					  <li><a href="{{ url($crud->route.'/'.$entry->getKey().'/edit') }}?locale={{ $key }}">{{ $locale }}</a></li>
				  @endforeach
				</ul>
			  </div>
		  </div>
		  @endif
		  <div class="row display-flex-wrap">
			<!-- load the view from the application if it exists, otherwise load the one in the package -->
			@if(view()->exists('vendor.backpack.crud.form_content'))
			  @include('vendor.backpack.crud.form_content', ['fields' => $fields, 'action' => 'edit'])
			@else
			  @include('crud::form_content', ['fields' => $fields, 'action' => 'edit'])
			@endif
		  </div><!-- /.box-body -->

		  <div class="">

			  @include('admin.form_save_buttons')

		  </div><!-- /.box-footer-->
		</div><!-- /.box -->
		</form>

	</div>
</div>
@endsection
