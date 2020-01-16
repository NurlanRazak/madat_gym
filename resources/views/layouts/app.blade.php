<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>MadAtGym.com</title>

    <!-- Scripts -->
    <script src="{{ asset('js/laravel/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

            <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
            @if(Session::has('message'))
                <script>
                    toastr.{{ Session::get('type', 'info') }}("{{ Session::get('message') }}");
                </script>
            @endif
    <style>
	@font-face{
	font-family: HelveticaLight;
	src: url(fonts/HelveticaNeueCyr-Light.otf);
}
@font-face{
	font-family: HelveticaUltraLight;
	src: url(fonts/HelveticaNeueCyr-UltraLight.otf);
}
@font-face{
	font-family: HelveticaBold;
	src: url(fonts/HelveticaNeueCyr-Bold.otf);
}

body{
	font-family: HelveticaLight, sans-serif !important;
}

strong{
	font-family: HelveticaBold, sans-serif !important;
}

.jumbotron{
	 background: url({{asset('assets/images/bg.jpg')}});
	 background-size: cover;
	 background-position: center;
	 border-radius: 0px !important;
	 height: 350px;
}

.headerc{
	 position: absolute;
	 top: 0; left: 0; right: 0;
	 background: #000;
	 opacity: .9;
	 padding: 10px 0;
}

.form-control{
	 border: 0px !important;
	 border-bottom: 2px solid #000 !important;
	 border-radius: 0px !important;
	 transition: 1s;
}

::placeholder{
	 color: #ccc !important;
	 opacity: 1;
}

input:focus{
	 box-shadow: none !important;
	 border-color: #FBE697 !important;
	 transition: 1s;
}

button:focus{
	 box-shadow: none !important;
}

.btn-gold.active{
	background: #FBE697;
	 cursor: pointer !important;
	 pointer-events: auto !important;
}

.btn-choise.active{
	 background: #FBE697 !important;
}

.btn-gold{
	 background: #ccc;
	 cursor: not-allowed !important;
	 pointer-events: none;
     color: #000;
	 border: none;
	 border-radius: .3rem;
	 padding: .5rem 1rem;
}

.btn-choise{
	 background: #ccc !important;
     color: #000;
	 border: none;
	 border-radius: .3rem;
	 padding: .5rem 1rem;
}

.footer{
	 position: absolute;
	 bottom: 0; left: 0; right: 0;
	 background: #272727;
	 padding: 15px 0;
}

.footer ul li{
	 list-style: none;
	 display: inline-block;
	 margin: 0 10px;
}

.footer ul li a{
	color: #fff;
}

.footer p{
	color: #fff;
}
		@media screen and (max-width: 768px){
			.jumbotron{
				display: none;
			}
		}</style>
</head>
<body>

            @yield('content')
</body>
</html>
