@extends('home')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-title">
				<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
				<span>Rides & Drivers</span>
			</h1>
		</div>
		@if (count($driverrides))
			<table class="table table-bordered">
				<thead>
					<tr>
						@foreach ($driverrides[0] as $key => $value)
							@if (!in_array($key, ['iscancelled', 'isended', 'isstarted']))
								@if ($key == 'departdatetime')
									<th>Departure Date & Time</th>
								@elseif ($key == 'departlocation')
									<th>Departure Location</th>
								@elseif ($key == 'destination')
									<th>Destination</th>
								@elseif ($key == 'driveremail')
									<th>Driver</th>
								@elseif ($key == 'priceperseat')
									<th>Price-Per-Seat</th>
								@elseif ($key == 'numseats')
									<th>Ride Seating Capacity</th>
								@else
									<th>{{$key}}</th>
								@endif
							@endif
						@endforeach	
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($driverrides as $driverride)
						<tr>
							@foreach ($driverride as $key => $value)
								@if (!in_array($key, ['iscancelled', 'isended', 'isstarted']))
									<td>{{ $value }}</td>
								@endif
							@endforeach
							<td>
								<a class="btn btn-primary btn-xs" href="{{'/driverrides/driver/'.$driverride->driveremail.'/datetime/'.$driverride->departdatetime}}">Show</a>
								<a class="btn btn-info btn-xs" href="{{'/driverrides/driver/'.$driverride->driveremail.'/datetime/'.$driverride->departdatetime.'/edit'}}">Edit</a>
								{!! Form::open(array('url' => '/driverrides/driver/'.$driverride->driveremail.'/datetime/'.$driverride->departdatetime, 'method' => 'delete', 'onsubmit' => "return confirm('Are you sure you want to delete the account?');")) !!}
	        				<button type="submit" class="btn btn-danger btn-xs">Delete</button>
	    					{!! Form::close() !!}
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		@endif
	</div>
@stop