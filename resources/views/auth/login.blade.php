@extends('layouts.app')

@section('content')
<div class="headerc text-center"><img src="{{asset('assets/images/logo.png')}}" alt="madatgym" width="50"></div>
		<section class="jumbotron text-center">

		</section>
    <div class="container">

    	<h1>ДОБРО ПОЖАЛОВАТЬ В MADATGYM!</h1>
    	<form method="post" action="{{ route('login') }}">
    		@csrf
			<div class="form-group">
			  <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Ваша эклектронная почта" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
			  @error('email')
					<div class="alert alert-danger" role="alert">
					  <strong>{{ $message }}</strong>
					</div>
				@enderror
			</div>
			<div class="form-group">
			  <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Создай пароль" name="password" required autocomplete="current-password">
			  @error('password')
					<div class="alert alert-danger" role="alert">
					  <strong>{{ $message }}</strong>
					</div>
				@enderror
				@if (Route::has('password.request'))
			  <small id="emailHelp" class="form-text text-muted"><a href="{{ route('password.request') }}">Забыли пароль?</a></small>
			  @endif
			</div>
			<div class="form-group form-check">
			  <input type="checkbox" class="form-check-input" id="remember" name="remember"  {{ old('remember') ? 'checked' : '' }}>
			  <label class="form-check-label" for="remember">Запомнить меня</label>
			</div>
			<button type="submit" class="btn-block btn-gold active">ВХОД</button>
		  </form>
    </div>
    <section class="footer text-center">
    	<ul>
    		<li><a href="">ПОЛИТИКА КОНФИДЕНЦИАЛЬНОСТИ</a></li>
    		<li><a href="">ДОГОВОР ОФЕРТЫ</a></li>
    		<li><a href="">УСЛОВИЯ ОПЛАТЫ</a></li>
    	</ul>
    	<p>©2015-2019 MAG Co. Все права защищены.</p>
    </section>
@endsection
