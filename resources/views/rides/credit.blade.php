@extends('home')

@section('style')
  <link rel="stylesheet" href="{{ asset('/vendor/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}" />
  <style type="text/css">
    .statement {
      display: inline-block;
      font-weight: 600;
      padding: 0 10px;
    }
    .statement-line {
      margin-top: 20px;
      margin-bottom: 20px;
    }
    .rideshare-btn {
      margin: 0 20px;
    }
    #form-wrapper {
      border-bottom: 1px solid #ffd34e;
    }
    .result-counter {
      text-align: right;
      font-weight: 600;
    }
    .result-container {
      padding: 20px;
    }
    .result-image {
      width: 100%;
    }
    .result-upper,
    .result-lower {
      overflow: hidden;
    }
    .result-upper {
      height: 150px;
    }
    .result-lower {
      height: 70px;
      padding: 20px 0;
    }
    .result-driver-name,
    .result-driver-details {
      text-transform: uppercase;
      font-weight: bold
    }
    .result-driver-name {
      color: #db9e36;
      margin-top: 40px;
    }
    .result-item {
      padding: 10px;
      background: #ffd34e;
      margin: 20px 0;
    }
    .result-item:hover {
      -webkit-box-shadow: 0px 0px 5px 5px rgb(202, 191, 159);
      -moz-box-shadow: 0px 0px 5px 5px rgb(202, 191, 159);
      box-shadow: 0px 0px 5px 5px rgb(202, 191, 159);
    }
    .result-ride-price {
      margin-top: 40px;
    }
    .result-ride-price sup {
      font-size: 50%;
      vertical-align: super;
    }
    .result-ride-price-desc {
      text-transform: uppercase;
      font-size: 12px;
      font-weight: bold;
    }
    .result-ride-start-end p,
    .result-ride-time p {
      font-weight: bold;
      margin-top: 10px;
    }
    .result-car-model,
    .result-ride-passenger p,
    .result-ride-start-end p,
    .result-ride-time p
    .result-ride-time p {
      text-align: center;
    }
    .result-ride-time p {
      font-size: 12px;
    }
    .result-ride-passenger p:first-child {
      font-weight: bold;
    }
    .result-ride-passenger p:last-child {
      text-transform: uppercase;
      font-size: 12px;
      font-weight: 300;
    }
    .result-ride-passenger p {
      margin: 0;
    }
    .result-ride-start-btn-holder form button {
      width: 100%;
      text-transform: uppercase;
    }
    .divider {
      border-right: 1px solid goldenrod;
    }

    .form-inline {
      text-align: center;
    }

    @media(max-width:991px) {
      .result-upper,
      .result-lower {
        height: auto;
      }
      .result-image {
        max-width: 200px;
        margin: auto;
      }
    }
  </style>
@stop

@section('content')
<div class="row" id="form-wrapper">
    <div class="col-md-12">
    	<h3>Buy Credits</h3>
        {!! Form::model($credit, ['url' => '/rides/credit', 'method' => 'GET', 'class' => 'form-inline']) !!}
          <div class="personal-form">
            <div class="row statement-line">
              <p class="statement">Enter amount of credits to buy:</p><br>
              <div class="form-group">
                  <div class="input-group">
  									<div class="input-group-addon">$</div>
  									{!! Form::input('number', 'creditsToBuy', null, ['class' => 'form-control']) !!}
  									<div class="input-group-addon">.00</div>
									</div>
              </div>
              {!! Form::submit('Buy Credits', ['class' => 'btn btn-default rideshare-btn']) !!}
            </div>
          </div>
        {!! Form::close() !!}
    </div>
  </div>
  @if ($results != '')
    <div class="row">
      <p class="result-counter">{{$results}}</p>
    </div>
  @endif
@stop