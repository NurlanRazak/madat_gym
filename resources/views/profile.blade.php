@extends('layouts.master')
@section('page-css')
<link rel="stylesheet" href="{{asset('assets/styles/vendor/ladda-themeless.min.css')}}">
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>


@section('main-content')
    <div class="breadcrumb">
                <h1>Личный профиль</h1>
            </div>

            <div class="separator-breadcrumb border-top"></div>

            <div class="card user-profile o-hidden mb-4">
                <!-- <div class="header-cover" style="background-image: url({{asset('assets/images/photo-wide-5.jpeg')}}"></div> -->
                <div class="user-info">
                    <form action="{{ route('image-post') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <img class="profile-picture avatar-lg mb-2" src="{{ asset($user->image ? 'uploads/'.$user->image : 'assets/images/photo-wide-5.jpeg')}}" alt="">
                        <input id="file-input" style="display: none;" accept="image/*" type="file" name="image">
                    </form>
                    <p class="m-0 text-24">{{ $user->name }}</p>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="profileTabContent">
                        <div class="tab-pane fade active show" id="about" role="tabpanel" aria-labelledby="about-tab">
                            <h4>ПОДПИСКА ПОЛЬЗОВАТЕЛЯ</h4>
                            <p>Дата активации – {{ $dates[0] }} | Дата завершения – {{ $dates[1] }}
                            </p>
                            <hr>
                            <div class="row mb-5">
                                <div class="col-lg-6 col-12">
                                    <div class="alert alert-warning" role="alert">
                                      ЛИЧНЫЙ ПРОФИЛЬ
                                      <a id="userdataedit" href="" class="float-right"><i class="i-Edit text-16"></i></a>
                                    </div>
                                    <div class="mb-4">
                                        <p class="text-primary mb-1"><i class="i-MaleFemale text-16 mr-1"></i> ИМЯ</p>
                                        <div class="form-group">
                                            <input type="text" class="form-control userdataediti" name="name" id="name" aria-describedby="emailHelp" value="{{ $user->name }}" disabled>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <p class="text-primary mb-1"><i class="i-MaleFemale text-16 mr-1"></i> ФАМИЛИЯ</p>
                                        <div class="form-group">
                                            <input type="text" class="form-control userdataediti" name="last_name" id="last_name" aria-describedby="emailHelp" value="{{ $user->last_name ?? '' }}" disabled>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <p class="text-primary mb-1"><i class="i-MaleFemale text-16 mr-1"></i> ОТЧЕСТВО</p>
                                        <div class="form-group">
                                            <input type="text" class="form-control userdataediti" name="middle_name" id="middle_name" aria-describedby="emailHelp" value="{{ $user->middle_name ?? '' }}" disabled>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <p class="text-primary mb-1"><i class="i-Mail text-16 mr-1"></i> ЭЛЕКТРОННАЯ ПОЧТА</p>
                                        <div class="form-group">
                                            <input type="email" class="form-control userdataediti" name="email" id="email" aria-describedby="emailHelp" value="{{ $user->email }}" disabled>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <p class="text-primary mb-1"><i class="i-Key text-16 mr-1"></i> ПАРОЛЬ</p>
                                        <div class="input-group">
                                          <input type="password" class="form-control" name="password" id="password" aria-describedby="button-addon2" disabled value="{{ $user->password ? 'password' : '' }}">
                                          <div class="input-group-append" >
                                            <button class="btn btn-primary" type="button" id="button-addon2" data-toggle="modal" data-target="#password-modal">Изменить</button>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="form-group">
                                          <input type="submit" id="save" class="form-control userdataediti invisible" value="Сохранить" >
                                        </div>
                                    </div>
                                </div>
                                <!--<div class="col-lg-4 col-12">
                                    <div class="alert alert-warning" role="alert">
                                      ПАРАМЕТРЫ
                                      <a id="userparamsedit" href="" class="float-right"><i class="i-Edit text-16"></i></a>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p>11 авг 2915</p>
                                            <hr>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1"><i class="i-MaleFemale text-16 mr-1"></i> Вес</p>
                                                <div class="form-group">
                                                    <input type="text" class="form-control userparamsediti"  aria-describedby="emailHelp" value="Ислам" disabled>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1"><i class="i-MaleFemale text-16 mr-1"></i> Email</p>
                                                <div class="form-group">
                                                    <input type="text" class="form-control userparamsediti"  aria-describedby="emailHelp" value="Ислам" disabled>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1"><i class="i-MaleFemale text-16 mr-1"></i> Website</p>
                                                <div class="form-group">
                                                    <input type="text" class="form-control userparamsediti"  aria-describedby="emailHelp" value="Ислам" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <p>17 авг 2915</p>
                                            <hr>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1"><i class="i-MaleFemale text-16 mr-1"></i> Gender</p>
                                                <div class="form-group">
                                                    <input type="text" class="form-control userparamsediti"  aria-describedby="emailHelp" value="Ислам" disabled>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1"><i class="i-MaleFemale text-16 mr-1"></i> Email</p>
                                                <div class="form-group">
                                                    <input type="text" class="form-control userparamsediti"  aria-describedby="emailHelp" value="Ислам" disabled>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1"><i class="i-MaleFemale text-16 mr-1"></i> Website</p>
                                                <div class="form-group">
                                                    <input type="text" class="form-control userparamsediti"  aria-describedby="emailHelp" value="Ислам" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <p>24 авг 2915</p>
                                            <hr>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1"><i class="i-MaleFemale text-16 mr-1"></i> Gender</p>
                                                <div class="form-group">
                                                    <input type="text" class="form-control userparamsediti"  aria-describedby="emailHelp" value="Ислам" disabled>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1"><i class="i-MaleFemale text-16 mr-1"></i> Email</p>
                                                <div class="form-group">
                                                    <input type="text" class="form-control userparamsediti"  aria-describedby="emailHelp" value="Ислам" disabled>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-primary mb-1"><i class="i-MaleFemale text-16 mr-1"></i> Website</p>
                                                <div class="form-group">
                                                    <input type="text" class="form-control userparamsediti"  aria-describedby="emailHelp" value="Ислам" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>-->
                                <div class="col-lg-6 col-12">
                                	<div class="alert alert-warning" role="alert">
                                      ЦЕЛЬ И ПЛАН
                                      <a href="" id="userplanedit" class="float-right"><i class="i-Edit text-16"></i></a>
                                    </div>
                                    <form class="mb-4" action="{{ route('program-update') }}" method="POST">
                                        @csrf
                                        <p class="text-primary mb-1"><i class="i-Globe text-16 mr-1"></i> ПЛАН</p>
                                        <select class="form-control userplanediti" name="programtraining_id" disabled id="user-program">
                                            @foreach($programs as $program)
                                                <option value="{{ $program->id }}" {{ $program->id == $user->programtraining_id ? 'selected' : '' }}>{{ $program->name }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                    <div class="alert alert-warning" role="alert">
                                      ШКАЛА ВЫПОЛНЕНЫХ ЗАДАНИЙ
                                      <a href="#" class="float-right"><i class="i-Eye text-16"></i></a>
                                    </div>
                                    <div class="progress mb-3">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $user->statistics ?? 0 }}%" aria-valuenow="{{ $user->statistics ?? 0 }}" aria-valuemin="0" aria-valuemax="100">{{ $user->statistics ?? 0 }}%</div>
                                    </div>
                                    <a href="{{ route('subscription') }}" class="btn btn-block btn-warning">ПРОДЛИТЬ ПОДПИСКУ</a>
                                    {{-- <a href="#" class="btn btn-block btn-danger">ОТМЕНИТЬ ПОДПИСКУ</a> --}}
                                    <br>
                                    <div class="alert alert-warning" role="alert">
                                        Почтовый адрес - {{ (($user->email_verified_at != null) ? 'подтвержден' : 'не был подтвержден' ) }}

                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-warning" role="alert">
                                      ИЗМЕНЕНИЕ ВАШИХ ПАРАМЕТРОВ
                                      <a href="" data-toggle="modal" data-target="#params" class="float-right"><i class="i-Edit text-16"></i></a>
                                    </div>

                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table ">
                                      <thead>
                                        <tr>
                                          <th scope="col">#</th>
                                          <th scope="col">Дата замера</th>
                                          <th scope="col">Вес</th>
                                          <th scope="col">Талия</th>
                                          <th scope="col">Объем ноги</th>
                                          <th scope="col">Объем руки</th>
                                          <th scope="col">Фото</th>
                                          <th scope="col">Действие</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                         @foreach($userparameters as $userparameter)
                                        <tr>
                                          <th scope="row">{{ $loop->iteration }}</th>
                                          <td>{{ date('j F Y', strtotime($userparameter->date_measure)) }}</td>
                                          <td>{{ $userparameter->weight }}</td>
                                          <td>{{ $userparameter->waist }}</td>
                                          <td>{{ $userparameter->leg_volume }}</td>
                                          <td>{{ $userparameter->arm_volume }}</td>
                                          <td><a data-toggle="modal" data-target="#gallery" class="btn btn-primary param-images" style="color: #fff" data-id="{{ $userparameter->id }}" data-images="{{ json_encode($userparameter->images ?? []) }}">Добавить / Просмотр</a></td>
                                          <td>
                                              <form action="{{ route('userparameter', ['id' => $userparameter->id]) }}" method="post">
                                                  @csrf
                                                  <input type="hidden" name="_method" value="DELETE"/>
                                                  <button type="submit" class="btn btn-primary">Удалить</button>
                                              </form>
                                          </td>
                                        </tr>
                                        @endforeach
                                      </tbody>
                                    </table>
                                </div>
                            </div>
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

            <div class="modal fade" id="password-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <form class="modal-content" action="{{ route('password-update') }}" method="POST">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Смена пароля</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div>
                      <div class="form-group">
                          @csrf
                        <input type="password" name="password" class="form-control" id="newpass" placeholder="Новый пароль" required minlength="6">
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-primary">Изменить</button>
                  </div>
              </form>
              </div>
            </div>

            <div class="modal fade" id="params" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Добавление изменений параметров</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form id="user-info">
                      <div class="form-group">
                        <input type="date" class="form-control" id="date_measure" name="date_measure" placeholder="Дата замера" required>
                      </div>
                      <!-- <div class="form-group">
                        <input type="text" class="form-control" id="newpass" placeholder="Рост">
                      </div> -->
                      <div class="form-group">
                        <input type="number" step="any" class="form-control" id="weight" name="weight" placeholder="Вес" required>
                      </div>
                      <div class="form-group">
                        <input type="number" step="any" class="form-control" id="waist" name="waist" placeholder="Талия" required>
                      </div>
                      <div class="form-group">
                        <input type="number" step="any" class="form-control" id="leg_volume" name="leg_volume" placeholder="Объем ноги" required>
                      </div>
                      <div class="form-group">
                        <input type="number" step="any" class="form-control" id="arm_volume" name="arm_volume" placeholder="Объем руки" required>
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="submit" id="submit" class="btn btn-primary btn-submit">Добавить замер</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Modal -->
           			<div class="modal fade" id="gallery" tabindex="-1" role="dialog" aria-labelledby="gallery" aria-hidden="true">
           			  <div class="modal-dialog modal-lg" role="document">
           			    <div class="modal-content">
           			      <div class="modal-header">
           			        <h5 class="modal-title" id="exampleModalLabel">Фото</h5>
           			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           			          <span aria-hidden="true">&times;</span>
           			        </button>
           			      </div>
           			      <div class="modal-body">
           			        <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
           					  <div class="carousel-inner">

           					  </div>
           					  <a class="carousel-control-prev" href="#carouselExampleSlidesOnly" role="button" data-slide="prev">
           					    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
           					    <span class="sr-only">Previous</span>
           					  </a>
           					  <a class="carousel-control-next" href="#carouselExampleSlidesOnly" role="button" data-slide="next">
           					    <span class="carousel-control-next-icon" aria-hidden="true"></span>
           					    <span class="sr-only">Next</span>
           					  </a>
           					</div>
           			      </div>
                             <form class="modal-footer" action="{{ route('user-params-image') }}" method="POST" enctype="multipart/form-data">
                                 @csrf
                                 <input type="hidden" name="userparameter_id" id="params-image-id"/>
                               Добавить фото:&nbsp;<input type="file" name="images[]" id="param-image-input" accept="image/*" multiple/>
                            </form>
           			    </div>
           			  </div>
           			</div>

@endsection
<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
    $(document).ready(function() {
        $('#submit').click(function (event) {
            if (!document.getElementById('user-info').reportValidity()) {
                return;
            }
            var date_measure = $("input[name=date_measure]").val();
            var weight = $("input[name=weight]").val();
            var waist = $("input[name=waist]").val();
            var leg_volume = $("input[name=leg_volume]").val();
            var arm_volume = $("input[name=arm_volume]").val();
            $('#params').modal('toggle');
            $.ajax({
                type: 'POST',
                url: '{{url("userparameter_update")}}',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data:{
                    date_measure:date_measure,
                    weight:weight,
                    waist:waist,
                    leg_volume: leg_volume,
                    arm_volume: arm_volume
                },
                success:function(data) {
                    window.location.reload();
                }
            })
        });

        $('#save').click(function (event) {

            var name = $("input[name=name]").val();
            var last_name = $("input[name=last_name]").val();
            var middle_name = $("input[name=middle_name]").val();
            var email = $("input[name=email]").val();
            var password = $("input[name=password]").val();

            $.ajax({
                type: 'POST',
                url: '{{ url("user_update") }}',
                header: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    name: name,
                    last_name: last_name,
                    middle_name: middle_name,
                    email: email,
                    password: password,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success:function(data) {
                    window.location.reload();
                }
            })

        });

        $('.param-images').on('click', function(e) {
            $('#params-image-id').val($(e.target).data('id'));
            let images = $(e.target).data('images');
            let $wrapper = $('#carouselExampleSlidesOnly');
            let $carusel = $wrapper.find('.carousel-inner');
            let content = '';

            for(let i = 0;i<images.length; ++i) {
                content += '<div class="carousel-item ';
                if (i == 0) {
                    content+=`active`
                }
                content+='\">';
                content+=`<img class="d-block w-100" src="/uploads/${images[i]}" alt="First slide">`;
                content+='</div>';
            }

            $carusel.html(content);
        });

        $('#param-image-input').on('change', function(e) {
            e.target.closest('form').submit();
        });

        $('#file-input').on('change', function(e) {
            e.target.closest('form').submit();
        });

        $('#user-program').on('change', function(e) {
            if (confirm("@lang('admin.change_program')")) {
                e.target.closest('form').submit();
            } else {
                e.target.value="{{ $user->programtraining_id }}";
            }
        });

    });

</script>
@section('page-js')
 <script src="{{asset('assets/js/vendor/spin.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/ladda.js')}}"></script>
<script src="{{asset('assets/js/ladda.script.js')}}"></script>
@endsection
