@extends('home')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-title">
				<span class="glyphicon glyphicon-blackboard" aria-hidden="true"></span>
				<span>Dashboard</span>
			</h1>
		</div>
		<a class="btn rideshare-btn" href="/rides/new">Post a ride</a>
		<a class="btn rideshare-btn" href="/rides/search">Join a ride</a>
		<p>We can place charts and graphs to show some <b>DATA ANALYSIS</b>. How awesome is that ??</p>
	</div>
@stop