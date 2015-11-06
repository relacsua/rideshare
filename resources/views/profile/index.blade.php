@extends('home')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-title">
				<span class="glyphicon glyphicon-sunglasses" aria-hidden="true"></span>
				<span>Profiles</span>
			</h1>
		</div>
		@if (count($profiles))
			<table class="table table-bordered">
				<thead>
					<tr>
						@foreach ($profiles[0] as $key => $value)
							@if (!in_array($key, ['token']))
								<th>{{ $key }}</th>
							@endif
						@endforeach	
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($profiles as $profile)
						<tr>
							@foreach ($profile as $key => $value)
								@if (!in_array($key, ['token']))
									@if ($key == 'email')
										<td><a href="{{'/persons/'.$value}}">{{ $value }}</a></td>
									@else
										<td>{{ $value }}</td>
									@endif
								@endif
							@endforeach
							<td>
								<a class="btn btn-primary btn-xs" href="{{'/profiles/'.$profile->email}}">Show</a>
								<a class="btn btn-info btn-xs" href="{{'/profiles/'.$profile->email.'/edit'}}">Edit</a>
								{!! Form::open(array('url' => '/profiles/'.$profile->email.'/'.$profile->userid, 'method' => 'delete', 'onsubmit' => "return confirm('Are you sure you want to delete the account?');")) !!}
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