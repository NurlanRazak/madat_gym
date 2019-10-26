@extends('layouts.app')

@section('content')
<div class="headerc text-center"><img src="logo.png" alt="madatgym" width="50"></div>
    <section class="jumbotron text-center">
    	
    </section>
    
    <div class="container">
		@if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
    	<h1>ПРОБЛЕМЫ СО ВХОДОМ?</h1>
    	<p>Введите адрес электронной почты и мы отправим вам ссылку для
сброса пароля</p>
    	<form method="POST" action="{{ route('password.email') }}">
    		@csrf
			<div class="form-group">
			  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Ваша эклектронная почта">
			  
			  @error('email')
					<div class="alert alert-danger" role="alert">
					  <strong>{{ $message }}</strong>
					</div>
				@enderror
			</div>
			<button type="submit" class="btn-block btn-gold active">ОТПРАВИТЬ</button>
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
