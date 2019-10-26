@extends('layouts.app')

@section('content')
<div class="headerc text-center"><img src="{{asset('assets/images/logo.png')}}" alt="madatgym" width="50"></div>
    <section class="jumbotron text-center">
        
    </section>
    <div class="container">
        <h1>Восстановление пароля</h1>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group">
              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" placeholder="Ваша эклектронная почта">
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
              <input id="password-confirm" type="password" class="form-control" name="password_confirm" required autocomplete="new-password" placeholder="Повтори пароль">
            </div>
            <button type="submit" class="btn-block btn-gold active">Восстановить пароль</button>
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
