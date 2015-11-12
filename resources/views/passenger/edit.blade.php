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
				<span>Edit Passenger {{$passengers['passengeremail']}} taking Ride {{$passengers['ridedepartdatetime']}} by Driver {{$passengers['ridedriveremail']}}</span>
			</h1>
		</div>
	    <div class="row">
		    <div class="col-md-4 col-md-offset-4 col-sm-12">
		        {!! Form::model($passengers, ['url' => '/passengers/passenger/'.$passengers['passengeremail'].'/driver/'.$passengers['ridedriveremail'].'/datetime/'.$passengers['ridedepartdatetime'], 'method' => 'patch']) !!}

		            {{-- Start of Passenger form --}}

		            <div class="personal-form">

		                <div class="form-group">
		                    {!! Form::label('passengeremail', 'Passenger\'s Email') !!}
		                    {!! Form::email('passengeremail', null, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
		                </div>

		                <div class="form-group">
		                    {!! Form::label('ridedepartdatetime', 'Ride Departure Date & Time') !!}
		                    {!! Form::text('ridedepartdatetime', null, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
		                </div>

		                <div class="form-group">
		                    {!! Form::label('ridedriveremail', 'Driver\'s Email') !!}
		                    {!! Form::email('ridedriveremail', null, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
		                </div>

		            </div>

		            {{-- End of Passenger form --}}

		            {!! Form::submit('Update Passenger', ['class' => 'btn btn-default rideshare-btn']) !!}
		        {!! Form::close() !!}
		    </div>
		</div>
	</div>
@stop