@extends('home')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-title">
				<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
				<span>{{$person[0]->name}}</span>
			</h1>
		</div>
		<table class="table table-bordered">
			<thead>
				<tr>
					@foreach ($person[0] as $key => $value)
						@if (!in_array($key, ['password']))
							<th>{{ $key }}</th>
						@endif
					@endforeach
				</tr>
			</thead>
			<tbody>
				<tr>
					@foreach ($person[0] as $key => $value)
						@if (!in_array($key, ['password']))
							<td>{{ $value }}</td>
						@endif
					@endforeach	
				</tr>	
			</tbody>
		</table>
	</div>
@stop