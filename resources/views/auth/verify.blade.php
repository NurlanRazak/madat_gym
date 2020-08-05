<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MadAtGym.com</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/styles/css/themes/lite-purple.min.css')}}">
</head>

<body>
    <div class="auth-layout-wrap" style="background-image: url({{asset('assets/images/bg.jpg')}})">
        <div class="auth-content">
            <div class="card o-hidden">
              <div class="row">
                <div class="col-md-12 text-center ">
                            <div class="pl-3 auth-right">
                                <div class="auth-logo text-center mt-4 mb-4">
                                    <img src="{{asset('assets/images/logo.png')}}" alt="">
                                </div>
                                <div class="w-100 mb-4">
                                    Добро пожаловать в онлайн фитнес madatgym! {{ __('Проверьте свой адрес электронной почты') }}
                                    @if (session('resent'))
                                        <div class="alert alert-success" role="alert">
                                            {{ __('На ваш адрес электронной почты была отправлена новая ссылка для подтверждения.') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1"></div>
                                <div class="w-100 mb-4">


                                    {{ __('Прежде чем продолжить, проверьте свою электронную почту на наличие ссылки для подтверждения.') }}
                                    {{ __('Если вы не получили письмо') }}, <a href="{{ route('verification.resend') }}">{{ __('нажмите здесь, чтобы запросить другой') }}</a>.
                                </div>
                            </div>
                        </div>
              </div>

            </div>
        </div>
    </div>

    <script src="{{asset('assets/js/common-bundle-script.js')}}"></script>
    <script src="{{asset('assets/js/script.js')}}"></script>
</body>

</html>
