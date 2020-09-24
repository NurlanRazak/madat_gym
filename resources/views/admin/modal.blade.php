@extends('admin.layout')
@section('content')
<div class="row m-t-20">
	<div class="{{ $crud->getCreateContentClass() }}">
		<!-- Default box -->

		@include('crud::inc.grouped_errors')

		  <form id="createForm"
                method="post"
				@if ($crud->hasUploadFields('create'))
				enctype="multipart/form-data"
				@endif
		  		>
		  {!! csrf_field() !!}
		  @foreach($extra ?? [] as $key => $value)
		  	@if(is_array($value))
				@foreach($value as $index => $val)
					<input type="hidden" name="{{ $key }}[{{ $index }}]" value="{{ $val }}" />
				@endforeach
			@else
				<input type="hidden" name="{{ $key }}" value="{{ $value }}" />
			@endif
		  @endforeach
		  <div class="col-md-12">

		    <div class="row display-flex-wrap">
		      <!-- load the view from the application if it exists, otherwise load the one in the package -->
		      @if(view()->exists('vendor.backpack.crud.form_content'))
		      	@include('vendor.backpack.crud.form_content', [ 'fields' => $crud->getFields('create'), 'action' => 'create' ])
		      @else
		      	@include('crud::form_content', [ 'fields' => $crud->getFields('create'), 'action' => 'create' ])
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
