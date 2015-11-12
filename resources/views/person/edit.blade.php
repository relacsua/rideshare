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
				<span>Edit {{$person['name']}}</span>
			</h1>
		</div>
	    <div class="row">
		    <div class="col-md-4 col-md-offset-4 col-sm-12">
		        {!! Form::model($person, ['url' => '/persons/'.$person['email'], 'method' => 'patch']) !!}

		            {{-- Start of Person form --}}

		            <div class="personal-form">

		                <div class="form-group">
		                    {!! Form::label('email', 'Email') !!}
		                    {!! Form::email('email', null, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
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
		                    {!! Form::label('balance', 'Balance') !!}
		                    {!! Form::input('number', 'balance', null, ['class' => 'form-control', 'min' => 0]) !!}
		                </div>

		                <div class="radio-inline">
		                    {!! Form::radio('isadmin', 'TRUE', null, ['id'=> 'isadmin-TRUE']) !!}
		                    {!! Form::label('isadmin-TRUE', 'True') !!}
		                </div>
		                <div class="radio-inline">
		                    {!! Form::radio('isadmin', 'FALSE', null, ['id' => 'isadmin-FALSE']) !!}
		                    {!! Form::label('isadmin-FALSE', 'False') !!}
		                </div>

		                <div class="form-group">
		                    {!! Form::label('avatar', 'Avatar') !!}
		                    {!! Form::input('url', 'avatar', null, ['class' => 'form-control']) !!}
		                </div>
		            </div>

		            {{-- End of Person form --}}
		            {!! Form::submit('Update Account', ['class' => 'btn btn-default rideshare-btn']) !!}
		        {!! Form::close() !!}
		    </div>
		</div>
	</div>
@stop