@extends('layouts.master')
@section('page-css')

@endsection

@section('main-content')
    <div class="breadcrumb">
        <h1>Выбор абонемента</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>

                <!-- content goes here -->

    <section class="ul-pricing-table">
        <div class="row">
            <div class="col-lg-12 col-xl-12">
                <div class="card mb-4">
                    <div class="card-body">

                        <div class="row">

                            <div class="owl-carousel">
                                @foreach($subscriptions as $subscription)
                                    <div class="col-md-12">
                                        <div class="ul-pricing__table-1">
                                            <div class="ul-pricing__image card-icon-bg-primary">
                                                <i class="i-Bicycle1"></i>
                                            </div>
                                            <div class="ul-pricing__title">
                                                <h2 class="heading text-primary">{{ $subscription->name }}</h2>
                                            </div>
                                            <div class="ul-pricing__text text-mute">На {{ $subscription->days }} дней</div>
                                            <div class="ul-pricing__main-number"> <h4 class="heading display-3 text-primary t-font-boldest" style="font-size: 3.5rem;">{{  number_format($subscription->price, 0,"."," ") }} ₸</h4></div>
                                            <div class="ul-pricing__list">

                                               <p>  </p>
                                            </div>
                                            <button type="button" class="btn btn-lg btn-primary btn-rounded m-1">Выбрать и продолжить</button>
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


@endsection

@section('page-js')

@endsection
