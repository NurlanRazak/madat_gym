{{-- regular object attribute --}}
@php
	$value = data_get($entry, $column['name']);

	if (is_array($value)) {
		$value = json_encode($value);
	}
@endphp

@if($value)
	<a href="https://cdn.jwplayer.com/players/{{ $value }}-pu6XmB5Q.html" target="_blank">Видео</a>
@else
    <span>-</span>
@endif
