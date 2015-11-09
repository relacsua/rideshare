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
      <p>No results. Try again.</p>
    </div>
  @elseif (!empty($results) && !empty($ride))
    <div class="row">
      <p>{{count($results).' '.(count($results) > 1 ? 'results' : 'result')}} found.</p>
      @foreach ($results as $result)
        <div>
          @foreach ($result as $key => $value)
            <p>{{ $key.' : '.$value }}</p>
          @endforeach
        </div>
      @endforeach
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