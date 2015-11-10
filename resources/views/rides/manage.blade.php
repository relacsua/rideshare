@extends('home')

@section('style')
	<style type="text/css">
		.nav-pills>li>a {
			background-color: transparent !important;
		    color: #db9e36 !important;
		    font-weight: bold;
		    text-transform: uppercase;
		    border-radius: 0;
		    opacity: 0.5;
		}
		.nav-pills>li.active>a, 	
		.nav-pills>li.active>a:hover {
			border-bottom: 2px solid #db9e36;
			opacity: 1;
		}
		.start-loca,
		.end-loca,
		.status {
			display: inline-block;
		}
		.end-loca,
		.status {
			padding-left: 10px;
		}
		.start-loca .glyphicon{
			color: #105B63;
		}
		.end-loca .glyphicon {
    		color: #BD4932;
		}
		.location-name,
		.end-loca .glyphicon,
		.start-loca .glyphicon {
			line-height: 20px;
		}
		.status {
			text-transform: uppercase;
		}
		.location-name {
			font-weight: 600;
		}
		.ride-item {
			padding-bottom: 20px;
    		border-bottom: 1px solid goldenrod;
    		margin: 20px 0;
		}
		.ride-top {
			margin-bottom: 20px;
		}
		.ride-time {
			display: block;
			text-align: right;
			font-weight: 600;
		}
		.passenger-item {
			margin: 10px 0px;
		}
		.passenger-avatar-container .profile-img-container {
			width: 40px;
    		height: 40px;
		}
		.passenger-avatar-container .profile-img {
			width: 40px;
		}
		.passenger-name {
			line-height: 40px;
    		font-weight: 400;
		}
		.passenger-email-container {
			text-align: right;
		}
		.glyphicon-envelope {
			font-size: 16px;
    		line-height: 40px;
    		color: #333;
		}
		.ride-passenger {
			border-left: 3px solid #FFD34E;
    		margin-left: 20px;
		}
		.ride-buttons {
			margin-left: 30px;
    		margin-right: 30px;
    		margin-top: 20px;
		}
		.ride-buttons form {
			text-align: center;
			margin-top: 5px;
		}
		.start-btn, .end-btn {
			width: 100%;
		}
		.cancel-btn {
			border: none;
    		background-color: transparent;
    		text-decoration: underline;
    		color: #962D3E;
		}
		.no-passenger-warning {
			line-height: 50px;
		    padding-left: 25px;
		    color: #611427;
		    font-weight: 600;
		}
		.section {
			margin-bottom: 50px;
		}
		.status-completed,
		.status-cancelled,
		.status-expired {
			font-weight: 600;
		}
		.status-completed span{
			color: #85DB18;
		}
		.status-cancelled span{
			color: #611427;
		}
		.status-expired span{
			color: #424242;
		}
	</style>
@stop

@section('content')
	<div class="row">
		<div class="col-md-12">
			<!-- Nav tabs -->
			<ul class="nav nav-pills" role="tablist">
				<li role="presentation" class="active">
					<a href="#postedrides" aria-controls="postedrides" role="tab" data-toggle="tab">Posted Rides</a>
				</li>
				<li role="presentation">
					<a href="#history" aria-controls="history" role="tab" data-toggle="tab">History</a>
				</li>
			</ul>

			  <!-- Tab panes -->
			 <div class="tab-content">
			    <div role="tabpanel" class="tab-pane active" id="postedrides">
			    	<div class="row">
						@if (count($inprogressrides))
							<div class="section clearfix">
								<div class="col-lg-12">
									<h1 class="page-title">
										<span class="glyphicon glyphicon-pushpin" aria-hidden="true"></span>
										<span>In-Progress</span>
									</h1>
								</div>
								@if (count($inprogressrides))
									<div class="col-md-12">
										@foreach ($inprogressrides as $inprogressride)
											<div class="ride-item">
												<div class="row ride-top">
													<div class="col-md-8">
														<div class="start-loca">
															<span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
															<span class="location-name">{{$inprogressride->departlocation}}</span>
														</div>
														<div class="end-loca">
															<span class="glyphicon glyphicon-flag" aria-hidden="true"></span>
															<span class="location-name">{{$inprogressride->destination}}</span>
														</div>
													</div>
													<div class="col-md-4">
														<span class="ride-time">{{$inprogressride->departdatetime}}</span>
													</div>
												</div>
												<div class="row ride-passenger">
													@if (count($inprogressride->passengers))
														@foreach($inprogressride->passengers as $passenger)
															<div class="col-md-12 passenger-item">
																<div class="col-md-1 passenger-avatar-container">
																	<div class="profile-img-container">
																		<img class="profile-img" src="{{$passenger->avatar}}" />
																	</div>
																</div>
																<div class="col-md-4">
																	<span class="passenger-name">{{$passenger->name}}</span>
																</div>
																<div class="col-md-4 col-md-offset-3 passenger-email-container">
																	<a href="mailto:{{$passenger->passengeremail}}">
																		<span class="glyphicon glyphicon-envelope" aria-hidden="true">
																	</a>
																</div>
															</div>
														@endforeach
													@else
														<p class="no-passenger-warning">No passengers have signed up for this ride!</p>
													@endif
												</div>
												<div class="row ride-buttons">
													<div class="col-md-12">
														{!! Form::open(array('url' => '/rides/managed/'.$inprogressride->departdatetime.'/endRide','onsubmit' => "return confirm('Are you sure you want to end the ride?');")) !!}
				        								<button type="submit" class="btn rideshare-btn end-btn">End</button>
				    									{!! Form::close() !!}
													</div>
												</div>
											</div>
										@endforeach
									</div>
								@endif
							</div>
						@endif
						<div class="section clearfix">
							<div class="col-md-12">
								<h1 class="page-title">
									<span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span>
									<span>Registered rides</span>
								</h1>
							</div>
							@if (count($postedrides))
								<div class="col-md-12">
									@foreach ($postedrides as $postedride)
										<div class="ride-item">
											<div class="row ride-top">
												<div class="col-md-8">
													<div class="start-loca">
														<span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
														<span class="location-name">{{$postedride->departlocation}}</span>
													</div>
													<div class="end-loca">
														<span class="glyphicon glyphicon-flag" aria-hidden="true"></span>
														<span class="location-name">{{$postedride->destination}}</span>
													</div>
												</div>
												<div class="col-md-4">
													<span class="ride-time">{{$postedride->departdatetime}}</span>
												</div>
											</div>
											<div class="row ride-passenger">
												@if (count($postedride->passengers))
													@foreach($postedride->passengers as $passenger)
														<div class="col-md-12 passenger-item">
															<div class="col-md-1 passenger-avatar-container">
																<div class="profile-img-container">
																	<img class="profile-img" src="{{$passenger->avatar}}" />
																</div>
															</div>
															<div class="col-md-4">
																<span class="passenger-name">{{$passenger->name}}</span>
															</div>
															<div class="col-md-4 col-md-offset-3 passenger-email-container">
																<a href="mailto:{{$passenger->passengeremail}}">
																	<span class="glyphicon glyphicon-envelope" aria-hidden="true">
																</a>
															</div>
														</div>
													@endforeach
												@else
													<p class="no-passenger-warning">No passengers have signed up for this ride!</p>
												@endif
											</div>
											<div class="row ride-buttons">
												<div class="col-md-12">
													{!! Form::open(array('url' => '/rides/managed/'.$postedride->departdatetime.'/startRide','onsubmit' => "return confirm('Are you sure you want to start the ride?');")) !!}
														<button type="submit" class="btn rideshare-btn start-btn">Start</button>
													{!! Form::close() !!}
													{!! Form::open(array('url' => '/rides/managed/'.$postedride->departdatetime.'/cancelRide','onsubmit' => "return confirm('Are you sure you want to cancel the ride?');")) !!}
														<button type="submit" class="cancel-btn">Cancel</button>
													{!! Form::close() !!}
												</div>
											</div>
										</div>
									@endforeach
								</div>
							@endif
				    	</div>
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
							<div class="col-md-12">
								@foreach ($ridehistories as $ridehistory)
									<div class="ride-item">
										<div class="row ride-top">
											<div class="col-md-8">
												<div class="start-loca">
													<span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
													<span class="location-name">{{$ridehistory->departlocation}}</span>
												</div>
												<div class="end-loca">
													<span class="glyphicon glyphicon-flag" aria-hidden="true"></span>
													<span class="location-name">{{$ridehistory->destination}}</span>
												</div>
												<div class="status">
													@if ($ridehistory->iscancelled == 'TRUE')
														<span class="status-cancelled">(<span>cancelled</span>)</span>
													@elseif ($ridehistory->isstarted == 'TRUE' && $ridehistory->isended == 'TRUE')
														<span class="status-completed">(<span>completed</span>)</span>
													@else
														<span class="status-expired">(<span>expired</span>)</span>
													@endif
												</div>
											</div>
											<div class="col-md-4">
												<span class="ride-time">{{$ridehistory->departdatetime}}</span>
											</div>
										</div>
										<div class="row ride-passenger">
											@if (count($ridehistory->passengers))
												@foreach($ridehistory->passengers as $passenger)
													<div class="col-md-12 passenger-item">
														<div class="col-md-1 passenger-avatar-container">
															<div class="profile-img-container">
																<img class="profile-img" src="{{$passenger->avatar}}" />
															</div>
														</div>
														<div class="col-md-4">
															<span class="passenger-name">{{$passenger->name}}</span>
														</div>
														<div class="col-md-4 col-md-offset-3 passenger-email-container">
															<a href="mailto:{{$passenger->passengeremail}}">
																<span class="glyphicon glyphicon-envelope" aria-hidden="true">
															</a>
														</div>
													</div>
												@endforeach
											@else
												<p class="no-passenger-warning">No passengers have signed up for this ride!</p>
											@endif
										</div>
									</div>
								@endforeach
							</div>
						@endif
					</div>
			    </div>
		  	</div>
		</div>
	</div>
@stop