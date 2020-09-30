@extends('backpack::layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box" id="admin">
                <div>
                    <calendar
                        :current_program="{{ request()->program_id ?? 0 }}"
                        :groups="{{ json_encode($groups) }}"
                        :programs="{{ json_encode($programs) }}"
                        :program="{{ $program_id }}"
                        :foodprogram="{{ $foodprogram_id }}"
                        :relaxprogram="{{ $relaxprogram_id }}"
                        ref="calendar"
                    ></calendar>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after_scripts')
    <script src="{{ asset('/assets/js/admin/app.js') }}"></script>
@endpush
