@extends('home')

@section('content')
	<link rel="stylesheet" type="text/css" href="{{ asset('/css/new_profile.css') }}">
	<div class="row">
		@if(Session::has('errors'))
	        <div class="alert alert-danger">
	            <h4><center>{{ Session::get('errors') }}</center></h4>
	        </div>
	    @endif
		<div class="col-lg-12">
			<h1 class="page-title">
				<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
				<span>Edit Profile</span>
			</h1>
			 <div class="row">
			    <div class="col-md-4 col-md-offset-4 col-sm-12">
			        {!! Form::model($user, ['url' => '/me/update']) !!}

			            {{-- Start of Person form --}}

			            <div class="personal-form">

			                <p class="form-header">Personal details</p>

			                <div class="form-group">
			                    {!! Form::label('email', 'Email') !!}
			                    {!! Form::email('email', null, ['class' => 'form-control', 'disabled' => '']) !!}
			                </div>

			                <div class="form-group">
			                    {!! Form::label('name', 'Name') !!}
			                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
			                </div>

			                <div class="radio-inline">
			                    {!! Form::radio('gender', 'MALE', null, ['id'=> 'gender-male']) !!}
			                    {!! Form::label('gender-male', 'Male') !!}
			                </div>
			                <div class="radio-inline">
			                    {!! Form::radio('gender', 'FEMALE', null, ['id' => 'gender-female']) !!}
			                    {!! Form::label('gender-female', 'Female') !!}
			                </div>

			                <div class="form-group">
			                    {!! Form::label('age', 'Age') !!}
			                    {!! Form::input('number', 'age', null, ['class' => 'form-control', 'min' => 18]) !!}
			                </div>

			                <div class="form-group">
			                    {!! Form::label('avatar', 'Avatar') !!}
			                    {!! Form::input('url', 'avatar', null, ['class' => 'form-control']) !!}
			                </div>

			                <div class="form-group">
			                    {!! Form::label('oldPassword', 'Old Password') !!}
			                    {!! Form::password('oldPassword', ['class' => 'form-control']) !!}
			                </div>

			                <div class="form-group">
			                    {!! Form::label('newPassword', 'New Password') !!}
			                    {!! Form::password('newPassword', ['class' => 'form-control']) !!}
			                </div>
			            </div>

			            {{-- End of Person form --}}

			            {{-- Start of Profile form --}}

{{-- 			            <div class="profile-form">
			                <p class="form-header">Profile details</p>
			                <div class="form-group">
			                    {!! Form::label('id', 'Facebook ID') !!}
			                    {!! Form::text('id', null, ['class' => 'form-control', 'disabled' => '']) !!}
			                </div>
			                <div class="form-group">
			                    {!! Form::label('token', 'Facebook token') !!}
			                    {!! Form::textarea('token', null, ['class' => 'form-control', 'disabled' => '']) !!}
			                </div>
			            </div> --}}

			            {{-- End of Profile form --}}
			            
			            {{-- Start of Driver form --}}

			            <div class="checkbox-inline">
			                {!! Form::checkbox('isDriver', 1, false, ['id' => 'isDriver']) !!}
			                {!! Form::label('isDriver', 'Do you also wish to register as a driver ?') !!}
			            </div>
			            
			            <div class="driver-form">

			                <p class="form-header">Driving details</p>

			                <div class="form-group">
			                    {!! Form::label('carPlateNo', 'Car Plate Number') !!}
			                    {!! Form::text('carPlateNo', null, ['class' => 'form-control']) !!}
			                </div>
			                <div class="form-group">
			                    {!! Form::label('carModel', 'Car Model') !!}
			                    {!! Form::text('carModel', null, ['class' => 'form-control']) !!}
			                </div>
			                <div class="form-group">
			                    {!! Form::label('licenceNo', 'Licence Number') !!}
			                    {!! Form::text('licenceNo', null, ['class' => 'form-control']) !!}
			                </div>
			                <div class="form-group">
			                    {!! Form::label('numSeats', 'Maximum number of seats (excluding driver seat)') !!}
			                    {!! Form::input('number', 'numSeats', null, ['class' => 'form-control', 'min' => 0]) !!}
			                </div>
			            </div>

			            {{-- End of Driver form --}}

			            {!! Form::submit('Update Profile', ['class' => 'btn btn-default rideshare-btn']) !!}
			        {!! Form::close() !!}
			    </div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="{{ asset('/vendor/jquery/dist/jquery.min.js') }}"></script>
	<script type="text/javascript">
	    if($('#isDriver').prop('checked')) {
	        $('.driver-form').show();
	    } else {
	        $('.driver-form').hide();
	    }
	    $('#isDriver').on('click', function () {
	        $('.driver-form').slideToggle();
	    });
	</script>
@stop