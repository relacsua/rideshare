@extends('home')

@section('style')
  <link rel="stylesheet" href="{{ asset('/vendor/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}" />
@stop

@section('content')
  <div class="row">
    @if(Session::has('errors'))
        <div class="alert alert-danger">
            <h4><center>{{ Session::get('errors') }}</center></h4>
        </div>
    @endif
    <div class="col-md-4 col-md-offset-4 col-sm-12">
    	<h3>Create a ride</h3>
        
      {!! Form::model($ride, ['url' => '/rides/create']) !!}

          <div class="personal-form">

            <div class="form-group">
                {!! Form::label('departLocation', 'From') !!}
                {!! Form::select('departLocation', $validLocations, null, ['class' => 'form-control']); !!}
            </div>

            <div class="form-group">
                {!! Form::label('destination', 'To') !!}
                {!! Form::select('destination', $validLocations, null, ['class' => 'form-control']); !!}
            </div>

            <div class="form-group">
							{!! Form::label('departDateTime', 'On') !!}
            	{!! Form::input('datetime', 'departDateTime', null, ['class' => 'form-control', 'id' => 'datetimepicker1']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('pricePerSeat', 'Price per passenger') !!}
                <div class="input-group">
									<div class="input-group-addon">$</div>
									{!! Form::input('number', 'pricePerSeat', null, ['class' => 'form-control']) !!}
									<div class="input-group-addon">.00</div>
								</div>
            </div>

            <div class="form-group">
                {!! Form::label('numSeats', 'Number of seats available') !!}
                {!! Form::input('number', 'numSeats', null, ['class' => 'form-control', 'min' => 1, 'max' => $maxSeats]) !!}
            </div>

          	{!! Form::submit('Post a ride', ['class' => 'btn btn-default rideshare-btn']) !!}
          </div>
      {!! Form::close() !!}
    </div>
  </div>
@stop

@section('script')
	<script type="text/javascript" src="{{ asset('/vendor/moment/min/moment.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/vendor/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
  <script>
		$(function () {
			var date = new Date();
			date.setDate(date.getDate()-1);
			$('#datetimepicker1').datetimepicker({
				format: 'DD-MM-YY HH:mm:ss',
				minDate: date,useCurrent: true,
				widgetPositioning: {vertical: 'bottom'}
			});
		});
  </script>
@stop