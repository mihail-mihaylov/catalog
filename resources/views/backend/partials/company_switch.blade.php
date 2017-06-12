<select name="company" id="">
	@foreach($companies as $company)
		@if(auth()->user()->administrates($company) || auth()->user()->owns($company))
		@if($company === Session::get('managed_company'))
			<option value="{{ $company->id }}" selected>{{ $company->identification_number }}</option>
		@else
			<option value="{{ $company->id }}">{{ $company->identification_number }}</option>

		@endif	
		@endif
	@endforeach
</select>
