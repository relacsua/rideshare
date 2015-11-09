@extends('home')

@section('content')
	<div class="row">

	  <!-- Nav tabs -->
	  <ul class="nav nav-pills" role="tablist">
	    <li role="presentation" class="active"><a href="#postedrides" aria-controls="postedrides" role="tab" data-toggle="tab">Posted Rides</a></li>
	    <li role="presentation"><a href="#history" aria-controls="history" role="tab" data-toggle="tab">History</a></li>
	  </ul>

	  <!-- Tab panes -->
	  <div class="tab-content">
	    <div role="tabpanel" class="tab-pane active" id="postedrides">
	    	<div class="row">
				<div class="col-lg-12">
					<h1 class="page-title">
						<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
						<span>In-Progress</span>
					</h1>
				</div>
				@if (count($inprogressrides))
					<table class="table table-bordered">
						<thead>
							<tr>
								@foreach ($inprogressrides[0] as $key => $value)
									<th>{{ $key }}</th>
								@endforeach	
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($inprogressrides as $inprogressride)
								<tr>
									@foreach ($inprogressride as $key => $value)
										<td>{{ $value }}</td>
									@endforeach
									<td>
										{!! Form::open(array('url' => '/rides/managed/'.$inprogressride->departdatetime.'/endRide','onsubmit' => "return confirm('Are you sure you want to end the ride?');")) !!}
	        								<button type="submit" class="btn rideshare-btn btn-xs">End</button>
	    								{!! Form::close() !!}
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				@endif

				<div class="col-lg-12">
					<h1 class="page-title">
						<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
						<span>Posted</span>
					</h1>
				</div>
				@if (count($postedrides))
					<table class="table table-bordered">
						<thead>
							<tr>
								@foreach ($postedrides[0] as $key => $value)
									<th>{{ $key }}</th>
								@endforeach	
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($postedrides as $postedride)
								<tr>
									@foreach ($postedride as $key => $value)
										<td>{{ $value }}</td>
									@endforeach
									<td>
										{!! Form::open(array('url' => '/rides/managed/'.$postedride->departdatetime.'/startRide','onsubmit' => "return confirm('Are you sure you want to start the ride?');")) !!}
	        								<button type="submit" class="btn rideshare-btn btn-xs">Start</button>
	    								{!! Form::close() !!}
	    								{!! Form::open(array('url' => '/rides/managed/'.$postedride->departdatetime.'/cancelRide','onsubmit' => "return confirm('Are you sure you want to cancel the ride?');")) !!}
	        								<button type="submit" class="btn rideshare-btn btn-xs">Cancel</button>
	    								{!! Form::close() !!}
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				@endif
			</div>
	    </div>
	    <div role="tabpanel" class="tab-pane" id="history">
	    	<div class="row">
				<div class="col-lg-12">
					<h1 class="page-title">
						<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
						<span>History</span>
					</h1>
				</div>
				@if (count($ridehistories))
					<table class="table table-bordered">
						<thead>
							<tr>
								@foreach ($ridehistories[0] as $key => $value)
									<th>{{ $key }}</th>
								@endforeach
							</tr>
						</thead>
						<tbody>
							@foreach ($ridehistories as $ridehistory)
								<tr>
									@foreach ($ridehistory as $key => $value)
										<td>{{ $value }}</td>
									@endforeach
								</tr>
							@endforeach
						</tbody>
					</table>
				@endif
			</div>
	    </div>
	  </div>

	</div>
@stop