@extends('layouts.master')
@section('page-css')

@endsection

@section('main-content')
    <div class="breadcrumb">
                    <h1>Выбор программы</h1>
                </div>

                <div class="separator-breadcrumb border-top"></div>

                <!-- content goes here -->

                <section class="ul-pricing-table">
                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="owl-carousel">
                                                @foreach($programs as $program)
                                                    <div class="col-md-12">
                                                        <div class="ul-pricing__table-1">
                                                            <div class="ul-pricing__title">
                                                                <h2 class="heading text-primary"> {{ $program->name }}</h2>
                                                            </div>
                                                            <div class="ul-pricing__text text-mute">{{ $program->duration }} дней</div>
                                                            <div class="ul-pricing__main-number"> <h4 class="heading display-3 text-primary t-font-boldest" style="font-size: 3.5rem;">{{  number_format($program->price, 0,"."," ") }} ₸ </h4></div>
                                                            <div class="ul-pricing__list">
                                                               <p>{{ $program->description }} </p>
                                                            </div>
                                                            <form action="{{ route('post-program') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="programtraining_id" value="{{ $program->id }}"/>
                                                                <button type="button" onclick="changeProgram(this);" class="btn btn-lg btn-primary btn-rounded m-1">Выбрать и продолжить</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>

<script>
    function changeProgram(e) {
        if (confirm("@lang('admin.change_program')")) {
            e.closest('form').submit();
        }
    }
</script>

@endsection

@section('page-js')

@endsection
