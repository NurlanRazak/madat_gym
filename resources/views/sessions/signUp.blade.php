<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gull - Laravel + Bootstrap 4 admin template</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/styles/css/themes/lite-purple.min.css')}}">
</head>

<body>
    <div class="auth-layout-wrap" style="background-image: url({{asset('assets/images/bg.jpg')}})">
        <div class="auth-content">
                            <div class="auth-logo text-center mb-4">
                                <img src="{{asset('assets/images/logo.png')}}" alt="">
                            </div>
            <div class="card o-hidden" style="width: 20rem; margin: auto;">
                        <div class="p-4">

                            <h1 class="mb-3 text-18">Регистрация</h1>
                            <form method="POST" action="{{ route('register') }}">
                            @csrf
                                <div class="form-group">
                                    <label for="username">Ваше имя</label>
                                    <input id="username" class="form-control form-control-rounded" type="text" name="name">
                                    @error('name')
                                       <div class="alert alert-danger" role="alert">
                                         <strong>{{ $message }}</strong>
                                       </div>
                                   @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email">Email адрес</label>
                                    <input id="email" class="form-control form-control-rounded" type="email" name="email">
                                    @error('email')
                      					<div class="alert alert-danger" role="alert">
                      					  <strong>{{ $message }}</strong>
                      					</div>
                      				@enderror
                                </div>
                                <div class="form-group">
                                    <label for="password">Пароль</label>
                                    <input id="password" class="form-control form-control-rounded" type="password" name="password">
                                    @error('password')
                      					<div class="alert alert-danger" role="alert">
                      					  <strong>{{ $message }}</strong>
                      					</div>
                      				@enderror
                                </div>
                                <div class="form-group">
                                    <label for="repassword">Повторите пароль</label>
                                    <input id="repassword" class="form-control form-control-rounded" type="password" name="password_confirmation">
                                </div>
                                <button type="submit" class="btn btn-primary btn-block btn-rounded mt-3">Регистрация</button>
                            </form>
                        </div>
            </div>
        </div>
    </div>

    <script src="{{asset('assets/js/common-bundle-script.js')}}"></script>

    <script src="{{asset('assets/js/script.js')}}"></script>
</body>

</html>
