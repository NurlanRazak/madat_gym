@extends('layouts.app')

@section('content')
<div class="headerc text-center"><img src="{{asset('assets/images/logo.png')}}" alt="madatgym" width="50"></div>
    <section class="jumbotron text-center">

    </section>
    <div class="container">
    	<h1>ДОБРО ПОЖАЛОВАТЬ В MADATGYM!</h1>
    	<form method="POST" action="{{ route('register') }}">
        @csrf
    			<div class="form-group">
    			  <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Ваше ФИО" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
    			  @error('name')
    					<div class="alert alert-danger" role="alert">
    					  <strong>{{ $message }}</strong>
    					</div>
    				@enderror
    			</div>
    			<div class="form-group">
    			  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Ваша эклектронная почта">
    			  @error('email')
    					<div class="alert alert-danger" role="alert">
    					  <strong>{{ $message }}</strong>
    					</div>
    				@enderror
    			</div>
    			<div class="form-group">
    			  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Создай пароль">
    			  @error('password')
    					<div class="alert alert-danger" role="alert">
    					  <strong>{{ $message }}</strong>
    					</div>
    				@enderror
    			</div>
    			<div class="form-group">
    			  <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Повтори пароль">
    			</div>
    			<div class="form-group form-check">
    			  <input type="checkbox" class="form-check-input" id="exampleCheck1">
    			  <label class="form-check-label" for="exampleCheck1">ПРИШЛИТЕ МНЕ ПРИВЕТСТВЕННОЕ ПИСЬМО, БЛОГИ И МНОГОЕ ДРУГОЕ.</label>
    			</div>
    			<small>*СОЗДАВАЯ АККАУНТ, Я ПРИНИМАЮ <a href="#">ПОЛИТИКУ КОНФИДЕНЦИАЛЬНОСТИ</a>, <a href="#">ДОГОВОР ОФЕРТЫ</a> И <a href="#">УСЛОВИЯ ОПЛАТЫ</a></small>
    			<button type="submit" class="btn-block btn-gold active">СОЗДАТЬ МОЮ УЧЕТНУЮ ЗАПИСЬ</button>
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
