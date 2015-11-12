@extends('home')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-title">
				<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
				<span>Passenger {{$passengers[0]->passengeremail}}</span>
			</h1>
		</div>
		@if (count($passengers))
			<table class="table table-bordered">
				<thead>
					<tr>
						@foreach ($passengers[0] as $key => $value)
							@if ($key == 'passengeremail')
								<th>Passenger</th>
							@elseif ($key == 'ridedepartdatetime')
								<th>Ride Departure Date & Time</th>
							@elseif ($key == 'ridedriveremail')
								<th>Ride Driver</th>
							@else
								<th>{{$key}}</th>
							@endif
						@endforeach
					</tr>
				</thead>
				<tbody>
					<tr>
						@foreach ($passengers[0] as $key => $value)
							<td>{{ $value }}</td>
						@endforeach	
					</tr>	
				</tbody>
			</table>
		@endif
	</div>
@stop