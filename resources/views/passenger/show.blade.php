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
							<th>{{ $key }}</th>
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