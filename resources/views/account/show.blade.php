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
								@if ($key == 'email')
									<th>Email</th>
								@elseif ($key == 'name')
									<th>Name</th>
								@elseif ($key == 'balance')
									<th>Balance</th>
								@elseif ($key == 'age')
									<th>Age</th>
								@elseif ($key == 'gender')
									<th>Gender</th>
								@elseif ($key == 'avatar')
									<th>Avatar</th>
								@else
									<th>{{$key}}</th>
								@endif
							@endif
						@endforeach	
					</tr>
				</thead>
				<tbody>
					<tr>
						@foreach ($person[0] as $key => $value)
							@if (!in_array($key, ['password', 'isadmin']))
								@if (in_array($key, ['balance']))
									<td>${{ $value }}.00</td>
								@else
									<td>{{ $value }}</td>
								@endif
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
									@if ($key == 'carplateno')
										<th>Car Plate Number</th>
									@elseif ($key == 'carmodel')
										<th>Car Model</th>
									@elseif ($key == 'ownerlicenseno')
										<th>Owner's License Number</th>
									@elseif ($key == 'numseats')
										<th>Seating Capacity</th>
									@endif
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