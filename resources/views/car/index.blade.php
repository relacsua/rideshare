@extends('home')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-title">
				<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
				<span>Cars</span>
			</h1>
		</div>
		@if (count($cars))
			<table class="table table-bordered">
				<thead>
					<tr>
						@foreach ($cars[0] as $key => $value)
							@if ($key == 'carplateno')
								<th>Car Plate Number</th>
							@elseif ($key == 'carmodel')
								<th>Car Model</th>
							@elseif ($key == 'ownerlicenseno')
								<th>Owner's License Number</th>
							@elseif ($key == 'numseats')
								<th>Seating Capacity</th>
							@elseif ($key == 'owneremail')
								<th>Owner</th>
							@endif
						@endforeach	
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($cars as $car)
						<tr>
							@foreach ($car as $key => $value)
								<td>{{ $value }}</td>
							@endforeach
							<td>
								<a class="btn btn-primary btn-xs" href="{{'/cars/'.$car->carplateno}}">Show</a>
								<a class="btn btn-info btn-xs" href="{{'/cars/'.$car->carplateno.'/edit'}}">Edit</a>
								{!! Form::open(array('url' => '/cars/'.$car->carplateno, 'method' => 'delete', 'onsubmit' => "return confirm('Are you sure you want to delete the car record?');")) !!}
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