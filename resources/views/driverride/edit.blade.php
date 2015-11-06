@extends('home')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-title">
				<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
				<span>Edit Ride at {{$driverrides['departdatetime']}} by Driver {{$driverrides['driveremail']}}</span>
			</h1>
		</div>
    <div class="row">
	    <div class="col-md-4 col-md-offset-4 col-sm-12">
	        {!! Form::model($driverrides, ['url' => '/driverrides/driver/'.$driverrides['driveremail'].'/datetime/'.$driverrides['departdatetime'], 'method' => 'patch']) !!}

	            {{-- Start of Driver Ride form --}}

	            <div class="personal-form">

	                <div class="form-group">
	                    {!! Form::label('departdatetime', 'Departure Date & Time') !!}
	                    {!! Form::text('departdatetime', null, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
	                </div>

	                <div class="form-group">
	                    {!! Form::label('departlocation', 'Departure Location') !!}
	                    {!! Form::select('departlocation', array(
	                    	'Pasir Ris' => 'Pasir Ris', 
	                    	'Tampines' => 'Tampines',
	                    	'Simei' => 'Simei',
	                    	'Tanah Merah' => 'Tanah Merah',
	                    	'Expo' => 'Expo',
	                    	'Changi Airport' => 'Changi Airport',
	                    	'Bedok' => 'Bedok',
	                    	'Kembangan' => 'Kembangan',
	                    	'Eunos' => 'Eunos',
	                    	'Paya Lebar' => 'Paya Lebar',
	                    	'Aljunied' => 'Aljunied',
	                    	'Kallang' => 'Kallang',
	                    	'Lavender' => 'Lavender',
	                    	'Bugis' => 'Bugis',
	                    	'City Hall' => 'City Hall',
	                    	'Raffles Place' => 'Raffles Place',
	                    	'Tanjong Pagar' => 'Tanjong Pagar',
	                    	'Outram Park' => 'Outram Park',
	                    	'Tiong Bahru' => 'Tiong Bahru',
	                    	'Redhill' => 'Redhill',
	                    	'Queenstown' => 'Queenstown',
	                    	'Commonwealth' => 'Commonwealth',
	                    	'Buona Vista' => 'Buona Vista',
	                    	'Dover' => 'Dover',
	                    	'Clementi' => 'Clementi',
	                    	'Jurong East' => 'Jurong East',
	                    	'Chinese Gardens' => 'Chinese Gardens',
	                    	'Lakeside' => 'Lakeside',
	                    	'Boon Lay' => 'Boon Lay',
	                    	'Pioneer' => 'Pioneer',
	                    	'Joo Koon' => 'Joo Koon',
	                    ), $driverrides['departlocation']); !!}
	                </div>

	                <div class="form-group">
	                    {!! Form::label('destination', 'Destination') !!}
	                    {!! Form::select('destination', array(
	                    	'Pasir Ris' => 'Pasir Ris', 
	                    	'Tampines' => 'Tampines',
	                    	'Simei' => 'Simei',
	                    	'Tanah Merah' => 'Tanah Merah',
	                    	'Expo' => 'Expo',
	                    	'Changi Airport' => 'Changi Airport',
	                    	'Bedok' => 'Bedok',
	                    	'Kembangan' => 'Kembangan',
	                    	'Eunos' => 'Eunos',
	                    	'Paya Lebar' => 'Paya Lebar',
	                    	'Aljunied' => 'Aljunied',
	                    	'Kallang' => 'Kallang',
	                    	'Lavender' => 'Lavender',
	                    	'Bugis' => 'Bugis',
	                    	'City Hall' => 'City Hall',
	                    	'Raffles Place' => 'Raffles Place',
	                    	'Tanjong Pagar' => 'Tanjong Pagar',
	                    	'Outram Park' => 'Outram Park',
	                    	'Tiong Bahru' => 'Tiong Bahru',
	                    	'Redhill' => 'Redhill',
	                    	'Queenstown' => 'Queenstown',
	                    	'Commonwealth' => 'Commonwealth',
	                    	'Buona Vista' => 'Buona Vista',
	                    	'Dover' => 'Dover',
	                    	'Clementi' => 'Clementi',
	                    	'Jurong East' => 'Jurong East',
	                    	'Chinese Gardens' => 'Chinese Gardens',
	                    	'Lakeside' => 'Lakeside',
	                    	'Boon Lay' => 'Boon Lay',
	                    	'Pioneer' => 'Pioneer',
	                    	'Joo Koon' => 'Joo Koon',
	                    ), $driverrides['destination']); !!}
	                </div>

	                <div class="form-group">
	                    {!! Form::label('driveremail', 'Driver') !!}
	                    {!! Form::email('driveremail', null, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
	                </div>

	                <div class="form-group">
	                    {!! Form::label('priceperseat', 'Price Per Seat') !!}
	                    {!! Form::input('number', 'priceperseat', null, ['class' => 'form-control', 'min' => 0]) !!}
	                </div>

	                <div class="form-group">
	                    {!! Form::label('numseats', 'Seating Capacity') !!}
	                    {!! Form::input('number', 'numseats', null, ['class' => 'form-control', 'min' => 0]) !!}
	                </div>

	                <div class="form-group">
	                    {!! Form::label('iscancelled', 'Is Ride Cancelled?') !!}
	                </div>

	                <div class="radio-inline">
	                    {!! Form::radio('iscancelled', 'TRUE', null, ['id'=> 'iscancelled-TRUE']) !!}
	                    {!! Form::label('isadmin-TRUE', 'TRUE') !!}
	                </div>
	                
	                <div class="radio-inline">
	                    {!! Form::radio('iscancelled', 'FALSE', null, ['id' => 'iscancelled-FALSE']) !!}
	                    {!! Form::label('isadmin-FALSE', 'False') !!}
	                </div>

	                <div class="form-group">
	                    {!! Form::label('isstarted', 'Has Ride Started?') !!}
	                </div>

	                <div class="radio-inline">
	                    {!! Form::radio('isstarted', 'TRUE', null, ['id'=> 'isstarted-TRUE']) !!}
	                    {!! Form::label('isstarted-TRUE', 'TRUE') !!}
	                </div>
	                
	                <div class="radio-inline">
	                    {!! Form::radio('isstarted', 'FALSE', null, ['id' => 'isstarted-FALSE']) !!}
	                    {!! Form::label('isstarted-FALSE', 'False') !!}
	                </div>

	                <div class="form-group">
	                    {!! Form::label('isended', 'Has Ride Ended?') !!}
	                </div>

	                <div class="radio-inline">
	                    {!! Form::radio('isended', 'TRUE', null, ['id'=> 'isended-TRUE']) !!}
	                    {!! Form::label('isended-TRUE', 'TRUE') !!}
	                </div>
	                
	                <div class="radio-inline">
	                    {!! Form::radio('isended', 'FALSE', null, ['id' => 'isended-FALSE']) !!}
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