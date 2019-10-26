@extends('layouts.app')

@section('content')
<div class="headerc text-center"><img src="{{asset('assets/images/logo.png')}}" alt="madatgym" width="50"></div>
    <section class="jumbotron text-center">
        
    </section>
    <div class="container">
        <h1>ДОБРО ПОЖАЛОВАТЬ В MADATGYM!</h1>
        <div class="card">
            <div class="card-header">{{ __('Verify Your Email Address') }}</div>

            <div class="card-body">
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif

                {{ __('Before proceeding, please check your email for a verification link.') }}
                {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
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
