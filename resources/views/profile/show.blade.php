@extends('home')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-title">
				<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
				<span>{{$profile[0]->email}}</span>
			</h1>
		</div>
		<table class="table table-bordered">
			<thead>
				<tr>
					@foreach ($profile[0] as $key => $value)
						@if (!in_array($key, []))
							<th>{{ $key }}</th>
						@endif
					@endforeach
				</tr>
			</thead>
			<tbody>
				<tr>
					@foreach ($profile[0] as $key => $value)
						@if (!in_array($key, []))
							<td>{{ $value }}</td>
						@endif
					@endforeach	
				</tr>	
			</tbody>
		</table>
	</div>
@stop