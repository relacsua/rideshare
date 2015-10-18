@extends('home')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-title">
				<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
				<span>Profile</span>
			</h1>
			
			<h3>Driver Details</h3>
			<table class="table table-bordered">
				<thead>
					<tr>
						@foreach ($car[0] as $key => $value)
							<th>{{ $key }}</th>
						@endforeach	
					</tr>
				</thead>
				<tbody>
					<tr>
						@foreach ($car[0] as $key => $value)
							<td>{{ $value }}</td>
						@endforeach	
					</tr>
				</tbody>
			</table>

			<h3>Person Details</h3>
			<table class="table table-bordered">
				<thead>
					<tr>
						@foreach ($person[0] as $key => $value)
							<th>{{ $key }}</th>
						@endforeach	
					</tr>
				</thead>
				<tbody>
					<tr>
						@foreach ($person[0] as $key => $value)
							<td>{{ $value }}</td>
						@endforeach	
					</tr>
				</tbody>
			</table>

			<h3>Facebook Profile Details</h3>
			<table class="table table-bordered">
				<thead>
					<tr>
						@foreach ($profile[0] as $key => $value)
							<th>{{ $key }}</th>
						@endforeach	
					</tr>
				</thead>
				<tbody>
					<tr>
						@foreach ($profile[0] as $key => $value)
							<td>{{ $value }}</td>
						@endforeach	
					</tr>
				</tbody>
			</table>
		</div>
	</div>
@stop