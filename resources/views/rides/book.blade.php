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
		.result-image {
	      	width: 100%;
	    }
	    .result-upper,
	    .result-lower {
	      	overflow: hidden;
	    }
	    .result-upper {
	      	height: 150px;
	    }
	    .result-lower {
	      	height: 70px;
	      	padding: 20px 0;
	    }
	    .result-driver-name,
	    .result-driver-details {
	      	text-transform: uppercase;
	      	font-weight: bold
	    }
	    .result-driver-name {
	      	color: #db9e36;
	      	margin-top: 40px;
	    }
	    .result-item {
	      	padding: 10px;
	      	background: #ffd34e;
	      	margin: 20px 0;
	    }
	    .result-item:hover {
	      	-webkit-box-shadow: 0px 0px 5px 5px rgb(202, 191, 159);
	      	-moz-box-shadow: 0px 0px 5px 5px rgb(202, 191, 159);
	      	box-shadow: 0px 0px 5px 5px rgb(202, 191, 159);
	    }
	    .result-ride-price {
	      	margin-top: 40px;
	    }
	    .result-ride-price sup {
	      	font-size: 50%;
	      	vertical-align: super;
	    }
	    .result-ride-price-desc {
	      	text-transform: uppercase;
	      	font-size: 12px;
	      	font-weight: bold;
	    }
	    .result-ride-start-end p,
	    .result-ride-time p {
	      	font-weight: bold;
	      	margin-top: 10px;
	    }
	    .result-car-model,
	    .result-ride-passenger p,
	    .result-ride-start-end p,
	    .result-ride-time p
	    .result-ride-time p {
	      	text-align: center;
	    }
	    .result-ride-time p {
	      	font-size: 12px;
	    }
	    .result-ride-passenger p:first-child {
	      	font-weight: bold;
	    }
	    .result-ride-passenger p:last-child {
	      	text-transform: uppercase;
	      	font-size: 12px;
	      	font-weight: 300;
	    }
	    .result-ride-passenger p {
			margin: 0;
	    }
	    .result-ride-start-btn-holder form button,
	    .result-ride-start-btn-holder span {
	      	width: 100%;
	      	text-transform: uppercase;
	    }
	    .divider {
	      	border-right: 1px solid goldenrod;
	    }
	    .form-inline {
	      	text-align: center;
	    }
	    .btn.btn-danger {
	    	border-radius: 0;
	    }
	    .status-progress
	    .status-completed,
		.status-cancelled,
		.status-expired {
			font-weight: 600;
		}
		.status-completed span{
			color: #85DB18;
			padding: 4px;
    		border: 2px solid #85DB18;
    		font-weight: 600;
			display: block;
			text-align: center;
		}
		@keyframes pulse {
			0% {
				transform: scale(1);
			}

			50% {
				transform: scale(1.1);
			}

			100% {
				transform: scale(1);
			}
		}
		.status-progress span {
			color: #ff3296;
			padding: 4px;
    		border: 2px solid #ff3296;	
    		-webkit-animation: pulse 1s ease infinite;
		    -moz-animation: pulse 1s ease infinite;
		    -ms-animation: pulse 1s ease infinite;
		    -o-animation: pulse 1s ease infinite;
		    animation: pulse 1s ease infinite;
			display: block;
			text-align: center;
		}
		.status-cancelled span{
			color: #611427;
			padding: 4px;
    		border: 2px solid #611427;
    		display: block;
			text-align: center;
		}
		.status-expired span{
			color: #424242;
			padding: 4px;
			border: 2px solid #424242;
			display: block;
			text-align: center;
		}
	    @media(max-width:991px) {
	      	.result-upper,
	      	.result-lower {
		        height: auto;
		      }
			.result-image {
			 	max-width: 200px;
	    		margin: auto;
	      	}
	    }
	</style>
@stop

@section('content')
	<div class="row">
		<div class="col-md-12">
			<!-- Nav tabs -->
			<ul class="nav nav-pills" role="tablist">
				<li role="presentation" class="active">
					<a href="#bookedrides" aria-controls="postedrides" role="tab" data-toggle="tab">Booked Rides</a>
				</li>
				<li role="presentation">
					<a href="#history" aria-controls="history" role="tab" data-toggle="tab">History</a>
				</li>
			</ul>

			  <!-- Tab panes -->
			 <div class="tab-content">
			    <div role="tabpanel" class="tab-pane active" id="bookedrides">
			    	<div class="row">
						@foreach ($progress as $ride)
				          	<div class="result-item">
				            	<div class="row result-upper">
					              	<div class="col-md-2">
					                	<img class="result-image" src="{{$ride->avatar}}" >
					              	</div>

				              		<div class="col-md-2">
				                		<p class="result-driver-name">{{$ride->name}}</p>
				                		<p class="result-driver-details">{{$ride->age}} yrs | {{$ride->gender}}</p>
				              		</div>
				              		<div class="col-md-offset-6 col-md-2">
				                		<h3 class="result-ride-price">${{$ride->priceperseat}}.<sup>00</sup></h3>
				                		<span class="result-ride-price-desc">paid in credits</span>
				              		</div>
				            	</div>
				            	<div class="row result-lower">
				              		<div class="col-md-2 result-car-model divider">
				                		<h4>{{$ride->carmodel}}</h4>
				              		</div>
				              		<div class="col-md-2 result-ride-start-end divider">
				                		<p>{{$ride->departlocation}} to {{$ride->destination}}</p>
				              		</div>
				              		<div class="col-md-2 result-ride-time divider">
				                		<p>{{$ride->departdatetime}}</p>
				              		</div>
				              		<div class="col-md-2">
				              		</div>
						            <div class="col-md-3 result-ride-start-btn-holder">
						            	<span class="status-progress"><span>progress</span></span>
									</div>
								</div>
				          </div>
				        @endforeach
				        @foreach ($booked as $ride)
				          	<div class="result-item">
				            	<div class="row result-upper">
					              	<div class="col-md-2">
					                	<img class="result-image" src="{{$ride->avatar}}" >
					              	</div>

				              		<div class="col-md-2">
				                		<p class="result-driver-name">{{$ride->name}}</p>
				                		<p class="result-driver-details">{{$ride->age}} yrs | {{$ride->gender}}</p>
				              		</div>
				              		<div class="col-md-offset-6 col-md-2">
				                		<h3 class="result-ride-price">${{$ride->priceperseat}}.<sup>00</sup></h3>
				                		<span class="result-ride-price-desc">per passenger</span>
				              		</div>
				            	</div>
				            	<div class="row result-lower">
				              		<div class="col-md-2 result-car-model divider">
				                		<h4>{{$ride->carmodel}}</h4>
				              		</div>
				              		<div class="col-md-2 result-ride-start-end divider">
				                		<p>{{$ride->departlocation}} to {{$ride->destination}}</p>
				              		</div>
				              		<div class="col-md-2 result-ride-time divider">
				                		<p>{{$ride->departdatetime}}</p>
				              		</div>
				              		<div class="col-md-2">
				              		</div>
						            <div class="col-md-3 result-ride-start-btn-holder">
						            	{!! Form::open(array('url' => '/rides/passenger/'.$email.'/driver/'.$ride->email.'/datetime/'.$ride->departdatetime, 'method' => 'delete', 'onsubmit' => "return confirm('Are you sure you want to withdaw from this ride?');")) !!}
											<button type="submit" class="btn btn-danger">withdraw ride</button>
										{!! Form::close() !!}
									</div>
								</div>
				          </div>
				        @endforeach
			    	</div>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="history">
			    	<div class="row">
						@foreach ($history as $ride)
				          	<div class="result-item">
				            	<div class="row result-upper">
					              	<div class="col-md-2">
					                	<img class="result-image" src="{{$ride->avatar}}" >
					              	</div>

				              		<div class="col-md-2">
				                		<p class="result-driver-name">{{$ride->name}}</p>
				                		<p class="result-driver-details">{{$ride->age}} yrs | {{$ride->gender}}</p>
				              		</div>
				              		<div class="col-md-offset-6 col-md-2">
				                		<h3 class="result-ride-price">${{$ride->priceperseat}}.<sup>00</sup></h3>
				                		<span class="result-ride-price-desc">paid in credits</span>
				              		</div>
				            	</div>
				            	<div class="row result-lower">
				              		<div class="col-md-2 result-car-model divider">
				                		<h4>{{$ride->carmodel}}</h4>
				              		</div>
				              		<div class="col-md-2 result-ride-start-end divider">
				                		<p>{{$ride->departlocation}} to {{$ride->destination}}</p>
				              		</div>
				              		<div class="col-md-2 result-ride-time divider">
				                		<p>{{$ride->departdatetime}}</p>
				              		</div>
				              		<div class="col-md-2">
				              		</div>
						            <div class="col-md-3 result-ride-start-btn-holder">
						            	@if ($ride->iscancelled == 'TRUE')
						            		<span class="status-cancelled"><span>cancelled</span></span>
						            	@elseif ($ride->isstarted == 'TRUE' && $ride->isended == 'TRUE')
						            		<span class="status-completed"><span>completed</span></span>
						            	@else
						            		<span class="status-expired"><span>expired</span></span>
						            	@endif
									</div>
								</div>
				          </div>
				        @endforeach
			    	</div>
			    </div>
			</div>
		</div>
	</div>
@stop