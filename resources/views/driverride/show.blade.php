@extends('home')

@section('content')
	<div class="row">
		@if (count($driverrides))
			<div class="col-lg-12">
				<h1 class="page-title">
					<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
					<span>Ride at {{$driverrides[0]->departdatetime}} by Driver {{$driverrides[0]->driveremail}}</span>
				</h1>
			</div>
			<table class="table table-bordered">
				<thead>
					<tr>
						@foreach ($driverrides[0] as $key => $value)
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
						@endforeach
					</tr>
				</thead>
				<tbody>
					<tr>
						@foreach ($driverrides[0] as $key => $value)
							<td>{{ $value }}</td>
						@endforeach	
					</tr>	
				</tbody>
			</table>
		@endif
	</div>
@stop