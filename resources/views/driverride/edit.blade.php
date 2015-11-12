@extends('home')

@section('content')
	<div class="row">
		@if(Session::has('errors'))
	        <div class="alert alert-danger">
	            <h4><center>{{ Session::get('errors') }}</center></h4>
	        </div>
	    @endif
		<div class="col-lg-12">
			<h1 class="page-title">
				<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
				<span>Edit Ride at {{$driverrides['departDateTime']}} by Driver {{$driverrides['driverEmail']}}</span>
			</h1>
		</div>
	    <div class="row">
		    <div class="col-md-4 col-md-offset-4 col-sm-12">
		        {!! Form::model($driverrides, ['url' => '/driverrides/driver/'.$driverrides['driverEmail'].'/datetime/'.$driverrides['departDateTime'], 'method' => 'patch']) !!}

		            {{-- Start of Driver Ride form --}}

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
	                  	{!! Form::input('datetime', 'departDateTime', null, ['class' => 'form-control', 'id' => 'datetimepicker1', 'readonly' => 'readonly']) !!}
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

		                <div class="form-group">
		                    {!! Form::label('driverEmail', 'Driver') !!}
		                    {!! Form::email('driverEmail', null, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
		                </div>

		                <div class="form-group">
		                    {!! Form::label('isCancelled', 'Is Ride Cancelled?') !!}
		                </div>

		                <div class="radio-inline">
		                    {!! Form::radio('isCancelled', 'TRUE', null, ['id'=> 'iscancelled-TRUE']) !!}
		                    {!! Form::label('iscancelled-TRUE', 'True') !!}
		                </div>
		                
		                <div class="radio-inline">
		                    {!! Form::radio('isCancelled', 'FALSE', null, ['id' => 'iscancelled-FALSE']) !!}
		                    {!! Form::label('iscancelled-FALSE', 'False') !!}
		                </div>

		                <div class="form-group">
		                    {!! Form::label('isStarted', 'Has Ride Started?') !!}
		                </div>


		                <div class="radio-inline">
		                    {!! Form::radio('isStarted', 'TRUE', null, ['id'=> 'isstarted-TRUE']) !!}
		                    {!! Form::label('isstarted-TRUE', 'True') !!}
		                </div>
		                
		                <div class="radio-inline">
		                    {!! Form::radio('isStarted', 'FALSE', null, ['id' => 'isstarted-FALSE']) !!}
		                    {!! Form::label('isstarted-FALSE', 'False') !!}
		                </div>

		                <div class="form-group">
		                    {!! Form::label('isEnded', 'Has Ride Ended?') !!}
		                </div>

		                <div class="radio-inline">
		                    {!! Form::radio('isEnded', 'TRUE', null, ['id'=> 'isended-TRUE']) !!}
		                    {!! Form::label('isended-TRUE', 'True') !!}
		                </div>
		                
		                <div class="radio-inline">
		                    {!! Form::radio('isEnded', 'FALSE', null, ['id' => 'isended-FALSE']) !!}
		                    {!! Form::label('isended-FALSE', 'False') !!}
		                </div>
		                
		            </div>

		            {{-- End of Person form --}}
		            {!! Form::submit('Update Ride', ['class' => 'btn btn-default rideshare-btn']) !!}
		        {!! Form::close() !!}
		    </div>
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