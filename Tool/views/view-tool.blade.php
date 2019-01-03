@extends('layouts.app')

@section('content')
	@include('layouts.banner')

	<div class="container mt-64 mb-64 mt-32-mobile mb-32-mobile">
		<div class="row mb-32">
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<img src="{{ $tool->featured_image_url }}" class="regular-image">
			</div>
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-32-mobile">
				<h3>{{ $tool->title }}</h3>
				<h5>Price: ${{ $tool->amount }}</h5>
				<hr />
				<div id="tool_description">
					{!! $tool->description !!}
				</div>
				@if($tool->amount > 0)
					<a href="/register/checkout/tools/{{ $tool->id }}?redirect_url=%2Fmembers%2Ftools%2F{{ $tool->id }}%2Fdashboard" class="btn btn-success">Purchase Tool</a>
				@else
					<a href="/tools/enroll/{{ $tool->id }}?redirect_url=%2Fmembers%2Ftools%2F{{ $tool->id }}%2Fdashboard" class="btn btn-success">Get Tool</a>
				@endif
			</div>
		</div>
	</div>
@endsection