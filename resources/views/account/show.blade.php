@extends('home')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-title">
				<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
				<span>Profile</span>
			</h1>
			<a class="pull-right btn btn-default rideshare-btn" href="/me/edit">Edit Profile</a>

			<h3>Person Details</h3>
			<table class="table table-bordered">
				<thead>
					<tr>
						@foreach ($person[0] as $key => $value)
							@if (!in_array($key, ['password', 'isadmin']))
								<th>{{ $key }}</th>
							@endif
						@endforeach	
					</tr>
				</thead>
				<tbody>
					<tr>
						@foreach ($person[0] as $key => $value)
							@if (!in_array($key, ['password', 'isadmin']))
								<td>{{ $value }}</td>
							@endif
						@endforeach	
					</tr>
				</tbody>
			</table>

			<h3>Facebook Profile Details</h3>
			<table class="table table-bordered">
				<thead>
					<tr>
						@foreach ($profile[0] as $key => $value)
							@if (!in_array($key, ['email', 'token']))
								<th>{{ $key }}</th>
							@endif
						@endforeach	
					</tr>
				</thead>
				<tbody>
					<tr>
						@foreach ($profile[0] as $key => $value)
							@if (!in_array($key, ['email', 'token']))
								<td>{{ $value }}</td>
							@endif
						@endforeach	
					</tr>
				</tbody>
			</table>

			@if (!empty($car))
				<h3>Driver Details</h3>
				<table class="table table-bordered">
					<thead>
						<tr>
							@foreach ($car[0] as $key => $value)
								@if (!in_array($key, ['owneremail']))
									<th>{{ $key }}</th>
								@endif
							@endforeach	
						</tr>
					</thead>
					<tbody>
						<tr>
							@foreach ($car[0] as $key => $value)
								@if (!in_array($key, ['owneremail']))
									<td>{{ $value }}</td>
								@endif
							@endforeach	
						</tr>
					</tbody>
				</table>
			@endif
		</div>
	</div>
@stop