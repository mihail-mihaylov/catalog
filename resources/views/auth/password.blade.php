<div class="container-fluid">
	<div class="row">
		@if (session('status'))
			<div class="alert alert-success">
				{{ session('status') }}
			</div>
		@endif

		@if (count($errors) > 0)
			<div class="alert alert-danger">
				<strong>Whoops!</strong> There were some problems with your input.<br><br>
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		<form class="form-horizontal" role="form" method="POST" action=" {{ route('passwordEmailPost') }} ">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			<div class="form-group">
				<label class="col-md-2 control-label">{{ trans('general.email') }}</label>
				<div class="col-md-10">
					<input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-2 pull-right m-r">
					<button type="submit" class="btn btn-primary">{{ trans('users.send') }}</button>
				</div>
			</div>
		</form>

	</div>
</div>