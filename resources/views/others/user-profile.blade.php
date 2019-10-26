@extends('layouts.master')
@section('page-css')
<link rel="stylesheet" href="{{asset('assets/styles/vendor/ladda-themeless.min.css')}}">
@endsection

@section('main-content')
    <div class="breadcrumb">
                <h1>Личный профиль</h1>
            </div>

            <div class="separator-breadcrumb border-top"></div>

            <div class="card user-profile o-hidden mb-4">
                <div class="header-cover" style="background-image: url({{asset('assets/images/photo-wide-5.jpeg')}}"></div>
                <div class="user-info">
                    <img class="profile-picture avatar-lg mb-2" src="{{asset('assets/images/faces/1.jpg')}}" alt="">
                    <p class="m-0 text-24">Timothy Carlson</p>
                    <p class="text-muted m-0">Digital Marketer</p>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs profile-nav mb-4" id="profileTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="about-tab" data-toggle="tab" href="#about" role="tab" aria-controls="about" aria-selected="true">ОБЩИЕ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="timeline-tab" data-toggle="tab" href="#timeline" role="tab" aria-controls="timeline" aria-selected="false">ИСТОРИЯ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="friends-tab" data-toggle="tab" href="#friends" role="tab" aria-controls="friends" aria-selected="false">ДРУЗЬЯ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="photos-tab" data-toggle="tab" href="#photos" role="tab" aria-controls="photos" aria-selected="false">ФОТОГРАФИИ</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="profileTabContent">
                        
                        <div class="tab-pane fade active show" id="about" role="tabpanel" aria-labelledby="about-tab">
                            <h4>ВАША ПОДПИСКА НА 1 МЕСЯЦ</h4>
                            <p>НАЧАЛО 11 АВГУСТА 2019 - КОНЕЦ 11 СЕНТЯБРЯ 2019
                            </p>
                            <hr>
                            <div class="row">
                                <div class="col-lg-4 col-12">
                                    <div class="alert alert-warning" role="alert">
                                      Аккаунт
                                      <a href="#"><i class="i-Edit text-16"></i></a>
                                    </div>
                                    <div class="mb-4">
                                        <p class="text-primary mb-1"><i class="i-Mail text-16 mr-1"></i> ЭЛЕКТРОННЫЙ АДРЕС</p>
                                        <span>wyccave@gmail.com</span>
                                    </div>
                                    <div class="mb-4">
                                        <p class="text-primary mb-1"><i class="i-Key text-16 mr-1"></i> ПАРОЛЬ</p>
                                        <span>******</span>
                                    </div>
                                    <div class="mb-4">
                                        <p class="text-primary mb-1"><i class="i-Globe text-16 mr-1"></i> ИМЯ</p>
                                        <span>МАДАТ</span>
                                    </div>
                                    <div class="alert alert-warning" role="alert">
                                      ЦЕЛЬ И ПЛАН
                                      <a href="#"><i class="i-Edit text-16"></i></a>
                                    </div>
                                    <div class="mb-4">
                                        <p class="text-primary mb-1"><i class="i-Globe text-16 mr-1"></i> ПЛАН</p>
                                        <span>ПОХУДЕНИЕ ПОСЛЕ БЕРЕМЕННОСТИ</span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-12">
                                    <div class="alert alert-warning" role="alert">
                                      ПАРАМЕТРЫ
                                      <a href="#"><i class="i-Edit text-16"></i></a>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p>11 авг 2915</p>
                                            <hr>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1"><i class="i-MaleFemale text-16 mr-1"></i> Gender</p>
                                                <span>1 Jan, 1994</span>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1"><i class="i-MaleFemale text-16 mr-1"></i> Email</p>
                                                <span>example@ui-lib.com</span>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1"><i class="i-Cloud-Weather text-16 mr-1"></i> Website</p>
                                                <span>www.ui-lib.com</span>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <p>17 авг 2915</p>
                                            <hr>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1"><i class="i-MaleFemale text-16 mr-1"></i> Gender</p>
                                                <span>1 Jan, 1994</span>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1"><i class="i-MaleFemale text-16 mr-1"></i> Email</p>
                                                <span>example@ui-lib.com</span>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1"><i class="i-Cloud-Weather text-16 mr-1"></i> Website</p>
                                                <span>www.ui-lib.com</span>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <p>24 авг 2915</p>
                                            <hr>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1"><i class="i-MaleFemale text-16 mr-1"></i> Gender</p>
                                                <span>1 Jan, 1994</span>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1"><i class="i-MaleFemale text-16 mr-1"></i> Email</p>
                                                <span>example@ui-lib.com</span>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1"><i class="i-Cloud-Weather text-16 mr-1"></i> Website</p>
                                                <span>www.ui-lib.com</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-12">
                                    <div class="alert alert-warning" role="alert">
                                      ШКАЛА ВЫПОЛНЕНЫХ ЗАДАНИЙ
                                      <a href="#"><i class="i-Eye text-16"></i></a>
                                    </div>
                                    <div class="progress mb-3">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 33%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">33%</div>
                                    </div>
                                    <a href="#" class="btn btn-block btn-warning">ПРОДЛИТЬ ПОДПИСКУ</a>
                                    <a href="#" class="btn btn-block btn-danger">ОТМЕНИТЬ ПОДПИСКУ</a>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="tab-pane fade" id="timeline" role="tabpanel" aria-labelledby="timeline-tab">
                            <ul class="timeline clearfix">
                                <li class="timeline-line"></li>
                                <li class="timeline-item">
                                    <div class="timeline-badge">
                                        <i class="badge-icon bg-primary text-white i-Cloud-Picture"></i>
                                    </div>
                                    <div class="timeline-card card">
                                        <div class="card-body">
                                            <div class="mb-1">
                                                <strong class="mr-1">Timothy Carlson</strong> added a new photo
                                                <p class="text-muted">3 hours ago</p>
                                            </div>
                                            <img class="rounded mb-2" src="{{asset('assets/images/photo-wide-1.jpg')}}" alt="">
                                            <div class="mb-3">
                                                <a href="#" class="mr-1">Like</a>
                                                <a href="#">Comment</a>
                                            </div>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Write comment" aria-label="comment" >
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="button" id="button-comment1">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="timeline-item">
                                    <div class="timeline-badge">
                                        <img class="badge-img" src="{{asset('assets/images/faces/1.jpg')}}" alt="">
                                    </div>
                                    <div class="timeline-card card">
                                        <div class="card-body">
                                            <div class="mb-1">
                                                <strong class="mr-1">Timothy Carlson</strong> updated his sattus
                                                <p class="text-muted">16 hours ago</p>
                                            </div>
                                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi dicta beatae illo illum iusto iste mollitia explicabo quam officia. Quas ullam, quisquam architecto aspernatur enim iure debitis dignissimos suscipit
                                                ipsa.
                                            </p>
                                            <div class="mb-3">
                                                <a href="#" class="mr-1">Like</a>
                                                <a href="#">Comment</a>
                                            </div>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Write comment" aria-label="comment" >
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="button" id="button-comment">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <ul class="timeline clearfix">
                                <li class="timeline-line"></li>
                                <li class="timeline-group text-center">
                                    <button class="btn btn-icon-text btn-primary"><i class="i-Calendar-4"></i> 2018</button>
                                </li>
                            </ul>
                            <ul class="timeline clearfix">
                                <li class="timeline-line"></li>
                                <li class="timeline-item">
                                    <div class="timeline-badge">
                                        <i class="badge-icon bg-danger text-white i-Love-User"></i>
                                    </div>
                                    <div class="timeline-card card">
                                        <div class="card-body">
                                            <div class="mb-1">
                                                <strong class="mr-1">New followers</strong>
                                                <p class="text-muted">2 days ago</p>
                                            </div>
                                            <p><a href="#">Henry krick</a> and 16 others followed you</p>
                                            <div class="mb-3">
                                                <a href="#" class="mr-1">Like</a>
                                                <a href="#">Comment</a>
                                            </div>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Write comment" aria-label="comment" >
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="button" id="button-comment3">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="timeline-item">
                                    <div class="timeline-badge">
                                        <i class="badge-icon bg-primary text-white i-Cloud-Picture"></i>
                                    </div>
                                    <div class="timeline-card card">
                                        <div class="card-body">
                                            <div class="mb-1">
                                                <strong class="mr-1">Timothy Carlson</strong> added a new photo
                                                <p class="text-muted">2 days ago</p>
                                            </div>
                                            <img class="rounded mb-2" src="{{asset('assets/images/photo-wide-2.jpg')}}" alt="">
                                            <div class="mb-3">
                                                <a href="#" class="mr-1">Like</a>
                                                <a href="#">Comment</a>
                                            </div>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Write comment" aria-label="comment" >
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="button" id="button-comment4">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <ul class="timeline clearfix">
                                <li class="timeline-line"></li>
                                <li class="timeline-group text-center">
                                    <button class="btn btn-icon-text btn-warning"><i class="i-Calendar-4"></i> Joined
                                        in 2013</button>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="friends" role="tabpanel" aria-labelledby="friends-tab">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="card card-profile-1 mb-4">
                                        <div class="card-body text-center">
                                            <div class="avatar box-shadow-2 mb-3">
                                                <img src="{{asset('assets/images/faces/16.jpg')}}" alt="">
                                            </div>
                                            <h5 class="m-0">Jassica Hike</h5>
                                            <p class="mt-0">UI/UX Designer</p>
                                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae cumque.
                                            </p>
                                            <button class="btn btn-primary btn-rounded">Contact Jassica</button>
                                            <div class="card-socials-simple mt-4">
                                                <a href="">
                                                    <i class="i-Linkedin-2"></i>
                                                </a>
                                                <a href="">
                                                    <i class="i-Facebook-2"></i>
                                                </a>
                                                <a href="">
                                                    <i class="i-Twitter"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="card card-profile-1 mb-4">
                                        <div class="card-body text-center">
                                            <div class="avatar box-shadow-2 mb-3">
                                                <img src="{{asset('assets/images/faces/2.jpg')}}" alt="">
                                            </div>
                                            <h5 class="m-0">Frank Powell</h5>
                                            <p class="mt-0">UI/UX Designer</p>
                                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae cumque.
                                            </p>
                                            <button class="btn btn-primary btn-rounded">Contact Frank</button>
                                            <div class="card-socials-simple mt-4">
                                                <a href="">
                                                    <i class="i-Linkedin-2"></i>
                                                </a>
                                                <a href="">
                                                    <i class="i-Facebook-2"></i>
                                                </a>
                                                <a href="">
                                                    <i class="i-Twitter"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="card card-profile-1 mb-4">
                                        <div class="card-body text-center">
                                            <div class="avatar box-shadow-2 mb-3">
                                                <img src="{{asset('assets/images/faces/3.jpg')}}" alt="">
                                            </div>
                                            <h5 class="m-0">Arthur Mendoza</h5>
                                            <p class="mt-0">UI/UX Designer</p>
                                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae cumque.
                                            </p>
                                            <button class="btn btn-primary btn-rounded">Contact Arthur</button>
                                            <div class="card-socials-simple mt-4">
                                                <a href="">
                                                    <i class="i-Linkedin-2"></i>
                                                </a>
                                                <a href="">
                                                    <i class="i-Facebook-2"></i>
                                                </a>
                                                <a href="">
                                                    <i class="i-Twitter"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-3">
                                    <div class="card card-profile-1 mb-4">
                                        <div class="card-body text-center">
                                            <div class="avatar box-shadow-2 mb-3">
                                                <img src="{{asset('assets/images/faces/4.jpg')}}" alt="">
                                            </div>
                                            <h5 class="m-0">Jacqueline Day</h5>
                                            <p class="mt-0">UI/UX Designer</p>
                                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae cumque.
                                            </p>
                                            <button class="btn btn-primary btn-rounded">Contact Jacqueline</button>
                                            <div class="card-socials-simple mt-4">
                                                <a href="">
                                                    <i class="i-Linkedin-2"></i>
                                                </a>
                                                <a href="">
                                                    <i class="i-Facebook-2"></i>
                                                </a>
                                                <a href="">
                                                    <i class="i-Twitter"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="photos" role="tabpanel" aria-labelledby="photos-tab">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card text-white o-hidden mb-3">
                                        <img class="card-img" src="{{asset('assets/images/products/headphone-1.jpg')}}" alt="">
                                        <div class="card-img-overlay">
                                            <div class="p-1 text-left card-footer font-weight-light d-flex">
                                                <span class="mr-3 d-flex align-items-center"><i class="i-Speach-Bubble-6 mr-1"></i>
                                                    12 </span>
                                                <span class="d-flex align-items-center"><i class="i-Calendar-4 mr-2"></i>03.12.2018</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card text-white o-hidden mb-3">
                                        <img class="card-img" src="{{asset('assets/images/products/headphone-2.jpg')}}" alt="">
                                        <div class="card-img-overlay">
                                            <div class="p-1 text-left card-footer font-weight-light d-flex">
                                                <span class="mr-3 d-flex align-items-center"><i class="i-Speach-Bubble-6 mr-1"></i>
                                                    12 </span>
                                                <span class="d-flex align-items-center"><i class="i-Calendar-4 mr-2"></i>03.12.2018</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card text-white o-hidden mb-3">
                                        <img class="card-img" src="{{asset('assets/images/products/headphone-3.jpg')}}" alt="">
                                        <div class="card-img-overlay">
                                            <div class="p-1 text-left card-footer font-weight-light d-flex">
                                                <span class="mr-3 d-flex align-items-center"><i class="i-Speach-Bubble-6 mr-1"></i>
                                                    12 </span>
                                                <span class="d-flex align-items-center"><i class="i-Calendar-4 mr-2"></i>03.12.2018</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card text-white o-hidden mb-3">
                                        <img class="card-img" src="{{asset('assets/images/products/iphone-1.jpg')}}" alt="">
                                        <div class="card-img-overlay">
                                            <div class="p-1 text-left card-footer font-weight-light d-flex">
                                                <span class="mr-3 d-flex align-items-center"><i class="i-Speach-Bubble-6 mr-1"></i>
                                                    12 </span>
                                                <span class="d-flex align-items-center"><i class="i-Calendar-4 mr-2"></i>03.12.2018</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card text-white o-hidden mb-3">
                                        <img class="card-img" src="{{asset('assets/images/products/iphone-2.jpg')}}" alt="">
                                        <div class="card-img-overlay">
                                            <div class="p-1 text-left card-footer font-weight-light d-flex">
                                                <span class="mr-3 d-flex align-items-center"><i class="i-Speach-Bubble-6 mr-1"></i>
                                                    12 </span>
                                                <span class="d-flex align-items-center"><i class="i-Calendar-4 mr-2"></i>03.12.2018</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card text-white o-hidden mb-3">
                                        <img class="card-img" src="{{asset('assets/images/products/watch-1.jpg')}}" alt="">
                                        <div class="card-img-overlay">
                                            <div class="p-1 text-left card-footer font-weight-light d-flex">
                                                <span class="mr-3 d-flex align-items-center"><i class="i-Speach-Bubble-6 mr-1"></i>
                                                    12 </span>
                                                <span class="d-flex align-items-center"><i class="i-Calendar-4 mr-2"></i>03.12.2018</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



@endsection

@section('page-js')
 <script src="{{asset('assets/js/vendor/spin.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/ladda.js')}}"></script>
<script src="{{asset('assets/js/ladda.script.js')}}"></script>
@endsection
