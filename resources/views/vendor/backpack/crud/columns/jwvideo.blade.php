{{-- regular object attribute --}}
@php
	$value = data_get($entry, $column['name']);
	$key = null;
	$name = null;
	if ($value) {
		try {
			list($key, $name) = explode(':', $value);
		} catch(\Exception $e) {
			//
		}
	}

	if (is_array($value)) {
		$value = json_encode($value);
	}
@endphp

@if($key)
	<a href="https://cdn.jwplayer.com/players/{{ $key }}-pu6XmB5Q.html" target="_blank">{{ $name }}</a>
@else
    <span>-</span>
@endif
