@extends('layouts.app')

@section('content')
	@include('layouts.banner')
	@include('admin.tools.modals.delete')

	<div class="container mt-64 mb-64">
		<div class="row">
			@if(count($tools) > 0)
			
			<div class="col-lg-12 col-md-12 col-sm-12 col-12">
				<a href="/admin/tools/new" class="site-btn mb-16">Create New Tool</a>
				<div style="overflow: auto;">
					<table class="table table-striped">
						<thead>
							<tr style="text-align: center;">
								<th>Title</th>
								<th>Slug</th>
								<th>Featured Image</th>
								<th>Amount</th>
								<th>Created</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach($tools as $tool)
								<tr style="text-align: center;">
									<td style="vertical-align: middle;">{{ $tool->title }}</td>
									<td style="vertical-align: middle;">{{ $tool->slug }}</td>
									<td style="max-width: 200px; vertical-align: middle;"><img src="{{ $tool->featured_image_url }}" class="regular-image"></td>
									<td style="vertical-align: middle;">${{ $tool->amount }}</td>
									<td style="vertical-align: middle;">{{ $post->created_at->format('M jS, Y') }}</td>
									<td style="vertical-align: middle;">
										<a href="/admin/tools/edit/{{ $tool->id }}" class="btn btn-info rounded small">Edit</a>
										<button id="{{ $tool->id}}" class="btn delete_tools_button btn-danger rounded small">Delete</button>
									</td>
								</tr>
							@endforeach	
						</tbody>
					</table>
				</div>


			</div>
			@else
				<div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-sm-12 col-12">
					<div class="gray-box">
						<h3 class="text-center">No Tools</h3>
						<p class="text-center">Click on the button below to get started on your first tool.</p>
						<div class="row">
							<div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-12 col-12">
								<a href="/admin/tools/new" class="site-btn-small center-button">New Tool</a>
							</div>
						</div>
					</div>
				</div>
			@endif
		</div>
	</div>
@endsection

@section('page_js')
	<script type="text/javascript">
		$(".delete_tools_button").on('click', function() {
			// Get tool ID
			var tool_id = $(this).attr('id');

			// Set in modal
			$("#delete_tool_id").val(tool_id);

			// Show modal
			$("#delete_tool_modal").modal();
		});
	</script>
@endsection