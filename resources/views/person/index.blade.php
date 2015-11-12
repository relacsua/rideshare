@extends('home')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-title">
				<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
				<span>Persons</span>
			</h1>
		</div>
		@if (count($persons))
			<table class="table table-bordered">
				<thead>
					<tr>
						@foreach ($persons[0] as $key => $value)
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
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($persons as $person)
						<tr>
							@foreach ($person as $key => $value)
								@if (!in_array($key, ['password', 'isadmin']))
									@if (in_array($key, ['balance']))
										<td>${{ $value }}.00</td>
									@else
										<td>{{ $value }}</td>
									@endif
								@endif
							@endforeach
							<td>
								<a class="btn btn-primary btn-xs" href="{{'/persons/'.$person->email}}">Show</a>
								<a class="btn btn-info btn-xs" href="{{'/persons/'.$person->email.'/edit'}}">Edit</a>
								{!! Form::open(array('url' => '/persons/'.$person->email, 'method' => 'delete', 'onsubmit' => "return confirm('Are you sure you want to delete the account?');")) !!}
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