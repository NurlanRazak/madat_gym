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
    @foreach($equipments as $equipment)
        <li>{{ $equipment->name }}</li>
    @endforeach
</ol>
<br>
<h4>Желаем достижения новых высот!</h4>
<small>Комада MAG.</small>
