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
  </style>
@stop

@section('content')
  <div class="row" id="form-wrapper">
    <div class="col-md-12">
    	<h3>Search for rides</h3>
        {!! Form::model($ride, ['url' => '/rides/search', 'method' => 'GET', 'class' => 'form-inline']) !!}
          <div class="personal-form">
            <div class="row statement-line">
              <p class="statement">I want to go from </p>
              <div class="form-group">
                  {!! Form::select('departLocation', $validLocations, null, ['class' => 'form-control']); !!}
              </div>
              <p class="statement"> to </p>
              <div class="form-group">
                  {!! Form::select('destination', $validLocations, null, ['class' => 'form-control']); !!}
              </div>
              
              <p class="statement"> anytime between </p>
              <div class="form-group">
              	{!! Form::input('datetime', 'departDateTimeStart', null, ['class' => 'form-control', 'id' => 'datetimepicker1']) !!}
              </div>
            </div>
            <div class="row statement-line">
              <p class="statement"> and </p>
              <div class="form-group">
                {!! Form::input('datetime', 'departDateTimeEnd', null, ['class' => 'form-control', 'id' => 'datetimepicker2']) !!}
              </div>
              <p class="statement"> at the price less than </p>
              <div class="form-group">
                  <div class="input-group">
  									<div class="input-group-addon">$</div>
  									{!! Form::input('number', 'maxPricePerSeat', null, ['class' => 'form-control']) !!}
  									<div class="input-group-addon">.00</div>
									</div>
              </div>
              {!! Form::submit('Get\'em rides', ['class' => 'btn btn-default rideshare-btn']) !!}
            </div>
          </div>
        {!! Form::close() !!}
    </div>
  </div>
  @if (empty($results) && !empty($ride))
    <div class="row">
      <p class="result-counter">No results. Try again.</p>
    </div>
  @elseif (!empty($results) && !empty($ride))
    <div class="row">
      <p class="result-counter">{{count($results).' '.(count($results) > 1 ? 'results' : 'result')}} found.</p>
      <div class="result-container">
        @foreach ($results as $result)
          <div class="result-item">
            <div class="row result-upper">
              <div class="col-md-2">
                <img class="result-image" src="{{$result->avatar}}" >
              </div>

              <div class="col-md-2">
                <p class="result-driver-name">{{$result->name}}</p>
                <p class="result-driver-details">{{$result->age}} yrs | {{$result->gender}}</p>
              </div>
              <div class="col-md-offset-6 col-md-2">
                <h3 class="result-ride-price">${{$result->priceperseat}}.<sup>00</sup></h3>
                <span class="result-ride-price-desc">per passenger</span>
              </div>
            </div>
            <div class="row result-lower">
              <div class="col-md-2 result-car-model divider">
                <h4>{{$result->carmodel}}</h4>
              </div>
              <div class="col-md-2 result-ride-start-end divider">
                <p>{{$result->departlocation}} to {{$result->destination}}</p>
              </div>
              <div class="col-md-2 result-ride-time divider">
                <p>{{$result->departdatetime}}</p>
              </div>
              <div class="col-md-2 result-ride-passenger">
                @if (is_null($result->numpassenger))
                  <p>{{$result->numseats.($result->numseats > 1 ? ' Seats' : 'Seat') }}</p>
                @else
                  <p>{{$result->numseats - $result->numpassenger}}{{' '.($result->numseats - $result->numpassenger > 1 ? 'Seats' : 'Seat')}}</p>
                @endif
                <p>Avalaible</p>
              </div>
              <div class="col-md-3 result-ride-start-btn-holder">
                {!! Form::open(array('url' => '', 'onsubmit' => "return confirm('Are you sure you want to sign up for the ride?');")) !!}
                  <button type="submit" class="btn rideshare-btn">take this ride</button>
                {!! Form::close() !!}
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  @endif
@stop

@section('script')
	<script type="text/javascript" src="{{ asset('/vendor/moment/min/moment.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/vendor/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
  <script>
		$(function () {
			var date = new Date();
			date.setDate(date.getDate()-1);
			$('#datetimepicker1, #datetimepicker2').datetimepicker({
				format: 'DD-MM-YY HH:mm:ss',
				minDate: date,useCurrent: true,
				widgetPositioning: {vertical: 'bottom'}
			});
		});
  </script>
@stop