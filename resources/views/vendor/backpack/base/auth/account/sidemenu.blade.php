<div class="box">
    <div class="box-body box-profile">
        <form action="{{ route('edit-account-avatar') }}" method="POST" enctype="multipart/form-data" style="display: none;" id="usr-image-form">
            {!! csrf_field() !!}
            <input id="usr-image-input" accept="image/*" type="file" name="image" onchange="document.getElementById('usr-image-form').submit();">
        </form>
        <div style="width: 100px; height: 100px; background-image: url('{{ backpack_auth()->user()->image ? url('uploads/'.backpack_auth()->user()->image) : backpack_avatar_url(backpack_auth()->user()) }}'); background-size: cover; background-repeat: no-repeat; background-position: center; margin: auto; border-radius: 50%; cursor: pointer;" onclick="document.getElementById('usr-image-input').click();"></div>
	    <h3 class="profile-username text-center">{{ backpack_auth()->user()->name }}</h3>
        </form>
	</div>

	<ul class="nav nav-pills nav-stacked">

	  <li role="presentation"
		@if (Request::route()->getName() == 'backpack.account.info')
	  	class="active"
	  	@endif
	  	><a href="{{ route('backpack.account.info') }}">{{ trans('backpack::base.update_account_info') }}</a></li>

	  <li role="presentation"
		@if (Request::route()->getName() == 'backpack.account.password')
	  	class="active"
	  	@endif
	  	><a href="{{ route('backpack.account.password') }}">{{ trans('backpack::base.change_password') }}</a></li>

	</ul>
</div>
