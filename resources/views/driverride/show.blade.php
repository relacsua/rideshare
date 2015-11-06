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
							<th>{{ $key }}</th>
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