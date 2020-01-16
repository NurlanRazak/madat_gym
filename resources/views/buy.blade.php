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
                    @foreach($items as $item)
                      <tr class="">
                      	<td>{{ $loop->iteration }}</td>
                        <td scope="row">
                          <div class="ul-product-cart__detail d-inline-block align-middle ">
                            <a href="">
                              <h6 class="heading">{{ $item['name'] }}</h6>
                            </a>
                          </div>
                        </td>
                        <td>{{ $item['price'] }}</td>
                        <td>{{ $item['cnt'] }}</td>
                        <td>{{ $item['total'] }}</td>
                        <td>
                          <a href=""><i class="i-Close-Window text-19 text-danger font-weight-700"></i></a>
                        </td>
                      </tr>
                    @endforeach
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
                        <td class="font-weight-700 text-16">{{ $total }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <form id="paymentForm" class="col-lg-8" autocomplete="off" action="{{ route('checkout') }}" method="POST">
          @csrf
          <input type="hidden" name="code" id="ch-code" />
          <input type="hidden" name="name" id="ch-name" />
        <div class="card">
          <div class="card-body">
            <div class="card-title">Детали счета</div>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="homeBasic" role="tabpanel"
                aria-labelledby="home-basic-tab">
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="inputtext11" class="ul-form__label">Номер карты:</label>
                    <input type="text" class="form-control" id="inputtext11" placeholder="Номер карты" data-cp="cardNumber" minlength="16" maxlength="19" pattern="[0-9\s]+" title="4242 4242 4242 4242" required />
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputEmail12" class="ul-form__label">Имя владельца:</label>
                    <input type="text" class="form-control" id="inputEmail12" placeholder="VASYA PUPKIN" data-cp="name" required />
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputtext11" class="ul-form__label">Действует до (месяц):</label>
                    <input type="text" class="form-control" id="inputtext11" placeholder="мм" data-cp="expDateMonth" minlength="2" maxlength="2" size="2" pattern="\d*" required />
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputtext11" class="ul-form__label">Действует до (год):</label>
                    <input type="text" class="form-control" id="inputtext12" placeholder="гг" data-cp="expDateYear" minlength="2" maxlength="2" size="2" pattern="\d*" required />
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputEmail12" class="ul-form__label">Код CVV:</label>
                    <input type="text" size="3" pattern="^\d{3}$" title="123" class="form-control" id="inputEmail12" placeholder="CVC" data-cp="cvv"  required />
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
                <button type="button" id="paymentBtn" class="btn btn-success m-1 float-right">
                  Оплатить
                </button>
              </div>
            </div>
          </div>
        </div>
    </form>
    </div>
  </section>

@endsection

@section('head-js')
    <script src="https://widget.cloudpayments.ru/bundles/checkout"></script>
@endsection

@section('page-js')
<script>

let checkout;

let createCryptogram = function () {
    $('#ch-name').val($('#inputEmail12').val())
    var result = checkout.createCryptogramPacket();

    if (result.success) {
        $('#ch-code').val(result.packet)
        $('#paymentForm').submit()
    }
    else {
        // найдены ошибки в введённых данных, объект `result.messages` формата:
        // { name: "В имени держателя карты слишком много символов", cardNumber: "Неправильный номер карты" }
        // где `name`, `cardNumber` соответствуют значениям атрибутов `<input ... data-cp="cardNumber">`
       for (var msgName in result.messages) {
           alert(result.messages[msgName]);
       }
    }
};

$('#paymentBtn').click(function(e) {
    e.preventDefault();
    if (document.getElementById('paymentForm').reportValidity()) {
        checkout = new cp.Checkout(
            // public id из личного кабинета
            "{{ config('services.payment.public_id') }}",
            // тег, содержащий поля данных карты
            document.getElementById("paymentForm")
        );
        createCryptogram()
    }
})

</script>

@endsection
