@extends('layouts.master')
@php
    $eats_data = [];
    foreach($planeats as $day => $planeat_arr) {
        $eats = [];
        foreach($planeat_arr as $planeat) {
            foreach($planeat->meals ?? [] as $meal) {
                foreach($planeat->eathours ?? [] as $eathour) {
                    if (!isset($eats[$eathour->hour_start])) {
                        $eats[$eathour->hour_start] = [];
                    }
                    if (!isset($eats[$eathour->hour_start][$eathour->hour_finish])) {
                        $eats[$eathour->hour_start][$eathour->hour_finish] = ['title' => $eathour->name, 'meals' => []];
                    }
                    $eats[$eathour->hour_start][$eathour->hour_finish]['meals'][] = $meal;
                    if (!isset($eats[$eathour->hour_start][$eathour->hour_finish]['image'])) {
                        $eats[$eathour->hour_start][$eathour->hour_finish]['image'] = $planeat->image ?? '';
                    }
                    if (!isset($eats[$eathour->hour_start][$eathour->hour_finish]['video'])) {
                        $eats[$eathour->hour_start][$eathour->hour_finish]['video'] = $planeat->video_key ?? '';
                    }
                }
            }
        }
        foreach($eats as $key => $eat) {
            ksort($eats[$key]);
        }
        ksort($eats);
        $eats_data[$day] = $eats;
    }
    $eats = $eats_data;


@endphp
@section('page-css')

  <link rel="stylesheet" href="{{asset('assets/styles/vendor/calendar/fullcalendar.min.css')}}">
@endsection
@section('main-content')
            <div class="breadcrumb">
                <h1>Приветствуем, {{ $user->name }}!</h1>
                <ul id="nav-tab" role="tablist">
                    <li>Сегодня: {{ $time }}</li>
                    <li>Текущая программа: <b>{{ $user->programtraining->name }}</b></li>
                </ul>
                <button class="btn btn-primary" id="timerTrigger">Таймер</button>
                <div id="timerWrap">
                    <span id="status">Установите время</span>
                	<div id="timer"><span id="hour">00</span>:<span id="min">00</span>:<span id="sec">00</span></div>
	                <!--<input type="time" value="0" id="time" placeholder="Введите время" min="00:00" max="24:00">-->
                    <input type="time" value="00:00:00" max="23:59:59" min="00:00:00" step="1" id="time" placeholder="Введите время">
	                <button id="timeBtn" onclick="$.fn.setTime()">Старт</button>
	                <button id="stop" onclick="$.fn.stopTimer()">Стоп</button>
                    <button id="timerTriggerr">Скрыть</button>

                </div>
            </div>
            <div class="separator-breadcrumb border-top"></div>
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Сегодня</a>
                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Календарь</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
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
                                     <li class="col"><a href="javascript:void(0);" data-day="{{ $i+1 }}" class="day-btn {{ ($today == $i+1) ? 'today' : '' }} {{ ($today > $i + 1 + $passed || $i + 1 - $today + $passed >= $user->programtraining->duration) ? 'day-disabled' : '' }}">{{ $days[$i] }}</a></li>
                                @endfor
                            </ul>
                        </div>
                        <div class="col-lg-2 col-12">
                            <a class="btn btn-block btn-warning" data-toggle="modal" data-target="#list">продукты и оборудование</a>
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
                                @if($today > $i + $passed || $i - $today + $passed >= $user->programtraining->duration)
                                    @continue
                                @endif
                                <div class="accordion day-box" id="accordionRightIcon-{{ $i }}" style="{{ $i != $today ? 'display: none;' : '' }}">
                                    <div class="card ">
                                        <div class="card-header header-elements-inline" data-toggle="collapse" href="#accordion-item-icon-right-{{ $i }}-1"
                                                    aria-expanded="false" style="padding-right: 50px;">
                                            <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                                <a data-toggle="collapse" class="text-default collapsed" href="#accordion-item-icon-right-{{ $i }}-1"
                                                    aria-expanded="false">Тренировки</a>
                                            </h6>
                                            <form>
                                              <div class="form-row align-items-center">
                                                  <div class="custom-control custom-checkbox mr-sm-2">
                                                    <input type="checkbox" class="custom-control-input" {{ $user->checkExersice($i, 1) ? 'checked' : '' }} id="{{ $i }}-1" {{ $today != $i ? 'disabled' : '' }}>
                                                    <label class="custom-control-label" for="{{ $i }}-1">&nbsp;</label>
                                                  </div>
                                              </div>
                                            </form>
                                        </div>



                                        <div id="accordion-item-icon-right-{{ $i }}-1" class="collapse" data-parent="#accordionRightIcon-{{ $i }}" style="">
                                            <div class="card-body">
                                                @foreach($trainings[$i] ?? [] as  $training)
                                                    <h2> {{ $training->name }}</h2>
                                                    <h4>{{ $training->hour_start }} - {{ $training->hour_finish }}</h4>
                                                    @if($training->user)
                                                        <h4> {{ $training->user->name }} </h4>
                                                    @endif
                                                    <ul>
                                                        @foreach($training->exercises as $index => $exercise)
                                                            <li class="row mb-4">
                                                                <div class="col-sm-3 col-lg-2">
                                                                    <div class="video" data-model="App\Models\Exercise" data-entity="{{ $exercise->id }}">
                                                                        @if($exercise->video_key)
                                                                            <script src="https://cdn.jwplayer.com/players/{{ $exercise->video_key }}-{{ config('jwplayer.player_id') }}.js"></script>
                                                                        @else
                                                                            <img src="{{ asset('assets/images/no-image.png') }}" width="100%">
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-7 col-lg-9">
                                                                    <h5 >
                                                                        <b><a type="button" class="ex-desc h2-pointer" data-toggle="modal" data-target="#desc" data-title="{{ $exercise->name }}" data-description="{{ $exercise->long_desc }}">{{ $index + 1 }}. {{ $exercise->name }}</a></b>
                                                                    </h5>
                                                                    <p>{{ $exercise->short_desc }}</p>
                                                                    <p>
                                                                        Количество подходов: <b>{{ $training->approaches_number ?? '-' }}</b>
                                                                    </p>
                                                                    <p>
                                                                        Количество повторений: <b>{{ $training->repetitions_number ?? '-' }}</b>
                                                                    </p>
                                                                    <p>
                                                                        Вес: <b>{{ $training->weight ?? '-' }}</b>
                                                                    </p>
                                                                    <p>
                                                                        Время выполнения: <b>{{ $training->lead_time ?? '-' }}</b>
                                                                    </p>
                                                                    <p>
                                                                        Время отдыха: <b>{{ $training->hour_finish ?? '-' }}</b>
                                                                    </p>

                                                                    <button class="btn btn-primary ex-desc" data-toggle="modal" data-target="#desc" data-title="{{ $exercise->name }}" data-description="{{ $exercise->long_desc }}">Подробнее</button>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endforeach
                                                    <p>* Время указанное тут рекомендуемое. Вы можете настроить временной диапазон под свой график</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header header-elements-inline" data-toggle="collapse" href="#accordion-item-icon-right-{{ $i }}-2" style="padding-right: 50px;">
                                            <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                                <a data-toggle="collapse" class="text-default collapsed"
                                                    href="#accordion-item-icon-right-{{ $i }}-2">Питание</a>
                                            </h6>

                                            <form>
                                              <div class="form-row align-items-center">
                                                  <div class="custom-control custom-checkbox mr-sm-2">
                                                    <input type="checkbox" class="custom-control-input" {{ $user->checkExersice($i, 2) ? 'checked' : '' }} id="{{ $i }}-2" {{ $today != $i ? 'disabled' : '' }}>
                                                    <label class="custom-control-label" for="{{ $i }}-2">&nbsp;</label>
                                                  </div>
                                              </div>
                                            </form>
                                        </div>



                                        <div id="accordion-item-icon-right-{{ $i }}-2" class="collapse " data-parent="#accordionRightIcon-{{ $i }}">
                                            <div class="card-body">
                                                <ul>
                                                    <li class="row mb-4">
                                                        @php
                                                            $eat_index = 1;
                                                        @endphp
                                                        @if(count($eats[$i] ?? []) > 0)
                                                        @foreach($eats[$i] ?? [] as $start => $eat)
                                                        @foreach($eat as $end => $data)
                                                            <div class="col-sm-3 col-lg-2">
                                                                <div class="video">
                                                                    @if($data['video'])
                                                                        <script src="https://cdn.jwplayer.com/players/{{ $data['video'] }}-{{ config('jwplayer.player_id') }}.js"></script>
                                                                    @elseif ($data['image'])
                                                                        <img src="{{ url('uploads/'.$data['image']) }}" width="100%">
                                                                    @else
                                                                        <img src="{{ asset('assets/images/no-image.png') }}" width="100%">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-7 col-lg-9">
                                                                <h2>{{ $eat_index++ }}. {{ $data['title'] ?? '' }}</h2>
                                                                    <p>Время приема пищи: <br><b>с {{ $start }} до {{ $end }}</b></p>
                                                                    <p>Блюда:</p>
                                                                    <ul>
                                                                        @foreach($data['meals'] ?? [] as $meal)
                                                                            <li>
                                                                                {{ $meal->name }}
                                                                                {!! $meal->description !!}
                                                                                <p>
                                                                                    @if($meal->calorie)
                                                                                        Калорийность: {{ $meal->calorie }}<br/>
                                                                                    @endif
                                                                                    @if($meal->weight)
                                                                                        Вес: {{ $meal->weight }} г.<br/>
                                                                                    @endif
                                                                                    @if($meal->price)
                                                                                        Цена: {{ number_format($meal->price, 0,"."," ") }} ₸<br/>
                                                                                    @endif
                                                                                </p>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                            </div>
                                                            @endforeach
                                                            @endforeach
                                                        @endif
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="card ">
                                        <div class="card-header header-elements-inline" data-toggle="collapse" href="#accordion-item-icon-right-{{ $i }}-3" style="padding-right: 50px;">
                                            <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                                <a data-toggle="collapse" class="text-default collapsed"
                                                    href="#accordion-item-icon-right-3">Отдых</a>
                                            </h6>

                                            <form>
                                              <div class="form-row align-items-center">
                                                  <div class="custom-control custom-checkbox mr-sm-2">
                                                    <input type="checkbox" class="custom-control-input" {{ $user->checkExersice($i, 3) ? 'checked' : '' }} id="{{ $i }}-3" {{ $today != $i ? 'disabled' : '' }}>
                                                    <label class="custom-control-label" for="{{ $i }}-3">&nbsp;</label>
                                                  </div>
                                              </div>
                                            </form>

                                        </div>



                                        <div id="accordion-item-icon-right-{{ $i }}-3" class="collapse " data-parent="#accordionRightIcon-{{ $i }}">
                                            <div class="card-body">
                                                @foreach($relaxtrainings[$i] ?? [] as $index => $relaxtraining)
                                                    <h2>{{ $relaxtraining->name }}</h2>
                                                    <h4>{{ $relaxtraining->hour_start }}</h4>
                                                    <ul>
                                                        @foreach($relaxtraining->exercises as $exerciseindex => $exercise)
                                                            <li class="row mb-4">
                                                                <div class="col-sm-3 col-lg-2">
                                                                    <div class="video" data-model="App\Models\Relaxexercise" data-entity="{{ $exercise->id }}">
                                                                        @if($exercise->video_key)
                                                                            <script src="https://cdn.jwplayer.com/players/{{ $exercise->video_key }}-{{ config('jwplayer.player_id') }}.js"></script>
                                                                        @else
                                                                            <img src="{{ asset('assets/images/no-image.png') }}" width="100%">
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-7 col-lg-9">
                                                                    <h5><b><a type="button" class="h2-pointer ex-desc" data-toggle="modal" data-target="#desc" data-title="{{ $exercise->name }}" data-description="{{ $exercise->long_description }}">{{ $index + 1 }}. {{ $exercise->name }}</a></b></h5>
                                                                    @if($exercise->audio)
                                                                        <audio src="{{ asset('uploads/'.$exercise->audio) }}" controls data-model="\App\Models\Relaxexercise" data-entity="{{ $exercise->id }}" style="width: 100%;"></audio>
                                                                    @endif

                                                                    <p>{{ $exercise->short_description }}</p>
                                                                    <p>Длительность выполнения: <b>{{ $relaxtraining->hour_finish }}</b></p><br>

                                                                </div>
                                                                <button class="btn btn-primary" data-toggle="modal" data-target="#desc" data-title="{{ $exercise->name }}" data-description="{{ $exercise->long_description }}">Подробнее</button>
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
                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4 o-hidden">
                        <div class="card-body">
                            <div id="calendar" data-events="{{ json_encode($events) }}"></div>
                        </div>
                    </div>
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
                            <video width="100%" src="https://cdn.jwplayer.com/v2/media/k8SJZLPw" controls></video>
                            <!-- <video width="100%" src="{{ asset('assets/images/61.mp4') }}" controls></video> -->
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
                    <h4>Вот, что будет нужно на эту неделю!</h4><br>
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
                        @foreach($equipment->lists as $list)
                            <li>{{ $list->name }}</li>
                            @endforeach
                        @endforeach
                    </ol>
                    <br>
                    <h4>Желаем достижения новых высот!</h4>
                    <small>Комада MAG.</small>
                  </div>
                  <form class="modal-footer" action="{{ route('friday') }}" method="POST">
                      @csrf
                    <button type="submit" class="btn btn-primary">Отправить список на почту</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </form>
                </div>
              </div>
            </div>
            <div class="modal fade" id="desc" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-2" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle-2"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal2 -->
            @if($nextGroceries->count() > 0 || $nextEquipments->count() > 0)
            <div class="modal fade" id="list2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Привет друг!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body" id="forprint2">
                    <h4>Новая неделя требует от Вас больших усилий. <br> Вот, что будет нужно на эту неделю!</h4><br>
                    <h4>Продукты: </h4>
                    <ol>
                        @foreach($nextGroceries as $grocery)
                            @foreach($grocery->listmeals as $meal)
                                <li>{{ $meal->name }}</li>
                            @endforeach
                        @endforeach
                    </ol>
                    <br>
                    <h4>Оборудование: </h4>
                    <ol>
                        @foreach($nextEquipments as $equipment)
                            @foreach($equipment->lists as $list)
                                <li>{{ $list->name }}</li>
                            @endforeach
                        @endforeach
                    </ol>
                    <br>
                    <h4>Желаем достижения новых высот!</h4>
                    <small>Комада MAG.</small>
                  </div>
                  <form class="modal-footer" action="{{ route('friday', ['next' => 1]) }}" method="POST">
                      @csrf
                    <button type="submit" class="btn btn-primary">Отправить список на почту</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </form>
                </div>
              </div>
            </div>
            @endif
@endsection

@section('page-js')
     <script src="{{asset('assets/js/vendor/echarts.min.js')}}"></script>
     <script src="{{asset('assets/js/es5/echart.options.min.js')}}"></script>
     <script src="{{asset('assets/js/es5/dashboard.v1.script.js')}}"></script>
     <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
     <script src="{{asset('assets/js/vendor/calendar/jquery-ui.min.js')}}"></script>
     <script src="{{asset('assets/js/vendor/calendar/moment.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/calendar/fullcalendar.min.js')}}"></script>
     <script src="{{asset('assets/js/vendor/calendar/lang/ru.js')}}"></script>
    <script src="{{asset('assets/js/easytimer.min.js')}}"></script>
     <script>
        $(document).ready(function() {
        $("#timerWrap").hide();
        $("#timerTrigger").on("click", function(){
        	$("#timerWrap").toggle();
        });
        $("#timerTriggerr").on("click", function(){
            $("#timerWrap").hide();
        });
            var newDate = new Date,
                date = newDate.getDate(),
                month = newDate.getMonth(),
                year = newDate.getFullYear();
            $('#calendar').fullCalendar({
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'agendaDay,agendaWeek'
                    },
                    themeSystem: "bootstrap4",
                    defaultView: 'agendaWeek',
                    editable: false,
                    eventLimit: true,
                    events: @json($events),

                    eventRender: function(event, element) {
                        if (event.eventData.length != 0)
                        {
                        	var render = event.title + "<div><ul class='sub_event'>";
                        	for(i=0; i < event.eventData.length; i++){
                        		render = render + "<li>" + event.eventData[i] + "</li>";
                        	}
                        	render = render + "</ul></div>";
                        element.html(render);
                        }
                    }
            });



            $(document).on('click', '.day-btn', function(e) {
                let $target = $(e.target);
                let day = $target.data('day');
                if ({{ $passed }} + day >= {{ $today }} && day - {{ $today + $passed }} < {{ $user->programtraining->duration }}) {
                    $('.day-btn').removeClass('active-day');
                    if (day != {{ $today }}) {
                        $target.addClass('active-day');
                    }

                    $('.day-box').hide();
                    $('#accordionRightIcon-' + day).show();
                }
            });

            $(document).on('click', '.ex-desc', function(e) {
                let desc = $(e.target).data('description')
                let title = $(e.target).data('title')
                $('#desc').find('.modal-title').html(title);
                $('#desc').find('.modal-body').html(desc);
            });

            $(document).on('click', '.playbtn', function(e) {
                let btn = $(e.target.closest('div')).find('button');
                $('#vid').find('video').attr('src', btn.data('video'));
                $('#vid').find('video').attr('data-model', btn.data('model'));
                $('#vid').find('video').attr('data-entity', btn.data('entity'));
            });

            $('.custom-control-input').on('change', function(e) {
                let weekDay = e.target.id.split('-')[0];
                let key = e.target.id.split('-')[1];
                console.log(weekDay);
                $.post('{{ route("exersice-done") }}', {
                    '_token': '{{ csrf_token() }}',
                    'key': key,
                    'day': weekDay
                });
            });

            @if($nextGroceries->count() || $nextEquipments->count())
                $('#list2').modal();
            @endif

            $('.video').on('click', function(e) {
                let video = $(e.target).closest('.video');
                let model = video.data('model');
                console.log(e.target)
                let entity = video.data('entity');
                $.post('{{ route("save-view") }}', {
                    '_token': '{{ csrf_token() }}',
                    'model': model,
                    'model_id': entity,
                    'type': 'video',
                    'url': video.attr('src'),
                });
            });

            $('audio').on('play', function(e) {
                let audio = $(e.target);
                let model = audio.data('model');
                let entity = audio.data('entity');
                $.post('{{ route("save-view") }}', {
                    '_token': '{{ csrf_token() }}',
                    'model': model,
                    'model_id': entity,
                    'type': 'audio',
                    'url': audio.attr('src'),
                });
            });

        });

     </script>

@endsection
