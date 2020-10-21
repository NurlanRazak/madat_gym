@extends('admin.layout')
@section('content')
<script>
	function sendToParent(data) {
		console.log(data)
		@if(isset($type) && $type == 'item')
	        window.opener.app.$refs['calendar'].setItemData(data);
		@elseif(isset($type) && $type == 'subitem')
	        window.opener.app.$refs['calendar'].setSubitemData(data);
	    @else
	        window.opener.app.$refs['calendar'].setGroupData(data);
		@endif
	}
</script>

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
