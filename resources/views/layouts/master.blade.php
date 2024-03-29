<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>MadatGym.com</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
        <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}">
        @yield('before-css')
        {{-- theme css --}}
        <link id="gull-theme" rel="stylesheet" href="{{  asset('assets/styles/css/themes/lite-purple.css')}}">
        <link rel="stylesheet" href="{{asset('assets/styles/vendor/perfect-scrollbar.css')}}">
        <link rel="stylesheet" href="{{asset('assets/styles/css/owl.carousel.min.css')}}">
        <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

        <style>
            .rating-nav a {
                padding: 10px 20px;
            }
            .rating-nav li {
                padding: 10px 0px;
            }
            .rating-nav a.active {
                background-color: #fff3cd;
            }
            .owl-nav{
                position: absolute;
                /* margin: auto 20px; */
                display: flex;
                justify-content: space-between;
                width: 100%;
                top: 50%;
            }
            .active-day {
                background-color: #fbe697!important;
            }
            .day-disabled {
                background: grey!important;
                cursor: not-allowed;
            }
            .li{
             -webkit-animation-name: spin;
             -webkit-animation-duration: 4000ms;
             -webkit-animation-iteration-count: infinite;
             -webkit-animation-timing-function: linear;
             -moz-animation-name: spin;
             -moz-animation-duration: 4000ms;
             -moz-animation-iteration-count: infinite;
             -moz-animation-timing-function: linear;
             -ms-animation-name: spin;
             -ms-animation-duration: 4000ms;
             -ms-animation-iteration-count: infinite;
             -ms-animation-timing-function: linear;
             animation-name: spin;
             animation-duration: 4000ms;
             animation-iteration-count: infinite;
             animation-timing-function: linear;
             @-ms-keyframes spin {
                 from {
                     -ms-transform: rotate(0deg);
                 } to {
                     -ms-transform: rotate(360deg);
                 }
             }
             @-moz-keyframes spin {
                 from {
                     -moz-transform: rotate(0deg);
                 } to {
                     -moz-transform: rotate(360deg);
                 }
             }
             @-webkit-keyframes spin {
                 from {
                     -webkit-transform: rotate(0deg);
                 } to {
                     -webkit-transform: rotate(360deg);
                 }
             }
             @keyframes spin {
                 from {
                     transform: rotate(0deg);
                 } to {
                     transform: rotate(360deg);
                 }
             }
           }
            .sub_event{
                background: rgb(102, 51, 153);
                border-radius: 3px;
                padding: 5px;
                margin: 5px 5px 0 5px;
           }
           #timerWrap{
              position: fixed;
              z-index: 999;
              bottom: 15px;
              right: 15px;
              background: #663399;
              border-radius: 5px;
              color: #fff;
              padding: 10px;
            }
            #timerTrigger{
              position: absolute;
              bottom: 15px;
              right: 15px;
              z-index: 998;
            }
        </style>
        <script src="https://kit.fontawesome.com/d1edd4ad8f.js"></script>
        <script src="https://cdn.jwplayer.com/libraries/{{ config('jwplayer.player_id') }}.js"></script>
        {{-- page specific css --}}
        @yield('page-css')
        @yield('head-js')
    </head>


    <body class="text-left">
        @php
        $layout = session('layout');
        @endphp

        <!-- Pre Loader Strat  -->
        <div class='loadscreen' id="preloader">

            <div class="loader">
                  <img src="{{ asset('assets/images/logo.png')}}" alt="pre" width="50" class="li">
            </div>
        </div>
        <!-- Pre Loader end  -->




        <!-- ============Deafult  Large SIdebar Layout start ============= -->

        {{-- normal layout --}}
        <div class="app-admin-wrap layout-sidebar-large clearfix">
            @include('layouts.header-menu')
            {{-- end of header menu --}}


            {{-- end of left sidebar --}}

            <!-- ============ Body content start ============= -->
             <div class="main-content-wrap d-flex flex-column">
                <div class="main-content">
                    @yield('main-content')
                </div>

                @include('layouts.footer')
            </div>
            <!-- ============ Body content End ============= -->
        </div>
        <!--=============== End app-admin-wrap ================-->

        <!-- ============ Search UI Start ============= -->
        @include('layouts.search')
        <!-- ============ Search UI End ============= -->


        <!-- ============ Large Sidebar Layout End ============= -->





        {{-- common js --}}
        <script src="{{mix('assets/js/common-bundle-script.js')}}"></script>
        {{-- page specific javascript --}}
        @yield('page-js')

        {{-- theme javascript --}}
        {{-- <script src="{{mix('assets/js/es5/script.js')}}"></script> --}}
        <script src="{{asset('assets/js/script.js')}}"></script>

        <script src="{{asset('assets/js/sidebar.large.script.js')}}"></script>

        <script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>

        <script src="{{asset('assets/js/customizer.script.js')}}"></script>

                <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
                @if(Session::has('message'))
                    <script>
                        toastr.{{ Session::get('type', 'info') }}("{{ Session::get('message') }}");
                    </script>
                @endif


        <script>
            $(document).ready(function(){
              $(".owl-carousel").owlCarousel({
                loop: false,
                rewind: true,
                nav: true,
                navText: ["<img src='{{asset('assets/images/prev.png')}}'>","<img src='{{asset('assets/images/next.png')}}'>"],
                responsive:{
                    0:{
                        items:1
                    },
                    600:{
                        items:1
                    },
                    1000:{
                        items:3
                    }
                }
            });
              $("#userdataedit").click(function (e) {
                  e.preventDefault();
                  var input = $('.userdataediti');
                  sost = !input.prop('disabled');
                  input.prop('disabled', sost);
                  if($("#save").hasClass("invisible")){
                    $("#save").removeClass("invisible");
                  }else{
                    $("#save").addClass("invisible");
                  }
                });
              $("#save").click(function () {
                  $("#save").addClass("invisible");
                  $('.userdataediti').prop('disabled', true);
              })
              $("#userparamsedit").click(function (e) {
                  e.preventDefault();
                  var input = $('.userparamsediti');
                  sost = !input.prop('disabled');
                  input.prop('disabled', sost);
                });
              $("#userplanedit").click(function (e) {
                  e.preventDefault();
                  var input = $('.userplanediti');
                  sost = !input.prop('disabled');
                  input.prop('disabled', sost);
                });

              $(".profile-picture").click(function(){
                $("#file-input").trigger('click');
              });
              $.fn.isTimeSet();
            });
            let timerInterval;
            $.fn.setTime = function(){
               //this function ensures that the user enter the correct format
               var time = $("#time").val();
               console.log(time);
               var fields = time.split(':');
               var hour = fields[0];
               var min = fields[1];
               var sec = fields[2];

               if(time === ''){
                   $("#status").html("Пожалуйста введите время!");
               }else{
                 if(hour < 24 && min < 60 && sec < 60){
                    $("#status").html("Время идет!");
                     $.fn.count(hour, min, min, sec, sec);
                     $("#timeBtn").prop('disabled', false);
                    $("#time").prop('disabled', false);
                 }else{
                    $("#status").html("Пожалуйста введите время правильно!");
                 }
               }
             }
             $.fn.count = function(hour, min, minLeft, sec, secLeft){
                 //this function is the count control is will check if the count down is finish
                 if(hour > 0 || min > 0 || minLeft > 0 || secLeft > 0){
                     if(secLeft == 0){
                       min -= 1;
                       sec = 59;
                     }
                     if(minLeft == 0){
                       if(hour != 0){
                          hour -= 1;
                          min = 59;
                        } else {
                          hour = 0;
                          min = 0;
                        }
                     }
                     $("#hour").html(hour);
                     $("#min").html(min);
                     $.fn.countDown(hour, min, sec);
                 }else{
                   $("#status").html("Установите время:");
                   localStorage.removeItem("time");
                   alert("Время вышло!");
                   $("#timeBtn").prop('disabled', false);
                   $("#time").prop('disabled', false);
                 }
             }
             $.fn.stopTimer = function() {
                 clearInterval(timerInterval);
                 localStorage.removeItem("time");

                 $("#status").html("Установите время:");
                 $("#hour").html(00);
                 $("#min").html(00);
                 $("#sec").html(00);

                 $("#timeBtn").prop('disabled', false);
                 $("#time").prop('disabled', false);
             }
             $.fn.countDown = function(hour, min, sec){
                //this function runs the seconds count
                 var time = sec;
                 $("#sec").html(time);
                 if (timerInterval) {
                     clearInterval(timerInterval);
                 }
                 timerInterval = setInterval(function(){
                     $("#sec").html(-- time);
                     $.fn.rememberMe(hour, min, time);
                     if (time == 0) {
                         clearInterval(timerInterval);
                       $.fn.count(hour, min, min, sec, "00");
                     }
                     if($('#sec').text().length < 2){
                       $('#sec').prepend('0');
                     }
                     if($("#min").text().length < 2){
                       $('#min').prepend('0');
                     }
                     if($("#hour").text().length < 2){
                       $('#hour').prepend('0');
                     }

                 }, 1000);
             }
             $.fn.rememberMe = function(hour, min, sec){
               //this function stores the time as a local storage incase the page refresh
               if (typeof(Storage) !== "undefined") {
                  localStorage.setItem("time",hour+':'+min+':'+sec);
               }else{
                  $("status").html("Ваш браузер не поддерживает наш таймер!");
               }
             }
             $.fn.isTimeSet = function(){
                  //this function checks if there is a time set
                  if(localStorage.getItem("time") != null){
                       var time = localStorage.getItem("time");
                       var fields = time.split(':');
                       hour = fields[0];
                       min = fields[1];
                       sec = fields[2];
                       $("#status").html("Оставшееся время:");
                       $("#timeBtn").prop('disabled', true);
                       $("#time").prop('disabled', true);
                       $.fn.count(hour, min, sec, sec);
                       $("#timerWrap").show();
                  }
             }
        </script>

        {{-- laravel js --}}
        {{-- <script src="{{mix('assets/js/laravel/app.js')}}"></script> --}}

        @yield('bottom-js')
    </body>

</html>
