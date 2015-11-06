@extends('home')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-title">
				<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
				<span>Car {{$car[0]->carplateno}} from {{$name}}</span>
			</h1>
		</div>
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
	</div>
@stop