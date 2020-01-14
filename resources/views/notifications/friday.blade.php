<h4>
    @if($next)
        Новая неделя требует от Вас больших усилий. <br>
    @endif
    Вот, что будет нужно на эту неделю!
</h4><br>
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
    @foreach($equipments as $equipment)
        @foreach($equipment->lists as $list)
            <li>{{ $list->name }}</li>
        @endforeach
    @endforeach
</ol>
<br>
<h4>Желаем достижения новых высот!</h4>
<small>Комада MAG.</small>
