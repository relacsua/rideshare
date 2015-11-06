@extends('home')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-title">
				<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
				<span>Edit Car {{$car['carplateno']}} from {{$name}}</span>
			</h1>
		</div>
	    <div class="row">
		    <div class="col-md-4 col-md-offset-4 col-sm-12">
		        {!! Form::model($car, ['url' => '/cars/'.$car['carplateno'], 'method' => 'patch']) !!}

		            {{-- Start of Person form --}}

		            <div class="personal-form">

		                <div class="form-group">
		                    {!! Form::label('carplateno', 'Car Plate Number') !!}
		                    {!! Form::text('carplateno', null, ['class' => 'form-control']) !!}
		                </div>

		                <div class="form-group">
		                    {!! Form::label('carmodel', 'Car Model') !!}
		                    {!! Form::text('carmodel', null, ['class' => 'form-control']) !!}
		                </div>

		                <div class="form-group">
		                    {!! Form::label('ownerlicenseno', 'License Number') !!}
		                    {!! Form::text('ownerlicenseno', null, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
		                </div>

		                <div class="form-group">
		                    {!! Form::label('numseats', 'Number of Seats') !!}
		                    {!! Form::input('number', 'numseats', null, ['class' => 'form-control', 'min' => 0]) !!}
		                </div>
		            </div>

		            {{-- End of Person form --}}
		            {!! Form::submit('Update Car Record', ['class' => 'btn btn-default rideshare-btn']) !!}
		        {!! Form::close() !!}
		    </div>
		</div>
	</div>
@stop