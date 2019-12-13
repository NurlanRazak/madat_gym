@extends('layouts.master')
@section('main-content')
            <div class="breadcrumb">
                <h1>Приветствуем, {{ $user->name }}!</h1>
                <ul>
                    <li>Сегодня: {{ $time }}</li>
                </ul>
            </div>
            <div class="separator-breadcrumb border-top"></div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                      <div class="card-body">

                        <div class="row apr">
                        <div class="col-lg-2 col-12 mb-1 text-center">
                            <span class="month">{{ $week }}г.</span>
                        </div>
                        <div class="col-lg-8 col-12 mb-1">
                            <ul class="days row">
                                @php
                                    $days = array('ПН', 'ВТ', 'СР', 'ЧТ', 'ПТ', 'СБ', 'ВС');
                                @endphp
                                @for ($i = 0; $i < count($days); $i++)
                                     <li class="col"><a href="javascript:void(0);" data-day="{{ $i+1 }}" class="day-btn {{ ($today == $i+1) ? 'today' : '' }}">{{ $days[$i] }}</a></li>
                                @endfor
                            </ul>
                        </div>
                        <div class="col-lg-2 col-12">
                            <a class="btn btn-warning" data-toggle="modal" data-target="#list">продукты и оборудование</a>
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
                            @for($i=1;$i<=7;++$i)
                                <div class="accordion day-box" id="accordionRightIcon-{{ $i }}" style="{{ $i != $today ? 'display: none;' : '' }}">
                                    <div class="card ">
                                        <div class="card-header header-elements-inline" data-toggle="collapse" href="#accordion-item-icon-right-{{ $i }}-1"
                                                    aria-expanded="false">
                                            <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                                <a data-toggle="collapse" class="text-default collapsed" href="#accordion-item-icon-right-{{ $i }}-1"
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



                                        <div id="accordion-item-icon-right-{{ $i }}-1" class="collapse" data-parent="#accordionRightIcon-{{ $i }}" style="">
                                            <div class="card-body">
                                                @foreach($trainings[$i] ?? [] as  $training)
                                                    <h2> {{ $training->name }}</h2>
                                                    @if($training->user)
                                                        <h4> {{ $training->user->name }} </h4>
                                                    @endif
                                                    <p>
                                                        @if ($training->weight)
                                                            {{ $training->weight }} кг,
                                                        @endif
                                                        @if ($training->approaches_number)
                                                            {{ $training->approaches_number }} подхода,
                                                        @endif
                                                        @if ($training->repetitions_number)
                                                            {{ $training->repetitions_number }} повторений
                                                        @endif
                                                    </p>
                                                    <ul>
                                                        @foreach($training->exercises as $index => $exercise)
                                                            <li class="row mb-4">
                                                                <div class="col-sm-3 col-lg-2"><div class="video"><img src="{{ asset('uploads/'.$exercise->image) }}" width="100%"><button type="button" class="playbtn" data-toggle="modal" data-video="{{ asset('uploads/'.$exercise->video) }}" data-target="#vid"><i class="i-Video-5 text-36 mr-1"></i></button></div></div>
                                                                <div class="col-sm-7 col-lg-9">
                                                                    <h2><b><a type="button" class="h2-pointer ex-desc" data-toggle="modal" data-target="#desc" data-title="{{ $exercise->name }}" data-description="{{ $exercise->long_desc }}">{{ $index + 1 }}. {{ $exercise->name }}</a></b></h2>
                                                                    <p>
                                                                        {{ $exercise->short_desc }}
                                                                    </p>
                                                                </div>
                                                                <div class="col-sm-2 col-lg-1"><label for="status"><input type="checkbox" checked name="status"></label><i class="i-Yes text-24"></i></div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header header-elements-inline" data-toggle="collapse" href="#accordion-item-icon-right-{{ $i }}-2">
                                            <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                                <a data-toggle="collapse" class="text-default collapsed"
                                                    href="#accordion-item-icon-right-{{ $i }}-2">Питание</a>
                                            </h6>

                                        </div>



                                        <div id="accordion-item-icon-right-{{ $i }}-2" class="collapse " data-parent="#accordionRightIcon-{{ $i }}">
                                            <div class="card-body">
                                                @foreach($planeats[$i] ?? [] as $planeat)
                                                    <h2>{{ $planeat->name }}</h2>
                                                    <h4>Блюда:</h4>
                                                    @foreach($planeat->meals ?? [] as $mealindex => $meal)
                                                        <h5>{{ $mealindex + 1 }}. {{ $meal->name }}</h5>
                                                        <div>
                                                            {!! $meal->description !!}
                                                            <p>
                                                            @if($meal->calorie)
                                                                <strong>Калорийность: </strong> {{ $meal->calorie }}<br/>
                                                            @endif
                                                            @if($meal->weight)
                                                                <strong>Вес: </strong> {{ $meal->weight }} г.<br/>
                                                            @endif
                                                            @if($meal->price)
                                                                <strong>Цена: </strong> {{ number_format($meal->price, 0,"."," ") }} ₸<br/>
                                                            @endif
                                                            </p>
                                                        </div>
                                                    @endforeach
                                                    <h4>Часы приема:</h4>
                                                    <p>
                                                        @foreach($planeat->eathours ?? [] as $eatindex => $eathour)
                                                            {{ $eatindex + 1 }}. {{ $eathour->hour_start }} - {{ $eathour->hour_finish }}</br>
                                                        @endforeach
                                                    </p>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>


                                    <div class="card ">
                                        <div class="card-header header-elements-inline" data-toggle="collapse" href="#accordion-item-icon-right-{{ $i }}-3">
                                            <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                                <a data-toggle="collapse" class="text-default collapsed"
                                                    href="#accordion-item-icon-right-3">Отдых</a>
                                            </h6>

                                        </div>



                                        <div id="accordion-item-icon-right-{{ $i }}-3" class="collapse " data-parent="#accordionRightIcon-{{ $i }}">
                                            <div class="card-body">
                                                @foreach($relaxtrainings[$i] ?? [] as $index => $relaxtraining)
                                                    <h4><strong>{{ $relaxtraining->time }}</strong> {{ $relaxtraining->name }}</h4>
                                                    <ul>
                                                        @foreach($relaxtraining->exercises as $exerciseindex => $exercise)
                                                            <li class="row mb-4">
                                                                <div class="col-sm-3 col-lg-2"><div class="video"><img src="{{ asset('uploads/'.$exercise->image) }}" width="100%"><button type="button" class="playbtn" data-toggle="modal" data-video="{{ asset('uploads/'.$exercise->video) }}" data-target="#vid"><i class="i-Video-5 text-36 mr-1"></i></button></div></div>
                                                                <div class="col-sm-7 col-lg-9">
                                                                    <h5><b><a type="button" class="h2-pointer ex-desc" data-toggle="modal" data-target="#desc" data-title="{{ $exercise->name }}" data-description="{{ $exercise->long_description }}">{{ $index + 1 }}. {{ $exercise->name }}</a></b></h5>
                                                                    @if($exercise->audio)
                                                                        <audio src="{{ asset('uploads/'.$exercise->audio) }}" controls></audio>
                                                                    @endif
                                                                    <p>{{ $exercise->short_description }}</p>
                                                                </div>
                                                                <div class="col-sm-2 col-lg-1"><label for="status"><input type="checkbox" checked name="status"></label><i class="i-Yes text-24"></i></div>
                                                            </li>
                                                        @endforeach
                                                    </ul>

                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
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
                            <video width="100%" src="{{ asset('assets/images/61.mp4') }}" controls></video>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="list" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Привет друг!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body" id="forprint">
                    <h4>Новая неделя требует от Вас больших усилий. <br> Вот, что будет нужно на эту неделю!</h4><br>
                    <h4>Продукты: </h4>
                    <ol>
                        @foreach($groceries as $grocery)
                            @foreach($grocery->listmeals as $meal)
                                <li>{{ $meal->name }}</li>
                            @endforeach
                        @endforeach
                    </ol>
                    <br>
                    <h4>Оборудование: </h4>
                    <ol>
                        @foreach($all_equipments as $equipment)
                            <li>{{ $equipment->name }}</li>
                        @endforeach
                    </ol>
                    <br>
                    <h4>Желаем достижения новых высот!</h4>
                    <small>Комада MAG.</small>
                  </div>
                  <form class="modal-footer" action="{{ route('friday') }}" method="POST">
                      @csrf
                    <button type="button" class="btn btn-success" onclick="printJS('forprint', 'html')">Печать</button>
                    <button type="submit" class="btn btn-primary">Отправить список на почту</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </form>
                </div>
              </div>
            </div>
@endsection

@section('page-js')
     <script src="{{asset('assets/js/vendor/echarts.min.js')}}"></script>
     <script src="{{asset('assets/js/es5/echart.options.min.js')}}"></script>
     <script src="{{asset('assets/js/es5/dashboard.v1.script.js')}}"></script>
     <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>

     <script>
        $(document).ready(function() {
            $(document).on('click', '.day-btn', function(e) {
                let $target = $(e.target);
                let day = $target.data('day');
                $('.day-btn').removeClass('active-day');
                if (day != {{ $today }}) {
                    $target.addClass('active-day');
                }

                $('.day-box').hide()
                $('#accordionRightIcon-' + day).show()
            });

            $(document).on('click', '.ex-desc', function(e) {
                let desc = $(e.target).data('description')
                let title = $(e.target).data('title')
                $('#desc').find('.modal-title').html(desc);
                $('#desc').find('.modal-body').html(title);
            });

            $(document).on('click', '.playbtn', function(e) {
                let video = $(e.target.closest('div')).find('button').data('video');
                $('#vid').find('video').attr('src', video);
            });
        });
     </script>

@endsection
