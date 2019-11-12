@extends('layouts.master')
@section('page-css')


@endsection

@section('main-content')

<div class="breadcrumb">
    <h1>Оплата счета</h1>
</div>
<div class="separator-breadcrumb border-top"></div>


<section class="chekout-page">
    <div class="row">
      <div class="col-lg-4 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title">Корзина</div>

            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                  	<th scope="col">№</th>
                    <th scope="col">Продукт</th>
                    <th scope="col">Цена</th>
                    <th scope="col">Количество</th>
                    <th scope="col">Стоимость</th>
                    <th scope="col">Дейстия</th>
                  </tr>
                </thead>
                <tbody>

                  <tr class="">
                  	<td>1</td>
                    <td scope="row">
                      <div class="ul-product-cart__detail d-inline-block align-middle ">
                        <a href="">
                          <h6 class="heading">Nike Air Jordan</h6>
                        </a>
                      </div>
                    </td>
                    <td>$2,000</td>
                    <td>4</td>
                    <td>$8,000</td>
                    <td>
                      <a href=""><i class="i-Close-Window text-19 text-danger font-weight-700"></i></a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="row ">
              <div class="col-lg-12 mt-2">
                <div class="ul-product-cart__invoice">
                  <table class="table">
                    <tbody>
                      <tr>
                        <th scope="row" class="text-primary text-16">
                          Итого:
                        </th>
                        <td class="font-weight-700 text-16">$5,015</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">
            <div class="card-title">Детали счета</div>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="homeBasic" role="tabpanel"
                aria-labelledby="home-basic-tab">
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="inputtext11" class="ul-form__label">Номер карты:</label>
                    <input type="text" class="form-control" id="inputtext11" placeholder="Имя на карте" />
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputEmail12" class="ul-form__label">Имя владельца:</label>
                    <input type="text" class="form-control" id="inputEmail12" placeholder="VASYA PUPKIN" />
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputtext11" class="ul-form__label">Действует до:</label>
                    <input type="text" class="form-control" id="inputtext11" placeholder="мм/гг" />
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputEmail12" class="ul-form__label">Код CVV:</label>
                    <input type="text" class="form-control" id="inputEmail12" placeholder="CVC" />
                  </div>
                </div>
              </div>
            </div>
                <a href="#">Договор оферты</a>
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-lg-12 ">
                <img src="{{asset('assets/images/cp.jpg')}}" alt="">
                <button type="button" class="btn btn-success m-1 float-right">
                  Оплатить
                </button>
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