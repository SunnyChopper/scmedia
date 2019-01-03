@extends('layouts.app')

@section('content')
	@include('layouts.banner')

	<div class="container mt-64 mb-64">
		<div class="row">
			<div class="col-lg-10 offset-lg-1 col-md-10 offset-md-1 col-sm-12 col-xs-12">
				<div class="gray-box">
					<form action="/admin/tools/create" method="post" id="new_tool_form">
						{{ csrf_field() }}
						<div class="form-group mb-64">
							<h5>Title:</h5>
							<p class="mb-2">This will be the title of the post that will show up on the public page.</p>
							<input type="text" name="title" class="form-control" required>
						</div>

						<div class="form-group mb-64">
							<h5>Slug:</h5>
							<p class="mb-2">This is the part that will go into the URL, so make it SEO friendly.</p>
							<input type="text" name="slug" class="form-control" required>
						</div>

						<div class="form-group mb-64">
							<h5>Description:</h5>
							<p class="mb-2">This is the description of the tool. Here's a nice little editor to make things easy.</p>
							<textarea id="tool_textarea" name="description" class="form-control" rows="15" form="new_tool_form"></textarea>
						</div>

						<div class="form-group mb-64">
							<h5>Amount:</h5>
							<p class="mb-2">This is how much the tool will cost.</p>
							<input type="number" name="amount" min="0.00" step="0.01" class="form-control" required>
						</div>

						<div class="form-group mb-64">
							<h5>Featured Image URL:</h5>
							<p class="mb-2">This is the image that will be used as the cover photo for this post.</p>
							<input type="text" name="featured_image_url" class="form-control" required>
						</div>

						<div class="form-group mb-64">
							<h5>Plan ID:</h5>
							<p class="mb-2">This is the ID of the tool on Stripe. Leave this empty if it will be a one-time charge.</p>
							<input type="text" name="plan_id" class="form-control">
						</div>

						<div class="form-group">
							<input type="submit" value="Create Tool" class="btn btn-success">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('page_js')
	<script src='https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=xq9hzw57g3zkmakqchurmgo9hnprenmg1yopn8cirghphy2x'></script>
	<script type="text/javascript">
		tinymce.init({
			selector: '#tool_textarea',
			plugins: "code"
		});
	</script>
@endsection