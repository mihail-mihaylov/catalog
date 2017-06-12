@if (session('status'))
	<div class="alert alert-success m-md">
		{{ session('status') }}
	</div>
@endif

@if (count($errors) > 0)
	<div class="alert alert-danger m-lg">
		{{--<strong>Whoops!</strong> There were some problems with your input.<br><br>--}}
		<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif
