@extends('home')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-title">
				<span class="glyphicon glyphicon-sunglasses" aria-hidden="true"></span>
				<span>Edit {{$profile['email']}}</span>
			</h1>
		</div>
    <div class="row">
	    <div class="col-md-4 col-md-offset-4 col-sm-12">
	        {!! Form::model($profile, ['url' => '/profiles/'.$profile['email'], 'method' => 'patch']) !!}
	            {{-- Start of Profile form --}}
						<div class="profile-form">
							<div class="form-group">
								{!! Form::label('userid', 'Facebook ID') !!}
								{!! Form::text('userid', null, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
							</div>
							<div class="form-group">
								{!! Form::label('token', 'Facebook token') !!}
								{!! Form::textarea('token', null, ['class' => 'form-control']) !!}
							</div>
						</div>
							{{-- End of Profile form --}}
	            {!! Form::submit('Update Profile', ['class' => 'btn btn-default rideshare-btn']) !!}
	        {!! Form::close() !!}
	    </div>
		</div>
	</div>
@stop