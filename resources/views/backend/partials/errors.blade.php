@foreach($errors->all() as $error)
    <div class="btn btn-danger">
	    {{ $error }}
    </div>
@endforeach