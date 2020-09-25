@php
    $itemValue = (isset($entry) && $entry) ? $entry->video_key : null;
@endphp
<!-- select2 from array -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    <input type="hidden" id="jwvideo-field" name="{{ $field['name'] }}" value="{{ $itemValue }}" />
    <div class="videos-wrapper container">
        <div class="row">
            @foreach($field['options'] as $key => $value)
                @php
                    $class = '';
                @endphp
                @if($itemValue == $key)
                    @php
                        $class = 'active';
                    @endphp
                @endif
                <div class="col-sm-3 jwvideo-option {{ $class }}" data-key="{{ $key }}:{{ $value }}">
                    <div class="jwvideo-video">
                        <script src="https://cdn.jwplayer.com/players/{{ $key }}-pu6XmB5Q.js\"></script>
                    </div>
                    <div class="jwvideo-val">{{ $value }}</div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

@if ($crud->checkIfFieldIsFirstOfItsType($field))

    @push('crud_fields_styles')
    <style>
        .videos-wrapper {

        }
        .jwvideo-option {
            text-align: center;
            cursor: pointer;
        }
        .jwvideo-option.active .jwvideo-video {
            border: 5px solid green;
        }
    </style>
    @endpush

    @push('crud_fields_scripts')
    <script>
        $(document).on('click', '.jwvideo-val', function(e) {
            var target = e.target.closest('div.jwvideo-option');
            var value = $(target).data('key');
            $('.jwvideo-option').removeClass('active');
            target.classList.add('active');
            $('#jwvideo-field').val(value);
        });
    </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
