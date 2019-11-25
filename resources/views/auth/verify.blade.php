@extends('layouts.app')

@section('content')
<div class="headerc text-center"><img src="{{asset('assets/images/logo.png')}}" alt="madatgym" width="50"></div>
    <section class="jumbotron text-center">

    </section>
    <div class="container">
        <h1>ДОБРО ПОЖАЛОВАТЬ В MADATGYM!</h1>
        <div class="card">
            <div class="card-header">{{ __('Проверьте свой адрес электронной почты') }}</div>

            <div class="card-body">
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('На ваш адрес электронной почты была отправлена новая ссылка для подтверждения.') }}
                    </div>
                @endif

                {{ __('Прежде чем продолжить, проверьте свою электронную почту на наличие ссылки для подтверждения.') }}
                {{ __('Если вы не получили письмо') }}, <a href="{{ route('verification.resend') }}">{{ __('нажмите здесь, чтобы запросить другой') }}</a>.
            </div>
        </div>
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
