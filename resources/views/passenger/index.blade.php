@extends('home')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-title">
				<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
				<span>Passengers</span>
			</h1>
		</div>
		@if (count($passengers))
			<table class="table table-bordered">
				<thead>
					<tr>
						@foreach ($passengers[0] as $key => $value)
							<th>{{ $key }}</th>
						@endforeach	
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($passengers as $passenger)
						<tr>
							@foreach ($passenger as $key => $value)
								<td>{{ $value }}</td>
							@endforeach
							<td>
								<a class="btn btn-primary btn-xs" href="{{'/passengers/passenger/'.$passenger->passengeremail.'/driver/'.$passenger->ridedriveremail.'/datetime/'.$passenger->ridedepartdatetime}}">Show</a>
								<a class="btn btn-info btn-xs" href="{{'/passengers/passenger/'.$passenger->passengeremail.'/driver/'.$passenger->ridedriveremail.'/datetime/'.$passenger->ridedepartdatetime.'/edit'}}">Edit</a>
								{!! Form::open(array('url' => '/passengers/passenger/'.$passenger->passengeremail.'/driver/'.$passenger->ridedriveremail.'/datetime/'.$passenger->ridedepartdatetime, 'method' => 'delete', 'onsubmit' => "return confirm('Are you sure you want to delete the account?');")) !!}
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