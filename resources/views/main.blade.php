@extends('layouts.master')
@section('main-content')
            <div class="breadcrumb">
                <h1>Приветствуем, Username!</h1>
                <ul>
                    <li>Сегодня: ПН 5 сен. 2019г.</li>
                </ul>
            </div>
            <div class="separator-breadcrumb border-top"></div>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                      <div class="card-body">

                        <div class="row apr">
                        <div class="col-lg-2 col-12 mb-1 text-center">
                            <span class="month">11 авг. - 17 авг. 2019 г.</span>
                        </div>
                        <div class="col-lg-8 col-12 mb-1">
                            <ul class="days row">
                                <li class="col"><a href="#" class="today">ПН</a></li>
                                <li class="col"><a href="#">ВТ</a></li>
                                <li class="col"><a href="#">СР</a></li>
                                <li class="col"><a href="#">ЧТ</a></li>
                                <li class="col"><a href="#">ПТ</a></li>
                                <li class="col"><a href="#">СБ</a></li>
                                <li class="col"><a href="#">ВС</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-2 col-12">
                            <a class="btn btn-block btn-warning" href="">продукты и оборудование</a>
                        </div>
                            
                        </div>
                      </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card mt-4">
                        <div class="card-body">
                            <!-- right control icon -->
                            <div class="accordion" id="accordionRightIcon">
                                <div class="card ">
                                    <div class="card-header header-elements-inline" data-toggle="collapse" href="#accordion-item-icon-right-1"
                                                aria-expanded="false" style="padding-right: 50px;">
                                        <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                            <a data-toggle="collapse" class="text-default collapsed" href="#accordion-item-icon-right-1"
                                                aria-expanded="false">Тренировки</a>
                                                
                                        </h6>
                                        <form>
                                          <div class="form-row align-items-center">
                                              <div class="custom-control custom-checkbox mr-sm-2">
                                                <input type="checkbox" class="custom-control-input" id="1">
                                                <label class="custom-control-label" for="1">&nbsp;</label>
                                              </div>
                                          </div>
                                        </form>
                                        
                                    </div>



                                    <div id="accordion-item-icon-right-1" class="collapse" data-parent="#accordionRightIcon" style="">
                                        <div class="card-body">
                                            <ul>
                                                <li class="row mb-4">
                                                    <div class="col-sm-3 col-lg-2"><div class="video"><img src="{{asset('assets/images/squat.jpg')}}" width="100%"><button type="button" class="playbtn" data-toggle="modal" data-target="#vid"><i class="i-Video-5 text-36 mr-1"></i></button></div></div>
                                                    <div class="col-sm-7 col-lg-9">
                                                        <h2 ><b><a type="button" class="h2-pointer" data-toggle="modal" data-target="#desc">1. Урпажнение</a></b></h2>
                                                        <p>3 подхода, 15 повторений</p>
                                                    </div>
                                                </li>
                                                <li class="row mb-4">
                                                    <div class="col-sm-3 col-lg-2"><div class="video"><img src="{{asset('assets/images/bg.jpg')}}" width="100%"><button type="button" class="playbtn" data-toggle="modal" data-target="#vid"><i class="i-Video-5 text-36 mr-1"></i></button></div></div>
                                                    <div class="col-sm-7 col-lg-9">
                                                        <h2 ><b><a type="button" class="h2-pointer" data-toggle="modal" data-target="#desc">2. Урпажнение</a></b></h2>
                                                        <p>3 подхода, 15 повторений</p>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header header-elements-inline" data-toggle="collapse" href="#accordion-item-icon-right-2" style="padding-right: 50px;">
                                        <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                            <a data-toggle="collapse" class="text-default collapsed"
                                                href="#accordion-item-icon-right-2">Питание</a>
                                                
                                        </h6>
                                        <form>
                                          <div class="form-row align-items-center">
                                              <div class="custom-control custom-checkbox mr-sm-2">
                                                <input type="checkbox" class="custom-control-input" id="2">
                                                <label class="custom-control-label" for="2">&nbsp;</label>
                                              </div>
                                          </div>
                                        </form>
                                    </div>



                                    <div id="accordion-item-icon-right-2" class="collapse " data-parent="#accordionRightIcon">
                                        <div class="card-body">
                                            <ul>
                                                <li class="row mb-4">
                                                    <div class="col-sm-3 col-lg-2"><div class="video"><img src="{{asset('assets/images/squat.jpg')}}" width="100%"><button type="button" class="playbtn" data-toggle="modal" data-target="#vid"><i class="i-Video-5 text-36 mr-1"></i></button></div></div>
                                                    <div class="col-sm-7 col-lg-9">
                                                        <h2 ><b><a type="button" class="h2-pointer" data-toggle="modal" data-target="#desc">1. Урпажнение</a></b></h2>
                                                        <p>3 подхода, 15 повторений</p>
                                                    </div>
                                                </li>
                                                <li class="row mb-4">
                                                    <div class="col-sm-3 col-lg-2"><div class="video"><img src="{{asset('assets/images/bg.jpg')}}" width="100%"><button type="button" class="playbtn" data-toggle="modal" data-target="#vid"><i class="i-Video-5 text-36 mr-1"></i></button></div></div>
                                                    <div class="col-sm-7 col-lg-9">
                                                        <h2 ><b><a type="button" class="h2-pointer" data-toggle="modal" data-target="#desc">2. Урпажнение</a></b></h2>
                                                        <p>3 подхода, 15 повторений</p>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>


                                <div class="card ">
                                    <div class="card-header header-elements-inline" data-toggle="collapse" href="#accordion-item-icon-right-3" style="padding-right: 50px;">
                                        <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                            <a data-toggle="collapse" class="text-default collapsed"
                                                href="#accordion-item-icon-right-3">Отдых</a>
                                                
                                        </h6>
                                        <form>
                                          <div class="form-row align-items-center">
                                              <div class="custom-control custom-checkbox mr-sm-2">
                                                <input type="checkbox" class="custom-control-input" id="3">
                                                <label class="custom-control-label" for="3">&nbsp;</label>
                                              </div>
                                          </div>
                                        </form>
                                        
                                    </div>



                                    <div id="accordion-item-icon-right-3" class="collapse " data-parent="#accordionRightIcon">
                                        <div class="card-body">
                                            <ul>
                                                <li class="row mb-4">
                                                    <div class="col-sm-3 col-lg-2"><div class="video"><img src="{{asset('assets/images/squat.jpg')}}" width="100%"><button type="button" class="playbtn" data-toggle="modal" data-target="#vid"><i class="i-Video-5 text-36 mr-1"></i></button></div></div>
                                                    <div class="col-sm-7 col-lg-9">
                                                        <h2 ><b><a type="button" class="h2-pointer" data-toggle="modal" data-target="#desc">1. Урпажнение</a></b></h2>
                                                        <p>3 подхода, 15 повторений</p>
                                                    </div>
                                                </li>
                                                <li class="row mb-4">
                                                    <div class="col-sm-3 col-lg-2"><div class="video"><img src="{{asset('assets/images/bg.jpg')}}" width="100%"><button type="button" class="playbtn" data-toggle="modal" data-target="#vid"><i class="i-Video-5 text-36 mr-1"></i></button></div></div>
                                                    <div class="col-sm-7 col-lg-9">
                                                        <h2 ><b><a type="button" class="h2-pointer" data-toggle="modal" data-target="#desc">2. Урпажнение</a></b></h2>
                                                        <p>3 подхода, 15 повторений</p>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /right control icon -->
                        </div>
                    </div>
                </div>



            </div>

            



            <div class="modal fade" id="vid" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-2" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <video width="100%" src="{{asset('assets/images/61.mp4')}}" controls></video>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="desc" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-2" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle-2">Описание упражнения</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Тут описание упражнения
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Всё понятно</button>
                        </div>
                    </div>
                </div>
            </div>
@endsection

@section('page-js')
     <script src="{{asset('assets/js/vendor/echarts.min.js')}}"></script>
     <script src="{{asset('assets/js/es5/echart.options.min.js')}}"></script>
     <script src="{{asset('assets/js/es5/dashboard.v1.script.js')}}"></script>

@endsection
