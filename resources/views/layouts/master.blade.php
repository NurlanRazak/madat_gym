<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Gull - Laravel + Bootstrap 4 admin template</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
        @yield('before-css')
        {{-- theme css --}}
        <link id="gull-theme" rel="stylesheet" href="{{  asset('assets/styles/css/themes/lite-purple.css')}}">
        <link rel="stylesheet" href="{{asset('assets/styles/vendor/perfect-scrollbar.css')}}">
        <link rel="stylesheet" href="{{asset('assets/styles/css/owl.carousel.min.css')}}">
                <style>
            .owl-nav{
                position: absolute;
                /* margin: auto 20px; */
                display: flex;
                justify-content: space-between;
                width: 100%;
                top: 50%;
            }

        </style>
        <script src="https://kit.fontawesome.com/d1edd4ad8f.js"></script>
        {{-- page specific css --}}
        @yield('page-css')
    </head>


    <body class="text-left">
        @php
        $layout = session('layout');
        @endphp

        <!-- Pre Loader Strat  -->
        <div class='loadscreen' id="preloader">

            <div class="loader spinner-bubble spinner-bubble-primary">


            </div>
        </div>
        <!-- Pre Loader end  -->




        <!-- ============Deafult  Large SIdebar Layout start ============= -->

        {{-- normal layout --}}
        <div class="app-admin-wrap layout-sidebar-large clearfix">
            @include('layouts.header-menu')
            {{-- end of header menu --}}



            @include('layouts.sidebar')
            {{-- end of left sidebar --}}

            <!-- ============ Body content start ============= -->
            <div class="main-content-wrap sidenav-open d-flex flex-column">
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



        <script>
            $(document).ready(function(){
              $(".owl-carousel").owlCarousel({
                loop: true,
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
                  console.log("click");
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
                  console.log("click");
                  var input = $('.userparamsediti');
                  sost = !input.prop('disabled');
                  input.prop('disabled', sost);
                });
              $("#userplanedit").click(function (e) {
                  e.preventDefault();
                  console.log("click");
                  var input = $('.userplanediti');
                  sost = !input.prop('disabled');
                  input.prop('disabled', sost);
                });

              $(".profile-picture").click(function(){
                $("input[type='file'").trigger('click');
              });
            });
        </script>

        {{-- laravel js --}}
        {{-- <script src="{{mix('assets/js/laravel/app.js')}}"></script> --}}

        @yield('bottom-js')
    </body>

</html>
