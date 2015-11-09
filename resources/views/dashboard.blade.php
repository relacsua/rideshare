@extends('home')

@section('style')
	<style type="text/css">
		.action-btn, .action-btn:hover {
			background-color: #105b63;
		    border: 0;
		    border-radius: 0;
		    color: #ffffff;
		    width: 100%;
		    padding: 20px;
		}
		.action-btn .glyphicon {
			font-size: 40px;
		}
	</style>
@stop

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-title">
				<span class="glyphicon glyphicon-blackboard" aria-hidden="true"></span>
				<span>Dashboard</span>
			</h1>
		</div>
		<div class="row">
			<div class="col-md-4 col-md-offset-2">
				<a class="btn action-btn" href="/rides/new">
					<span class="glyphicon glyphicon-road" aria-hidden="true"></span>
					<h3>Post a ride</h3>
				</a>
			</div>
			<div class="col-md-4">
				<a class="btn action-btn" href="/rides/search">
					<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
					<h3>Join a ride</h3>
				</a>
			</div>
		</div>
	</div>
@stop