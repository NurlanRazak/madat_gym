@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        {{ trans('backpack::base.dashboard') }}<small>{{ trans('backpack::base.first_page_you_see') }}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ trans('backpack::base.dashboard') }}</li>
      </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box" id="admin">
                <div>
                    <div id="createModal"></div>
                    <calendar
                        :current_program="{{ request()->program_id ?? 0 }}"
                        :groups="{{ json_encode($groups) }}"
                        :programs="{{ json_encode($programs) }}"
                    ></calendar>
                </div>

                <div class="box-body">
                    <div>
                        <div class="row">
                            <div class="col-sm-6">
                                <h3>
                                    Абонементы
                                </h3>
                                <subscription :data="{{ json_encode($aboniment_statistics_data) }}" :labels="{{ json_encode($aboniment_statistics_labels) }}" style="width: 100%;"></subscription>
                            </div>
                            <div class="col-sm-6">
                                <h3>
                                    Программы
                                </h3>
                                <program :data="{{ json_encode($program_statistics_data) }}" :labels="{{ json_encode($program_statistics_labels) }}" style="width: 100%;"></program>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after_scripts')
    <script>
        function setFormData(data) {
            console.log(data)
        }
    </script>
    <script src="{{ asset('/assets/js/admin/app.js') }}"></script>
@endpush
