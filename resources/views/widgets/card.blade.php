@extends('layouts.master')
@section('before-css')


@endsection

@section('page-css')

@endsection

@section('main-content')
        <div class="breadcrumb">
                    <h1> Card</h1>
                    <ul>
                        <li><a href="">Widgets</a></li>
                        <li> Card</li>
                    </ul>
                </div>

                <div class="separator-breadcrumb border-top"></div>

                <!-- content goes here -->

                <section class="widget-card">
                    <div class="row">
                        
                        <div class="col-md-6 mt-3">
                            <div class="card bg-dark text-white o-hidden mb-4">
                                <img class="card-img" src="{{asset('assets/images/photo-long-2.jpg')}}" alt="Card image">
                                <div class="card-img-overlay">

                                    <div class="text-center pt-4">
                                        <h5 class="card-title mb-2 text-white">План</h5>
                                        <div class="separator border-top mb-2"></div>
                                        <h3 class="text-white">ФИТНЕС ПОХУДЕНИЕ ДОМА</h3>

                                    </div>
                                    <div class="ul-widget-card__cloud card-icon-bg">
                                        <div class="ul-widget-card__body">
                                            <div class="ul-widget-card__weather-info">
                                                <span>Фитнес уровень</span>
                                                <span>НАЧИНАЮЩИЙ</span>
                                            </div>
                                            <div class="ul-widget-card__weather-info">
                                                <span>Тренировки в неделю</span>
                                                <span>ОТ 3 ДО 5</span>
                                            </div>
                                            <div class="ul-widget-card__weather-info">
                                                <span>Продолжительность</span>
                                                <span>ОТ 15 ДО 60 МИНУТ</span>
                                            </div>
                                            <div class="ul-widget-card__weather-info">
                                                <span>Необходимое оборудование</span>
                                                <span>НЕТ</span>
                                            </div>
                                            <div class="ul-widget-card__weather-info">
                                                <span>Локация</span>
                                                <span>ДОМА</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-1 text-left card-footer font-weight-light d-flex">
                                        <span class="d-flex align-items-center"><button class="btn btn-success">Выбрать</button></span>
                                    </div>

                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mt-3">
                            <div class="card bg-dark text-white o-hidden mb-4">
                                <img class="card-img" src="{{asset('assets/images/photo-long-2.jpg')}}" alt="Card image">
                                <div class="card-img-overlay">

                                    <div class="text-center pt-4">
                                        <h5 class="card-title mb-2 text-white">План</h5>
                                        <div class="separator border-top mb-2"></div>
                                        <h3 class="text-white">ПОХУДЕНИЕ ПОСЛЕ БЕРЕМЕННОСТИ</h3>

                                    </div>
                                    <div class="ul-widget-card__cloud card-icon-bg">
                                        <div class="ul-widget-card__body">
                                            <div class="ul-widget-card__weather-info">
                                                <span>Фитнес уровень</span>
                                                <span>НАЧИНАЮЩИЙ</span>
                                            </div>
                                            <div class="ul-widget-card__weather-info">
                                                <span>Тренировки в неделю</span>
                                                <span>ОТ 3 ДО 5</span>
                                            </div>
                                            <div class="ul-widget-card__weather-info">
                                                <span>Продолжительность</span>
                                                <span>ОТ 15 ДО 60 МИНУТ</span>
                                            </div>
                                            <div class="ul-widget-card__weather-info">
                                                <span>Необходимое оборудование</span>
                                                <span>НЕТ</span>
                                            </div>
                                            <div class="ul-widget-card__weather-info">
                                                <span>Локация</span>
                                                <span>ДОМА</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-1 text-left card-footer font-weight-light d-flex">
                                        <span class="d-flex align-items-center"><button class="btn btn-success">Выбрать</button></span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </section>

@endsection

@section('page-js')





@endsection

@section('bottom-js')




@endsection
